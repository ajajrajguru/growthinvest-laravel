<?php

namespace App\Http\Controllers;

use App\Firm;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $network_firm          = new Firm;
        $firm                  = new Firm;
        $data                  = [];
        $breadcrumbs           = [];
        $breadcrumbs[]         = ['url' => url('/'), 'name' => "Home"];
        $breadcrumbs[]         = ['url' => '', 'name' => 'Add Firm'];
        $data['breadcrumbs']   = $breadcrumbs;
        $data['countyList']    = getCounty();
        $data['countryList']   = getCountry();
        $data['network_firms'] = $network_firm->getAllParentFirms();
        $data['firm']          = $firm;
        return view('backoffice.firm.add-edit-firm')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firm_data = array('firm_id' => $request->input('firm_id'),
            'name'                       => is_null($request->input('name')) ? '' : $request->input('name'),
            'description'                => is_null($request->input('description')) ? '' : $request->input('description'),
            'parent_id'                  => is_null($request->input('parent_firm')) ? 0 : $request->input('parent_firm'),
            'type'                       => is_null($request->input('type')) ? 0 : $request->input('type'),
            'fca_ref_no'                 => is_null($request->input('referenceno')) ? '' : $request->input('referenceno'),
            'wm_commission'              => is_null($request->input('wm_commission')) ? 0 : $request->input('wm_commission'),
            'introducer_commission'      => is_null($request->input('introducer_commission')) ? 0 : $request->input('introducer_commission'),
            'invite_key'                 => is_null($request->input('invite_key')) ? '' : $request->input('invite_key'),
            'address1'                   => is_null($request->input('address')) ? '' : $request->input('address'),
            'address2'                   => is_null($request->input('address2')) ? '' : $request->input('address2'),
            'town'                       => is_null($request->input('city')) ? '' : $request->input('city'),
            'county'                     => is_null($request->input('location')) ? '' : $request->input('location'),
            'postcode'                   => is_null($request->input('postcode')) ? '' : $request->input('postcode'),
            'country'                    => is_null($request->input('country')) ? '' : $request->input('country'),
            'logoid'                     => is_null($request->input('logoid')) ? 0 : $request->input('logoid'),
            'backgroundid'               => is_null($request->input('backgroundid')) ? 0 : $request->input('backgroundid'),
            'frontend_display'           => $request->input('front_end_display'),
            'backend_display'            => $request->input('back_end_display'),
            'blog'                       => $request->input('blog'),

        );

        $firm   = new Firm();
        $firmid = $firm->addFirm($firm_data);
    }

    /**
     * Display the specified resource.
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
