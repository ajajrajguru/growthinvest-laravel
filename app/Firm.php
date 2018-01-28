<?php

namespace App;

use App\Defaults;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    protected $table = 'firms';

    // protected $guard_name = 'backoffice';

    public function getFirmTypes()
    {
        $firmTypes = Defaults::where('type', 'firm_type')->where('status', 1)->get();

        return $firmTypes;
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function firmData()
    {
        return $this->hasMany('App\FirmData');
    }

    public function firmType()
    {
        $typeId   = $this->type;
        $firmType = Defaults::find($typeId);
        return $firmType;
    }

    public function getParentFirm()
    {
        $parentFirmId = $this->parent_id;
        $parentFirm   = Firm::find($parentFirmId);
        return $parentFirm;
    }

    public function getAllParentFirms()
    {
        $parent_firms = Firm::where(['type' => 10])->orderBy('name', 'asc')->get();
        return $parent_firms;
    }

    public function getFirmAdditionalInfo()
    {
        $addionalData = $this->firmData()->where('data_key', 'additional_details')->first();
        return $addionalData;
    }

    public function getFirmInviteContent()
    {
        $addionalData = $this->firmData()->where('data_key', 'invite_content')->first();
        return $addionalData;
    }

    public function getInviteContent()
    {
        $invite_data = [];

        $invite_contents = Defaults::where('type', 'invite_content')->where('status', 1)->get();

        foreach ($invite_contents as $invite_content) {
            $invite_data[$invite_content->slug] = $invite_content->meta_data;
        }

        return $invite_data;
    }

    public function getAllChildFirmsByFirmID($firm_id){



        $first = Firm::where(['parent_id' => $firm_id])->pluck('id')->all();

        $second = Firm::whereIn('parent_id', $first)->get();
 return $second;
        $child_firms = Firm::where(['parent_id'=>$firm_id])
        ->union($second)
        ->get();


        /*DB::table('users')
            ->whereIn('parent_id');


        $parent_firms = Firm::where(['parent_id' => $firm_id])->orderBy('name', 'asc')->get()*/;
        return $child_firms;
    }
}
