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
            $table->increments('id');
            $table->string('login_id');
            $table->string('email')->unique();
            $table->string('avatar');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->integer('status');
            $table->integer('registered_by');
            $table->string('telephone_no');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->string('postcode');
            $table->string('county');
            $table->string('country');
            $table->integer('firm_id');
            $table->string('gi_code');
            $table->timestamp('terms_n_condi_date');
            $table->integer('deleted');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
