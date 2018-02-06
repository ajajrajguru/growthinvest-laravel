<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;

class Comment extends Model
{
    public function commentObj()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function commentedOn($format=1){
        $date = '';

        if(!empty($this->created_at)){

            if($format==1)
                $date = date('dS M Y', strtotime(str_replace('-','/', $this->created_at)));
            elseif($format==2)
                $date = date('h:i A', strtotime(str_replace('-','/', $this->created_at)));
            elseif($format==3){
                $dateFormat = date('d-m-Y ~*~ h:i A', strtotime(str_replace('-','/', $this->created_at)));
                $splitDate = explode('~*~', $dateFormat);
                $date = $splitDate[0].'<br>'.$splitDate[1];

            }
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->created_at)));

        }

        return $date;
      
    }

     



}
