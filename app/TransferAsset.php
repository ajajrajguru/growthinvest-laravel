<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ajency\FileUpload\FileUpload;

class TransferAsset extends Model
{
    use FileUpload;
	public function company()
    {
        return $this->belongsTo('App\Company','companyid');
    }

    public function investor()
    {
        return $this->belongsTo('App\User','investor_id');
    }

    public function getDetailsAttribute( $value ) {
        $value = unserialize( $value );  
         
        return $value;
    }

	public function setDetailsAttribute( $value ) { 
		$this->attributes['details'] = serialize( $value );

	}

    public function transferAssetMeta()
    {
        return $this->hasMany('App\TransferAssetMeta','transfer_id');
    }

    

     
}
