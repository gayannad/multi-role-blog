<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChekUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized action !',
            ], 200);
        }

        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized action !',
        ], 200);
    }
}
