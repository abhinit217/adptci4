class PO1 {
  constructor() {
    this.map = null;
    this.map1 = null;
    //this.generateProgramwiseMap();
    this.onRcihClick();
    this.getPO1Data();
    this.getRcihWiseData();
    this.getFilterOptions();
    $("#po1_filter").on("click", () => {
      //this.poOneData=null;
      //console.log(this.poOneData);
      this.getPO1Data();
      this.getRcihWiseData();
    });

    $("#dwn-csv-1").on("click", function () {
      $("#result").table2csv({
        file_name: "avisa-mapping-varietyname.csv",
        header_body_space: 0,
      });
    });

    $("#dwn-csv-12").on("click", function () {
      $("#resultpo12").table2csv({
        file_name: "avisa-phenotyping.csv",
        header_body_space: 0,
      });
    });


    $('[data-toggle="tooltip"]').tooltip();




  }

  onRcihClick() {
    $("#base-rcihs1").on("click", () => {
      if (!this.richdata) {
        // this.getRcihWiseData();
      }
    });
  }

  getRcihwisemap() {
    setTimeout(() => {
      if (!this.map1) {
        const greenIcon = L.icon({
          iconUrl: `${imgUrl}map_pointer/greenmarker.png`,
          shadowUrl:
            "https://unpkg.com/leaflet@1.3.1/dist/images/marker-shadow.png",
        });
        this.map1 = L.map("map1").setView([-11.202692, 17.873886], 3);
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
        ).addTo(this.map1);
        let markers = L.markerClusterGroup();
        for (let i = 0; i < RCIH.length; i++) {
          let rcih_name = RCIH[i]["rcih_name"];
          let lat = RCIH[i]["lat"];
          let lng = RCIH[i]["lang"];
          let location = RCIH[i]["location"];
          let Organization = RCIH[i]["Organization"];
          let marker = L.marker(new L.LatLng(lat, lng), {
            rcih_name: rcih_name,
            Organization: Organization,
            location: location,
            icon: greenIcon,
          });
          const html = `
            <div class="row">
              <div class="col-sm-12">
                <span>${rcih_name}</span>
                <p> ${Organization}</p>
                <p> ${location}</p>
              </div>
            </div>
        `;
          // marker /.on('click', onMapClick);
          // marker.bindPopup(html);
          markers.addLayer(marker);
          /* adding click event */
          marker.on("click", function (e) {
            let name = e.target.options;
            // let side_info = name + "Clicked.";
            // adding info into side bar
            $("#rcih_location").html(name.location);
            $("#rcih_organization").html(name.Organization);
            $("#rcih_name").html(name.rcih_name);
          });
        }
        this.map1.addLayer(markers);
        let popup = L.popup();
        //   $(".leaflet-marker-icon").attr(
        //     "src",
        //     "./assets/images/map_pointer/greenmarker.png"
        //   );
      }
    });
  }


  getRcihWiseData() {
    showLoader();
    const request = { "purpose": "PO1", "rcih": "po1rcih" };
    const countryData = $("#po1_country_list").val();
    if (countryData?.length) {
      request.country_id = countryData
    }
    post("dashboard", request).then(response => {
      this.richdata = response;
      //this.rcihwiseprotocolsDevelopedChart();
      this.richwisegenerationsAchievedChart();
      //this.rcihwisefixedlinesDevelopedChart();
      // this.richwisebreedinglinesExchangedChart();
      // this.cropwisebreedinglinesExchangedChart();
      // this.richwisemultiLocationtrialsChart();
      //this.cropwisemultiLocationtrialsChart()
      //this.richwiseonfarmTrialsChart();
      this.rcihwisefpvsDataChart();
      //this.rcihwisetricottrialsConductedChart();
      // this.richwisenewtoolsAdoptedChart();
      //this.cropwisenewtoolsAdoptedChart();
      // this.richwisecommunicationApproachesChart();
      // this.cropwisecommunicationApproachesChart();
      this.richwisehybridVarietyReleasedChart();
      this.rcihwiseonStationOnYieldChart();
     // this.rcihwisemappingVarietynameVarietytargetTable();
      // this.generateDusSankeyGraph();
      const rcihs_hybird_p1 = this.richdata.hybrid_opv_spv_data.map(d => d.hybrid).reduce((a, b) => a + b, 0)
      const rcihs_opv_p1 = this.richdata.hybrid_opv_spv_data.map(d => d.opv).reduce((a, b) => a + b, 0)
      const rcihs_spv_p1 = this.richdata.hybrid_opv_spv_data.map(d => d.spv).reduce((a, b) => a + b, 0)

      $("#rcih_wise_hybrid").html(rcihs_hybird_p1);
      $("#rcih_wise_opv").html(rcihs_opv_p1);
      $("#rcih_wise_spv").html(rcihs_spv_p1);
      $("#total_2").html(rcihs_hybird_p1 + rcihs_opv_p1 + rcihs_spv_p1);

      $("#rcih_wise_npd_data_count").html(this.richdata.npt_line + this.richdata.npt_hybrid);
      $("#rcih_wise_npt_line").html(this.richdata.npt_line);
      $("#rcih_wise_npt_hybrid").html(this.richdata.npt_hybrid);
      $("#rcih_wise_dus_line").html(this.richdata.dus_line);
      $("#rcih_wise_dus_hybrid").html(this.richdata.dus_hybrid);
      $("#rcih_wise_dus_total").html(
        this.richdata.dus_hybrid + this.richdata.dus_line
      );
    }).catch().finally(() => {
      setTimeout(() => {
        hideLoader();
        //this.getRcihwisemap();
      }
        , 1000);
    })
  }

  generateProgramwiseMap() {
    this.map = L.map("map").setView([-11.202692, 17.873886], 3);
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

      /* adding click event */
      marker.on("click", function (e) {
        let name = e.target.options;
        // var side_info = name + "Clicked.";
        // adding info into side bar
        $("#map_crops").html(name.crops);
        $("#map_partners").html(name.partners);
      });
      this.map.addLayer(marker);
    }

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
    $("#po1_country_list").multipleSelect('destroy');
    setTimeout(() => {
      const optionData = country.map(d => {
        return `<option value="${d.country_id}">${d.country_name}</option>`
      }).join('\n');
      $("#po1_country_list").html(optionData);
      $("#po1_country_list").multipleSelect();
    }
    )
  }
  cropList() {
    const crops = this.filterData.crops_list;
    $("#po1_crop_list").multipleSelect('destroy');
    setTimeout(() => {
      const optionData = crops.map(d => {
        return `<option value="${d.crop_id}">${d.crop_name}</option>`
      }).join('\n');
      $("#po1_crop_list").html(optionData);
      $("#po1_crop_list").multipleSelect();
    }
    )
  }

  getPO1Data() {
    showLoader();
    const request = { purpose: "PO1" };
    const countryData = $("#po1_country_list").val();
    if (countryData?.length) {
      request.country_id = countryData
    }
    const cropData = $("#po1_crop_list").val();
    if (cropData?.length) {
      request.crop_id = cropData
    }
    //this.poOneData=null
    post("dashboard", request)
      .then((response) => {
        // To do generate chart
        this.poOneData = response;
        this.protocolsDevelopedChart();
        this.protocolsDevelopedCropChart();
        this.generationsAchievedChart();
        this.fixedlinesDevelopedChart();
        this.fixedlinesDevelopedCropChart();
        this.breedinglinesExchangedChart();
        this.multiLocationtrialsChart();
        //this.onfarmTrialsChart();
        this.fpvsDataChart();
        this.cropwisebreedinglinesExchangedChart();
        //this.tricottrialsConductedChart();
        this.newtoolsAdoptedChart();
        this.communicationApproachesChart();
        this.hybridVarietyReleasedChart();
        this.onStationOnYieldChart();
        this.mappingVarietynameVarietytargetTable();
        this.rcihwisemappingVarietynameVarietytargetTable();
        this.generateNptSankeyGraph();
        this.generateDusSankeyGraph();
        this.generateHybridSvpSankeyGraph();
        this.generateBreedinglinesSankeyGraph();
        this.nptDusCountryChart();
        this.nptDusCropChart();
        // this.cropwisenewtoolsAdoptedChart();
        // this.cropwisecommunicationApproachesChart();
        this.cropwisemultiLocationtrialsChart();
        this.managedByMultiLocationtrialsChart();
        //this.generatePoOneBubbleMap();
        this.countrywiseDiagnosticChart();
        this.countrywiseMarkerAsseyGraphChart();
        this.countrywiseMarkerQtlGraphChart();
        this.geographicalScopeWiseChart();
        this.cvChart();
        this.heritabilityMeasureChart();
        this.partnerCountryMap();
        // $("#hybrid").html(this.poOneData.hybrid_opv_spv_data[0].hybrid);
        const hybird_p1 = this.poOneData.hybrid_opv_spv_data.map(d => d.hybrid).reduce((a, b) => a + b, 0)
        const opv_p1 = this.poOneData.hybrid_opv_spv_data.map(d => d.opv).reduce((a, b) => a + b, 0)
        const spv_p1 = this.poOneData.hybrid_opv_spv_data.map(d => d.spv).reduce((a, b) => a + b, 0)
        $("#hybrid").html(hybird_p1)
        $("#opv").html(opv_p1);
        $("#spv").html(spv_p1);
        $("#total_1").html(hybird_p1 + opv_p1 + spv_p1);
        $("#npd_data_count").html(this.poOneData.npt_line + this.poOneData.npt_hybrid);
        $("#npt_line").html(this.poOneData.npt_line);
        $("#npt_hybrid").html(this.poOneData.npt_hybrid);
        $("#dus_line").html(this.poOneData.dus_line);
        $("#dus_hybrid").html(this.poOneData.dus_hybrid);
        $("#dus_total").html(
          this.poOneData.dus_hybrid + this.poOneData.dus_line
        );
        $("#npd_data_sum").html(this.poOneData.npt_line + this.poOneData.npt_hybrid + this.poOneData.dus_hybrid + this.poOneData.dus_line);
      })
      .catch()
      .finally(() => {
        setTimeout(() => hideLoader(), 1000);
      });
  }

  partnerCountryMap(){
    const cropCountryData = clone(po1.poOneData.breedinglines_exchanged_partner_countries);

   const cropsOptions = cropCountryData.map(d => `<option value="${d.partner_country}">${d.program_name}</option>`)
   cropsOptions.unshift(`<option value=""> All</option>`)
   $('#map-country-crop-selector').html(cropsOptions);

   $('#map-country-crop-selector').on('change', () => {

     let filterData = [];

     filterData = cropCountryData.filter(d => !$('#map-country-crop-selector').val() || $('#map-country-crop-selector').val() == d.partner_country)
     .map(d => {
     // const result = {program_name: d.program_name, country_name: d.partner_country, count: d.count, id: ''};
     const result = {name: d.program_name, country_name: d.partner_country, value: d.count, id: ''};
     result.id = countriesCodes.find(c => c.country_name == result.country_name)?.country_code;
     return result;
     });

     let countryCodes = Array.from(new Set(filterData.filter(e => e.id).map(e => e.id)));


     am4core.ready(function() {
       am4core.useTheme(am4themes_animated);

       var chart = am4core.create("bubble_map_po1", am4maps.MapChart);
       chart.geodata = am4geodata_worldIndiaLow;
       chart.projection = new am4maps.projections.Miller();
       chart.logo.disabled = true;

       var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
       polygonSeries.useGeodata = true;
       polygonSeries.exclude = ["AQ"];

       polygonSeries.heatRules.push({
         property: "fill",
         target: polygonSeries.mapPolygons.template,
         min: chart.colors.getIndex(1).brighten(1),
         max: chart.colors.getIndex(1).brighten(-0.3)
        });

       // Add required properties here
       // If country code is present it will show value, make sure all countries have country code in the API response/db


   
       polygonSeries.data = countryCodes.map(e => {
         let indicators = filterData.filter(d => d.id && d.id == e).map(d => `${d.name}: ${d.value}`).join("\n");
                   let value = filterData.filter(d => d.id && d.id == e).map(d => d.value).reduce((a, b) => a + b, 0);
                   return {"id": e, "value": value, "indicators": indicators};
       })

       

       // debugger

       // debugger
       var polygonTemplate = polygonSeries.mapPolygons.template;
       polygonTemplate.applyOnClones = true;
       polygonTemplate.togglable = true;
       polygonTemplate.tooltipText = `[bold]{name}[/] 
                                       {indicators}`;
       // Conditionally render tooltips
       polygonTemplate.adapter.add("tooltipText", function (text, ev) {
           if (!ev.dataItem.dataContext.value) return;
           return text;
       });
       polygonTemplate.nonScalingStroke = true;
       polygonTemplate.strokeOpacity = 0.5;

       // Zoom on click
       var lastSelected;
       polygonTemplate.events.on("hit", function(ev) {
           if (lastSelected) {
               lastSelected.isActive = false;
           }
           ev.target.series.chart.zoomToMapObject(ev.target);
           if (lastSelected !== ev.target) {
               lastSelected = ev.target;
           }
       });

       chart.maxZoomLevel = 1

     
               
   }); 
    
   });

   $('#map-country-crop-selector').trigger('change');
 }


  protocolsDevelopedChart() {
    // debugger;
    $("#program_wise_graph_one").html("");
    const protocols_developed = this.poOneData.protocols_developed_country;
    $("#protocols_developed_count").html(
      protocols_developed.map((e) => e.count).reduce((a, b) => a + b, 0)
    );
    if (!protocols_developed?.length) {
      $("#program_wise_graph_one").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      // am4core.useTheme(am4themes_kelly)
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("program_wise_graph_one", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = protocols_developed;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of protocols";
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
  protocolsDevelopedCropChart() {
    // debugger;
    $("#crop_wise_graph_one").html("");
    const protocols_developed = clone(this.poOneData.protocols_developed_crop);
    protocols_developed.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });

    const programList = Array.from(new Set(protocols_developed.map(d => d.program_name)));

    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = protocols_developed.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });

    $("#crop_wise_protocols_developed_count").html(
      chartData.map((e) => e.count).reduce((a, b) => a + b, 0)
    );
    if (!chartData?.length) {
      $("#crop_wise_graph_one").html(nodata_html());
      return;
    }
    this.rich_piechart1("crop_wise_graph_one", chartData)
  }

  generationsAchievedChart() {
    // debugger
    $("#program_wise_graph_two").html("");
    const generationsachieved = this.poOneData.generationsachieved;
    let generationsachieved_counts = generationsachieved.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    let values = (generationsachieved_counts / generationsachieved.length).toFixed(2);
    $("#generationsachieved_count").html(values);
    if (!generationsachieved?.length) {
      $("#program_wise_graph_two").html(nodata_html());
      return;
    }
    const chartData = generationsachieved.filter(e => (e.count+e.target) != 0 );
    //Graph - 2
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("program_wise_graph_two", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      chart.colors.list = [
        am4core.color("#F3C300"),
        am4core.color("#875692"),
			am4core.color("#F38400"),
			am4core.color("#A1CAF1"),
			am4core.color("#BE0032"),
			am4core.color("#C2B280"),
			am4core.color("#848482"),
			am4core.color("#008856"),
			am4core.color("#E68FAC"),
			am4core.color("#0067A5"),
			am4core.color("#F99379"),
			am4core.color("#604E97"),
			am4core.color("#F6A600"),
			am4core.color("#B3446C"),
			am4core.color("#DCD300"),
			am4core.color("#882D17"),
			am4core.color("#8DB600"),
			am4core.color("#654522"),
			am4core.color("#E25822"),
			am4core.color("#2B3D26"),
			// am4core.color("#F2F3F4"),
			am4core.color("#222222")
    ]

      // Add data
      chart.data = chartData;

      // chart.legend = new am4charts.Legend();



      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of generations";
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
      var label = categoryAxis.renderer.labels.template;
      //label.truncate = true;
      //label.maxWidth = 120;
      label.tooltipText = "{program_name}";

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.name = "Actual Value"
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "count";
      series.dataFields.categoryX = "program_name";
      // series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
      series.columns.template.strokeWidth = 0;
      // series.color = am4core.color("#000000");

      series.tooltip.pointerOrientation = "vertical";

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
      lineBullets.tooltipText = "[#fff font-size: 15px]{name} in {categoryX}:\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
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
  //Graph-3
  fixedlinesDevelopedChart() {
    $("#program_wise_graph_three").html("");

    //const fixedlines_developed = [...this.poOneData.fixedlines_developed_country].sort(countryIndexsort);
    const fixedlines_developed = this.poOneData.fixedlines_developed_country;
    $("#fixedlines_developed_count").html(
      fixedlines_developed.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!fixedlines_developed?.length) {
      $("#program_wise_graph_three").html(nodata_html());
      return;
    }

    const allValues = fixedlines_developed.map(d => d.count)

    const maxValue = Math.max(...allValues)

    am4core.ready(function () {
      // Themes begin


      // am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("program_wise_graph_three", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      chart.colors.list = [
        am4core.color("#F3C300"),
        am4core.color("#875692"),
			am4core.color("#F38400"),
			am4core.color("#A1CAF1"),
			am4core.color("#BE0032"),
			am4core.color("#C2B280"),
			am4core.color("#848482"),
			am4core.color("#008856"),
			am4core.color("#E68FAC"),
			am4core.color("#0067A5"),
			am4core.color("#F99379"),
			am4core.color("#604E97"),
			am4core.color("#F6A600"),
			am4core.color("#B3446C"),
			am4core.color("#DCD300"),
			am4core.color("#882D17"),
			am4core.color("#8DB600"),
			am4core.color("#654522"),
			am4core.color("#E25822"),
			am4core.color("#2B3D26"),
			// am4core.color("#F2F3F4"),
			am4core.color("#222222")
    ]

      // Add data
      chart.data = fixedlines_developed;

      //console.log(fixedlines_developed);


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of fixed lines";
      valueAxis.title.fontWeight = "bold";
      // valueAxis.minGridDistance = -10;
      valueAxis.min = 0;
      valueAxis.max = maxValue + 200;
      valueAxis.strictMinMax = true;




      var axisBreak = valueAxis.axisBreaks.create();
      axisBreak.startValue = (maxValue * 5) / 100;
      axisBreak.endValue = (maxValue * 95) / 100;
      axisBreak.breakSize = 0.005;

      // fixed axis break
      // var d = (axisBreak.endValue - axisBreak.startValue) / (valueAxis.max - valueAxis.min);
      // axisBreak.breakSize = 0.05 * (1 - d) / d; // 0.05 means that the break will take 5% of the total value axis height
      // axisBreak.breakSize = 40

      // make break expand on hover
      var hoverState = axisBreak.states.create("hover");
      hoverState.properties.breakSize = 1;
      hoverState.properties.opacity = 0.1;
      hoverState.transitionDuration = 1500;

      axisBreak.defaultState.transitionDuration = 1000;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
      bullet.dy = -20;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "10px";
      // bullet.label.wrap = true;

      bullet.label.fill = am4core.color("#000");
      bullet.label.truncate = false;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }
  // fixedlinesDevelopedChart() {
  //   $("#program_wise_graph_three").html("");

  //   //const fixedlines_developed = [...this.poOneData.fixedlines_developed_country].sort(countryIndexsort);
  //   const fixedlines_developed = this.poOneData.fixedlines_developed_country;
  //   $("#fixedlines_developed_count").html(
  //     fixedlines_developed.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
  //   );
  //   if (!fixedlines_developed?.length) {
  //     $("#program_wise_graph_three").html(nodata_html());
  //     return;
  //   }
  //   am4core.ready(function () {
  //     // Themes begin
  //     am4core.useTheme(am4themes_animated);
  //     // Create chart instance
  //     var chart = am4core.create("program_wise_graph_three", am4charts.XYChart);
  //     chart.logo.disabled = "true";
  //     chart.scrollbarX = new am4core.Scrollbar();

  //     // Add data
  //     chart.data = fixedlines_developed;

  //     // Create value axis
  //     var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  //     valueAxis.title.text = "Number of fixed lines";
  //     valueAxis.title.fontWeight = "bold";

  //     // Create axes
  //     var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  //     categoryAxis.dataFields.category = "program_name";
  //     categoryAxis.renderer.grid.template.location = 0;
  //     categoryAxis.renderer.minGridDistance = 0;
  //     categoryAxis.renderer.labels.template.rotation = 270;
  //     categoryAxis.renderer.labels.template.horizontalCenter = "middle";
  //     categoryAxis.renderer.labels.template.verticalCenter = "middle";

  //     // Configure axis label
  //     var label = categoryAxis.renderer.labels.template;
  //     //label.truncate = true;
  //     //label.maxWidth = 120;
  //     label.tooltipText = "{program_name}";

  //     // Create series
  //     var series = chart.series.push(new am4charts.ColumnSeries());
  //     series.sequencedInterpolation = true;
  //     series.dataFields.valueY = "count";
  //     series.dataFields.categoryX = "program_name";
  //     series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
  //     series.columns.template.strokeWidth = 0;

  //     series.tooltip.pointerOrientation = "vertical";

  //     series.columns.template.column.cornerRadiusTopLeft = 10;
  //     series.columns.template.column.cornerRadiusTopRight = 10;
  //     series.columns.template.column.fillOpacity = 0.8;

  //     // on hover, make corner radiuses bigger
  //     var hoverState = series.columns.template.column.states.create("hover");
  //     hoverState.properties.cornerRadiusTopLeft = 0;
  //     hoverState.properties.cornerRadiusTopRight = 0;
  //     hoverState.properties.fillOpacity = 1;

  //     var bullet = series.bullets.push(new am4charts.LabelBullet());
  //     bullet.interactionsEnabled = false;
  //     bullet.dy = -10;
  //     bullet.label.text = "{valueY}";
  //     bullet.label.fontSize = "10px";
  //     bullet.label.fill = am4core.color("#000");
  //     bullet.label.truncate = false;

  //     series.columns.template.adapter.add("fill", function (fill, target) {
  //       return chart.colors.getIndex(target.dataItem.index);
  //     });

  //     // Cursor
  //     chart.cursor = new am4charts.XYCursor();
  //     chart.exporting.menu = new am4core.ExportMenu();
  //     chart.exporting.filePrefix = "avisa";
  //   });
  // }

  fixedlinesDevelopedCropChart() {
    $("#crop_wise_graph_three").html("");
    //const fixedlines_developed = this.poOneData.fixedlines_developed_crop;
    const fixedlines_developed = clone(this.poOneData.fixedlines_developed_crop);
    fixedlines_developed.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });

    const programList = Array.from(new Set(fixedlines_developed.map(d => d.program_name)));

    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = fixedlines_developed.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });

    $("#crop_wise_developed_count").html(
      chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!chartData?.length) {
      $("#crop_wise_graph_three").html(nodata_html());
      return;
    }
    this.rich_piechart1("crop_wise_graph_three", chartData)

    /*am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("crop_wise_graph_three", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = fixedlines_developed;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of fixed lines";
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
    });*/
  }

  countrywiseDiagnosticChart() {
    $("#country_wise_diagnostic_graph").html("");

    //const fixedlines_developed = [...this.poOneData.fixedlines_developed_country].sort(countryIndexsort);
    const diagnostic_markers_country = this.poOneData.diagnostic_markers_country;
    $("#country_wise_diagnostic_graph_count").html(
      diagnostic_markers_country.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!diagnostic_markers_country?.length) {
      $("#country_wise_diagnostic_graph").html(nodata_html());
      return;
    }

    const allValues = diagnostic_markers_country.map(d => d.count)

    const maxValue = Math.max(...allValues)

    am4core.ready(function () {
      // Themes begin


      // am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("country_wise_diagnostic_graph", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();



      // Add data
      chart.data = diagnostic_markers_country;

      //console.log(fixedlines_developed);


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of diagnostic markers developed";
      valueAxis.title.fontWeight = "bold";
      valueAxis.min = 0;
      valueAxis.max = maxValue;




      var axisBreak = valueAxis.axisBreaks.create();
      axisBreak.startValue = (maxValue * 5) / 100;
      axisBreak.endValue = (maxValue * 95) / 100;
      axisBreak.breakSize = 0.005;

      // fixed axis break
      var d = (axisBreak.endValue - axisBreak.startValue) / (valueAxis.max - valueAxis.min);
      axisBreak.breakSize = 0.05 * (1 - d) / d; // 0.05 means that the break will take 5% of the total value axis height

      // make break expand on hover
      var hoverState = axisBreak.states.create("hover");
      hoverState.properties.breakSize = 1;
      hoverState.properties.opacity = 0.1;
      hoverState.transitionDuration = 1500;

      axisBreak.defaultState.transitionDuration = 1000;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
      bullet.label.fontSize = "16px";
      bullet.label.fill = am4core.color("#000");
      bullet.label.truncate = false;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }
  countrywiseMarkerAsseyGraphChart() {
    $("#marker_assey_graph").html("");

    //const fixedlines_developed = [...this.poOneData.fixedlines_developed_country].sort(countryIndexsort);
    const assays_available_country = this.poOneData.assays_available_country;
    $("#marker_assey_count").html(
      assays_available_country.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!assays_available_country?.length) {
      $("#marker_assey_graph").html(nodata_html());
      return;
    }

    const allValues = assays_available_country.map(d => d.count)

    const maxValue = Math.max(...allValues)

    am4core.ready(function () {
      // Themes begin


      // am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("marker_assey_graph", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();



      // Add data
      chart.data = assays_available_country;

      //console.log(fixedlines_developed);


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of marker assays";
      valueAxis.title.fontWeight = "bold";
      valueAxis.min = 0;
      valueAxis.max = maxValue;




      var axisBreak = valueAxis.axisBreaks.create();
      axisBreak.startValue = (maxValue * 5) / 100;
      axisBreak.endValue = (maxValue * 95) / 100;
      axisBreak.breakSize = 0.005;

      // fixed axis break
      var d = (axisBreak.endValue - axisBreak.startValue) / (valueAxis.max - valueAxis.min);
      axisBreak.breakSize = 0.05 * (1 - d) / d; // 0.05 means that the break will take 5% of the total value axis height

      // make break expand on hover
      var hoverState = axisBreak.states.create("hover");
      hoverState.properties.breakSize = 1;
      hoverState.properties.opacity = 0.1;
      hoverState.transitionDuration = 1500;

      axisBreak.defaultState.transitionDuration = 1000;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
      bullet.dy = -20;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "16px";
      bullet.label.fill = am4core.color("#000");
      bullet.label.truncate = false;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }

  countrywiseMarkerQtlGraphChart() {
    $("#marker_qtl_graph").html("");

    //const fixedlines_developed = [...this.poOneData.fixedlines_developed_country].sort(countryIndexsort);
    const qtls_markers_country = this.poOneData.qtls_markers_country;
    $("#marker_qtl_count").html(
      qtls_markers_country.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!qtls_markers_country?.length) {
      $("#marker_qtl_graph").html(nodata_html());
      return;
    }

    const allValues = qtls_markers_country.map(d => d.count)

    const maxValue = Math.max(...allValues)

    // debugger
    am4core.ready(function () {
      // Themes begin


      // am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("marker_qtl_graph", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();



      // Add data
      chart.data = qtls_markers_country;

      //console.log(fixedlines_developed);


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of QTLs";
      valueAxis.title.fontWeight = "bold";
      valueAxis.min = 0;
      valueAxis.max = maxValue + (maxValue * 0.10);




      var axisBreak = valueAxis.axisBreaks.create();
      axisBreak.startValue = (maxValue * 10) / 100;
      axisBreak.endValue = (maxValue * 80) / 100;
      axisBreak.breakSize = 0.005;

      // fixed axis break
      var d = (axisBreak.endValue - axisBreak.startValue) / (valueAxis.max - valueAxis.min);
      axisBreak.breakSize = 0.05 * (1 - d) / d; // 0.05 means that the break will take 5% of the total value axis height

      // make break expand on hover
      var hoverState = axisBreak.states.create("hover");
      hoverState.properties.breakSize = 1;
      hoverState.properties.opacity = 0.1;
      hoverState.transitionDuration = 1500;

      axisBreak.defaultState.transitionDuration = 1000;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
      hoverState.properties.cornerRadiusTopLeft = 10;
      hoverState.properties.cornerRadiusTopRight = 10;
      hoverState.properties.fillOpacity = 0.8;

      var bullet = series.bullets.push(new am4charts.LabelBullet());
      bullet.interactionsEnabled = true;
      bullet.dy = -20;
      bullet.label.text = "{valueY}";
      bullet.label.fontSize = "16px";
      bullet.label.fill = am4core.color("#000");
      bullet.label.truncate = false;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      // chart.paddingTop = "10px"
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }
  // Graph-4
  breedinglinesExchangedChart() {
    $("#program_wise_graph_four").html("");
    const breedinglines_exchanged_country = this.poOneData.breedinglines_exchanged_country;
    $("#breedinglines_exchanged_count").html(
      breedinglines_exchanged_country.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!breedinglines_exchanged_country?.length) {
      $("#program_wise_graph_four").html(nodata_html());
      return;
    }


    const allValues = breedinglines_exchanged_country.map(d => d.count)

    const maxValue = Math.max(...allValues)

    am4core.ready(function () {
      // Themes begin


      // am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("program_wise_graph_four", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = breedinglines_exchanged_country;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of breeding lines";
      valueAxis.title.fontWeight = "bold";
      valueAxis.min = 0;
      valueAxis.max = maxValue;

      var axisBreak = valueAxis.axisBreaks.create();
      axisBreak.startValue = (maxValue * 5) / 100;
      axisBreak.endValue = (maxValue * 95) / 100;
      axisBreak.breakSize = 0.005;

      // fixed axis break
      var d = (axisBreak.endValue - axisBreak.startValue) / (valueAxis.max - valueAxis.min);
      axisBreak.breakSize = 0.05 * (1 - d) / d; // 0.05 means that the break will take 5% of the total value axis height

      // make break expand on hover
      var hoverState = axisBreak.states.create("hover");
      hoverState.properties.breakSize = 1;
      hoverState.properties.opacity = 0.1;
      hoverState.transitionDuration = 1500;

      axisBreak.defaultState.transitionDuration = 1000;



      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
      bullet.label.fontSize = "10px";
      bullet.label.fill = am4core.color("#000");
      bullet.label.truncate = false;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();

      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }

 
  nptDusCountryChart() {
    $("#npt_dus_country").html("");
    const npt_dus_country_crop = this.poOneData.npt_dus_country_crop;
    const chartdata = npt_dus_country_crop.filter(d => d.count != 0);
    //debugger
    //console.log(npt_dus_country_crop);
    $("#npt_dus_country").html(
      npt_dus_country_crop.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!npt_dus_country_crop?.length) {
      $("#npt_dus_country").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Create chart instance
      var chart = am4core.create("npt_dus_country", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = chartdata;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of lines/hybrids";
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
      bullet.label.truncate = false;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();

      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }
  nptDusCropChart() {
    $("#npt_dus_crop").html("");
    //const fixedlines_developed = this.poOneData.fixedlines_developed_crop;
    const npt_dus_crop_country = clone(this.poOneData.npt_dus_crop_country);
    const npt_dus_crop_countrys = npt_dus_crop_country.filter(d => d.count != 0);
    npt_dus_crop_countrys.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });

    const programList = Array.from(new Set(npt_dus_crop_countrys.map(d => d.program_name)));

    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = npt_dus_crop_countrys.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });

    $("#npt_dus_crop").html(
      chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!chartData?.length) {
      $("#npt_dus_crop").html(nodata_html());
      return;
    }
    this.rich_piechart1("npt_dus_crop", chartData)
  }

  multiLocationtrialsChart() {
    $("#program_wise_multi_locational_trials").html("");
    const multi_locationtrials = this.poOneData.multi_locationtrials_country;
    $("#program_wise_multi_locational_trials_count").html(
      multi_locationtrials.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!multi_locationtrials?.length) {
      $("#program_wise_multi_locational_trials").html(nodata_html());
      return;
    }

    const chartData = multi_locationtrials.filter(e => e.count != 0);


    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_multi_locational_trials",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();
      chart.colors.list = [
        am4core.color("#F3C300"),
        am4core.color("#875692"),
			am4core.color("#F38400"),
			am4core.color("#A1CAF1"),
			am4core.color("#BE0032"),
			am4core.color("#C2B280"),
			am4core.color("#848482"),
			am4core.color("#008856"),
			am4core.color("#E68FAC"),
			am4core.color("#0067A5"),
			am4core.color("#F99379"),
			am4core.color("#604E97"),
			am4core.color("#F6A600"),
			am4core.color("#B3446C"),
			am4core.color("#DCD300"),
			am4core.color("#882D17"),
			am4core.color("#8DB600"),
			am4core.color("#654522"),
			am4core.color("#E25822"),
			am4core.color("#2B3D26"),
			// am4core.color("#F2F3F4"),
			am4core.color("#222222")
    ]

      // Add data
      chart.data = chartData;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials ";
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
    // end am4core.ready()
  }

  cvChart() {
    $("#cv_graph").html("");
    const cv_trials_conducted = this.poOneData.cv_trials_conducted;
    $("#cv_graph_count").html(
      cv_trials_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!cv_trials_conducted?.length) {
      $("#cv_graph").html(nodata_html());
      return;
    }

    const chartData = cv_trials_conducted.filter(e => e.count != 0);


    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "cv_graph",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = chartData;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials ";
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
    // end am4core.ready()
  }
  heritabilityMeasureChart() {
    $("#heritability_graph").html("");
    const heritability_measure = this.poOneData.heritability_measure;
    $("#heritability_graph_count").html(
      heritability_measure.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!heritability_measure?.length) {
      $("#heritability_graph").html(nodata_html());
      return;
    }

    const chartData = heritability_measure.filter(e => e.count != 0);


    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "heritability_graph",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = chartData;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials ";
      valueAxis.title.fontWeight = "bold";
       //valueAxis.renderer.minGridDistance = 20;
       //valueAxis.renderer.labels.template.dy = -40;
      
      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
      bullet.label.fontSize = "14px";
      bullet.label.fill = am4core.color("#000");
      //bullet.locationY = 0.5;

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
    // end am4core.ready()
  }

  /* onfarmTrialsChart() {
     $("#program_wise_on_farm_trials").html("");
     const onfarm_trials = this.poOneData.onfarm_trials;
     $("#program_wise_on_farm_trials_count").html(
       onfarm_trials.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
     );
     if (!onfarm_trials?.length) {
       $("#program_wise_on_farm_trials").html(nodata_html());
       return;
     }
     am4core.ready(function () {
       // Themes begin
       am4core.useTheme(am4themes_animated);
       // Themes end
 
       // Create chart instance
       var chart = am4core.create(
         "program_wise_on_farm_trials",
         am4charts.XYChart
       );
       chart.logo.disabled = "true";
       chart.scrollbarX = new am4core.Scrollbar();
 
       // Add data
       chart.data = onfarm_trials;
       // Create value axis
       var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
       valueAxis.title.text = "Number of trials ";
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
     }); // end am4core.ready()
   }*/

  fpvsDataChart() {
    $("#program_wise_multi_fpvs").html("");
    const fpvs_data = this.poOneData.fpvs_data_country;
    $("#program_wise_multi_fpvs_count").html(
      fpvs_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!fpvs_data?.length) {
      $("#program_wise_multi_fpvs").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("program_wise_multi_fpvs", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = fpvs_data;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials ";
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
    }); // end am4core.ready()
  }

  /*tricottrialsConductedChart() {
    const tricottrials_conducted = this.poOneData.tricottrials_conducted;
    $("#program_wise_tricot_trials_count").html(
      tricottrials_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_tricot_trials",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = tricottrials_conducted;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials ";
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
    }); // end am4core.ready()
  }*/

  newtoolsAdoptedChart() {
    $("#program_wise_new_tools").html("");
    let newtools_adopted = this.poOneData.newtools_adopted_country;
    //console.log(newtools_adopted);
    $("#program_wise_new_tools_count").html(
      newtools_adopted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!newtools_adopted?.length) {
      $("#program_wise_new_tools").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("program_wise_new_tools", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = newtools_adopted;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of new tools and approaches";
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
    }); // end am4core.ready()
  }
  //Graph-8
  // communicationApproachesChart() {
  //   $("#program_wise_no_of_communication").html("");
  //   const communication_approaches = this.poOneData.communication_approaches_country;
  //   $("#program_wise_no_of_communication_count").html(
  //     communication_approaches.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
  //   );
  //   if (!communication_approaches?.length) {
  //     $("#program_wise_no_of_communication").html(nodata_html());
  //     return;
  //   }

  //   am4core.ready(function () {
  //     // Themes begin
  //     am4core.useTheme(am4themes_animated);
  //     // Themes end

  //     // Create chart instance
  //     var chart = am4core.create(
  //       "program_wise_no_of_communication",
  //       am4charts.XYChart
  //     );
  //     chart.logo.disabled = "true";
  //     chart.scrollbarX = new am4core.Scrollbar();

  //     // Add data
  //     chart.data = communication_approaches;

  //     // Create value axis
  //     var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
  //     valueAxis.title.text = "Number of communication approaches";
  //     valueAxis.title.fontWeight = "bold";


  //     // Create axes
  //     var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
  //     categoryAxis.dataFields.category = "program_name";
  //     categoryAxis.renderer.grid.template.location = 0;
  //     categoryAxis.renderer.minGridDistance = 0;
  //     categoryAxis.renderer.labels.template.rotation = 270;
  //     categoryAxis.renderer.labels.template.horizontalCenter = "middle";
  //     categoryAxis.renderer.labels.template.verticalCenter = "middle";

  //     // Configure axis label
  //     var label = categoryAxis.renderer.labels.template;
  //     //label.truncate = true;
  //     //label.maxWidth = 120;
  //     label.tooltipText = "{program_name}";

  //     // Create series
  //     var series = chart.series.push(new am4charts.ColumnSeries());
  //     series.sequencedInterpolation = true;
  //     series.dataFields.valueY = "count";
  //     series.dataFields.categoryX = "program_name";
  //     series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
  //     series.columns.template.strokeWidth = 0;

  //     series.tooltip.pointerOrientation = "vertical";

  //     series.columns.template.column.cornerRadiusTopLeft = 10;
  //     series.columns.template.column.cornerRadiusTopRight = 10;
  //     series.columns.template.column.fillOpacity = 0.8;

  //     // on hover, make corner radiuses bigger
  //     var hoverState = series.columns.template.column.states.create("hover");
  //     hoverState.properties.cornerRadiusTopLeft = 0;
  //     hoverState.properties.cornerRadiusTopRight = 0;
  //     hoverState.properties.fillOpacity = 1;

  //     var bullet = series.bullets.push(new am4charts.LabelBullet());
  //     bullet.interactionsEnabled = false;
  //     bullet.dy = -10;
  //     bullet.label.text = "{valueY}";
  //     bullet.label.fontSize = "13px";
  //     bullet.label.fill = am4core.color("#000");

  //     series.columns.template.adapter.add("fill", function (fill, target) {
  //       return chart.colors.getIndex(target.dataItem.index);
  //     });

  //     // Cursor
  //     chart.cursor = new am4charts.XYCursor();
  //     chart.exporting.menu = new am4core.ExportMenu();
  //     chart.exporting.filePrefix = "avisa";
  //   }); // end am4core.ready()
  // }
  communicationApproachesChart() {
    $("#program_wise_no_of_communication").html("");
    const communication_approaches = this.poOneData.communication_approaches_country;
    $("#program_wise_no_of_communication_count").html(
      communication_approaches.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!communication_approaches?.length) {
      $("#program_wise_no_of_communication").html(nodata_html());
      return;
    }

    // am4core.ready(function () {
    //   // Themes begin
    //   am4core.useTheme(am4themes_animated);
    //   // Themes end

    //   // Create chart instance
    //   var chart = am4core.create(
    //     "program_wise_no_of_communication",
    //     am4charts.XYChart
    //   );
    //   chart.logo.disabled = "true";
    //   chart.scrollbarX = new am4core.Scrollbar();

    //   // Add data
    //   chart.data = communication_approaches;

    //   // Create value axis
    //   var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //   valueAxis.title.text = "Number of communication approaches";
    //   valueAxis.title.fontWeight = "bold";

    //   // Create axes
    //   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //   categoryAxis.dataFields.category = "program_name";
    //   categoryAxis.renderer.grid.template.location = 0;
    //   categoryAxis.renderer.minGridDistance = 0;
    //   categoryAxis.renderer.labels.template.rotation = 270;
    //   categoryAxis.renderer.labels.template.horizontalCenter = "middle";
    //   categoryAxis.renderer.labels.template.verticalCenter = "middle";

    //   // Configure axis label
    //   var label = categoryAxis.renderer.labels.template;
    //   //label.truncate = true;
    //   //label.maxWidth = 120;
    //   label.tooltipText = "{program_name}";

    //   // Create series
    //   var series = chart.series.push(new am4charts.ColumnSeries());
    //   series.sequencedInterpolation = true;
    //   series.dataFields.valueY = "count";
    //   series.dataFields.categoryX = "program_name";
    //   series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
    //   series.columns.template.strokeWidth = 0;

    //   series.tooltip.pointerOrientation = "vertical";

    //   series.columns.template.column.cornerRadiusTopLeft = 10;
    //   series.columns.template.column.cornerRadiusTopRight = 10;
    //   series.columns.template.column.fillOpacity = 0.8;

    //   // on hover, make corner radiuses bigger
    //   var hoverState = series.columns.template.column.states.create("hover");
    //   hoverState.properties.cornerRadiusTopLeft = 0;
    //   hoverState.properties.cornerRadiusTopRight = 0;
    //   hoverState.properties.fillOpacity = 1;

    //   var bullet = series.bullets.push(new am4charts.LabelBullet());
    //   bullet.interactionsEnabled = false;
    //   bullet.dy = -10;
    //   bullet.label.text = "{valueY}";
    //   bullet.label.fontSize = "13px";
    //   bullet.label.fill = am4core.color("#000");

    //   series.columns.template.adapter.add("fill", function (fill, target) {
    //     return chart.colors.getIndex(target.dataItem.index);
    //   });

    //   // Cursor
    //   chart.cursor = new am4charts.XYCursor();
    //   chart.exporting.menu = new am4core.ExportMenu();
    //   chart.exporting.filePrefix = "avisa";
    // }); // end am4core.ready()

    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("program_wise_no_of_communication", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = communication_approaches;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of communication approaches";
      valueAxis.title.fontWeight = "bold";
      valueAxis.renderer.minGridDistance = 1000;
      valueAxis.min = 0;

      // valueAxis.strictMinMax = true;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 0;
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
    }); // end am4core.ready()
  }
  hybridVarietyReleasedChart() {
    //Graph -7
    $("#program_varietyreleased").html("");

    const hybrid_opv_spv_data = this.poOneData.hybrid_opv_spv_data;
    if (!hybrid_opv_spv_data?.length) {
      $("#program_varietyreleased").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("program_varietyreleased", am4charts.XYChart);
      chart.logo.disabled = "true";

      chart.marginRight = 400;

      // Add data
      chart.data = hybrid_opv_spv_data;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      // categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Varieties released";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "hybrid";
      series.dataFields.categoryX = "program_name";
      series.name = "Hybrid varieties";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "opv";
      series2.dataFields.categoryX = "program_name";
      series2.name = "OPV varieties";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      var series3 = chart.series.push(new am4charts.ColumnSeries());
      series3.dataFields.valueY = "spv";
      series3.dataFields.categoryX = "program_name";
      series3.name = "SPV varieties";
      series3.tooltipText = "{name}: [bold]{valueY}[/]";
      series3.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
  onStationOnYieldChart() {
    //Graph-8
    $("#programwise_onstation_onfarm_yield").html("");
    const program_onfarm_onstation = this.poOneData.verity_onfarm_onstation;
    if (!program_onfarm_onstation?.length) {
      $("#programwise_onstation_onfarm_yield").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      var chart = am4core.create(
        "programwise_onstation_onfarm_yield",
        am4charts.XYChart
      );
      chart.colors.step = 2;
      chart.logo.disabled = "true";

      chart.legend = new am4charts.Legend();
      chart.legend.position = "bottom";
      chart.legend.paddingBottom = 20;
      chart.legend.labels.template.maxWidth = 95;

      var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      xAxis.dataFields.category = "program_name";
      xAxis.renderer.cellStartLocation = 0.1;
      xAxis.renderer.cellEndLocation = 0.9;
      xAxis.renderer.grid.template.location = 0;
      xAxis.renderer.labels.template.rotation = 270;

      var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
      yAxis.min = 0;
      yAxis.title.text = "Yield (tons/ha)";
      yAxis.title.fontWeight = 800;

      function createSeries(value, name) {
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = value;
        series.dataFields.categoryX = "program_name";
        series.name = name;
        series.tooltipText = "{name}-{valueY}";

        series.events.on("hidden", arrangeColumns);
        series.events.on("shown", arrangeColumns);

        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.interactionsEnabled = false;
        bullet.dy = -20;
        bullet.label.text = "{valueY}";
        bullet.label.fontSize = 14;
        bullet.label.truncate = false;
        bullet.label.hideOversized = false;
        //bullet.label.fill = am4core.color('#ffffff')

        return series;
      }

      chart.data = program_onfarm_onstation;

      createSeries("onstation", "On-station yield");
      createSeries("onfarm", "On-farm yield");

      function arrangeColumns() {
        var series = chart.series.getIndex(0);

        var w =
          1 -
          xAxis.renderer.cellStartLocation -
          (1 - xAxis.renderer.cellEndLocation);
        if (series.dataItems.length > 1) {
          var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
          var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
          var delta = ((x1 - x0) / chart.series.length) * w;
          if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function (series) {
              if (!series.isHidden && !series.isHiding) {
                series.dummyData = newIndex;
                newIndex++;
              } else {
                series.dummyData = chart.series.indexOf(series);
              }
            });
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function (series) {
              var trueIndex = chart.series.indexOf(series);
              var newIndex = series.dummyData;

              var dx = (newIndex - trueIndex + middle - newMiddle) * delta;

              series.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
              series.bulletsContainer.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
            });
          }
        }
      }

      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }
  mappingVarietynameVarietytargetTable() {
    var mydata = this.poOneData.platforms_developed_table;
    //console.log(mydata);
    const tableData= mydata.map(d =>{
      const result=`
      <tr>
        <td>${d.platform_name}</td>
        <td>${d.deployment_location}</td>
        <td>${d.devlopment_location}</td>
        <td>${d.before_facility}</td>
        <td>${d.after_facility}</td>
      </tr>
      `;
      return result;
    })

    //const phenotypingCount = mydata.map(d=> Number(d.after_facility) + Number(d.before_facility)).reduce((a,b)=> a+b)
    $('#phenotypingCount').html(mydata.length)


    $('#resultpo12>tbody').html(tableData);
    $("tbody>tr").addClass("tbl_bg");
   
  }

  geographicalScopeWiseChart() {
    //Graph-8
    $("#geographical_scope_wise_graph").html("");
    const geographical_scope_wise = this.poOneData.geographical_scope_wise;
    if (!geographical_scope_wise?.length) {
      $("#geographical_scope_wise_graph").html(nodata_html());
      return;
    }
    const chartData = geographical_scope_wise.filter(e => (e.regional_count+e.national_count) != 0 );

    // debugger
    //console.log(geographical_scope_wise);
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      var chart = am4core.create(
        "geographical_scope_wise_graph",
        am4charts.XYChart
      );
      chart.colors.step = 2;
      chart.logo.disabled = "true";

      chart.legend = new am4charts.Legend();
      chart.legend.position = "bottom";
      chart.legend.paddingBottom = 20;
      chart.legend.labels.template.maxWidth = 95;

      var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      xAxis.dataFields.category = "program_name";
      xAxis.renderer.cellStartLocation = 0.1;
      xAxis.renderer.cellEndLocation = 0.9;
      xAxis.renderer.grid.template.location = 0;
      xAxis.renderer.labels.template.rotation = 270;
      xAxis.renderer.minGridDistance = 0;
      xAxis.renderer.labels.template.horizontalCenter = "bottom";
      xAxis.renderer.labels.template.verticalCenter = "middle";

      var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
      yAxis.min = 0;
      // yAxis.title.text = "Yield (kg/ ha)";
      yAxis.title.text = "Number of trials";
      yAxis.title.fontWeight = 800;

      function createSeries(value, name) {
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = value;
        series.dataFields.categoryX = "program_name";
        series.name = name;
        series.tooltipText = "{name}-{valueY}";

        series.events.on("hidden", arrangeColumns);
        series.events.on("shown", arrangeColumns);

        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.interactionsEnabled = false;
        bullet.dy = -20;
        bullet.label.text = "{valueY}";
        bullet.label.fontSize = 14;
        bullet.label.truncate = false;
        bullet.label.hideOversized = false;
        //bullet.label.fill = am4core.color('#ffffff')

        return series;
      }

      //chart.data = geographical_scope_wise;
      chart.data = chartData;

      createSeries("regional_count", "Regional");
      createSeries("national_count", "National");
      //createSeries("reginal_national_count", "Regional and National");

      function arrangeColumns() {
        var series = chart.series.getIndex(0);

        var w =
          1 -
          xAxis.renderer.cellStartLocation -
          (1 - xAxis.renderer.cellEndLocation);
        if (series.dataItems.length > 1) {
          var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
          var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
          var delta = ((x1 - x0) / chart.series.length) * w;
          if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function (series) {
              if (!series.isHidden && !series.isHiding) {
                series.dummyData = newIndex;
                newIndex++;
              } else {
                series.dummyData = chart.series.indexOf(series);
              }
            });
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function (series) {
              var trueIndex = chart.series.indexOf(series);
              var newIndex = series.dummyData;

              var dx = (newIndex - trueIndex + middle - newMiddle) * delta;

              series.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
              series.bulletsContainer.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
            });
          }
        }
      }

      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }

  generateNptSankeyGraph() {
    $("#program_wise_graph_six").html("");
    const npt_rawdata = clone(this.poOneData.npt_rawdata);
    // debugger

    npt_rawdata.forEach((d) => {
      const formData = JSON.parse(d.form_data);
      Object.keys(formData).forEach((e) => (d[e] = formData[e]));
    });
    const toList = Array.from(
      new Set(npt_rawdata.map((d) => d.field_36))
    );
    const countryList = Array.from(
      new Set(npt_rawdata.map((d) => d.country_name))
    );
    const cropList = Array.from(
      new Set(npt_rawdata.map((d) => d.crop_name))
    );
    // const chartData = countryList.map((country) => {
    //   return cropList.map((crop) => {
    //     return toList.map((to) => {
    //       const val = npt_rawdata.filter(
    //         (d) =>
    //           d.country_name == country &&
    //           d.crop_name == crop &&
    //           d.field_36 == to
    //       ).length;
    //       return { from: `${country}-${crop}`, to: to, value: val, width: 10 };
    //     });
    //   });
    // }).flat().flat().filter(d => d.value);
    const chartData = countryList.map((country) => {
      return cropList.map((crop) => {
        return toList.map((to) => {
          const val = npt_rawdata.filter(
            (d) =>
              d.country_name == country &&
              d.crop_name == crop &&
              d.field_36 == to
          ).length;
          const result = { program_name: `${country}-${crop}` };
          result[to] = val;
          return result;
        }).reduce((v1, v2) => Object.assign(v1, v2));
      });
    }).flat().filter(d => {
      return Object.keys(d).filter(e => e != 'program_name').some(e => d[e]);
    });

    chartData.forEach(d => {
      const keys = Object.keys(d).forEach(key => {
        if (!d[key]) {
          delete d[key];
        }
      });
    });



    if (!chartData?.length) {
      $("#program_wise_graph_six").html(nodata_html());
      return;
    }

    const seriesList = Array.from(new Set(chartData.map(d => Object.keys(d).filter(key => key != 'program_name')).flat()))

    // am4core.ready(function() {

    //   // Themes begin
    //   am4core.useTheme(am4themes_animated);
    //   // Themes end

    //   // Create chart instance
    //   var chart = am4core.create("program_wise_graph_six", am4charts.XYChart);
    //   chart.logo.disabled = 'true'


    //   // Add data
    //   // log
    //   chart.data = chartData

    //   // Create axes
    //   var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
    //   categoryAxis.dataFields.category = "program_name";
    //   categoryAxis.renderer.grid.template.location = 0;
    //   categoryAxis.renderer.minGridDistance = 20;


    //   var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
    //   valueAxis.renderer.inside = true;
    //   valueAxis.renderer.labels.template.disabled = true;
    //   valueAxis.min = 0;
    //   valueAxis.extraMax = 0.1;
    //   valueAxis.calculateTotals = true;

    //   // Create series
    //   function createSeries(field, name) {

    //     // Set up series
    //     var series = chart.series.push(new am4charts.ColumnSeries());
    //     series.name = name;
    //     series.dataFields.valueX = field;
    //     series.dataFields.categoryY = "program_name";
    //     series.sequencedInterpolation = true;

    //     // Make it stacked
    //     series.stacked = true;

    //     // Configure columns
    //     series.columns.template.width = am4core.percent(60);
    //     series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryY}: {valueX}";

    //     // Add label
    //     var labelBullet = series.bullets.push(new am4charts.LabelBullet());
    //     // labelBullet.label.text = "{valueY}";
    //     labelBullet.locationY = 0.5;
    //     labelBullet.label.hideOversized = true;

    //     return series;
    //   }
    //   seriesList.forEach(d=> createSeries(d,d.replace(/&#44;/g,',')));
    //   // createSeries("europe", "Europe");
    //   // createSeries("namerica", "North America");
    //   // createSeries("asia", "Asia-Pacific");
    //   // createSeries("lamerica", "Latin America");
    //   // createSeries("meast", "Middle-East");
    //   // createSeries("africa", "Africa");

    //   // Create series for total  

    // var totalSeries = chart.series.push(new am4charts.ColumnSeries());
    // totalSeries.dataFields.valueX = "none";
    // totalSeries.dataFields.categoryY = "program_name";
    // totalSeries.stacked = true;
    // totalSeries.hiddenInLegend = true;
    // totalSeries.columns.template.strokeOpacity = 0;

    // var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
    // totalBullet.dx = 20;
    // totalBullet.label.text = "{valueX.total}";
    // totalBullet.label.hideOversized = false;
    // totalBullet.label.fontSize = 10;
    // totalBullet.label.background.fill = totalSeries.stroke;
    // totalBullet.label.background.fillOpacity = 0.2;
    // totalBullet.label.padding(15, 15, 15, 15);

    //   // Legend
    //   chart.legend = new am4charts.Legend();

    //   }); // end am4core.ready()


    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("program_wise_graph_six", am4charts.XYChart);
      chart.logo.disabled = 'true'


      // Add data
      chartData.forEach(d => d.none = 0)
      chart.data = chartData

      // Create axes
      var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;


      var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
      valueAxis.renderer.inside = true;
      valueAxis.renderer.labels.template.disabled = true;
      valueAxis.min = 0;
      valueAxis.extraMax = 0.1;
      valueAxis.calculateTotals = true;

      // Create series
      function createSeries(field, name) {

        // Set up series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.name = name;
        series.dataFields.valueX = field;
        series.dataFields.categoryY = "program_name";
        series.sequencedInterpolation = true;

        // Make it stacked
        series.stacked = true;

        // Configure columns
        series.columns.template.width = am4core.percent(60);
        series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryY}: {valueX}";

        // Add label
        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        // labelBullet.label.text = "{valueY}";
        labelBullet.locationY = 0.5;
        labelBullet.label.hideOversized = true;

        return series;
      }
      seriesList.forEach(d => createSeries(d, d.replace(/&#44;/g, ',')));
      // createSeries("europe", "Europe");
      // createSeries("namerica", "North America");
      // createSeries("asia", "Asia-Pacific");
      // createSeries("lamerica", "Latin America");
      // createSeries("meast", "Middle-East");
      // createSeries("africa", "Africa");


      // Create series for total  valueAxis.extraMax = 0.1;
      // valueAxis.calculateTotals = true;

      var totalSeries = chart.series.push(new am4charts.ColumnSeries());
      totalSeries.dataFields.valueX = "none";
      totalSeries.dataFields.categoryY = "program_name";
      totalSeries.stacked = true;
      totalSeries.hiddenInLegend = true;
      totalSeries.columns.template.strokeOpacity = 0;

      var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
      totalBullet.dx = 20;
      totalBullet.label.text = "{valueX.total}";
      totalBullet.label.hideOversized = false;
      totalBullet.label.truncate = false;

      totalBullet.label.fontSize = 10;

      totalBullet.label.background.fill = totalSeries.stroke;
      totalBullet.label.background.fillOpacity = 0.2;
      totalBullet.label.padding(10, 10, 10, 10);
      // Legend

      chart.legend = new am4charts.Legend();

    }); // end am4core.ready()



    // am4core.ready(function () {
    //   am4core.useTheme(am4themes_animated);
    //   var chart = am4core.create("program_wise_graph_six", am4charts.SankeyDiagram);
    //   chart.hiddenState.properties.opacity = 0;
    //   chart.logo.disabled = 'true'


    //   // console.log(chartData);

    //   chart.data = chartData


    //   let hoverState = chart.links.template.states.create("hover");
    //   hoverState.properties.fillOpacity = 0.6;

    //   chart.dataFields.fromName = "from";
    //   chart.dataFields.toName = "to";
    //   chart.dataFields.value = "value";
    //   chart.dataFields.color = "nodeColor";

    //   chart.paddingRight = 120;

    //   var nodeTemplate = chart.nodes.template;
    //   nodeTemplate.inert = true;
    //   nodeTemplate.readerTitle = "Drag me!";
    //   nodeTemplate.showSystemTooltip = true;
    //   nodeTemplate.width = 20;

    //   nodeTemplate.propertyFields.width = "width";

    //   var nodeTemplate = chart.nodes.template;
    //   nodeTemplate.readerTitle = "Click to show/hide or drag to rearrange";
    //   nodeTemplate.showSystemTooltip = true;
    //   nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer
    //   chart.exporting.menu = new am4core.ExportMenu();
    //   chart.exporting.filePrefix = "avisa";

    // });
  }

  generateDusSankeyGraph() {
    $("#program_wise_graph_five").html("");
    const dus_rowdata = clone(this.poOneData.dus_rawdata);
    dus_rowdata.forEach((d) => {
      const formData = JSON.parse(d.form_data);
      Object.keys(formData).forEach((e) => (d[e] = formData[e]));
    });
    const toList = Array.from(
      new Set(dus_rowdata.map((d) => d.field_41))
    );
    const countryList = Array.from(
      new Set(dus_rowdata.map((d) => d.country_name))
    );
    const cropList = Array.from(
      new Set(dus_rowdata.map((d) => d.crop_name))
    );
    // const chartData = countryList.map((country) => {
    //   return cropList.map((crop) => {
    //     return toList.map((to) => {
    //       const val = dus_rowdata.filter(
    //         (d) =>
    //           d.country_name == country &&
    //           d.crop_name == crop &&
    //           d.field_41 == to
    //       ).length;
    //       return { from: `${country}-${crop}`, to: to, value: val, width: 10 };
    //     });
    //   });
    // }).flat().flat().filter(d => d.value);;
    // if (!dus_rowdata?.length) {
    //   $("#program_wise_graph_five").html(nodata_html());
    //   return;
    // }

    const chartData = countryList.map((country) => {
      return cropList.map((crop) => {
        return toList.map((to) => {
          const val = dus_rowdata.filter(
            (d) =>
              d.country_name == country &&
              d.crop_name == crop &&
              d.field_41 == to
          ).length;
          const result = { program_name: `${country}-${crop}` };
          result[to] = val;
          return result;
        }).reduce((v1, v2) => Object.assign(v1, v2));
      });
    }).flat().filter(d => {
      return Object.keys(d).filter(e => e != 'program_name').some(e => d[e]);
    });

    chartData.forEach(d => {
      const keys = Object.keys(d).forEach(key => {
        if (!d[key]) {
          delete d[key];
        }
      });
    });



    if (!chartData?.length) {
      $("#program_wise_graph_five").html(nodata_html());
      return;
    }

    const seriesList = Array.from(new Set(chartData.map(d => Object.keys(d).filter(key => key != 'program_name')).flat()))


    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("program_wise_graph_five", am4charts.XYChart);
      chart.logo.disabled = 'true'


      // Add data
      chartData.forEach(d => d.none = 0)
      chart.data = chartData

      // Create axes
      var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;


      var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
      valueAxis.renderer.inside = true;
      valueAxis.renderer.labels.template.disabled = true;
      valueAxis.min = 0;
      valueAxis.extraMax = 0.1;
      valueAxis.calculateTotals = true;

      // Create series
      function createSeries(field, name) {

        // Set up series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.name = name;
        series.dataFields.valueX = field;
        series.dataFields.categoryY = "program_name";
        series.sequencedInterpolation = true;

        // Make it stacked
        series.stacked = true;

        // Configure columns
        series.columns.template.width = am4core.percent(60);
        series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryY}: {valueX}";

        // Add label
        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        // labelBullet.label.text = "{valueY}";
        labelBullet.locationY = 0.5;
        labelBullet.label.hideOversized = true;

        return series;
      }
      seriesList.forEach(d => createSeries(d, d.replace(/&#44;/g, ',')));
      // createSeries("europe", "Europe");
      // createSeries("namerica", "North America");
      // createSeries("asia", "Asia-Pacific");
      // createSeries("lamerica", "Latin America");
      // createSeries("meast", "Middle-East");
      // createSeries("africa", "Africa");


      // Create series for total  valueAxis.extraMax = 0.1;
      // valueAxis.calculateTotals = true;

      var totalSeries = chart.series.push(new am4charts.ColumnSeries());
      totalSeries.dataFields.valueX = "none";
      totalSeries.dataFields.categoryY = "program_name";
      totalSeries.stacked = true;
      totalSeries.hiddenInLegend = true;
      totalSeries.columns.template.strokeOpacity = 0;

      var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
      totalBullet.dx = 20;
      totalBullet.label.text = "{valueX.total}";
      totalBullet.label.hideOversized = false;
      totalBullet.label.truncate = false;
      totalBullet.label.fontSize = 10;
      totalBullet.label.background.fill = totalSeries.stroke;
      totalBullet.label.background.fillOpacity = 0.2;
      totalBullet.label.padding(10, 10, 10, 10);
      // Legend

      chart.legend = new am4charts.Legend();

    }); // end am4core.ready()
    // am4core.ready(function () {
    //   am4core.useTheme(am4themes_animated);
    //   var chart = am4core.create(
    //     "program_wise_graph_five",
    //     am4charts.SankeyDiagram
    //   );
    //   chart.hiddenState.properties.opacity = 0;
    //   chart.logo.disabled = "true";

    //   //   chart.data = [
    //   //     {
    //   //       from: "Tanzania-Common bean",
    //   //       to: "Nutrition",
    //   //       value: 20,
    //   //       nodeColor: "#d79494",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Tanzania-Common bean",
    //   //       to: "Abiotic stress tolerance",
    //   //       value: 20,
    //   //       nodeColor: "#82cee4",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Tanzania-Common bean",
    //   //       to: "Biotic stress tolerance",
    //   //       value: 7,
    //   //       nodeColor: "#843ff4",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Tanzania-Common bean",
    //   //       to: "Grain Yield",
    //   //       value: 7,
    //   //       nodeColor: "#f98988",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Nigeria-Cowpea",
    //   //       to: "Early Maturity",
    //   //       value: 17,
    //   //       nodeColor: "#45b4c6",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "WCA-Cowpea",
    //   //       to: "Abiotic stress tolerance",
    //   //       value: 25,
    //   //       nodeColor: "#f9d533",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "WCA-Cowpea",
    //   //       to: "Biotic stress tolerance",
    //   //       value: 4,
    //   //       nodeColor: "#ec64a3",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "WCA-Cowpea",
    //   //       to: "Grain Yield",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Burkina Faso-Pearl millet",
    //   //       to: "Other",
    //   //       value: 18,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Uganda-Sorghum",
    //   //       to: "Grain",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Uganda-Sorghum",
    //   //       to: "Other",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Uganda-Sorghum",
    //   //       to: "Grain Yield",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Uganda-Sorghum",
    //   //       to: "Biotic stress tolerance",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Uganda-Sorghum",
    //   //       to: "Early Maturity",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Burkina Faso-Sorghum",
    //   //       to: "Abiotic stress tolerance",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Burkina Faso-Sorghum",
    //   //       to: "Culinary",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Burkina Faso-Sorghum",
    //   //       to: "Grain Yield",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     {
    //   //       from: "Burkina Faso-Sorghum",
    //   //       to: "Biotic stress tolerance",
    //   //       value: 8,
    //   //       nodeColor: "#4dabf5",
    //   //       width: 10,
    //   //     },
    //   //     //{ from: "Germplasm", to: "Goal 4", value: 20 }
    //   //   ];

    //   chart.data = chartData;
    //   let hoverState = chart.links.template.states.create("hover");
    //   hoverState.properties.fillOpacity = 0.6;

    //   chart.dataFields.fromName = "from";
    //   chart.dataFields.toName = "to";
    //   chart.dataFields.value = "value";
    //   chart.dataFields.color = "nodeColor";

    //   chart.paddingRight = 120;

    //   var nodeTemplate = chart.nodes.template;
    //   nodeTemplate.inert = true;
    //   nodeTemplate.readerTitle = "Drag me!";
    //   nodeTemplate.showSystemTooltip = true;
    //   nodeTemplate.width = 20;

    //   nodeTemplate.propertyFields.width = "width";

    //   var nodeTemplate = chart.nodes.template;
    //   nodeTemplate.readerTitle = "Click to show/hide or drag to rearrange";
    //   nodeTemplate.showSystemTooltip = true;
    //   nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer;

    //   chart.exporting.menu = new am4core.ExportMenu();
    //   chart.exporting.filePrefix = "avisa";
    // });
  }

  generateHybridSvpSankeyGraph() {
    $("#program_traits_hybrid_opv_spv").html("");
    const hybrid_opv_spv_rawdata = clone(this.poOneData.hybrid_opv_spv_rawdata);
    hybrid_opv_spv_rawdata.forEach((d) => {
      const formData = JSON.parse(d.form_data);
      Object.keys(formData).forEach((e) => (d[e] = formData[e]));
    });
    const toList = Array.from(
      new Set(hybrid_opv_spv_rawdata.map((d) => d.field_46))
    );
    const countryList = Array.from(
      new Set(hybrid_opv_spv_rawdata.map((d) => d.country_name))
    );
    const cropList = Array.from(
      new Set(hybrid_opv_spv_rawdata.map((d) => d.crop_name))
    );
    const chartData = countryList.map((country) => {
      return cropList.map((crop) => {
        return toList.map((to) => {
          const val = hybrid_opv_spv_rawdata.filter(
            (d) =>
              d.country_name == country &&
              d.crop_name == crop &&
              d.field_46 == to
          ).length;
          return { from: `${country}-${crop}`, to: to, value: val, width: 10 };
        });
      });
    }).flat().flat().filter(d => d.value);
    if (!hybrid_opv_spv_rawdata?.length) {
      $("#program_traits_hybrid_opv_spv").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      am4core.useTheme(am4themes_animated);
      var chart = am4core.create("program_traits_hybrid_opv_spv", am4charts.SankeyDiagram);
      chart.hiddenState.properties.opacity = 0;
      chart.logo.disabled = 'true'
      chart.data = chartData


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
      chart.exporting.filePrefix = "avisa";

    });
  }

  generateBreedinglinesSankeyGraph() {
    $("#breeder_sanky").html("");
    const breedinglines_exchanged_rawdata = clone(this.poOneData.breedinglines_exchanged_rawdata);
    breedinglines_exchanged_rawdata.forEach((d) => {
      const formData = JSON.parse(d.form_data);
      Object.keys(formData).forEach((e) => (d[e] = formData[e]));
    });
    const toList = Array.from(
      new Set(breedinglines_exchanged_rawdata.map((d) => d.field_424))
    );
    const countryList = Array.from(
      new Set(breedinglines_exchanged_rawdata.map((d) => d.country_name))
    );
    const cropList = Array.from(
      new Set(breedinglines_exchanged_rawdata.map((d) => d.crop_name))
    );

    const chartData = countryList.map((country) => {
      return cropList.map((crop) => {
        return toList.map((to) => {
          const val = breedinglines_exchanged_rawdata.filter(
            (d) =>
              d.country_name == country &&
              d.crop_name == crop &&
              d.field_424 == to
          ).length;
          if (to) {
            return to.split("&#44;").map(t=> {
              return { from: `${country}-${crop}`, to: t, value: val, width: 10 };
            })
          } else {
            return []
          }
        });
      });
    }).flat().flat().flat().filter(d => d.value);
    if (!breedinglines_exchanged_rawdata?.length) {
      $("#breeder_sanky").html(nodata_html());
      return;
    }

    //debugger

    am4core.ready(function () {
      am4core.useTheme(am4themes_animated);
      var chart = am4core.create("breeder_sanky", am4charts.SankeyDiagram);
      chart.hiddenState.properties.opacity = 0;
      chart.logo.disabled = 'true'
      chart.data = chartData


      let hoverState = chart.links.template.states.create("hover");
      hoverState.properties.fillOpacity = 0.6;

      chart.dataFields.fromName = "from";
      chart.dataFields.toName = "to";
      chart.dataFields.value = "value";
      chart.dataFields.color = "nodeColor";

      chart.paddingRight = 250;
      chart.paddingTop = 30;

      chart.nodes.template.nameLabel.label.wrap = true;
			chart.nodes.template.nameLabel.label.truncate = false;

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
      chart.exporting.filePrefix = "avisa";

    });
  }

  rich_piechart(divid, data) {
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
      pieSeries.dataFields.category = "program_name";
      pieSeries.slices.template.stroke = am4core.color("#fff");
      pieSeries.slices.template.strokeWidth = 2;
      pieSeries.slices.template.strokeOpacity = 1;
      pieSeries.labels.template.fontSize = 10;
      pieSeries.labels.template.maxWidth = 90;
      pieSeries.labels.template.wrap = false;
      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      pieSeries.hiddenState.properties.endAngle = -80;
      pieSeries.hiddenState.properties.startAngle = -80;



    });
  }
  rich_piechart1(divid, data) {
    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(divid, am4charts.PieChart);
      chart.legend = new am4charts.Legend();
      //chart.legend.maxHeight = 150;
      //chart.legend.scrollable = true;
      chart.logo.disabled = 'true'
      // Add data
      chart.data = data;

      // Add and configure Series
      var pieSeries = chart.series.push(new am4charts.PieSeries());
      pieSeries.dataFields.value = "count";
      pieSeries.dataFields.category = "program_name";
      pieSeries.slices.template.stroke = am4core.color("#fff");
      pieSeries.slices.template.strokeWidth = 2;
      pieSeries.slices.template.strokeOpacity = 1;
      // pieSeries.labels.template.fontSize = 13;
      pieSeries.labels.template.fontWeight = 400;

      pieSeries.labels.template.maxWidth = 150;
      pieSeries.labels.template.wrap = true;
      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      // pieSeries.hiddenState.properties.endAngle = -70;
      // pieSeries.hiddenState.properties.startAngle = -70;
      pieSeries.legendSettings.labelText = "[bold {color}]{name}[/] - [bold {color}]{value}[/]";

      chart.scrollbarX = new am4core.Scrollbar();
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";

    });
  }

  // rcihwiseprotocolsDevelopedChart() {
  //   // debugger;
  //   $("#rcih_wise_graph_one").html("");
  //   const protocols_developed = this.richdata.protocols_developed;
  //   $("#rcih_wise_protocols_developed_count").html(
  //     protocols_developed.map((e) => e.count).reduce((a, b) => a + b, 0)
  //   );
  //   if(!protocols_developed?.length){
  //     $("#rcih_wise_graph_one").html(nodata_html());
  //     return;
  //   }
  //   this.rich_piechart("rcih_wise_graph_one", protocols_developed)

  // }

  richwisegenerationsAchievedChart() {
    $("#rcih_wise_graph_two").html("");
    const generationsachieved = this.richdata.generationsachieved;
    let commercialized_varieties_counts = generationsachieved.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    let values = (commercialized_varieties_counts / generationsachieved.length).toFixed(2);
    $("#rcih_wise_generationsachieved_count").html(values);
    if (!generationsachieved?.length) {
      $("#rcih_wise_graph_two").html(nodata_html());
      return;
    }
    //Graph - 2
    this.rich_piechart("rcih_wise_graph_two", generationsachieved)

  }

  rcihwisefixedlinesDevelopedChart() {
    $("#rcih_wise_graph_three").html("");
    const fixedlines_developed = this.richdata.fixedlines_developed;
    $("#rcih_wise_developed_count").html(
      fixedlines_developed.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!fixedlines_developed?.length) {
      $("#rcih_wise_graph_three").html(nodata_html());
      return;
    }
    this.rich_piechart("rcih_wise_graph_three", fixedlines_developed)

  }

  // richwisebreedinglinesExchangedChart() {
  //   $("#rcih_wise_graph_four").html("");
  //   const breedinglines_exchanged = this.richdata.breedinglines_exchanged;
  //   $("#rcih_wise_breedinglines_exchanged_count").html(
  //     breedinglines_exchanged.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
  //   );
  //   if(!breedinglines_exchanged?.length){
  //     $("#rcih_wise_graph_four").html(nodata_html());
  //     return;
  //   }
  //   this.rich_piechart("rcih_wise_graph_four", breedinglines_exchanged)

  // }
  cropwisebreedinglinesExchangedChart() {
    $("#crop_wise_graph_four").html("");
    // const breedinglines_exchanged_crop = clone(this.poOneData.breedinglines_exchanged_crop);
    const breedinglines_exchanged_crop = this.poOneData.breedinglines_exchanged_crop;
    breedinglines_exchanged_crop.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });
    const programList = Array.from(new Set(breedinglines_exchanged_crop.map(d => d.program_name)));
    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = breedinglines_exchanged_crop.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });

    $("#rcih_wise_breedinglines_exchanged_count").html(
      chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!chartData?.length) {
      $("#crop_wise_graph_four").html(nodata_html());
      return;
    }
    this.rich_piechart1("crop_wise_graph_four", chartData)

  }
  richwisehybridVarietyReleasedChart() {
    //Graph -7
    $("#rcih_wise_varietyreleased").html("");

    const hybrid_opv_spv_data = this.richdata.hybrid_opv_spv_data;
    if (!hybrid_opv_spv_data?.length) {
      $("#rcih_wise_varietyreleased").html(nodata_html());
      return;
    }
    //console.log(hybrid_opv_spv_data);
    //this.rich_piechart("rcih_wise_varietyreleased",hybrid_opv_spv_data)
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("rcih_wise_varietyreleased", am4charts.XYChart);
      chart.logo.disabled = "true";

      chart.marginRight = 400;

      // Add data
      chart.data = hybrid_opv_spv_data;

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      //categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Varieties released";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "hybrid";
      series.dataFields.categoryX = "program_name";
      series.name = "Hybrid varieties";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "opv";
      series2.dataFields.categoryX = "program_name";
      series2.name = "OPV varieties";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      var series3 = chart.series.push(new am4charts.ColumnSeries());
      series3.dataFields.valueY = "spv";
      series3.dataFields.categoryX = "program_name";
      series3.name = "SPV varieties";
      series3.tooltipText = "{name}: [bold]{valueY}[/]";
      series3.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  // richwisemultiLocationtrialsChart() {
  //   $("#rcih_wise_multi_locational_trials").html("");
  //   const multi_locationtrials = this.richdata.multi_locationtrials;
  //   $("#rcih_wise_multi_locational_trials_count").html(
  //     multi_locationtrials.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
  //   );
  //   if(!multi_locationtrials?.length){
  //     $("#rcih_wise_multi_locational_trials").html(nodata_html());
  //     return;
  //   }
  //   this.rich_piechart("rcih_wise_multi_locational_trials", multi_locationtrials)

  // }
  cropwisemultiLocationtrialsChart() {
    $("#crop_wise_multi_locational_trials").html("");
    const multi_locationtrials_crop = clone(this.poOneData.multi_locationtrials_crop);
    multi_locationtrials_crop.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });
    const programList = Array.from(new Set(multi_locationtrials_crop.map(d => d.program_name)));
    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = multi_locationtrials_crop.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });


    $("#crop_wise_multi_locational_trials_count").html(
      chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!chartData?.length) {
      $("#crop_wise_multi_locational_trials").html(nodata_html());
      return;
    }
    this.rich_piechart1("crop_wise_multi_locational_trials", chartData)

  }

  managedByMultiLocationtrialsChart() {
    $("#managed_by_multi_locational_trials").html("");
    const multi_locationtrials_managed_by = clone(this.poOneData.multi_locationtrials_managed_by);

    // $("#crop_wise_multi_locational_trials_count").html(
    //   chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    // );
    if (!multi_locationtrials_managed_by?.length) {
      $("#managed_by_multi_locational_trials").html(nodata_html());
      return;
    }
    this.rich_piechart1("managed_by_multi_locational_trials", multi_locationtrials_managed_by)

  }

  richwiseonfarmTrialsChart() {
    $("#rcih_wise_on_farm_trials").html("");
    const onfarm_trials = this.richdata.onfarm_trials;
    $("#rcih_wise_on_farm_trials_count").html(
      onfarm_trials.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!onfarm_trials?.length) {
      $("#rcih_wise_on_farm_trials").html(nodata_html());
      return;
    }
    this.rich_piechart("rcih_wise_on_farm_trials", onfarm_trials)

  }

  rcihwisefpvsDataChart() {
    $("#rcih_wise_multi_fpvs").html();
    const fpvs_data_crop = clone(this.poOneData.fpvs_data_crop);
    fpvs_data_crop.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });
    const programList = Array.from(new Set(fpvs_data_crop.map(d => d.program_name)));
    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = fpvs_data_crop.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });
    $("#rcih_wise_multi_fpvs_count").html(
      chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!chartData?.length) {
      $("#rcih_wise_multi_fpvs").html(nodata_html());
      return;
    }
    this.rich_piechart1("rcih_wise_multi_fpvs", chartData)

  }

  /*rcihwisetricottrialsConductedChart() {
    const tricottrials_conducted = this.richdata.tricottrials_conducted;
    $("#rcih_wise_tricot_trials_count").html(
      tricottrials_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    this.rich_piechart("rcih_wise_tricot_trials", tricottrials_conducted)
    /*am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "rcih_wise_tricot_trials",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = tricottrials_conducted;

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of trials ";
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
    }); // end am4core.ready()
  }*/

  // richwisenewtoolsAdoptedChart() {
  //   $("#rcih_wise_new_tools").html("");
  //   const newtools_adopted = this.richdata.newtools_adopted;
  //   $("#rcih_wise_new_tools_count").html(
  //     newtools_adopted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
  //   );
  //   if(!newtools_adopted?.length){
  //     $("#rcih_wise_new_tools").html(nodata_html());
  //     return;
  //   }
  //   this.rich_piechart("rcih_wise_new_tools", newtools_adopted)
  // }
  cropwisenewtoolsAdoptedChart() {
    $("#crop_wise_new_tools").html("");
    const newtools_adopted = clone(this.poOneData.newtools_adopted_crop);
    newtools_adopted.forEach(d => {
      const esaType = esaDivisonCountry.find(div => d.program_name.includes(div));
      const wcaType = wcaDivisonCountry.find(div => d.program_name.includes(div));
      if (esaType) {
        d.program_name = d.program_name.replace(esaType, 'ESA');
      } else if (wcaType) {
        d.program_name = d.program_name.replace(wcaType, 'WCA');
      }
    });
    const programList = Array.from(new Set(newtools_adopted.map(d => d.program_name)));
    const chartData = programList.map(pName => {
      const result = { program_name: pName };
      // if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
      //   result.program_name = pName?.substring(0, pName?.indexOf('-'))
      // }
      result['count'] = newtools_adopted.filter(d => d.program_name == pName).map(d => d.count).reduce((v1, v2) => v1 + v2, 0);
      return result;
    });

    // $("#crop_wise_new_tools_count").html(
    //   chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    // );
    // if (!chartData?.length) {
    //   $("#crop_wise_new_tools").html(nodata_html());
    //   return;
    // }
    // this.rich_piechart1("crop_wise_new_tools", chartData)
  }

  // richwisecommunicationApproachesChart() {
  //   $("#rcih_wise_no_of_communication").html("");
  //   const communication_approaches = this.richdata.communication_approaches;
  //   $("#rcih_wise_no_of_communication_count").html(
  //     communication_approaches.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
  //   );
  //   if(!communication_approaches?.length){
  //     $("#rcih_wise_no_of_communication").html(nodata_html());
  //     return;
  //   }
  //   this.rich_piechart("rcih_wise_no_of_communication", communication_approaches)

  // }
  cropwisecommunicationApproachesChart() {
    $("#crop_wise_no_of_communication").html("");
    const communication_approaches = this.poOneData.communication_approaches_crop;


    $("#crop_wise_no_of_communication_count").html(
      communication_approaches.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!communication_approaches?.length) {
      $("#crop_wise_no_of_communication").html(nodata_html());
      return;
    }
    this.rich_piechart1("crop_wise_no_of_communication", communication_approaches)

  }



  rcihwiseonStationOnYieldChart() {
    //Graph-8
    $("#rcih_wise_onstation_onfarm_yield").html("");
    const program_onfarm_onstation = this.richdata.program_onfarm_onstation;
    if (!program_onfarm_onstation?.length) {
      $("#rcih_wise_onstation_onfarm_yield").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      var chart = am4core.create(
        "rcih_wise_onstation_onfarm_yield",
        am4charts.XYChart
      );
      chart.colors.step = 2;
      chart.logo.disabled = "true";

      chart.legend = new am4charts.Legend();
      chart.legend.position = "top";
      chart.legend.paddingBottom = 20;
      chart.legend.labels.template.maxWidth = 95;

      var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      xAxis.dataFields.category = "program_name";
      xAxis.renderer.cellStartLocation = 0.1;
      xAxis.renderer.cellEndLocation = 0.9;
      xAxis.renderer.grid.template.location = 0;

      var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
      yAxis.min = 0;
      yAxis.title.text = "Yield (kg/ ha)";
      yAxis.title.fontWeight = 800;

      function createSeries(value, name) {
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = value;
        series.dataFields.categoryX = "program_name";
        series.name = name;

        series.events.on("hidden", arrangeColumns);
        series.events.on("shown", arrangeColumns);

        var bullet = series.bullets.push(new am4charts.LabelBullet());
        bullet.interactionsEnabled = false;
        bullet.dy = -5;
        bullet.label.text = "{valueY}";
        bullet.label.fontSize = 10;
        bullet.label.truncate = false;
        bullet.label.hideOversized = false;
        //bullet.label.fill = am4core.color('#ffffff')

        return series;
      }

      chart.data = program_onfarm_onstation;

      createSeries("onstation", "On-station yield");
      createSeries("onfarm", "On-farm yield");

      function arrangeColumns() {
        var series = chart.series.getIndex(0);

        var w =
          1 -
          xAxis.renderer.cellStartLocation -
          (1 - xAxis.renderer.cellEndLocation);
        if (series.dataItems.length > 1) {
          var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
          var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
          var delta = ((x1 - x0) / chart.series.length) * w;
          if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function (series) {
              if (!series.isHidden && !series.isHiding) {
                series.dummyData = newIndex;
                newIndex++;
              } else {
                series.dummyData = chart.series.indexOf(series);
              }
            });
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function (series) {
              var trueIndex = chart.series.indexOf(series);
              var newIndex = series.dummyData;

              var dx = (newIndex - trueIndex + middle - newMiddle) * delta;

              series.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
              series.bulletsContainer.animate(
                { property: "dx", to: dx },
                series.interpolationDuration,
                series.interpolationEasing
              );
            });
          }
        }
      }

      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    });
  }

  rcihwisemappingVarietynameVarietytargetTable() {
    var mydata = this.poOneData.mapping_varietyname_varietytarget;
    $("#result").bootstrapTable({
      data: mydata,
    });
    $("tbody>tr").addClass("tbl_bg");
  }
}
