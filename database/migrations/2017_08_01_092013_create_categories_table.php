<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_cat_id')->default(0);
            $table->char('cat_name', 255);
            $table->string('cat_icon',255);
            $table->text('cat_description')->nullable();
            $table->text('specifications')->nullable();
            $table->timestamps();
        });

        DB::table('categories')->insert([
                'id' => '1',
                'parent_cat_id' => 0,
                'cat_name' => 'UnCategorized',
                'cat_icon' => 'pe-7s-menu',
                'cat_description' => 'The Uncategorized Item will be here'
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
