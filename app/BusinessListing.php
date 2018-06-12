<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ajency\FileUpload\FileUpload;
use App\BusinessHasDefault;

class BusinessListing extends Model
{
    use FileUpload;
    protected $table = 'business_listings';

    public function getTaxStatusAttribute( $value ) { 
        $value = json_decode( $value );
        $value = (!empty($value)) ? array_map('strtoupper', $value) :[];
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

    public Function getBusinessLogo($type){
        $hasImage = false;
        $businessLogo  = getDefaultImages('business_logo');
        $businessLogos = $this->getImages('business_logo'); 
        foreach ($businessLogos as $key => $logo) { 
            if(isset($logo[$type])) {
                $businessLogo = $logo[$type];
                $hasImage = true;
            }
        }


        return ['url'=>$businessLogo,'hasImage'=>$hasImage]; 
    }

    public Function getBusinessBackgroundImage($type){
        $hasImage = false;
        $backgroundImage  = getDefaultImages('background_image');
        $backgroundImages = $this->getImages('business_background_image'); 
        foreach ($backgroundImages as $key => $image) { 
            if(isset($image[$type])) {
                $backgroundImage = $image[$type];
                $hasImage = true;
            }
        }


        return ['url'=>$backgroundImage,'hasImage'=>$hasImage]; 
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

    public function businessVideos()
    {
        return $this->hasMany('App\BusinessVideo', 'business_id');
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
        $aicsector = aicSectors();
        $businessListingData = $this->businessListingData()->where('data_key','aicsector')->first(); 
        $data = (!empty($businessListingData) && isset($aicsector[$businessListingData->data_value])) ?  $aicsector[$businessListingData->data_value] :'';
        
        return $data;
    }


    /**
    get business data  
     */

    public function getBusinessSectionStatus(){
       return $this->businessListingData()->where('data_key','business_section_status')->first(); 
    }

     public function getBusinessIdeas(){
       return $this->businessListingData()->where('data_key','business_ideas')->first(); 
    }


    public function getBusinessProposalDetails(){
       return $this->businessListingData()->where('data_key','business_proposal_details')->first(); 
    }

    public function getBusinessHmrcStatus(){
       return $this->businessListingData()->where('data_key','hmrc_status')->first(); 
    }

    public function getFundingRequirement(){
       return $this->businessListingData()->where('data_key','funding_requirement')->first(); 
    }

    public function getFinancials(){
       return $this->businessListingData()->where('data_key','financials')->first(); 
    }

    public function getTeamMembers(){
       return $this->businessListingData()->where('data_key','team_members')->first(); 
    }

    public function getTeamMemberDetails(){
       return $this->businessListingData()->where('data_key','team_members')->first(); 
    }

    public function getCompanyDetails(){
       return $this->businessListingData()->where('data_key','company_details')->first(); 
    }

    public function getDocumentUpload(){
       return $this->businessListingData()->where('data_key','document_upload')->first(); 
    }

    public function getDueDeligence(){
       return $this->businessListingData()->where('data_key','due_deligence')->first(); 
    }

    public function getBusinessSectors(){
        $businessSectors = BusinessHasDefault::select('business_has_defaults.*')->join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->where('defaults.type', 'business-sector')->where('business_has_defaults.business_id', $this->id)->get();
        return $businessSectors;
    }

    public function getBusinessMilestone(){  
        $businessMilestone =BusinessHasDefault::join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->where('defaults.type', 'milestone')->where('business_has_defaults.business_id', $this->id)->get();
        return $businessMilestone;
    }

    public function getBusinessStage(){      
        $businessStage = BusinessHasDefault::select('business_has_defaults.*')->join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->where('defaults.type', 'stage_of_business')->where('business_has_defaults.business_id', $this->id)->first();

        return $businessStage;
    }

    public function keyFinancialMetrics(){
       return $this->businessListingData()->where('data_key','key_financial_metrics')->first(); 
    }

    public function companyFinancialSnapshot(){
       return $this->businessListingData()->where('data_key','company_financial_snapshot')->first(); 
    }

    public function shareOwnershipInfo(){
       return $this->businessListingData()->where('data_key','share_structure_and_ownership_info')->first(); 
    }

    public function dueDeligenceCompanyDetails(){
       return $this->businessListingData()->where('data_key','due_deligence_company_details')->first(); 
    }

    public function investmentBusinessQuestionnaire(){
       return $this->businessListingData()->where('data_key','tier1_investment_business_questionnaire')->first(); 
    }

    public function tier1CompanyInformation(){
       return $this->businessListingData()->where('data_key','tier1_company_information')->first(); 
    }

    public function tier1EmployeeInformation(){
       return $this->businessListingData()->where('data_key','employee_information')->first(); 
    }

    public function tier1FinancialInformation(){
       return $this->businessListingData()->where('data_key','tier1_financial_information')->first(); 
    }

    public Function getTier1Document(){
        $hasFile = false;
        $files = $this->getFiles('tier1_document'); 
        $fileUrl =  '';
        $fileid =  '';
        $filesData = [];
        foreach ($files as $key => $file) { 
            $fileid = $file['id'];
            $filename = $file['name'];
            $fileUrl = $file['url'];
            $hasFile = true;
            $filesData[] = ['url'=>$fileUrl,'name'=>$filename,'fileid'=>$fileid,'hasFile'=>$hasFile]; 
             
        }

        return $filesData;
    }

    public Function getMemberPicture($member,$type){
        $hasImage = false;
        $profilePic  = getDefaultImages('member_picture');
        $profilePicImages = $this->getImages($member); 
        foreach ($profilePicImages as $key => $image) { 
            if(isset($image[$type])) {
                $profilePic = $image[$type];
                $hasImage = true;
            }
        }

        return ['url'=>$profilePic,'hasImage'=>$hasImage];
    }




    public Function getBusinessMultipleFile($type){
        $hasFile = false;
        $files = $this->getFiles($type); 
        $fileUrl =  '';
        $fileid =  '';
        $filesData = [];
        foreach ($files as $key => $file) { 
            $fileid = $file['id'];
            $filename = $file['name'];
            $fileUrl = $file['url'];
            $hasFile = true;
            $filesData[] = ['url'=>$fileUrl,'name'=>$filename,'fileid'=>$fileid,'hasFile'=>$hasFile]; 
             
        }

        return $filesData;
    }

    public Function getAllBusinessFile(){

        $files = $this->getAllFilesByType();  
        
        return $files;
    }
 
 





}
