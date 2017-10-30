<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedeemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pro_id_fk')->unsigned();
            $table->foreign('pro_id_fk')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('o_id_fk')->unsigned();
            $table->foreign('o_id_fk')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('u_id_fk')->unsigned();
            $table->foreign('u_id_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('coupon_code');
            $table->enum('status',['0','1'])->default('0')->comment('0=> Not Redeemed, 1=> Redeemed');
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
        Schema::dropIfExists('redeems');
    }
}
