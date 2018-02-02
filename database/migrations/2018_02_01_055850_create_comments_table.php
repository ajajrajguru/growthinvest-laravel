<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('data');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_url');
            $table->string('author_ip');
            $table->integer('user_id');
            $table->integer('object_id');
            $table->string('object_type', '50');            
            $table->string('type', '150')->nullable();            
            $table->integer('parent');
            $table->string('approved', 50);
            $table->string('send_mail_button');
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
        Schema::dropIfExists('comments');
    }
}
