<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessListing extends Model
{
    protected $table = 'business_listings';

    public function getTaxStatusAttribute( $value ) { 
        $value = json_decode( $value );
        $value = array_map('strtoupper', $value);
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
    public function businessInvestmentsData()
    {
        return $this->hasMany('App\BusinessInvestment', 'business_id');
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

   public function getAllNextProposalRounds($business_id,$parent_id)
    {
        //\DB::enableQueryLog();        
        //->where('business_listings.id','!=',$parent_id)
        $business_rounds = BusinessListing::where(['business_listings.parent' => $parent_id,'business_listings.status'=>'publish'])->leftJoin('business_investments as bi1', function ($join) use($parent_id) {
        $join->on('business_listings.id', '=', 'bi1.business_id')->where('bi1.status','pledged')->groupBy('bi1.business_id');
        })
        ->leftJoin('business_investments as bi2', function ($join) use($parent_id) {
        $join->on('business_listings.id', '=', 'bi2.business_id')->where('bi2.status','funded')->groupBy('bi1.business_id');
        })
        ->leftJoin('business_investments as bi3', function ($join) use($parent_id) {
        $join->on('business_listings.id', '=', 'bi3.business_id')->where('bi3.status','watchlist')->groupBy('bi1.business_id');
        })
        ->leftJoin('business_investments as bi4', function ($join) use($parent_id) {
        $join->on('business_listings.id', '=', 'bi4.business_id')->whereIn('bi4.status',['funded','pledged'])->groupBy('bi1.business_id');
        })
        ->leftJoin('comments as comments', function ($join) use($parent_id) {
        $join->on('business_listings.id', '=', 'comments.object_id')->where('comments.object_type','App/BusinessListing')->groupBy('comments.object_id','comments.object_type');
        })->select(\DB::raw("count(bi1.id) as pledge_count, count(bi2.id) as funded_count, count(bi3.id) as watchlist_count, count(comments.id) as comments_count, SUM(bi4.amount) as fund_raised, business_listings.id as business_id, business_listings.title as business_title, business_listings.slug as business_slug, business_listings.round as biz_round, business_listings.type as type"))->get();
        ;



        /*$business_rounds = BusinessListing::where(['business_listings.parent' => $parent_id])->select(\DB::raw(" business_listings.id as business_id, business_listings.title as business_title, business_listings.slug as business_slug"))->get();
                ;
        /*dd(\DB::getQueryLog());*/
       // dd($business_rounds);
        return $business_rounds;
    } 


    public function getBusinessDefaultsData(){
        $businessDefaults = $this->businessDefaults()->get(); 
        $data = [];
        foreach ($businessDefaults as $key => $businessDefault) {
            $defaultData = $businessDefault->belongsDefault;
            $data[$defaultData->type][] = $defaultData->name;
        }

        return $data;
    }

    public function businessFundType(){
        $businessListingData = $this->businessListingData()->where('data_key','fund_typeoffund')->first();
        $fundType = (!empty($businessListingData)) ? $businessListingData->data_value :'';
        $fundType = str_replace('_', ' ', $fundType);


        return $fundType;
    }

    public function businessInvestmentStrategy(){
        $businessListingData = $this->businessListingData()->where('data_key','investmentstrategy')->first();
        $investmentStrategy = (!empty($businessListingData)) ? $businessListingData->data_value :'';
        $investmentStrategy = strtoupper($investmentStrategy);


        return $investmentStrategy;
    }

    public function businessFundVctDetails(){
        $businessListingData = $this->businessListingData()->where('data_key','fundvct_details')->first();
        $fundvctDetails = (!empty($businessListingData)) ? unserialize($businessListingData->data_value) :[];
    
        return $fundvctDetails;
    }


    public function businessFundCloseDate(){
        $businessListingData = $this->businessListingData()->where('data_key','fund_closedate')->first();
        $closedate = (!empty($businessListingData)) ? $businessListingData->data_value :'';
    
        return $closedate;
    }

    public function businessProposalDetails(){
        $businessListingData = $this->businessListingData()->where('data_key','proposal_details')->first();
        $data = (!empty($businessListingData)) ?  unserialize($businessListingData->data_value) :[];
        
        return $data;
    }

    public function businessAicSector(){
        $businessListingData = $this->businessListingData()->where('data_key','aicsector')->first();
        $data = (!empty($businessListingData)) ?  unserialize($businessListingData->data_value) :[];
        
        return $data;
    }






}
