<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            //
            Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            $table->enum('gender',['M','F','O'])->default('O')->after('name');
            $table->string('dob')->nullable()->after('gender');
            $table->string('address1')->nullable()->change();
            $table->string('postal_code')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('country')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            //
            $table->dropColumn('dob');
            $table->dropColumn('gender');

        });
    }
}
