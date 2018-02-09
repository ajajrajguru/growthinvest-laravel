<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\BusinessListing;

class AllerBusinessListing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_listings', function (Blueprint $table) {
            $table->json('taxstatus');
        });

        BusinessListing::all()->each(function($businessListing) {  
            $businessListing->taxstatus = $businessListing->tax_status;
            $businessListing->save(); 
             
        });

        Schema::table('business_listings', function (Blueprint $table) {
            $table->dropColumn('tax_status');
        });

        Schema::table('business_listings', function (Blueprint $table) {
            $table->renameColumn('taxstatus', 'tax_status');
        });

 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
