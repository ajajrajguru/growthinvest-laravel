<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessInvestment extends Model
{
    public function belongstoBusiness()
    {
        return $this->belongsTo('App\BusinessListing','business_id');
    } 
   
    
}
