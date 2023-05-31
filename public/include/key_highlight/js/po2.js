class PO2 {
  constructor() {
    this.map = null;
    this.map1 = null;
    // setTimeout(() => this.generateProgramwiseMap());
    this.onRcihClick();
    this.getFilterOptions();
    this.getPO2Data();
    this.getRcihWiseData();
    // setTimeout(() => this.staticCharts());
    $("#po2_filter").on("click", () => {
      this.getPO2Data();
      this.getRcihWiseData();
    });
    $("#dwn-csv-22").on("click", function () {
      $("#resultpo2").table2csv({
        file_name: "avisa-advocacy-tools.csv",
        header_body_space: 0,
      });
    });
  }

  onRcihClick() {
    $("#base-rcihs2").on("click", () => {

      if (!this.richdata) {
      }
    });
  }

  getRcihWiseData() {
    showLoader();
    const request = { "purpose": "PO2", "rcih": "po2rcih" };
    const countryData = $("#po2_country_list").val();
    if (countryData?.length) {
      request.country_id = countryData
    }
    post("dashboard", request).then(response => {
      this.richdata = response;
      // this.rcihwisenurseriesEstablishedFieldChart();
      // this.rcihwisenurseriesEstablishedGreenhouseChart();
      // this.rcihwisetrialsEstablishedFieldChart();
      // this.rcihwisetrialsEstablishedGreenhouseChart();
      // this.rcihwisesopPytDataChart();
      // this.rcihwisesopAytDataChart();
      // this.rcihwisesopMltDataChart();
      // this.rcihwisesopPvsDataChart();
      // this.rcihwisesopNurseriesDataChart();
      // this.rcihwiseweaiGreatDataChart();
      // this.rcihwiseadoptingStreamLinedChart();
    }).catch().finally(() => {
      setTimeout(() => hideLoader(), 1000);
    });
  }
  getFilterOptions() {
    showLoader();
    const request = { purpose: "FILTER" };
    post("dashboard", request)
      .then((response) => {
        // To do generate chart
        this.filterData = response;
        this.countryList();
        this.cropList();
      })
      .catch()
      .finally(() => {
        setTimeout(() => hideLoader(), 1000);
      });
  }
  countryList() {
    const country = this.filterData.country_list;
    $("#po2_country_list").multipleSelect('destroy');
    setTimeout(() => {
      const optionData = country.map(d => {
        return `<option value="${d.country_id}">${d.country_name}</option>`
      }).join('\n');
      $("#po2_country_list").html(optionData);
      $("#po2_country_list").multipleSelect();
    }
    )
  }
  cropList() {
    const crops = this.filterData.crops_list;
    $("#po2_crop_list").multipleSelect('destroy');
    setTimeout(() => {
      const optionData = crops.map(d => {
        return `<option value="${d.crop_id}">${d.crop_name}</option>`
      }).join('\n');
      $("#po2_crop_list").html(optionData);
      $("#po2_crop_list").multipleSelect();
    }
    )
  }

  generateProgramwiseMap() {
    this.map = L.map("po-2-programwise-map").setView([-11.202692, 17.873886], 3);
    L.tileLayer(
      "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw",
      {
        maxZoom: 18,
        attribution:
          'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: "mapbox/streets-v11",
      }
    ).addTo(this.map);

    let markers = L.markerClusterGroup();
    for (let i = 0; i < villages.length; i++) {
      let country = villages[i]["name"];
      let lat = villages[i]["lat"];
      let lng = villages[i]["lang"];
      let partners = villages[i]["partners"];
      let crops = villages[i]["Crops"];
      let marker = L.marker(new L.LatLng(lat, lng), {
        title: country,
        crops: crops,
        partners: partners,
      });
      const html = `
      <div class="row">
        <div class="col-sm-12">
          <span>${country}</span>
          <p> ${partners}</p>
          <p> ${crops}</p>
        </div>
      </div>
  `;

      markers.addLayer(marker);
      /* adding click event */
      marker.on("click", function (e) {
        let name = e.target.options;
        // var side_info = name + "Clicked.";
        // adding info into side bar
        $("#map_crops_p2").html(name.crops);
        $("#map_partners_p2").html(name.partners);
      });
    }
    this.map.addLayer(markers);
  }

  getPO2Data() {
    showLoader();
    const request = { "purpose": "PO2" };
    const countryData = $("#po2_country_list").val();
    if (countryData?.length) {
      request.country_id = countryData
    }
    const cropData = $("#po2_crop_list").val();
    if (cropData?.length) {
      request.crop_id = cropData
    }
    post('dashboard', request).then(response => {
      // To do generate chart
      this.poTwoData = response;
      //this.countryList();
      //this.cropList();
      this.nurseriesEstablishedFieldChart();
      // this.nurseriesEstablishedGreenhouseChart();
      // this.trialsEstablishedFieldChart();
      this.trialsEstablishedGreenhouseChart();
      this.sopPytDataChart();
      // this.sopAytDataChart();
      // this.sopMltDataChart();
      // this.sopPvsDataChart();
      // this.sopNurseriesDataChart();
      this.weaiGreatDataChart();
      this.adoptingStreamLinedChart();
      this.advocacyToolsChart();
      this.advocacyToolsTable();
      this.bmsChart();
      // $("#dus_hybrid").html(this.poOneData.dus_hybrid);
      let pyt = this.poTwoData.sop_pyt_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
      let ayt = this.poTwoData.sop_ayt_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
      let mlt = this.poTwoData.sop_mlt_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
      let pvs = this.poTwoData.sop_pvs_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
      let nurseries = this.poTwoData.sop_nurseries_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
      // $("#programwise_sop_count").html(pyt + ayt + mlt + pvs + nurseries);



    }).catch().finally(() => {
      setTimeout(() => hideLoader(), 1000);
    });
  }

  bmsChart() {
    // debugger
    $("#programwise_bms").html("");
    const bms_uploads = this.poTwoData.bms_uploads;
    let bms_uploads_counts = bms_uploads.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    //let values = (generationsachieved_counts / bms_uploads.length).toFixed(2);
    $("#programwise_bms_count").html(bms_uploads_counts);
    if (!bms_uploads?.length) {
      $("#programwise_bms").html(nodata_html());
      return;
    }
    const chartData = bms_uploads.filter(e => (e.count+e.target) != 0 );
    //Graph - 2
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("programwise_bms", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = chartData;
      // chart.legend = new am4charts.Legend();


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials in BMS";
      valueAxis.title.fontWeight = "bold";

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());

      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
      categoryAxis.renderer.labels.template.rotation = 270;
      categoryAxis.renderer.labels.template.horizontalCenter = "middle";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";

      
      // Configure axis label
      // var label = categoryAxis.renderer.labels.template;
      //label.truncate = true;
      //label.maxWidth = 120;
      // label.tooltipText = "{program_name}";

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      // series.name = "Actual Value"
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "count";
      series.dataFields.categoryX = "program_name";
      // series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      // series.tooltipText = "{program_name}: {valueY}";
      // series.tooltipLocation = 0;
      

      // series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      

      var lineSeries = chart.series.push(new am4charts.LineSeries());
      lineSeries.name = "Target Value";
      lineSeries.dataFields.valueY = "target";
      lineSeries.dataFields.categoryX = "program_name";
      //lineSeries.stroke = am4core.color("#B5461B");
      lineSeries.stroke = am4core.color("#882D17");
      lineSeries.strokeWidth = 3;
      lineSeries.propertyFields.strokeDasharray = "lineDash";
      lineSeries.tooltip.label.textAlign = "middle";

      var lineBullets = lineSeries.bullets.push(new am4charts.Bullet());
      lineBullets.fill = am4core.color("#882D17"); // tooltips grab fill from parent by default
      //lineBullets.fill = am4core.color("#6C4575"); // tooltips grab fill from parent by default
      //lineBullets.fill = am4core.color("#B5461B"); // tooltips grab fill from parent by default
      // lineBullets.tooltipText = "[#fff font-size: 12px]{name} in {categoryX}:\n[/][#fff font-size: 16px]{valueY}[/] [#fff]{additional}[/]"
      lineBullets.tooltipText = "{categoryX}\n{name}: {valueY}"
      var circle = lineBullets.createChild(am4core.Circle);
      circle.radius = 4;
      circle.fill = am4core.color("#fff");
      circle.strokeWidth = 3;

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -20;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "16px";
      bullet.label.fill = am4core.color("#000");

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });



      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }
  //Graph -1
  nurseriesEstablishedFieldChart() {
    $("#programwise_bmsinfo").html("");
    const nurseriesestablished_field = this.poTwoData.nurseriesestablished_field;
    const nurseriesestablished_greenhouse = this.poTwoData.nurseriesestablished_greenhouse;



    const totalData = [...nurseriesestablished_field, ...nurseriesestablished_greenhouse].filter(d => d.count)
    const programList = Array.from(new Set(totalData.map(d => d.program_name)));

    //console.log(totalData);


    const chartData = programList.map(e => {
      const result = { "program_name": e }
      const fieldData = nurseriesestablished_field.find(d => d.program_name == e)?.count;
      const greenhouseData = nurseriesestablished_greenhouse.find(d => d.program_name == e)?.count;
      if (fieldData) result["fieldData"] = fieldData;
      if (greenhouseData) result["greenhouseData"] = greenhouseData;
      result.none = 0;
      return result;
    })

    //console.log(chartData);

    if (!nurseriesestablished_field?.length) {
      $("#programwise_bmsinfo").html(nodata_html());
      return;
    }

    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_bmsinfo", am4charts.XYChart);
      chart.maskBullets = false;
      chart.numberFormatter.numberFormat = "#.#";
      chart.logo.disabled = "true";

      // Add data

      chart.data = chartData

      //console.log(chartData);


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.labels.template.rotation = 270;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "middlw";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      // valueAxis.renderer.inside = false;
      // valueAxis.renderer.labels.template.disabled = false;
      valueAxis.min = 0;
      valueAxis.extraMax = 0.2;
      valueAxis.calculateTotals = true;
      // valueAxis.title.text = "Number";
      valueAxis.title.text = "Number of nurseries";
      valueAxis.title.fontWeight = 800;
      valueAxis.calculateTotals = true;

      // var axisBreak = valueAxis.axisBreaks.create();
      // axisBreak.startValue = 200;
      // axisBreak.endValue = 2000;


      // Create series
      function createSeries(field, name) {

        // Set up series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.name = name;
        series.dataFields.valueY = field;
        series.dataFields.categoryX = "program_name";
        series.sequencedInterpolation = true;


        // Make it stacked
        series.stacked = true;

        // Configure columns
        series.columns.template.width = am4core.percent(60);
        series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

        // Add label
        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        // labelBullet.label.text = "{valueY}";
        labelBullet.label.fill = am4core.color("#fff");
        labelBullet.locationY = 0.5;

        return series;
      }

      createSeries("fieldData", "Nurseries established in field");
      createSeries("greenhouseData", "Nurseries established in greenhouse");

      var totalSeries = chart.series.push(new am4charts.ColumnSeries());
      totalSeries.dataFields.valueY = "none";
      totalSeries.dataFields.categoryX = "program_name";
      totalSeries.stacked = true;
      totalSeries.hiddenInLegend = true;
      totalSeries.columns.template.strokeOpacity = 0;

      var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
      totalBullet.dy = -20;
      totalBullet.label.text = "{valueY.total}";
      totalBullet.label.hideOversized = false;
      totalBullet.label.fontSize = 10;
      totalBullet.label.fontWeight = 400;
      totalBullet.label.truncate = false;
      totalBullet.label.background.fill = totalSeries.stroke;
      totalBullet.label.background.fillOpacity = 0.2;
      totalBullet.label.padding(10, 10, 5, 10);


      // Legend
      chart.legend = new am4charts.Legend();
      chart.scrollbarX = new am4core.Scrollbar();
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";

    }
    )
  }
  //Graph -2
  nurseriesEstablishedGreenhouseChart() {
    $("#programwise_greenhouse").html("");
    const nurseriesestablished_greenhouse = this.poTwoData.nurseriesestablished_greenhouse
    if (!nurseriesestablished_greenhouse?.length) {
      $("#programwise_greenhouse").html(nodata_html());
      return;
    }




    // am4core.ready(function () {
    //   // Apply chart themes
    //   am4core.useTheme(am4themes_animated);

    //   // Create chart instance
    //   var chart = am4core.create("programwise_greenhouse", am4charts.XYChart);
    //   chart.logo.disabled = "true";

    //   chart.marginRight = 400;

    //   // Add data
    //   chart.data = nurseriesestablished_greenhouse


    //   // Create axes
    //   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //   categoryAxis.dataFields.category = "programname";
    //   // categoryAxis.title.text = "Countries";
    //   categoryAxis.renderer.grid.template.location = 0;
    //   categoryAxis.renderer.minGridDistance = 30;
    //   categoryAxis.renderer.labels.template.horizontalCenter = "right";
    //   categoryAxis.renderer.labels.template.verticalCenter = "middle";
    //   categoryAxis.renderer.labels.template.rotation = 270;

    //   var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //   valueAxis.title.text = "Number of Nurseries";
    //   valueAxis.title.fontWeight = 800;

    //   // Create series
    //   var series = chart.series.push(new am4charts.ColumnSeries());
    //   series.dataFields.valueY = "nsg_total_nurseriestotal";
    //   series.dataFields.categoryX = "programname";
    //   series.name = "Total nurseries established";
    //   series.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series.stacked = true;

    //   var series2 = chart.series.push(new am4charts.ColumnSeries());
    //   series2.dataFields.valueY = "nsg_total_nurserieswithbms";
    //   series2.dataFields.categoryX = "programname";
    //   series2.name = "Nurseries uploaded in BMS";
    //   series2.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series2.stacked = true;

    //   var series3 = chart.series.push(new am4charts.ColumnSeries());
    //   series3.dataFields.valueY = "nsg_total_nurserieswithbarcode";
    //   series3.dataFields.categoryX = "programname";
    //   series3.name = "Nurseries with barcode";
    //   series3.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series3.stacked = true;

    //   var series4 = chart.series.push(new am4charts.ColumnSeries());
    //   series4.dataFields.valueY = "nsg_total_nurseriesdatacollected";
    //   series4.dataFields.categoryX = "programname";
    //   series4.name =
    //     "Nurseries with data collected through HH devices or tablets";
    //   series4.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series4.stacked = true;

    //   chart.legend = new am4charts.Legend();

    //   // Add cursor
    //   chart.cursor = new am4charts.XYCursor();
    //   chart.exporting.menu = new am4core.ExportMenu();
    //   chart.exporting.filePrefix = "avisa";
    // }); // end am4core.ready()

    const chartData = nurseriesestablished_greenhouse.map(d => {
      const result = { programname: d.programname };
      result['total'] = Object.keys(d).filter(e => e != 'programname').map(e => d[e] || 0).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });
    //console.log(chartData);

    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_greenhouse", am4charts.XYChart);
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = chartData


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
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
      yAxis.title.text = "Number of Nurseries";
      yAxis.title.fontWeight = 800;


      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "total";
      series.dataFields.categoryX = "programname";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.scrollbarX = new am4core.Scrollbar();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
  //Graph -3
  trialsEstablishedFieldChart() {
    $("#programwise_trials").html("");
    const trialsestablished_field = this.poTwoData.trialsestablished_field
    if (!trialsestablished_field?.length) {
      $("#programwise_trials").html(nodata_html());
      return;
    }

    // am4core.ready(function () {
    //   // Apply chart themes
    //   am4core.useTheme(am4themes_animated);

    //   // Create chart instance
    //   var chart = am4core.create("programwise_trials", am4charts.XYChart);
    //   chart.logo.disabled = "true";

    //   chart.marginRight = 400;

    //   // Add data
    //   chart.data = trialsestablished_field

    //   // Create axes
    //   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //   categoryAxis.dataFields.category = "programname";
    //   // categoryAxis.title.text = "Countries";
    //   categoryAxis.renderer.grid.template.location = 0;
    //   categoryAxis.renderer.minGridDistance = 30;
    //   categoryAxis.renderer.labels.template.horizontalCenter = "right";
    //   categoryAxis.renderer.labels.template.verticalCenter = "middle";
    //   categoryAxis.renderer.labels.template.rotation = 270;

    //   var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //   valueAxis.title.text = "Number of Trials";
    //   valueAxis.title.fontWeight = 800;

    //   // Create series
    //   var series = chart.series.push(new am4charts.ColumnSeries());
    //   series.dataFields.valueY = "tef_totaltrais";
    //   series.dataFields.categoryX = "programname";
    //   series.name = "Total Trials established";
    //   series.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series.stacked = true;

    //   var series2 = chart.series.push(new am4charts.ColumnSeries());
    //   series2.dataFields.valueY = "tef_bmsupload";
    //   series2.dataFields.categoryX = "programname";
    //   series2.name = "Trials uploaded in BMS";
    //   series2.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series2.stacked = true;

    //   var series3 = chart.series.push(new am4charts.ColumnSeries());
    //   series3.dataFields.valueY = "barcode";
    //   series3.dataFields.categoryX = "programname";
    //   series3.name = "Trials with barcode";
    //   series3.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series3.stacked = true;

    //   var series4 = chart.series.push(new am4charts.ColumnSeries());
    //   series4.dataFields.valueY = "hh_device";
    //   series4.dataFields.categoryX = "programname";
    //   series4.name = "Trials with data collected through HH devices or tablets";
    //   series4.tooltipText = "{name}: [bold]{valueY}[/]";
    //   series4.stacked = true;

    //   chart.legend = new am4charts.Legend();

    //   // Add cursor
    //   chart.cursor = new am4charts.XYCursor();
    //   chart.exporting.menu = new am4core.ExportMenu();
    //   chart.exporting.filePrefix = "avisa";
    // }); // end am4core.ready()
    const chartData = trialsestablished_field.map(d => {
      const result = { programname: d.programname };
      result['total'] = Object.keys(d).filter(e => e != 'programname').map(e => d[e] || 0).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });
    // console.log(chartData);

    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_trials", am4charts.XYChart);
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = chartData


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
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
      yAxis.title.text = "Number of Nurseries";
      yAxis.title.fontWeight = 800;


      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "total";
      series.dataFields.categoryX = "programname";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.scrollbarX = new am4core.Scrollbar();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
  //Graph -4
  // trialsEstablishedGreenhouseChart() {
  //   $("#programwise_trials_greenhouse").html("");

  //   const trialsestablished_greenhouse = this.poTwoData.trialsestablished_greenhouse
  //   if (!trialsestablished_greenhouse?.length) {
  //     $("#programwise_trials_greenhouse").html(nodata_html());
  //     return;
  //   }
  //   const chartData = trialsestablished_greenhouse.map(d => {
  //     const result = {programname: d.programname};
  //     result['total'] = Object.keys(d).filter(e => e != 'programname').map(e => d[e] || 0).reduce((v1,v2) => v1+v2, 0);
  //     return result;
  //     });
  //   console.log(chartData);

  //   am4core.ready(function () {
  //     // Themes begin
  //     am4core.useTheme(am4themes_animated);
  //     // Themes end

  //     // Create chart instance
  //     var chart = am4core.create("programwise_trials_greenhouse", am4charts.XYChart);
  //     chart.scrollbarX = new am4core.Scrollbar();
  //     chart.logo.disabled = "true";

  //     // Add data
  //     chart.data = chartData


  //     // Create axes
  //     var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  //     categoryAxis.dataFields.category = "programname";
  //     categoryAxis.renderer.grid.template.location = 0;
  //     categoryAxis.renderer.minGridDistance = 30;
  //     categoryAxis.renderer.labels.template.horizontalCenter = "right";
  //     categoryAxis.renderer.labels.template.verticalCenter = "middle";
  //     categoryAxis.renderer.labels.template.rotation = 270;
  //     categoryAxis.tooltip.disabled = true;
  //     categoryAxis.renderer.minHeight = 110;

  //     // var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  //     // valueAxis.renderer.minWidth = 50;

  //     var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
  //     yAxis.min = 0;
  //     yAxis.title.text = "Number of Nurseries";
  //     yAxis.title.fontWeight = 800;


  //     // Create series
  //     var series = chart.series.push(new am4charts.ColumnSeries());
  //     series.sequencedInterpolation = true;
  //     series.dataFields.valueY = "total";
  //     series.dataFields.categoryX = "programname";
  //     series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
  //     series.columns.template.strokeWidth = 0;

  //     series.tooltip.pointerOrientation = "vertical";

  //     series.columns.template.column.cornerRadiusTopLeft = 10;
  //     series.columns.template.column.cornerRadiusTopRight = 10;
  //     series.columns.template.column.fillOpacity = 0.8;

  //     var bullet = series.bullets.push(new am4charts.LabelBullet());
  //     bullet.interactionsEnabled = false;
  //     bullet.dy = -10;
  //     bullet.label.text = "{valueY}";
  //     bullet.label.fontSize = "13px";
  //     bullet.label.fill = am4core.color("#000");

  //     // on hover, make corner radiuses bigger
  //     var hoverState = series.columns.template.column.states.create("hover");
  //     hoverState.properties.cornerRadiusTopLeft = 0;
  //     hoverState.properties.cornerRadiusTopRight = 0;
  //     hoverState.properties.fillOpacity = 1;

  //     series.columns.template.adapter.add("fill", function (fill, target) {
  //       return chart.colors.getIndex(target.dataItem.index);
  //     });

  //     // Cursor
  //     chart.cursor = new am4charts.XYCursor();
  //     chart.exporting.menu = new am4core.ExportMenu();
  //     chart.exporting.filePrefix = "avisa";
  //   }); // end am4core.ready()

  //   // am4core.ready(function () {
  //   //   // Apply chart themes
  //   //   am4core.useTheme(am4themes_animated);

  //   //   // Create chart instance
  //   //   var chart = am4core.create(
  //   //     "programwise_trials_greenhouse",
  //   //     am4charts.XYChart
  //   //   );
  //   //   chart.logo.disabled = "true";

  //   //   chart.marginRight = 400;

  //   //   // Add data
  //   //   chart.data = trialsestablished_greenhouse


  //   //   // Create axes
  //   //   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  //   //   categoryAxis.dataFields.category = "programname";
  //   //   // categoryAxis.title.text = "Countries";
  //   //   categoryAxis.renderer.grid.template.location = 0;
  //   //   categoryAxis.renderer.minGridDistance = 30;
  //   //   categoryAxis.renderer.labels.template.horizontalCenter = "right";
  //   //   categoryAxis.renderer.labels.template.verticalCenter = "middle";
  //   //   categoryAxis.renderer.labels.template.rotation = 270;

  //   //   var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  //   //   valueAxis.title.text = "Number of Trials";
  //   //   valueAxis.title.fontWeight = 800;

  //   //   // Create series
  //   //   var series = chart.series.push(new am4charts.ColumnSeries());
  //   //   series.dataFields.valueY = "teg_totaltrais";
  //   //   series.dataFields.categoryX = "programname";
  //   //   series.name = "Total Trials established";
  //   //   series.tooltipText = "{name}: [bold]{valueY}[/]";
  //   //   series.stacked = true;

  //   //   var series2 = chart.series.push(new am4charts.ColumnSeries());
  //   //   series2.dataFields.valueY = "teg_bmsupload";
  //   //   series2.dataFields.categoryX = "programname";
  //   //   series2.name = "Trials uploaded in BMS";
  //   //   series2.tooltipText = "{name}: [bold]{valueY}[/]";
  //   //   series2.stacked = true;

  //   //   var series3 = chart.series.push(new am4charts.ColumnSeries());
  //   //   series3.dataFields.valueY = "barcode";
  //   //   series3.dataFields.categoryX = "programname";
  //   //   series3.name = "Trials with barcode";
  //   //   series3.tooltipText = "{name}: [bold]{valueY}[/]";
  //   //   series3.stacked = true;

  //   //   var series4 = chart.series.push(new am4charts.ColumnSeries());
  //   //   series4.dataFields.valueY = "hh_device";
  //   //   series4.dataFields.categoryX = "program";
  //   //   series4.name = "Trials with data collected through HH devices or tablets";
  //   //   series4.tooltipText = "{name}: [bold]{valueY}[/]";
  //   //   series4.stacked = true;

  //   //   chart.legend = new am4charts.Legend();

  //   //   // Add cursor
  //   //   chart.cursor = new am4charts.XYCursor();
  //   //   chart.exporting.menu = new am4core.ExportMenu();
  //   //   chart.exporting.filePrefix = "avisa";
  //   // }); // end am4core.ready()


  // }

  trialsEstablishedGreenhouseChart() {
    $("#programwise_trials_greenhouse").html("");
    const trialsestablished_field = this.poTwoData.trialsestablished_field;
    const trialsestablished_greenhouse = this.poTwoData.trialsestablished_greenhouse;



    const totalData = [...trialsestablished_field, ...trialsestablished_greenhouse].filter(d => d.count)
    const programList = Array.from(new Set(totalData.map(d => d.program_name)));

    //console.log(totalData);


    const chartData = programList.map(e => {
      const result = { "program_name": e }
      const fieldData = trialsestablished_field.find(d => d.program_name == e)?.count;
      const greenhouseData = trialsestablished_greenhouse.find(d => d.program_name == e)?.count;
      if (fieldData) result["fieldData"] = fieldData;
      if (greenhouseData) result["greenhouseData"] = greenhouseData;
      result.none = 0;
      return result;
    })

    //console.log(chartData);

    if (!trialsestablished_field?.length) {
      $("#programwise_trials_greenhouse").html(nodata_html());
      return;
    }

    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_trials_greenhouse", am4charts.XYChart);
      chart.maskBullets = false;
      chart.numberFormatter.numberFormat = "#.#";
      chart.logo.disabled = "true";

      // Add data
      chart.data = chartData

      //console.log(chartData);


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 10;
      categoryAxis.renderer.labels.template.rotation = 270;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "middlw";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      // valueAxis.renderer.inside = true;
      //valueAxis.renderer.labels.template.disabled = true;
      valueAxis.min = 0;
      valueAxis.extraMax = 0.2;
      valueAxis.calculateTotals = true;
      // valueAxis.title.text = "Number";
      valueAxis.title.text = "Number of trials";
      valueAxis.title.fontWeight = 800;
      //valueAxis.extraMax = 0.2;
      valueAxis.calculateTotals = true;

      // Create series
      function createSeries(field, name) {

        // Set up series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.name = name;
        series.dataFields.valueY = field;
        series.dataFields.categoryX = "program_name";
        series.sequencedInterpolation = true;


        // Make it stacked
        series.stacked = true;

        // Configure columns
        series.columns.template.width = am4core.percent(60);
        series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

        // Add label
        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        // labelBullet.label.text = "{valueY}";
        labelBullet.label.fill = am4core.color("#fff");
        labelBullet.locationY = 0.5;

        return series;
      }

      createSeries("fieldData", "Trials established in field");
      createSeries("greenhouseData", "Trials established in greenhouse");

      var totalSeries = chart.series.push(new am4charts.ColumnSeries());
      totalSeries.dataFields.valueY = "none";
      totalSeries.dataFields.categoryX = "program_name";
      totalSeries.stacked = true;
      totalSeries.hiddenInLegend = true;
      totalSeries.columns.template.strokeOpacity = 0;

      var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
      totalBullet.dy = -20;
      totalBullet.label.text = "{valueY.total}";
      totalBullet.label.hideOversized = false;
      totalBullet.label.fontSize = 12;
      totalBullet.label.fontWeight = 400;
      totalBullet.label.background.fill = totalSeries.stroke;
      totalBullet.label.background.fillOpacity = 0.2;
      totalBullet.label.padding(10, 10, 5, 10);
      totalBullet.label.truncate = false;


      // Legend
      chart.legend = new am4charts.Legend();
      chart.scrollbarX = new am4core.Scrollbar();
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";



    }
    )
  }

  sopPytDataChart() {
    $("#programwise_sop_pyt").html("");
    const sop_pyt_data = this.poTwoData.sop_pyt_data;
    const sop_ayt_data = this.poTwoData.sop_ayt_data;
    const sop_mlt_data = this.poTwoData.sop_mlt_data;
    const sop_pvs_data = this.poTwoData.sop_pvs_data;
    const sop_nurseries_data = this.poTwoData.sop_nurseries_data;

    // const chartData = 

    // const chartData = trialsestablished_field.map(d => {
    //   const result = {programname: d.programname};
    //   result['total'] = Object.keys(d).filter(e => e != 'programname').map(e => d[e] || 0).reduce((v1,v2) => v1+v2, 0);
    //   return result;
    //   });
    // console.log(chartData);

    const totalData = [...sop_pyt_data, ...sop_ayt_data, ...sop_mlt_data, ...sop_pvs_data, ...sop_nurseries_data].filter(d => d.count)
    const target_percent = totalData.length;
    //console.log(target_percent);
    const programList = Array.from(new Set(totalData.map(d => d.programname)));

    const chartData = programList.map(e => {
      const result = { "program_name": e }
      const pytData = sop_pyt_data.find(d => d.programname == e)?.count;
      const aytData = sop_ayt_data.find(d => d.programname == e)?.count;
      const mltData = sop_mlt_data.find(d => d.programname == e)?.count;
      const pvsData = sop_pvs_data.find(d => d.programname == e)?.count;
      const nurseriesData = sop_nurseries_data.find(d => d.programname == e)?.count;
      if (pytData) result["pytData"] = pytData;
      if (aytData) result["aytData"] = aytData;
      if (mltData) result["mltData"] = mltData;
      if (pvsData) result["pvsData"] = pvsData;
      if (nurseriesData) result["nurseriesData"] = nurseriesData;
      result.count = (pytData + aytData + mltData + pvsData + nurseriesData) / 5;
      return result;
    })

    const totalCount = chartData.map(d => Object.keys(d).filter(e => e != "program_name" && e != 'count').map(e => d[e]).reduce((u, v) => u + v, 0)).reduce((u, v) => u + v, 0)

    $("#programwise_sop_count").html((totalCount / totalData.length).toFixed(2));

    //Graph -5
    if (!sop_pyt_data?.length) {
      $("#programwise_sop_pyt").html(nodata_html());
      return;
    }

    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_sop_pyt", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = chartData
      chart.numberFormatter.numberFormat = "#.#";

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Progress (%)";
      valueAxis.title.fontWeight = "bold";
      valueAxis.extraMax = 0.2;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.rotation = 270;
      categoryAxis.renderer.labels.template.horizontalCenter = "middle";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";


      // Configure axis label
      var label = categoryAxis.renderer.labels.template;
      //label.truncate = true;
      //label.maxWidth = 120;
      label.tooltipText = "{program_name}";

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "count";
      series.dataFields.categoryX = "program_name";
      series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
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

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
    // am4core.ready(function () {

    //   // Themes begin
    //   am4core.useTheme(am4themes_animated);
    //   // Themes end

    //   // Create chart instance
    //   var chart = am4core.create("programwise_sop_pyt", am4charts.XYChart);
    //   chart.maskBullets = false;
    //   chart.numberFormatter.numberFormat = "#.#";
    //   chart.logo.disabled = "true";

    //   // Add data
    //   chart.data = chartData

    //   console.log(chartData);


    //   // Create axes
    //   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //   categoryAxis.dataFields.category = "programname";
    //   categoryAxis.renderer.grid.template.location = 10;
    //   categoryAxis.renderer.labels.template.rotation = 270;
    //   categoryAxis.renderer.minGridDistance = 10;
    //   categoryAxis.renderer.labels.template.horizontalCenter = "right";
    //   categoryAxis.renderer.labels.template.verticalCenter = "middle";

    //   var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //   valueAxis.renderer.inside = true;
    //   valueAxis.renderer.labels.template.disabled = true;
    //   valueAxis.min = 0;
    //   valueAxis.extraMax = 0.3;
    //   valueAxis.calculateTotals = true;
    //   valueAxis.title.text = "Progress (%)";
    //   valueAxis.title.fontWeight = 800;

    //   // Create series
    //   function createSeries(field, name) {

    //     // Set up series
    //     var series = chart.series.push(new am4charts.ColumnSeries());
    //     series.name = name;
    //     series.dataFields.valueY = field;
    //     series.dataFields.categoryX = "programname";
    //     series.sequencedInterpolation = true;


    //     // Make it stacked
    //     series.stacked = true;

    //     // Configure columns
    //     series.columns.template.width = am4core.percent(60);
    //     series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

    //     // Add label
    //     var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    //     // labelBullet.label.text = "{valueY}";
    //     labelBullet.label.fill = am4core.color("#fff");
    //     labelBullet.locationY = 0.5;

    //     return series;
    //   }

    //   createSeries("pytData", "PYT");
    //   createSeries("aytData", "AYT");
    //   createSeries("mltData", "MLT");
    //   createSeries("pvsData", "PVS");
    //   createSeries("nurseriesData", "Nurseries");

    //   var totalSeries = chart.series.push(new am4charts.ColumnSeries());
    //   totalSeries.dataFields.valueY = "none";
    //   totalSeries.dataFields.categoryX = "programname";
    //   totalSeries.stacked = true;
    //   totalSeries.hiddenInLegend = true;
    //   totalSeries.columns.template.strokeOpacity = 0;

    //   var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
    //   totalBullet.dy = -20;
    //   totalBullet.label.text = "{valueY}";
    //   totalBullet.label.hideOversized = false;
    //   totalBullet.label.fontSize = 12;
    //   totalBullet.label.fontWeight = 400;
    //   totalBullet.label.background.fill = totalSeries.stroke;
    //   totalBullet.label.background.fillOpacity = 0.2;
    //   totalBullet.label.padding(10, 10, 5, 10);


    //   // Legend
    //   chart.legend = new am4charts.Legend();



    // }
    // )
    // am4core.ready(function () {
    //   // Themes begin
    //   am4core.useTheme(am4themes_animated);
    //   // Themes end

    //   // Create chart instance
    //   var chart = am4core.create("programwise_sop_pyt", am4charts.XYChart);
    //   chart.scrollbarX = new am4core.Scrollbar();
    //   chart.logo.disabled = "true";

    //   // Add data
    //   chart.data = sop_pyt_data


    //   // Create axes
    //   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //   categoryAxis.dataFields.category = "programname";
    //   categoryAxis.renderer.grid.template.location = 0;
    //   categoryAxis.renderer.minGridDistance = 30;
    //   categoryAxis.renderer.labels.template.horizontalCenter = "right";
    //   categoryAxis.renderer.labels.template.verticalCenter = "middle";
    //   categoryAxis.renderer.labels.template.rotation = 270;
    //   categoryAxis.tooltip.disabled = true;
    //   categoryAxis.renderer.minHeight = 110;

    //   // var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //   // valueAxis.renderer.minWidth = 50;

    //   var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //   yAxis.min = 0;
    //   yAxis.title.text = "Progress made (%)";
    //   yAxis.title.fontWeight = 800;

    //   // Create series
    //   var series = chart.series.push(new am4charts.ColumnSeries());
    //   series.sequencedInterpolation = true;
    //   series.dataFields.valueY = "count";
    //   series.dataFields.categoryX = "programname";
    //   series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
    //   series.columns.template.strokeWidth = 0;

    //   series.tooltip.pointerOrientation = "vertical";

    //   series.columns.template.column.cornerRadiusTopLeft = 10;
    //   series.columns.template.column.cornerRadiusTopRight = 10;
    //   series.columns.template.column.fillOpacity = 0.8;

    //   var bullet = series.bullets.push(new am4charts.LabelBullet());
    //   bullet.interactionsEnabled = false;
    //   bullet.dy = -10;
    //   bullet.label.text = "{valueY}";
    //   bullet.label.fontSize = "13px";
    //   bullet.label.fill = am4core.color("#000");

    //   // on hover, make corner radiuses bigger
    //   var hoverState = series.columns.template.column.states.create("hover");
    //   hoverState.properties.cornerRadiusTopLeft = 0;
    //   hoverState.properties.cornerRadiusTopRight = 0;
    //   hoverState.properties.fillOpacity = 1;

    //   series.columns.template.adapter.add("fill", function (fill, target) {
    //     return chart.colors.getIndex(target.dataItem.index);
    //   });

    //   // Cursor
    //   chart.cursor = new am4charts.XYCursor();
    //   chart.exporting.menu = new am4core.ExportMenu();
    //   chart.exporting.filePrefix = "avisa";
    // }); // end am4core.ready()

  }
  advocacyToolsTable() {
    var mydata = this.poTwoData.advocacy_tools_table;

    //debugger
    //console.log(mydata);
    const tableData = mydata.map(d => {
      const result = `
      <tr>
        <td>${d.country_name}</td>
        <td>${d.crop_name}</td>
        <td>
          ${d.name}
        </td>
      </tr>
      `;
      return result;
    })

    $('#resultpo2>tbody').html(tableData);
    $("tbody>tr").addClass("tbl_bg");

  }
  advocacyToolsChart() {
    // debugger;
    $("#programwise_advocacy_tools").html("");
    const advocacy_tools = this.poTwoData.advocacy_tools;
    $("#advocacy_tools_count").html(
      advocacy_tools.map((e) => e.count).reduce((a, b) => a + b, 0)
    );
    if (!advocacy_tools?.length) {
      $("#programwise_advocacy_tools").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      // am4core.useTheme(am4themes_kelly)
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_advocacy_tools", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = advocacy_tools;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of advocacy tools";
      valueAxis.title.fontWeight = "bold";
      valueAxis.renderer.minGridDistance = 100;
      valueAxis.min = 0;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 10;
      categoryAxis.renderer.labels.template.rotation = 270;
      categoryAxis.renderer.labels.template.horizontalCenter = "middle";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";

      // Configure axis label
      var label = categoryAxis.renderer.labels.template;
      //label.truncate = true;
      //label.maxWidth = 120;
      label.tooltipText = "{program_name}";

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "count";
      series.dataFields.categoryX = "program_name";
      series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
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

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }

  sopAytDataChart() {
    //Graph -6
    $("#programwise_sop_ayt").html("");

    const sop_ayt_data = this.poTwoData.sop_ayt_data;
    if (!sop_ayt_data?.length) {
      $("#programwise_sop_ayt").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_sop_ayt", am4charts.XYChart);
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = sop_ayt_data;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
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
      series.dataFields.categoryX = "programname";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  sopMltDataChart() {
    $("#programwise_sop_mlt").html("");
    const sop_mlt_data = this.poTwoData.sop_mlt_data;
    if (!sop_mlt_data?.length) {
      $("#programwise_sop_mlt").html(nodata_html());
      return;
    }
    //Graph -7
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_sop_mlt", am4charts.XYChart);
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = sop_mlt_data;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
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
      series.dataFields.categoryX = "programname";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()

  }

  sopPvsDataChart() {
    $("#programwise_sop_pvs").html("");
    const sop_pvs_data = this.poTwoData.sop_pvs_data;
    if (!sop_pvs_data?.length) {
      $("#programwise_sop_pvs").html(nodata_html());
      return;
    }
    //Graph -8
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_sop_pvs", am4charts.XYChart);
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = sop_pvs_data;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
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
      series.dataFields.categoryX = "programname";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  sopNurseriesDataChart() {
    $("#programwise_sop_nurseries").html("");
    const sop_nurseries_data = this.poTwoData.sop_nurseries_data;
    if (!sop_nurseries_data?.length) {
      $("#programwise_sop_nurseries").html(nodata_html());
      return;
    }
    //Graph -9
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "programwise_sop_nurseries",
        am4charts.XYChart
      );
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = sop_nurseries_data;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
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
      series.dataFields.categoryX = "programname";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "13px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()

  }

  weaiGreatDataChart() {
    $("#program_wise_WEAI_GREAT_methodology").html("");
    const weai_great_data = this.poTwoData.weai_great_data
    //console.log(weai_great_data);
    let weai_count = weai_great_data.map((e) => e.weai).reduce((a, b) => a + b, 0) || 0;
    let great_count = weai_great_data.map((e) => e.great).reduce((a, b) => a + b, 0) || 0;

    $("#program_wise_WEAI_GREAT_methodology_count").html(weai_count + great_count);
    if (!weai_great_data?.length) {
      $("#program_wise_WEAI_GREAT_methodology").html(nodata_html());
      return;
    }
    //Graph -10
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_WEAI_GREAT_methodology",
        am4charts.XYChart
      );

      // Add percent sign to all numbers
      chart.numberFormatter.numberFormat = "#.#";
      chart.logo.disabled = "true";

      // Add data
      chart.data = weai_great_data;

      chart.legend = new am4charts.Legend();

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "weai";
      series.dataFields.categoryX = "program_name";
      series.clustered = false;
      series.name = "WEAI Methodology";
      series.tooltipText = "WEAI Methodology: [bold]{valueY}[/]";
      // series.columns.template.fill = am4core.color("#e600e6"); // fill

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "great";
      series2.dataFields.categoryX = "program_name";
      series2.clustered = false;
      series2.name = "GREAT methodology";
      series2.columns.template.width = am4core.percent(50);
      series2.tooltipText = "GREAT methodology: [bold]{valueY}[/]";
      // series2.columns.template.fill = am4core.color("#4b56cc"); // fill

      chart.cursor = new am4charts.XYCursor();
      /*chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;*/
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  adoptingStreamLinedChart() {
    $("#program_wise_digital_seed_and_breeding").html("");

    const adoptingstreamlined = this.poTwoData.adoptingstreamlined;
    //console.log(adoptingstreamlined);
    let weai_count = adoptingstreamlined.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    $("#program_wise_digital_seed_and_breeding_count").html(weai_count);
    if (!adoptingstreamlined?.length) {
      $("#program_wise_digital_seed_and_breeding").html(nodata_html());
      return;
    }
    //Graph -11
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_digital_seed_and_breeding",
        am4charts.XYChart
      );
      chart.scrollbarX = new am4core.Scrollbar();
      chart.logo.disabled = "true";

      // Add data
      chart.data = adoptingstreamlined;


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
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
      series.dataFields.categoryX = "program_name";
      series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
      series.columns.template.strokeWidth = 0;

      series.tooltip.pointerOrientation = "vertical";

      series.columns.template.column.cornerRadiusTopLeft = 10;
      series.columns.template.column.cornerRadiusTopRight = 10;
      series.columns.template.column.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = false;
      bullet.dy = -10;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "12px";
      bullet.label.fill = am4core.color("#000");

      // on hover, make corner radiuses bigger
      var hoverState = series.columns.template.column.states.create("hover");
      hoverState.properties.cornerRadiusTopLeft = 0;
      hoverState.properties.cornerRadiusTopRight = 0;
      hoverState.properties.fillOpacity = 1;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }


  staticCharts() {
  }
  rcih_po2_piechart(divid, data) {
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end
      // Create chart instance
      var chart = am4core.create(divid, am4charts.PieChart);
      chart.logo.disabled = 'true'

      // Add data
      chart.data = data;
      // Add and configure Series
      var pieSeries = chart.series.push(new am4charts.PieSeries());
      pieSeries.dataFields.value = "count";
      pieSeries.dataFields.category = "programname";
      pieSeries.slices.template.stroke = am4core.color("#fff");
      pieSeries.slices.template.strokeWidth = 2;
      pieSeries.slices.template.strokeOpacity = 1;
      pieSeries.labels.template.fontSize = 14;
      pieSeries.labels.template.maxWidth = 90;
      pieSeries.labels.template.wrap = true;

      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      pieSeries.hiddenState.properties.endAngle = -90;
      pieSeries.hiddenState.properties.startAngle = -90;

    });
  }

  rcihwisenurseriesEstablishedFieldChart() {
    $("#richwise_bmsinfo").html("");
    const nurseriesestablished_field = this.richdata.nurseriesestablished_field
    if (!nurseriesestablished_field?.length) {
      $("#richwise_bmsinfo").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("richwise_bmsinfo", am4charts.XYChart);
      chart.logo.disabled = "true";

      chart.marginRight = 400;

      // Add data
      chart.data = nurseriesestablished_field
      // chart.data = [
      //   {
      //     program: "Uganda - Common bean",
      //     total: "7",
      //     uploaded_bms: "5",
      //     barcode: "3",
      //     hh_device: "5",
      //   }
      // ];

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
      // categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of Nurseries";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "nsf_total_nurseriestotal";
      series.dataFields.categoryX = "programname";
      series.name = "Total nurseries established";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "nsf_total_nurserieswithbms";
      series2.dataFields.categoryX = "programname";
      series2.name = "Nurseries uploaded in BMS";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      var series3 = chart.series.push(new am4charts.ColumnSeries());
      series3.dataFields.valueY = "nsf_total_nurserieswithbarcode";
      series3.dataFields.categoryX = "programname";
      series3.name = "Nurseries with barcode";
      series3.tooltipText = "{name}: [bold]{valueY}[/]";
      series3.stacked = true;

      var series4 = chart.series.push(new am4charts.ColumnSeries());
      series4.dataFields.valueY = "nsf_total_nurseriesdatacollected";
      series4.dataFields.categoryX = "programname";
      series4.name =
        "Nurseries with data collected through HH devices or tablets";
      series4.tooltipText = "{name}: [bold]{valueY}[/]";
      series4.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwisenurseriesEstablishedGreenhouseChart() {
    $("#richwise_greenhouse").html("");
    const nurseriesestablished_greenhouse = this.richdata.nurseriesestablished_greenhouse
    if (!nurseriesestablished_greenhouse?.length) {
      $("#richwise_greenhouse").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("richwise_greenhouse", am4charts.XYChart);
      chart.logo.disabled = "true";

      chart.marginRight = 400;

      // Add data
      chart.data = nurseriesestablished_greenhouse


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
      // categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of Nurseries";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "nsg_total_nurseriestotal";
      series.dataFields.categoryX = "programname";
      series.name = "Total nurseries established";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "nsg_total_nurserieswithbms";
      series2.dataFields.categoryX = "programname";
      series2.name = "Nurseries uploaded in BMS";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      var series3 = chart.series.push(new am4charts.ColumnSeries());
      series3.dataFields.valueY = "nsg_total_nurserieswithbarcode";
      series3.dataFields.categoryX = "programname";
      series3.name = "Nurseries with barcode";
      series3.tooltipText = "{name}: [bold]{valueY}[/]";
      series3.stacked = true;

      var series4 = chart.series.push(new am4charts.ColumnSeries());
      series4.dataFields.valueY = "nsg_total_nurseriesdatacollected";
      series4.dataFields.categoryX = "programname";
      series4.name =
        "Nurseries with data collected through HH devices or tablets";
      series4.tooltipText = "{name}: [bold]{valueY}[/]";
      series4.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwisetrialsEstablishedFieldChart() {
    $("#richwise_trials").html("");
    const trialsestablished_field = this.richdata.trialsestablished_field
    if (!trialsestablished_field?.length) {
      $("#richwise_trials").html(nodata_html());
      return;
    }

    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("richwise_trials", am4charts.XYChart);
      chart.logo.disabled = "true";

      chart.marginRight = 400;

      // Add data
      chart.data = trialsestablished_field

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
      // categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of Trials";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "tef_totaltrais";
      series.dataFields.categoryX = "programname";
      series.name = "Total Trials established";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "tef_bmsupload";
      series2.dataFields.categoryX = "programname";
      series2.name = "Trials uploaded in BMS";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      var series3 = chart.series.push(new am4charts.ColumnSeries());
      series3.dataFields.valueY = "barcode";
      series3.dataFields.categoryX = "programname";
      series3.name = "Trials with barcode";
      series3.tooltipText = "{name}: [bold]{valueY}[/]";
      series3.stacked = true;

      var series4 = chart.series.push(new am4charts.ColumnSeries());
      series4.dataFields.valueY = "hh_device";
      series4.dataFields.categoryX = "programname";
      series4.name = "Trials with data collected through HH devices or tablets";
      series4.tooltipText = "{name}: [bold]{valueY}[/]";
      series4.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwisetrialsEstablishedGreenhouseChart() {
    $("#richwise_trials_greenhouse").html("");
    const trialsestablished_greenhouse = this.richdata.trialsestablished_greenhouse
    if (!trialsestablished_greenhouse?.length) {
      $("#richwise_trials_greenhouse").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create(
        "richwise_trials_greenhouse",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";

      chart.marginRight = 400;

      // Add data
      chart.data = trialsestablished_greenhouse


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "programname";
      // categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of Trials";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "teg_totaltrais";
      series.dataFields.categoryX = "programname";
      series.name = "Total Trials established";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "teg_bmsupload";
      series2.dataFields.categoryX = "programname";
      series2.name = "Trials uploaded in BMS";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      var series3 = chart.series.push(new am4charts.ColumnSeries());
      series3.dataFields.valueY = "barcode";
      series3.dataFields.categoryX = "programname";
      series3.name = "Trials with barcode";
      series3.tooltipText = "{name}: [bold]{valueY}[/]";
      series3.stacked = true;

      var series4 = chart.series.push(new am4charts.ColumnSeries());
      series4.dataFields.valueY = "hh_device";
      series4.dataFields.categoryX = "program";
      series4.name = "Trials with data collected through HH devices or tablets";
      series4.tooltipText = "{name}: [bold]{valueY}[/]";
      series4.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwisesopPytDataChart() {
    $("#richwise_sop_pyt").html("");
    const sop_pyt_data = this.richdata.sop_pyt_data
    if (!sop_pyt_data?.length) {
      $("#richwise_sop_pyt").html(nodata_html());
      return;
    }
    this.rcih_po2_piechart("richwise_sop_pyt", sop_pyt_data)

  }

  rcihwisesopAytDataChart() {
    //Graph -6
    $("#richwise_sop_ayt").html("");
    const sop_ayt_data = this.richdata.sop_ayt_data;
    if (!sop_ayt_data?.length) {
      $("#richwise_sop_ayt").html(nodata_html());
      return;
    }
    this.rcih_po2_piechart("richwise_sop_ayt", sop_ayt_data)
  }

  rcihwisesopMltDataChart() {
    $("#richwise_sop_mlt").html("");
    const sop_mlt_data = this.richdata.sop_mlt_data;
    if (!sop_mlt_data?.length) {
      $("#richwise_sop_mlt").html(nodata_html());
      return;
    }
    this.rcih_po2_piechart("richwise_sop_mlt", sop_mlt_data)
  }

  rcihwisesopPvsDataChart() {
    $("#richwise_sop_pvs").html("");

    const sop_pvs_data = this.richdata.sop_pvs_data;
    if (!sop_pvs_data?.length) {
      $("#richwise_sop_pvs").html(nodata_html());
      return;
    }
    this.rcih_po2_piechart("richwise_sop_pvs", sop_pvs_data)
  }

  rcihwisesopNurseriesDataChart() {
    $("#richwise_sop_nurseries").html("");
    const sop_nurseries_data = this.richdata.sop_nurseries_data;
    if (!sop_nurseries_data?.length) {
      $("#richwise_sop_nurseries").html(nodata_html());
      return;
    }
    this.rcih_po2_piechart("richwise_sop_nurseries", sop_nurseries_data)
  }

  rcihwiseweaiGreatDataChart() {
    $("#richwise_WEAI_GREAT_methodology").html("");
    const weai_great_data = this.richdata.weai_great_data
    let weai_count = weai_great_data.map((e) => e.weai).reduce((a, b) => a + b, 0) || 0;
    let great_count = weai_great_data.map((e) => e.great).reduce((a, b) => a + b, 0) || 0;

    $("#richwise_WEAI_GREAT_methodology_count").html(weai_count + great_count);
    if (!weai_great_data?.length) {
      $("#richwise_WEAI_GREAT_methodology").html(nodata_html());
      return;
    }
    //Graph -10
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "richwise_WEAI_GREAT_methodology",
        am4charts.XYChart
      );

      // Add percent sign to all numbers
      chart.numberFormatter.numberFormat = "#.#";
      chart.logo.disabled = "true";

      // Add data
      chart.data = weai_great_data;

      chart.legend = new am4charts.Legend();

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 30;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.verticalCenter = "middle";
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "weai";
      series.dataFields.categoryX = "program_name";
      series.clustered = false;
      series.name = "WEAI Methodology";
      series.tooltipText = "WEAI Methodology: [bold]{valueY}[/]";
      // series.columns.template.fill = am4core.color("#e600e6"); // fill

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "great";
      series2.dataFields.categoryX = "program_name";
      series2.clustered = false;
      series2.name = "GREAT methodology";
      series2.columns.template.width = am4core.percent(50);
      series2.tooltipText = "GREAT methodology: [bold]{valueY}[/]";
      // series2.columns.template.fill = am4core.color("#4b56cc"); // fill

      chart.cursor = new am4charts.XYCursor();
      /*chart.cursor.lineX.disabled = true;
        chart.cursor.lineY.disabled = true;*/
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwiseadoptingStreamLinedChart() {
    $("#richwise_digital_seed_and_breeding").html("");
    const adoptingstreamlined = this.richdata.adoptingstreamlined;
    //console.log(adoptingstreamlined);
    let weai_count = adoptingstreamlined.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    $("#richwise_digital_seed_and_breeding_count").html(weai_count);
    if (!adoptingstreamlined?.length) {
      $("#richwise_digital_seed_and_breeding").html(nodata_html());
      return;
    }
    //this.rcih_po2_piechart("richwise_digital_seed_and_breeding", adoptingstreamlined)
    //Graph -11
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end
      // Create chart instance
      var chart = am4core.create("richwise_digital_seed_and_breeding", am4charts.PieChart);

      // Add data
      chart.data = adoptingstreamlined;
      // Add and configure Series
      var pieSeries = chart.series.push(new am4charts.PieSeries());
      pieSeries.dataFields.value = "count";
      pieSeries.dataFields.category = "program_name";
      pieSeries.slices.template.stroke = am4core.color("#fff");
      pieSeries.slices.template.strokeWidth = 2;
      pieSeries.slices.template.strokeOpacity = 1;
      pieSeries.labels.template.fontSize = 14;
      pieSeries.labels.template.maxWidth = 90;
      pieSeries.labels.template.wrap = true;

      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      pieSeries.hiddenState.properties.endAngle = -90;
      pieSeries.hiddenState.properties.startAngle = -90;

    });
  }
}
