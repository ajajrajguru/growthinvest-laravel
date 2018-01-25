<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); 
            $table->string('file_url')->nullable(); 
            $table->integer('uploaded_by')->unsigned()->nullable(); 
            $table->string('document_type')->nullable(); 
            $table->integer('object_id')->unsigned()->nullable(); 
            $table->string('object_type')->nullable();  
            $table->integer('folder_id')->unsigned()->nullable(); 
            $table->timestamps();

            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_files');
    }
}
