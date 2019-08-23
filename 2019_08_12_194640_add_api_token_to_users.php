<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiTokenToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add api_token and drop access_token
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token', 60)->unique()->nullable()->default(null);
            $table->dropColumn('access_token');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('api_token');
            $table->string('access_token');            


        });
    }
}
