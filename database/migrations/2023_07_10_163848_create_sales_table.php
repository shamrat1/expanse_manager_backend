<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
			$table->integer('user_id')->nullable()->index('user_id_sales');
			$table->date('date')->nullable();
			$table->string('ref', 192)->nullable();
			$table->integer('customer_id')->nullable()->index('sale_customer_id');
			$table->integer('quantity')->nullable();
			$table->float('rate', 10, 0)->nullable()->default(0);
			$table->float('shipping', 10, 0)->nullable()->default(0);
			$table->float('total_amount', 10, 0)->default(0);
			$table->float('discount', 10, 0)->nullable()->default(0);
			$table->float('total_payment', 10, 0)->default(0);
			$table->float('paid', 10, 0)->default(0);
			$table->float('due', 10, 0)->default(0);
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
        Schema::dropIfExists('sales');
    }
}
