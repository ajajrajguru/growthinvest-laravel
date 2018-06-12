$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->

	userActivityTable = $('#datatable-user-activity').DataTable(
	    'pageLength': 50
	    'processing': true
	    'language' :
	      processing : '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> <span class="">Loading...</span> '
	    'serverSide': true
	    'bAutoWidth': false
	    "dom": '<"top d-sm-flex justify-content-sm-between w-100"li>t<"bottom d-sm-flex justify-content-sm-between flex-sm-row-reverse w-100"ip>' 
	    'aaSorting': [[0,'asc']]
	    'ajax':
	      url: '/user-dashboard/user/get-user-activity'
	      type: 'post'
	      data: (data) ->

	        filters = {}
	        filters.duration = $('select[name="duration"]').val()
	        filters.duration_from = $('input[name="duration_from"]').val()
	        filters.duration_to = $('input[name="duration_to"]').val()
	        filters.user_id = $('input[name="user"]').val()
	        filters.type = $('select[name="type"]').val()
	        filters.activity_group = $('select[name="activity_group"]').val()
	        filters.firmid = $('select[name="firm"]').val()
	        if $('input[name="exclude_platform_admin_activity"]').is(':checked')
	          filters.exclude_platform_admin_activity = 1
	        else
	          filters.exclude_platform_admin_activity = 0


	        data.filters = filters
	        data

	      error: ->
	        return

	    'columns': [
	      { 'data': 'logo', "orderable": false }
	      { 'data': 'proposal_funds' }
	      { 'data': 'user'}
	      { 'data': 'user_type' }
	      { 'data': 'firm' }
	      { 'data': 'gi_code' , "orderable": false}
	      { 'data': 'email' }
	      { 'data': 'telephone' }
	      { 'data': 'description' , "orderable": false}
	      { 'data': 'date' }
	      { 'data': 'activity' }

	    ]
	    'columnDefs': [
	      {
	        'targets': 'col-visble'
	        'visible': false
	      }
	    ]

	    )

	$('.download-user-activity-report').click ->
	    type = $(this).attr('report-type')
	    urlParams = ''
	    
	    if($('select[name="duration"]').val()!="")
	      urlParams +='duration='+$('select[name="duration"]').val() 

	    if($('input[name="duration_from"]').val()!="")
	      urlParams +='&duration_from='+$('input[name="duration_from"]').val()

	    if($('input[name="duration_to"]').val()!="")
	      urlParams +='&duration_to='+$('input[name="duration_to"]').val()

	    if($('select[name="type"]').val()!="")
	      urlParams +='&type='+$('select[name="type"]').val()

 
	    if($('input[name="user"]').val()!="")
	      urlParams +='&user_id='+$('input[name="user"]').val()

	    if($('input[name="exclude_platform_admin_activity"]').is(':checked'))
	      urlParams +='&exclude_platform_admin_activity=1'
	    else
	    	urlParams +='&exclude_platform_admin_activity=0'

 
	    if(type == 'csv')  
	      window.open("/user-dashboard/user/export-user-activity?"+urlParams)
	    else if(type == 'pdf')  
	      window.open("/user-dashboard/user/user-activity-pdf?"+urlParams)


	$('body').on 'click', '.apply-activity-filters', ->
	    urlParams = ''

	    if($('select[name="duration"]').val()!="")
	      urlParams +='duration='+$('select[name="duration"]').val() 

	    if($('input[name="duration_from"]').val()!="")
	      urlParams +='&duration_from='+$('input[name="duration_from"]').val()

	    if($('input[name="duration_to"]').val()!="")
	      urlParams +='&duration_to='+$('input[name="duration_to"]').val()

	    if($('select[name="type"]').val()!="")
	      urlParams +='&type='+$('select[name="type"]').val()
	 
	    window.history.pushState("", "", "?"+urlParams);
	    userActivityTable.ajax.reload()
	    return

	  $('body').on 'click', '.reset-activity-filters', ->
	    $('select[name="duration"]').val('lasttwomonth').attr('disabled',false)
	    $('input[name="duration_from"]').val('').attr('disabled',false)
	    $('input[name="duration_to"]').val('').attr('disabled',false)
	    $('select[name="type"]').val('')
	  

	    window.history.pushState("", "", "?");
	    userActivityTable.ajax.reload()
	    return

	$(document).on 'click', '.editUserBtn', ->
		$('.editmode').removeClass('d-none');
		$('.reqField').removeClass('d-none');
		$('.viewmode').addClass('d-none');
		$('.disabledInput').attr('disabled',false)

		$(this).addClass('d-none');
		$('.cancelUpdateBtn').removeClass('d-none');

	$(document).on 'click', '.cancelUpdateBtn', ->
		$('.editmode').addClass('d-none');
		$('.reqField').addClass('d-none');
		$('.viewmode').removeClass('d-none');
		$('.disabledInput').attr('disabled',true)
		$(this).addClass('d-none');
		$('.editUserBtn').removeClass('d-none');

	$(document).on 'click', '#change_pwd', ->
		$(this).addClass('d-none');
		$('#cancel_pwd').removeClass('d-none');
		$('.setpassword-cont').removeClass('d-none');

	$(document).on 'click', '#cancel_pwd', ->
		$(this).addClass('d-none');
		$('#change_pwd').removeClass('d-none');
		$('.setpassword-cont').addClass('d-none');
			



				 
	 		 


