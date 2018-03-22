<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function meta()
    {
        return $this->hasMany('App\ActivityMeta', 'activity_id');
    }
}
