const getStackedBarChart = (containerId, chartData, baseAxis, seriesObjects, titleText) => {
  am4core.ready(function() {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    // Create chart instance
    var chart = am4core.create(containerId, am4charts.XYChart);
    // Add data
    chart.data = chartData;
    chart.logo.disabled = true;
    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = baseAxis;
    categoryAxis.renderer.grid.template.location = 0;
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    valueAxis.renderer.inside = true;
    valueAxis.renderer.labels.template.disabled = true;
    valueAxis.min = 0;
    
    // Create series
    function createSeries(field, name) {
      // Set up series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.name = name;
      series.dataFields.valueY = field;
      series.dataFields.categoryX = baseAxis;
      series.sequencedInterpolation = true;
      // Make it stacked
      series.stacked = true;
      // Configure columns
      series.columns.template.width = am4core.percent(60);
      series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";
      // Add label
      var labelBullet = series.bullets.push(new am4charts.LabelBullet());
      labelBullet.label.text = "{valueY}";
      labelBullet.locationY = 0.5;
      labelBullet.label.hideOversized = true;
      return series;
    }
    
    seriesObjects.sort();
    seriesObjects.forEach(ele => createSeries(ele, ele));

    // Legend
    chart.legend = new am4charts.Legend();
    chart.legend.position = "top";
    // Chart Title
    var title = chart.titles.create();
    title.text = titleText;
    title.fontSize = 18;
    title.marginBottom = 12;
      
  }); // end am4core.ready()

}


const getBarChart = (containerId, chartData, baseAxis, magnitudeAxis, seriesName, titleText) => {
  am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create(containerId, am4charts.XYChart);
    
    // Add data
    chart.data = chartData;
    chart.logo.disabled = true;
    
    // Create axes
    
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = baseAxis;
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;
    
    categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
      if (target.dataItem && target.dataItem.index & 2 == 2) {
        return dy + 25;
      }
      return dy;
    });
    
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    
    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = magnitudeAxis; 
    series.dataFields.categoryX = baseAxis;
    series.name = seriesName; // Quantity
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;
    
    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;

    // Legend
    chart.legend = new am4charts.Legend();
    chart.legend.position = "top";
    // Chart Title
    var title = chart.titles.create();
    title.text = titleText;
    title.fontSize = 18;
    title.marginBottom = 12;    
    }); // end am4core.ready()
}