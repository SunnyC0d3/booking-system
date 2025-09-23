<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ValidateMicrosoftWebhook
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->has('validationToken')) {
            return $next($request);
        }

        $clientState = $request->header('ClientState');
        $expectedClientState = config('microsoft.webhook_secret');

        if (!$clientState || $clientState !== $expectedClientState) {
            Log::warning('Invalid webhook client state', [
                'received_state' => $clientState,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json(['error' => 'Invalid client state'], Response::HTTP_UNAUTHORIZED);
        }

        if (!$request->isJson()) {
            Log::warning('Invalid webhook content type', [
                'content_type' => $request->header('Content-Type'),
                'ip' => $request->ip()
            ]);

            return response()->json(['error' => 'Invalid content type'], Response::HTTP_BAD_REQUEST);
        }

        Log::info('Valid Microsoft webhook received', [
            'ip' => $request->ip(),
            'content_length' => $request->header('Content-Length')
        ]);

        return $next($request);
    }
}
