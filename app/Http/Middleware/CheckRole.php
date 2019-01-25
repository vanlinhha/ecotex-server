<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Cores\Rest\UserController;
use Closure;

class CheckRole
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role))
        {
            //access permission denied
            return response()->json(['message' => 'Bạn không có quyền thực hiện chức năng này'], 403);
        }
        return $next($request);
    }
}
