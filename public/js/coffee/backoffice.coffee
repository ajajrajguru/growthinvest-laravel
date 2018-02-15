$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->

	getUrlVars = ->
		vars = []
		hash = undefined
		hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&')
		i = 0
		while i < hashes.length
			hash = hashes[i].split('=')
			# vars.push hash[0]
			vars[hash[0]] = hash[1]
			$('td[data-search="'+hash[0]+'"]').find('.datatable-search').val(hash[1])
			i++
		vars

	$('.dataFilterTable thead th.w-search').each ->
		title = $(this).text()
		searchType = $(this).closest('table').find('tr.filters td').eq($(this).index()).attr 'data-search';
		if(searchType=='role')
			searchField = '<select class="form-control datatable-search">'
			searchField += '<option value="">Search ' + title + '</option>'
			$(userRoles).each (id,value) ->
				value = value.trim()
				searchField += '<option value="'+value+'">' + value + '</option>'
			searchField += '</select>'
		else
			searchField = '<div class="input-group"> <div class="input-group-prepend pt-2 pr-2"><i class="fa fa-search text-muted"></i></div> <input type="text" class="form-control datatable-search" placeholder="Search ' + title + '" />   <div class="input-group-append">    <button class="btn btn-sm btn-link clear-input" type="button"><i class="fa fa-times text-secondary"></i></button>  </div> </div>'

		$(this).closest('table').find('tr.filters td').eq($(this).index()).html searchField
		return


	updateSerachinput = (tableObj) ->
		urlParms = getUrlVars()
		tableObj.columns().eq(0).each (colIdx) ->
			colVal = $('.datatable-search', $('.filters td')[colIdx]).val()
			tableObj.columns(colIdx).search(colVal).draw()
			return
		return

	initSerachForTable = (tableObj) ->
		urlParms = getUrlVars()
		tableObj.columns().eq(0).each (colIdx) ->
			$('.datatable-search', $('.filters td')[colIdx]).on 'keyup change', ->
				tableObj.column(colIdx).search(@value).draw()
				return
			return
		return

	clearInput = (tableObj) ->
		$('body').on 'click', '.clear-input', ->
			$(this).closest('.input-group').find('input').val('')
			tableObj.columns().eq(0).each (colIdx) ->
				colVal = $('input', $('.filters td')[colIdx]).val()
				tableObj.columns(colIdx).search(colVal).draw()
				return
			if $(window).width() < 767
				if $('.toggle-btn input:checkbox:not(:checked)')
					column = 'table .' + $('.toggle-btn input').attr('name')
					$(column).hide()
			return
		return


	if $('#datatable-firms').length
		firmsTable = $('#datatable-firms').DataTable(
			"paging": false
			"info": true
			"dom": '<"top"i>t<"bottom"i>'
			'aaSorting': [[1,'asc']]
			'columns': [
				{ 'data': 'logo' , "orderable": false}
				{ 'data': 'name' }
				{ 'data': 'firm_type' }
				{ 'data': 'parent_firm'}
				{ 'data': 'gi_code' }
				{ 'data': 'action' , "orderable": false}
			]

		)

		initSerachForTable(firmsTable)
		updateSerachinput(firmsTable)
		clearInput(firmsTable)



	$(document).on 'keyup change', '.data-search-input .datatable-search', ->
		urlParams = ''
		$('.data-search-input .datatable-search').each ->
			textVal = $(this).val()
			dataType = $(this).closest('td').attr 'data-search'

			if(textVal != '')
				if(urlParams!="")
					urlParams +='&'

				urlParams +=dataType+'='+textVal

		window.history.pushState("", "", "?"+urlParams);

	if $('#datatable-users').length
		usersTable = $('#datatable-users').DataTable(
			"paging": false
			"info": true
			"dom": '<"top"i>t<"bottom"i>'
			'aaSorting': [[0,'asc']]
			'columns': [
				{ 'data': 'name' }
				{ 'data': 'email' }
				{ 'data': 'role'}
				{ 'data': 'firm' }
				{ 'data': 'action' , "orderable": false}
			]

		)
		initSerachForTable(usersTable)
		updateSerachinput(usersTable)
		clearInput(usersTable)

	if $('#userAdmin').length
		userAdminTable = $('#userAdmin').DataTable(
			"paging": true
			"info": true
			"searching": false
			"ordering": false
		)

	if $('#availablePermissions').length
		availablePermissionstable = $('#availablePermissions').DataTable(
			"paging": true
			"info": true
			"searching": false
			"ordering": false
		)

	if $('#rolesTable').length
		addrolesTable = $('#rolesTable').DataTable(
			"paging": true
			"info": true
			"searching": false
			"ordering": false
		)


	if $('#datatable-Intermediary').length
		intermediaryTable = $('#datatable-Intermediary').DataTable(
			"paging": false
			"info": true
			"dom": '<"top"i>t<"bottom"i>'
			'aaSorting': [[1,'asc']]
			'columns': [
				{ 'data': 'ckbox'  , "orderable": false}
				{ 'data': 'intm_details' }
				{ 'data': 'comp_name' }
				{ 'data': 'comp_desc'}
				{ 'data': 'submitted_on' }
				{ 'data': 'lbgr' }
				{ 'data': 'action' , "orderable": false}
			]

		)
		initSerachForTable(intermediaryTable)
		updateSerachinput(intermediaryTable)
		clearInput(intermediaryTable)

	$(document).on 'change', '.delete_intm_users', ->
		if($('input[name="intermediary_user_delete[]"]:checked').length > 0)
			$('.delete-all-user').removeClass('d-none');
		else
			$('.delete-all-user').addClass('d-none');



	$(document).on 'click', '.select-all-user', ->
		$(this).addClass('d-none');
		$('.select-none-user').removeClass('d-none');
		$('.delete-all-user').removeClass('d-none');
		$(".delete_intm_users").prop('checked',true);

	$(document).on 'click', '.select-none-user', ->
		$(this).addClass('d-none');
		$('.select-all-user').removeClass('d-none');
		$('.delete-all-user').addClass('d-none');
		$(".delete_intm_users").prop('checked',false);

	$(document).on 'click', '.delete-all-user', ->
		userIds = ''
		$('.delete_intm_users').each ->
			if $(this).is(':checked')
				userIds += $(this).val()+','

		$.ajax
			type: 'post'
			url: '/backoffice/user/delete-user'
			headers:
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			data:
				'user_id': userIds
			success: (data) ->
				if data.status
					$('.delete_intm_users').each ->
						if $(this).is(':checked')
							intermediaryTable.row($(this).closest('tr')).remove()

					$('.gi-success').removeClass('d-none')
					$('.gi-danger').addClass('d-none')
					$('.gi-success #message').html "Intermediaries Deleted Successfully."

					intermediaryTable.draw()
				else
					$('.gi-success').addClass('d-none')
					$('.gi-danger').removeClass('d-none')
					$('.gi-danger #message').html "Failed to delete intermediaries."




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


	$(document).on 'click', '.editFirmBtn', ->
		$('.editmode').removeClass('d-none');
		$('.reqField').removeClass('d-none');
		$('.viewmode').addClass('d-none');

		$(this).addClass('d-none');
		$('#cke_ent_invite_content').removeClass('d-none')
		$('#cke_inv_invite_content').removeClass('d-none')
		$('#cke_fundmanager_invite_content').removeClass('d-none')
		$('.percentlbl').removeClass('d-none');
		$('.cancelFirmUpdateBtn').removeClass('d-none');

	$(document).on 'click', '.cancelFirmUpdateBtn', ->
		$('.editmode').addClass('d-none');
		$('.reqField').addClass('d-none');
		$('.viewmode').removeClass('d-none');
		$(this).addClass('d-none');
		$('#cke_ent_invite_content').addClass('d-none')
		$('#cke_inv_invite_content').addClass('d-none')
		$('#cke_fundmanager_invite_content').addClass('d-none')
		$('.percentlbl').addClass('d-none');
		$('.editFirmBtn').removeClass('d-none');


	$(document).on 'click', '#change_pwd', ->
		$(this).addClass('d-none');
		$('#cancel_pwd').removeClass('d-none');
		$('.setpassword-cont').removeClass('d-none');

	$(document).on 'click', '#cancel_pwd', ->
		$(this).addClass('d-none');
		$('#change_pwd').removeClass('d-none');
		$('.setpassword-cont').addClass('d-none');


	if $('form').length && $('form').attr('data-parsley-validate') == true
		$('form').parsley().on 'form:success', ->
			$(this)[0].$element.find('.save-btn .fa-check').addClass('d-none')
			$(this)[0].$element.find('.save-btn').addClass 'running'



	$('[data-toggle="popover"]').popover()

	# Menu JS
	$('#giMenu').mmenu {
		navbar: title: false
		extensions: [ 'pagedim-black', 'theme-dark' ]
	}, clone: true
	api = $('#mm-giMenu').data('mmenu')
	api.bind 'open:start', ->
		$('.mobile-menu-toggle').addClass 'is-active'
	api.bind 'close:start', ->
		$('.mobile-menu-toggle').removeClass 'is-active'


	$(window).scroll ->
		scroll = $(window).scrollTop()
		if scroll >= 1
			$('header').addClass 'sticky'
			$('.navbar-menu').addClass 'dark'
		else
			$('header').removeClass 'sticky'
			$('.navbar-menu').removeClass 'dark'


	entrepreneurTable = $('#datatable-entrepreneurs').DataTable(
		'pageLength': 50
		'processing': false
		'serverSide': true
		'bAutoWidth': false
		'aaSorting': [[0,'asc']]
		'ajax':
			url: '/backoffice/entrepreneurs/get-entrepreneurs'
			type: 'post'
			data: (data) ->
				filters = {}
				filters.firm_name = $('select[name="firm_name"]').val()
				data.filters = filters
				data

			error: ->


				return


		'columns': [
			{ 'data': 'name' }
			{ 'data': 'email' }
			{ 'data': 'firm'}
			{ 'data': 'business' }
			{ 'data': 'registered_date'}
			{ 'data': 'source', "orderable": false}
			{ 'data': 'action' , "orderable": false}
		])


	$('.entrepreneurSearchinput').change ->
		entrepreneurTable.ajax.reload()
		return

	$('.download-entrepreneur-csv').click ->
		firm_name = $('select[name="firm_name"]').val()
		window.open("/backoffice/entrepreneur/export-entrepreneurs?firm_name="+firm_name);

	$('body').on 'click', '.entrepreneurs-reset-filters', ->
		$('select[name="firm_name"]').val('').trigger('change')
		entrepreneurTable.ajax.reload()
		return

	fundmanagerTable = $('#datatable-fundmanagers').DataTable(
		'pageLength': 50
		'processing': false
		'serverSide': true
		'bAutoWidth': false
		'aaSorting': [[0,'asc']]
		'ajax':
			url: '/backoffice/fundmanagers/get-fundmanagers'
			type: 'post'
			data: (data) ->
				filters = {}
				filters.firm_name = $('select[name="firm_name"]').val()
				data.filters = filters
				data

			error: ->
				console.log "error"
				return


		'columns': [
			{ 'data': 'name' }
			{ 'data': 'email' }
			{ 'data': 'firm'}
			{ 'data': 'business' }
			{ 'data': 'registered_date'}
			{ 'data': 'source', "orderable": false}
			{ 'data': 'action' , "orderable": false}
		])


	$('.fundmanagerSearchinput').change ->
		fundmanagerTable.ajax.reload()
		return

	$('.download-fundmanager-csv').click ->
		firm_name = $('select[name="firm_name"]').val()
		window.open("/backoffice/fundmanager/export-fundmanagers?firm_name="+firm_name);

	$('body').on 'click', '.fundmanagers-reset-filters', ->
		$('select[name="firm_name"]').val('').trigger('change')
		fundmanagerTable.ajax.reload()
		return

	businesslistingsTable = $('#datatable-businesslistings').DataTable(
		'pageLength': 50
		'searching':false
		'processing': false
		'serverSide': true
		'bAutoWidth': false
		"dom": '<"top d-sm-flex justify-content-sm-between w-100"li>t<"bottom d-sm-flex justify-content-sm-between w-100"ip>' 
		'aaSorting': [[1,'asc']]
		'ajax':
			url: '/backoffice/business-listings/get-businesslistings'
			type: 'post'
			data: (data) ->
				filters = {}
				filters.firm_name = $('select[name="firm_name"]').val()
				filters.business_listings_type = $('select[name="business_listings_type"]').val()
				business_invest_listings = 'yes'
				if window.location.pathname.indexOf('invest-listings')==-1
					business_invest_listings ="no"
				filters.invest_listings = business_invest_listings
				data.filters = filters
				data

			error: ->


				return


		'columns': [
			{ 'data': 'logo' , "orderable": false}
			{ 'data': 'name' }
			{ 'data': 'duediligence' }
			{ 'data': 'created_date'}
			{ 'data': 'modified_date'}
			{ 'data': 'firmtoraise', "orderable": false}
			{ 'data': 'activity_sitewide', "orderable": false}
			{ 'data': 'activity_firmwide', "orderable": false}
			{ 'data': 'action' , "orderable": false}
		])


	$('.businesslistingsSearchinput').change ->
		businesslistingsTable.ajax.reload()
		return


	$(document).on 'change', '#managebusiness_type', ->
		window.open("/backoffice/"+$(this).val(),"_self");

	$('.download-business-listings-csv').click ->
		firm_name = $('select[name="firm_name"]').val()
		business_listings_type = $('select[name="business_listings_type"]').val()
		window.open("/backoffice/business-listing/export-business-listings?firm_name="+firm_name+"&business_listings_type="+business_listings_type);

	$('body').on 'click', '.business-listings-reset-filters', ->
		$('select[name="firm_name"]').val('').trigger('change')
		$('select[name="business_listings_type"]').val('').trigger('change')
		businesslistingsTable.ajax.reload()
		return




	businesslistingsTable = $('#datatable-currentbusinessvaluations').DataTable(
		'pageLength': 50
		'processing': false
		'serverSide': true
		'bAutoWidth': false
		'aaSorting': [[1,'asc']]
		'ajax':
			url: '/backoffice/business-listings/get-current-valuation-listings'
			type: 'post'
			data: (data) ->
				data
			error: ->
				return
		'columns': [
			{ 'data': 'name' }
			{ 'data': 'created_date'}
			{ 'data': 'total_valuation', "orderable": false}
			{ 'data': 'share_price', "orderable": false}
			{ 'data': 'action' , "orderable": false}
		])



	$('.btn-view-invite').click ->


		invite_type = $(this).attr('invite-type')
		firmid = $('#invite_firm_name').val()
		if firmid==""
			alert "Please select firm"
			return

		$.ajax
			type: 'get'
			url: '/backoffice/firm-invite/'+firmid+'/'+invite_type
			success: (data) ->
				console.log(data)
				CKEDITOR.instances['invite_content'].setData(data.invite_content);
				$('input[name="invite_link"]').val("http://seedtwin.ajency.in/register/?"+data.invite_key+"#"+invite_type)


	#tabs functionality on mobile
	$('body').on 'click', '.squareline-tabs .nav-link.active', (e)->
		e.preventDefault()
		$('.squareline-tabs .nav-item .nav-link').toggleClass 'd-none d-block'

	# toggle columns
	if $(window).width() < 767
		if $('.toggle-btn input:checkbox:not(:checked)')
			column = 'table .' + $('.toggle-btn input').attr('name')
			$(column).hide()

		$('body').on 'click', '.toggle-btn', ->
			column = 'table .' + $(this).find('input[type="checkbox"]').attr('name')
			$(column).toggle()
			return
		return


	$('select[name="invite_firm_name"]').change ->
		$('#invite_display').addClass('d-none')

	$('.cancel-invite-btn').click ->
		$('#invite_display').addClass('d-none')

	$('.save-invite-btn').click ->

		invite_type = $(this).attr('invite-type')
		firmid = $('#invite_firm_name').val()
		if firmid==""
			alert "Please select firm"
			return
		$('form[name="form-invite-firm"]').submit();

	$('body').on 'click', '.edit_valuation', ->
		business_id = $(this).attr('proposal-id')
		share_price = $(this).attr('share-price')
		total_valuation = $(this).attr('total-valuation')
		$('#editing_business_id').val(business_id)
		$('#inp_shareprice').val(share_price)
		$('#inp_totalvaluation').val(total_valuation)
		$('#currentValuationModal').modal('show')
		return

	$('body').on 'click', '#current_valuation_save', ->
		total_valuation = $('#inp_totalvaluation').val()
		share_price = $('#inp_shareprice').val()
		business_id = $('#editing_business_id').val()
		$.ajax
			type: 'post'
			url: '/backoffice/save-current-business-valuation'
			headers:
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			data:
				'business_id': business_id
				'share_price': share_price
				'total_valuation': total_valuation
			success: (data) ->
				$('.spn_totalvaluation_'+business_id).html(total_valuation)
				$('.spn_shareprice_'+business_id).html(share_price)
				if data.status
					$('.gi-danger').addClass('d-none')
					$('.gi-danger').html ""
					$('.gi-success').html "Valuation Saved Successfully."
					$('.spn_totalvaluation_'+business_id).html(total_valuation)
					$('.spn_shareprice_'+business_id).html(share_price)
				else
					$('.gi-danger').html "Failed to Save Valuation."
					$('.gi-success').html ""

	$('.download-current-business-valuation-csv').click ->		 
		window.open("/backoffice/current-valuations/export-current-valuations");
				 
	 		 




