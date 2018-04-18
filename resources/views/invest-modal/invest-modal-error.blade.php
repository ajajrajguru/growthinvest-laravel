<!-- Modal -->


<div class="modal fade" id="cust-invest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{isset($title)?$title:'Subscription Form'}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          {!!$message!!}

      </div>
      @if(isset($type) && $type=='account_upgrade')

      <!-- Modal Body End-->
       <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
        <a class="btn btn-info" href="{{ url('/backoffice/investor/')}}/{{$investor_data['gi_code']}}/investment-account">Become Investment ready</a>
      </div>
      @endif
    </div>
  </div>
</div>
