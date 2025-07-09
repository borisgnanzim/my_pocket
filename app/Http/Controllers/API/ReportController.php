<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

/**
 * ReportController handles the management of user reports.
 *
 * @group Reports
 * @authenticated
 */
class ReportController extends Controller
{
    use JsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->errorResponse('Unauthorized', 401);
        }
        // Fetch reports for the authenticated user
        $reports = $user->reports()->orderBy('created_at', 'desc')->paginate(10);
        return $this->successResponseWithPaginate(ReportResource::class, $reports, 'Reports');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::find($id);
        if (!$report) 
        {
            return $this->errorResponse('Report not found', 404);
        }
        // check if the report belongs to the authenticated user
        if ($report->user_id !== auth()->id()) 
        {
            return $this->errorResponse('Unauthorized', 403);
        }
        return $this->successResponse(ReportResource::make($report), 'Report Retrieved Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = ReportResource::find($id);
        if (!$report) {
            return $this->errorResponse('Report not found', 404);
        }
        // check if the report belongs to the authenticated user
        if ($report->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }
        $report->delete();
        return $this->successResponse(null, 'Report Deleted Successfully', 204);
    }
}
