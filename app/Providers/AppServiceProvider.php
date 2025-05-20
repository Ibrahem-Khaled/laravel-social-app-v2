<?php

namespace App\Providers;

use App\Models\Report;
use App\Models\VerificationRequest;
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
        if (!app()->runningInConsole() && \Schema::hasTable('verification_requests') && \Schema::hasTable('report_posts')) {
            $pendingVerificationCount = VerificationRequest::where('status', 'pending')->count();
            $unhiddenReportsCount = Report::where('is_hidden', false)->count();

            view()->share([
                'pendingVerificationCount' => $pendingVerificationCount,
                'unhiddenReportsCount' => $unhiddenReportsCount,
            ]);
        }
        Schema::defaultStringLength(191);

    }

}
