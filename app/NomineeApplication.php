<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NomineeApplication extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDetailsAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setDetailsAttribute( $value ) { 
		$this->attributes['details'] = serialize( $value );

	}

	public function getChargesfinancialAdvisorDetailsAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setChargesfinancialAdvisorDetailsAttribute( $value ) { 
		$this->attributes['chargesfinancial_advisor_details'] = serialize( $value );

	}

	public function getFinancialAdvisorDetailsAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setFinancialAdvisorDetailsAttribute( $value ) { 
		$this->attributes['financial_advisor_details'] = serialize( $value );

	}

	
}
