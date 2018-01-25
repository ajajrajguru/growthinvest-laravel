<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserData;

class FundmanagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user      = new User;
        $fundmanagers = $user->getFundmanagers();
        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list']; 
        

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Fund Managers'];

        
      
        $data['firms']              = $firms;
        $data['fundmanagers']       = $fundmanagers;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Fund Managers';

        return view('backoffice.clients.fundmanagers')->with($data);
    }




    public function getFundmanagerslist(Request $request)
    {
        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '1' => 'users.first_name',
            '2' => 'users.firm.name',
            '3' => 'users.business',
            '3' => 'users.created_at',
        );

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filterEntrepreneurs = $this->getFilteredFundmanagers($filters, $skip, $length, $orderDataBy);
        $entrepreneurs       = $filterEntrepreneurs['list'];
        $totalEntrepreneurs  = $filterEntrepreneurs['TotalEntrepreneurs'];

        $entrepreneursData = [];

        foreach ($entrepreneurs as $key => $entrepreneur) {

            $nameHtml = '<b><a href=="#">' . $entrepreneur->first_name . ' ' . $entrepreneur->last_name . '</a>';

            $actionHtml = '<select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">Edit Profile</option>
                                                </select>';

            $source = "Self";
            if ($entrepreneur->registered_by !== $entrepreneur->id) {
                $source = "Intermediary";
            }

            $entrepreneursData[] = [
                'name'            => $nameHtml,
                'email'           => $entrepreneur->email,
                'firm'            => (!empty($entrepreneur->firm)) ? $entrepreneur->firm->name : '',
                'business'        => $entrepreneur->business,
                'registered_date' => date('d/m/Y', strtotime($entrepreneur->created_at)),
                'source'          => $source,
                'action'          => $actionHtml,

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalEntrepreneurs),
            "recordsFiltered" => intval($totalEntrepreneurs),
            "data"            => $entrepreneursData,
        );

        return response()->json($json_data);

    }

    public function getFilteredFundmanagers($filters = array(), $skip = 1, $length = 50, $orderDataBy = array())
    {

        $entrepreneurQuery = User::join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', 'App\User');
        })->join('roles', function ($join) {
            $join->on('model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('roles.name', ['fundmanager']);
        })
            ->leftJoin('business_listings', function ($join) {
                $join->on('users.id', '=', 'business_listings.owner_id')
                    ->whereIn('business_listings.type', ['proposal']);
            });

        /*->where($cond)->select("users.*")*/

        /* $entrepreneurQuery = User::join('model_has_roles', function ($join) {
        $join->on('users.id', '=', 'model_has_roles.model_id')
        ->where('model_has_roles.model_type', 'App\User');
        })->join('roles', function ($join) {
        $join->on('model_has_roles.role_id', '=', 'roles.id')
        ->whereIn('roles.name', ['business_owner']);
        })->leftjoin('user_has_certifications', function ($join) {
        $join->on('users.id', 'user_has_certifications.user_id');
        });*/

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $entrepreneurQuery->where('users.firm_id', $filters['firm_name']);
        }

        /* if (isset($filters['user_ids']) && $filters['user_ids'] != "") {
        $userIds = explode(',', $filters['user_ids']);
        $userIds = array_filter($userIds);

        $entrepreneurQuery->whereIn('users.id', $userIds);
        }

        if (isset($filters['investor_name']) && $filters['investor_name'] != "") {
        $entrepreneurQuery->where('users.id', $filters['investor_name']);
        }*/

        /////////////////// $entrepreneurQuery->groupBy('users.id')->select('users.*');
        $entrepreneurQuery->groupBy('users.id');
        $entrepreneurQuery->select(\DB::raw("GROUP_CONCAT(business_listings.title ) as business, users.*"));

        foreach ($orderDataBy as $columnName => $orderBy) {
            $entrepreneurQuery->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $totalEntrepreneurs = $entrepreneurQuery->get()->count();
            $entrepreneurs      = $entrepreneurQuery->skip($skip)->take($length)->get();
        } else {
            $entrepreneurs      = $entrepreneurQuery->get();
            $totalEntrepreneurs = $entrepreneurQuery->count();
        }

        return ['TotalEntrepreneurs' => $totalEntrepreneurs, 'list' => $entrepreneurs];

    }


    public function exportFundmanagers(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filterFundmanagers = $this->getFilteredFundmanagers($filters, 0, 0, $orderDataBy);
        $fundmanagers       = $filterFundmanagers['list'];

        $fileName = 'all_fundmanagers_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Name', 'Email ID', 'Firm','Funds', 'Introduced on', 'Source'];
        $userData = [];

         
        /*echo"<pre>";
        print_r($entrepreneurs);
        die();*/
        foreach ($fundmanagers as $fundmanager) {

            
            $source = "Self";
            if ($fundmanager->registered_by !== $fundmanager->id) {
                $source = "Intermediary";
            }
             

            $userData[] = [$fundmanager->gi_code,
                title_case($fundmanager->first_name . ' ' . $fundmanager->last_name),
                $fundmanager->email,                
                (!empty($fundmanager->firm)) ? $fundmanager->firm->name : '',
                 $fundmanager->business,   
                date('d/m/Y', strtotime($fundmanager->created_at)),
                $source

            ];
        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
