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

        <div class="col-md-10 bg-white border border-gray border-left-0 border-right-0">
            <div class="mt-4 p-2">
              <div class="row align-items-center mb-4">
                <div class="col-sm-1">
                  <img src="{{ url('img/diversity.png') }}" width="" height="" class="img-fluid" alt="Activity Analysis">
                </div>
                <div class="col-sm-11">
                  <h1 class="section-title font-weight-medium text-primary mb-0">Transfer Assets</h1>
                </div>
              </div>

            <b>  At GrowthInvest we enable Advisers to on­board existing client tax assets, in order to benefit from aggregated portfolio monitoring, reporting and adviser fee management. At present we can facilitate single companies, EIS portfolio services, IHT services and VCTs.</b>
            <br><br>

            <b>How does it work?</b><br>
            In order to transfer assets, you will need to complete a full account application and set up a nominee account form for each investor. Once fully registered, a short individual transfer form for each investment is required.
            <br><br>

            We are very happy to help with any multi-investor or multi-investment transfers. Please contact us via support@growthinvest.com, or 020 7071 3945
                
            
            <div class="row mb-4">
                <div class="col-md-5">
                    <b>These are four main stages to an Asset Transfer:</b>
                    <p class="text-muted">Register a new client on the platform</p>
                </div>
                <div class="col-md-7">
                    <div class="bg-gray p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ url('img/image-transfer-asset.jpg')}}" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <h5 class="font-weight-normal text-dark">Download our Transfer Assets Guide</h5>
                                <p class="mb-1">Our online transfer service allows you to transfer SEIS, EIS, VCT and other tax efficient investments.</p>
                                <button class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <ul class="asset-transfer-steps clearfix m-t-25">
                <li class="steps-reg">
                    <div class="brand-band white text-center">
                        Register Client
                    </div>
                    <ul class="clearfix">
                        <li>
                            Online Platform Account
                        </li>
                        <li>
                            Nominee Account setup
                        </li>
                        <li>
                            Full access to all existing platform investments and funds
                        </li>
                        <li>
                            Full support for clients and advisers available
                        </li>
                    </ul>
                </li>
                <li class="steps-reg">
                    <div class="brand-band white text-center">
                        Request Transfer
                    </div>
                    <ul class="clearfix">
                        <li>
                            Select from large selection of existing companies & funds or add additional
                        </li>
                        <li>
                            Online Transfer Request Confirmed
                        </li>
                        <li>
                            Prepopulated forms produced
                        </li>
                        <li>
                            Client Signs all documents & forms
                        </li>
                        <li>
                            Document sent
                        </li>
                        <li>
                            on and off line options available
                        </li>
                    </ul>
                </li>
                <li class="steps-reg">
                    <div class="brand-band white text-center">
                        Transition Phase
                    </div>
                    <ul class="clearfix">
                        <li>
                            Platform contacts and chases all 3
                            <sup>
                                rd
                            </sup>
                            parties
                        </li>
                        <li>
                            Confirmation of receipt and ETA's sought from all 3
                            <sup>
                                rd
                            </sup>
                            parties
                        </li>
                        <li>
                            Online updates available at all times
                        </li>
                        <li>
                            Regular update emails on all transfers
                        </li>
                    </ul>
                </li>
                <li class="steps-reg">
                    <div class="brand-band white text-center">
                        On Board
                    </div>
                    <ul class="clearfix">
                        <li>
                            Once completed, notification sent to client & adviser
                        </li>
                        <li>
                            Assets available and visible in consolidated client portfolio
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="asset-transfer-steps-imgs clearfix">
                <li class="steps-reg">  <img src="{{ url('img/assistance.png') }}" alt="" class="img-responsive center-block"></li>
                <li class="steps-reg">  <img src="{{ url('img/edit.jpeg') }}" alt="" class="img-responsive center-block"></li>
                <li class="steps-reg">  <img src="{{ url('img/Round.png') }}" alt="" class="img-responsive center-block"></li>
                <li class="steps-reg">  <img src="{{ url('img/due-diligence.png') }}" alt="" class="img-responsive center-block"></li>
            </ul>

            <b>How do I get started?</b><br>
            In order to transfer assets, you will need to complete a full account application and setup a nominee account form for each investor. If your client appears in the dropdown box below, then they are fully registered and you can begin the transfer process by selecting the client name.
            <br><br>

             <b>If you cannot see your client in the drop down there are 2 options:</b><br>

            If you would like to register a brand new client and transfer assets - please go to Add Clients Dashboard
            If you would like to complete the account setup for a registered client, please go to Manage Client Dashboard
            To complete offline asset tranfer please click "Offline Asset Transfer" below and if you wish to proceed through online method, please click "Online Asset Transfer"
            <br><br>

            <a href="{{url('backoffice/transfer-asset/online')}}" class="btn btn-primary mt-2 ld-ext-right">Online Asset Transfer</a>
            <a href="{{url('backoffice/transfer-asset/offline')}}" class="btn btn-primary mt-2 ld-ext-right">Offline Asset Transfer</a>
          

        </div>
    </div>


</div>
 

    

@endsection

