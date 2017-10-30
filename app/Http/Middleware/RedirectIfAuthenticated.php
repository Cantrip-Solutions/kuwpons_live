<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            
            if (Auth::user()->u_role == 'U') {
                // if (Auth::user()->status != '1') {

                //     Session::flash('message',json_encode(array('type'=>'error', 'message'=>'Acccount is not Active')));
                // }
                return redirect()->back();
            } else{
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
