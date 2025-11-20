<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * $roles llega en formato: 'Admin' o 'Admin|Chef'
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $rolesArray = explode('|', $roles); // 'Admin|Chef' => ['Admin', 'Chef']

        if (!auth()->user()->hasRole($rolesArray)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
