<?php

namespace App\Http\Controllers;

use App\Firm;
use App\FirmData;
use Illuminate\Http\Request;
use Session;

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
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Firm'];

        $data['firms']       = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Firms';

        return view('backoffice.firm.list')->with($data);
    }

    public function exportFirms()
    {
        $firmsList = getModelList('App\Firm');
        $firms     = $firmsList['list'];

        $fileName = 'firms_list_as_on_'.date('d-m-Y');
        $header   = ['Platform GI Code', 'Name','Firm Type','Parent Firm'];
        $firmData = [];
 
        foreach ($firms as $firm) {
            $firmData[] = [ $firm->gi_code, 
                            title_case($firm->name),
                            title_case($firm->firmType()->name),
                            (!empty($firm->getParentFirm())) ? title_case($firm->getParentFirm()->name) :''
            ];
        }
         
        generateCSV($header,$firmData,$fileName);

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
        return redirect(url('backoffice/firms/' . $giCode ));
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

        $data                       = [];
        $additional_info            = $firm->getFirmAdditionalInfo($firm->id);
        $invite_content             = $firm->getFirmInviteContent($firm->id);

 
       // echo "<pre>";
        //print_r($invite_content->getOriginal('data_value'));
       // dd($invite_content->data_value );
       // print_r($invite_content->getAttribute('data_value'));
       // die();

        $data['countyList']         = getCounty();
        $data['countryList']        = getCountry();
        $data['network_firms']      = $network_firm->getAllParentFirms();
        $data['firm']               = $firm;
        $data['firm_types']         = $firm->getFirmTypes();
        $data['additional_details'] = (!empty($additional_info)) ? $additional_info->data_value : [];
        $data['invite_content']     = (!empty($invite_content)) ? $invite_content->data_value : [];
        $data['mode']               = 'view';

        $breadcrumbs         = [];
        $breadcrumbs[]       = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[]       = ['url' => '/backoffice/firm', 'name' => 'Firm'];
        $breadcrumbs[]       = ['url' => '', 'name' => $firm->name];
        $breadcrumbs[]       = ['url' => '', 'name' => 'View Firm Details'];

        $data['breadcrumbs'] = $breadcrumbs;

        /*echo "<pre>";
        print_r($data);
        die();*/
        
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
