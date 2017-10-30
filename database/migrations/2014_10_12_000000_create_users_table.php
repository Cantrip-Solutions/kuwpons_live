<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email', 128)->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->enum('u_role',['A', 'S', 'U'])->default('U')->comment('A=Admin , S=Company user , U=User or consumer');
            $table->text('notes')->nullable();
            $table->enum('status',['1','0','2'])->default('1')->comment('1=>ACTIVE,0=>INACTIVE,2=>SUSPEND');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
                'id' => '1',
                'name' => 'Admin',
                'email' => 'dipankar.cantripsolutions@gmail.com',
                'password' => '$2y$10$pFg1WNtYrInlYXYibGp7B.Q722v23e98hO3VDKSZzVif9Hy4.467C',
                'u_role' => 'A'
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
        Schema::dropIfExists('users');
    }
}
