<?php

namespace App\Services;

use App\Models\MicrosoftToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class Microsoft365Service
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $tenantId;
    protected string $redirectUri;
    protected array $scopes;

    public function __construct()
    {
        $this->clientId = config('microsoft.client_id');
        $this->clientSecret = config('microsoft.client_secret');
        $this->tenantId = config('microsoft.tenant_id', 'common');
        $this->redirectUri = config('microsoft.redirect_uri');
        $this->scopes = config('microsoft.scopes', [
            'https://graph.microsoft.com/Calendars.ReadWrite',
            'https://graph.microsoft.com/offline_access'
        ]);
    }

    /**
     * Generate OAuth authorization URL.
     */
    public function getAuthorizationUrl(string $state, ?string $customRedirectUri = null): string
    {
        $redirectUri = $customRedirectUri ?? $this->redirectUri;

        $params = [
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'scope' => implode(' ', $this->scopes),
            'state' => $state,
            'response_mode' => 'query',
            'prompt' => 'consent'
        ];

        return 'https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/authorize?' . http_build_query($params);
    }

    /**
     * Exchange authorization code for tokens.
     */
    public function exchangeCodeForTokens(string $code, string $redirectUri): array
    {
        $response = Http::asForm()->post('https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
            'scope' => implode(' ', $this->scopes)
        ]);

        if (!$response->successful()) {
            Log::error('Failed to exchange code for tokens', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            throw new Exception('Failed to obtain access tokens: ' . $response->json()['error_description'] ?? 'Unknown error');
        }

        return $response->json();
    }

    /**
     * Refresh an access token using refresh token.
     */
    public function refreshToken(string $refreshToken): array
    {
        $response = Http::asForm()->post('https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
            'scope' => implode(' ', $this->scopes)
        ]);

        if (!$response->successful()) {
            Log::error('Failed to refresh token', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            throw new Exception('Failed to refresh access token: ' . $response->json()['error_description'] ?? 'Unknown error');
        }

        return $response->json();
    }

    /**
     * Get user's calendars.
     */
    public function getUserCalendars(string $userIdentifier): array
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->get('https://graph.microsoft.com/v1.0/me/calendars');

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to get user calendars');
        }

        return $response->json()['value'] ?? [];
    }

    /**
     * Create a calendar event.
     */
    public function createCalendarEvent(string $userIdentifier, array $eventData, ?string $calendarId = null): array
    {
        $token = $this->getValidToken($userIdentifier);
        $endpoint = $calendarId
            ? "https://graph.microsoft.com/v1.0/me/calendars/{$calendarId}/events"
            : 'https://graph.microsoft.com/v1.0/me/events';

        $response = Http::withToken($token->access_token)
            ->post($endpoint, $eventData);

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to create calendar event');
        }

        return $response->json();
    }

    /**
     * Update a calendar event.
     */
    public function updateCalendarEvent(string $userIdentifier, string $eventId, array $eventData): array
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->patch("https://graph.microsoft.com/v1.0/me/events/{$eventId}", $eventData);

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to update calendar event');
        }

        return $response->json();
    }

    /**
     * Delete a calendar event.
     */
    public function deleteCalendarEvent(string $userIdentifier, string $eventId): bool
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->delete("https://graph.microsoft.com/v1.0/me/events/{$eventId}");

        if (!$response->successful() && $response->status() !== 404) {
            $this->handleApiError($response, 'Failed to delete calendar event');
        }

        return $response->successful() || $response->status() === 404;
    }

    /**
     * Get a calendar event.
     */
    public function getCalendarEvent(string $userIdentifier, string $eventId): ?array
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->get("https://graph.microsoft.com/v1.0/me/events/{$eventId}");

        if ($response->status() === 404) {
            return null;
        }

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to get calendar event');
        }

        return $response->json();
    }

    /**
     * Create a webhook subscription.
     */
    public function createWebhookSubscription(string $userIdentifier, string $notificationUrl, string $resource = '/me/events'): array
    {
        $token = $this->getValidToken($userIdentifier);

        $subscriptionData = [
            'changeType' => 'created,updated,deleted',
            'notificationUrl' => $notificationUrl,
            'resource' => $resource,
            'expirationDateTime' => now()->addDays(3)->toISOString(),
            'clientState' => config('microsoft.webhook_secret')
        ];

        $response = Http::withToken($token->access_token)
            ->post('https://graph.microsoft.com/v1.0/subscriptions', $subscriptionData);

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to create webhook subscription');
        }

        return $response->json();
    }

    /**
     * Delete a webhook subscription.
     */
    public function deleteWebhookSubscription(string $userIdentifier, string $subscriptionId): bool
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->delete("https://graph.microsoft.com/v1.0/subscriptions/{$subscriptionId}");

        if (!$response->successful() && $response->status() !== 404) {
            $this->handleApiError($response, 'Failed to delete webhook subscription');
        }

        return $response->successful() || $response->status() === 404;
    }

    /**
     * Get all webhook subscriptions.
     */
    public function getWebhookSubscriptions(string $userIdentifier): array
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->get('https://graph.microsoft.com/v1.0/subscriptions');

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to get webhook subscriptions');
        }

        return $response->json()['value'] ?? [];
    }

    /**
     * Get user profile information.
     */
    public function getUserProfile(string $userIdentifier): array
    {
        $token = $this->getValidToken($userIdentifier);

        $response = Http::withToken($token->access_token)
            ->get('https://graph.microsoft.com/v1.0/me');

        if (!$response->successful()) {
            $this->handleApiError($response, 'Failed to get user profile');
        }

        return $response->json();
    }

    /**
     * Get valid token for user, refreshing if necessary.
     */
    protected function getValidToken(string $userIdentifier): MicrosoftToken
    {
        $token = MicrosoftToken::getValidTokenForUser($userIdentifier);

        if (!$token) {
            throw new Exception("No valid authentication found for user: {$userIdentifier}");
        }

        if ($token->needsRefresh()) {
            try {
                $refreshedTokenData = $this->refreshToken($token->refresh_token);
                $token->updateTokenData($refreshedTokenData);

                Log::info('Token automatically refreshed', [
                    'user_identifier' => $userIdentifier,
                    'token_id' => $token->id
                ]);
            } catch (Exception $e) {
                Log::error('Failed to refresh token automatically', [
                    'user_identifier' => $userIdentifier,
                    'error' => $e->getMessage()
                ]);

                throw new Exception("Authentication expired for user: {$userIdentifier}. Please re-authenticate.");
            }
        }

        return $token;
    }

    /**
     * Handle Microsoft Graph API errors.
     */
    protected function handleApiError($response, string $context): void
    {
        $error = $response->json();
        $errorCode = $error['error']['code'] ?? 'Unknown';
        $errorMessage = $error['error']['message'] ?? 'Unknown error';

        Log::error($context, [
            'status' => $response->status(),
            'error_code' => $errorCode,
            'error_message' => $errorMessage,
            'response' => $error
        ]);

        switch ($errorCode) {
            case 'InvalidAuthenticationToken':
            case 'TokenNotFound':
                throw new Exception('Authentication token is invalid or expired. Please re-authenticate.');

            case 'Forbidden':
                throw new Exception('Insufficient permissions to perform this action.');

            case 'TooManyRequests':
                throw new Exception('Rate limit exceeded. Please try again later.');

            case 'EventNotFound':
                throw new Exception('Calendar event not found.');

            default:
                throw new Exception("{$context}: {$errorMessage}");
        }
    }

    /**
     * Format event data for Microsoft Graph API.
     */
    public function formatEventData(array $eventData): array
    {
        $formatted = [
            'subject' => $eventData['subject'],
            'start' => [
                'dateTime' => $eventData['start_time'],
                'timeZone' => $eventData['timezone'] ?? config('app.timezone', 'UTC')
            ],
            'end' => [
                'dateTime' => $eventData['end_time'],
                'timeZone' => $eventData['timezone'] ?? config('app.timezone', 'UTC')
            ]
        ];

        if (isset($eventData['body'])) {
            $formatted['body'] = [
                'contentType' => 'HTML',
                'content' => $eventData['body']
            ];
        }

        if (isset($eventData['location'])) {
            $formatted['location'] = [
                'displayName' => $eventData['location']
            ];
        }

        if (isset($eventData['attendees']) && is_array($eventData['attendees'])) {
            $formatted['attendees'] = array_map(function ($attendee) {
                return [
                    'emailAddress' => [
                        'address' => $attendee['email'],
                        'name' => $attendee['name'] ?? $attendee['email']
                    ],
                    'type' => $attendee['type'] ?? 'required'
                ];
            }, $eventData['attendees']);
        }

        if (isset($eventData['reminder_minutes'])) {
            $formatted['isReminderOn'] = true;
            $formatted['reminderMinutesBeforeStart'] = $eventData['reminder_minutes'];
        }

        return $formatted;
    }
}
