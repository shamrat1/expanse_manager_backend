<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 192)->nullable();
			$table->string('username', 191)->nullable();
			$table->string('email', 192)->nullable();
			$table->string('phone', 192)->nullable();
			$table->string('country', 192)->nullable();
			$table->string('city', 192)->nullable();
			$table->string('province', 192)->nullable();
			$table->string('zipcode', 192)->nullable();
			$table->string('address', 192)->nullable();
			$table->string('gender', 192)->nullable();
			$table->string('avatar', 192)->nullable()->default('no_avatar.png');
			$table->date('birth_date')->nullable();
			$table->boolean('total_leave')->nullable()->default(0);
			$table->decimal('hourly_rate', 10)->nullable()->default(0.00);
			$table->decimal('basic_salary', 10)->nullable()->default(0.00);
			$table->string('employment_type', 192)->nullable()->default('full_time');
			$table->date('leaving_date')->nullable();
			$table->string('marital_status', 192)->nullable()->default('single');
			$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
