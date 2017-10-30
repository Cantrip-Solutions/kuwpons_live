<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('mid')->comment('module id it can be category Id or product Id');
            $table->enum('module',['C','P'])->comment('C=>category,p=>product');
            $table->integer('discount_per')->deafult('0');
            $table->string('image')->nullable();
            $table->dateTime('started_on');
            $table->dateTime('expire_on');
            $table->text('rules')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['0','1'])->default('0')->comment('0=>Active,p=>Not Active');
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
        Schema::dropIfExists('product_discounts');
    }
}
