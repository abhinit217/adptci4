am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

 // Create chart instance
var chart = am4core.create("program_wise_graph_one", am4charts.XYChart);
chart.logo.disabled = 'true'
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = [
{"program":"ESA - Common bean","count":2},
{"program":"Ethiopia - Common bean","count":3},
{"program":"Tanzania - Common bean","count":4},
{"program":"Uganda - Common bean","count":2},

{"program":"ESA - Groundnut","count":2},
{"program":"Ethiopia - Groundnut","count":3},
{"program":"Tanzania - Groundnut","count":4},
{"program":"Uganda - Groundnut","count":2},

{"program":"ESA - Finger millet","count":2},
{"program":"Ethiopia - Finger millet","count":3},
{"program":"Tanzania - Finger millet","count":4},
{"program":"Uganda - Finger millet","count":2},

{"program":"ESA - Pearl millet","count":2},
{"program":"Ethiopia - Pearl millet","count":3},
{"program":"Tanzania - Pearl millet","count":4},
{"program":"Uganda - Pearl millet","count":2},

{"program":"ESA - Sorghum","count":2},
{"program":"Ethiopia - Sorghum","count":3},
{"program":"Tanzania - Sorghum","count":4},
{"program":"Uganda - Sorghum","count":2},

{"program":"WCA - Groundnut","count":2},
{"program":"Burkina Faso - Groundnut","count":3},
{"program":"Ghana - Groundnut","count":4},
{"program":"Mali - Groundnut","count":2},
{"program":"Nigeria - Groundnut","count":2},

{"program":"WCA - Pearl millet","count":2},
{"program":"Burkina Faso - Pearl millet","count":3},
{"program":"Ghana - Pearl millet","count":4},
{"program":"Mali - Pearl millet","count":2},
{"program":"Nigeria - Pearl millet","count":2},

{"program":"WCA - Sorghum","count":2},
{"program":"Burkina Faso - Sorghum","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Sorghum","count":2},
{"program":"Nigeria - Sorghum","count":2},

{"program":"WCA - Cowpea","count":2},
{"program":"Burkina Faso - Cowpea","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Cowpea","count":2},
{"program":"Nigeria - Cowpea","count":2}


]


// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Number of generations";
valueAxis.title.fontWeight = "bold";

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 0;
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";


// Configure axis label
var label = categoryAxis.renderer.labels.template;
//label.truncate = true;
//label.maxWidth = 120;
label.tooltipText = "{program}";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{program}-{valueY}[/]";
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
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.filePrefix = "measure_download";
}); // end am4core.ready()



//Graph - 2
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
 // Create chart instance
var chart = am4core.create("program_wise_graph_two", am4charts.XYChart);
chart.logo.disabled = 'true'
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = [
{"program":"ESA - Common bean","count":2},
{"program":"Ethiopia - Common bean","count":3},
{"program":"Tanzania - Common bean","count":4},
{"program":"Uganda - Common bean","count":2},

{"program":"ESA - Groundnut","count":2},
{"program":"Ethiopia - Groundnut","count":3},
{"program":"Tanzania - Groundnut","count":4},
{"program":"Uganda - Groundnut","count":2},

{"program":"ESA - Finger millet","count":2},
{"program":"Ethiopia - Finger millet","count":3},
{"program":"Tanzania - Finger millet","count":4},
{"program":"Uganda - Finger millet","count":2},

{"program":"ESA - Pearl millet","count":2},
{"program":"Ethiopia - Pearl millet","count":3},
{"program":"Tanzania - Pearl millet","count":4},
{"program":"Uganda - Pearl millet","count":2},

{"program":"ESA - Sorghum","count":2},
{"program":"Ethiopia - Sorghum","count":3},
{"program":"Tanzania - Sorghum","count":4},
{"program":"Uganda - Sorghum","count":2},

{"program":"WCA - Groundnut","count":2},
{"program":"Burkina Faso - Groundnut","count":3},
{"program":"Ghana - Groundnut","count":4},
{"program":"Mali - Groundnut","count":2},
{"program":"Nigeria - Groundnut","count":2},

{"program":"WCA - Pearl millet","count":2},
{"program":"Burkina Faso - Pearl millet","count":3},
{"program":"Ghana - Pearl millet","count":4},
{"program":"Mali - Pearl millet","count":2},
{"program":"Nigeria - Pearl millet","count":2},

{"program":"WCA - Sorghum","count":2},
{"program":"Burkina Faso - Sorghum","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Sorghum","count":2},
{"program":"Nigeria - Sorghum","count":2},

{"program":"WCA - Cowpea","count":2},
{"program":"Burkina Faso - Cowpea","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Cowpea","count":2},
{"program":"Nigeria - Cowpea","count":2}


]


// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Number of generations";
valueAxis.title.fontWeight = "bold";

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 0;
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";


// Configure axis label
var label = categoryAxis.renderer.labels.template;
//label.truncate = true;
//label.maxWidth = 120;
label.tooltipText = "{program}";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{program}-{valueY}[/]";
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
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.filePrefix = "measure_download";
});


