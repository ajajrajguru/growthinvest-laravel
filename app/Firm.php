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
        $parent_firms = Firm::where(['type' => 10]);
        return $parent_firms;
    }
}
