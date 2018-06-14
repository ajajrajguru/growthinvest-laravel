$.ajaxSetup headers: 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

$(document).ready ->

	getFilteredPortfoilio = ->
		filters = {}
		filters.duration = $('select[name="duration"]').val()
		filters.duration_from = $('input[name="duration_from"]').val()
		filters.duration_to = $('input[name="duration_to"]').val()
		filters.tax_year = $('select[name="tax_year"]').val()
		filters.investor = $('select[name="user"]').val()
		filters.asset_status = $('select[name="asset_status"]').val()
		filters.investment_origin = $('select[name="investment_origin"]').val()
		filters.company = $('select[name="companies"]').val()
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

				# if($('#investment_type_pledge').length)
				# 	dataProvider = data.investmentTypePledgeData
				# 	window.ajPieChartWithLegend('investment_type_pledge',dataProvider,'amount','Investmenttype')

				# if($('#sector_analysis_pledge').length)
				# 	dataProvider = data.sectorAnalysisPledge
				# 	window.ajPieChartWithLegend('sector_analysis_pledge',dataProvider,'amount','sectortype')

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
				if topInvestments.length
					$.each topInvestments, (index, value) ->
						invAmt= parseInt(value.amount)
						totalInvestment= parseInt(totalInvestment)
						percentage = (invAmt/totalInvestment)*100
						topHoldingHtml += '<div class="row">
						<div class="col-sm-3"><label>'+value.title+'</label> </div>
						<div class="col-sm-3">'+percentage.toFixed(2)+'%</div>
						<div class="col-sm-3">'+value.formated_amount+'</div>
						</div>'
				else
					topHoldingHtml = 'The Table Contains No Data'

				$("#top_holdings").html topHoldingHtml
				$("#investment_details_list").html data.investmentHtml

				$('a[type="portfolio"]').attr('reset-data',false)
				$('a[type="pledged"]').attr('reset-data',false)
				$('a[type="watchlist"]').attr('reset-data',false)
				$('a[type="cashaccount"]').attr('reset-data',false)
	 
				# if($('#pledge_investment_details_list').length)
				# 	$("#pledge_investment_details_list").html data.pledgedInvestmentHtml

				# if($('#watchlist_investment_details_list').length)
				# 	$("#watchlist_investment_details_list").html data.watchlistInvestmentHtml
				

 
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
	    $('select[name="duration"]').val('lasttwomonth').attr('disabled',false).trigger('change')
	    $('input[name="duration_from"]').val('').attr('disabled',false)
	    $('input[name="duration_to"]').val('').attr('disabled',false)
	    $('select[name="tax_year"]').val('').trigger('change').attr('disabled',false)
	    $('select[name="asset_status"]').val('').trigger('change')
	    $('select[name="companies"]').val('').trigger('change')
	    $('select[name="firm"]').val('').trigger('change')
	    window.history.pushState("", "", "?");
	    getFilteredPortfoilio()
	    
	    return 

	$(document).on 'shown.bs.tab', 'a[data-toggle="tab"]', ->
		type = $(this).attr('type')
		console.log type

		filters = {}
		filters.duration = $('select[name="duration"]').val()
		filters.duration_from = $('input[name="duration_from"]').val()
		filters.duration_to = $('input[name="duration_to"]').val()
		filters.tax_year = $('select[name="tax_year"]').val()
		filters.investor = $('select[name="user"]').val()
		filters.asset_status = $('select[name="asset_status"]').val()
		filters.investment_origin = $('select[name="investment_origin"]').val()
		filters.company = $('select[name="companies"]').val()
		filters.firmid = $('select[name="firm"]').val()
		getdata = true;
 
		if($('a[type="'+type+'"]').attr('reset-data') == 'false')
			getdata = false;

		if(type == 'pledged' && !getdata)
			$.ajax
				type: 'post'
				url: '/backoffice/portfolio/get-portfolio-pledge-data'
				data:filters
				success: (data) ->
					dataProvider = data.investmentTypePledgeData
					window.ajPieChartWithLegend('investment_type_pledge',dataProvider,'amount','Investmenttype')

					dataProvider = data.sectorAnalysisPledge
					window.ajPieChartWithLegend('sector_analysis_pledge',dataProvider,'amount','sectortype')

					if($('#pledge_investment_details_list').length)
						$("#pledge_investment_details_list").html data.pledgedInvestmentHtml
		else if(type == 'watchlist' && !getdata)
			$.ajax
				type: 'post'
				url: '/backoffice/portfolio/get-portfolio-watchlist-data'
				data:filters
				success: (data) ->
					if($('#watchlist_investment_details_list').length)
						$("#watchlist_investment_details_list").html data.watchlistInvestmentHtml

		else if(type == 'transferasset' && !getdata)
			investorId = $('select[name="user"]').val()
			$.ajax
				type: 'post'
				url: '/backoffice/transfer-asset/investor-assets'
				data:
					'investor_id': investorId
				success: (data) ->
					$('.investor_transfer_asset_list').html(data.businesslisting_html)
				 
		else if(type == 'cashaccount' && !getdata)
			investorId = $('select[name="user"]').val()
			$.ajax
				type: 'post'
				url: '/backoffice/portfolio/get-portfolio-cashaccount-data'
				data:
					'investor_id': investorId
				success: (data) ->
					$('.cash_balance').html(data.cashAmount)
					$('.cash_last_updated_date').html(data.lasUpdatedDate)
					$('.cash_account_investment_list').html(data.transactionHtml)

		$('a[type="'+type+'"]').attr('reset-data',true)





	$('body').on 'change', 'select[name="duration"]', ->
		if($(this).val())
			$('input[name="duration_from"]').val('').attr('disabled',true)
			$('input[name="duration_to"]').val('').attr('disabled',true)
			$('select[name="tax_year"]').val('').attr('disabled',true)
		else
			$('input[name="duration_from"]').val('').attr('disabled',false)
			$('input[name="duration_to"]').val('').attr('disabled',false)
			$('select[name="tax_year"]').val('').attr('disabled',false)

	$('body').on 'change', 'select[name="tax_year"]', ->
		if($(this).val())
			$('input[name="duration_from"]').val('').attr('disabled',true)
			$('input[name="duration_to"]').val('').attr('disabled',true)
			$('select[name="duration"]').val('').attr('disabled',true)
		else
			$('input[name="duration_from"]').val('').attr('disabled',false)
			$('input[name="duration_to"]').val('').attr('disabled',false)
			$('select[name="duration"]').val('').attr('disabled',false) 

	$('body').on 'change', '.date_range', ->
		if($(this).val())
			$('select[name="duration"]').val('').attr('disabled',true)
			$('select[name="tax_year"]').val('').attr('disabled',true)
		else
			$('select[name="duration"]').val('').attr('disabled',false)
			$('select[name="tax_year"]').val('').attr('disabled',false)

	$('body').on 'click', '.download-portfolio-report-xlsx', ->
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
		
		window.open("/backoffice/portfolio/export-report?"+urlParams);


	$('body').on 'click', '.download-portfolio-report-pdf', ->
	  seed_logo_base_64 = 'data:image/jpeg;base64,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'
	  imgdata = new Array
	  imgdata2 = new Array
	  images = []
	  pending = AmCharts.charts.length
	  console.log 'count'
	  console.log pending
	  i = 0
	  while i < AmCharts.charts.length
	    chart = AmCharts.charts[i]
	    console.log 'CHART DIV ID: ' + chart.div.id
	    cur_div_id = chart.div.id
	    chart['export'].capture { cur_div_id: cur_div_id }, (cur_div_id) ->

	      newdivid = undefined
	      newdivid = cur_div_id.cur_div_id
	      @toJPG { newdivid: newdivid }, (data) ->
	        docDefinition = undefined
	        pdf_name = undefined
	        imgdata2[newdivid] = data
	        images.push
	          'image': data
	          'fit': [
	            523.28
	            769.89
	          ]
	        pending--
	        if pending == 0
	          docDefinition =
	            pageMargins: [
	              10
	              100
	              10
	              100
	            ]
	            header: (currentPage, pageCount) ->
	              {
	                image: seed_logo_base_64
	                width: 80
	                alignment: 'center'
	              }
	            footer: (page, pages) ->
	              {
	                layout: 'noBorders'
	                table:
	                  widths: [
	                    280
	                    280
	                  ]
	                  body: [
	                    [
	                      {
	                        colSpan: 2
	                        alignment: 'center'
	                        canvas: [ {
	                          type: 'line'
	                          x1: 10
	                          y1: 5
	                          x2: 578
	                          y2: 5
	                          lineWidth: 1
	                        } ]
	                      }
	                      {}
	                    ]
	                    [
	                      {
	                        colSpan: 2
	                        alignment: 'center'
	                        text: [
	                          {
	                            text: 'GrowthInvest '
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                          {
	                            text: 'Candlewick House, 120 Cannon Street, London EC4N 6AS \nT:'
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': false
	                          }
	                          {
	                            text: '020 7071 3945'
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                          {
	                            text: ' E: '
	                            italics: true
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': false
	                          }
	                          {
	                            text: ' enquiries@growthinvest.com W: growthinvest.com '
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                          {
	                            text: ' W: '
	                            italics: true
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': false
	                          }
	                          {
	                            text: ' growthinvest.com '
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                          {
	                            text: '\n\nGrowthInvest is a trading name of EIS Platforms Limited. EIS Platforms Limited (FRN: 694945) is an appointed representative of Sapphire'
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': false
	                          }
	                          {
	                            text: '\nCapital Partners LLP (FRN:565716) which is authorised and regulated by the Financial Conduct Authority in the UK.'
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': false
	                          }
	                        ]
	                      }
	                      {}
	                    ]
	                    [
	                      {
	                        text: ' \u0009           Portfolio Summary'
	                        italics: true
	                        color: 'black'
	                        'fontSize': 8
	                        'bold': true
	                        margin: [
	                          10
	                          0
	                          200
	                          0
	                        ]
	                      }
	                      {
	                        alignment: 'right'
	                        text: [
	                          {
	                            text: page.toString()
	                            italics: true
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                          {
	                            text: ' of '
	                            italics: true
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                          {
	                            text: pages.toString()
	                            italics: true
	                            color: 'black'
	                            'fontSize': 8
	                            'bold': true
	                          }
	                        ]
	                      }
	                    ]
	                  ]
	              }
	            content: [ {
	              style: 'tableExample'
	              table: body: [
	                [ [
	                  ''
	                  {
	                    table: body: [
	                      [
	                        [
	                          'Investment Type'
	                          {
	                            image: imgdata2['investment_type']
	                            width: 270
	                          }
	                        ]
	                        [
	                          'Sector Analysis'
	                          {
	                            image: imgdata2['sector_analysis']
	                            width: 270
	                          }
	                        ]
	                      ]
	                      [
	                        [
	                          'Business Stage Analysis'
	                          {
	                            image: imgdata2['business_stage_analysis']
	                            width: 270
	                          }
	                        ]
	                        [
	                          'Investment Route : Direct Vs Fund/Portfolio'
	                          {
	                            image: imgdata2['investment_route']
	                            width: 270
	                          }
	                        ]
	                      ]
	                    ]
	                    layout: 'noBorders'
	                  }
	                ] ]
	                [ [
	                  ''
	                  {
	                    table: body: [ [
	                      [
	                        'Investment by Tax Year(Bar Graph)'
	                        {
	                          image: imgdata2['investment_by_tax_bar']
	                          width: 270
	                        }
	                      ]
	                      [
	                        'Investment by Tax Year(Pie Chart)'
	                        {
	                          image: imgdata2['investment_by_tax_pie']
	                          width: 270
	                        }
	                      ]
	                    ] ]
	                    layout: 'noBorders'
	                  }
	                ] ]
	              ]
	              layout: 'noBorders'
	            } ]
	          pdf_name = 'Portfolio.pdf'
	          pdfMake.createPdf(docDefinition).download pdf_name
	        return
	      return
	    i++


	 
				
		



				 
	 		 


