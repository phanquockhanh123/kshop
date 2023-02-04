<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\BaseController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckFirstLogin extends BaseController
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
        if (!auth()->user()->first_login_flag) {
            return $this->response([
                'id' => auth()->user()->id,
                'email' => auth()->user()->email_address,
                'first_login_flag' => auth()->user()->first_login_flag,
            ], Response::HTTP_FORBIDDEN);
        };
        return $next($request);
    }
}
