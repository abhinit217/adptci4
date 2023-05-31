 // Create chart instance
var chart = am4core.create("rcihs-one", am4charts.XYChart);
chart.logo.disabled = 'true'

// Add data
chart.data = [{
                "crop": "Kawanda - Common bean",
                "visits": 3025
            }, {
                "crop": "Uganda - Common bean",
                "visits": 1882
            }, {
                "crop": "Bulawayo - Groundnut",
                "visits": 1809
            }, {
                "crop": "Bulawayo - Finger millet",
                "visits": 1322
            }, {
                "crop": "Bulawayo - Pearl millet",
                "visits": 1122
            }, {
                "crop": "Bulawayo - Sorghum",
                "visits": 1114
            },{
                "crop": "Zimbabwe - Groundnut",
                "visits": 1809
            }, {
                "crop": "Zimbabwe - Finger millet",
                "visits": 1322
            }, {
                "crop": "Zimbabwe - Pearl millet",
                "visits": 1122
            }, {
                "crop": "Zimbabwe - Sorghum",
                "visits": 1114
            },{
                "crop": "Bamako - Groundnut",
                "visits": 1322
            }, {
                "crop": "Bamako - Pearl millet",
                "visits": 1122
            }, {
                "crop": "Bamako - Sorghum",
                "visits": 1114
            },{
                "crop": "Mali - Groundnut",
                "visits": 1322
            }, {
                "crop": "Mali - Pearl millet",
                "visits": 1122
            }, {
                "crop": "Mali - Sorghum",
                "visits": 1114
            },{
                "crop": "Kano - Cowpea",
                "visits": 1122
            }, {
                "crop": "Nigeria - Cowpea",
                "visits": 1114
            }];


// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Number";
valueAxis.title.fontWeight = "bold";

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "crop";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 0;
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";


// Configure axis label
var label = categoryAxis.renderer.labels.template;
//label.truncate = true;
//label.maxWidth = 120;
label.tooltipText = "{crop}";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "crop";
series.tooltipText = "[{categoryX}: bold]{crop}-{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

var bullet = series.bullets.push(new am4charts.LabelBullet())
    bullet.interactionsEnabled = false
    bullet.dy = -10;
    bullet.label.text = '{valueY}'
    bullet.label.fontSize = '13px'
    bullet.label.fill = am4core.color('#000')

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();