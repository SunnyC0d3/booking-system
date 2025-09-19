<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceAvailabilityRequest;
use App\Http\Requests\ResourceIndexRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use App\Services\AvailabilityService;
use App\Services\CalendarService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Exception;

class ResourceController extends Controller
{
    protected AvailabilityService $availabilityService;
    protected CalendarService $calendarService;

    public function __construct(AvailabilityService $availabilityService, CalendarService $calendarService)
    {
        $this->availabilityService = $availabilityService;
        $this->calendarService = $calendarService;
    }

    /**
     * List all resources.
     *
     * Retrieves all bookable resources in the system with their basic information
     * including name, description, capacity, and availability rules.
     *
     * @group Resources
     * @authenticated
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Conference Room A",
     *       "description": "Large conference room for up to 12 people",
     *       "capacity": 12,
     *       "availability_rules": {
     *         "monday": ["09:00-17:00"],
     *         "tuesday": ["09:00-17:00"],
     *         "wednesday": ["09:00-17:00"],
     *         "thursday": ["09:00-17:00"],
     *         "friday": ["09:00-17:00"]
     *       }
     *     },
     *     {
     *       "id": 2,
     *       "name": "Meeting Room B",
     *       "description": "Small meeting room for up to 4 people",
     *       "capacity": 4,
     *       "availability_rules": {
     *         "monday": ["08:00-20:00"],
     *         "tuesday": ["08:00-20:00"],
     *         "wednesday": ["08:00-20:00"],
     *         "thursday": ["08:00-20:00"],
     *         "friday": ["08:00-20:00"]
     *       }
     *     }
     *   ]
     * }
     */
    public function index(ResourceIndexRequest $request)
    {
        try {
            $query = Resource::query();

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            }

            if ($request->filled('capacity_min')) {
                $query->where('capacity', '>=', $request->input('capacity_min'));
            }

            if ($request->filled('capacity_max')) {
                $query->where('capacity', '<=', $request->input('capacity_max'));
            }

            $sortBy = $request->input('sort_by', 'name');
            $sortDirection = $request->input('sort_direction', 'asc');
            $perPage = $request->input('per_page', 10);
            $currentPage = $request->input('page', 1);

            $query
                ->orderBy($sortBy, $sortDirection)
                ->paginate($perPage, ['*'], 'page', $currentPage);

            return ResourceResource::collection($query->get());
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
     * Retrieves availability information for a specific resource with flexible date querying.
     * Returns availability slots, existing bookings, and calendar-formatted data for frontend integration.
     *
     * The endpoint supports multiple query modes:
     * - Single date: Returns availability for one specific date
     * - Date range: Returns availability between two dates
     * - Days ahead: Returns availability for N days starting from today
     * - Default: Returns today's availability if no parameters provided
     *
     * @group Resources
     * @authenticated
     *
     * @response 200 {
     *   "resource": {
     *     "id": 1,
     *     "name": "Conference Room A",
     *     "description": "Large conference room",
     *     "capacity": 12
     *   },
     *   "date_range": {
     *     "from": "2025-09-18",
     *     "to": "2025-09-25"
     *   },
     *   "availability_slots": [
     *     {
     *       "id": 1,
     *       "date": "2025-09-18",
     *       "start_time": "09:00:00",
     *       "end_time": "10:00:00",
     *       "is_available": true
     *     },
     *     {
     *       "id": 2,
     *       "date": "2025-09-18",
     *       "start_time": "10:00:00",
     *       "end_time": "11:00:00",
     *       "is_available": false
     *     }
     *   ],
     *   "bookings": [
     *     {
     *       "id": 1,
     *       "start_time": "2025-09-18T10:00:00",
     *       "end_time": "2025-09-18T11:00:00",
     *       "customer_info": {"name": "John Doe", "email": "john@example.com"},
     *       "status": "confirmed"
     *     }
     *   ],
     *   "calendar_view": [
     *     {
     *       "date": "2025-09-18",
     *       "total_slots": 8,
     *       "available_slots": 7,
     *       "slots": [...]
     *     },
     *     {
     *       "date": "2025-09-19",
     *       "total_slots": 8,
     *       "available_slots": 8,
     *       "slots": [...]
     *     }
     *   ]
     * }
     *
     * @response 200 {
     *   "resource": {"id": 1, "name": "Conference Room A"},
     *   "date": "2025-09-18",
     *   "availability_slots": [...],
     *   "bookings": [...]
     * }
     *
     * @response 404 {
     *   "message": "Resource not found",
     *   "errors": {"id": ["The selected resource ID is invalid."]}
     * }
     *
     * @response 422 {
     *   "message": "Invalid date format",
     *   "errors": {"date": ["The date format is invalid. Use Y-m-d format."]}
     * }
     */
    public function availability($id, ResourceAvailabilityRequest $request)
    {
        try {
            $resource = Resource::findOrFail($id);
            $dateRange = $this->getDateRangeFromRequest($request);

            if ($dateRange['single_date']) {
                $availabilitySlots = $resource->getAvailabilityForDate($dateRange['start']);
                $bookings = $resource->bookings()
                    ->whereDate('start_time', $dateRange['start']->toDateString())
                    ->get();

                return response()->json([
                    'resource' => new ResourceResource($resource),
                    'date' => $dateRange['start']->toDateString(),
                    'availability_slots' => $availabilitySlots,
                    'bookings' => $bookings,
                ]);
            }

            $availabilitySlots = $this->availabilityService->getAvailabilityForDateRange(
                $resource,
                $dateRange['start'],
                $dateRange['end']
            );

            $bookings = $resource->bookings()
                ->whereBetween('start_time', [
                    $dateRange['start']->startOfDay(),
                    $dateRange['end']->endOfDay()
                ])
                ->get();

            $calendarView = $this->calendarService->formatAvailabilityForCalendar(
                $availabilitySlots->toArray()
            );

            return response()->json([
                'resource' => new ResourceResource($resource),
                'date_range' => [
                    'from' => $dateRange['start']->toDateString(),
                    'to' => $dateRange['end']->toDateString(),
                ],
                'availability_slots' => $availabilitySlots,
                'bookings' => $bookings,
                'calendar_view' => $calendarView,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Resource not found',
                'errors' => [
                    'id' => ['The selected resource ID is invalid.']
                ]
            ], Response::HTTP_NOT_FOUND);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => 'Invalid date parameters',
                'errors' => [
                    'date' => [$e->getMessage()]
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching availability',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getDateRangeFromRequest(ResourceAvailabilityRequest $request): array
    {
        if ($request->filled('date')) {
            return [
                'single_date' => true,
                'start' => Carbon::createFromFormat('Y-m-d', $request->input('date')),
                'end' => Carbon::createFromFormat('Y-m-d', $request->input('date')),
            ];
        }

        if ($request->filled('from') && $request->filled('to')) {
            return [
                'single_date' => false,
                'start' => Carbon::createFromFormat('Y-m-d', $request->input('from')),
                'end' => Carbon::createFromFormat('Y-m-d', $request->input('to')),
            ];
        }

        if ($request->filled('days')) {
            return [
                'single_date' => false,
                'start' => Carbon::today(),
                'end' => Carbon::today()->addDays((int) $request->input('days') - 1),
            ];
        }

        return [
            'single_date' => true,
            'start' => Carbon::today(),
            'end' => Carbon::today(),
        ];
    }
}
