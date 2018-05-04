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
         <ul class="progress-indicator my-5">
            <li class="active" part="part-1">
               <a href="javascript:void(0)">Part 1</a>
               <span class="bubble"></span>
            </li>
            <li class="active" part="part-2">
               <a href="javascript:void(0)">Part 2</a>
               <span class="bubble"></span>
            </li>
            <li class="active" part="part-3">
               <a href="javascript:void(0)">Part 3</a>
               <span class="bubble"></span>
            </li>
         </ul>
         
         Dear Adviser,<br><br>

Many thanks for submitting your asset transfer request. In a short while you will receive an email confirming the details of your request.<br>
The below forms can be signed through E-signature or are available to download for offline completion. As soon as we have these signed we will commence the transfer.<br>
Please check these forms thoroughly, if you find any errors or have any questions please contact client services on support@growthinvest.com or 020 7071 3945.<br>
Follow the mailing instructions on each separate form and always remember to make a copy of your signed forms and certification.<br><br>

<b>There are 3 documents needed for your asset transfer :</b><br><br>
Letter of Authority - Enables us to complete the transfer on your/your client’s behalf<br>
<a href="{{ url('backoffice/transfer-asset/'.$transferasset->id.'/download/letter_of_authority_pdf')}}"  class="btn btn-primary mt-2 " target="_blank">Download </a>
<button  class="btn btn-primary mt-3 esign_doc" assetid="{{ $transferasset->id }}" assettype ="letter_of_authority_pdf">Send for E-SIGN </button><br><br>

Stock Transfer Form - Please fill out and send to us as we required for our own records regardless of Stamp Duty status<br>
<a href="{{ url('backoffice/transfer-asset/'.$transferasset->id.'/download/stock_transfer_form')}}"  class="btn btn-primary mt-2" target="_blank">Download </a>
<button class="btn btn-primary mt-3 esign_doc" assetid="{{ $transferasset->id }}" assettype ="stock_transfer_form">Send for E-SIGN </button><br><br>

Asset Transfer Form - Always save a copy for your own record and send for electronic signature<br>
<a href="{{ url('backoffice/transfer-asset/'.$transferasset->id.'/download/transfer_asset_pdf')}}"    class="btn btn-primary mt-3 " target="_blank">Download </a>

<button class="btn btn-primary mt-3 esign_doc" assetid="{{ $transferasset->id }}" assettype ="transfer_asset_pdf">Send for E-SIGN </button>

<br>
<br>

<a href="{{url('backoffice/transfer-asset/online')}}" class="btn btn-primary mt-2"> New Asset Transfer</a>
 

      </div>
   </div>
</div>
@endsection