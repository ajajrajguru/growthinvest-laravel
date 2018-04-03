<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityGroup extends Model
{
    protected $table = 'activity_group';

    public function getActivityTypeValueAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setActivityTypeValueAttribute( $value ) { 
		$this->attributes['activity_type_value'] = serialize( $value );

	}
}
