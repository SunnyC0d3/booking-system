<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Microsoft365Service;
use App\Models\MicrosoftToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class CalendarAuthController extends Controller
{
    protected Microsoft365Service $microsoftService;

    public function __construct(Microsoft365Service $microsoftService)
    {
        $this->microsoftService = $microsoftService;
    }

    /**
     * Get Microsoft OAuth authorization URL.
     *
     * Generates the authorization URL that the business owner needs to visit
     * to grant calendar permissions to the application.
     *
     * @group Calendar Authentication
     * @authenticated
     *
     * @queryParam user_identifier string User identifier (usually business owner email). Example: owner@business.com
     * @queryParam redirect_uri string Optional custom redirect URI. Example: https://yourapp.com/auth/callback
     */
    public function getAuthUrl(Request $request): JsonResponse
    {
        try {
            $userIdentifier = $request->get('user_identifier', config('enquiry.owner_email'));
            $redirectUri = $request->get('redirect_uri', config('microsoft.redirect_uri'));

            $state = Str::random(32);

            cache()->put("oauth_state:{$state}", [
                'user_identifier' => $userIdentifier,
                'redirect_uri' => $redirectUri,
                'created_at' => now()
            ], now()->addMinutes(10));

            $authUrl = $this->microsoftService->getAuthorizationUrl($state, $redirectUri);

            Log::info('OAuth authorization URL generated', [
                'user_identifier' => $userIdentifier,
                'state' => $state
            ]);

            return response()->json([
                'auth_url' => $authUrl,
                'state' => $state,
                'expires_in' => 600,
                'instructions' => 'Visit the auth_url to grant calendar permissions, then return to handle the callback.'
            ]);

        } catch (Exception $e) {
            Log::error('Failed to generate OAuth URL', [
                'error' => $e->getMessage(),
                'user_identifier' => $request->get('user_identifier')
            ]);

            return response()->json([
                'error' => 'Failed to generate authorization URL',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle OAuth callback from Microsoft.
     *
     * This endpoint processes the OAuth callback from Microsoft and exchanges
     * the authorization code for access tokens.
     *
     * @group Calendar Authentication
     *
     * @queryParam code string required Authorization code from Microsoft. Example: M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab
     * @queryParam state string required State parameter to prevent CSRF attacks. Example: abc123def456
     * @queryParam error string Error code if authorization failed. Example: access_denied
     * @queryParam error_description string Error description if authorization failed.
     */
    public function handleCallback(Request $request): JsonResponse|RedirectResponse
    {
        try {
            if ($request->has('error')) {
                Log::warning('OAuth authorization denied', [
                    'error' => $request->get('error'),
                    'description' => $request->get('error_description')
                ]);

                return response()->json([
                    'error' => 'Authorization denied',
                    'details' => $request->get('error_description', $request->get('error'))
                ], Response::HTTP_BAD_REQUEST);
            }

            $request->validate([
                'code' => 'required|string',
                'state' => 'required|string'
            ]);

            $code = $request->get('code');
            $state = $request->get('state');

            $stateData = cache()->get("oauth_state:{$state}");

            if (!$stateData) {
                Log::warning('Invalid or expired OAuth state', ['state' => $state]);

                return response()->json([
                    'error' => 'Invalid or expired authorization request'
                ], Response::HTTP_BAD_REQUEST);
            }

            cache()->forget("oauth_state:{$state}");

            $userIdentifier = $stateData['user_identifier'];
            $redirectUri = $stateData['redirect_uri'];

            Log::info('Processing OAuth callback', [
                'user_identifier' => $userIdentifier,
                'code_length' => strlen($code)
            ]);

            $tokenData = $this->microsoftService->exchangeCodeForTokens($code, $redirectUri);
            $token = MicrosoftToken::createFromResponse($userIdentifier, $tokenData);

            if (!$token->hasRequiredScopes()) {
                Log::warning('Token missing required scopes', [
                    'user_identifier' => $userIdentifier,
                    'scopes' => $token->scope
                ]);

                return response()->json([
                    'error' => 'Insufficient permissions granted',
                    'required_scopes' => ['Calendars.ReadWrite', 'offline_access'],
                    'granted_scopes' => $token->scope
                ], Response::HTTP_BAD_REQUEST);
            }

            Log::info('OAuth authentication successful', [
                'user_identifier' => $userIdentifier,
                'token_id' => $token->id,
                'expires_at' => $token->expires_at
            ]);

            return response()->json([
                'message' => 'Calendar integration configured successfully',
                'user_identifier' => $userIdentifier,
                'expires_at' => $token->expires_at,
                'scopes' => $token->scope,
                'status' => 'connected'
            ]);

        } catch (Exception $e) {
            Log::error('OAuth callback processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Failed to process authorization',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get current authentication status.
     *
     * @group Calendar Authentication
     * @authenticated
     *
     * @queryParam user_identifier string User identifier to check. Example: owner@business.com
     */
    public function status(Request $request): JsonResponse
    {
        try {
            $userIdentifier = $request->get('user_identifier', config('enquiry.owner_email'));

            $token = MicrosoftToken::getValidTokenForUser($userIdentifier);

            if (!$token) {
                return response()->json([
                    'status' => 'disconnected',
                    'user_identifier' => $userIdentifier,
                    'message' => 'No valid authentication found'
                ]);
            }

            return response()->json([
                'status' => $token->status,
                'user_identifier' => $userIdentifier,
                'expires_at' => $token->expires_at,
                'expires_in_minutes' => $token->expires_in_minutes,
                'scopes' => $token->scope,
                'last_refreshed' => $token->last_refreshed_at,
                'needs_refresh' => $token->needsRefresh()
            ]);

        } catch (Exception $e) {
            Log::error('Failed to get auth status', [
                'error' => $e->getMessage(),
                'user_identifier' => $request->get('user_identifier')
            ]);

            return response()->json([
                'error' => 'Failed to get authentication status',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Refresh access token.
     *
     * @group Calendar Authentication
     * @authenticated
     *
     * @queryParam user_identifier string User identifier to refresh token for. Example: owner@business.com
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $userIdentifier = $request->get('user_identifier', config('enquiry.owner_email'));

            $token = MicrosoftToken::getValidTokenForUser($userIdentifier);

            if (!$token) {
                return response()->json([
                    'error' => 'No authentication found',
                    'message' => 'Please re-authenticate with Microsoft'
                ], Response::HTTP_NOT_FOUND);
            }

            $refreshedTokenData = $this->microsoftService->refreshToken($token->refresh_token);
            $token->updateTokenData($refreshedTokenData);

            Log::info('Token refreshed successfully', [
                'user_identifier' => $userIdentifier,
                'token_id' => $token->id
            ]);

            return response()->json([
                'message' => 'Token refreshed successfully',
                'expires_at' => $token->expires_at,
                'expires_in_minutes' => $token->expires_in_minutes
            ]);

        } catch (Exception $e) {
            Log::error('Token refresh failed', [
                'error' => $e->getMessage(),
                'user_identifier' => $request->get('user_identifier')
            ]);

            return response()->json([
                'error' => 'Failed to refresh token',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Disconnect calendar integration.
     *
     * @group Calendar Authentication
     * @authenticated
     *
     * @queryParam user_identifier string User identifier to disconnect. Example: owner@business.com
     */
    public function disconnect(Request $request): JsonResponse
    {
        try {
            $userIdentifier = $request->get('user_identifier', config('enquiry.owner_email'));

            $token = MicrosoftToken::forUser($userIdentifier)->first();

            if ($token) {
                $token->deactivate();

                Log::info('Calendar integration disconnected', [
                    'user_identifier' => $userIdentifier,
                    'token_id' => $token->id
                ]);
            }

            return response()->json([
                'message' => 'Calendar integration disconnected successfully',
                'user_identifier' => $userIdentifier
            ]);

        } catch (Exception $e) {
            Log::error('Failed to disconnect calendar integration', [
                'error' => $e->getMessage(),
                'user_identifier' => $request->get('user_identifier')
            ]);

            return response()->json([
                'error' => 'Failed to disconnect integration',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Test calendar connection.
     *
     * @group Calendar Authentication
     * @authenticated
     *
     * @queryParam user_identifier string User identifier to test. Example: owner@business.com
     */
    public function test(Request $request): JsonResponse
    {
        try {
            $userIdentifier = $request->get('user_identifier', config('enquiry.owner_email'));

            $calendars = $this->microsoftService->getUserCalendars($userIdentifier);

            return response()->json([
                'message' => 'Calendar connection successful',
                'calendar_count' => count($calendars),
                'calendars' => $calendars
            ]);

        } catch (Exception $e) {
            Log::error('Calendar connection test failed', [
                'error' => $e->getMessage(),
                'user_identifier' => $request->get('user_identifier')
            ]);

            return response()->json([
                'error' => 'Calendar connection test failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
