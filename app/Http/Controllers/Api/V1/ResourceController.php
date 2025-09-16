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
