<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();

        if (!$user->roles()->where('name', $role)->exists()) {
            abort(403);
        }

        return $next($request);
    }
}
