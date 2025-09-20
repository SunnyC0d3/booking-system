<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Requests\UpdateEnquiryRequest;
use App\Http\Resources\EnquiryResource;
use App\Http\Resources\EnquiryCollection;
use App\Models\Enquiry;
use App\Models\Resource;
use App\Services\EnquiryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Exception;

class EnquiryController extends Controller
{
    protected EnquiryService $enquiryService;

    public function __construct(EnquiryService $enquiryService)
    {
        $this->enquiryService = $enquiryService;
    }

    /**
     * Display a listing of enquiries.
     *
     * @group Enquiries
     * @authenticated
     *
     * @queryParam status string Filter by enquiry status (pending, approved, declined, cancelled). Example: pending
     * @queryParam resource_id integer Filter by resource ID. Example: 1
     * @queryParam date string Filter by preferred date (Y-m-d format). Example: 2025-09-25
     * @queryParam from string Filter from date (Y-m-d format). Example: 2025-09-20
     * @queryParam to string Filter to date (Y-m-d format). Example: 2025-09-30
     * @queryParam customer_email string Filter by customer email. Example: john@example.com
     * @queryParam per_page integer Number of items per page (max 100). Example: 15
     * @queryParam page integer Page number. Example: 1
     */
    public function index(Request $request): JsonResponse
    {
        $query = Enquiry::with(['resource', 'statusHistory'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('resource_id')) {
            $query->where('resource_id', $request->resource_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('preferred_date', $request->date);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('preferred_date', [$request->from, $request->to]);
        }

        if ($request->filled('customer_email')) {
            $query->whereJsonContains('customer_info->email', $request->customer_email);
        }

        $perPage = min($request->get('per_page', 15), 100);
        $enquiries = $query->paginate($perPage);

        return response()->json(new EnquiryCollection($enquiries));
    }

    /**
     * Store a newly created enquiry.
     *
     * Creates a new enquiry for a specific resource and sends notification emails.
     * This is the main endpoint customers use to submit enquiry requests.
     *
     * @group Enquiries
     *
     * @bodyParam resource_id integer required The ID of the resource to enquire about. Example: 1
     * @bodyParam preferred_date string required Preferred date in Y-m-d format. Example: 2025-09-25
     * @bodyParam preferred_start_time string Preferred start time in H:i format. Example: 10:00
     * @bodyParam preferred_end_time string Preferred end time in H:i format. Example: 12:00
     * @bodyParam customer_info object required Customer information object.
     * @bodyParam customer_info.name string required Customer name. Example: John Doe
     * @bodyParam customer_info.email string required Customer email. Example: john@example.com
     * @bodyParam customer_info.phone string Customer phone number. Example: +1234567890
     * @bodyParam customer_info.company string Customer company name. Example: Acme Corp
     * @bodyParam message string Additional message or requirements. Example: Looking for decoration services for a corporate event.
     */
    public function store(StoreEnquiryRequest $request): JsonResponse
    {
        try {
            $resource = Resource::findOrFail($request->resource_id);

            $enquiry = $this->enquiryService->createEnquiry(
                $resource,
                $request->validated()
            );

            return response()->json([
                'message' => 'Enquiry submitted successfully',
                'data' => new EnquiryResource($enquiry->load(['resource', 'statusHistory']))
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create enquiry',
                'message' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified enquiry.
     *
     * @group Enquiries
     * @authenticated
     *
     * @urlParam enquiry integer required The ID of the enquiry. Example: 1
     */
    public function show(Enquiry $enquiry): JsonResponse
    {
        $enquiry->load(['resource', 'statusHistory', 'syncLogs']);

        return response()->json([
            'data' => new EnquiryResource($enquiry)
        ]);
    }

    /**
     * Update the specified enquiry.
     *
     * @group Enquiries
     * @authenticated
     *
     * @urlParam enquiry integer required The ID of the enquiry. Example: 1
     * @bodyParam preferred_date string Preferred date in Y-m-d format. Example: 2025-09-26
     * @bodyParam preferred_start_time string Preferred start time in H:i format. Example: 14:00
     * @bodyParam preferred_end_time string Preferred end time in H:i format. Example: 16:00
     * @bodyParam customer_info object Customer information object.
     * @bodyParam customer_info.name string Customer name. Example: John Doe
     * @bodyParam customer_info.email string Customer email. Example: john@example.com
     * @bodyParam customer_info.phone string Customer phone number. Example: +1234567890
     * @bodyParam customer_info.company string Customer company name. Example: Acme Corp
     * @bodyParam message string Additional message or requirements.
     * @bodyParam status string Update enquiry status (pending, approved, declined, cancelled). Example: approved
     */
    public function update(UpdateEnquiryRequest $request, Enquiry $enquiry): JsonResponse
    {
        try {
            $updatedEnquiry = $this->enquiryService->updateEnquiry($enquiry, $request->validated());

            return response()->json([
                'message' => 'Enquiry updated successfully',
                'data' => new EnquiryResource($updatedEnquiry->load(['resource', 'statusHistory']))
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update enquiry',
                'message' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified enquiry.
     *
     * @group Enquiries
     * @authenticated
     *
     * @urlParam enquiry integer required The ID of the enquiry. Example: 1
     */
    public function destroy(Enquiry $enquiry): JsonResponse
    {
        try {
            $this->enquiryService->cancelEnquiry($enquiry, 'Deleted via API');

            return response()->json([
                'message' => 'Enquiry cancelled successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to cancel enquiry',
                'message' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Get enquiry statistics and summary.
     *
     * @group Enquiries
     * @authenticated
     *
     * @queryParam from string Start date for statistics (Y-m-d format). Example: 2025-09-01
     * @queryParam to string End date for statistics (Y-m-d format). Example: 2025-09-30
     */
    public function statistics(Request $request): JsonResponse
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to', now()->endOfMonth()->toDateString());

        $statistics = $this->enquiryService->getEnquiryStatistics($from, $to);

        return response()->json([
            'data' => $statistics
        ]);
    }

    /**
     * Search enquiries by customer information.
     *
     * @group Enquiries
     * @authenticated
     *
     * @queryParam q string required Search term (searches name, email, company). Example: john
     * @queryParam per_page integer Number of items per page (max 100). Example: 15
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q'        => 'required|string|min:2',
            'page'     => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100'
        ]);

        $searchTerm = $request->q;
        $currentPage = $request->input('page', 1);
        $perPage = min($request->get('per_page', 10), 100);

        $enquiries = Enquiry::with(['resource', 'statusHistory'])
            ->where(function ($query) use ($searchTerm) {
                $query->whereJsonContains('customer_info->name', $searchTerm)
                    ->orWhereJsonContains('customer_info->email', $searchTerm)
                    ->orWhereJsonContains('customer_info->company', $searchTerm)
                    ->orWhere('message', 'like', "%{$searchTerm}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json(new EnquiryCollection($enquiries));
    }
}
