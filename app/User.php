<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use App\User;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'firm_id');
    }

    public function userData()
    {
        return $this->hasMany('App\UserData');
    }

    public function userCertification()
    {
        return $this->hasMany('App\UserHasCertification');
    }

    public function userAdditionalInfo()
    {
        $addionalData = $this->userData()->where('data_key','additional_info')->first();
        return $addionalData;
    }

    public function userIntermidaiteCompInfo()
    {
        $addionalData = $this->userData()->where('data_key','intermediary_company_info')->first();
        return $addionalData;
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
        $addionalData = $this->userData()->where('data_key','taxstructure_info')->first();
        return $addionalData;
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


    public function getInvestorUsers($cond=[]){
        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                        })->join('roles', function ($join) {
                            $join->on('model_has_roles.role_id', '=', 'roles.id')
                                ->where('roles.name', 'investor');
                        })->where($cond)->select('users.*')->get();

        return $users; 
    }


}
