<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Exception;

class ResourceController extends Controller
{
    /**
     * List all resources.
     *
     * @group Resources
     * @authenticated
     *
     * @response 200 [
     *   {"id":1,"name":"Conference Room"},
     *   {"id":2,"name":"Meeting Room"}
     * ]
     */
    public function index()
    {
        try {
            return ResourceResource::collection(Resource::all());
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching resources',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get resource availability and bookings.
     *
     * @group Resources
     * @authenticated
     *
     * @urlParam resource integer required The ID of the resource. Example: 1
     *
     * @response 200 {
     *   "resource":{"id":1,"name":"Conference Room"},
     *   "availability_slots":[{"start_time":"10:00","end_time":"12:00"}],
     *   "bookings":[{"id":1,"start_time":"2025-09-18T10:00","end_time":"2025-09-18T12:00"}]
     * }
     *
     * @response 404 {
     *   "message": "Resource not found",
     *   "errors": {"id":["The selected resource ID is invalid."]}
     * }
     */
    public function availability($id)
    {
        try {
            $resource = Resource::with(['availabilitySlots', 'bookings'])->findOrFail($id);

            return response()->json([
                'resource' => new ResourceResource($resource),
                'availability_slots' => $resource->availabilitySlots,
                'bookings' => $resource->bookings,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Resource not found',
                'errors' => [
                    'id' => ['The selected resource ID is invalid.']
                ]
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching availability',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
