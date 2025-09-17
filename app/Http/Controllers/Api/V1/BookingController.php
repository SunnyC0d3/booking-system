<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Resource;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Exception;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Create a new booking.
     *
     * Creates a booking for a specific resource and time slot. The system automatically:
     * - Validates booking is within allowed time window (min/max advance booking)
     * - Checks for availability conflicts and resource capacity
     * - Verifies no blackout dates (holidays, maintenance)
     * - Marks availability slots as unavailable for single-capacity resources
     *
     * @group Bookings
     * @authenticated
     *
     * @bodyParam resource_id integer required The ID of the resource to book. Example: 1
     * @bodyParam start_time string required Start time in ISO 8601 format. Example: 2025-09-18T10:00:00
     * @bodyParam end_time string required End time in ISO 8601 format. Example: 2025-09-18T12:00:00
     * @bodyParam customer_info object required Customer information object.
     * @bodyParam customer_info.name string required Customer name. Example: John Doe
     * @bodyParam customer_info.email string required Customer email. Example: john@example.com
     *
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "resource": {"id": 1, "name": "Conference Room"},
     *     "start_time": "2025-09-18T10:00:00",
     *     "end_time": "2025-09-18T12:00:00",
     *     "customer_info": {"name": "John Doe", "email": "john@example.com"},
     *     "status": "pending"
     *   }
     * }
     *
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {
     *     "start_time": ["Booking time is outside allowed booking window"],
     *     "availability": ["Resource is not available in this time slot"],
     *     "conflict": ["Resource is fully booked for this interval"]
     *   }
     * }
     *
     * @response 404 {
     *   "message": "Resource not found"
     * }
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            $resource = Resource::findOrFail($request->resource_id);

            $booking = $this->bookingService->createBooking(
                $resource,
                Carbon::parse($request->start_time),
                Carbon::parse($request->end_time),
                $request->customer_info
            );

            return new BookingResource($booking->load('resource'));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a single booking.
     *
     * Retrieves detailed information about a specific booking including
     * resource details and current booking status.
     *
     * @group Bookings
     * @authenticated
     *
     * @urlParam booking integer required The ID of the booking. Example: 1
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "resource": {"id": 1, "name": "Conference Room", "capacity": 8},
     *     "start_time": "2025-09-18T10:00:00",
     *     "end_time": "2025-09-18T12:00:00",
     *     "customer_info": {"name": "John Doe", "email": "john@example.com"},
     *     "status": "confirmed",
     *     "created_at": "2025-09-17T15:30:00"
     *   }
     * }
     *
     * @response 404 {
     *   "message": "Booking not found"
     * }
     */
    public function show(Booking $booking)
    {
        try {
            return new BookingResource($booking->load('resource'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update a booking.
     *
     * Updates an existing booking. When changing time slots, the system:
     * - Validates new time is within booking window
     * - Checks new time slot availability and conflicts
     * - Restores old availability slots and marks new ones as unavailable
     * - Prevents updates to cancelled bookings
     *
     * @group Bookings
     * @authenticated
     *
     * @urlParam booking integer required The ID of the booking to update. Example: 1
     * @bodyParam start_time string optional New start time in ISO 8601 format. Example: 2025-09-18T10:30:00
     * @bodyParam end_time string optional New end time in ISO 8601 format. Example: 2025-09-18T12:30:00
     * @bodyParam customer_info object optional Updated customer information.
     * @bodyParam customer_info.name string optional Updated customer name. Example: Jane Doe
     * @bodyParam customer_info.email string optional Updated customer email. Example: jane@example.com
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "resource": {"id": 1, "name": "Conference Room"},
     *     "start_time": "2025-09-18T10:30:00",
     *     "end_time": "2025-09-18T12:30:00",
     *     "customer_info": {"name": "Jane Doe", "email": "jane@example.com"},
     *     "status": "pending"
     *   }
     * }
     *
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {
     *     "availability": ["Resource is not available in this new time slot"],
     *     "conflict": ["Resource is fully booked for this interval"]
     *   }
     * }
     *
     * @response 404 {
     *   "message": "Booking not found"
     * }
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            $updated = $this->bookingService->updateBooking(
                $booking,
                $request->start_time ? Carbon::parse($request->start_time) : $booking->start_time,
                $request->end_time ? Carbon::parse($request->end_time) : $booking->end_time,
                $request->customer_info ?? $booking->customer_info,
            );

            return new BookingResource($updated->load('resource'));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cancel a booking.
     *
     * Cancels an existing booking and restores availability slots for future bookings.
     * For single-capacity resources, the cancelled time slots become available again.
     * Cancelled bookings cannot be reactivated.
     *
     * @group Bookings
     * @authenticated
     *
     * @urlParam booking integer required The ID of the booking to cancel. Example: 1
     *
     * @response 200 {
     *   "message": "Booking cancelled successfully"
     * }
     *
     * @response 404 {
     *   "message": "Booking not found"
     * }
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->update(['status' => 'cancelled']);
            return response()->json(['message' => 'Booking cancelled'], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