//Graph-3
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Create chart instance
var chart = am4core.create("program_wise_graph_three", am4charts.XYChart);
chart.logo.disabled = 'true'
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = [
{"program":"ESA - Common bean","count":2},
{"program":"Ethiopia - Common bean","count":3},
{"program":"Tanzania - Common bean","count":4},
{"program":"Uganda - Common bean","count":2},

{"program":"ESA - Groundnut","count":2},
{"program":"Ethiopia - Groundnut","count":3},
{"program":"Tanzania - Groundnut","count":4},
{"program":"Uganda - Groundnut","count":2},

{"program":"ESA - Finger millet","count":2},
{"program":"Ethiopia - Finger millet","count":3},
{"program":"Tanzania - Finger millet","count":4},
{"program":"Uganda - Finger millet","count":2},

{"program":"ESA - Pearl millet","count":2},
{"program":"Ethiopia - Pearl millet","count":3},
{"program":"Tanzania - Pearl millet","count":4},
{"program":"Uganda - Pearl millet","count":2},

{"program":"ESA - Sorghum","count":2},
{"program":"Ethiopia - Sorghum","count":3},
{"program":"Tanzania - Sorghum","count":4},
{"program":"Uganda - Sorghum","count":2},

{"program":"WCA - Groundnut","count":2},
{"program":"Burkina Faso - Groundnut","count":3},
{"program":"Ghana - Groundnut","count":4},
{"program":"Mali - Groundnut","count":2},
{"program":"Nigeria - Groundnut","count":2},

{"program":"WCA - Pearl millet","count":2},
{"program":"Burkina Faso - Pearl millet","count":3},
{"program":"Ghana - Pearl millet","count":4},
{"program":"Mali - Pearl millet","count":2},
{"program":"Nigeria - Pearl millet","count":2},

{"program":"WCA - Sorghum","count":2},
{"program":"Burkina Faso - Sorghum","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Sorghum","count":2},
{"program":"Nigeria - Sorghum","count":2},

{"program":"WCA - Cowpea","count":2},
{"program":"Burkina Faso - Cowpea","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Cowpea","count":2},
{"program":"Nigeria - Cowpea","count":2}


]


// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Number of fixed lines";
valueAxis.title.fontWeight = "bold";

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 0;
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";


// Configure axis label
var label = categoryAxis.renderer.labels.template;
//label.truncate = true;
//label.maxWidth = 120;
label.tooltipText = "{program}";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{program}-{valueY}[/]";
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
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.filePrefix = "measure_download";
});



// Graph-4
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Create chart instance
var chart = am4core.create("program_wise_graph_four", am4charts.XYChart);
chart.logo.disabled = 'true'
chart.scrollbarX = new am4core.Scrollbar();

// Add data
chart.data = [
{"program":"ESA - Common bean","count":2},
{"program":"Ethiopia - Common bean","count":3},
{"program":"Tanzania - Common bean","count":4},
{"program":"Uganda - Common bean","count":2},

{"program":"ESA - Groundnut","count":2},
{"program":"Ethiopia - Groundnut","count":3},
{"program":"Tanzania - Groundnut","count":4},
{"program":"Uganda - Groundnut","count":2},

{"program":"ESA - Finger millet","count":2},
{"program":"Ethiopia - Finger millet","count":3},
{"program":"Tanzania - Finger millet","count":4},
{"program":"Uganda - Finger millet","count":2},

{"program":"ESA - Pearl millet","count":2},
{"program":"Ethiopia - Pearl millet","count":3},
{"program":"Tanzania - Pearl millet","count":4},
{"program":"Uganda - Pearl millet","count":2},

{"program":"ESA - Sorghum","count":2},
{"program":"Ethiopia - Sorghum","count":3},
{"program":"Tanzania - Sorghum","count":4},
{"program":"Uganda - Sorghum","count":2},

{"program":"WCA - Groundnut","count":2},
{"program":"Burkina Faso - Groundnut","count":3},
{"program":"Ghana - Groundnut","count":4},
{"program":"Mali - Groundnut","count":2},
{"program":"Nigeria - Groundnut","count":2},

{"program":"WCA - Pearl millet","count":2},
{"program":"Burkina Faso - Pearl millet","count":3},
{"program":"Ghana - Pearl millet","count":4},
{"program":"Mali - Pearl millet","count":2},
{"program":"Nigeria - Pearl millet","count":2},

{"program":"WCA - Sorghum","count":2},
{"program":"Burkina Faso - Sorghum","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Sorghum","count":2},
{"program":"Nigeria - Sorghum","count":2},

{"program":"WCA - Cowpea","count":2},
{"program":"Burkina Faso - Cowpea","count":3},
{"program":"Ghana - Sorghum","count":4},
{"program":"Mali - Cowpea","count":2},
{"program":"Nigeria - Cowpea","count":2}


]


// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Number of breeding lines";
valueAxis.title.fontWeight = "bold";

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 0;
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";


// Configure axis label
var label = categoryAxis.renderer.labels.template;
//label.truncate = true;
//label.maxWidth = 120;
label.tooltipText = "{program}";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{program}-{valueY}[/]";
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

chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.filePrefix = "measure_download";
});


