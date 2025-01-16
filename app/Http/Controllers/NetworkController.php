<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNetworkRequest;
use App\Http\Requests\UpdateNetworkRequest;
use App\Models\Network;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $networks = Network::paginate($request->input('per_page', 10));
        return response()->json($networks, 200);
    }

    public function store(StoreNetworkRequest $request)
    {
        try {
            $network = Network::create($request->validated());
        } catch (Exception $e) {
            Log::error("Error creating network: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while creating the network.'], 500);
        }
        return response()->json($network, 201);
    }

    public function show($id)
    {
        try {
            $network = Network::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Network not found.'], 404);
        }
        return response()->json($network, 200);
    }

    public function update(UpdateNetworkRequest $request, $id)
    {
        try {
            $network = Network::findOrFail($id);
            $network->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Network not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error updating network: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while updating the network.'], 500);
        }
        return response()->json($network, 200);
    }

    public function destroy($id)
    {
        try {
            $network = Network::findOrFail($id);
            $network->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Network not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error deleting network: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while deleting the network.'], 500);
        }
        return response()->json(null, 204);
    }
}
