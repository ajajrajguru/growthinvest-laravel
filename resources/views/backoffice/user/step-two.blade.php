@extends('layouts.backoffice')

@section('js')
  @parent
 
  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
    
@endsection
@section('backoffice-content')

<div class="container">

        @php
            echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
        @endphp

         @include('includes.notification')

        <div class="mt-4 bg-white border border-gray p-4">
        <h1 class="section-title font-weight-medium text-primary mb-0">Add User</h1>
        <p class="text-muted">Add details of intermediary.</p>

        

        <ul class="progress-indicator my-5">
            <li class="completed">
                <a href="javascript:void(0)">Intermediary Registration</a>
                <span class="bubble"></span>
            </li>
            <li class="active">
                <a href="javascript:void(0)">Intermediary Profile</a>
                <span class="bubble"></span>
            </li>
        </ul>

        <div class="profile-content p-4">

        
        <a href="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}" class="btn btn-primary mb-4"><i class="fa fa-angle-double-left"></i> Prev</a>
     

            <div class="row">
                <div class="col-6">
                    <h6 class="mt-0">Step 2: <span class="text-primary">Intermediary Profile</span></h6>
                </div>
                <div class="col-6">
                    <a href="javascript:void(0)" class="btn btn-primary editUserBtn">Edit Details</a>
                    <a href="javascript:void(0)" class="btn btn-primary d-none cancelUpdateBtn">Cancel Updates</a>
                </div>
            </div>
            <hr class="my-3">

            <form method="post" action="{{ url('backoffice/user/save-step-two') }}" data-parsley-validate name="add-user-step2" id="add-user-step2" enctype="multipart/form-data">

                <div class="card border-light mb-3">
                  <div class="card-header text-white bg-primary font-weight-medium">Contact Information</div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <label class="d-block">Profile Picture</label>
                            <img src="{{ url('img/dummy/avatar.png')}}'" alt="..." class="img-thumbnail">
                            <button type="button" class="btn btn-primary btn-sm mt-2"><i class="fa fa-camera"></i> Select Image</button>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Skype ID</label>
                                        <input type="text" name="contact_skype_id" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. johnsmith_avon" value="{{ (isset($intermidiatData['con_skype']))? $intermidiatData['con_skype'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['con_skype']))? $intermidiatData['con_skype'] :'' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>LinkedIN</label>
                                        <input type="text"  name="contact_linked_in" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. www.linkedin.com/john-smith" value="{{ (isset($intermidiatData['con_link']))? $intermidiatData['con_link'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['con_link']))? $intermidiatData['con_link'] :'' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="text"  name="contact_facebook" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. www.facebook.com/john-smith" value="{{ (isset($intermidiatData['con_fb']))? $intermidiatData['con_fb'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['con_fb']))? $intermidiatData['con_fb'] :'' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <input type="text"  name="contact_twitter" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. www.twitter.com/john-smith" value="{{ (isset($intermidiatData['con_twit']))? $intermidiatData['con_twit'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['con_twit']))? $intermidiatData['con_twit'] :'' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                           <div class="form-group">
                            <label>Job Title</label>
                            <input type="text"  name="contact_job_title" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg: Wealth Manager" value="{{ (isset($intermidiatData['position']))? $intermidiatData['position'] :'' }}">
                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['position']))? $intermidiatData['position'] :'' }}</span>
                           </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Are you a UK FCA regulated individual?</label>
                                <div class=" editmode @if($mode=='view') d-none @endif">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input disabledInput" type="radio" @if($mode=='view') disabled @endif  name="contact_fca_regulation" id="fca_yes" value="yes" checked>
                                      <label class="form-check-label" for="fca_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input disabledInput" type="radio" @if($mode=='view') disabled @endif  name="contact_fca_regulation" id="fca_no" value="no" @if(isset($intermidiatData['fca_approved']) && $intermidiatData['fca_approved']=='no') checked @endif>
                                      <label class="form-check-label" for="fca_no">No</label>
                                    </div>
                                </div>
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['fca_approved']) && $intermidiatData['fca_approved']=='yes')? 'Yes' :'No' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>If you are a regulated individual, please enter your registration number</label>
                                <input type="text" name="contact_registration_number" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Please enter your registration number" value="{{ (isset($intermidiatData['personal_fca']))? $intermidiatData['personal_fca'] :'' }}">
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['personal_fca']))? $intermidiatData['personal_fca'] :'' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telephone - Direct Dial</label>
                                <input type="tel" name="contact_telephone" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg: 020 7071 3945" value="{{ (isset($intermidiatData['telephonenumber']))? $intermidiatData['telephonenumber'] :'' }}">
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['telephonenumber']))? $intermidiatData['telephonenumber'] :'' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telephone - Mobile</label>
                                <input type="tel" name="contact_mobile" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg: 01344 747418" value="{{ (isset($intermidiatData['mobile']))? $intermidiatData['mobile'] :'' }}">
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['mobile']))? $intermidiatData['mobile'] :'' }}</span>
                            </div>
                        </div>
                    </div>

                  </div>
                </div>


                <div class="card border-light mb-3">
                  <div class="card-header text-white bg-primary font-weight-medium">Company Information</div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <label class="d-block">Logo</label>
                            <img src="{{ url('img/dummy/avatar.png') }}" alt="..." class="img-thumbnail">
                            <button type="button" class="btn btn-primary btn-sm mt-2"><i class="fa fa-camera"></i> Select Image</button>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>LinkedIN</label>
                                        <input type="text" name="company_linkedin" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. www.linkedin.com/john-smith" value="{{ (isset($intermidiatData['company_link']))? $intermidiatData['company_link'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['company_link']))? $intermidiatData['company_link'] :'' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="text" name="company_facebook" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. www.facebook.com/john-smith" value="{{ (isset($intermidiatData['company_fb']))? $intermidiatData['company_fb'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['company_fb']))? $intermidiatData['company_fb'] :'' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <input type="text" name="company_twitter" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Eg. www.twitter.com/john-smith" value="{{ (isset($intermidiatData['company_twit']))? $intermidiatData['company_twit'] :'' }}">
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['company_twit']))? $intermidiatData['company_twit'] :'' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Please select your regulation type</label>
                                <select name="company_regulation_type" class="form-control editmode @if($mode=='view') d-none @endif">
                                    <option value="">Select</option>
                                    @php
                                    $regTypeName = '';
                                    @endphp
                                    
                                    @foreach($regulationTypes as $key =>$regType)
                                    @php
                                    if(isset($intermidiatData['regulationtype']) && $intermidiatData['regulationtype']==$key)
                                        $regTypeName = $regType;
 
                                    @endphp

                                    <option @if(isset($intermidiatData['regulationtype']) && $intermidiatData['regulationtype']==$key) selected @endif  value="{{ $key }}">{{ $regType }}</option>
                                     @endforeach
                                </select>
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ $regTypeName }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>How many Registered individuals are employed at the company ?</label>
                                <select name="company_reg_ind" class="form-control editmode @if($mode=='view') d-none @endif">
                                    <option value="">Select</option>
                                    @php
                                    $rangeName = '';
                                    @endphp
                                    @foreach($registeredIndRange as $key =>$range)
                                    @php
                                    if(isset($intermidiatData['reg_ind_cnt']) && $intermidiatData['reg_ind_cnt']==$key)
                                        $rangeName = $range;
 
                                    @endphp
                                   <option @if(isset($intermidiatData['reg_ind_cnt']) && $intermidiatData['reg_ind_cnt']==$key) selected @endif  value="{{ $key }}">{{ $range }}</option>
                                    @endforeach                          
                                </select>
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ $rangeName }}</span>
                            </div>
                        </div>
                    </div>
 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>What are your current estimated Assets Under Management ?</label>
                                <input type="text" name="company_estimate_asset_under_mgt" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Please enter current estimated Assets Under Management" value="{{ (isset($intermidiatData['regulated_total_bus_inv_aum']))? $intermidiatData['regulated_total_bus_inv_aum'] :'' }}">
                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['regulated_total_bus_inv_aum']))? $intermidiatData['regulated_total_bus_inv_aum'] :'' }}</span>
                            </div>
                        </div>
                    </div>
                    @php
                    if(isset($intermidiatData['interested_tax_struct'])  && !empty($intermidiatData['interested_tax_struct']))
                        $taxStructure = explode(',',$intermidiatData['interested_tax_struct']);
                    else
                        $taxStructure = [];
                    @endphp
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Please indicate which of the following tax structures you or your clients are interested in. (Tick all that apply)?</label>
                                <div class="row  editmode @if($mode=='view') d-none @endif">
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                          <input class="form-check-input" name="interested_tax_structure[]" type="checkbox" value="SEIS" id="seis" @if(!empty($taxStructure) && in_array("SEIS",$taxStructure)) checked @endif>
                                          <label class="form-check-label" for="seis">
                                            SEIS
                                          </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                          <input class="form-check-input" name="interested_tax_structure[]" type="checkbox" value="EIS" id="eis" @if(!empty($taxStructure) && in_array("EIS",$taxStructure)) checked @endif>
                                          <label class="form-check-label" for="eis">
                                            EIS
                                          </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                          <input class="form-check-input" name="interested_tax_structure[]" type="checkbox" value="VCT" id="vct" @if(!empty($taxStructure) && in_array("VCT",$taxStructure)) checked @endif>
                                          <label class="form-check-label" for="vct">
                                            VCT
                                          </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                          <input class="form-check-input" name="interested_tax_structure[]" type="checkbox" value="IHT" id="iht" @if(!empty($taxStructure) && in_array("IHT",$taxStructure)) checked @endif>
                                          <label class="form-check-label" for="iht">
                                            IHT
                                          </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                          <input class="form-check-input" name="interested_tax_structure[]" type="checkbox" value="SITR" id="sitr" @if(!empty($taxStructure) && in_array("SITR",$taxStructure)) checked @endif>
                                          <label class="form-check-label" for="sitr">
                                            SITR
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <span class="viewmode @if($mode=='edit') d-none @endif">@if(isset($intermidiatData['interested_tax_struct']) && !empty($intermidiatData['interested_tax_struct'])) {{  $intermidiatData['interested_tax_struct']  }} @endif</span>

                                <div class="table-responsive my-4">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Expected number of clients this financial year (2017/18)</th>
                                                <th>Expected total value invested this financial year (2017/18)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>SEIS</td>
                                                <td>
                                                <input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['seis_clients'])) ? $taxstructureInfo['seis_clients'] :'' }}" name="taxstructure[seis_clients]">
                                                <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['seis_clients'])) ? $taxstructureInfo['seis_clients'] :'' }}</span>
                                                </td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['seis_valueinvested'])) ? $taxstructureInfo['seis_valueinvested'] :'' }}" name="taxstructure[seis_valueinvested]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['seis_valueinvested'])) ? $taxstructureInfo['seis_valueinvested'] :'' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EIS</td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['eis_clients'])) ? $taxstructureInfo['eis_clients'] :'' }}" name="taxstructure[eis_clients]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['eis_clients'])) ? $taxstructureInfo['eis_clients'] :'' }}</span>
                                                    </td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['eis_valueinvested'])) ? $taxstructureInfo['eis_valueinvested'] :'' }}" name="taxstructure[eis_valueinvested]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['eis_valueinvested'])) ? $taxstructureInfo['eis_valueinvested'] :'' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>VCT</td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['vct_clients'])) ? $taxstructureInfo['vct_clients'] :'' }}" name="taxstructure[vct_clients]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['vct_clients'])) ? $taxstructureInfo['vct_clients'] :'' }}</span>
                                                </td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['vct_valueinvested'])) ? $taxstructureInfo['vct_valueinvested'] :'' }}" name="taxstructure[vct_valueinvested]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['vct_valueinvested'])) ? $taxstructureInfo['vct_valueinvested'] :'' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IHT</td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['bpr_clients'])) ? $taxstructureInfo['bpr_clients'] :'' }}" name="taxstructure[bpr_clients]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['bpr_clients'])) ? $taxstructureInfo['bpr_clients'] :'' }}</span>
                                                </td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['bpr_valueinvested'])) ? $taxstructureInfo['bpr_valueinvested'] :'' }}" name="taxstructure[bpr_valueinvested]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['bpr_valueinvested'])) ? $taxstructureInfo['bpr_valueinvested'] :'' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SITR</td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['sitr_clients'])) ? $taxstructureInfo['sitr_clients'] :'' }}" name="taxstructure[sitr_clients]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['sitr_clients'])) ? $taxstructureInfo['sitr_clients'] :'' }} </span>
                                                </td>
                                                <td><input type="number" class="form-control editmode @if($mode=='view') d-none @endif" value="{{ (isset($taxstructureInfo['sitr_valueinvested'])) ? $taxstructureInfo['sitr_valueinvested'] :'' }}" name="taxstructure[sitr_valueinvested]">
                                                    <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($taxstructureInfo['seis_clients'])) ? $taxstructureInfo['sitr_valueinvested'] :'' }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>How did you hear about the Platform?</label>
                                            <select name="about_platform" class="form-control editmode @if($mode=='view') d-none @endif" name="">
                                                <option value="">Select</option>  
                                                 @php
                                                $sourceName = '';
                                                @endphp                      
                                                 @foreach($sources as $key =>$source)
                                                    if(isset($intermidiatData['source']) && $intermidiatData['source']==$key)
                                                        $sourceName = $range;
                                                   <option @if(isset($intermidiatData['source']) && $intermidiatData['source']==$key) selected @endif  value="{{ $key }}">{{ $source }}</option>
                                                    @endforeach                     
                                            </select>
                                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ $sourceName }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Additional Comments</label>
                                            <textarea name="additional_comments" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="Please enter any additional comments or requests">{{ (isset($intermidiatData['source_cmts']))? $intermidiatData['source_cmts'] :'' }}</textarea>
                                            <span class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($intermidiatData['source_cmts']))? $intermidiatData['source_cmts'] :'' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Contact Preferences</label>
                                            <p>I am happy to be contacted by:</p>
                                            <div class="form-check form-check-inline">
                                              <input name="connect_email" class="form-check-input disabledInput" type="checkbox" @if($mode=='view') disabled @endif id="email" value="email" @if(isset($intermidiatData['contact_email']) && $intermidiatData['contact_email']=='yes') checked @endif>
                                              <label class="form-check-label" for="email">Email</label>
                                            </div>
                                            <div class="form-check form-check-inline ">
                                              <input name="connect_mobile" class="form-check-input disabledInput" type="checkbox" @if($mode=='view') disabled @endif id="phone" value="phone" @if(isset($intermidiatData['contact_phone']) && $intermidiatData['contact_phone']=='yes') checked @endif>
                                              <label class="form-check-label" for="phone">Phone</label>
                                            </div>

                                             
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                              <input class="form-check-input disabledInput" name="marketing_email" type="checkbox" @if($mode=='view') disabled @endif value="yes" id="yes_marketing_mails" @if(isset($intermidiatData['marketingmail']) && $intermidiatData['marketingmail']=='yes') checked @endif>
                                              <label class="form-check-label" for="yes_marketing_mails">
                                                Yes, I am happy to receive marketing emails from the platform
                                              </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                              <input class="form-check-input disabledInput" name="marketing_mails_partners" @if($mode=='view') disabled @endif type="checkbox" value="yes" id="yes_marketing_mails_partners" @if(isset($intermidiatData['marketingmail_partner']) && $intermidiatData['marketingmail_partner']=='yes') checked @endif>
                                              <label class="form-check-label" for="yes_marketing_mails_partners" >
                                                Yes, I am happy to receive marketing emails from the platform from selected partners of the platform
                                              </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                  </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="">
                        <a href="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}" class="btn btn-primary mt-3"><i class="fa fa-angle-double-left"></i>Prev</a>
                     
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-primary mt-3 editmode @if($mode=='view') d-none @endif">Save</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="gi_code" value="{{ $user->gi_code }}">
            </form>
        </div>
    </div>
    </div>

    <style type="text/css">
        #datatable-users_filter{
            display: none;
        }
    </style>
 
@endsection

