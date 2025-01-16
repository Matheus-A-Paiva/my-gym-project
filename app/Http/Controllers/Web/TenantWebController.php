<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class TenantWebController extends Controller
{
    /**
    *
    *
    * @return View
    */
    public function index()
    {
        $response = Http::get('/api/tenants');

        if ($response->successful()) {
            $tenants = $response->json();
            return view('tenants.index', compact('tenants'));
        }

        return redirect()->route('tenants.index')->with('error', 'Failed to fetch tenants');
    }


    /**
    *
    *
    * @param int $id
    * @return View
    */
    public function show($id)
    {
        $response = Http::get('/api/tenants/' . $id);

        if ($response->successful()) {
            $tenant = $response->json();
            return view('tenants.show', compact('tenant'));
        } else {
            return redirect()->route('tenants.index')->with('error', 'Tenant not found');
        }
    }
}
