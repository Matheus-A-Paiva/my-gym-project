<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowAccessOnlyFromCentralDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->is('api/tenants*') || $request->is('api/domains*')) {

            if (!in_array($request->getHost(), config('tenancy.central_domains'))){
                return response('Access is allowed only from the central domain.', 401);
            }
        }

        return $next($request);
    }
}
