<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->timestamps();

            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("todo_categories",function(Blueprint $table){
            $table->dropForeign('todo_categories_created_by_id_foreign');
        });
        Schema::dropIfExists('todo_categories');
    }
}