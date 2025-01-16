<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\GymPlanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AllowAccessOnlyFromCentralDomains;
use App\Http\Middleware\InitializeTenancyForAuth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'api'
])->prefix('api')->group(function () {

    Route::middleware(['auth:sanctum', AllowAccessOnlyFromCentralDomains::class])->group(function () {

        Route::prefix('tenants')->group(function () {
            Route::get('/', [TenantController::class, 'index']);
            Route::get('/{tenant_id}', [TenantController::class, 'show'])->middleware('check.tenant.exists');
            Route::post('/', [TenantController::class, 'store']);
            Route::put('/{tenant_id}', [TenantController::class, 'update'])->middleware('check.tenant.exists');
            Route::delete('/{tenant_id}', [TenantController::class, 'destroy'])->middleware('check.tenant.exists');

            Route::prefix('{tenant_id}/domains')->middleware('check.tenant.exists')->group(function () {
                Route::get('/', [DomainController::class, 'index']);
                Route::get('/{domain_id}', [DomainController::class, 'show']);
                Route::post('/', [DomainController::class, 'store']);
                Route::put('/{domain_id}', [DomainController::class, 'update']);
                Route::delete('/{domain_id}', [DomainController::class, 'destroy']);
            });
        });
    });

    Route::middleware(['auth:sanctum', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{user_id}', [UserController::class, 'show']);
            Route::post('/', [UserController::class, 'store']);
            Route::put('/{user_id}', [UserController::class, 'update']);
            Route::delete('/{user_id}', [UserController::class, 'destroy']);
        });

        Route::prefix('networks')->group(function () {
            Route::get('/', [NetworkController::class, 'index']);
            Route::get('/{network_id}', [NetworkController::class, 'show']);
            Route::post('/', [NetworkController::class, 'store']);
            Route::put('/{network_id}', [NetworkController::class, 'update']);
            Route::delete('/{network_id}', [NetworkController::class, 'destroy']);
        });

        Route::prefix('gyms')->group(function () {
           Route::get('/', [GymController::class, 'index']);
           Route::get('/{gym_id}', [GymController::class, 'show'])->middleware('check.gym.exists');
           Route::post('/', [GymController::class, 'store']);
           Route::put('/{gym_id}', [GymController::class, 'update'])->middleware('check.gym.exists');
           Route::delete('/{gym_id}', [GymController::class, 'destroy'])->middleware('check.gym.exists');

           Route::prefix('{gym_id}/plans')->middleware('check.gym.exists')->group(function () {
               Route::get('/', [GymPlanController::class, 'index']);
               Route::post('/', [GymPlanController::class, 'store']);
               Route::get('/{gym_plan_id}', [GymPlanController::class, 'show']);
               Route::put('/{gym_plan_id}', [GymPlanController::class, 'update']);
               Route::delete('/{gym_plan_id}', [GymPlanController::class, 'destroy']);
            });
        });


        Route::prefix('members')->group(function () {
           Route::get('/', [MemberController::class, 'index']);
           Route::get('/{member_id}', [MemberController::class, 'show'])->middleware('check.member.exists');
           Route::post('/', [MemberController::class, 'store']);
           Route::put('/{member_id}', [MemberController::class, 'update'])->middleware('check.member.exists');
           Route::delete('/{member_id}', [MemberController::class, 'destroy'])->middleware('check.member.exists');

            Route::prefix('{member_id}/plans')->middleware('check.member.exists')->group(function () {
                Route::get('/', [MemberController::class, 'getPlans']);
                Route::post('/{gym_plan_id}', [MemberController::class, 'assignPlan']);
                Route::get('/{gym_plan_id}', [MemberController::class, 'getPlan']);
                Route::delete('/{gym_plan_id}', [MemberController::class, 'removePlan']);

            });
        });

    });

    Route::middleware(['auth:sanctum', InitializeTenancyForAuth::class])->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

    Route::middleware([InitializeTenancyForAuth::class])->group(function () {
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest')
            ->name('login');
    });
});


