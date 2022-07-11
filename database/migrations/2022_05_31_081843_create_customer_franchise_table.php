<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFranchiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_franchise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('franchise_id')->constrained()->onDelete('cascade');
            $table->float('amount',8,2);
            $table->float('discount',8,2);
            $table->float('concession',8,2);
            $table->float('due',8,2);
            $table->string('payment_option')->default('installment');
            $table->string('payment_status');
            $table->date('service_taken');
            $table->date('service_ends');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('customer_franchise');
    }
}
