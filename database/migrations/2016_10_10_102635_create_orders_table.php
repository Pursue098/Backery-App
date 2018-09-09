<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('cust_name');
            $table->string('cust_email')->nullable();
            $table->string('cust_address')->nullable();
            $table->string('cust_phone')->nullable();
            $table->string('weight');
            $table->string('quantity');
            $table->string('price');
            $table->string('advance_price')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('order_type')->nullable();
            $table->boolean('order_status');
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->string('token_code')->nullable();
            $table->string('token_no')->nullable();
            $table->string('token_expiry_date')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('branch_id')->unsigned();
            $table->string('branch_code');
            $table->integer('user_id')->unsigned();
            $table->boolean('active');
            $table->boolean('priority');
            $table->string('image');

            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users');

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