// Graph - 5
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("program_wise_graph_five", am4charts.SankeyDiagram);
        chart.hiddenState.properties.opacity = 0;
        chart.logo.disabled = 'true'


        chart.data = [
            { from: "Tanzania-Common bean", to: "Nutrition", value: 20, nodeColor: "#d79494", width: 10 },
            { from: "Tanzania-Common bean", to: "Abiotic stress tolerance", value: 20, nodeColor: "#82cee4", width: 10 },
            { from: "Tanzania-Common bean", to: "Biotic stress tolerance", value: 7, nodeColor: "#843ff4", width: 10 },
            { from: "Tanzania-Common bean", to: "Grain Yield", value: 7, nodeColor: "#f98988", width: 10 },
            { from: "Nigeria-Cowpea", to: "Early Maturity", value: 17, nodeColor: "#45b4c6", width: 10 },
            { from: "WCA-Cowpea", to: "Abiotic stress tolerance", value: 25, nodeColor: "#f9d533", width: 10},
            { from: "WCA-Cowpea", to: "Biotic stress tolerance", value: 4, nodeColor: "#ec64a3", width: 10 },
            { from: "WCA-Cowpea", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Pearl millet", to: "Other", value: 18, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Grain", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Other", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Biotic stress tolerance", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Early Maturity", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Abiotic stress tolerance", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Culinary", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Biotic stress tolerance", value: 8, nodeColor: "#4dabf5", width: 10},
            //{ from: "Germplasm", to: "Goal 4", value: 20 }
        ];

        let hoverState = chart.links.template.states.create("hover");
        hoverState.properties.fillOpacity = 0.6;

        chart.dataFields.fromName = "from";
        chart.dataFields.toName = "to";
        chart.dataFields.value = "value";
        chart.dataFields.color = "nodeColor";

        chart.paddingRight = 120;

        var nodeTemplate = chart.nodes.template;
        nodeTemplate.inert = true;
        nodeTemplate.readerTitle = "Drag me!";
        nodeTemplate.showSystemTooltip = true;
        nodeTemplate.width = 20;

        nodeTemplate.propertyFields.width = "width";

        var nodeTemplate = chart.nodes.template;
        nodeTemplate.readerTitle = "Click to show/hide or drag to rearrange";
        nodeTemplate.showSystemTooltip = true;
        nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer

        chart.exporting.menu = new am4core.ExportMenu();
         chart.exporting.filePrefix = "measure_download";

    });


    // Graph - 6
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("program_wise_graph_six", am4charts.SankeyDiagram);
        chart.hiddenState.properties.opacity = 0;
        chart.logo.disabled = 'true'

        chart.data = [
            { from: "Tanzania-Common bean", to: "Nutrition", value: 20, nodeColor: "#d79494", width: 10 },
            { from: "Tanzania-Common bean", to: "Abiotic stress tolerance", value: 20, nodeColor: "#82cee4", width: 10 },
            { from: "Tanzania-Common bean", to: "Biotic stress tolerance", value: 7, nodeColor: "#843ff4", width: 10 },
            { from: "Tanzania-Common bean", to: "Grain Yield", value: 7, nodeColor: "#f98988", width: 10 },
            { from: "Nigeria-Cowpea", to: "Early Maturity", value: 17, nodeColor: "#45b4c6", width: 10 },
            { from: "WCA-Cowpea", to: "Abiotic stress tolerance", value: 25, nodeColor: "#f9d533", width: 10},
            { from: "WCA-Cowpea", to: "Biotic stress tolerance", value: 4, nodeColor: "#ec64a3", width: 10 },
            { from: "WCA-Cowpea", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Pearl millet", to: "Other", value: 18, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Grain", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Other", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Biotic stress tolerance", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Uganda-Sorghum", to: "Early Maturity", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Abiotic stress tolerance", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Culinary", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10},
            { from: "Burkina Faso-Sorghum", to: "Biotic stress tolerance", value: 8, nodeColor: "#4dabf5", width: 10},
            //{ from: "Germplasm", to: "Goal 4", value: 20 }
        ];

        let hoverState = chart.links.template.states.create("hover");
        hoverState.properties.fillOpacity = 0.6;

        chart.dataFields.fromName = "from";
        chart.dataFields.toName = "to";
        chart.dataFields.value = "value";
        chart.dataFields.color = "nodeColor";

        chart.paddingRight = 120;

        var nodeTemplate = chart.nodes.template;
        nodeTemplate.inert = true;
        nodeTemplate.readerTitle = "Drag me!";
        nodeTemplate.showSystemTooltip = true;
        nodeTemplate.width = 20;

        nodeTemplate.propertyFields.width = "width";

        var nodeTemplate = chart.nodes.template;
        nodeTemplate.readerTitle = "Click to show/hide or drag to rearrange";
        nodeTemplate.showSystemTooltip = true;
        nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer
        chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.filePrefix = "measure_download";

    });


