<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use App\User;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

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

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'firm_id');
    }

    public function userData()
    {
        return $this->hasMany('App\UserData');
    }

    public function userAdditionalInfo()
    {
        $addionalData = $this->userData()->where('data_key','additional_info')->first();
        return (empty($addionalData))? [] : $addionalData->data_value;
    }

    

    public function getIntermidiateUsers($cond=[]){
        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                    })->join('roles', function ($join) {
                        $join->on('model_has_roles.role_id', '=', 'roles.id')
                             ->where('roles.name', 'yet_to_be_approved_intermediary');
                    })->where($cond)->get();

        return $users; 
    }


    public function allUsers($cond=[]){
        $users = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                    })->join('roles', function ($join) {
                        $join->on('model_has_roles.role_id', '=', 'roles.id')
                             ->where('roles.name','!=', 'yet_to_be_approved_intermediary');
                    })->where($cond)->select('users.*')->get();

        return $users; 
      
    }


}
