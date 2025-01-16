<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyForAuth
{
    protected $tenancy;
    protected $resolver;

    public function __construct(Tenancy $tenancy, DomainTenantResolver $resolver)
    {
        $this->tenancy = $tenancy;
        $this->resolver = $resolver;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentRouteName = Route::currentRouteName();
        $currentHost = $request->getHost();

        if (in_array($currentRouteName, ['login', 'logout']) && $this->isCentralDomain($currentHost)) {
            return $next($request);
        }

        return $this->initializeTenancy($request, $next, $currentHost);
    }

    /**
     *
     * @param string $host
     * @return bool
     */
    protected function isCentralDomain(string $host): bool
    {
        $normalizedHost = strtolower(trim($host));
        return in_array($normalizedHost, array_map('strtolower', config('tenancy.central_domains')));
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $currentHost
     * @return mixed
     */
    protected function initializeTenancy($request, Closure $next, string $currentHost)
    {
        $this->tenancy->initialize($this->resolver->resolve($currentHost));

        return $next($request);
    }
}
