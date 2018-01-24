<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificationQuestionaire extends Model
{
    public function getOptionsAttribute( $value ) { 
        $value = json_decode( $value );
         
        return $value;
    }
}
