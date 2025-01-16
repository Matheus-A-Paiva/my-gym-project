<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGymPlanRequest;
use App\Http\Requests\UpdateGymPlanRequest;
use App\Models\Gym;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $gymId)
    {
        $gym = Gym::find($gymId);
        $gymPlans = $gym->gymPlans()->paginate($request->input('per_page', 10));
        return response()->json($gymPlans, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGymPlanRequest $request, $gymId)
    {
        try{
            $gym = Gym::findOrFail($gymId);
            $gymPlan =$gym->gymPlans()->create($request->validated());
        } catch (Exception $e) {
            Log::error("Error creating the gym plan: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while creating the gym plan.'], 500);
        }
        return response()->json($gymPlan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($gymId, $gymPlanId)
    {
        try{
            $gym = Gym::find($gymId);
            $gymPlan = $gym->gymPlans()->findOrFail($gymPlanId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Gym plan not found.'], 404);
        }


        return response()->json($gymPlan, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGymPlanRequest $request, $gymId, $gymPlanId)
    {
        try{
            $gym = Gym::find($gymId);
            $gymPlan = $gym->gymPlans()->findOrFail($gymPlanId);
            $gymPlan->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Gym plan not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error updating the gym plan: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while updating the gym plan.'], 500);
        }
        return response()->json($gymPlan, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($gymId, $gymPlanId)
    {
        try{
            $gym = Gym::find($gymId);
            $gymPlan = $gym->gymPlans()->findOrFail($gymPlanId);
            $gymPlan->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Gym plan not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error deleting the gym plan: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while deleting gym plan.'], 500);
        }
        return response()->json(null, 204);
    }
}
