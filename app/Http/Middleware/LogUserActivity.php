<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('api')->check()) {
            // Key فريد لكل مستخدم
            $cacheKey = 'user-is-online-' . auth()->guard('api')->id();

            // حط قيمة في الكاش لمدة ست دقائق مثلاً
            // مع كل request جديد، صلاحية الكاش هتتمد ست دقائق كمان
            Cache::put($cacheKey, true, now()->addMinutes(6));
        }

        return $next($request);
    }
}
