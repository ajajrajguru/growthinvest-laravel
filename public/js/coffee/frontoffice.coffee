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



	$(document).on 'click', '.btn-invest-now', (e)->
	 	e.preventDefault()
	 	business_type = $(this).attr('data-businesstype')
	 	user_id = $(this).attr('data-userid')
	 	business_id = $(this).attr('data-businessid')
	 	 
	 	$.ajax
	 		type: 'post'
	 		url: '/frontoffice/show-invest-in-business-modal'
	 		headers:
	 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 		data:
	 			'business_type': business_type
	 			'business_id': business_id
	 			'user_id': user_id
	 		success: (data) ->
	 			$('#cust-invest-modal').remove()	 			 
	 			$('body').append(data.invest_modal)
	 			$('#cust-invest-modal').modal('show')

	$(document).on 'click', '#btn_investform', (e)->
		e.preventDefault()
		if $('#max_inv_planned').val() ==''
			$('#investment_msg').html "Please enter Investment amount."
			$('#investment_msg').addClass('text-danger')
			setTimeout ->
				$('#investment_msg').html ""
				$('#investment_msg').removeClass('text-danger');
			, 5000
		else if $('#max_inv_planned').val() > 0
			$('#investment_msg').html ""
			$('#investment_msg').removeClass('text-danger');
			format_max_investment = formatAmount($('#max_inv_planned').val(),2,true,true);
			$('#invest-confirm').modal('show');

	$(document).on 'click', '#btn_cancel_conf_investment', (e)->
		e.preventDefault()
		$('#invest-confirm').modal('hide');

	requiredInvestment = () ->
		desired_investment =  $('#pledge_desiredinvestment').val() ",", "" 
		price_per_share =  $('#pledge_pricepershare').val().replace ",", "" 

		if price_per_share=="" || typeof price_per_share =="undefined"
			$('.equired_investment_msg').html "Since the 'price per share' is unknown, 'required investment' cannot be calculated. Please contact a member of the GrowthInvest team to complete your investment on: 020 7071 3945"
			$('#pledge_nosharesrequested').val('');
      		$('#max_inv_planned').val('');
    	