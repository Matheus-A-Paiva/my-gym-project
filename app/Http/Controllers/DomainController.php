<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\Domain;
use App\Models\Tenant;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    public function index(Request $request, $tenantId)
    {
        $domains = Domain::where('tenant_id', $tenantId)
            ->paginate($request->input('per_page', 10));

        return response()->json($domains, 200);
    }

    public function store(StoreDomainRequest $request, $tenantId)
    {
        try {
            $domain = Tenant::find($tenantId)->domains()->create($request->validated());
        } catch (Exception $e) {
            Log::error("Error creating domain: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while creating the domain.'], 500);
        }

        return response()->json($domain, 201);
    }

    public function show($tenantId, $domainId)
    {
        try {
            $domain = Tenant::find($tenantId)->domains()->findOrFail($domainId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Domain not found.'], 404);
        }

        return response()->json($domain, 200);
    }

    public function update(UpdateDomainRequest $request, $tenantId, $domainId)
    {
        try {
            $domain = Tenant::find($tenantId)->domains()->findOrFail($domainId);
            $domain->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => "Domain not found."], 404);
        } catch (Exception $e) {
            Log::error("Error updating domain: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while updating the domain.'], 500);
        }

        return response()->json($domain, 200);
    }

    public function destroy($tenantId, $domainId)
    {
        try {
            $domain = Tenant::find($tenantId)->domains()->findOrFail($domainId);
            $domain->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Domain not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error deleting domain: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while deleting the domain.'], 500);
        }

        return response()->json(null, 204);
    }
}
