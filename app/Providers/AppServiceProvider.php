<?php

namespace App\Providers;

use App\Models\Report;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole() && Schema::hasTable('verification_requests') && Schema::hasTable('reports')) {
            $pendingVerificationCount = VerificationRequest::where('status', 'pending')->count();
            $unhiddenReportsCount = Report::where('is_hidden', false)->count();
            $websiteData = User::where('role', 'website-data')->latest()->first();
            view()->share([
                'pendingVerificationCount' => $pendingVerificationCount,
                'unhiddenReportsCount' => $unhiddenReportsCount,
                'websiteData' => $websiteData,
            ]);
        }
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
