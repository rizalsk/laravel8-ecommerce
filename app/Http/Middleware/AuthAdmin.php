<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {   
        if(auth()->check()){
            if($role == 'admin' && auth()->user()->is_admin ){
                return $next($request);
            }else{
                session()->flush();
                return redirect()->route('admin.login');
            }
        }

        session()->flush();
        return redirect()->route('admin.login');

        /* if(session('is_admin')){
            return $next($request);
        }else{
            session()->flush();
            return redirect()->route('login');
        } */
        
    }
}
