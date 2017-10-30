<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('u_id_fk')->unsigned();
            $table->foreign('u_id_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('cat_id_fk')->unsigned();
            $table->foreign('cat_id_fk')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->integer('original_price');
            $table->integer('saling_price');
            $table->integer('quantity');
            $table->text('description');
            $table->dateTime('expire_on');
            $table->text('tag')->nullable();
            $table->text('specification')->nullable();
            $table->enum('isdelete',['0','1'])->default('0')->comment('0=> Active, 1=> Deleted');
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
        Schema::dropIfExists('products');
    }
}
