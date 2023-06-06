<?php

namespace ConfrariaWeb\Acl\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $getRouteName = $request->route()->getName();
        abort_unless(Auth::user()->hasPermission($getRouteName), 403);
        return $next($request);
    }
}
