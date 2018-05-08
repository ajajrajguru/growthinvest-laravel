$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->

	getFilteredPortfoilio = ->
		filters = {}
		filters.duration = $('select[name="duration"]').val()
		filters.duration_from = $('input[name="duration_from"]').val()
		filters.duration_to = $('input[name="duration_to"]').val()
		filters.tax_year = $('select[name="tax_year"]').val()
		filters.user_id = $('select[name="user"]').val()
		filters.asset_status = $('select[name="asset_status"]').val()
		filters.investment_origin = $('select[name="investment_origin"]').val()
		filters.companies = $('select[name="companies"]').val()
		filters.firmid = $('select[name="firm"]').val()

		$.ajax
			type: 'post'
			url: '/backoffice/portfolio/get-portfolio-data'
			data:filters
			success: (data) ->
				dataProvider = data.investmentTypeData
				window.ajPieChartWithLegend('investment_type',dataProvider,'amount','Investmenttype')

				dataProvider = data.sectorAnalysis
				window.ajPieChartWithLegend('sector_analysis',dataProvider,'amount','sectortype')

				dataProvider = data.businessStageAnalysis
				window.ajPieChartWithLegend('business_stage_analysis',dataProvider,'amount','stage')

				dataProvider = data.investmentRoute
				window.ajPieChartWithLegend('investment_route',dataProvider,'amount','investmenttype')

				dataProvider = data.investmentTypeByYear
				graph = data.graph
				window.ajClusteredBar('investment_by_tax_bar',dataProvider,'year','Investment By Tax Year',graph)

				dataProvider = data.investmentByYear
				window.ajPieChartWithLegend('investment_by_tax_pie',dataProvider,'amount','year',false)

				portfolioSummary = data.portfolioSummary
				$('#total_investment').html(portfolioSummary.invested)
				$('#eis_investment_count').html(portfolioSummary.investmentTypeData.eis_count)
				$('#number_investment').html(portfolioSummary.invested_count)
				$('#eis_investment_amount').html(portfolioSummary.investmentTypeData.eis_amount)
				$('#pledge').html(portfolioSummary.pledged)
				$('#seis_investment_count').html(portfolioSummary.investmentTypeData.seis_count)
				$('#followings').html(portfolioSummary.watchlist_count)
				$('#seis_investment_amount').html(portfolioSummary.investmentTypeData.seis_amount)
				$('#cash_balance').html(portfolioSummary.cash_amount)
				$('#vct_investment_count').html(portfolioSummary.investmentTypeData.vct_amount)
				$('#vct_investment_amount').html(portfolioSummary.investmentTypeData.vct_count)

				topHoldingHtml = ''
				topInvestments = data.topInvestmentData.topInvestments
				totalInvestment = data.topInvestmentData.totalInvestment
				$.each topInvestments, (index, value) ->
					invAmt= parseInt(value.amount)
					totalInvestment= parseInt(totalInvestment)
					console.log invAmt
					console.log totalInvestment
					percentage = (invAmt/totalInvestment)*100
					topHoldingHtml += '<div class="row">
					<div class="col-sm-3"><label>'+value.title+'</label> </div>
					<div class="col-sm-3">'+percentage.toFixed(2)+'%</div>
					<div class="col-sm-3">'+value.formated_amount+'</div>
					</div>'

				$("#top_holdings").html topHoldingHtml
				$("#investment_details_list").html data.investmentHtml

 
		return
	getFilteredPortfoilio()	
 
	$('body').on 'click', '.apply-portfolio-filters	', ->
	    urlParams = ''

	    if($('select[name="duration"]').val()!="")
	      urlParams +='duration='+$('select[name="duration"]').val() 

	    if($('input[name="duration_from"]').val()!="")
	      urlParams +='&duration_from='+$('input[name="duration_from"]').val()

	    if($('input[name="duration_to"]').val()!="")
	      urlParams +='&duration_to='+$('input[name="duration_to"]').val()

	    if($('select[name="tax_year"]').val()!="")
	      urlParams +='&tax_year='+$('input[name="tax_year"]').val()

	    if($('select[name="asset_status"]').val()!="")
	      urlParams +='&asset_status='+$('select[name="asset_status"]').val()

	    if($('select[name="companies"]').val()!="")
	      urlParams +='&companies='+$('select[name="companies"]').val()

	    if($('select[name="firm"]').val()!="")
	      urlParams +='&firm='+$('select[name="firm"]').val()    

	    getFilteredPortfoilio()	
	    window.history.pushState("", "", "?"+urlParams);

	$('body').on 'click', '.reset-portfolio-filters', ->
	    $('select[name="duration"]').val('lasttwomonth').attr('disabled',false)
	    $('input[name="duration_from"]').val('').attr('disabled',false)
	    $('input[name="duration_to"]').val('').attr('disabled',false)
	    $('select[name="tax_year"]').val('')
	    $('select[name="asset_status"]').val('')
	    $('select[name="companies"]').val('')
	    $('select[name="firm"]').val('')
	    window.history.pushState("", "", "?");
	    getFilteredPortfoilio()
	    
	    return 


	$('body').on 'change', 'select[name="duration"]', ->
		if($(this).val())
			$('input[name="duration_from"]').val('').attr('disabled',true)
			$('input[name="duration_to"]').val('').attr('disabled',true)
			$('select[name="tax_year"]').val('').attr('disabled',true)
		else
			$('input[name="duration_from"]').val('').attr('disabled',false)
			$('input[name="duration_to"]').val('').attr('disabled',false)
			$('select[name="tax_year"]').val('').attr('disabled',true)

	$('body').on 'change', 'select[name="tax_year"]', ->
		if($(this).val())
			$('input[name="duration_from"]').val('').attr('disabled',true)
			$('input[name="duration_to"]').val('').attr('disabled',true)
			$('select[name="duration"]').val('').attr('disabled',true)
		else
			$('input[name="duration_from"]').val('').attr('disabled',false)
			$('input[name="duration_to"]').val('').attr('disabled',false)
			$('select[name="duration"]').val('').attr('disabled',true) 

	$('body').on 'change', '.date_range', ->
		if($(this).val())
			$('select[name="duration"]').val('').attr('disabled',true)
			$('select[name="tax_year"]').val('').attr('disabled',true)
		else
			$('select[name="duration"]').val('').attr('disabled',false)
			$('select[name="tax_year"]').val('').attr('disabled',true)

	 
				
		



				 
	 		 


