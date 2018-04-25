<?php

namespace App\Http\Controllers;

use App\Firm;
use App\FirmData;
use App\BusinessListing;

use App\User;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Role;

class FirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firmsList = getModelList('App\Firm');
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/manage/manage-backoffice'), 'name' => "Manage Backoffice"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Firm'];

        $data['firms']       = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Firms';
        $data['activeMenu']  = 'firms';

        return view('backoffice.firm.list')->with($data);
    }

    public function exportFirms()
    {
        $firmsList = getModelList('App\Firm');
        $firms     = $firmsList['list'];

        $fileName = 'firms_list_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Name', 'Firm Type', 'Parent Firm'];
        $firmData = [];

        foreach ($firms as $firm) {
            $firmData[] = [$firm->gi_code,
                title_case($firm->name),
                title_case($firm->firmType()->name),
                (!empty($firm->getParentFirm())) ? title_case($firm->getParentFirm()->name) : '',
            ];
        }

        generateCSV($header, $firmData, $fileName);

        return true;

    }

    /**
     * Show the form for creating a new Firm.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firm        = new Firm;
        $data        = [];
        $breadcrumbs = [];

        $invite_content = $firm->getInviteContent();

        $breadcrumbs[]          = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[]          = ['url' => '/backoffice/firm', 'name' => 'Firms'];
        $breadcrumbs[]          = ['url' => '', 'name' => 'Add Firm'];
        $data['breadcrumbs']    = $breadcrumbs;
        $data['countyList']     = getCounty();
        $data['countryList']    = getCountry();
        $data['network_firms']  = $firm->getAllParentFirms();
        $data['firm']           = $firm;
        $data['firm_types']     = $firm->getFirmTypes();
        $data['mode']           = 'edit';
        $data['invite_content'] = $invite_content;

        $profilePic      = $firm->getFirmLogo('medium_1x1');
        $backgroundImage = $firm->getBackgroundImage('medium_2_58x1');

        $data['firmLogo']           = $profilePic['url'];
        $data['hasFirmLogo']        = $profilePic['hasImage'];
        $data['backgroundImage']    = $backgroundImage['url'];
        $data['hasBackgroundImage'] = $backgroundImage['hasImage'];

        return view('backoffice.firm.add-edit-firm')->with($data);
    }

    /**
     * Store a newly created Firm.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $firm_data = array(
            'name'                  => is_null($request->input('name')) ? '' : $request->input('name'),
            'description'           => is_null($request->input('description')) ? '' : $request->input('description'),
            'parent_id'             => is_null($request->input('parent_id')) ? 0 : $request->input('parent_id'),
            'type'                  => is_null($request->input('type')) ? 0 : $request->input('type'),
            'fca_ref_no'            => is_null($request->input('fca_ref_no')) ? '' : $request->input('fca_ref_no'),
            'wm_commission'         => is_null($request->input('wm_commission')) ? 0 : $request->input('wm_commission'),
            'introducer_commission' => is_null($request->input('introducer_commission')) ? 0 : $request->input('introducer_commission'),
            'invite_key'            => is_null($request->input('invite_key')) ? '' : $request->input('invite_key'),
            'address1'              => is_null($request->input('address1')) ? '' : $request->input('address1'),
            'address2'              => is_null($request->input('address2')) ? '' : $request->input('address2'),
            'town'                  => is_null($request->input('town')) ? '' : $request->input('town'),
            'county'                => is_null($request->input('county')) ? '' : $request->input('county'),
            'postcode'              => is_null($request->input('postcode')) ? '' : $request->input('postcode'),
            'country'               => is_null($request->input('country')) ? '' : $request->input('country'),
            'logoid'                => is_null($request->input('logoid')) ? 0 : $request->input('logoid'),
            'backgroundid'          => is_null($request->input('backgroundid')) ? 0 : $request->input('backgroundid'),
            'frontend_display'      => is_null($request->input('frontend_display')) ? 'no' : 'yes',
            'backend_display'       => is_null($request->input('backend_display')) ? 'no' : 'yes',
            'blog'                  => is_null($request->input('blog')) ? 1 : $request->input('blog'),

        );

        $giCode = $request->input('gi_code');
        $giArgs = array('prefix' => "GIIF", 'min' => 50000001, 'max' => 60000000);

        if ($giCode == '') {
            $firm          = new Firm;
            $giCode        = generateGICode($firm, 'gi_code', $giArgs);
            $firm->gi_code = $giCode;
        } else {
            $firm = Firm::where('gi_code', $giCode)->first();
        }

        $firm->name                  = $firm_data['name'];
        $firm->description           = $firm_data['description'];
        $firm->parent_id             = $firm_data['parent_id'];
        $firm->type                  = $firm_data['type'];
        $firm->fca_ref_no            = $firm_data['fca_ref_no'];
        $firm->wm_commission         = $firm_data['wm_commission'];
        $firm->introducer_commission = $firm_data['introducer_commission'];
        $firm->invite_key            = $firm_data['invite_key'];
        $firm->address1              = $firm_data['address1'];
        $firm->address2              = $firm_data['address2'];
        $firm->town                  = $firm_data['town'];
        $firm->county                = $firm_data['county'];
        $firm->postcode              = $firm_data['postcode'];
        $firm->country               = $firm_data['country'];
        $firm->logoid                = $firm_data['logoid'];
        $firm->backgroundid          = $firm_data['backgroundid'];
        $firm->frontend_display      = $firm_data['frontend_display'];
        $firm->backend_display       = $firm_data['backend_display'];
        $firm->blog                  = $firm_data['blog'];
        $firm->gi_code               = $giCode;

        //print_r($firm);

        $firm->save();

        $firm_id = $firm->id;

        if ($firm_id != false) {

            if ($firm->invite_key == "") {
                $firm->invite_key = generate_firm_invite_key($firm, $firm->id);
            }
            $firm->save();

            $invite_content = array('ent_invite_content' => $request->input('ent_invite_content'),
                'inv_invite_content'                         => $request->input('inv_invite_content'),
                'fundmanager_invite_content'                 => $request->input('fundmanager_invite_content'));

            $additional_firmdetails = array('pri_contactname' => $request->input('pri_contactname'),
                'pri_contactfcano'                                => $request->input('pri_contactfcano'),
                'pri_contactemail'                                => $request->input('pri_contactemail'),
                'pri_contactphoneno'                              => $request->input('pri_contactphoneno'));

            $firm_metas = array('invite_content' => $invite_content,
                'additional_details'                 => $additional_firmdetails);

            $firm_data = new FirmData();
            $result    = $firm_data->insertUpdateFirmdata($firm_metas, $firm_id);
        }

        //return $firm_id;

        Session::flash('success_message', 'Firm details saved successfully.');
        return redirect(url('backoffice/firms/' . $giCode));
    }

    /**
     * Display the specified Firm by gicode.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($giCode)
    {
        $network_firm = new Firm;
        $firm         = Firm::where('gi_code', $giCode)->first();
        if (empty($firm)) {
            abort(404);
        }

        $data            = [];
        $additional_info = $firm->getFirmAdditionalInfo($firm->id);
        $invite_content  = $firm->getFirmInviteContent($firm->id);

        // echo "<pre>";
        //print_r($invite_content->getOriginal('data_value'));
        // dd($invite_content->data_value );
        // print_r($invite_content->getAttribute('data_value'));
        // die();

        $profilePic      = $firm->getFirmLogo('medium_1x1');
        $backgroundImage = $firm->getBackgroundImage('medium_2_58x1');

        $data['firmLogo']           = $profilePic['url'];
        $data['hasFirmLogo']        = $profilePic['hasImage'];
        $data['backgroundImage']    = $backgroundImage['url'];
        $data['hasBackgroundImage'] = $backgroundImage['hasImage'];
        $data['countyList']         = getCounty();
        $data['countryList']        = getCountry();
        $data['network_firms']      = $network_firm->getAllParentFirms();
        $data['firm']               = $firm;
        $data['firm_types']         = $firm->getFirmTypes();
        $data['additional_details'] = (!empty($additional_info)) ? $additional_info->data_value : [];
        $data['invite_content']     = (!empty($invite_content)) ? $invite_content->data_value : [];
        $data['mode']               = 'view';
        $data['firmActiveMenu']     = 'firm-details';

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '/backoffice/firm', 'name' => 'Firm'];
        $breadcrumbs[] = ['url' => '', 'name' => $firm->name];
        $breadcrumbs[] = ['url' => '', 'name' => 'View Firm Details'];

        $data['breadcrumbs'] = $breadcrumbs;

        return view('backoffice.firm.add-edit-firm')->with($data);
    }

    public function getInvite($firm_id, $invite_type)
    {
        $firm   = Firm::where('id', $firm_id)->first();
        $result = $firm->getInviteData($firm_id, $invite_type);
        return $result;
    }

    public function saveFirmInvite(Request $request)
    {

        $firm_id            = is_null($request->input('invite_firm_name')) ? '' : $request->input('invite_firm_name');
        $invite_content_txt = is_null($request->input('invite_content')) ? '' : $request->input('invite_content');
        $invite_type        = is_null($request->input('invite_type')) ? '' : $request->input('invite_type');

        /* echo "<pre>";
        echo"<br/>".$invite_type."<br/>";
        print_r($invite_content_txt);
        die();
         */
        if ($firm_id == "" || is_null($firm_id)) {
            Session::flash('error_message', 'Please select firm');
            return redirect()->back()->withInput();
        }
        if ($invite_type == "" || is_null($invite_type)) {
            Session::flash('error_message', 'Invite Type missing');
            return redirect()->back()->withInput();
        }

        $firm                = Firm::where('id', $firm_id)->first();
        $invite_content_data = $firm->getFirmInviteContent($firm->id);
        $invite_content      = $invite_content_data->data_value;

        switch ($invite_type) {
            case 'businessowner':$invite_content['ent_invite_content'] = $invite_content_txt;
                break;
            case 'investor':$invite_content['inv_invite_content'] = $invite_content_txt;
                break;
            case 'fundmanager':$invite_content['fundmanager_invite_content'] = $invite_content_txt;
                break;
        }

        /*echo "<pre>";
        print_r($invite_content);
        die();*/
        $firm_metas = array('invite_content' => $invite_content);

        $firm_data = new FirmData();
        $result    = $firm_data->insertUpdateFirmdata($firm_metas, $firm_id);

        //return $firm_id;

        Session::flash('success_message', 'Firm Invite content saved successfully.');
        return redirect()->back()->withInput();

    }

    public function getFirmUsers($giCode)
    {
        $firm       = Firm::where('gi_code', $giCode)->first();
        $childFirms = Firm::where('parent_id', $firm->id)->pluck('id')->toArray();

        if (empty($firm)) {
            abort(404);
        }
        $firmIds   = $childFirms;
        $firmIds[] = $firm->id;
        $cond      = ['firm_id' => $firmIds];
        $user      = new User;
        $users     = $user->allUsers([], $cond);

        $data['roles']          = Role::where('type', 'backoffice')->pluck('display_name');
        $data['users']          = $users;
        $data['firm']           = $firm;
        $data['firmActiveMenu'] = 'firm-users';

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '/backoffice/firm', 'name' => 'Firm'];
        $breadcrumbs[] = ['url' => '', 'name' => $firm->name];
        $breadcrumbs[] = ['url' => '', 'name' => 'View Firm Users'];

        $data['breadcrumbs'] = $breadcrumbs;

        return view('backoffice.firm.firm-users')->with($data);
    }

    public function firmInvestors(Request $request, $giCode)
    {
        $firm       = Firm::where('gi_code', $giCode)->first();
        $childFirms = Firm::where('parent_id', $firm->id)->pluck('id')->toArray();

        if (empty($firm)) {
            abort(404);
        }
        $firmIds    = $childFirms;
        $firmIds[]  = $firm->id;
        $inCond     = ['firm_id' => $firmIds];
        $firmInCond = ['id' => $firmIds];
        $user       = new User;

        $investors = $user->getInvestorUsers([], $inCond);

        $requestFilters = $request->all();

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc'], $firmInCond);
        $firms     = $firmsList['list'];

        $clientCategoriesList = getModelList('App\Defaults', ['type' => 'certification'], 0, 0, ['name' => 'asc']);
        $clientCategories     = $clientCategoriesList['list'];

        $certificationTypes = certificationTypes();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '/backoffice/firm', 'name' => 'Firm'];
        $breadcrumbs[] = ['url' => '', 'name' => $firm->name];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];

        $data['certificationTypes'] = $certificationTypes;
        $data['clientCategories']   = $clientCategories;
        $data['requestFilters']     = $requestFilters;
        $data['firm']               = $firm;
        $data['firms']              = $firms;
        $data['firm_ids']           = $firmIds;
        $data['investors']          = $investors;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Investors';
        $data['firmActiveMenu']     = 'investors';

        return view('backoffice.firm.firm-investors')->with($data);
    }

    public function exportFirmUsers($giCode)
    {
        $firm       = Firm::where('gi_code', $giCode)->first();
        $childFirms = Firm::where('parent_id', $firm->id)->pluck('id')->toArray();

        if (empty($firm)) {
            abort(404);
        }
        $firmIds   = $childFirms;
        $firmIds[] = $firm->id;
        $cond      = ['firm_id' => $firmIds];
        $userObj   = new User;
        $users     = $userObj->allUsers([], $cond);

        $fileName = 'approved_intermediary';

        $header = ['Platform GI Code', 'Name', 'Email', 'Role', 'Firm', 'Telephone No'];

        $userData = [];

        foreach ($users as $user) {
            $userData[] = [$user->gi_code,
                title_case($user->first_name . ' ' . $user->last_name),
                $user->email,
                title_case($user->roles()->pluck('display_name')->implode(' ')),
                (!empty($user->firm)) ? $user->firm->name : '',
                $user->telephone_no,
            ];
        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    public function firmInvestmentClients(Request $request, $firmGiCode = '')
    {
        $requestFilters = $request->all();
        $firm           = Firm::where('gi_code', $firmGiCode)->first();
        $firmCond       = [];

        if (empty($firm)) {
            abort(404);
        }

        $firms = Firm::where('parent_id', $firm->id)->get();
        $firms->push($firm);
        $firmIds  = $firms->pluck('id')->toArray();
        $firmCond = ['firm_id' => $firm->id];

        $user                 = new User;
        $investors            = $user->getInvestorUsers([],['firm_id' => $firmIds]);
        $clientCategoriesList = getModelList('App\Defaults', ['type' => 'certification'], 0, 0, ['name' => 'asc']);
        $clientCategories     = $clientCategoriesList['list'];

        $investmentList = BusinessListing::select('business_listings.*')->join('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['funded']);
        })->leftjoin('users', function ($join) {
            $join->on('business_listings.owner_id', 'users.id');
        })->whereIn('users.firm_id', $firmIds)->where('business_listings.business_status', 'listed')->groupBy('business_listings.id')->get();

        $breadcrumbs   = [];
        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '/backoffice/firm', 'name' => 'Firm'];
        $breadcrumbs[] = ['url' => '', 'name' => $firm->name];
        $breadcrumbs[] = ['url' => '', 'name' => 'Investment Clients'];

        $data['requestFilters']   = $requestFilters;
        $data['firm']            = $firm;
        $data['firms']            = $firms;
        $data['firm_ids']         = $firmIds;
        $data['investors']        = $investors;
        $data['clientCategories'] = $clientCategories;
        $data['investmentList']   = $investmentList;
        $data['breadcrumbs']      = $breadcrumbs;
        $data['pageTitle']        = 'Investment Clients';
        $data['firmActiveMenu']   = 'firm-investment-clients';

        return view('backoffice.firm.investment-clients')->with($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
