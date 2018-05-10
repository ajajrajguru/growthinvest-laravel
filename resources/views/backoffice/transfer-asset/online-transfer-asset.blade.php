@extends('layouts.backoffice')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" >
<link rel="stylesheet" href="{{ asset('/bower_components/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') }}" >
<style>
   #activitysummarychart {
   width   : 100%;
   height  : 700px;
   }                                       
</style>
@endsection
@section('js')
@parent
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" ></script>
<script type="text/javascript">
   $(document).ready(function() {
       // select2
   
       $('.select2-single').select2({
           // placeholder: "Search here"
       });
   });
   
</script>
<script type="text/javascript" src="{{ asset('bower_components/cropper/dist/cropper.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/plupload/js/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/aj-uploads.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function() {
       uploadFiles('uploader','{{ url("upload-files") }}');
   });
</script>
@endsection
@section('backoffice-content')
<div class="container">
@php
echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
@endphp
<div class="row mt-5 mx-0">
   <div class="col-md-2 bg-white px-0">
      @include('includes.side-menu')
   </div>
   <div class="col-md-10 bg-white border border-gray border-left-0 border-right-0 transfer-asset">
      <div class="mt-4 p-2">
         <a href="{{ url('backoffice/transfer-asset')}}" class="btn btn-outline-primary mb-4"><i class="fa fa-angle-double-left"></i> Back</a>
         <div class="row align-items-center mb-4">
            <div class="col-sm-11">
               <h1 class="section-title font-weight-medium text-primary mb-0">Online Asset Transfer</h1>
            </div>
         </div>
         Please follow the instructions below for the online completion of asset transfers. If you require assistance or have any questions please do not hesitate to contact our help team on 020 7071 3945
         <br>
         <br>
         <div class="card-header">Transfer Asset</div>
         Please select your client from the dropdown list below to view existing asset transfers or start a new one. Please note that only fully registered clients with nominee accounts will appear in the dropdown list.
         <ul class="progress-indicator my-5">
            <li class="active" part="part-1">
               <a href="javascript:void(0)">Part 1</a>
               <span class="bubble"></span>
            </li>
            <li part="part-2">
               <a href="javascript:void(0)">Part 2</a>
               <span class="bubble"></span>
            </li>
            <li part="part-3">
               <a href="javascript:void(0)">Part 3</a>
               <span class="bubble"></span>
            </li>
         </ul>
          <form method="post" name="online_transfer_asset" action="{{ url('backoffice/transfer-asset/save-online-asset') }}" data-parsley-validate name="add-investor-reg" id="add-investor-reg" enctype="multipart/form-data">
         <div class="part-container part-1">
            <div class="row">
               <div class="col-md-3 text-center" >
                  <div class="form-group">
                     <label>Select Client <span class="text-danger">*</span></label>
                     <select name="investor" class="form-control select2-single" data-parsley-required >
                        <option value="">-select-</option>
                        @foreach($investors as $investor)
                        <option value="{{ $investor->id }}">{{ $investor->first_name.' '.$investor->last_name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <h3>View Assets</h3>
               <table class="table table-bordered cust-table" id="view_all_firms_table">
                  <thead>
                     <tr class="">
                        <th width="10%">
                           Type of Assets
                        </th>
                        <th  width="10%">
                           Company Name
                        </th>
                        <th class="subheader_cell-cust" width="10%">
                           Type of Share
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           No of Shares to be transferred
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           Current name on share certificate
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           Name of Product
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           Client Account Number
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           Transfer Type
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           Custody/Non-Custody
                        </th>
                        <th class="subheader_cell-cust" width="9%">
                           Amount
                        </th>
                        <th class="subheader_cell-cust" width="10%">
                           Documents / Underlying Companies
                        </th>
                        <th class="subheader_cell-cust" width="6%">
                           Action
                        </th>
                        <th class="subheader_cell-cust" width="6%">
                           Status
                        </th>
                        <!--<th class="subheader_cell firm_user_manager ">WM Commission Collected</th>            <th class="subheader_cell firm_user_manager ">Introducer Commission Due</th>            <th class="subheader_cell firm_user_manager ">Introducer Commission Collected</th>-->
                     </tr>
                  </thead>
                  <tbody class="data_container">
                      <tr><td  colspan="13" class="text-center"> No Data Found</td></tr>
                  </tbody>
               </table>
               <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 display-section d-none" part="part-2"><i class="fa fa-angle-double-right"></i> Next</a>
            </div> 
         </div>
         <!--  -->
         <!-- part 2 -->
         <div class="part-container part-2 d-none">
            <div class="row">
               <div class="col-md-3 text-center" >
                  <div class="form-group">
                     <label>Type of Asset <span class="text-danger">*</span></label>
                     <select name="type_of_asset" class="form-control select2-single" data-parsley-required  >
                        <option value="">-select-</option>
                        @foreach($typeOfAssets as $key=>$typeOfAsset)
                        <option value="{{ $key }}">{{ $typeOfAsset }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <!-- company section -->
            <div class="row border py-3 bg-light align-items-md-center mx-0 d-none company-section">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>Company<span class="text-danger">*</span></label>
                           <select name="companies" class="form-control select2-single" data-parsley-required   >
                              <option value="">-select-</option>
                              @foreach($single_companies as $key=>$company)
                              <option name="{{ $company->name }}" company_no="{{ $company->company_no }}" email="{{ $company->email }}" phone="{{ $company->phone }}" value="{{ $company->id }}" class="" type="{{ $company->type }}">{{ $company->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Company Name (as registered at companies house)<span class="text-danger">*</span></label>
                           <input type="text"  name="company[assets_cmpname]" data-parsley-required  input_name="assets_cmpname" class="form-control update-summary company_name"  >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Company Number</label>
                           <input type="text"  name="company[assets_cmpno]" input_name="assets_cmpno" class="form-control update-summary company_no"  >
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Email</label>
                           <input type="text"  name="company[assets_cmpemail]" input_name="assets_cmpemail" class="form-control update-summary company_email"  >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Company Telephone</label>
                           <input type="text"  name="company[assets_cmpphone]" input_name="assets_cmpphone" class="form-control update-summary company_tel"  >
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Type of share (e.g. "Ordinary")</label>
                           <input type="text"  name="company[assets_typeofshare]" input_name="assets_typeofshare" class="form-control update-summary"  >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Number of shares to be transferred</label>
                           <input type="text"  name="company[assets_noofshares]" input_name="assets_noofshares" class="form-control update-summary"  >
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Current name on share certificate</label>
                           <input type="text"  name="company[assets_nameonsharecertificate]" input_name="assets_nameonsharecertificate" class="form-control update-summary"  >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Custody / Non-Custody</label>
                           <select name="company[assets_aicustody]" input_name="assets_aicustody" is_select="true" class="form-control update-summary">
                              <option value="">--select--</option>
                              <option value="aic">Custody</option>
                              <option value="ainc">Non-Custody</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- provider section -->
            <div class="row border py-3 bg-light align-items-md-center mx-0 d-none provider-section">
               <div class="col-md-12">
                  <h3>Details of Provider</h3>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Providers<span class="text-danger">*</span></label>
                           <select name="providers" class="form-control select2-single" data-parsley-required  >
                              <option value="">-select-</option>
                              @foreach($other_companies as $key=>$other_company)
                              <option name="{{ $other_company->name }}" product="{{ $other_company->product }}" email="{{ $other_company->email }}" phone="{{ $other_company->phone }}" value="{{ $other_company->id }}" class="" type="{{ $other_company->type }}">{{ $other_company->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Name of Provider<span class="text-danger">*</span></label>
                           <input type="text"  name="provider[assets_providername]" data-parsley-required  input_name="assets_providername" class="form-control update-summary provider_name"  >
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Name of Product</label>
                           <input type="text"  name="provider[assets_productname]" input_name="assets_productname" class="form-control update-summary provider_product"  >
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Client Account Number</label>
                           <input type="text"  name="provider[assets_clientaccno]" input_name="assets_clientaccno" class="form-control update-summary "  >
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Email</label>
                           <input type="text"  name="provider[assets_provider_email]" input_name="assets_provider_email" class="form-control update-summary provider_email"  >
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Company Telephone</label>
                           <input type="text"  name="provider[assets_provider_phone]" input_name="assets_provider_phone" class="form-control update-summary provider_tel"  >
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Custody / Non-Custody</label>
                           <select   name="provider[assets_provider_aicustody]" input_name="assets_provider_aicustody" class="form-control update-summary">
                              <option value="">--select--</option>
                              <option value="aic">Custody</option>
                              <option value="ainc">Non-Custody</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label>Address of Provider</label>
                           <textarea name="provider[assets_provideraddress]" input_name="assets_provideraddress" class="form-control update-summary"  ></textarea>
                        </div>
                     </div>
                  </div>
                  <div class="row vct-section">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>ISIN No</label>
                           <input type="text"  name="provider[isinno]" input_name="isinno" class="form-control update-summary"  >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>SEDOL Code</label>
                           <input type="text"  name="provider[sedol]" input_name="sedol" class="form-control update-summary"  >
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>County</label>
                           <input type="text"  name="provider[assets_county]" input_name="assets_county" class="form-control update-summary"  >
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Postcode</label>
                           <input type="text"  name="provider[assets_pincode]" input_name="assets_pincode" class="form-control update-summary"  >
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>Please Transfer</label>
                           <div class=" ">
                              <div class="custom-control custom-radio">
                                 <input type="radio" id="yesrodio1" input_name="typeoftransfer" name="provider[typeoftransfer]" value="full" class="custom-control-input update-summary"  checked display-text="In Full">
                                 <label class="custom-control-label normal" for="yesrodio1" >In Full  </label>
                              </div>
                              <div class="custom-control custom-radio">
                                 <input type="radio" id="norodio1" input_name="typeoftransfer" name="provider[typeoftransfer]" value="part" class="custom-control-input update-summary" display-text="In Part">
                                 <label class="custom-control-label normal" for="norodio1" > In Part</label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row upload-files-section d-none">
               <div id="uploader">
                  <p></p>
               </div>
               <div class="uploaded-file-path"></div>
            </div>
            <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 display-section" part="part-1"><i class="fa fa-angle-double-left"></i> Prev</a>
            <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 display-section d-none" part="part-3"><i class="fa fa-angle-double-right"></i> Next</a>
         </div>
         <!--  -->
         <div class="part-container part-3 d-none">
            Type of Asset: <span class="type_of_asset_summary"></span><br><br>
            Name of Client: <span class="name_of_client_summary"></span><br><br>
            <div class="row border py-3 bg-light  mx-0 d-none company-section">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Company Name (as registered at companies house) :</label>
                        <span class="assets_cmpname_summary text-capitalize"></span>          
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Company Number :</label>
                        <span class="assets_cmpno_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Email  :</label><span class="assets_cmpemail_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Company Telephone  :</label><span class="assets_cmpphone_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Type of share (e.g. "ordinary")  :</label><span class="assets_typeofshare_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Number of shares to be transferred  :</label><span class="assets_noofshares_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Current name on share certificate  :</label><span class="assets_nameonsharecertificate_summary text-capitalize"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Custody / Non-Custody  :</label><span class="assets_aicustody_summary text-capitalize"></span>
                     </div>
                  </div>
               </div>
               <button type="submit" name="btn_save" class="btn btn-primary mt-2 ld-ext-right">Save</button>
            </div>
            <div class="row border py-3 bg-light align-items-md-center mx-0 d-none provider-section">
               <h3>Details of Provider :</h3>
               <br><br>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Name of Provider :</label><span class="assets_providername_summary text-capitalize"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Name of Product :</label><span class="assets_productname_summary text-capitalize"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Client Account Number :</label><span class="assets_clientaccno_summary "></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Postcode :</label><span class="assets_pincode_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Address of Provider :</label><span class="assets_provideraddress_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Email :</label><span class="assets_cmpname_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Company Telephone :</label><span class="assets_provider_phone_summary"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Custody / Non-Custody :</label><span class="assets_provider_aicustody_summary text-capitalize"></span>
                     </div>
                  </div>
               </div>
               <div class="vct-section">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>
                           ISIN No :</label><span class="isinno_summary"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>
                           SEDOL Code :</label><span class="sedol_summary"></span> 
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        County :</label><span class="assets_county_summary text-capitalize"></span> 
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>
                        Please Transfer :</label>  <span class="typeoftransfer_summary">In Full</span>
                     </div>
                  </div>
               </div>
               <button type="submit" name="btn_save" class="btn btn-primary mt-2 ld-ext-right">Save</button>
            </div>
            <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 display-section" part="part-2"><i class="fa fa-angle-double-left"></i> Prev</a>
         </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
     </form>
      </div>
   </div>
</div>
@endsection