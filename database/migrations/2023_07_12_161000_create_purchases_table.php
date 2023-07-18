<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('company_id')->nullable();
            $table->bigInteger('user_id')->nullable();
			$table->date('date')->nullable();
			$table->string('ref', 192)->nullable();
			$table->bigInteger('supplier_id')->nullable();
			$table->integer('quantity')->nullable();
			$table->decimal('rate', 15, 0)->nullable();
			$table->decimal('shipping', 15, 0)->nullable();
			$table->decimal('total_amount', 15, 0)->nullable();
			$table->decimal('discount', 15, 0)->nullable();
			$table->decimal('total_payment', 15, 0)->nullable();
			$table->decimal('paid', 15, 0)->nullable();
			$table->decimal('prev_due', 15, 0)->nullable();
			$table->decimal('due', 15, 0)->nullable();
			$table->text('notes')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
