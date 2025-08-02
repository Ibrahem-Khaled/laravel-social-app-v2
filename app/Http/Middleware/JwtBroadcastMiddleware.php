<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtBroadcastMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // محاولة مصادقة المستخدم بالتوكن
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            auth()->login($user); // تسجيل الدخول يدويًا لجعل Auth::user() يعمل
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token error', 'error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
