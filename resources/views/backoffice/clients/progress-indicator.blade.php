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
    <li class="active">
        <a href="javascript:void(0)">Registration</a>
        <span class="bubble"></span>
    </li>
    <li >
        <a href="{{ ($investor->id) ? url('backoffice/investor/'.$investor->gi_code.'/client-categorisation'): 'javascript:void(0)'}}">Client Categorisation</a>
        <span class="bubble"></span>
    </li>
    <li>
        <a href="{{ ($investor->id) ? url('backoffice/investor/'.$investor->gi_code.'/additional-information'): 'javascript:void(0)'}}">Additional Information</a>
        <span class="bubble"></span>
    </li>
    <li>
        <a href="{{ ($investor->id) ? url('backoffice/investor/'.$investor->gi_code.'/investment-account'): 'javascript:void(0)'}}">Investment Account</a>
        <span class="bubble"></span>
    </li>
</ul>