//Graph -7
     am4core.ready(function() {
        // Apply chart themes
        am4core.useTheme(am4themes_animated);

        // Create chart instance
        var chart = am4core.create("program_varietyreleased", am4charts.XYChart);
        chart.logo.disabled = 'true'

        chart.marginRight = 400;

        // Add data
        chart.data = [{"program":"Ethiopia - Common bean","hybridvarieties":0,"opvvarieties":0,"spvvarieties":4},{"program":"Tanzania - Finger millet","hybridvarieties":0,"opvvarieties":1,"spvvarieties":0}];

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "program";
        categoryAxis.title.text = "Countries";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 20;

        var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Varieties released";
        valueAxis.title.fontWeight = 800;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "hybridvarieties";
        series.dataFields.categoryX = "program";
        series.name = "Hybrid varieties";
        series.tooltipText = "{name}: [bold]{valueY}[/]";
        series.stacked = true;

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.valueY = "opvvarieties";
        series2.dataFields.categoryX = "program";
        series2.name = "OPV varieties";
        series2.tooltipText = "{name}: [bold]{valueY}[/]";
        series2.stacked = true;

        var series3 = chart.series.push(new am4charts.ColumnSeries());
        series3.dataFields.valueY = "spvvarieties";
        series3.dataFields.categoryX = "program";
        series3.name = "SPV varieties";
        series3.tooltipText = "{name}: [bold]{valueY}[/]";
        series3.stacked = true;

        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";
    }); // end am4core.ready()


     //Graph-8

      am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create('programwise_onstation_onfarm_yield', am4charts.XYChart)
        chart.colors.step = 2;
        chart.logo.disabled = 'true'

        chart.legend = new am4charts.Legend()
        chart.legend.position = 'top'
        chart.legend.paddingBottom = 20
        chart.legend.labels.template.maxWidth = 95

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
        xAxis.dataFields.category = 'program'
        xAxis.renderer.cellStartLocation = 0.1
        xAxis.renderer.cellEndLocation = 0.9
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.min = 0;
        yAxis.title.text = "Yield (kg/ ha)";
        yAxis.title.fontWeight = 800;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries())
            series.dataFields.valueY = value
            series.dataFields.categoryX = 'program'
            series.name = name

            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet())
            bullet.interactionsEnabled = false
            bullet.dy = -5;
            bullet.label.text = '{valueY}'
            bullet.label.fontSize = 10;
            bullet.label.truncate = false;
            bullet.label.hideOversized = false;
            //bullet.label.fill = am4core.color('#ffffff')

            return series;
        }

        chart.data = [{"program":"Ethiopia - Common bean","onstation_yield":"9210","onfarm_yield":"7657"},{"program":"Tanzania - Finger millet","onstation_yield":"5900","onfarm_yield":"4500"}];

        createSeries('onstation_yield', 'On-station yield');
        createSeries('onfarm_yield', 'On-farm yield');

        function arrangeColumns() {

            var series = chart.series.getIndex(0);

            var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
            if (series.dataItems.length > 1) {
                var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                var delta = ((x1 - x0) / chart.series.length) * w;
                if (am4core.isNumber(delta)) {
                    var middle = chart.series.length / 2;

                    var newIndex = 0;
                    chart.series.each(function(series) {
                        if (!series.isHidden && !series.isHiding) {
                            series.dummyData = newIndex;
                            newIndex++;
                        }
                        else {
                            series.dummyData = chart.series.indexOf(series);
                        }
                    })
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function(series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;

                        var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                        series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                        series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                    })
                }
            }
        }

        chart.cursor = new am4charts.XYCursor();
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";
    }); 


    // Graph - 9
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("program_traits_hybrid_opv_spv", am4charts.SankeyDiagram);
        chart.hiddenState.properties.opacity = 0;
        chart.logo.disabled = 'true'

        chart.data = [
            { from: "Ethiopia - Common bean", to: "Nutrition", value: 20, nodeColor: "#d79494", width: 10 },
            { from: "Ethiopia - Common bean", to: "Abiotic stress tolerance", value: 20, nodeColor: "#82cee4", width: 10 },
            { from: "Ethiopia - Common bean", to: "Biotic stress tolerance", value: 7, nodeColor: "#843ff4", width: 10 },
            { from: "Ethiopia - Common bean", to: "Grain Yield", value: 7, nodeColor: "#f98988", width: 10 },
            { from: "Ethiopia - Common bean", to: "Other", value: 17, nodeColor: "#45b4c6", width: 10 },
            { from: "Tanzania - Finger millet", to: "Abiotic stress tolerance", value: 25, nodeColor: "#f9d533", width: 10},
            { from: "Tanzania - Finger millet", to: "Biotic stress tolerance", value: 4, nodeColor: "#ec64a3", width: 10 },
            { from: "Tanzania - Finger millet", to: "Grain Yield", value: 8, nodeColor: "#4dabf5", width: 10}
        ];

        let hoverState = chart.links.template.states.create("hover");
        hoverState.properties.fillOpacity = 0.6;

        chart.dataFields.fromName = "from";
        chart.dataFields.toName = "to";
        chart.dataFields.value = "value";
        chart.dataFields.color = "nodeColor";

        chart.paddingRight = 120;

        var nodeTemplate = chart.nodes.template;
        nodeTemplate.inert = true;
        nodeTemplate.readerTitle = "Drag me!";
        nodeTemplate.showSystemTooltip = true;
        nodeTemplate.width = 20;

        nodeTemplate.propertyFields.width = "width";

        var nodeTemplate = chart.nodes.template;
        nodeTemplate.readerTitle = "Click to show/hide or drag to rearrange";
        nodeTemplate.showSystemTooltip = true;
        nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer
        chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.filePrefix = "measure_download";

    });  


    //po2 -- graph-1

    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("programwise_bmsinfo", am4charts.XYChart);

        // Add percent sign to all numbers
        chart.numberFormatter.numberFormat = "#.#";
        chart.logo.disabled='true'

        // Add data
        chart.data = [
        {"program":"Uganda - Common bean","total":"7","uploaded_bms":"5","barcode":"3","hh_device":"5"},
        {"program":"Tanzania - Common bean","total":"12","uploaded_bms":"0","barcode":"3","hh_device":"5"},
        {"program":"Ethiopia - Common bean","total":"20","uploaded_bms":"20","barcode":"3","hh_device":"5"},
        {"program":"ESA - Common bean","total":"30","uploaded_bms":"30","barcode":"3","hh_device":"5"},
        {"program":"Mali - Cowpea","total":"13","uploaded_bms":"13","barcode":"3","hh_device":"5"},
        {"program":"Nigeria - Cowpea","total":"12","uploaded_bms":"6","barcode":"3","hh_device":"5"},
        {"program":"Tanzania - Finger millet","total":"4","uploaded_bms":"0","barcode":"3","hh_device":"5"},
        {"program":"Ethiopia - Finger millet","total":"2","uploaded_bms":"2","barcode":"3","hh_device":"5"},
        {"program":"Uganda - Finger millet","total":"3","uploaded_bms":"0","barcode":"3","hh_device":"5"},
        {"program":"Tanzania - Groundnut","total":"6","uploaded_bms":"4","barcode":"3","hh_device":"5"},
        {"program":"Uganda - Groundnut","total":"22","uploaded_bms":"22","barcode":"3","hh_device":"5"},
        {"program":"ESA - Groundnut","total":"12","uploaded_bms":"12","barcode":"3","hh_device":"5"},
        {"program":"Ghana - Groundnut","total":"5","uploaded_bms":"5","barcode":"3","hh_device":"5"},
        {"program":"Nigeria - Groundnut","total":"10","uploaded_bms":"6","barcode":"3","hh_device":"5"},
        {"program":"WCA - Pearl millet","total":"13","uploaded_bms":"13","barcode":"7","hh_device":"5"},
        {"program":"Nigeria - Pearl millet","total":"16","uploaded_bms":"8","barcode":"5","hh_device":"9"},
        {"program":"Ethiopia - Sorghum","total":"4","uploaded_bms":"4","barcode":"15","hh_device":"10"},
        {"program":"ICRISAT-Mali - Sorghum","total":"15","uploaded_bms":"15","barcode":"10","hh_device":"11"},
        {"program":"Nigeria - Sorghum","total":"44","uploaded_bms":"30","barcode":"8","hh_device":"12"},
        {"program":"Uganda - Sorghum","total":"2","uploaded_bms":"1","barcode":"9","hh_device":"13"},
        {"program":"Tanzania - Sorghum","total":"15","uploaded_bms":"2","barcode":"13","hh_device":"15"}
        ];

        chart.legend = new am4charts.Legend();

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "program";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.horizontalCenter = "middle";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Number of nurseries";
        valueAxis.title.fontWeight = 800;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "total";
        series.dataFields.categoryX = "program";
        series.clustered = false;
        series.name = "Total nurseries established";
        series.tooltipText = "Total number of nurseries established: [bold]{valueY}[/]";
        series.columns.template.fill = am4core.color("#e600e6"); // fill

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.valueY = "uploaded_bms";
        series2.dataFields.categoryX = "program";
        series2.clustered = false;
        series2.name = "Nurseries uploaded in BMS";
        series2.columns.template.width = am4core.percent(50);
        series2.tooltipText = "Number of nurseries uploaded in BMS: [bold]{valueY}[/]";
        series2.columns.template.fill = am4core.color("#4b56cc"); // fill

        // var series3 = chart.series.push(new am4charts.ColumnSeries());
        // series3.dataFields.valueY = "barcode";
        // series3.dataFields.categoryX = "program";
        // series3.clustered = false;
        // series3.name = "Nurseries with barcode";
        // series3.columns.template.width = am4core.percent(50);
        // series3.tooltipText = "Nurseries with barcode: [bold]{valueY}[/]";
        // series3.columns.template.fill = am4core.color("#4b56cc");

        // var series4 = chart.series.push(new am4charts.ColumnSeries());
        // series4.dataFields.valueY = "hh_device";
        // series4.dataFields.categoryX = "program";
        // series4.clustered = false;
        // series4.name = "Nurseries with data collected through HH devices or tablets";
        // series4.columns.template.width = am4core.percent(50);
        // series4.tooltipText = "Nurseries with data collected through HH devices or tablets: [bold]{valueY}[/]";
        // series4.columns.template.fill = am4core.color("#4b56cc");

        chart.cursor = new am4charts.XYCursor();
        /*chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;*/
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";
    }); // end am4core.ready()

  am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("programwise_greenhouse", am4charts.XYChart);

        // Add percent sign to all numbers
        chart.numberFormatter.numberFormat = "#.#";
        chart.logo.disabled='true'

        // Add data
        chart.data = [
        {"program":"Uganda - Common bean","total":"7","uploaded_bms":"5","barcode":"3","hh_device":"5"},
        {"program":"Tanzania - Common bean","total":"12","uploaded_bms":"0","barcode":"3","hh_device":"5"},
        {"program":"Ethiopia - Common bean","total":"20","uploaded_bms":"20","barcode":"3","hh_device":"5"},
        {"program":"ESA - Common bean","total":"30","uploaded_bms":"30","barcode":"3","hh_device":"5"},
        {"program":"Mali - Cowpea","total":"13","uploaded_bms":"13","barcode":"3","hh_device":"5"},
        {"program":"Nigeria - Cowpea","total":"12","uploaded_bms":"6","barcode":"3","hh_device":"5"},
        {"program":"Tanzania - Finger millet","total":"4","uploaded_bms":"0","barcode":"3","hh_device":"5"},
        {"program":"Ethiopia - Finger millet","total":"2","uploaded_bms":"2","barcode":"3","hh_device":"5"},
        {"program":"Uganda - Finger millet","total":"3","uploaded_bms":"0","barcode":"3","hh_device":"5"},
        {"program":"Tanzania - Groundnut","total":"6","uploaded_bms":"4","barcode":"3","hh_device":"5"},
        {"program":"Uganda - Groundnut","total":"22","uploaded_bms":"22","barcode":"3","hh_device":"5"},
        {"program":"ESA - Groundnut","total":"12","uploaded_bms":"12","barcode":"3","hh_device":"5"},
        {"program":"Ghana - Groundnut","total":"5","uploaded_bms":"5","barcode":"3","hh_device":"5"},
        {"program":"Nigeria - Groundnut","total":"10","uploaded_bms":"6","barcode":"3","hh_device":"5"},
        {"program":"WCA - Pearl millet","total":"13","uploaded_bms":"13","barcode":"7","hh_device":"5"},
        {"program":"Nigeria - Pearl millet","total":"16","uploaded_bms":"8","barcode":"5","hh_device":"9"},
        {"program":"Ethiopia - Sorghum","total":"4","uploaded_bms":"4","barcode":"15","hh_device":"10"},
        {"program":"ICRISAT-Mali - Sorghum","total":"15","uploaded_bms":"15","barcode":"10","hh_device":"11"},
        {"program":"Nigeria - Sorghum","total":"44","uploaded_bms":"30","barcode":"8","hh_device":"12"},
        {"program":"Uganda - Sorghum","total":"2","uploaded_bms":"1","barcode":"9","hh_device":"13"},
        {"program":"Tanzania - Sorghum","total":"15","uploaded_bms":"2","barcode":"13","hh_device":"15"}
        ];

        chart.legend = new am4charts.Legend();

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "program";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.horizontalCenter = "middle";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Number of nurseries";
        valueAxis.title.fontWeight = 800;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "total";
        series.dataFields.categoryX = "program";
        series.clustered = false;
        series.name = "Total nurseries established";
        series.tooltipText = "Total number of nurseries established: [bold]{valueY}[/]";
        series.columns.template.fill = am4core.color("#e600e6"); // fill

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.valueY = "uploaded_bms";
        series2.dataFields.categoryX = "program";
        series2.clustered = false;
        series2.name = "Nurseries uploaded in BMS";
        series2.columns.template.width = am4core.percent(50);
        series2.tooltipText = "Number of nurseries uploaded in BMS: [bold]{valueY}[/]";
        series2.columns.template.fill = am4core.color("#4b56cc"); // fill

        // var series3 = chart.series.push(new am4charts.ColumnSeries());
        // series3.dataFields.valueY = "barcode";
        // series3.dataFields.categoryX = "program";
        // series3.clustered = false;
        // series3.name = "Nurseries with barcode";
        // series3.columns.template.width = am4core.percent(50);
        // series3.tooltipText = "Nurseries with barcode: [bold]{valueY}[/]";
        // series3.columns.template.fill = am4core.color("#4b56cc");

        // var series4 = chart.series.push(new am4charts.ColumnSeries());
        // series4.dataFields.valueY = "hh_device";
        // series4.dataFields.categoryX = "program";
        // series4.clustered = false;
        // series4.name = "Nurseries with data collected through HH devices or tablets";
        // series4.columns.template.width = am4core.percent(50);
        // series4.tooltipText = "Nurseries with data collected through HH devices or tablets: [bold]{valueY}[/]";
        // series4.columns.template.fill = am4core.color("#4b56cc");

        chart.cursor = new am4charts.XYCursor();
        /*chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;*/
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";
    }); // end am4core.ready()



 am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("programwise_trials", am4charts.XYChart);

        // Add percent sign to all numbers
        chart.numberFormatter.numberFormat = "#.#";
        chart.logo.disabled ='true'

        // Add data
        chart.data = [{"program":"Uganda - Common bean","total":"7","uploaded_bms":"5"},{"program":"Tanzania - Common bean","total":"12","uploaded_bms":"0"},{"program":"Ethiopia - Common bean","total":"20","uploaded_bms":"20"},{"program":"ESA - Common bean","total":"30","uploaded_bms":"30"},{"program":"Mali - Cowpea","total":"13","uploaded_bms":"13"},{"program":"Nigeria - Cowpea","total":"12","uploaded_bms":"6"},{"program":"Tanzania - Finger millet","total":"4","uploaded_bms":"0"},{"program":"Ethiopia - Finger millet","total":"2","uploaded_bms":"2"},{"program":"Uganda - Finger millet","total":"3","uploaded_bms":"0"},{"program":"Tanzania - Groundnut","total":"6","uploaded_bms":"4"},{"program":"Uganda - Groundnut","total":"22","uploaded_bms":"22"},{"program":"ESA - Groundnut","total":"12","uploaded_bms":"12"},{"program":"Ghana - Groundnut","total":"5","uploaded_bms":"5"},{"program":"Nigeria - Groundnut","total":"10","uploaded_bms":"6"},{"program":"WCA - Pearl millet","total":"13","uploaded_bms":"13"},{"program":"Nigeria - Pearl millet","total":"16","uploaded_bms":"8"},{"program":"Ethiopia - Sorghum","total":"4","uploaded_bms":"4"},{"program":"ICRISAT-Mali - Sorghum","total":"15","uploaded_bms":"15"},{"program":"Nigeria - Sorghum","total":"44","uploaded_bms":"30"},{"program":"Uganda - Sorghum","total":"2","uploaded_bms":"1"},{"program":"Tanzania - Sorghum","total":"15","uploaded_bms":"2"}];

        chart.legend = new am4charts.Legend();

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "program";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.horizontalCenter = "right";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Number of trials";
        valueAxis.title.fontWeight = 800;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "total";
        series.dataFields.categoryX = "program";
        series.clustered = false;
        series.name = "Total number of trials established";
        series.tooltipText = "Total number of trials established: [bold]{valueY}[/]";
        series.columns.template.fill = am4core.color("#e600e6"); // fill

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.valueY = "uploaded_bms";
        series2.dataFields.categoryX = "program";
        series2.clustered = false;
        series2.name = "Number of trials uploaded in BMS";
        series2.columns.template.width = am4core.percent(50);
        series2.tooltipText = "Number of trials uploaded in BMS: [bold]{valueY}[/]";
        series2.columns.template.fill = am4core.color("#4b56cc"); // fill

        chart.cursor = new am4charts.XYCursor();
        /*chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;*/
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";
    }); // end am4core.ready()


 am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("programwise_trials_greenhouse", am4charts.XYChart);

        // Add percent sign to all numbers
        chart.numberFormatter.numberFormat = "#.#";
        chart.logo.disabled ='true'

        // Add data
        chart.data = [{"program":"Uganda - Common bean","total":"7","uploaded_bms":"5"},{"program":"Tanzania - Common bean","total":"12","uploaded_bms":"0"},{"program":"Ethiopia - Common bean","total":"20","uploaded_bms":"20"},{"program":"ESA - Common bean","total":"30","uploaded_bms":"30"},{"program":"Mali - Cowpea","total":"13","uploaded_bms":"13"},{"program":"Nigeria - Cowpea","total":"12","uploaded_bms":"6"},{"program":"Tanzania - Finger millet","total":"4","uploaded_bms":"0"},{"program":"Ethiopia - Finger millet","total":"2","uploaded_bms":"2"},{"program":"Uganda - Finger millet","total":"3","uploaded_bms":"0"},{"program":"Tanzania - Groundnut","total":"6","uploaded_bms":"4"},{"program":"Uganda - Groundnut","total":"22","uploaded_bms":"22"},{"program":"ESA - Groundnut","total":"12","uploaded_bms":"12"},{"program":"Ghana - Groundnut","total":"5","uploaded_bms":"5"},{"program":"Nigeria - Groundnut","total":"10","uploaded_bms":"6"},{"program":"WCA - Pearl millet","total":"13","uploaded_bms":"13"},{"program":"Nigeria - Pearl millet","total":"16","uploaded_bms":"8"},{"program":"Ethiopia - Sorghum","total":"4","uploaded_bms":"4"},{"program":"ICRISAT-Mali - Sorghum","total":"15","uploaded_bms":"15"},{"program":"Nigeria - Sorghum","total":"44","uploaded_bms":"30"},{"program":"Uganda - Sorghum","total":"2","uploaded_bms":"1"},{"program":"Tanzania - Sorghum","total":"15","uploaded_bms":"2"}];

        chart.legend = new am4charts.Legend();

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "program";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.horizontalCenter = "right";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Number of trials";
        valueAxis.title.fontWeight = 800;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "total";
        series.dataFields.categoryX = "program";
        series.clustered = false;
        series.name = "Total number of trials established";
        series.tooltipText = "Total number of trials established: [bold]{valueY}[/]";
        series.columns.template.fill = am4core.color("#e600e6"); // fill

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.valueY = "uploaded_bms";
        series2.dataFields.categoryX = "program";
        series2.clustered = false;
        series2.name = "Number of trials uploaded in BMS";
        series2.columns.template.width = am4core.percent(50);
        series2.tooltipText = "Number of trials uploaded in BMS: [bold]{valueY}[/]";
        series2.columns.template.fill = am4core.color("#4b56cc"); // fill

        chart.cursor = new am4charts.XYCursor();
        /*chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;*/
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";
    }); // end am4core.ready()

    // am4core.ready(function() {
    //     // Themes begin
    //     am4core.useTheme(am4themes_animated);
    //     // Themes end

    //     var chart = am4core.create('programwise_bmsinfo1', am4charts.XYChart)
    //     chart.colors.step = 2;
    //     chart.logo.disabled = 'true'

    //     chart.legend = new am4charts.Legend()
    //     chart.legend.position = 'top'
    //     chart.legend.paddingBottom = 20
    //     chart.legend.labels.template.maxWidth = 95


    //     var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
    //     xAxis.dataFields.category = 'program'
    //     xAxis.renderer.cellStartLocation = 0.1
    //     xAxis.renderer.cellEndLocation = 0.9
    //     xAxis.renderer.grid.template.location = 0;
    //      xAxis.renderer.labels.template.horizontalCenter = "middle";
    //     xAxis.renderer.labels.template.verticalCenter = "middle";
    //     xAxis.renderer.labels.template.rotation = 270;

    //     var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //     yAxis.min = 0;
    //     yAxis.title.text = "Yield (kg/ ha)";
    //     yAxis.title.fontWeight = 800;

    //     function createSeries(value, name) {
    //         var series = chart.series.push(new am4charts.ColumnSeries())
    //         series.dataFields.valueY = value
    //         series.dataFields.categoryX = 'program'
    //         series.name = name

    //         series.events.on("hidden", arrangeColumns);
    //         series.events.on("shown", arrangeColumns);

    //         var bullet = series.bullets.push(new am4charts.LabelBullet())
    //         bullet.interactionsEnabled = false
    //         bullet.dy = -5;
    //         bullet.label.text = '{valueY}'
    //         bullet.label.fontSize = 10;
    //         bullet.label.truncate = false;
    //         bullet.label.hideOversized = false;
    //         //bullet.label.fill = am4core.color('#ffffff')

    //         return series;
    //     }

    //     chart.data = [
    //     // {"program":"Ethiopia - Common bean","onstation_yield":"9210","onfarm_yield":"7657"},
    //     // {"program":"Tanzania - Finger millet","onstation_yield":"5900","onfarm_yield":"4500"}

    //     {"program":"Uganda - Common bean","total":"7","uploaded_bms":"5", "barcode":"3","hh_device":"5"},
    //     {"program":"Tanzania - Common bean","total":"12","uploaded_bms":"0", "barcode":"3","hh_device":"5"},
    //     {"program":"Ethiopia - Common bean","total":"20","uploaded_bms":"20", "barcode":"3","hh_device":"5"},
    //     {"program":"ESA - Common bean","total":"30","uploaded_bms":"30", "barcode":"3","hh_device":"5"},
    //     {"program":"Mali - Cowpea","total":"13","uploaded_bms":"13", "barcode":"3","hh_device":"5"},
    //     {"program":"Nigeria - Cowpea","total":"12","uploaded_bms":"6", "barcode":"3","hh_device":"5"},
    //     {"program":"Tanzania - Finger millet","total":"4","uploaded_bms":"0", "barcode":"3","hh_device":"5"},
    //     {"program":"Ethiopia - Finger millet","total":"2","uploaded_bms":"2", "barcode":"3","hh_device":"5"},
    //     {"program":"Uganda - Finger millet","total":"3","uploaded_bms":"0", "barcode":"3","hh_device":"5"},
    //     {"program":"Tanzania - Groundnut","total":"6","uploaded_bms":"4", "barcode":"3","hh_device":"5"},
    //      {"program":"ESA - Groundnut","total":"12","uploaded_bms":"12","barcode":"3","hh_device":"5"},
    //     {"program":"Ghana - Groundnut","total":"5","uploaded_bms":"5","barcode":"3","hh_device":"5"},
    //     {"program":"Nigeria - Groundnut","total":"10","uploaded_bms":"6","barcode":"3","hh_device":"5"},
    //     {"program":"WCA - Pearl millet","total":"13","uploaded_bms":"13","barcode":"7","hh_device":"5"},
    //     {"program":"Nigeria - Pearl millet","total":"16","uploaded_bms":"8","barcode":"5","hh_device":"9"},
    //     {"program":"Ethiopia - Sorghum","total":"4","uploaded_bms":"4","barcode":"15","hh_device":"10"},
    //     {"program":"ICRISAT-Mali - Sorghum","total":"15","uploaded_bms":"15","barcode":"10","hh_device":"11"},
    //     {"program":"Nigeria - Sorghum","total":"44","uploaded_bms":"30","barcode":"8","hh_device":"12"},
        
    //     ];

    //     createSeries('total', 'Total nurseries established');
    //     createSeries('uploaded_bms', 'Nurseries uploaded in BMS');
    //     // createSeries('barcode', 'Nurseries with barcode');
    //     // createSeries('hh_device', 'Nurseries with data collected through HH devices or tablets');

    //     function arrangeColumns() {

    //         var series = chart.series.getIndex(0);

    //         var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    //         if (series.dataItems.length > 1) {
    //             var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
    //             var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
    //             var delta = ((x1 - x0) / chart.series.length) * w;
    //             if (am4core.isNumber(delta)) {
    //                 var middle = chart.series.length / 2;

    //                 var newIndex = 0;
    //                 chart.series.each(function(series) {
    //                     if (!series.isHidden && !series.isHiding) {
    //                         series.dummyData = newIndex;
    //                         newIndex++;
    //                     }
    //                     else {
    //                         series.dummyData = chart.series.indexOf(series);
    //                     }
    //                 })
    //                 var visibleCount = newIndex;
    //                 var newMiddle = visibleCount / 2;

    //                 chart.series.each(function(series) {
    //                     var trueIndex = chart.series.indexOf(series);
    //                     var newIndex = series.dummyData;

    //                     var dx = (newIndex - trueIndex + middle - newMiddle) * delta

    //                     series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
    //                     series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
    //                 })
    //             }
    //         }
    //     }

    //     chart.cursor = new am4charts.XYCursor();
    //     chart.exporting.menu = new am4core.ExportMenu();
    //     chart.exporting.filePrefix = "measure_download";
    // }); 



