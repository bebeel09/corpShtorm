<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('guard_name')->nullable();
			$table->timestamps();
		});

		Schema::create('roles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('guard_name')->nullable();
			$table->timestamps();
		});

		Schema::create('model_has_permissions', function (Blueprint $table) {

			$table->unsignedInteger('permission_id');

			$table->string('model_type');
			$table->unsignedBigInteger('model_id');
			$table->index(['model_id', 'model_type', ]);

			$table->foreign('permission_id')
				->references('id')
				->on('permissions')
				->onDelete('cascade');

			$table->primary(['permission_id', 'model_id', 'model_type'],
				'model_has_permissions_permission_model_type_primary');

		});

		Schema::create('model_has_roles', function (Blueprint $table) {
			$table->unsignedInteger('role_id');

			$table->string('model_type');
			$table->unsignedBigInteger('model_id');
			$table->index(['model_id', 'model_type', ]);

			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onDelete('cascade');

			$table->primary(['role_id', 'model_id', 'model_type'],
				'model_has_roles_role_model_type_primary');
		});

		Schema::create('role_has_permissions', function (Blueprint $table) {
			$table->unsignedInteger('permission_id');
			$table->unsignedInteger('role_id');

			$table->foreign('permission_id')
				->references('id')
				->on('permissions')
				->onDelete('cascade');

			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onDelete('cascade');

			$table->primary(['permission_id', 'role_id']);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Drop old
		Schema::dropIfExists('role_user');
		//Drop new
		Schema::dropIfExists('role_has_permissions');
		Schema::dropIfExists('model_has_roles');
		Schema::dropIfExists('model_has_permissions');
		Schema::dropIfExists('roles');
		Schema::dropIfExists('permissions');
	}
}
