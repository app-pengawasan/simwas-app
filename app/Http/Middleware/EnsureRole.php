<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */



    public function handle(Request $request, Closure $next, ...$role)
    {
        $roleString = $role[0];
        if ($roleString == 'is_sekretaris'){
            if (auth()->user()->is_sekma == true || auth()->user()->is_sekwil == true) {
                return $next($request);
            } else {
                return redirect('/');
            }
        }
        if (auth()->user()->$roleString == true) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
