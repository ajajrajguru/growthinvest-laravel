@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice-investors.js') }}"></script>


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
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/registration') }}">Registration</a>
                            <span class="bubble"></span>
                        </li>
                        <li class="active">
                            <a href="javascript:void(0)">Client Categorisation</a>
                            <span class="bubble"></span>
                        </li>
                        <li>
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information') }}">Additional Information</a>
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
                             
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/registration') }}" class="btn btn-outline-primary mb-4"><i class="fa fa-angle-double-left"></i>Prev </a> 
                        </div>
                        <div class="">
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information')}}" class="btn btn-primary mb-4">Next <i class="fa fa-angle-double-right"></i></a> 
                            
                        </div>
                    </div>

                    <h5 class="mt-3 mb-2">
                        2: <i class="fa fa-group text-primary"> </i> <span class="text-primary">  Client Categorisation</span>
                    </h5>
                    <hr class="my-3">

                    <div class="mb-5">
                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))
                        <p>In order to access our platform we need to categorise your client as one of 6 different types of Investor. These are all listed below, so  please click on each box below, read the descriptions and select the one you feel is most appropriate.</p>
                        <p>Once you have selected a category, please then complete the certification process as instructed.  A copy of the certification document will be held in your investor’s document library,  and investor will be prompted to revisit and renew the categorisation periodically.</p>
                        <p style="font-weight: initial;">We may need to contact the investor to confirm some details and ensure we are happy that your categorisation is appropriate. If your investor's circumstances change, he will be able to  re-certify at any stage. If you or your client have any questions at all please contact a member of the GrowthInvest<!-- Seed EIS Platform --> team on 020 7071 3945 or via <a href="mailto:suppport@growthinvest.com">suppport@growthinvest.com</a>.</p>
                    @else
                        <p >In order to access our platform we need to categorise you as one of 6 different types of Investor. These are all listed below, so  please click on each box below, read the descriptions and select the one you feel is most appropriate.</p>
                        <p>Once you have selected a category, please then complete the certification process as instructed.  A copy of the certification document will be held in your document library,  and you will be prompted to revisit and renew the categorisation periodically.</p>

                        <p style="font-weight: initial;"> We may contact you to confirm some details and ensure we are happy that your categorisation is appropriate. If your circumstances change, you are able to  re-certify at any stage. If you have any questions at all please contact a member of the GrowthInvest<!-- Seed EIS Platform --> team on 020 7071 3945 or via <a href="mailto:suppport@growthinvest.com">suppport@growthinvest.com</a>.</p>
                    @endif
                    </div>

                    <div class="register-tab" id="client-category-tabs">
                        <div class="row">
                            <div id="tabs-container">
                                <ul class="nav nav-tabs " role="tablist">

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link @if(empty($investorCertification) || $activeCertificationData->slug == 'retail_restricted_investor' ) active @endif" href="#tab-1" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{ url('img/hand132.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                RETAIL (RESTRICTED) INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'sophisticated_investor') active @endif" href="#tab-2" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/office-worker1.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                SOPHISTICATED INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'high_net_worth_individual') active @endif" href="#tab-3" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/coin.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                            HIGH NET WORTH INDIVIDUAL
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'professional_investor') active @endif" href="#tab-4" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/group47.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                PROFESSIONAL INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'advised_investor') active @endif" href="#tab-5" role="tab" data-toggle="tab">
                                            <div class="image">
                                                <img class="mx-auto d-block img-responsive" width="35" src="{{url('img/staff1.png')}}">
                                            </div>
                                            <div class="small text-center font-weight-medium mt-2">
                                                ADVISED INVESTOR
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item col-md-2 d-flex">
                                        <a class="nav-link @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'elective_professional_investor') active @endif" href="#tab-6" role="tab" data-toggle="tab">
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
                        <div role="tabpanel" class="tab-pane @if(empty($investorCertification) || $activeCertificationData->slug == 'retail_restricted_investor' ) active fadein @else fade @endif" id="tab-1">
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
                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))
                              If you wish to classify your client as a Retail Restricted Investor on the GrowthInvest, please complete the short <span class="text-primary">Investor Questionnaire </span>below and then complete the statement below
                            @else
                            If you wish to be classified as a Retail Restricted Investor on the GrowthInvest<!-- Seed EIS Platform -->, please complete the short <span class="text-primary">Investor Questionnaire</span> below and then complete the statement below.
                            @endif
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
                                                              <input type="radio" id="option_{{ $key.'_'.$key2 }}" name="radiobtn_{{ $key }}" class="custom-control-input question-option" data-correct="{{ $option->correct }}"  data-qid="{{ $questionnaire->q_id }}" data-label="{{ $option->label }}" @if($isRetail && $option->correct) checked @endif>
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
                                       
                                       <button type="button" class="btn btn-primary pull-right retail-quiz-btn submit-quiz @if($isRetail) d-none @endif" >
                                       Submit Quiz
                                       </button>
                                       
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
                           @if(Auth::user()->hasPermissionTo('is_wealth_manager'))

                           <b class="mb-5">
                           I make this statement on behalf of my client so that he/she can receive promotional communications relating to non-readily realisable securities as a retail (restricted) investor. I declare that he/she qualify as a retail (restricted) investor because:
                           </b>
                           <ul class=" mb-5">
                              <li>In the preceding twelve months, my client has not invested more than 10% of his/her net assets in non-readily realisable securities; and</li>
                                <li>I undertake that in the next twelve months my client will not invest more than 10% of his/her net assets in non-readily realisable securities.</li>
                           </ul>
                           <b class="mb-5">
                          Net assets for these purposes do not include:
                           </b>
                           <ul class="mb-5">
                              <li> The property which is my client's primary residence or any money raised through a loan secured on that property;</li>
                                <li>  Any rights of my client under a qualifying contract of insurance; OR</li>
                                <li>Any benefits (in the form of pensions or otherwise) which are payable on the termination of my client service or on his/her death or retirement and to which he/she (or dependants are), or may be entitled.</li>
                           </ul>

                           @else

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

                           @endif
                           <div class="alert alert-primary" id="">
                              <div class="text-primary">
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input retail-input" name="ri_check_0" id="ri_acceptInvestments" @if($isRetail && !empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ri_check_0',$investorCertification->details['conditions'])) checked @endif>
                                       <label class="custom-control-label normal text-primary" for="ri_acceptInvestments">
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                       I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                    @else
                                        I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                    @endif
                                   </label>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" name="ri_check_1" class="custom-control-input retail-input" id="ri_retailinvestor" @if($isRetail && !empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ri_check_1',$investorCertification->details['conditions'])) checked @endif>
                                       <label class="custom-control-label normal text-primary" for="ri_retailinvestor">
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))        
                                       I wish my client to be treated as a Retail (restricted) Investor.
                                    @else
                                        I wish to be treated as a Retail (Restricted) Investor.
                                    @endif
                                   </label>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" name="ri_check_2" class="custom-control-input retail-input" id="ri_riskwarning" @if($isRetail && !empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ri_check_2',$investorCertification->details['conditions'])) checked @endif>
                                       <label class="custom-control-label normal text-primary" for="ri_riskwarning">
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))      
                                       I on behalf of my client have read and understand the risk warning.
                                    @else
                                       I have read and understand the risk warning.
                                    @endif
                                   </label>
                                    </div>
                                 </div>
                                 <div class="mb-3">
                                    <div>
                                       
                                       <button class="btn btn-primary save-retial-certification save-certification @if($isRetail) d-none @endif ld-ext-right" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" get-input-class="retail-input">Submit <div class="ld ld-ring ld-spin"></div></button>
                                       
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
                                            <option value="">Select Certification</option>
                                            @foreach($certificationTypes as $key=> $certificationType)
                                                @php
                                                if($key == 'uncertified')
                                                    continue;
                                                @endphp
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


                           <div class="investor-certification">
                            @if(!empty($investorCertification))
                            {!! genActiveCertificationValidityHtml($investorCertification,$investorCertification->file_id) !!}
                            @endif
                           </div>
                           


                        </div>

                        <div role="tabpanel" class="tab-pane @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'sophisticated_investor') active fadein @else fade @endif" id="tab-2">
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

                                @if(Auth::user()->hasPermissionTo('is_wealth_manager'))     
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
                                @else
                                    <span class="mb-5">
                                        <p>
                                            <b>You are considered a Sophisticated Investor if any of the following applies:
                                            </b>
                                        </p>
                                        <ul class="list_ok">
                                            <li>You have made more than one investment in an unlisted company in the last 2 years </li>
                                            <li>You have been a member of a network or syndicate of business angel for at least six months</li>
                                            <li>You have worked in the private equity SME finance sector in the last two years</li>
                                            <li>You have been a director of a company with annual turnover in excess of £1m in the last 2 years</li>
                                        </ul>
                                    </span>
                                    <div class="mb-5">
                                        <p>If you wish to be classified as a Sophisticated Investor on the GrowthInvest<!-- Seed EIS Platform -->, please indicate the reason(s) that you qualify and then complete the statement below.</p>     

                                        <p>I qualify as a Sophisticated investor and thus exempt under article 50(A) of the Financial Services and Markets Act 2000 after signing this prescribed template with relevant risk warnings and I meet at least one of the following criteria.</p>
                                    </div>
                                @endif
                                <div class="alert bg-gray mb-5">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_0" id="ch7" @if($isSophisticatedInv && !empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_0',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch7">

                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                He/She has been a member of a network or syndicate of business angels for at least the six months preceding the date of the certificate.
                                            @else
                                                I have been a member of a network or syndicate of business angels for at least the six months preceding the date of the certificate
                                            @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_1" id="ch8" @if($isSophisticatedInv && !empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_1',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch8">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                He/She has made more than one investment in an unlisted company in the two years preceding that date.
                                            @else
                                                I have made more than one investment in an unlisted company in the two years preceding that date
                                            @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_2" id="ch9"  @if($isSophisticatedInv && !empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_2',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch9">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                He/She has worked, in the two years preceding that date, in a professional capacity in the private equity sector, or in the provision of finance for small and medium enterprises.
                                            @else
                                                I have worked, in the two years preceding that date, in a professional capacity in the private equity sector, or in the provision of finance for small and medium enterprises
                                            @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input sop-terms-input" name="sic_option_3" id="ch10"  @if($isSophisticatedInv && !empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_3',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label medium" for="ch10">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                He/She has been, in the two years preceding that date, a director of a company with an annual turnover of at least £1 million.
                                            @else
                                                I have been, in the two years preceding that date, a director of a company with an annual turnover of at least £1 million
                                            @endif
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
                                                <label class="custom-control-label normal text-primary" for="si_acceptInvestments">
                                                @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                 I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                                @else
                                                I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                                @endif
                                             </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input sop-conditions-input" name="si_check_1"  id="si_retailinvestor" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('si_check_1',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="si_retailinvestor">
                                             @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                I wish to be treat my client as a sophisticated investor and have a certificate that can be made available for presentation by my client's accountant or lawyer (on request).
                                            @else
                                                 I wish to be treated as a sophisticated investor and have a certificate that can be made available for presentation by my accountant or lawyer (on request).
                                            @endif
                                            </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input sop-conditions-input" name="si_check_2"  id="si_riskwarning" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('si_check_2',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="si_riskwarning">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                                I have read and understand on behalf of my client the risk warning.
                                            @else
                                                I have read and understand the risk warning.
                                            @endif
                                            </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div>
                                                <button class="btn btn-primary save-sophisticated-Investor save-certification @if($isSophisticatedInv) d-none @endif ld-ext-right" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" get-input-class="retail-input">Submit<div class="ld ld-ring ld-spin"></div></button>
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
                            </form>

                             <div class="investor-certification">
                                @if(!empty($investorCertification))
                                {!! genActiveCertificationValidityHtml($investorCertification,$investorCertification->file_id) !!}
                                @endif
                               </div>
                        </div>

                        <div role="tabpanel" class="tab-pane @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'high_net_worth_individual') active fadein @else fade @endif" id="tab-3">
                            <h4 class ="my-3 text-primary">
                                High Net Worth Individual
                            </h4>
                             <div class="alert alert-danger d-none" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                               <span id="message"></span>
                            </div>
                            <form>
                                @php
                                $clientCategory = $clientCategories->firstWhere('slug','high_net_worth_individual'); 
                                $isHighNetworth = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false; 
                                @endphp
                                <div class="mb-5">
                                    <p>High Net Worth Individual (“HNWI”) are exempt under article 48 of the FSMA 2000 if they have signed a prescribed template with relevant risk warnings that they have over £100 000 p.a income and net assets excluding primary residence of over £250,000</p>
                                    <p>
                                     @if(Auth::user()->hasPermissionTo('is_wealth_manager'))   
                                        If you wish to be classify your client as a High Net Worth Investor  on the GrowthInvest<!-- Seed EIS Platform -->, please indicate the reason(s) that your client qualifies and then complete the statement below.
                                    @else
                                        If you wish to be classified as a High Net Worth Investor on the GrowthInvest<!-- Seed EIS Platform -->, please indicate the reason(s) that you qualify and then complete the statement below.
                                    @endif
                                    </p>
                                </div>
                                <p>
                                    <b>
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))       
                                        My client is a certified high net worth individual because at least one of the following applies:
                                    @else
                                        I am a certified high net worth individual because at least one of the following applies: 
                                    @endif
                                    </b>
                                </p>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input hi-terms-input" name="sic_option_0" id="ch15" @if($isHighNetworth && !empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_0',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label normal" for="ch15">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))           
                                                He/she had, during the financial year immediately preceding the date below, an annual income to the value of £100,000 or more;
                                            @else
                                                I had, during the financial year immediately preceding the date below, an annual income to the value of £100,000 or more;
                                            @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input hi-terms-input" id="ch16" name="sic_option_1" @if($isHighNetworth && !empty($investorCertification) && isset($investorCertification->details['terms']) && in_array('sic_option_1',$investorCertification->details['terms'])) checked @endif>
                                            <label class="custom-control-label normal" for="ch16">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))        
                                                He/she held, throughout the financial year immediately preceding the date below, net assets to the value of £250,000 or more. Net assets for these purposes do not include:
                                            @else
                                                I held, throughout the financial year immediately preceding the date below, net assets to the value of £250,000 or more. Net assets for these purposes do not include:
                                            @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <ol>
                                    @if(Auth::user()->hasPermissionTo('is_wealth_manager'))     
                                    <li>
                                        The property which is my client's primary residence or any loan secured on that residence;
                                    </li>
                                    <li>
                                        Any rights of my client's are under a qualifying contract of insurance within the meaning of the Financial Services and Markets Act 2000 (Regulated Activities) Order 2001; or
                                    </li>
                                    <li>
                                        Any benefits (in the form of pensions or otherwise) which are payable on the termination of my client service or on his/her death or retirement and to which he/she (or dependants are), or may be entitled.
                                    </li>
                                    @else
                                        <li> The property which is my primary residence or any loan secured on that residence;</li>
                                        <li> Any rights of mine are under a qualifying contract of insurance within the meaning of the Financial Services and Markets Act 2000 (Regulated Activities) Order 2001; or</li>
                                        <li> Any benefits (in the form of pensions or otherwise) which are payable on the termination of my service or on my death or retirement and to which I am (or my dependants are), or may be, entitled. </li>
                                    @endif
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
                                                <input type="checkbox" class="custom-control-input hi-conditions-input" name="hi_check_0" id="hi_acceptInvestments" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('hi_check_0',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="hi_acceptInvestments">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                                I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                            @else
                                                I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                            @endif
                                            </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input hi-conditions-input" name="hi_check_1" id="hi_retailinvestor" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('hi_check_1',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="hi_retailinvestor">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                                I wish to treat my client as a HNWI and have a certificate that can be made available for presentation by my client's accountant or lawyer (on request).
                                            @else
                                                I wish to be treated as a HNWI and have a certificate that can be made available for presentation by my accountant or lawyer (on request).
                                            @endif
                                            </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input hi-conditions-input" name="hi_check_2" id="hi_riskwarning" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('hi_check_2',$investorCertification->details['conditions'])) checked @endif>
                                                <label class="custom-control-label normal text-primary" for="hi_riskwarning">
                                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))    
                                                I have read and understand on behalf of my client, the risk warning.
                                            @else
                                                I have read and understand the risk warning.
                                            @endif
                                            </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div>
                                                <button class="btn btn-primary save-high-net-worth save-certification @if($isHighNetworth) d-none @endif ld-ext-right" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" >Submit<div class="ld ld-ring ld-spin"></div></button>
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
                            </form>

                             <div class="investor-certification">
                            @if(!empty($investorCertification))
                            {!! genActiveCertificationValidityHtml($investorCertification,$investorCertification->file_id) !!}
                            @endif
                           </div>

                        </div>
                        <div role="tabpanel" class="tab-pane @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'professional_investor') active fadein @else fade @endif" id="tab-4">
                            <h4 class="my-3 text-primary">
                                Professional Investor
                            </h4>
                            @php
                                $clientCategory = $clientCategories->firstWhere('slug','professional_investor'); 
                                $isProfessionalInv = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false; 
                            @endphp

                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))  
                            <p>A Professional Investor is an investor whom is not designated as a Retail (Restricted) Investor as per the FCA Conduct of Business Handbook <a href="https://fshandbook.info/FS/print/FCA/COBS/3" target="_blank">https://fshandbook.info/FS/print/FCA/COBS/3</a> . If your client falls into one of the below categories then He/She will qualify as a professional investor. As a professional investor GrowthInvest<!-- Seed EIS Platform --> is able to communicate with your client directly in relation to investment business.</p>
                            @else
                            <p>A Professional Investor is an investor whom is not designated as a Retail (Restricted) Investor as per the FCA Conduct of Business Handbook <a href="https://fshandbook.info/FS/print/FCA/COBS/3" target="_blank">https://fshandbook.info/FS/print/FCA/COBS/3</a>. If you fall into one of the below categories then you will qualify as a professional investor. As a professional investor GrowthInvest<!-- Seed EIS Platform --> is able to communicate with you directly in relation to investment business.</p>
                            @endif

                            @if(Auth::user()->hasPermissionTo('is_wealth_manager'))  
                            <p>If you wish to classify your client as a Professional Investor on the GrowthInvest<!-- Seed EIS Platform -->, please indicate the reason(s) that he/she qualifies and then complete the statement below.</p><br>
                            @else
                            <p>If you wish to be classified as a Professional Investor on the GrowthInvest<!-- Seed EIS Platform -->, please read the categories below carefully, and if you are confident that you qualify, please complete and submit the statement.</p>
                            @endif

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
                                            <input type="checkbox" class="custom-control-input pi-conditions-input" name="pi_check_0" id="pi_acceptInvestments" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('pi_check_0',$investorCertification->details['conditions'])) checked @endif>
                                            <label class="custom-control-label normal text-primary" for="pi_acceptInvestments">
                                        @if(Auth::user()->hasPermissionTo('is_wealth_manager'))  
                                            I accept that the investments to which the promotions will relate may expose him/her to a significant risk of losing all of the money or other assets invested. I am aware that it is open to him/her to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                        @else
                                            I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.
                                        @endif
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input pi-conditions-input" name="pi_check_1" id="pi_retailinvestor" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('pi_check_1',$investorCertification->details['conditions'])) checked @endif>
                                            <label class="custom-control-label normal text-primary" for="pi_retailinvestor">
                                        @if(Auth::user()->hasPermissionTo('is_wealth_manager'))  
                                            I wish to treat my client as a Professional investor.
                                        @else
                                            I wish to be treated as an professional investor.
                                        @endif
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input pi-conditions-input" name="pi_check_2" id="pi_riskwarning" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('pi_check_2',$investorCertification->details['conditions'])) checked @endif>
                                            <label class="custom-control-label normal text-primary" for="pi_riskwarning">
                                        @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                                             I have read and understand on behalf of my client, the risk warning.
                                        @else
                                            I have read and understand the risk warning.
                                        @endif
                                        </label>
                                        </div>
                                    </div>
                                   
                                    <div class="mb-3">
                                        <div>
                                            <button class="btn btn-primary save-professsional-inv save-certification @if($isProfessionalInv) d-none @endif ld-ext-right" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" >Submit<div class="ld ld-ring ld-spin"></div></button>
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
                             
                             <div class="investor-certification">
                            @if(!empty($investorCertification))
                            {!! genActiveCertificationValidityHtml($investorCertification,$investorCertification->file_id) !!}
                            @endif
                           </div>

                        </div>
                        <div role="tabpanel" class="tab-pane @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'advised_investor') active fadein @else fade @endif" id="tab-5">
                            <h4 class="my-3 text-primary">
                                Advised Investor
                            </h4>
                             @php
                                $clientCategory = $clientCategories->firstWhere('slug','advised_investor'); 
                                $isAdvisedInvestor = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false; 
                            @endphp

                            @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                            <p>
                                An advised investor is one that has been assessed and categorised by an FCA regulated company and deemed suitable under COBS9 to receive financial promotions. As an advised investor your client is aware that he/she can seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.

                            </p>

                            <p>
                                Please provide details of the FCA regulated company through which your client has been assessed and categorised. GrowthInvest<!-- Seed EIS Platform --> will treat your client as a Retail (Restricted) Investor until such time as the company is registered as a client and has provided categorisation documentation on your client behalf.
                            </p>

                            <p>
                                If you wish to classify your client as an Advised  Investor on the GrowthInvest<!-- Seed EIS Platform -->, please fill out the short <span class="brand-text">Advised Investor Questionnaire</span> and then complete the statement below
                            </p>
                            @else
                            <p>
                                An advised investor is one that has been assessed and categorised by an FCA regulated company and deemed suitable under COBS9 to receive financial promotions. As an advised investor you are aware that you can seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.

                            </p>

                            <p>
                                Please provide details of the FCA regulated company through which you have been assessed and categorised. GrowthInvest<!-- Seed EIS Platform --> will treat you as a Retail (Restricted) Investor until such time as the company is registered as a client and has provided categorisation documentation on your behalf.
                            </p>

                            <p>
                                If you wish to classify as an Advised  Investor on the GrowthInvest<!-- Seed EIS Platform -->, please fill out the short <span class="brand-text">Advised Investor Questionnaire</span> and then complete the statement below
                            </p>
                            @endif

                            <h5>Section 1 - Financial Adviser</h5>
                            <div class="form-group">
                                <label>Does your client have a financial advisor or a wealth manager (authorised person)?</label>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="havefinancialadvisor_yes" name="havefinancialadvisor" value="yes" class="custom-control-input" @if(!empty($investorFai) && isset($investorFai['havefinancialadvisor']) && $investorFai['havefinancialadvisor'] == 'yes') checked @endif>
                                  <label class="custom-control-label medium" for="havefinancialadvisor_yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="havefinancialadvisor_no" name="havefinancialadvisor" value="no" class="custom-control-input" @if(!empty($investorFai) && isset($investorFai['havefinancialadvisor']) && $investorFai['havefinancialadvisor'] == 'no') checked @endif>
                                  <label class="custom-control-label medium" for="havefinancialadvisor_no">No</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Is your client receiving advice from an Authorised Person in relation to unlisted shares and unlisted debt securities?</label>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="advicefromauthorised_yes" name="advicefromauthorised" class="custom-control-input" value="yes" @if(!empty($investorFai) && isset($investorFai['advicefromauthorised']) && $investorFai['advicefromauthorised'] == 'yes') checked @endif>
                                  <label class="custom-control-label medium" for="advicefromauthorised_yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                  <input type="radio" id="advicefromauthorised_no" name="advicefromauthorised" class="custom-control-input" value="no" @if(!empty($investorFai) && isset($investorFai['advicefromauthorised']) && $investorFai['advicefromauthorised'] == 'no') checked @endif>
                                  <label class="custom-control-label medium" for="advicefromauthorised_no">No</label>
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
                                        <form name="advised_investor">
                                        <div class="card-body">
                                            <p><em>To be completed by your adviser/investment institution/intermediary</em></p>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Firm Name</label>
                                                        <input type="text" class="form-control" name="companyname" value="{{ (!empty($investorFai) && isset($investorFai['companyname'])) ? $investorFai['companyname']:'' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>FCA Firm Reference Number</label>
                                                        <input type="text" class="form-control" name="fcanumber" value="{{ (!empty($investorFai) && isset($investorFai['fcanumber'])) ? $investorFai['fcanumber']:'' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact Name</label>
                                                        <input type="text" class="form-control" name="principlecontact" value="{{ (!empty($investorFai) && isset($investorFai['principlecontact'])) ? $investorFai['principlecontact']:'' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact's FCA Number</label>
                                                        <input type="text" class="form-control" name="primarycontactfca" value="{{ (!empty($investorFai) && isset($investorFai['primarycontactfca'])) ? $investorFai['primarycontactfca']:'' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact Email Address</label>
                                                        <input type="email" class="form-control" name="email"  data-parsley-type="email" value="{{ (!empty($investorFai) && isset($investorFai['email'])) ? $investorFai['email']:'' }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Primary Contact Phone Number</label>
                                                        <input type="text" class="form-control" name="telephone" data-parsley-type="number" data-parsley-minlength="10" data-parsley-minlength-message="The telephone number must be atleast 10 characters long!" value="{{ (!empty($investorFai) && isset($investorFai['telephone'])) ? $investorFai['telephone']:'' }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <fieldset>
                                                        <legend>Firm Address</legend>
                                                        <div class="form-group">
                                                            <label>Address 1</label>
                                                            <textarea class="form-control" name="address">{{ (!empty($investorFai) && isset($investorFai['address'])) ? $investorFai['address']:'' }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address 2</label>
                                                            <textarea class="form-control" name="address2">{{ (!empty($investorFai) && isset($investorFai['address2'])) ? $investorFai['address2']:'' }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Town</label>
                                                            <input type="text" class="form-control" name="city" value="{{ (!empty($investorFai) && isset($investorFai['city'])) ? $investorFai['city']:'' }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>County</label>
                                                            <select class="form-control" name="county">
                                                                <option value="">Please Select</option>
                                                   
                                                                @foreach($countyList as $county) 
                                                                    <option value="{{ $county }}" @if(!empty($investorFai) && isset($investorFai['county']) && $investorFai['county'] == $county) selected @endif >{{ $county }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Postcode</label>
                                                                    <input type="text" class="form-control" name="postcode" value="{{ (!empty($investorFai) && isset($investorFai['postcode'])) ? $investorFai['postcode']:'' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Country</label>
                                                                <select class="form-control" name="country">
                                                                    <option value="">Please Select</option>
                                                                     
                                                                    @foreach($countryList as $code=>$country)
                                                                        <option value="{{ $code }}" @if(!empty($investorFai) && isset($investorFai['country']) && $investorFai['country'] == $code) selected @endif>{{ $country }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-primary" id="">
                                <div class="text-primary">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input ai-conditions-input" name="ai_check_0" id="ai_acceptInvestments" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ai_check_0',$investorCertification->details['conditions'])) checked @endif>
                                            <label class="custom-control-label normal text-primary" for="ai_acceptInvestments">
                                         @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                                            My client belongs to a firm that has assessed him/her as suitable to receive financial promotions.
                                        @else
                                            I am a client of a firm that has assessed me as suitable to receive financial promotions.
                                        @endif
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input ai-conditions-input" name="ai_check_1" id="ai_retailinvestor" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ai_check_1',$investorCertification->details['conditions'])) checked @endif>
                                            <label class="custom-control-label normal text-primary" for="ai_retailinvestor">
                                        @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                                            I accept that the investments to which the promotions relate may expose him/her to a significant risk of losing all of the money or other property invested. My client is  aware that it is open to him/her to seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.
                                        @else
                                            I accept that the investments to which the promotions relate may expose me to a significant risk of losing all of the money or other property invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.
                                        @endif
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input ai-conditions-input" name="ai_check_2" id="ai_riskwarning" @if(!empty($investorCertification) && isset($investorCertification->details['conditions']) && in_array('ai_check_2',$investorCertification->details['conditions'])) checked @endif>
                                            <label class="custom-control-label normal text-primary" for="ai_riskwarning">
                                        @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                                            I have read and understand, the risk warnings on behalf of my client.
                                        @else
                                            I have read and understand the risk warning.
                                        @endif
                                        </label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <button class="btn btn-primary save-advised-investor save-certification @if($isAdvisedInvestor) d-none @endif ld-ext-right" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" >Submit<div class="ld ld-ring ld-spin"></div></button>
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

                             <div class="investor-certification">
                            @if(!empty($investorCertification))
                            {!! genActiveCertificationValidityHtml($investorCertification,$investorCertification->file_id) !!}
                            @endif
                           </div>


                        </div>
                        <div role="tabpanel" class="tab-pane @if(!empty($activeCertificationData) && $activeCertificationData->slug == 'elective_professional_investor') active fadein @else fade @endif" id="tab-6">
                            <h4 class="my-3 text-primary">
                                Elective Professional Investor
                            </h4>
                            @php
                            $clientCategory = $clientCategories->firstWhere('slug','elective_professional_investor'); 
                            $getQuestionnaire = $clientCategory->getCertificationQuesionnaire(); 
                            $isElectiveProfInv = (!empty($investorCertification) && $investorCertification->certification_default_id == $clientCategory->id) ? true : false;

                            $electiveProfInvestorQuizStatementDeclaration = getElectiveProfInvestorQuizStatementDeclaration(false,$isElectiveProfInv);

                            $electiveProfessionalStatement   = $electiveProfInvestorQuizStatementDeclaration['statement'];
                            $electiveProfessionalDeclaration = $electiveProfInvestorQuizStatementDeclaration['declaration'];
                            @endphp


                        @if(Auth::user()->hasPermissionTo('is_wealth_manager')) 
                            <p>An Elective Professional Investor (Opt Up) Client is someone ordinarily a “Retail” client who wishes to be treated as a “Professional” category client.</p>

                            <p>If categorised as a Retail (Restricted) Investor, Sophisticated Investor or High Net Worth Individual we are unable to conduct business with you via telephone or in person in relation to our investments. However, if you chose to classify your client to become an Elective Professional client and we deem your client suitable then he/she can engage directly with us in respect of investment business.</p>

                            <p>If you wish to classify your client as an  Elective Professional Investor on the GrowthInvest<!-- Seed EIS Platform -->, please complete  the short <span class="brand-text">Elective Professional Investor Questionnaire</span>, and then complete the statement below.</p>

                        @else
                            <p>An Elective Professional Investor (Opt Up) is someone ordinarily a “Retail” client who wishes to be treated as a “Professional” category client.</p>

                            <p>If categorised as a Retail (Restricted) Investor, Sophisticated Investor or High Net Worth Individual we are unable to conduct business with you via telephone or in person in relation to our investments. However, if you chose to become an Elective Professional and we deem you suitable then you can engage directly with us in respect of investment business</p>

                            <p>If you wish to be classified as an Elective Professional Investor on the GrowthInvest<!-- Seed EIS Platform -->, please complete the short <span class="brand-text">Elective Professional Investor Questionnaire</span>, and then complete the statement below.</p>
                        @endif

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
                                        <div class="card-body quiz-container"> 
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
                                                              <input type="radio" id="elec_option_{{ $key.'_'.$key2 }}" name="radiobtn_{{ $key }}" class="custom-control-input question-option" data-correct="{{ $option->correct }}"  data-qid="{{ $questionnaire->q_id }}" data-label="{{ $option->label }}" @if($isElectiveProfInv && $option->correct) checked @endif>
                                                              <label class="custom-control-label normal" for ="elec_option_{{ $key.'_'.$key2 }}">
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

                                             <button type="button" class="btn btn-primary pull-right elective-prof-inv-quiz-btn submit-quiz @if($isElectiveProfInv) d-none @endif" > Submit </button>

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
                                
                                {!!$electiveProfessionalStatement!!}
                               
                                
                            </div>

                            {!! $electiveProfessionalDeclaration !!}
                           <button class="btn btn-primary save-elective-prof-inv save-certification @if($isElectiveProfInv) d-none @endif ld-ext-right" client-category="{{ (!empty($clientCategory)) ? $clientCategory->id :'' }}" inv-gi-code="{{ $investor->gi_code }}" type="button" >Submit<div class="ld ld-ring ld-spin"></div></button>

                            <div class="investor-certification">
                            @if(!empty($investorCertification))
                            {!! genActiveCertificationValidityHtml($investorCertification,$investorCertification->file_id) !!}
                            @endif
                           </div>

                        </div>
 

                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/registration') }}" class="btn btn-outline-primary mb-4"><i class="fa fa-angle-double-left"></i>Prev </a> 
                        </div>
                        <div class="">
                            <a href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information')}}" class="btn btn-primary mb-4">Next <i class="fa fa-angle-double-right"></i></a> 
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

