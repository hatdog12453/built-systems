<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AdminWebMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = Session::get('role');
        $user = Session::get('user');

        if (!$user || $role !== 'admin') {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        return $next($request);
    }
}

