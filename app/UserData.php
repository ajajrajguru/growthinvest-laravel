<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDataValueAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setDataValueAttribute( $value ) { 
		$this->attributes['data_value'] = serialize( $value );

	}
}
