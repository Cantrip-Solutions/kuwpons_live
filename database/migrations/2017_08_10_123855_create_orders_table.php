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
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pro_id_fk')->unsigned();
            $table->foreign('pro_id_fk')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('u_id_fk')->unsigned();
            $table->foreign('u_id_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('trans_id_fk')->unsigned();
            $table->foreign('trans_id_fk')->references('id')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('billing_address');
            $table->string('shipping_address');
            $table->integer('amount');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->string('invoice_path');
            $table->enum('status',['0','1','2','3','4','5','6','7','8'])->default('0')->comment("0=>PENDING 1=>PROCESSING 2=>DISPATCHED 3=>DELIVERED 4=>REFUND REQUEST 5=>PRODUCT RECEIVED 6=>REFUNDED 7=>REPLACEMENT REQUEST 8=>REPLACED");
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
