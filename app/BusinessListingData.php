<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BusinessListingData extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var        array
     */
    protected $fillable = ['business_id', 'data_key', 'data_value']; 
   

}