am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("programwise_sop_pyt", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();
chart.logo.disabled ='true'

// Add data
chart.data = [
{"program":"Ethiopia - Common bean","count":"40"},
{"program":"ESA - Common bean","count":"10"},
{"program":"Ghana - Cowpea","count":"100"},
{"program":"Mali - Cowpea","count":"100"},
{"program":"ESA - Groundnut","count":"95"},
{"program":"WCA - Pearl millet","count":"40"},
{"program":"Nigeria - Pearl millet","count":"60"},
{"program":"Uganda - Sorghum","count":"10"},
{"program":"Tanzania - Sorghum","count":"100"}
];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
// valueAxis.renderer.minWidth = 50;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;
yAxis.title.text = "Progress made (%)";
yAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
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

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";

}); // end am4core.ready()



am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("programwise_sop_ayt", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();
chart.logo.disabled ='true'

// Add data
chart.data = [
{"program":"Ethiopia - Common bean","count":"40"},
{"program":"ESA - Common bean","count":"10"},
{"program":"Ghana - Cowpea","count":"100"},
{"program":"Mali - Cowpea","count":"100"},
{"program":"ESA - Groundnut","count":"95"},
{"program":"WCA - Pearl millet","count":"40"},
{"program":"Nigeria - Pearl millet","count":"60"},
{"program":"Ethiopia - Sorghum","count":"80"},
{"program":"Uganda - Sorghum","count":"10"},
{"program":"Tanzania - Sorghum","count":"100"}
]

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
// valueAxis.renderer.minWidth = 50;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;
yAxis.title.text = "Progress made (%)";
yAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
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

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";

}); // end am4core.ready()



