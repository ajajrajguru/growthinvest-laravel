(function() {
  window.ajLineChart = function(containerId, dataProvider, graphs, categoryField) {
    var chart;
    graphs = $.parseJSON(graphs);
    return chart = AmCharts.makeChart(containerId, {
      'type': 'serial',
      'theme': 'light',
      'legend': {
        'useGraphSettings': true,
        'markerSize': 12,
        'valueWidth': 0,
        'verticalGap': 0
      },
      'dataProvider': dataProvider,
      'valueAxes': [
        {
          'minorGridAlpha': 0.08,
          'minorGridEnabled': true,
          'position': 'top',
          'axisAlpha': 0
        }
      ],
      'startDuration': 1,
      'graphs': graphs,
      'rotate': true,
      'categoryField': categoryField,
      'categoryAxis': {
        'gridPosition': 'start'
      },
      'export': {
        'enabled': true
      }
    });
  };

  window.ajPieChartWithLegend = function(containerId, dataProvider, valueField, titleField, percent) {
    var chart, handleInit, handleRollOver, legendValueText;
    if (percent == null) {
      percent = true;
    }
    if (!percent) {
      legendValueText = ': [[value]]';
    } else {
      legendValueText = ': [[percents]]%';
    }
    chart = AmCharts.makeChart(containerId, {
      'type': 'pie',
      'startDuration': 0,
      'theme': 'none',
      'autoMargins': false,
      'legend': {
        'position': 'right',
        'labelText': '[[title]]',
        'valueText': legendValueText,
        'marginRight': 100,
        'autoMargins': false
      },
      'innerRadius': '30%',
      'defs': {
        'filter': [
          {
            'id': 'shadow',
            'width': '200%',
            'height': '200%',
            'feOffset': {
              'result': 'offOut',
              'in': 'SourceAlpha',
              'dx': 0,
              'dy': 0
            },
            'feGaussianBlur': {
              'result': 'blurOut',
              'in': 'offOut',
              'stdDeviation': 5
            },
            'feBlend': {
              'in': 'SourceGraphic',
              'in2': 'blurOut',
              'mode': 'normal'
            }
          }
        ]
      },
      'dataProvider': dataProvider,
      'valueField': valueField,
      'titleField': titleField,
      'balloonText': '[[title]]<br><span style="font-size:14px"><b>[[value]]</b> ([[percents]]%)</span>',
      'export': {
        'enabled': true
      }
    });
    handleInit = function() {
      chart.legend.addListener('rollOverItem', handleRollOver);
    };
    handleRollOver = function(e) {
      var wedge;
      wedge = e.dataItem.wedge.node;
      wedge.parentNode.appendChild(wedge);
    };
    chart.addListener('init', handleInit);
    return chart.addListener('rollOverSlice', function(e) {
      handleRollOver(e);
    });
  };

  window.ajLayeredColumnBar = function(containerId, dataProvider, unitType, unitTitle, graphs) {
    var chart;
    return chart = AmCharts.makeChart(containerId, {
      'theme': 'light',
      'type': 'serial',
      'dataProvider': dataProvider,
      'valueAxes': [
        {
          'unit': unitType,
          'position': 'left',
          'title': unitTitle
        }
      ],
      'startDuration': 1,
      'graphs': graphs,
      'plotAreaFillAlphas': 0.1,
      'categoryField': 'country',
      'categoryAxis': {
        'gridPosition': 'start'
      },
      'export': {
        'enabled': true
      }
    });
  };

  window.ajClusteredBar = function(containerId, dataProvider, categoryField, unitTitle, graphs) {
    var chart;
    return chart = AmCharts.makeChart(containerId, {
      'type': 'serial',
      'theme': 'light',
      'categoryField': categoryField,
      'rotate': false,
      'startDuration': 1,
      'categoryAxis': {
        'gridPosition': 'start',
        'position': 'left'
      },
      'trendLines': [],
      'graphs': graphs,
      'guides': [],
      'valueAxes': [
        {
          'id': 'ValueAxis-1',
          'position': 'left',
          'title': unitTitle,
          'axisAlpha': 0
        }
      ],
      'allLabels': [],
      'balloon': {},
      'titles': [],
      'dataProvider': dataProvider,
      'export': {
        'enabled': true
      }
    });
  };

}).call(this);
