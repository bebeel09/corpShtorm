<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, string $role)
	{
		if(Auth::guest())
		{
			return redirect()->route('auth');
		}

		$roles = is_array($role) ? $role : explode('|', $role);

		if(!Auth::user()->hasAnyRole($roles))
		{
			return redirect()->route('dashboard');
		}

		return $next($request);

//        if( !$request->user()->hasRole($role)) {
//            return redirect()->route('dashboard');
//        }
//        if($permission !== null && !$request->user()->can($permission)) {
//            return redirect()->route('dashboard');
//        }
//        return $next($request);
	}
}
