<div class="alert alert-success gi-success @if(!Session::has('success_message')) d-none @endif " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
   <span id="message">{{ Session::get('success_message')}}</span>
</div>
 
<div class="alert alert-danger gi-danger @if(!Session::has('error_message')) d-none @endif " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
   <span id="message">{{ Session::get('error_message')}}</span>
</div>

