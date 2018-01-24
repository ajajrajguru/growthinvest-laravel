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
    <div class="d-flex flex-row mt-5 bg-white border border-gray">
        @include('includes.side-menu')

        <div class="tab-content">
            <div class="tab-pane fade" id="home" role="tabpanel">
                <h1>Lorem</h1>

                <p>Aenean sed lacus id mi scelerisque tristique. Nunc sed ex sed turpis fringilla aliquet in in neque. Praesent posuere, neque rhoncus sollicitudin fermentum, erat ligula volutpat dui, nec dapibus ligula lorem ac mauris. Etiam et leo venenatis purus pharetra dictum.</p>

                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin tempor mi ut risus laoreet molestie. Duis augue risus, fringilla et nibh ac, convallis cursus purus. Suspendisse potenti. Praesent pretium eros eleifend posuere facilisis. Proin ut magna vitae nulla suscipit eleifend. Ut bibendum pulvinar sapien, vel tristique felis scelerisque et. Sed elementum sapien magna, placerat interdum lacus placerat ut. Integer varius, ligula bibendum laoreet sollicitudin, eros metus fringilla lectus, quis consequat nisl nibh ut nisi. Aenean dignissim, nibh ac fermentum condimentum, ante nisl rutrum sapien, at commodo eros sapien vulputate arcu. Fusce neque leo, blandit nec lectus eu, vestibulum commodo tellus. Aliquam sem libero, tristique at condimentum ac, luctus nec nulla.</p>
            </div>
            <div class="tab-pane fade" id="manage_clients" role="tabpanel">
                <h1>Ipsum</h1>

                <p>Aenean pharetra risus quis placerat euismod. Praesent mattis lorem eget massa euismod sollicitudin. Donec porta nulla ut blandit vehicula. Mauris sagittis lorem nec mauris placerat, et molestie elit vehicula. Donec libero ex, condimentum et mi dapibus, euismod ornare ligula.</p>

                <p>In faucibus tempus ante, et tempor magna luctus id. Ut a maximus ipsum. Duis eu velit nec libero pretium pellentesque. Maecenas auctor hendrerit pulvinar. Donec sed tortor interdum, sodales elit vel, tempor turpis. In tristique vestibulum eros vel congue. Vivamus maximus posuere fringilla. Nullam in est commodo, tristique ligula eu, tincidunt enim. Duis iaculis sodales lectus vitae cursus.</p>
            </div>
            <div class="tab-pane fade show active" id="add_clients" role="tabpanel">
 

                <div class="p-2">
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <h1 class="section-title font-weight-medium text-primary mt-4 mb-0">Add Investor</h1>
                            <p class="text-muted">Register a new client on the platform</p>
                        </div>
                        <div class="col-md-7">
                            <div class="bg-gray p-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ url('img/image-transfer-asset.jpg')}}" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="font-weight-normal text-dark">Download our Client Registration Guide</h5>
                                        <p class="mb-1">A straightforward guide to getting your clients up and running on the platform.</p>
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('includes.notification')

                    <div class="row">
                        <div class="col-9">
                            <div class="border border-primary border-2 bg-gray p-3 mb-4">
                                <div class="text-center">
                                    <h5 class="m-0">
                                        <small class=" font-weight-medium">
                                            Platform Account Registration
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border border-transparent border-2 bg-gray p-3 mb-4">
                                <div class="text-center">
                                    <h5 class="m-0">
                                        <small class=" font-weight-medium">
                                            Investment Account
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="progress-indicator">
                        <li class="completed">
                            <a href="javascript:void(0)">Registration</a>
                            <span class="bubble"></span>
                        </li>
                        <li class="active">
                            <a href="javascript:void(0)">Client Categorisation</a>
                            <span class="bubble"></span>
                        </li>
                        <li>
                            <a href="javascript:void(0)">Additional Information</a>
                            <span class="bubble"></span>
                        </li>
                        <li>
                            <a href="javascript:void(0)">Investment Account</a>
                            <span class="bubble"></span>
                        </li>
                    </ul>
                </div>


                <div class="profile-content p-4">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <button type="button" class="btn btn-outline-primary mb-4"><i class="fa fa-angle-double-left"></i> Prev</button>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary mb-4">Next <i class="fa fa-angle-double-right"></i></button>
                        </div>
                    </div>

                    <h5 class="mt-3 mb-2">
                        2: <i class="fa fa-group text-primary"> </i> <span class="text-primary">  Client Categorisation</span>
                    </h5>
                    <hr class="my-3">

                    <div class="mb-5">
                        <p>
                        In order to access our platform we need to categorise your client as one of 6 different types of Investor. These are all listed below, so please click on each box below, read the descriptions and select the one you feel is most appropriate.</p>

                        <p> Once you have selected a category, please then complete the certification process as instructed. A copy of the certification document will be held in your investor’s document library, and investor will be prompted to revisit and renew the categorisation periodically.</p>

                        <p> We may need to contact the investor to confirm some details and ensure we are happy that your categorisation is appropriate. If your investor's circumstances change, he will be able to re-certify at any stage. If you or your client have any questions at all please contact a member of the GrowthInvest team on 020 7071 3945 or via .<a href="mailto:suppport@growthinvest.com">suppport@growthinvest.com</a></p>
                    </div>

                    <div class="register-tab">
                        <div class="row">
                            <div id="tabs-container">
                                <ul class="nav nav-tabs " role="tablist">

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link active" href="#tab-1" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{ url('img/hand132.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                RETAIL (RESTRICTED) INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link" href="#tab-2" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/office-worker1.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                SOPHISTICATED INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link" href="#tab-3" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/coin.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                            HIGH NET WORTH INDIVIDUAL
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link" href="#tab-4" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/group47.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                PROFESSIONAL INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link" href="#tab-5" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/staff1.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                ADVISED INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link" href="#tab-6" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/money-bag1.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                            ELECTIVE PROFESSIONAL INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                            </div>
                        </div>

                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fadein active" id="tab-1">
                            @php
                            $clientCategory = $clientCategories->firstWhere('slug','retail_restricted_investor'); 
                            $getQuestionnaire = $clientCategory->getCertificationQuesionnaire(); 
                            $isRetail = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false;
                            @endphp
                           <h4 class="my-3 text-primary">
                              Retail (Restricted) Investor
                           </h4>
                           <p>
                              Retail (restricted) investors must declare that they are not investing more than 10% of their net assets (including savings, stocks, ISAs, bonds and property; excluding your primary residence) into unquoted companies as a result of using GrowthInvest.
                           </p>
                           <p>
                              If you wish to classify your client as a Retail Restricted Investor on the GrowthInvest, please complete the short <span class="text-primary">Investor Questionnaire </span>below and then complete the statement below
                           </p>
                           <div id="" role="tablist" class="gi-collapse">
                              <div class="card mb-3">
                                 <div class="card-header" role="tab" id="headingOne">
                                    <a data-toggle="collapse" href="#collapseOne" role="button">
                                    Investor Questionnaire
                                    <i class="fa fa-lg fa-plus-square-o"></i>
                                    <i class="fa fa-lg fa-minus-square-o"></i>
                                    </a>
                                 </div>
                              </div>
                              <div id="collapseOne" class="collapse show mb-5" role="tabpanel">
                                 <div class="card-body">
                                    <div class="quiz-container">
                                       <ol>
                                                                                    
                                          
                                            @if(!empty($getQuestionnaire))
                                                
                                                @foreach($getQuestionnaire as $key=>$questionnaire)
                                                    <li class="mb-2 questions">
                                                     <div class="form-group">
                                                        <label class="quiz-question">
                                                            {{ $questionnaire->questions}}
                                                        </label>
                                                        <ul>
                                                          
                                                          @foreach($questionnaire->options as $key2=> $option)
                                                           <li class="custom-control custom-radio">
                                                              <input type="radio" id="option_{{ $key.'_'.$key2 }}" name="radiobtn_{{ $key }}" class="custom-control-input question-option" data-correct="{{ $option->correct }}" @if($isRetail && $option->correct) checked @endif>
                                                              <label class="custom-control-label normal" for ="option_{{ $key.'_'.$key2 }}">
                                                              {{ $option->label }}
                                                              </label>
                                                           </li>
                                                       
                                                           @endforeach  
                                                            
                                                        </ul>
                                                     </div>
                                                  </li>

                                                @endforeach
                                            @endif
 
                                           
                                       </ol>
                                       @if(!$isRetail)
                                       <button type="button" class="btn btn-primary pull-right retail-quiz-btn submit-quiz" >
                                       Submit Quiz
                                       </button>
                                       @endif
                                       <br><br>
                                       <div class="alert alert-success quiz-success d-none" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                           <span id="message"></span>
                                        </div>
                                         
                                        <div class="alert alert-danger quiz-danger d-none" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                           <span id="message"></span>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <b class="mb-5">
                           I make this statement so that I can receive promotional communications relating to non-readily realisable securities as a retail (restricted) investor. I declare that I qualify as a retail (restricted) investor because:
                           </b>
                           <ul class=" mb-5">
                              <li>In the preceding twelve months, I have not invested more than 10% of my net assets in non-readily realisable securities; and </li>
                              <li>I undertake that in the next twelve months I will not invest more than 10% of my net assets in non-readily realisable securities. </li>
                           </ul>
                           <b class="mb-5">
                           Net assets for these purposes do not include:
                           </b>
                           <ul class="mb-5">
                              <li>The property which is my primary residence or any money raised through a loan secured on that property;</li>
                              <li>Any rights of mine under a qualifying contract of insurance; OR </li>
                              <li>Any benefits (in the form of pensions or otherwise) which are payable on the termination of my service or on my death or retirement and to which I am (or my dependants are), or may be entitled. </li>
                           </ul>
                           <div class="alert alert-primary" id="">
                              <div class="text-primary">
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input retail-input" name="ri_check_0" id="ri_acceptInvestments" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ri_check_0',$investorCertification->details['conditions'])) checked @endif>
                                       <label class="custom-control-label normal text-primary" for="ri_acceptInvestments">I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</label>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" name="ri_check_1" class="custom-control-input retail-input" id="ri_retailinvestor" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ri_check_1',$investorCertification->details['conditions'])) checked @endif>
                                       <label class="custom-control-label normal text-primary" for="ri_retailinvestor">I wish to be treated as a Retail (Restricted) Investor.</label>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" name="ri_check_2" class="custom-control-input retail-input" id="ri_riskwarning" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ri_check_2',$investorCertification->details['conditions'])) checked @endif>
                                       <label class="custom-control-label normal text-primary" for="ri_riskwarning">I have read and understand the risk warning.</label>
                                    </div>
                                 </div>
                                 <div class="mb-3">
                                    <div>
                                       @if(!$isRetail) 
                                       <button class="btn btn-primary save-retial-certification" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" get-input-class="retail-input">Submit</button>
                                       @endif
                                    </div>
                                 </div>
                                 <div>
                                    Name: {{ $investor->first_name .' '.$investor->last_name}} 
                                 </div>
                                 <div>
                                    Date: {{ (!empty($investorCertification)) ? date('d/m/Y', strtotime($investorCertification->created_at)) : date('d/m/Y') }}
                                 </div>
                              </div>
                           </div>
                           <div class="alert bg-gray">
                              <span>You can change your Client Certification here</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="font-weight-medium">Certification : </label>
                                        <select name="certification_type" class="form-control editmode @if($mode=='view') d-none @endif" >
                                            <option>Select Certification</option>
                                            @foreach($certificationTypes as $key=> $certificationType)
                                            <option value="{{ $key }}" {{ (!empty($investorCertification) && $investorCertification->certification == $key) ? 'selected' : '' }} >{{ $certificationType }}</option>
                                            @endforeach
                                        </select>
                                        <span class="viewmode @if($mode=='edit') d-none @endif">{{ (!empty($investorCertification) && isset($certificationTypes[$investorCertification->certification])) ? $certificationTypes[$investorCertification->certification] : '' }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-primary pull-right editUserBtn" type="button">Edit Details</button>
                                        <button class="btn btn-primary pull-right  d-none cancelUpdateBtn" type="button">Cancel Updates</button>

                                    </div>
                                </div>
                           </div>

                           <div class="alert bg-gray certification-success d-none">
                                <div class="pull-left l-30">                                                                                
                                    <i class="icon icon-ok text-success"></i> Certified on                                           
                                 <span class="date-rem">{{ (!empty($investorCertification)) ? date('d/m/Y', strtotime($investorCertification->created_at)) : date('d/m/Y') }}                                          
                                    <a href="">(Click to download)</a>
                                </span>&nbsp;                                            
                                <span class="text-danger">
                                    and valid for: a year                                            
                                </span>                                                        
                                </div>                
                            </div>


                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab-2">
                            <h4 class="my-3 text-primary">
                                Sophisticated Investor
                            </h4>

                            <div class="alert alert-danger d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                               <span id="message"></span>
                            </div>

                            <form>
                                @php
                                $clientCategory = $clientCategories->firstWhere('slug','sophisticated_investor'); 
                                $isSophisticatedInv = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false;
                                @endphp
                                <span class="mb-5">
                                    <p>
                                        <b>Your client can be considered a Sophisticated Investor if any of the following applies:
                                        </b>
                                    </p>
                                    <ul class="list_ok">
                                        <li>He/She has made more than one investment in an unlisted company in the last 2 years
                                        </li>
                                        <li>He/She has been a member of a network or syndicate of business angel for at least six months
                                        </li>
                                        <li>He/She has worked in the private equity SME finance sector in the last two years
                                        </li>
                                        <li>He/She has been a director of a company with annual turnover in excess of £1m in the last two years
                                        </li>
                                    </ul>
                                </span>
                                <div class="mb-5">
                                    <p>
                                        If you wish your client to be classified as a Sophisticated Investor on the GrowthInvest, please indicate the reason(s) that He/She qualifies and then complete the statement below.
                                    </p>
                                    <p>
                                        My client qualify as a Sophisticated investor and thus exempt under article 50(A) of the Financial Services and Markets Act 2000 after signing this prescribed template with relevant risk warnings and he/she meets at least one of the following criteria:
                                    </p>
                                </div>
                                <div class="alert bg-gray mb-5">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_0" id="ch7" @if(!empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_0',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch7">
                                                He/She has been a member of a network or syndicate of business angels for at least the six months preceding the date of the certificate.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_1" id="ch8" @if(!empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_1',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch8">
                                                He/She has made more than one investment in an unlisted company in the two years preceding that date.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_2" id="ch9"  @if(!empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_2',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch9">
                                                He/She has worked, in the two years preceding that date, in a professional capacity in the private equity sector, or in the provision of finance for small and medium enterprises.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_3" id="ch10"  @if(!empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_3',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch10">
                                                He/She has been, in the two years preceding that date, a director of a company with an annual turnover of at least £1 million.
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <b>
                                    The financial products that are covered in the exemptions (articles 48 and 50A) only apply to certain types of investment:
                                </b>

                                <ul>
                                    <li>
                                        Shares or stock in unlisted companies
                                    </li>
                                    <li>
                                        Collective investment schemes, where the underlying investment is in unlisted company shares or stock
                                    </li>
                                    <li>
                                        Options, futures and contracts for differences that relate to unlisted shares or stock.
                                    </li>
                                </ul>
                                <div class="alert alert-primary" id="">
                                    <div class="text-primary">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input sop-conditions-input"  name="si_check_0" id="si_acceptInvestments" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('si_check_0',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="si_acceptInvestments">I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input sop-conditions-input" name="si_check_1"  id="si_retailinvestor" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('si_check_1',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="si_retailinvestor">I wish to be treated as a Retail (Restricted) Investor.</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input sop-conditions-input" name="si_check_2"  id="si_riskwarning" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('si_check_2',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="si_riskwarning">I have read and understand the risk warning.</label>
                                            </div>
                                        </div>
                                        @if(!$isSophisticatedInv)
                                        <div class="mb-3">
                                            <div>
                                                <button class="btn btn-primary save-sophisticated-Investor" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" get-input-class="retail-input">Submit</button>
                                            </div>
                                        </div>
                                        @endif
                                        <div>
                                             Name: {{ $investor->first_name .' '.$investor->last_name}} 
                                        </div>
                                        <div>
                                            Date: {{ (!empty($investorCertification)) ? date('d/m/Y', strtotime($investorCertification->created_at)) : date('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab-3">
                            <h4 class ="my-3 text-primary">
                                High Net Worth Individual
                            </h4>
                            <form>
                                @php
                                $clientCategory = $clientCategories->firstWhere('slug','high_net_worth_individual'); 
                                $isHighNetworth = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false;
                                @endphp
                                <div class="mb-5">
                                    <p>High Net Worth Individual (“HNWI”) are exempt under article 48 of the FSMA 2000 if they have signed a prescribed template with relevant risk warnings that they have over £100 000 p.a income and net assets excluding primary residence of over £250,000</p>
                                    <p>
                                        If you wish to be classify your client as a High Net Worth Investor on the GrowthInvest, please indicate the reason(s) that your client qualifies and then complete the statement below.
                                    </p>
                                </div>
                                <p>
                                    <b>
                                        My client is a certified high net worth individual because at least one of the following applies:
                                    </b>
                                </p>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input hi-terms-input" id="ch15">
                                            <label class="custom-control-label normal" for="ch15">
                                                He/she had, during the financial year immediately preceding the date below, an annual income to the value of £100,000 or more;
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input hi-terms-input" id="ch16" checked="">
                                            <label class="custom-control-label normal" for="ch16">
                                                He/she held, throughout the financial year immediately preceding the date below, net assets to the value of £250,000 or more. Net assets for these purposes do not include:
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <ol>
                                    <li>
                                        The property which is my client's primary residence or any loan secured on that residence;
                                    </li>
                                    <li>
                                        Any rights of my client's are under a qualifying contract of insurance within the meaning of the Financial Services and Markets Act 2000 (Regulated Activities) Order 2001; or
                                    </li>
                                    <li>
                                        Any benefits (in the form of pensions or otherwise) which are payable on the termination of my client service or on his/her death or retirement and to which he/she (or dependants are), or may be entitled.
                                    </li>
                                </ol>
                                <b>
                                    By agreeing to be categorised as a HNWI, you agree to be communicated financial promotions of certain types of investments, principally;
                                </b>
                                <ul>
                                    <li>
                                        Shares or stock in unlisted companies
                                    </li>
                                    <li>
                                        Collective investment schemes, where the underlying investment is in unlisted company shares or stock
                                    </li>
                                    <li>
                                        Options, futures and contracts for differences that relate to unlisted shares or stock
                                    </li>
                                </ul>
                                <div class="alert alert-primary" id="">
                                    <div class="text-primary">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input hi-conditions-input" name="hi_check_0" id="hi_acceptInvestments">
                                                <label class="custom-control-label normal text-primary" for="hi_acceptInvestments">I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input hi-conditions-input" name="hi_check_1" id="hi_retailinvestor">
                                                <label class="custom-control-label normal text-primary" for="hi_retailinvestor">I wish to be treated as a Retail (Restricted) Investor.</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input hi-conditions-input" name="hi_check_2" id="hi_riskwarning">
                                                <label class="custom-control-label normal text-primary" for="hi_riskwarning">I have read and understand the risk warning.</label>
                                            </div>
                                        </div>
                                        @if(!$isHighNetworth)
                                        <div class="mb-3">
                                            <div>
                                                <button class="btn btn-primary save-high-net-worth" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" >Submit</button>
                                            </div>
                                        </div>
                                        @endif
                                        <div>
                                             Name: {{ $investor->first_name .' '.$investor->last_name}} 
                                        </div>
                                        <div>
                                            Date: {{ (!empty($investorCertification)) ? date('d/m/Y', strtotime($investorCertification->created_at)) : date('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab-4">
                            <h4 class="my-3 text-primary">
                                Professional Investor
                            </h4>
                            <p>A Professional Investor is an investor whom is not designated as a Retail (Restricted) Investor as per the FCA Conduct of Business Handbook <a href="https://fshandbook.info/FS/print/FCA/COBS/3" target="_blank">https://fshandbook.info/FS/print/FCA/COBS/3</a> . If your client falls into one of the below categories then He/She will qualify as a professional investor. As a professional investor GrowthInvest<!-- Seed EIS Platform --> is able to communicate with your client directly in relation to investment business.</p>
                            <p>If you wish to classify your client as a Professional Investor on the GrowthInvest<!-- Seed EIS Platform -->, please indicate the reason(s) that he/she qualifies and then complete the statement below.</p><br>
                            <b>Investment professionals are exempt under Article 14 of the of the Financial Services and Markets Act 2000 (Promotion of Collective Investment Scheme) (Exemptions) Order 2001:</b>
                            <ol class="low-alpha-double-brackets">
                                <li>an authorised person;</li>
                                <li>an exempt person where the communication relates to a controlled activity which is a regulated activity in relation to which the person is exempt;</li>
                                <li>any other person—
                                    <ol class="low-rome-brackets">
                                        <li>whose ordinary activities involve him in carrying on the controlled activity to which the communication relates for the purpose of a business carried on by him; or</li>
                                        <li>who it is reasonable to expect will carry on such activity for the purposes of a business carried on by him;</li>
                                    </ol>
                                </li>
                                <li>a government, local authority (whether in the United Kingdom or elsewhere) or an international organisation;</li>
                                <li>a person ("A") who is a director, officer or employee of a person ("B") falling within any of subparagraphs (a) to (d) where the communication is made to A in that capacity and where A’s responsibilities when acting in that capacity involve him in the carrying on by B of controlled activities.</li>
                            </ol>

                            <div class="alert alert-primary" id="">
                                <div class="text-primary">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="acceptInvestments">
                                            <label class="custom-control-label normal text-primary" for="acceptInvestments">I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="retailinvestor">
                                            <label class="custom-control-label normal text-primary" for="retailinvestor">I wish to be treated as a Retail (Restricted) Investor.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="riskwarning">
                                            <label class="custom-control-label normal text-primary" for="riskwarning">I have read and understand the risk warning.</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <button class="btn btn-primary" type="button">Submit</button>
                                        </div>
                                    </div>
                                    <div>
                                        Name: test3 test3
                                    </div>
                                    <div>
                                        Date: 01/01/2018
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane " id="tab-5">
                            <h4 class="my-3 text-primary">
                                Advised Investor
                            </h4>
                            <p>An advised investor is one that has been assessed and categorised by an FCA regulated company and deemed suitable under COBS9 to receive financial promotions. As an advised investor your client is aware that he/she can seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.</p>
                            <p>Please provide details of the FCA regulated company through which your client has been assessed and categorised. GrowthInvest<!-- Seed EIS Platform --> will treat your client as a Retail (Restricted) Investor until such time as the company is registered as a client and has provided categorisation documentation on your client behalf. </p>
                            <p>If you wish to classify your client as an Advised  Investor on the GrowthInvest<!-- Seed EIS Platform -->, please fill out the short <span class="brand-text">Advised Investor Questionnaire</span> and then complete the statement below</p>

                            <h5>Section 1 - Financial Adviser</h5>
                            <div class="form-group">
                                <label>Does your client have a financial advisor or a wealth manager (authorised person)?</label>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="yes" name="radiobtn" class="custom-control-input">
                                  <label class="custom-control-label medium" for="yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="no" name="radiobtn" class="custom-control-input">
                                  <label class="custom-control-label medium" for="no">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Is your client receiving advice from an Authorised Person in relation to unlisted shares and unlisted debt securities?</label>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="yes2" name="radiobtn2" class="custom-control-input">
                                  <label class="custom-control-label medium" for="yes2">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="no2" name="radiobtn2" class="custom-control-input">
                                  <label class="custom-control-label medium" for="no2">No</label>
                                </div>
                            </div>

                            <div id="" role="tablist" class="gi-collapse mb-3">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <a data-toggle="collapse" href="#collapse1" role="button">
                                          Advised Investor Questionnaire
                                          <i class="fa fa-lg fa-plus-square-o"></i>
                                          <i class="fa fa-lg fa-minus-square-o"></i>
                                        </a>
                                    </div>

                                    <div id="collapse1" class="collapse show" role="tabpanel" >
                                        <div class="card-body">
                                            <p><em>To be completed by your adviser/investment institution/intermediary</em></p>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Firm Name</label>
                                                        <input type="text" class="form-control" name="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>FCA Firm Reference Number</label>
                                                        <input type="text" class="form-control" name="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact Name</label>
                                                        <input type="text" class="form-control" name="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact's FCA Number</label>
                                                        <input type="text" class="form-control" name="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact Email Address</label>
                                                        <input type="text" class="form-control" name="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact Phone Number</label>
                                                        <input type="text" class="form-control" name="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <fieldset>
                                                        <legend>Firm Address</legend>
                                                        <div class="form-group">
                                                            <label>Address 1</label>
                                                            <textarea class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address 2</label>
                                                            <textarea class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Town</label>
                                                            <input type="text" class="form-control" name="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>County</label>
                                                            <select class="form-control">
                                                                <option>Select</option>
                                                                <option>Option1</option>
                                                                <option>Option2</option>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Postcode</label>
                                                                    <input type="text" class="form-control" name="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Country</label>
                                                                <select class="form-control">
                                                                    <option>Select</option>
                                                                    <option>Option1</option>
                                                                    <option>Option2</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-primary" id="">
                                <div class="text-primary">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="acceptInvestments">
                                            <label class="custom-control-label normal text-primary" for="acceptInvestments">I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="retailinvestor">
                                            <label class="custom-control-label normal text-primary" for="retailinvestor">I wish to be treated as a Retail (Restricted) Investor.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="riskwarning">
                                            <label class="custom-control-label normal text-primary" for="riskwarning">I have read and understand the risk warning.</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <button class="btn btn-primary" type="button">Submit</button>
                                        </div>
                                    </div>
                                    <div>
                                        Name: test3 test3
                                    </div>
                                    <div>
                                        Date: 01/01/2018
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane fadein " id="tab-6">
                            <h4 class="my-3 text-primary">
                                Elective Professional Investor
                            </h4>
                            <p>An Elective Professional Investor (Opt Up) Client is someone ordinarily a “Retail” client who wishes to be treated as a “Professional” category client.</p>
                            <p>If categorised as a Retail (Restricted) Investor, Sophisticated Investor or High Net Worth Individual we are unable to conduct business with you via telephone or in person in relation to our investments. However, if you chose to classify your client to become an Elective Professional client and we deem your client suitable then he/she can engage directly with us in respect of investment business.</p>
                            <p>If you wish to classify your client as an  Elective Professional Investor on the GrowthInvest<!-- Seed EIS Platform -->, please complete  the short <span class="brand-text">Elective Professional Investor Questionnaire</span>, and then complete the statement below.</p>

                            <div id="" role="tablist" class="gi-collapse">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <a data-toggle="collapse" href="#epiQuestion" role="button">
                                          Elective Professional Investor Questionnaire
                                          <i class="fa fa-lg fa-plus-square-o"></i>
                                          <i class="fa fa-lg fa-minus-square-o"></i>
                                        </a>
                                    </div>

                                    <div id="epiQuestion" class="collapse show" role="tabpanel" >
                                        <div class="card-body">
                                            <ol>
                                                <li>
                                                    <div class="form-group">
                                                        <label>Most Start­up businesses:</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="succeed" name="startupbiz" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="succeed">Succeed</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="breakeven" name="startupbiz" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="breakeven">Break even</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="fail" name="startupbiz" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="fail">Fail</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>What happens if the start­up I invest in fails?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="yesmoneyback" name="startupfail" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="yesmoneyback">I will get my money back from either the broker who arranged the transaction or the entrepreneurs who founded the business.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="nomoneyback" name="startupfail" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="nomoneyback"> I will unlikely get my money back and no one is liable to pay me back.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>Can I get my money back whenever I want?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="noback" name="moneyback" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="noback">No, not unless the company is bought by another company or floats on a stock exchange.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="yesshares" name="moneyback" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="yesshares"> Yes, I can surrender my shares back to the company and they will give me my money back.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="yessellshares" name="moneyback" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="yessellshares"> Yes, I can sell my shares on a stock exchange and get my money back.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>If the company that I invest in becomes successful, can I sell my shares?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="sharesback" name="successful" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="sharesback"> I will be entitled to sell my shares back the company.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="nosell" name="successful" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="nosell"> I may not be able to sell my shares unless the company is bought by another company, or floats on a stock exchange.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>What happens to your level of shareholding if a company was to issue more shares in the future after you invest?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="shareholdingincrease" name="shareholding" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="shareholdingincrease"> My shareholding will increase.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="shareholdingsame" name="shareholding" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="shareholdingsame"> My shareholding will stay the same.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="shareholdingdecrease" name="shareholding" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="shareholdingdecrease"> My shareholding will decrease.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>The best way to invest in start­ups is to:</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="singleco" name="bestway" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="singleco"> Invest all of my money into a single company.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="startupco" name="bestway" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="startupco"> Invest most of my available capital in a start­up company and invest a very little amount to safer investments.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="multiplecos" name="bestway" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="multiplecos"> Invest a small proportion of my available capital into a start­up business and spread my risk by investing in multiple companies.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>Do start­ups pay dividends?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="nodividends" name="dividends" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="nodividends"> No, generally start­ups do not pay dividends.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="yesyear" name="dividends" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="yesyear"> Yes, I will start to receive dividends within a year after the investment is made.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="yesimmediate" name="dividends" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="yesimmediate"> Yes, I will receive dividends immediately after my investment is made.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>Are you aware that you will have no access to the Financial Services Compensation Scheme (FSCS) in the event of a start-up business failing?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="accessyes" name="noaccess" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="accessyes"> Yes.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="accessno" name="noaccess" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="accessno"> No.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>Are you aware that you may lose all of your invested monies in this investment?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="loseyes" name="losemonies" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="loseyes"> Yes.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="loseno" name="losemonies" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="loseno"> No.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <label>Is the investment being made on your own volition?</label>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="volitionyes" name="volition" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="volitionyes"> Yes.</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                          <input type="radio" id="volitionno" name="volition" class="custom-control-input">
                                                          <label class="custom-control-label normal" for="volitionno"> No.</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <a data-toggle="collapse" href="#epiStatement" role="button" class="collapsed">
                                          Elective Professional Investor Statement
                                          <i class="fa fa-lg fa-plus-square-o"></i>
                                          <i class="fa fa-lg fa-minus-square-o"></i>
                                        </a>
                                    </div>

                                    <div id="epiStatement" class="collapse " role="tabpanel" >
                                        <div class="card-body">
                                            <p><b>The statement below details the rights and protections afforded to Retail investors that are lost when the client opts up to be designated as a Professional.</b></p>
                                            <p><b>Please confirm that you have read and understood the statement below:</b></p>
                                            <p><b>STATEMENT</b></p>
                                            <p>Financial Conduct Authority (“FCA”) Classification</p>
                                            <p>On the basis of information we have about you, or you have given us, and with reference to the rules of the FCA (see http://fshandbook.info/FS/html/FCA/COBS/3/5), we have categorised you as a Professional client by reason of your expertise, experience and knowledge in relation to investing in our financial products and other investment opportunities.</p>
                                            <p>Please note that your categorisation as an elective Professional client applies only for the purpose of enabling us or our affiliates to promote financial products and investment opportunities to you, and that you will not be treated as our client for any other purpose.</p>
                                            <p>As a consequence of this categorisation, we are informing you that you will lose the protections afforded exclusively to Retail clients under the FCA rules. In particular:</p>
                                            <ul class="disc">
                                                <li>Communications and financial promotions made to you will not be subject to the detailed form and content requirements of the FCA’s rules, including those regarding costs and associated charges, that apply in the case of Retail clients.</li>
                                                <li>When communicating with you, we are required to ensure that such communications are fair, clear and not misleading. However, we may take into consideration your status as a Professional client when complying with such requirements and in assessing whether any communication to you is likely to be understood by you and contains appropriate information for you to make an informed assessment of its subject matter;</li>
                                                <li>We will not be restricted from promoting financial products and investment opportunities which are not regulated in the UK and in doing so need not warn you further as regards the protections you will lose;</li>
                                                <li>Because participants in our financial products and investment opportunities are not (or will not on first participating be) Retail clients, we are able to agree with any fund investment that we do not owe a duty of best execution;</li>
                                                <li>Because participants in our financial products and investment opportunities are not Retail clients, the detailed FCA rules on periodic statements are dis-applied. You will however still receive statements in accordance with the other constitutional documents;</li>
                                                <li>In the event that we cease to provide investment advisory services, we are not required to ensure that any business which is outstanding is properly completed but we will nevertheless agree to do so; and</li>
                                                <li>You will have no right of access to the UK’s Financial Ombudsman Service.</li>
                                            </ul>Please read and sign the declaration below to confirm you have read and understand this written notice and wish to be treated as a Professional client.
                                            <p>If you do not agree to the signing of this declaration, we are unable to categorise you as an Elective Professional client in conducting business with you in regard to the financial products and investment opportunities we wish to communicate and market to you.</p>
                                            <p>Yours sincerely,</p>
                                            <p>Daniel Rodwell,<br>
                                            Managing Director<br>
                                            GrowthInvest</p>

                                            <button class="btn btn-primary btn-sm">I Agree</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="my-3">
                                Declaration
                            </h4>
                            <p>Declaration: Notice of Wish to be treated as a Professional client</p>
                            <p>Under the EU’s Markets in Financial Instruments Directive (MiFID), I wish to be treated as an
                                elective Professional client if, subject to your assessment of my expertise, experience, and
                                knowledge of me you are reasonably assured, in light of the nature of the transactions or services
                                envisaged, that I am capable of making my own investment decisions and understand the risks
                                involved. In making your assessment I understand you may rely on information already in your
                                possession and you may request further additional information from me if necessary.</p>
                            <p>As a consequence of this assessment and classification as a Professional client I understand you
                                will be able to promote various financial products and investment opportunities to me. I also
                                understand you are required to obtain written acknowledgement from me that I have been provided
                                with a written notice (as detailed in the above letter) in regards of me being treated as a
                                Professional client.</p>
                            <p>I warrant that I have the necessary expertise, experience and knowledge of making my own
                                investment decisions and understand the risks involved in investing in the financial products and
                                investment opportunities being marketed to me.</p>
                            <p>I also confirm that I have read and understand the differences between the treatment of
                                Professional and Retail clients and that I fully understand the protections and compensation
                                rights that I may lose and the consequences of losing such protections.</p>
                            <p>I am fully aware that it is up to me to keep the firm informed of any change that could
                                affect my categorisation.</p>
                            <p>On the basis of the above information I can confirm that the firm may treat me as a
                                Professional client.</p>
                            <button class="btn btn-primary">Submit</button>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="">
                            <button type="button" class="btn btn-outline-primary mt-4"><i class="fa fa-angle-double-left"></i> Prev</button>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary mt-4">Next <i class="fa fa-angle-double-right"></i></button>
                        </div>
                    </div>
  
                    
                </div>
            </div>
            <div class="tab-pane fade" id="investment_offers" role="tabpanel">
                <h1>Ipsum</h1>

                <p>Aenean pharetra risus quis placerat euismod. Praesent mattis lorem eget massa euismod sollicitudin. Donec porta nulla ut blandit vehicula. Mauris sagittis lorem nec mauris placerat, et molestie elit vehicula. Donec libero ex, condimentum et mi dapibus, euismod ornare ligula.</p>

                <p>In faucibus tempus ante, et tempor magna luctus id. Ut a maximus ipsum. Duis eu velit nec libero pretium pellentesque. Maecenas auctor hendrerit pulvinar. Donec sed tortor interdum, sodales elit vel, tempor turpis. In tristique vestibulum eros vel congue. Vivamus maximus posuere fringilla. Nullam in est commodo, tristique ligula eu, tincidunt enim. Duis iaculis sodales lectus vitae cursus.</p>
            </div>
        </div>
    </div>

</div>



    <style type="text/css">
        #datatable-investors_filter{
            display: none;
        }
    </style>

@endsection

