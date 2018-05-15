@extends('layouts.backoffice')
 
 
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
         <!-- <div class="row align-items-center mb-4">
            <div class="col-sm-11"> -->
               <h1 class="section-title font-weight-medium text-primary mb-4">Offline Asset Transfer</h1>
            <!-- </div>
         </div> -->
         <p class="font-weight-semi-bold">Please download the correct form below to complete a GrowthInvest offline asset transfer. This document would be required to be sent to us with you or your client's signature. We will commence the transfer as soon as we receive the forms. If you are transferring assets that we do not yet host on the platform please fill out the Asset Request Form, this normally takes a while longer to complete.</p>

<div class="mb-4">
   <p class="font-weight-semi-bold mb-0">Assets ready for transfer are :</p>
   <ul class="ml--15">
      <li>IHT</li>
      <li>Single Company</li>
      <li>Eis/SEIS Portfolio or Fund</li>
      <li>VCT</li>
   </ul>
</div>
       
<p class="font-weight-semi-bold">There are 3 documents needed for your asset transfer :</p>
<ul class="ml--15">
   <li class="mb-3">
      <p class="mb-0">Letter of Authority - Enables us to complete the transfer on your/your client’s behalf</p>
      <a href="{{ url('uploads/offline-pdf/Authority Letter for Transfer Asset Doc.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">DOWNLOAD (BLANK PDF) </a>
   </li>

   <li class="mb-3">
      <p class="mb-0">Stock Transfer Form - Please fill out and send to us as we required for our own records regardless of Stamp Duty status</p>
      <a href="{{ url('uploads/offline-pdf/Stock Transfer Form.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">DOWNLOAD (BLANK PDF) </a>
   </li>

   <li class="mb-3">
      <p class="mb-0">Asset Transfer Form - Always save a copy for your own record and send for electronic signature</p>
      <a href="{{ url('uploads/offline-pdf/Asset Transfer Form - IHT.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">IHT (BLANK PDF) </a>
      <a href="{{ url('uploads/offline-pdf/Transfer Asset Form Single Company.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">SINGLE COMPANY(BLANK PDF)</a>
      <a href="{{ url('uploads/offline-pdf/Asset Transfer Form - Portfolio.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">PORTFOLIO(BLANK PDF) </a>
      <a href="{{ url('uploads/offline-pdf/Transfer Asset Form - VCT.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">VCT (BLANK PDF) </a>
   </li>

   <li class="mb-3">
      <p class="mb-0">Asset Request Form - Transfer assets to Growthinvest we do not yet host</p>
      <a href="{{ url('uploads/offline-pdf/Asset Request Form.pdf')}}"  class="btn btn-primary mt-2 " target="_blank">Asset Request Form </a>
   </li>
</ul>

      </div>
   </div>
</div>
@endsection