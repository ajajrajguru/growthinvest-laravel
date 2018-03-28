<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function businessListing()
    {
        return $this->belongsTo('App\BusinessListing', 'item_id');
    }

    public function meta()
    {
        return $this->hasMany('App\ActivityMeta', 'activity_id');
    }

    // public function getActivityUserOrPropsalFund()
    // {
    //     if (in_array($this->type, ['nominee_application', 'onfido_requested', 'onfido_confirmed', 'certification', 'registration', 'stage1_investor_registration', 'entrepreneur_account_registration', 'fundmanager_account_registration',
    //         'successful_logins', 'download_client_registration_guide',
    //         'download_investor_csv', 'download_transfer_asset_guide',
    //         'download_vct_asset_transfer_form', 'download_single_company_asset_transfer_form', 'download_iht_product_asset_transfer_form', 'download_portfolio_asset_transfer_form', 'download_stock_transfer_form', 'submitted_transfers',
    //         'status_changes_for_asset_transfers', 'transfers_deleted',
    //         'start_adobe_sign', 'completed_adobe_sign',
    //         'external_downloads', 'stage_3_profile_details',
    //         'auth_fail', 'cash_withdrawl', 'cash_deposits'])) {
    //     }
    // }

}
