<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Tenant;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenants = Tenant::paginate($request->input('per_page', 10));

        return response()->json($tenants, 200);
    }


    public function store(StoreTenantRequest $request)
    {
        try {
            $tenant = Tenant::create($request->validated());
        } catch (Exception $e) {
            Log::error("Error creating tenant: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while creating the tenant.'], 500);
        }

        return response()->json($tenant, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        return response()->json($tenant, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantRequest $request, $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $tenant->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (Exception $e) {
            Log::error("Error updating tenant: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while updating the tenant.'], 500);
        }

        return response()->json($tenant, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tenant = Tenant::findOrFail($id);
            $tenant->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (Exception $e) {
            Log::error("Error deleting tenant: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while deleting the tenant.'], 500);
        }

        return response()->json(null, 204);
    }
}
