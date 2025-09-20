<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnquiryActionRequest;
use App\Http\Resources\EnquiryResource;
use App\Models\Enquiry;
use App\Services\EnquiryService;
use App\Services\CalendarEventService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class EnquiryActionController extends Controller
{
    protected EnquiryService $enquiryService;
    protected CalendarEventService $calendarEventService;

    public function __construct(
        EnquiryService $enquiryService,
        CalendarEventService $calendarEventService
    ) {
        $this->enquiryService = $enquiryService;
        $this->calendarEventService = $calendarEventService;
    }

    /**
     * Approve an enquiry.
     *
     * Approves an enquiry and optionally creates a calendar event.
     * Can be called via API or through secure email action links.
     *
     * @group Enquiry Actions
     * @authenticated
     *
     * @urlParam enquiry integer required The ID of the enquiry. Example: 1
     * @bodyParam create_calendar_event boolean Whether to create a calendar event. Example: true
     * @bodyParam calendar_notes string Additional notes for the calendar event. Example: Confirmed booking for corporate event
     * @bodyParam action_token string Required when using email action links. Example: abc123def456
     */
    public function approve(EnquiryActionRequest $request, Enquiry $enquiry): JsonResponse
    {
        try {
            if (!$enquiry->canBeApproved()) {
                return response()->json([
                    'error' => 'Enquiry cannot be approved',
                    'message' => $this->getCannotApproveReason($enquiry)
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $approvedEnquiry = $this->enquiryService->approveEnquiry(
                $enquiry,
                'manual_approval',
                $request->get('calendar_notes')
            );

            $calendarEvent = null;

            if ($request->get('create_calendar_event', true)) {
                try {
                    $calendarEvent = $this->calendarEventService->createEventForEnquiry($approvedEnquiry);

                    Log::info('Calendar event created for approved enquiry', [
                        'enquiry_id' => $enquiry->id,
                        'event_id' => $calendarEvent['id'] ?? null
                    ]);
                } catch (Exception $e) {
                    Log::warning('Failed to create calendar event for approved enquiry', [
                        'enquiry_id' => $enquiry->id,
                        'error' => $e->getMessage()
                    ]);

                    $calendarEvent = ['error' => $e->getMessage()];
                }
            }

            Log::info('Enquiry approved', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'calendar_event_created' => !empty($calendarEvent) && !isset($calendarEvent['error'])
            ]);

            return response()->json([
                'message' => 'Enquiry approved successfully',
                'data' => new EnquiryResource($approvedEnquiry->load(['resource', 'statusHistory'])),
                'calendar_event' => $calendarEvent
            ]);

        } catch (Exception $e) {
            Log::error('Failed to approve enquiry', [
                'enquiry_id' => $enquiry->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to approve enquiry',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Decline an enquiry.
     *
     * Declines an enquiry and sends notification to the customer.
     * Can be called via API or through secure email action links.
     *
     * @group Enquiry Actions
     * @authenticated
     *
     * @urlParam enquiry integer required The ID of the enquiry. Example: 1
     * @bodyParam decline_reason string Reason for declining the enquiry. Example: Resource not available on requested date
     * @bodyParam custom_message string Custom message to include in decline email. Example: Thank you for your interest. Unfortunately, we are fully booked on your preferred date.
     * @bodyParam action_token string Required when using email action links. Example: abc123def456
     */
    public function decline(EnquiryActionRequest $request, Enquiry $enquiry): JsonResponse
    {
        try {
            if (!$enquiry->canBeDeclined()) {
                return response()->json([
                    'error' => 'Enquiry cannot be declined',
                    'message' => $this->getCannotDeclineReason($enquiry)
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $declinedEnquiry = $this->enquiryService->declineEnquiry(
                $enquiry,
                $request->get('decline_reason', 'Not available'),
                $request->get('custom_message')
            );

            Log::info('Enquiry declined', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'decline_reason' => $request->get('decline_reason')
            ]);

            return response()->json([
                'message' => 'Enquiry declined successfully',
                'data' => new EnquiryResource($declinedEnquiry->load(['resource', 'statusHistory']))
            ]);

        } catch (Exception $e) {
            Log::error('Failed to decline enquiry', [
                'enquiry_id' => $enquiry->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to decline enquiry',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cancel an enquiry.
     *
     * Cancels an enquiry and removes any associated calendar events.
     *
     * @group Enquiry Actions
     * @authenticated
     *
     * @urlParam enquiry integer required The ID of the enquiry. Example: 1
     * @bodyParam cancellation_reason string Reason for cancellation. Example: Customer requested cancellation
     * @bodyParam notify_customer boolean Whether to notify the customer. Example: true
     */
    public function cancel(Request $request, Enquiry $enquiry): JsonResponse
    {
        try {
            $request->validate([
                'cancellation_reason' => 'required|string|max:500',
                'notify_customer' => 'boolean'
            ]);

            $cancelledEnquiry = $this->enquiryService->cancelEnquiry(
                $enquiry,
                $request->get('cancellation_reason'),
                $request->get('notify_customer', true)
            );

            if ($enquiry->hasMicrosoftEvent()) {
                try {
                    $this->calendarEventService->deleteEventForEnquiry($enquiry);

                    Log::info('Calendar event deleted for cancelled enquiry', [
                        'enquiry_id' => $enquiry->id,
                        'event_id' => $enquiry->microsoft_event_id
                    ]);
                } catch (Exception $e) {
                    Log::warning('Failed to delete calendar event for cancelled enquiry', [
                        'enquiry_id' => $enquiry->id,
                        'event_id' => $enquiry->microsoft_event_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('Enquiry cancelled', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'reason' => $request->get('cancellation_reason')
            ]);

            return response()->json([
                'message' => 'Enquiry cancelled successfully',
                'data' => new EnquiryResource($cancelledEnquiry->load(['resource', 'statusHistory']))
            ]);

        } catch (Exception $e) {
            Log::error('Failed to cancel enquiry', [
                'enquiry_id' => $enquiry->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to cancel enquiry',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle action via secure token (from email links).
     *
     * This endpoint handles enquiry actions when accessed through email action links.
     * It validates the secure token and performs the requested action.
     *
     * @group Enquiry Actions
     *
     * @urlParam token string required The secure action token. Example: abc123def456ghi789
     * @urlParam action string required The action to perform (approve, decline). Example: approve
     * @queryParam decline_reason string Reason for declining (only for decline action). Example: Not available
     * @queryParam custom_message string Custom message for customer. Example: Thank you for your enquiry
     */
    public function handleTokenAction(Request $request, string $token, string $action): JsonResponse
    {
        try {
            $enquiry = Enquiry::where('enquiry_token', $token)->first();

            if (!$enquiry) {
                return response()->json([
                    'error' => 'Invalid or expired action link'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($enquiry->isExpired()) {
                return response()->json([
                    'error' => 'This enquiry has expired and can no longer be processed'
                ], Response::HTTP_GONE);
            }

            Log::info('Processing token action', [
                'enquiry_id' => $enquiry->id,
                'action' => $action,
                'token' => substr($token, 0, 8) . '...'
            ]);

            switch ($action) {
                case 'approve':
                    return $this->handleTokenApproval($enquiry, $request);

                case 'decline':
                    return $this->handleTokenDecline($enquiry, $request);

                default:
                    return response()->json([
                        'error' => 'Invalid action specified'
                    ], Response::HTTP_BAD_REQUEST);
            }

        } catch (Exception $e) {
            Log::error('Token action processing failed', [
                'token' => substr($token, 0, 8) . '...',
                'action' => $action,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to process action',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle approval via token.
     */
    protected function handleTokenApproval(Enquiry $enquiry, Request $request): JsonResponse
    {
        if (!$enquiry->canBeApproved()) {
            return response()->json([
                'error' => 'Enquiry cannot be approved',
                'message' => $this->getCannotApproveReason($enquiry)
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $actionRequest = new EnquiryActionRequest([
            'create_calendar_event' => true,
            'calendar_notes' => $request->get('custom_message'),
            'action_token' => $enquiry->enquiry_token
        ]);

        return $this->approve($actionRequest, $enquiry);
    }

    /**
     * Handle decline via token.
     */
    protected function handleTokenDecline(Enquiry $enquiry, Request $request): JsonResponse
    {
        if (!$enquiry->canBeDeclined()) {
            return response()->json([
                'error' => 'Enquiry cannot be declined',
                'message' => $this->getCannotDeclineReason($enquiry)
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $actionRequest = new EnquiryActionRequest([
            'decline_reason' => $request->get('decline_reason', 'Not available'),
            'custom_message' => $request->get('custom_message'),
            'action_token' => $enquiry->enquiry_token
        ]);

        return $this->decline($actionRequest, $enquiry);
    }

    /**
     * Get reason why enquiry cannot be approved.
     */
    protected function getCannotApproveReason(Enquiry $enquiry): string
    {
        if ($enquiry->isExpired()) {
            return 'Enquiry has expired';
        }

        if (!$enquiry->isPending()) {
            return "Enquiry is already {$enquiry->status}";
        }

        return 'Enquiry cannot be approved';
    }

    /**
     * Get reason why enquiry cannot be declined.
     */
    protected function getCannotDeclineReason(Enquiry $enquiry): string
    {
        if ($enquiry->isExpired()) {
            return 'Enquiry has expired';
        }

        if (!$enquiry->isPending()) {
            return "Enquiry is already {$enquiry->status}";
        }

        return 'Enquiry cannot be declined';
    }
}
