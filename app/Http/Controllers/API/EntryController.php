<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Resources\EntryResource;
use App\Models\Entry;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

/**
 * Get all user entries
 *
 * @group Entries
 * @authenticated
 * @responseField id int The ID of the entry
 */

class EntryController extends Controller
{
    use JsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(auth()->id());
        if (!$user) {
            return $this->errorResponse('Unauthorized', 401);
        }
        // Fetch entries for the authenticated user 
        $entries = $user->entries()->orderBy('date', 'desc')->paginate(10);
        return $this->successResponseWithPaginate(EntryResource::class, $entries, 'Entries');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntryRequest $request)
    {
        $entry = Entry::create($request->validated());
        return $this->successResponse(EntryResource::make($entry), 'Entry Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entry = Entry::with('user')->find($id);
        if (!$entry) {
            return $this->errorResponse('Entry not found', 404);
        }
        return $this->successResponse(EntryResource::make($entry), 'Entry Retrieved Successfully', 200);
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
        $entry = Entry::find($id);
        if (!$entry) {
            return $this->errorResponse('Entry not found', 404);
        }
        $entry->delete();
        return $this->successResponse(null, 'Entry Deleted Successfully', 204);
    }

    public function getMyIncomes()
    {
        $user = User::find(auth()->id());
        if (!$user) {
            return $this->errorResponse('Unauthorized', 401);
        }
        // Fetch incomes for the authenticated user
        $incomes = $user->incomes()->orderBy('date', 'desc')->paginate(10);
        return $this->successResponseWithPaginate(EntryResource::class, $incomes, 'Incomes');
    }
    public function getMyExpenses()
    {
        $user = User::find(auth()->id());
        if (!$user) {
            return $this->errorResponse('Unauthorized', 401);
        }
        // Fetch expenses for the authenticated user
        $expenses = $user->expenses()->orderBy('date', 'desc')->paginate(10);
        return $this->successResponseWithPaginate(EntryResource::class, $expenses, 'Expenses');
    }
}
