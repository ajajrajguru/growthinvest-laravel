<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Defaults;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Investors'];

        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Investors';

        return view('backoffice.clients.investors')->with($data);
    }

    public function getInvestors(Request $request){

        $requestData = $request->all();  //dd($requestData);
        $data =[];
        $skip = $requestData['start'];
        $length = $requestData['length'];
        $orderValue = $requestData['order'][0];
      
       
        $columnOrder = array( );
 
        if(isset($columnOrder[$orderValue['column']]))
        {   
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy = $orderValue['dir'];
        }

        
        $investorQuery = User::join('model_has_roles', function ($join) {
                        $join->on('users.id', '=', 'model_has_roles.model_id')
                             ->where('model_has_roles.model_type', 'App\User');
                        })->join('roles', function ($join) {
                            $join->on('model_has_roles.role_id', '=', 'roles.id')
                                ->where('roles.name', 'investor');
                        })->leftjoin('user_has_certifications', function ($join) {
                            $join->on('users.id', 'user_has_certifications.user_id');
                        })->groupBy('users.id')->select('users.*');    
        
        if($length>1)
        {  

            $totalInvestors = $investorQuery->get()->count(); 
            $investors    = $investorQuery->skip($skip)->take($length)->get();   
        }
        else
        {
            $investors    = $investorQuery->get();  
            $totalInvestors = $jobs->count();  
        } 
 
        $investorsData = [];
        $certification = [];
        foreach ($investors as $key => $investor) {

            $userCertification =$investor->userCertification()->orderBy('created_at','desc')->first();

            $certificationName ='Uncertified Investors';
            $certificationDate ='-';

            if(!empty($userCertification)){

                if(isset($certification[$userCertification->certification_default_id]))
                    $certificationName = $certification[$userCertification->certification_default_id];
                else{
                    $certificationName = Defaults::find($userCertification->certification_default_id)->name;
                    $certification[$userCertification->certification_default_id]=$certificationName;
                }

                $certificationDate =  date('d/m/Y', strtotime($userCertification->created_at));
            }

 
            $nameHtml =  '<b><a href=="">'. $investor->first_name.' '.$investor->last_name.'</a></b><br><a class="investor_email" href="mailto: '.$investor->email.'">'.$investor->email.'</a><br>'.$certificationName;

            $actionHtml = '<select> 
            <option id="select" value="">-Select-</option> 
            <option value="edit_profile">View Profile</option>                                    
            <option value="view_portfolio">View Portfolio</option>                                                            
            <option value="manage_documents">View Investor Documents</option>                                        
            <option value="message_board">View Message Board</option>                    
            <option value="nominee_application">Investment Account</option>                                                            
            <option value="investoffers">Investment Offers</option>                                                
            </select>';


            $active = (!empty($userCertification) && $userCertification->active)? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Not Active</span>'; 
            
            
 
            $investorsData[] = [ 
                            '#' => '<input type="checkbox" name="ck_investor">',
                            'name' => $nameHtml,
                            'certification_date' => $certificationDate,
                            'client_categorisation' => $active,
                            'parent_firm' =>(!empty($investor->firm))?$investor->firm->name:'',
                            'registered_date' => date('d/m/Y', strtotime($investor->created_at)),
                            'action' => $actionHtml,
                            
                            ];
            
        }

 

        $json_data = array(
                "draw"            => intval( $requestData['draw'] ),
                "recordsTotal"    => intval( $totalInvestors ),
                "recordsFiltered" => intval( $totalInvestors ),
                "data"            => $investorsData,
            );
              
        return response()->json($json_data);

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
