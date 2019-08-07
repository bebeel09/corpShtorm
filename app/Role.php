<?php

namespace App;

use App\Guard;
use App\Http\Traits\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Model;
use App\Http\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Http\Exceptions\RoleAlreadyExists;
use App\Http\Exceptions\RoleDoesNotExist;
use App\Http\Exceptions\GuardDoesNotMatch;

class Role extends Model implements RoleContract
{
	use HasPermissionsTrait;

	protected $guarded = ['id'];

	public function __construct(array $attributes = [])
	{
		$attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.default.guard');
		parent::__construct($attributes);
	}

	public static function create( array $attributes = [])
	{
		$attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

		if(static::where('name', $attributes['name'])->where('guard_name', $attributes['guard_name'])->first()) {
			throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
		}

		return static::query()->create($attributes);
	}

	public function permissions(): BelongsToMany
	{
		return $this->belongsToMany(Permission::class,'roles_permissions', 'role_id', 'permission_id');
	}

	public function users(): MorphToMany
	{
		return $this->morphedByMany(
			getModelForGuard($this->attributes['guard_name']), 'model', 'model_has_roles', 'role_id', 'model_morph_key'
		);
	}

	/**
	 * Find a role by its name and guard name.
	 *
	 * @param string $name
	 * @param string|null $guardName
	 *
	 * @return \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
	 *
	 * @throws \Spatie\Permission\Exceptions\RoleDoesNotExist
	 */
	public static function findByName(string $name, $guardName = null): RoleContract
	{
		$guardName = $guardName ?? Guard::getDefaultName(static::class);
		$role = static::where('name', $name)->where('guard_name', $guardName)->first();
		if (! $role) {
			throw RoleDoesNotExist::named($name);
		}
		return $role;
	}
	public static function findById(int $id, $guardName = null): RoleContract
	{
		$guardName = $guardName ?? Guard::getDefaultName(static::class);
		$role = static::where('id', $id)->where('guard_name', $guardName)->first();
		if (! $role) {
			throw RoleDoesNotExist::withId($id);
		}
		return $role;
	}

	/**
	 * Find or create role by its name (and optionally guardName).
	 *
	 * @param string $name
	 * @param string|null $guardName
	 *
	 * @return RoleContract
	 */
	public static function findOrCreate(string $name, $guardName = null): RoleContract
	{
		$guardName = $guardName ?? Guard::getDefaultName(static::class);
		$role = static::where('name', $name)->where('guard_name', $guardName)->first();
		if (! $role) {
			return static::query()->create(['name' => $name, 'guard_name' => $guardName]);
		}
		return $role;
	}
	/**
	 * Determine if the user may perform the given permission.
	 *
	 * @param string|Permission $permission
	 *
	 * @return bool
	 *
	 * @throws \Spatie\Permission\Exceptions\GuardDoesNotMatch
	 */
	public function hasPermissionTo($permission): bool
	{
		$permissionClass = $this->getPermissionClass();
		if (is_string($permission)) {
			$permission = $permissionClass->findByName($permission, $this->getDefaultGuardName());
		}
		if (is_int($permission)) {
			$permission = $permissionClass->findById($permission, $this->getDefaultGuardName());
		}
		if (! $this->getGuardNames()->contains($permission->guard_name)) {
			throw GuardDoesNotMatch::create($permission->guard_name, $this->getGuardNames());
		}
		return $this->permissions->contains('id', $permission->id);
	}
}
