AmCharts.checkEmptyData = (chart) ->
  if 0 == chart.dataProvider.length
    # set min/max on the value axis
    chart.valueAxes[0].minimum = 0
    chart.valueAxes[0].maximum = 100
    # add dummy data point
    dataPoint = dummyValue: 0
    dataPoint[chart.categoryField] = ''
    chart.dataProvider = [ dataPoint ]
    # add label
    chart.addLabel 0, '50%', 'The chart contains no data', 'center'
    # set opacity of the chart div
    chart.chartDiv.style.opacity = 0.5
    # redraw it
    chart.validateNow()
  return

AmCharts.addInitHandler ((chart) ->
  `var dp`
  `var dp`
  # check if data is mepty
  if chart.dataProvider == undefined or chart.dataProvider.length == 0
    # add some bogus data
    dp = {}
    dp[chart.titleField] = ''
    dp[chart.valueField] = 1
    chart.dataProvider.push dp
    dp = {}
    dp[chart.titleField] = ''
    dp[chart.valueField] = 1
    chart.dataProvider.push dp
    dp = {}
    dp[chart.titleField] = ''
    dp[chart.valueField] = 1
    chart.dataProvider.push dp
    # disable slice labels
    chart.labelsEnabled = false
    # add label to let users know the chart is empty
    chart.addLabel '50%', '50%', 'The chart contains no data', 'middle', 15
    # dim the whole chart
    chart.alpha = 0.3
  return
), [ 'pie' ]


window.ajLineChart = (containerId,dataProvider,graphs,categoryField) ->  
	graphs = $.parseJSON(graphs)
 
	chart = AmCharts.makeChart(containerId,
	  'type': 'serial'
	  'theme': 'light'
	  'hideCredits':true
	  'legend':
	    'useGraphSettings': true
	    'markerSize': 12
	    'valueWidth': 0
	    'verticalGap': 0
	  'dataProvider': dataProvider
	  'valueAxes': [ {
	    'minorGridAlpha': 0.08
	    'minorGridEnabled': true
	    'position': 'top'
	    'axisAlpha': 0
	  } ]
	  'startDuration': 1
	  'graphs': graphs
	  'rotate': true
	  'categoryField': categoryField
	  'categoryAxis': 'gridPosition': 'start'
	  'export': 'enabled': true)

	AmCharts.checkEmptyData(chart)

window.ajPieChartWithLegend = (containerId,dataProvider,valueField,titleField,percent=true) ->  
	if(!percent)
		legendValueText = ': [[value]]'
	else
		legendValueText = ': [[percents]]%'

	chart = AmCharts.makeChart(containerId,
	  'type': 'pie'
	  'hideCredits':true
	  'startDuration': 0
	  'theme': 'none'
	  'autoMargins' : false
	  'labelsEnabled' : false
	  'legend':
	    'position': 'right'
	    'labelText': '[[title]]'
	    'valueText': legendValueText
	    'marginRight': 100
	    'maxColumns': 1
	    'autoMargins': false
	  'innerRadius': '30%'
	  'defs': 'filter': [ {
	    'id': 'shadow'
	    'width': '200%'
	    'height': '200%'
	    'feOffset':
	      'result': 'offOut'
	      'in': 'SourceAlpha'
	      'dx': 0
	      'dy': 0
	    'feGaussianBlur':
	      'result': 'blurOut'
	      'in': 'offOut'
	      'stdDeviation': 5
	    'feBlend':
	      'in': 'SourceGraphic'
	      'in2': 'blurOut'
	      'mode': 'normal'
	  } ]
	  'dataProvider': dataProvider
	  'valueField': valueField
	  'titleField': titleField
	  'balloonText': '[[title]]<br><span style="font-size:14px"><b>[[value]]</b> ([[percents]]%)</span>'
	  'export': 
	  	'enabled': true
	  	'menu': [])



window.ajLayeredColumnBar = (containerId,dataProvider,unitType,unitTitle,graphs) ->  
	chart = AmCharts.makeChart(containerId,
	  'theme': 'light'
	  'hideCredits':true
	  'type': 'serial'
	  'dataProvider': dataProvider
	  'valueAxes': [ {
	    'unit': unitType
	    'position': 'left'
	    'title': unitTitle
	  } ]
	  'startDuration': 1
	  'graphs': graphs
	  'plotAreaFillAlphas': 0.1
	  'categoryField': 'country'
	  'categoryAxis': 'gridPosition': 'start'
	  'export': 'enabled': true)

	AmCharts.checkEmptyData(chart)

window.ajClusteredBar = (containerId,dataProvider,categoryField,unitTitle,graphs) ->  
	chart = AmCharts.makeChart(containerId,
	  'hideCredits':true
	  'type': 'serial'
	  'theme': 'light'
	  'categoryField': categoryField
	  'rotate': false
	  'startDuration': 1
	  'categoryAxis':
	    'gridPosition': 'start'
	    'position': 'left'
	  'trendLines': []
	  'graphs': graphs
	  'guides': []
	  'valueAxes': [ {
	    'id': 'ValueAxis-1'
	    'position': 'left'
	    'title': unitTitle
	    'axisAlpha': 0
	  } ]
	  'allLabels': []
	  'balloon': {}
	  'titles': []
	  'dataProvider': dataProvider
	  'export': 
	  	'enabled': true
	  	'menu': [])

	AmCharts.checkEmptyData(chart)

 

 