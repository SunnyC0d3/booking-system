<?php

namespace App\Http\Middleware;

use App\Models\Enquiry;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ValidateEnquiryToken
{
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->route('token') ?? $request->input('action_token');

        if (!$token) {
            Log::warning('Missing enquiry token', [
                'ip' => $request->ip(),
                'route' => $request->route()?->getName()
            ]);

            return response()->json(['error' => 'Missing action token'], Response::HTTP_BAD_REQUEST);
        }

        $enquiry = Enquiry::where('enquiry_token', $token)->first();

        if (!$enquiry) {
            Log::warning('Invalid enquiry token', [
                'token' => substr($token, 0, 8) . '...',
                'ip' => $request->ip()
            ]);

            return response()->json(['error' => 'Invalid or expired action token'], Response::HTTP_NOT_FOUND);
        }

        if ($enquiry->isExpired()) {
            Log::warning('Expired enquiry token used', [
                'enquiry_id' => $enquiry->id,
                'expires_at' => $enquiry->expires_at,
                'ip' => $request->ip()
            ]);

            return response()->json([
                'error' => 'This enquiry has expired and can no longer be processed'
            ], Response::HTTP_GONE);
        }

        $request->merge(['enquiry' => $enquiry]);

        return $next($request);
    }
}