am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("programwise_sop_mlt", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();
chart.logo.disabled ='true'

// Add data
chart.data = [
{"program":"Ethiopia - Common bean","count":"40"},
{"program":"ESA - Common bean","count":"10"},
{"program":"Ghana - Cowpea","count":"100"},
{"program":"Mali - Cowpea","count":"100"},
{"program":"ESA - Groundnut","count":"95"},
{"program":"WCA - Pearl millet","count":"40"},
{"program":"Nigeria - Pearl millet","count":"60"},
{"program":"Ethiopia - Sorghum","count":"80"},
{"program":"Uganda - Sorghum","count":"10"},
{"program":"Tanzania - Sorghum","count":"100"}
]

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
// valueAxis.renderer.minWidth = 50;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;
yAxis.title.text = "Progress made (%)";
yAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
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

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";

}); // end am4core.ready()



am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("programwise_sop_pvs", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();
chart.logo.disabled ='true'

// Add data
chart.data = [
{"program":"Ethiopia - Common bean","count":"30"},
{"program":"Ghana - Cowpea","count":"100"},
{"program":"Mali - Cowpea","count":"100"},
{"program":"ESA - Groundnut","count":"95"},
{"program":"WCA - Pearl millet","count":"40"},
{"program":"Nigeria - Pearl millet","count":"80"},
{"program":"Uganda - Sorghum","count":"10"}
,{"program":"Tanzania - Sorghum","count":"100"}
]

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
// valueAxis.renderer.minWidth = 50;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;
yAxis.title.text = "Yield (kg/ ha)";
yAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
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

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";

}); // end am4core.ready()


