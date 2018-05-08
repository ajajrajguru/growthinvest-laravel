$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->

	getFilteredPortfoilio = ->
		filters = {}
		filters.duration = $('select[name="duration"]').val()
		filters.duration_from = $('input[name="duration_from"]').val()
		filters.duration_to = $('input[name="duration_to"]').val()
		filters.user_id = $('select[name="user"]').val()
		filters.type = $('select[name="type"]').val()
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

	 
				
		



				 
	 		 


