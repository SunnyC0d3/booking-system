<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CalendarSyncLog;
use App\Services\WebhookHandlerService;
use App\Services\CalendarSyncService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class CalendarWebhookController extends Controller
{
    protected WebhookHandlerService $webhookHandler;
    protected CalendarSyncService $calendarSync;

    public function __construct(
        WebhookHandlerService $webhookHandler,
        CalendarSyncService $calendarSync
    ) {
        $this->webhookHandler = $webhookHandler;
        $this->calendarSync = $calendarSync;
    }

    /**
     * Handle Microsoft Calendar webhook notifications.
     *
     * This endpoint receives webhook notifications from Microsoft Graph API
     * when calendar events are created, updated, or deleted.
     *
     * @group Webhooks
     *
     * @header Authorization Bearer {webhook_secret}
     * @header Content-Type application/json
     */
    public function handle(Request $request): JsonResponse
    {
        try {
            Log::info('Microsoft webhook received', [
                'headers' => $request->headers->all(),
                'payload' => $request->all()
            ]);

            if ($request->has('validationToken')) {
                return $this->handleValidation($request);
            }

            if ($request->has('value')) {
                return $this->handleNotifications($request);
            }

            Log::warning('Invalid webhook payload received', [
                'payload' => $request->all()
            ]);

            return response()->json([
                'error' => 'Invalid webhook payload'
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            return response()->json([
                'status' => 'error_logged'
            ]);
        }
    }

    /**
     * Handle subscription validation from Microsoft.
     */
    protected function handleValidation(Request $request): JsonResponse
    {
        $validationToken = $request->input('validationToken');

        Log::info('Microsoft webhook validation received', [
            'token' => $validationToken
        ]);

        return response()->json($validationToken, 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Handle webhook notifications.
     */
    protected function handleNotifications(Request $request): JsonResponse
    {
        $notifications = $request->input('value', []);
        $processedCount = 0;
        $errors = [];

        foreach ($notifications as $notification) {
            try {
                $this->processNotification($notification);
                $processedCount++;
            } catch (Exception $e) {
                Log::error('Failed to process individual notification', [
                    'notification' => $notification,
                    'error' => $e->getMessage()
                ]);

                $errors[] = [
                    'notification_id' => $notification['id'] ?? 'unknown',
                    'error' => $e->getMessage()
                ];
            }
        }

        Log::info('Webhook notifications processed', [
            'total' => count($notifications),
            'processed' => $processedCount,
            'errors' => count($errors)
        ]);

        return response()->json([
            'processed' => $processedCount,
            'total' => count($notifications),
            'errors' => $errors
        ]);
    }

    /**
     * Process individual notification.
     */
    protected function processNotification(array $notification): void
    {
        $changeType = $notification['changeType'] ?? null;
        $resourceData = $notification['resourceData'] ?? [];
        $eventId = $resourceData['id'] ?? null;

        if (!$eventId) {
            Log::warning('Notification without event ID', ['notification' => $notification]);
            return;
        }

        Log::info('Processing calendar notification', [
            'change_type' => $changeType,
            'event_id' => $eventId,
            'resource_data' => $resourceData
        ]);

        switch ($changeType) {
            case 'created':
                $this->handleEventCreated($eventId, $notification);
                break;

            case 'updated':
                $this->handleEventUpdated($eventId, $notification);
                break;

            case 'deleted':
                $this->handleEventDeleted($eventId, $notification);
                break;

            default:
                Log::info('Unhandled notification type', [
                    'change_type' => $changeType,
                    'notification' => $notification
                ]);
        }
    }

    /**
     * Handle calendar event creation.
     */
    protected function handleEventCreated(string $eventId, array $notification): void
    {
        Log::info('Handling event created', ['event_id' => $eventId]);

        $this->webhookHandler->handleEventCreated($eventId, $notification);
    }

    /**
     * Handle calendar event updates.
     */
    protected function handleEventUpdated(string $eventId, array $notification): void
    {
        Log::info('Handling event updated', ['event_id' => $eventId]);

        $this->webhookHandler->handleEventUpdated($eventId, $notification);
    }

    /**
     * Handle calendar event deletion.
     */
    protected function handleEventDeleted(string $eventId, array $notification): void
    {
        Log::info('Handling event deleted', ['event_id' => $eventId]);

        $this->webhookHandler->handleEventDeleted($eventId, $notification);
    }

    /**
     * Get webhook subscription status.
     *
     * @group Webhooks
     * @authenticated
     */
    public function status(): JsonResponse
    {
        try {
            $subscriptions = $this->calendarSync->getActiveSubscriptions();

            return response()->json([
                'active_subscriptions' => count($subscriptions),
                'subscriptions' => $subscriptions,
                'webhook_url' => route('api.v1.webhooks.microsoft'),
                'last_notification' => $this->getLastNotificationTime()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to get webhook status',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create or refresh webhook subscription.
     *
     * @group Webhooks
     * @authenticated
     */
    public function subscribe(): JsonResponse
    {
        try {
            $subscription = $this->calendarSync->createWebhookSubscription();

            return response()->json([
                'message' => 'Webhook subscription created successfully',
                'subscription' => $subscription
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create webhook subscription',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove webhook subscription.
     *
     * @group Webhooks
     * @authenticated
     */
    public function unsubscribe(): JsonResponse
    {
        try {
            $this->calendarSync->deleteWebhookSubscriptions();

            return response()->json([
                'message' => 'Webhook subscriptions removed successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to remove webhook subscriptions',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Test webhook endpoint connectivity.
     *
     * @group Webhooks
     */
    public function test(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Webhook endpoint is accessible',
            'timestamp' => now()->toISOString(),
            'url' => $request->fullUrl()
        ]);
    }

    /**
     * Get the timestamp of the last received notification.
     */
    protected function getLastNotificationTime(): ?string
    {
        $latestSync = CalendarSyncLog::where('sync_direction', 'from_microsoft')
            ->latest()
            ->first();

        return $latestSync?->created_at?->toISOString();
    }
}
