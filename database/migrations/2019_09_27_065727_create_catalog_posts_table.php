<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_posts', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('catalog_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content_json');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
            $table->index('is_published');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_posts');
    }
}
