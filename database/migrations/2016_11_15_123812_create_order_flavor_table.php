<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFlavorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flavour_order', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('flavour_id')->unsigned();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('flavour_id')
                ->references('id')
                ->on('flavours')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();

            $table->primary(['order_id', 'flavour_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flavour_order');
    }
}
