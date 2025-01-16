<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGymRequest;
use App\Http\Requests\UpdateGymRequest;
use App\Models\Gym;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gyms = Gym::paginate($request->input('per_page', 10));

        return response()->json($gyms, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGymRequest $request)
    {
        try{
            $gym = Gym::create($request->validated());
        } catch (Exception $e){
            Log::error("Error creating gym: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while creating the gym.'], 500);
        }
        return response()->json($gym, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gym = Gym::find($id);
        return response()->json($gym, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGymRequest $request, $id)
    {
        try{
            $gym = Gym::find($id);
            $gym->update($request->validated());
        }  catch (Exception $e){
            Log::error("Error updating gym: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while updating the gym.'], 500);
        }
        return response()->json($gym, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $gym = Gym::find($id);
            $gym->delete();
        } catch (Exception $e){
            Log::error("Error deleting gym: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while deleting the gym.'], 500);
        }
        return response()->json(null, 204);
    }
}
