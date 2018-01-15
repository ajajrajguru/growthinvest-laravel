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
            $table->string('login_id')->nullable(); 
            $table->string('email')->unique();
            $table->string('avatar')->nullable(); 
            $table->string('title')->nullable(); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->integer('status');
            $table->integer('registered_by');
            $table->string('telephone_no')->nullable(); 
            $table->string('address_1')->nullable(); 
            $table->string('address_2')->nullable(); 
            $table->string('city')->nullable();
            $table->string('postcode')->nullable(); 
            $table->string('county')->nullable(); 
            $table->string('country')->nullable(); 
            $table->integer('firm_id')->unsigned()->nullable(); 
            $table->string('gi_code');
            $table->timestamp('terms_n_condi_date')->nullable(); 
            $table->integer('deleted')->nullable(); 
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
