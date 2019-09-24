<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('login')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('sur_name');
            $table->string('last_name');
            $table->string('mobile_phone');
            $table->string('work_phone');

            $table->integer('region_id')->unsigned();
            $table->integer('office_id')->unsigned();
            $table->integer('department_id')->unsigned();
            
            $table->string('position');
            $table->string('avatar')->default('');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('department_id')->references('id')->on('departments');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
