<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityMeta extends Model
{
    protected $table = 'activity_meta';

    public function activity()
    {
        return $this->belongsTo('App\Activity','activity_id');
    }

    public function getMetaValueAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setMetaValueAttribute( $value ) { 
		$this->attributes['meta_value'] = serialize( $value );

	}
}
