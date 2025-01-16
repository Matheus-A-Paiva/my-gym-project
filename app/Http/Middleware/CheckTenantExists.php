<?php

namespace App\Http\Middleware;

use App\Models\Member;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Tenant::where('id', $request->route('tenant_id'))->exists()) {
            return response()->json(['error' => 'Tenant not found.'], Response::HTTP_NOT_FOUND);
        }
        return $next($request);
    }
}
