<?php

namespace App\Providers;

use App\PermissionRegistrar;
use App\Role;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Compilers\BladeCompiler;
use App\Contracts\Role as RoleContract;
use App\Contracts\Permission as PermissionContract;
use Illuminate\Support\Collection;

class PermissionsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot(PermissionRegistrar $permissionLoader, Filesystem $filesystem)
	{

		//  It's old version
		//        Permission::get()->map(function($permission){
		//            Gate::define($permission->slug, function($user) use ($permission){
		//                return $user->hasPermissionTo($permission);
		//            });
		//        });
		$this->registerMacroHelpers();
		$this->registerModelBindings();

		$permissionLoader->registerPermissions();
		$this->app->singleton(PermissionRegistrar::class, function ($app) use ($permissionLoader) {
			return $permissionLoader;
		});
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerBladeExtensions();
	}

	protected function registerModelBindings()
	{
		$this->app->bind(PermissionContract::class, Permission::class);
		$this->app->bind(RoleContract::class, Role::class);
	}

	protected function registerMacroHelpers()
	{
		Route::macro('role', function($roles = []) {
			if(!is_array($roles)) $roles = [$roles];

			$roles = implode('|', $roles);

			$this->middleware('role:$roles');

			return $this;
		});

		Route::macro('permission', function($permissions = []) {
			if(is_array($permissions)) $permissions = [$permissions];

			$permissions = implode('|', $permissions);

			$this->middleware('permission:$permissions');

			return $this;
		});
	}

	protected function registerBladeExtensions()
	{
		$this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
			$bladeCompiler->directive('role', function ($arguments) {
				list($role, $guard) = explode(',', $arguments.',');
				return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasRole({$role})): ?>";
			});
			$bladeCompiler->directive('elserole', function($arguments) {
				list($role, $guard) = explode(',', $arguments.',');
				return "<?php elseif( auth({$guard})->check() && auth({$guard})->user()->hasRole({$role}): ?>";
			});
			$bladeCompiler->directive('endrole', function() {
				return "<?php endif; ?>";
			});
			$bladeCompiler->directive('hasrole', function ($arguments) {
				list($role, $guard) = explode(',', $arguments.',');
				return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasRole({$role})): ?>";
			});
			$bladeCompiler->directive('endhasrole', function () {
				return '<?php endif; ?>';
			});
			$bladeCompiler->directive('hasanyrole', function ($arguments) {
				list($roles, $guard) = explode(',', $arguments.',');
				return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasAnyRole({$roles})): ?>";
			});
			$bladeCompiler->directive('endhasanyrole', function () {
				return '<?php endif; ?>';
			});
			$bladeCompiler->directive('hasallroles', function ($arguments) {
				list($roles, $guard) = explode(',', $arguments.',');
				return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasAllRoles({$roles})): ?>";
			});
			$bladeCompiler->directive('endhasallroles', function () {
				return '<?php endif; ?>';
			});
			$bladeCompiler->directive('unlessrole', function ($arguments) {
				list($role, $guard) = explode(',', $arguments.',');
				return "<?php if(!auth({$guard})->check() || ! auth({$guard})->user()->hasRole({$role})): ?>";
			});
			$bladeCompiler->directive('endunlessrole', function () {
				return '<?php endif; ?>';
			});
		});
	}
}
