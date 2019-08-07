<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permission)
	{
		if(app('auth')->guest()) {
			return redirect()->route('auth');
		}
		$permissions = is_array($permission) ? $permission : explode('|', $permission);

		foreach ($permissions as $permission)
		{
			if(app('auth')->user()->can($permission)) {
				return $next($request);
			}
		}

		return redirect()->route('dashboard');
	}
}
