<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasCertification extends Model
{
   	public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function certification()
    {
        return $this->hasOne('App\Defaults', 'certification_default_id');
    }

    public function getDetailsAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setDetailsAttribute( $value ) { 
		$this->attributes['details'] = serialize( $value );

	}

    
}