am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("programwise_sop_nurseries", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();
chart.logo.disabled ='true'

// Add data
chart.data = [
{"program":"Ethiopia - Common bean","count":"40"},
{"program":"ESA - Common bean","count":"10"},
{"program":"Ghana - Cowpea","count":"100"},
{"program":"Mali - Cowpea","count":"100"},
{"program":"ESA - Groundnut","count":"95"},
{"program":"WCA - Pearl millet","count":"40"},
{"program":"Nigeria - Pearl millet","count":"70"},
{"program":"Ethiopia - Sorghum","count":"90"},
{"program":"Uganda - Sorghum","count":"10"},
{"program":"Tanzania - Sorghum","count":"100"}
]

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
// valueAxis.renderer.minWidth = 50;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;
yAxis.title.text = "Yield (kg/ ha)";
yAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
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

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";

}); // end am4core.ready()


am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("programwise_tpes", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();
chart.logo.disabled ='true'

// Add data
chart.data = [
{"program":"Ethiopia - Common bean","count":"3883"},
{"program":"Ghana - Cowpea","count":"18"},
{"program":"Mali - Cowpea","count":"29"},
{"program":"Nigeria - Cowpea","count":"44"},
{"program":"Burkina Faso - Cowpea","count":"3"},
{"program":"WCA - Cowpea","count":"12"},
{"program":"ESA - Finger millet","count":"270"},
{"program":"Tanzania - Finger millet","count":"400"},
{"program":"Ethiopia - Finger millet","count":"30"},
{"program":"Mali - Groundnut","count":"119"},
{"program":"WCA - Groundnut","count":"89"},
{"program":"WCA - Pearl millet","count":"166"},
{"program":"Mali - Pearl millet","count":"120"},
{"program":"Ethiopia - Sorghum","count":"52"},
{"program":"ICRISAT-Mali - Sorghum","count":"2"},
{"program":"Uganda - Sorghum","count":"20"},
{"program":"Burkina Faso - Sorghum","count":"65"},
{"program":"Mali - Sorghum","count":"78"},
{"program":"ESA - Sorghum","count":"179"}
]

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "program";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
// valueAxis.renderer.minWidth = 50;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;
yAxis.title.text = "Number of populations";
yAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "count";
series.dataFields.categoryX = "program";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
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

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();
chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "measure_download";

}); // end am4core.ready()

