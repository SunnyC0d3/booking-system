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
