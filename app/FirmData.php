<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FirmData extends Model
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
    protected $fillable = ['firm_id', 'data_key', 'data_value'];

    /**
     * { function_description }
     *
     * @param      <type>  $firm_metas  The firm metas
     * @param      <type>  $firmid      The firmid
     */
    public function insertUpdateFirmdata($firm_metas, $firmid)
    {
        foreach ($firm_metas as $key => $value) {
            FirmData::updateOrCreate(['data_key' => $key,
                'firm_id'                       => $firmid],
                ['data_value' => serialize($value) ]);

        }

    }


    public function getFirmmetas($where_cond){

        $firmm_metas = DB::table('firm_datas')->where($where_cond)->get();
        return $firmm_metas;
    }

    
    public function getDataValueAttribute( $value ) { 
        $value = @unserialize( $value );
         
        return $value;
    }

}
