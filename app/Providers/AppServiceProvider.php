<?php

namespace App\Providers;

use App\Models\ReportPost;
use App\Models\VerificationRequest;
use Illuminate\Support\ServiceProvider;

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
            $unhiddenReportsCount = ReportPost::where('is_hidden', false)->count();

            view()->share([
                'pendingVerificationCount' => $pendingVerificationCount,
                'unhiddenReportsCount' => $unhiddenReportsCount,
            ]);
        }
    }

}
