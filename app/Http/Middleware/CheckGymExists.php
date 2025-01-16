<?php

namespace App\Http\Middleware;

use App\Models\Gym;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGymExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $gymId = $request->route('gym_id');

        $gym = Gym::find($gymId);

        if(!$gym){
            return response()->json(['error' => 'Gym not found.'], Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
