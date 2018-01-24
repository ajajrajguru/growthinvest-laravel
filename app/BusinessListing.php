<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessListing extends Model
{
    protected $table = 'business_listings';


    public function getBusinessList($args){

    	if($args['backoffice']==true){

    		//$business_list = BusinessListing::all();

    		$business_list = \DB::table('business_listings')                
                ->get();

    		return $business_list;
    	}

    }

}
