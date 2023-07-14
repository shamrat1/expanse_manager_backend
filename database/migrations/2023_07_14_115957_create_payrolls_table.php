<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->nullable();
            $table->string('month',15);
            $table->decimal('pay',15,2)->nullable();
            $table->integer('total_worked_days')->nullable();
            $table->decimal('overtime_rate',15,2)->nullable();
            $table->integer('total_overtime_days')->nullable();
            $table->decimal('overtime_pay',15,2)->nullable();
            $table->decimal('gross_pay',15,2)->nullable();
            $table->decimal('deductibles',15,2)->nullable();
            $table->decimal('net_pay',15,2)->nullable();
            $table->decimal('paid',15,2)->nullable();
            $table->decimal('due',15,2)->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
