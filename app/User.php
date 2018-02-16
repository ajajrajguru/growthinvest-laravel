<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use App\User;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
    
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use Notifiable, HasRoles,SoftDeletes;
 

    // protected $guard_name = 'backoffice';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFirstNameAttribute( $value ) { 
        $value = title_case( $value );      
        return $value;
    }

    public function getLastNameAttribute( $value ) { 
        $value = title_case( $value );      
        return $value;
    }

    public function displayName() { 
         return $this->first_name.' '.$this->last_name;
    }

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'firm_id');
    }

    public function registeredBy()
    {
        return $this->belongsTo('App\User', 'registered_by');
    }

    public function userData()
    {
        return $this->hasMany('App\UserData');
    }

    public function userCertification()
    {
        return $this->hasMany('App\UserHasCertification', 'user_id');
    }

    public function nomineeApplication()
    {
        return $this->hasOne('App\NomineeApplication', 'user_id');
    }

    public function userAdditionalInfo()
    {
        $userData = $this->userData()->where('data_key','additional_info')->first();
        return $userData;
    }

    public function userInvestmentAccountNumber()
    {
        $userData = $this->userData()->where('data_key','p1code')->first();
        return $userData;
    }

    public function userIntermidaiteCompInfo()
    {
        $userData = $this->userData()->where('data_key','intermediary_company_info')->first();
        return $userData;
    }

    public function userOnfidoApplicationId()
    {
        $userData = $this->userData()->where('data_key','onfido_applicant_id')->first();
        return $userData;
    }

    public function userOnfidoSubmissionStatus()
    {
        $userData = $this->userData()->where('data_key','onfido_submitted')->first();
        return $userData;
    }

    public function userOnfidoApplicationReports()
    {
        $userData = $this->userData()->where('data_key','onfido_reports')->first();
        return $userData;
    }

    public function investorNomineeApplication()
    {
        $userData = $this->nomineeApplication()->first();
        return $userData;
    }


    public function userFinancialAdvisorInfo()
    {
        $userData = $this->userData()->where('data_key','financial_advisor_info')->first();
        return $userData;
    }

    public function isCompanyWealthManager(){
        $compInfo = (!empty($this->userAdditionalInfo())) ? $this->userAdditionalInfo()->data_value : [];  
        if(isset($compInfo['typeaccount']) && $compInfo['typeaccount'] == 'Wealth Manager')
            return true;
        else
            return false; 
    }

    public function taxstructureInfo()
    {
        $userData = $this->userData()->where('data_key','taxstructure_info')->first();
        return $userData;
    }

    public function comments(){
        return $this->morphMany( 'App\Comment', 'object');
    }


    public function getActiveCertification(){
        $activeCertification = $this->userCertification()->where('active',1)->first();
        return $activeCertification;
    }

    public function getbackOfficeAccessRoleIds(){
        $roleIds = Permission::join('role_has_permissions', function ($join) {
                        $join->on('permissions.id', '=', 'role_has_permissions.permission_id')
                             ->where('permissions.name', 'backoffice_access');
                    })->pluck('role_has_permissions.role_id')->toArray();

        return $roleIds;
    }



    public function getIntermidiateUsers($cond=[]){
        $backOfficeRoleIds = $this->getbackOfficeAccessRoleIds();

        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                    })->join('roles', function ($join)use($backOfficeRoleIds) {
                        $join->on('model_has_roles.role_id', '=', 'roles.id')
                             ->where('roles.name', 'yet_to_be_approved_intermediary')->whereIn('roles.id',$backOfficeRoleIds);
                    })->where($cond)->select('users.*')->get();

        return $users; 
    }


    public function allUsers($cond=[]){
        $backOfficeRoleIds = $this->getbackOfficeAccessRoleIds();

        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                    })->join('roles', function ($join)use($backOfficeRoleIds) {
                        $join->on('model_has_roles.role_id', '=', 'roles.id')
                            ->where('roles.name','!=', 'yet_to_be_approved_intermediary')->whereIn('roles.id',$backOfficeRoleIds);
                    })->where($cond)->select('users.*')->get();

        return $users; 
      
    }


 


    public function getEntrepreneurs($cond=[]){
        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                        })->join('roles', function ($join) {
                            $join->on('model_has_roles.role_id', '=', 'roles.id')
                                ->whereIn('roles.name', ['business_owner']);
                        })
                        ->leftJoin('business_listings', function ($join) {
                                                    $join->on('users.id', '=', 'business_listings.owner_id')
                                                    ->whereIn('business_listings.type', ['proposal'])    ;                                                      
                                                })
                        ->groupBy('business_listings.owner_id')
                        ->where($cond)->select(DB::raw("GROUP_CONCAT(business_listings.title ) as business, users.*"))
                        /*->where($cond)->select("users.*")*/
                        ->get();

        return $users; 
    }




    public function getFundmanagers($cond=[]){
        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                        })->join('roles', function ($join) {
                            $join->on('model_has_roles.role_id', '=', 'roles.id')
                                        ->whereIn('roles.name', ['fundmanager']);
                        })
                        ->join('business_listings', function ($join) {
                                                    $join->on('users.id', '=', 'business_listings.owner_id')
                                                   ->whereIn('business_listings.type', ['proposal','fund']);                                                          
                                                })
                        ->groupBy('business_listings.owner_id')
                        ->where($cond)->select(DB::raw("GROUP_CONCAT(business_listings.title ) as business, users.*")) 
                        /*->where($cond)->select("users.*")*/
                        ->get();
            return $users; 
    }


    public function getInvestorUsers($cond=[]){

        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                        })->join('roles', function ($join) {
                            $join->on('model_has_roles.role_id', '=', 'roles.id')

                                ->whereIn('roles.name', ['investor','yet_to_be_approved_investor']);
                        })->where($cond)->select('users.*')->get();


        return $users; 
    }

    public function document(){
        return $this->morphMany( 'App\DocumentFile', 'object');
    }

    public function isUserAlreadyExists($email){
        $user = User::where('email','=',$email)->first();
        if ($user === null) {
           return false;
        }
        return true;
    }

    /* Get nominee application data for the nominee form download */
    public function getInvestorNomineeData()
    {
        $nomineeApplication = $this->investorNomineeApplication();

        if (!empty($nomineeApplication)) {
            $investorFai = $nomineeApplication->chargesfinancial_advisor_details;
        } else {
            $investorFai = $this->userFinancialAdvisorInfo();
            $investorFai = (!empty($investorFai)) ? $investorFai->data_value : [];

        }


        $user_info["user_role"] = title_case($this->roles()->pluck('display_name')->implode(' '));

        $user_info["display_name"] = $this->first_name.' '.$this->last_name;

        $user_info["username"] = '';

        $user_info["user_email"] = $this->email;

        //$user_info["avatar"] = get_avatar($id, 150);

        $user_avatar = '';

        $user_info['avatar_id']               = '';
        $user_info['avatar']                  = '';
        $user_info['nomineeapplication_info'] = (!empty($nomineeApplication)) ? $nomineeApplication->details : [];
        $user_info['nomineeapplication_info']['areuspersonal'] = (!empty($nomineeApplication)) ?  $nomineeApplication->is_us_person : '';
        $user_info['nomineeapplication_info']['verified'] =(!empty($nomineeApplication)) ?   $nomineeApplication->id_verification_status : '';
        $user_info['nomineeapplication_info']['sendtaxcertificateto'] = (!empty($nomineeApplication)) ?  $nomineeApplication->tax_certificate_sent_to : '';

        // //get the signature attachment id and url
        // if (isset($user_info['nomineeapplication_info']['signatureimgid'])) {

        //     $img_sign_url_src                          = get_attached_file($user_info['nomineeapplication_info']['signatureimgid'], false);
        //     @list($signimage_width, $signimage_height) = getimagesize($img_sign_url_src);
        //     $sign_url                                  = wp_get_attachment_url($user_info['nomineeapplication_info']['signatureimgid']);

        //     $user_info['nomineeapplication_info']['signature_large'] = array('imageurl' => $sign_url,
        //         'width'                                                                     => $signimage_width['width'],
        //         'height'                                                                    => $signimage_height['height'],
        //     );

        // }


        $user_info["chargesfinancial_advisor_info"] = (!empty($nomineeApplication)) ? $nomineeApplication->chargesfinancial_advisor_details:[];

        $user_info["financial_advisor_info"] = [];

        $user_info["taxfinancial_advisor_info"] = [];

        $user_info['organization_info'] = [];

        $user_info['additional_info'] = (!empty($this->userAdditionalInfo())) ? $this->userAdditionalInfo()->data_value :[];

        $user_info["ID"] = $this->id;

        return $user_info;

    }


}
