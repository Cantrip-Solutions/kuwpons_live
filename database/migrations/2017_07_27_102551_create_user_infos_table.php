<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('u_id_fk')->unsigned();
            $table->foreign('u_id_fk')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('email',128);
            $table->string('name');
            $table->string('phone',111);
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('postal_code', 111);
            $table->string('city',111)->nullable();
            $table->string('state',111);
            $table->string('country',111);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('u_details')->nullable();
            $table->tinyInteger('default_address_flag')->default('0');
            $table->timestamps();
        });

        DB::table('user_infos')->insert([
                'id' => '1',
                'u_id_fk' => '1',
                'email' => 'dipankar.cantripsolutions@gmail.com',
                'name' => 'Admin',
                'phone' => '8617293778',
                'address1' => 'Address 1',
                'address2' => 'Address 2',
                'postal_code' => '123456',
                'city' => 'Kolkata',
                'state' => 'West Bengal',
                'country' => 'India',
                'default_address_flag' => '1'
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
        Schema::dropIfExists('user_infos');
    }
}
