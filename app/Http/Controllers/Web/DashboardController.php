<?php

namespace App\Http\Controllers\Web;

class DashboardController
{
    public function index()
    {
        $host = strtolower(trim(request()->getHost()));
        $isCentralDomain = in_array($host, array_map('strtolower', config('tenancy.central_domains')));

        return view('dashboard', compact('isCentralDomain'));
    }



}
