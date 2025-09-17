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
     * @group Bookings
     * @authenticated
     *
     * @bodyParam resource_id integer required The ID of the resource. Example: 1
     * @bodyParam start_time string required Start time in ISO 8601 format. Example: 2025-09-18T10:00:00
     * @bodyParam end_time string required End time in ISO 8601 format. Example: 2025-09-18T12:00:00
     * @bodyParam customer_info string Customer info. Example: John Doe
     *
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "resource": {"id": 1, "name": "Conference Room"},
     *     "start_time": "2025-09-18T10:00:00",
     *     "end_time": "2025-09-18T12:00:00",
     *     "customer_info": "John Doe",
     *     "status": "confirmed"
     *   }
     * }
     *
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {"start_time": ["The start time field is required."]}
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
     * @group Bookings
     * @authenticated
     *
     * @urlParam booking integer required The ID of the booking. Example: 1
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "resource": {"id": 1, "name": "Conference Room"},
     *     "start_time": "2025-09-18T10:00:00",
     *     "end_time": "2025-09-18T12:00:00",
     *     "customer_info": "John Doe",
     *     "status": "confirmed"
     *   }
     * }
     *
     * @response 404 {
     *   "message": "An error occurred",
     *   "error": "Booking not found"
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
     * @group Bookings
     * @authenticated
     *
     * @urlParam booking integer required The ID of the booking. Example: 1
     * @bodyParam start_time string Start time in ISO 8601 format. Example: 2025-09-18T10:30:00
     * @bodyParam end_time string End time in ISO 8601 format. Example: 2025-09-18T12:30:00
     * @bodyParam customer_info string Customer info. Example: Jane Doe
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "resource": {"id": 1, "name": "Conference Room"},
     *     "start_time": "2025-09-18T10:30:00",
     *     "end_time": "2025-09-18T12:30:00",
     *     "customer_info": "Jane Doe",
     *     "status": "confirmed"
     *   }
     * }
     *
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {"end_time": ["The end time must be after start time."]}
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
     * @group Bookings
     * @authenticated
     *
     * @urlParam booking integer required The ID of the booking. Example: 1
     *
     * @response 204 {
     *   "message": "Booking cancelled"
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
