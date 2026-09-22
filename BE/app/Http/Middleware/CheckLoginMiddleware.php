<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user('sanctum')) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện chức năng này'
            ], 401);
        }

        return $next($request);
    }
}