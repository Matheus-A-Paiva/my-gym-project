<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\GymPlan;
use App\Models\Member;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = Member::paginate($request->input('per_page', 10));

        return response()->json($members, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        try {
            $member = Member::create($request->validated());
        } catch (Exception $e) {
            Log::error("Error creating the member: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while creating the member.'], 500);
        }
        return response()->json($member, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $member = Member::find($id);
        return response()->json($member, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        try {
            $member = Member::find($id);
            $member->update($request->validated());
        } catch (Exception $e) {
            Log::error("Error updating the member: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while updating the member.'], 500);
        }
        return response()->json($member, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $member = Member::find($id);
            $member->delete();
        } catch (Exception $e) {
            Log::error("Error deleting the member: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while deleting the member.'], 500);
        }
        return response()->json(null, 204);
    }

    public function getPlans($memberId)
    {
        $member = Member::find($memberId);
        $gymPlans = $member->gymPlans;

        return response()->json($gymPlans, 200);
    }

    public function assignPlan($memberId, $gymPlanId)
    {
        try{
            $member = Member::find($memberId);
            $gymPlan = GymPlan::findOrFail($gymPlanId);
            $member->gymPlans()->attach($gymPlanId, ['created_at' => now(), 'updated_at' => now()]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Plan not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error adding plan to member: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while adding plan to member.'], 500);
        }

        return response()->json(['message' => 'Plan assigned'], 200);

    }

    public function getPlan($memberId, $gymPlanId)
    {
        try{
            $member = Member::find($memberId);
            $gymPlan = $member->gymPlans()->findOrFail($gymPlanId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Plan not assigned to member.'], 404);
        }
        return response()->json($gymPlan, 200);
    }

    public function removePlan($memberId, $gymPlanId)
    {
        try{
            $member = Member::find($memberId);
            $gymPlan = GymPlan::findOrFail($gymPlanId);
            $member->gymPlans()->detach($gymPlanId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Plan not found.'], 404);
        } catch (Exception $e) {
            Log::error("Error removing the plan from member: {$e->getMessage()}");
            return response()->json(['error' => 'An error occurred while removing the plan from member.'], 500);
        }

        return response()->json(null, 204);
    }
}
