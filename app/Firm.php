<?php

namespace App;

use App\Defaults;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    protected $table = 'firms';
    protected $child_firms = [];

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

    public function getFirmAdditionalInfo($firm_id)
    {
        $addionalData = $this->firmData()->where(['data_key'=>'additional_details','firm_id'=>$firm_id])->first();
        return $addionalData;
    }

    public function getFirmInviteContent($firm_id)
    {
        $addionalData = $this->firmData()->where(['data_key'=>'invite_content','firm_id'=>$firm_id] )->first();
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

    public function parent()
    {
        return $this->hasone('Firm', 'id', 'parent_id');
    }
    public function children()
    {
        return $this->hasmany('Firm', 'parent_id', 'id');
    }
    public function tree()
    {
        return static::with(implode('.', array_fill(0, 10, 'children')))->where('parent_id', '=', '0')->get();
    }

    public function getAllChildFirmsByFirmID($firm_id)
    {

        $first               = Firm::where(['parent_id' => $firm_id])->pluck('id')->all();
        $this->child_firms = array_merge($this->child_firms,$first);

        if (count($first > 0)) {
            foreach ($first as $value) {

                $this->getAllChildFirmsByFirmID($value);
            }
        }

        /*DB::table('users')
        ->whereIn('parent_id');

        $parent_firms = Firm::where(['parent_id' => $firm_id])->orderBy('name', 'asc')->get()*/;
        return $this->child_firms;
    }

}
