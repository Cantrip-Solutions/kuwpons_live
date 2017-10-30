<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('menu_id');
            $table->integer('parent_id');
            $table->char('menu_name', 255);
            $table->char('menu_page', 255);
            $table->char('icon', 255);
            $table->enum('fixed', ['0','1'])->default('0');
            $table->enum('admin_access', ['YES','NO'])->default('YES');
            $table->enum('vendor_access', ['YES','NO'])->default('NO');
            $table->enum('buyer_access', ['YES','NO'])->default('NO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
