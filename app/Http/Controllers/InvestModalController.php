<?php

namespace App\Http\Controllers;

use App\BusinessInvestment;
use App\BusinessListing;
use App\User;
use Auth;
use Illuminate\Http\Request;
use View;

class InvestModalController extends Controller
{
    /**
     * Shows the invest business modal.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function showInvestInBusinessModal(Request $request)
    {

        //If user is not logged in, pledge/invest is not allowed
        if (Auth::guest()) {
            $data['message']   = "You do not have enough permissions to pledge or invest, contact your Adviser or anyone in our team: 020 7071 3945";
            $invest_modal_view = View::make('invest-modal.invest-modal-error', $data)->render();
            $json_data         = array(
                "status"       => 'success',
                'invest_modal' => $invest_modal_view,

            );
            return response()->json($json_data);
        }

        $requestData        = $request->all(); //dd($requestData);
        $logged_in_user     = Auth::user();
        $businessInvestment = new BusinessInvestment;
        $data               = [];

        $business_id = $requestData['business_id'];
        $investor_id = $requestData['user_id'];

        $investor = User::find($investor_id);

        $p1code = $investor->userInvestmentAccountNumber();

        // $certification_data_obj             = $investor->getActiveCertification();
        $last_active_certification_data_obj = $investor->getLastActiveCertification();

        $nominee_data  = $investor->getInvestorNomineeData();
        $investor_data = $investor->toArray();
        //$certification_data             = !is_null($certification_data_obj) ? $certification_data_obj->toArray() : [];
        $last_active_certification_data = !is_null($last_active_certification_data_obj) ? $last_active_certification_data_obj->toArray() : [];

        $certification_defaults_obj = $last_active_certification_data_obj->certification();
        if (!is_null($certification_defaults_obj)) {
            $certification_defaults                               = $certification_defaults_obj->toArray();
            $last_active_certification_data['certification_name'] = $certification_defaults['name'];
            $last_active_certification_data['certification_slug'] = $certification_defaults['slug'];
        }

        $pledged_data = $businessInvestment->getInvestmentDataByUserAndBussinessIdStatus($business_id, $investor_id, 'pledged');

        if ($investor->can('participate_in_business') == false) { //if investtor for which participate_in_business permissions is not there
            $data['message']   = "You do not have enough permissions to pledge or invest, contact your Adviser or anyone in our team: 020 7071 3945";
            $invest_modal_view = View::make('invest-modal.invest-modal-error', $data)->render();
        } else if (count($pledged_data) > 0) {
            //display template showing user has already pledged
            $data['message']   = "In order to edit your investment please contact your Adviser or anyone in our team: 020 7071 3945";
            $invest_modal_view = View::make('invest-modal.invest-modal-error', $data)->render();
        } /*else if ($logged_in_user->can('participate_in_business') && !$logged_in_user->can('manage_options') && !$logged_in_user->can('is_wealth_manager') && !$logged_in_user->can('backoffice_access') && !$logged_in_user->can('create_business_proposal') && (!isset($nominee_data['nomineeapplication_dockey']) || $nominee_data['nomineeapplication_dockey'] == '')) {  // if 

            $data['investor_data'] = $investor_data;
            $data['type']          = 'account_upgrade';
            $data['title']         = 'Account Upgrade';
            $data['message']       = '<p><b>Thank you for your interest in investing.</b></p> <p>In order to do so, we need <strong>to upgrade you to an Investment Account.</strong>
This only takes a couple of minutes and a link can be found in the  Dashboard area under Profile.</p>
<p>If you would like us to help please call us on <a href="tel:02070713945">020 7071 3945</a> or <a href="mailto:support@growthinvest.com">support@growthinvest.com</a></p>';
            $invest_modal_view = View::make('invest-modal.invest-modal-error', $data)->render();

        }*/ else {

            $business_listing = BusinessListing::where('id', $business_id)->first();

            $data_keys = [
                'isEIS', 'hmrc_status', 'tradingname', 'markit_overview', 'management_team', 'company_details',
                'fundcharges_details', 'proposal_desc_details', 'fiancial_field', 'use_of_funds', 'exit_strategy',
                'proposal_details', 'busi_pro_selected_firms', 'fundvct_details', 'check_list_items', 'fund_productoverview',
                'fund_manageroverview', 'fund_minamountdesc', 'fund_closedate', 'fund_launchdate', 'fund_openclosed',
                'fund_investmentobjective', 'fund_targetreturn', 'fund_typeoffund', 'fund_managername', 'fund_nominee_custody',
                'fund_minmaxinvestment', 'fundcharges_details', 'investment_opportunities', 'company_transfer_asset'];

            $serialized_meta_keys = [
                'isEIS', 'hmrc_status', 'tradingname', 'markit_overview', 'management_team', 'company_details', 'fundcharges_details',
                'proposal_desc_details', 'fiancial_field', 'use_of_funds', 'proposal_details', 'busi_pro_selected_firms', 'fundvct_details'];

            $business_datas = $business_listing->businessListingData()->whereIn('data_key', $data_keys)->get()->toArray();

            foreach ($business_datas as $key => $business_data) {

                if (in_array($business_data['data_key'], $serialized_meta_keys)) {
                    $business_data_ar[$business_data['data_key']] = @unserialize($business_data['data_value']);
                    if (in_array($business_data['data_key'], ['proposal_desc_details', 'company_details', 'fundvct_details', 'fundcharges_details'])) {
                        $business_data_ar[$business_data['data_key']] = @unserialize($business_data_ar[$business_data['data_key']]);

                    }
                } else {
                    $business_data_ar[$business_data['data_key']] = $business_data['data_value'];
                }

            }

            $investor_data['p1code'] = $p1code;

            $business_ar   = $business_listing->toArray();
            $business_data = array_merge($business_ar, $business_data_ar);

            $data = [
                'investor_data'                  => $investor_data,
                'business_data'                  => $business_data,
                'nominee_data'                   => $nominee_data,
                /*'certification_data'             => $certification_data,*/
                'last_active_certification_data' => $last_active_certification_data,
            ];
            //$invest_modal_view =  View::make('invest-modal.invest-modal', compact('comment'))->render();
            //view('invest-modal.invest-modal')->with($data);
            /*echo "<pre>";
            print_r($certification_defaults);
            echo "=========";
            dd($last_active_certification_data);*/

            $invest_modal_view = View::make('invest-modal.invest-modal', $data)->render();
        }

        $json_data = array(
            "status"       => 'success',
            'invest_modal' => $invest_modal_view,

        );
        return response()->json($json_data);

    }
}
