<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Contracts\Auth\SupportsBasicAuth;
use Illuminate\Support\Facades\Auth;

class EmployeMiddleware
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
        if(! auth()->check()){
            return redirect('login');
        }                            
            return $next($request);
    }
}
