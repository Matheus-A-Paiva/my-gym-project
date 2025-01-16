<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMemberExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $member_id = $request->route('member_id');

        $member = Member::find($member_id);
        if (!$member) {
            return response()->json(['error' => 'Member not found.'], Response::HTTP_NOT_FOUND);
        }
        return $next($request);
    }
}
