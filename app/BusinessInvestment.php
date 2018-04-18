<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessInvestment extends Model
{

    public function belongstoBusiness()
    {
        return $this->belongsTo('App\BusinessListing', 'business_id');
    }

    public function getInvestmentDataByUserAndBussinessIdStatus($business_id = '', $user_id = '', $status = 'pledged')
    {

        if ($business_id != '' && $user_id != '') {
            $where_params = ['business_id' => $business_id, 'investor_id' => $user_id, 'status' => $status];
        } else if ($business_id != '') {
            $where_params = ['business_id' => $business_id, 'status' => $status];
        } else if ($user_id != '') {
            $where_params = ['investor_id' => $user_id, 'status' => $status];
        }
        $business_investment_data = BusinessInvestment::where($where_params)->get()->toArray();

        /*dd($business_investment_data);*/

        /*$business_list = \DB::table('business_listings')
        ->get();*/

        return $business_investment_data;
    }

}
