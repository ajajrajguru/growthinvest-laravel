<?php

namespace App\Http\Controllers;

use App\Firm;
use App\FirmData;
use Illuminate\Http\Request;

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
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Home"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Firm'];

        $data['firms']       = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Firms';

        return view('backoffice.firm.list')->with($data);
    }

    /**
     * Show the form for creating a new Firm.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firm                  = new Firm;
        $data                  = [];
        $breadcrumbs           = [];
        $breadcrumbs[]         = ['url' => url('/'), 'name' => "Home"];
        $breadcrumbs[]         = ['url' => '', 'name' => 'Add Firm'];
        $data['breadcrumbs']   = $breadcrumbs;
        $data['countyList']    = getCounty();
        $data['countryList']   = getCountry();
        $data['network_firms'] = $firm->getAllParentFirms();
        $data['firm']          = $firm;
        $data['firm_types']    = $firm->getFirmTypes();
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
            'parent_id'             => is_null($request->input('parent_firm')) ? 0 : $request->input('parent_firm'),
            'type'                  => is_null($request->input('type')) ? 0 : $request->input('type'),
            'fca_ref_no'            => is_null($request->input('referenceno')) ? '' : $request->input('referenceno'),
            'wm_commission'         => is_null($request->input('wm_commission')) ? 0 : $request->input('wm_commission'),
            'introducer_commission' => is_null($request->input('introducer_commission')) ? 0 : $request->input('introducer_commission'),
            'invite_key'            => is_null($request->input('invite_key')) ? '' : $request->input('invite_key'),
            'address1'              => is_null($request->input('address')) ? '' : $request->input('address'),
            'address2'              => is_null($request->input('address2')) ? '' : $request->input('address2'),
            'town'                  => is_null($request->input('city')) ? '' : $request->input('city'),
            'county'                => is_null($request->input('location')) ? '' : $request->input('location'),
            'postcode'              => is_null($request->input('postcode')) ? '' : $request->input('postcode'),
            'country'               => is_null($request->input('country')) ? '' : $request->input('country'),
            'logoid'                => is_null($request->input('logoid')) ? 0 : $request->input('logoid'),
            'backgroundid'          => is_null($request->input('backgroundid')) ? 0 : $request->input('backgroundid'),
            'frontend_display'      => $request->input('front_end_display'),
            'backend_display'       => $request->input('back_end_display'),
            'blog'                  => $request->input('blog'),

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

       return $firm_id;

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
        $data                  = [];
        $breadcrumbs           = [];
        $breadcrumbs[]         = ['url' => url('/'), 'name' => "Home"];
        $breadcrumbs[]         = ['url' => '', 'name' => 'Add Firm'];
        $data['breadcrumbs']   = $breadcrumbs;
        $data['countyList']    = getCounty();
        $data['countryList']   = getCountry();
        $data['network_firms'] = $network_firm->getAllParentFirms();
        $data['firm']          = $firm;
        $data['firm_types']    = $firm->getFirmTypes();
        return view('backoffice.firm.add-edit-firm')->with($data);

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
