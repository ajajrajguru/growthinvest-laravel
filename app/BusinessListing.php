<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessListing extends Model
{
    protected $table = 'business_listings';

    public function getTaxStatusAttribute( $value ) { 
        $value = json_decode( $value );
         
        return $value;
    }

    public function setTaxStatusAttribute( $value ) { 
        $this->attributes['tax_status'] = json_encode( $value );

    }


    public function getBusinessList($args)
    {

        if ($args['backoffice'] == true) {

            if($args['invest_listings']==true){
                $business_list = BusinessListing::where('invest_listing','yes')->get();    
            }
            else{
                $business_list = BusinessListing::all();
            }
            

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

    public function getBusinessSectorsFromDefaultAr($business_default_ar)
    {
        $business_sectors = $this->getDefaultFromDefaultsArByType($business_default_ar, 'business-sector');
        return $business_sectors;

    }


    public function getDisplayBusinessStatus($business_status)
    {

        switch ($business_status) {
            case 'awaiting_inputs':
                $display_business_status = "Awaiting Business Owner Inputs";
                break;
            case 'early_stage':
                $display_business_status = "Marked as Incubator";
                break;
            case 'listed':
                $display_business_status = "Listed on Platform";
                break;
            case 'fund_raised':
                $display_business_status = "Fund Raised";
                break;
            case 'pending_review':
                $display_business_status = "Pending Review";
                break;
            case 'reject':
                $display_business_status = "Rejected";
                break;
            case 'archive':
                $display_business_status = "Archived";
                break;
            default:
                $display_business_status = "Pending Review";
                break;

        }
        return $display_business_status;

    }

    public function getCompanyNames(){
        $businessListingQuery = BusinessListing::where('invest_listing', 'yes')->where('status', 'publish')->get();


        return $businessListingQuery;
    }

   /* public function getAllNextProposalRounds($firm_id)
    {

        $first             = Firm::where(['parent_id' => $firm_id])->pluck('id')->all();
        $this->next_business_rounds = array_merge($this->next_business_rounds, $first);

        if (count($first > 0)) {
            foreach ($first as $value) {

                $this->getAllNextProposalRounds($value);
            }
        }

        /*DB::table('users')
        ->whereIn('parent_id');

        $parent_firms = Firm::where(['parent_id' => $firm_id])->orderBy('name', 'asc')->get()* /;
        return $this->next_business_rounds;
    }*/



}
