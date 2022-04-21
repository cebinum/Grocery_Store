<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->integer('user_id');
            $table->enum('status', ['pending', 'received', 'order_in_process', 'delivery_in_progress', 'package_delivered'])->default('pending');
            $table->decimal('grand_total', 20, 6);
            $table->decimal('delivery_charges', 20, 6);
            $table->boolean('payment_status')->default(0);
            $table->string('mode_of_delivery')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
