<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defaults extends Model
{
    //
	public function hasQuestionnaire()
    {
        return $this->hasMany('App\CertificationQuestionaire','certification_default_id');
    }

    function getCertificationQuesionnaire(){
	    $questionnaires = $this->hasQuestionnaire()->orderBy('certification_default_id','asc')->orderBy('order','asc')->get();

	    return $questionnaires;
	}
}
