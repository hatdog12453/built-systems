<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;
use App\Models\Coach;
use App\Models\Client;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $map = [
            'admin' => Admin::class,
            'coach' => Coach::class,
            'client' => Client::class,
        ];

        if (!isset($map[$role]) || !($user instanceof $map[$role])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}


