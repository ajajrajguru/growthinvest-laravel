<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessListing extends Model
{
    protected $table = 'business_listings';

    public function getBusinessList($args)
    {

        if ($args['backoffice'] == true) {

            $business_list = BusinessListing::all();

            /*$business_list = \DB::table('business_listings')
            ->get();*/

            return $business_list;
        }

    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function businessListingData()
    {
        return $this->hasMany('App\BusinessListingData', 'business_id');
    }

    public function businessDefaults()
    {
        return $this->hasMany('App\BusinessHasDefault', 'business_id');
    }

    public function getBusinessApprover()
    {

    }
    public function getBusinessMilestones()
    {

    }

    public function getBusinessDefaultsByBizId($business_id = "", $where_args = [])
    {
        $business_default_data = [];

        if ($business_id == "") {

            $business_listing = $this;
            if ($this->id == "" || is_null($this->id) || !isset($this->id)) {
                return false;
            }

            $business_id = $this->id;
        } else {
            $business_listing = BusinessListing::where('id', $business_id)->first();
        }

        if (count($where_args > 0)) {
            $business_defaults = $business_listing->businessDefaults()->where($where_args)->get();
        } else {
            $business_defaults = $business_listing->businessDefaults()->get();
        }

        foreach ($business_defaults as $biz_default) {

            $default_data            = $biz_default->belongsDefault->toArray();
            $business_default_data[] = $default_data;

        }

        $price = array_get($business_default_data, 'products.desk.price');

        return $business_default_data;

    }
    public function getDefaultFromDefaultsArByType($business_default_ar, $type)
    {
        if (!isset($business_default_ar) && !isset($type)) {
            return false;
        }

        $filtered = array_where($business_default_ar, function ($value, $key) use ($type) {

            if ($value['type'] == $type) {
                return $value;
            }

        });
        return $filtered;
    }

    public function getApproversFromDefaultAr($business_default_ar)
    {
        $approvers = $this->getDefaultFromDefaultsArByType($business_default_ar, 'approver');
        return $approvers;
    }

    public function getMilestonesFromDefaultAr($business_default_ar)
    {
        $milestones = $this->getDefaultFromDefaultsArByType($business_default_ar, 'milestone');
        return $milestones;

    }

    public function getStagesOfBusinessFromDefaultAr($business_default_ar)
    {
        $stages_of_business = $this->getDefaultFromDefaultsArByType($business_default_ar, 'stage_of_business');
        return $stages_of_business;

    }

}
