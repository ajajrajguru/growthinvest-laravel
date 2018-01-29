<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessHasDefaults extends Model
{
    public function business()
    {
        return $this->belongsTo('App\BusinessListing','business_id');
    }

    public function default()
    {
        return $this->belongsTo('App\Defaults','default_id');
    }

    public function getDataValueAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setDataValueAttribute( $value ) { 
		$this->attributes['data_value'] = serialize( $value );

	}
}
