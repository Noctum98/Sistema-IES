<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$roles)
    {  
        $roles = explode("-",$roles);
        if($request->user()->authorizeRoles($roles)){
            return $next($request);
        }else{
            return redirect('/home');
        }
        
    }
}
