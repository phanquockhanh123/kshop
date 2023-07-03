<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Http\Response;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, int $permission)
    {
        $userRole = \Auth::user()->role;

        if (in_array($permission, array_keys(Admin::$roles)) && $userRole >= $permission) {
            return $next($request);
        }

        return response()->json([
            'message' => trans('messages.permission'),
        ], Response::HTTP_FORBIDDEN);
    }
}
