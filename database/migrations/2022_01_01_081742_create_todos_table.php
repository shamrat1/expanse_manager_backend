<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id')->nullable();
            $table->string('task');
            $table->string('note')->nullable();
            $table->dateTime('reminder_at')->nullable();
            $table->unsignedInteger('created_by_id');
            $table->timestamps();

            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("todos",function(Blueprint $table){
            $table->dropForeign('todos_created_by_id_foreign');
            $table->dropForeign('todos_category_id_foreign');
        });
        Schema::dropIfExists('todos');
    }
}
