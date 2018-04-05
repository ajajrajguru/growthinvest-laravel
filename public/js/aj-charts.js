(function() {
  window.ajLineChart = function(containerId, dataProvider, graphs, categoryField) {
    var chart;
    dataProvider = $.parseJSON(dataProvider);
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

}).call(this);
