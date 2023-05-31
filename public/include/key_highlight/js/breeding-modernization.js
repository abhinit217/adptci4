class BreedingModernization {
  constructor() {
    this.country_lat_lng = [
      {
          "country_name": "Burkina Faso",
          "country_id": "1",
          "lat": 12.232655,
          "lng": -1.170044
      },
      {
          "country_name": "Ethiopia",
          "country_id": "2",
          "lat": 8.91492,
          "lng": 38.884735
      },
      {
          "country_name": "Ghana",
          "country_id": "4",
          "lat": 7.841615,
          "lng": -1.058807
      },
      {
          "country_name": "Mali",
          "country_id": "5",
          "lat": 17.685895,
          "lng": -0.631714
      },
      {
          "country_name": "Nigeria",
          "country_id": "6",
          "lat": 8.809082,
          "lng": 7.487183
      },
      {
          "country_name": "Tanzania",
          "country_id": "8",
          "lat": -6.408107,
          "lng": 34.840393
      },
      {
          "country_name": "Uganda",
          "country_id": "10",
          "lat": 1.472006,
          "lng": 32.450867
      },
      {
          "country_name": "Zimbabwe",
          "country_id": "16",
          "lat": -19.040051,
          "lng": 29.612961
      },
      {
          "country_name": "Angola",
          "country_id": "17",
          "lat": -11.990965,
          "lng": 18.798981
      },
      {
          "country_name": "Cameroon",
          "country_id": "18",
          "lat": 7.396174,
          "lng": 13.588543
      },
      {
          "country_name": "France",
          "country_id": "19",
          "lat": 46.965259,
          "lng": 2.598267
      },
      {
          "country_name": "Kenya",
          "country_id": "20",
          "lat": -0.461421,
          "lng": 37.680359
      },
      {
          "country_name": "Malawi",
          "country_id": "21",
          "lat": -13.304103,
          "lng": 33.74176
      },
      {
          "country_name": "Mozambique",
          "country_id": "22",
          "lat": -18.849112,
          "lng": 34.633026
      },
      {
          "country_name": "Niger",
          "country_id": "24",
          "lat": 17.5564973,
          "lng": 3.5815559
      },
      {
          "country_name": "Philippines",
          "country_id": "25",
          "lat": 12.983148,
          "lng": 122.178955
      },
      {
          "country_name": "Senegal",
          "country_id": "26",
          "lat": 14.689881,
          "lng": -14.80957
      },
      {
          "country_name": "Sierra Leone",
          "country_id": "28",
          "lat": 8.928487,
          "lng": -11.711426
      },
      {
          "country_name": "South Africa",
          "country_id": "29",
          "lat": -29.075375,
          "lng": 23.24707
      },
      {
          "country_name": "Thailand",
          "country_id": "30",
          "lat": 15.870032,
          "lng": 100.992538
      },
      {
          "country_name": "Togo",
          "country_id": "31",
          "lat": 8.563368,
          "lng": 1.10763
      },
      {
          "country_name": "Zambia",
          "country_id": "32",
          "lat": -13.332166,
          "lng": 25.566499
      },
      {
          "country_name": "CHAD",
          "country_id": "33",
          "lat": 15.464269,
          "lng": 18.353949
      }
  ]
    this.getApiData();
  }

  getApiData() {
    const request = { purpose: "BREEDINGMODERNIZATION" };
    showLoader();
    post("dashboard", request).then(response => {
      if (response?.status == 1) {
        this.init(response);
      } else {
        console.error("Error in data");
      }
    }).catch(e => console.error(e)).finally(() => hideLoader());
  }
  init(data) {
    this.apiData = data;
    // location_radial_graph
    this.generateLabels();
    this.generateCharts();
  }

  generateLabels() {
    const hybird_p1 = this.apiData.hybrid_opv_spv_data.map(d => d.hybrid).reduce((a, b) => a + b, 0)
    const opv_p1 = this.apiData.hybrid_opv_spv_data.map(d => d.opv).reduce((a, b) => a + b, 0)
    const spv_p1 = this.apiData.hybrid_opv_spv_data.map(d => d.spv).reduce((a, b) => a + b, 0)

    $("#hybrid").html(hybird_p1)
    $("#opv").html(opv_p1);
    $("#spv").html(spv_p1);
    $("#total_1").html(hybird_p1 + opv_p1 + spv_p1);
    $("#npd_data_count").html(this.apiData.npt_line + this.apiData.npt_hybrid);
    $("#npt_line").html(this.apiData.npt_line);
    $("#npt_hybrid").html(this.apiData.npt_hybrid);
    $("#dus_line").html(this.apiData.dus_line);
    $("#dus_hybrid").html(this.apiData.dus_hybrid);
    $("#dus_total").html(
      this.apiData.dus_hybrid + this.apiData.dus_line
    );
    $("#npd_data_sum").html(this.apiData.npt_line + this.apiData.npt_hybrid + this.apiData.dus_hybrid + this.apiData.dus_line);

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


  }
  generateCharts() {
    setTimeout(() => this.generateSpillOverChart());
    setTimeout(() => this.mappingVarietynameVarietytargetTable());
    setTimeout(() => this.countrywiseDiagnosticChart());
    setTimeout(() => this.countrywiseMarkerAsseyGraphChart());
    setTimeout(() => this.countrywiseMarkerQtlGraphChart());
    setTimeout(() => this.protocolsDevelopedChart());
    setTimeout(() => this.generationsAchievedChart());
    setTimeout(() => this.fixedlinesDevelopedChart());
    setTimeout(() => this.breedinglinesExchangedChart());
    setTimeout(() => this.nptDusCountryChart());
    setTimeout(() => this.nptDusCropChart());
    setTimeout(() => this.hybridVarietyReleasedChart());
    setTimeout(() => this.generateHybridSvpSankeyGraph());
    setTimeout(() => this.rcihwisemappingVarietynameVarietytargetTable());
    setTimeout(() => this.multiLocationtrialsChart());
    setTimeout(() => this.managedByMultiLocationtrialsChart());
    setTimeout(() => this.geographicalScopeWiseChart());
    setTimeout(() => this.cvChart());
    setTimeout(() => this.heritabilityMeasureChart());
    setTimeout(() => this.nurseriesEstablishedFieldChart());
    setTimeout(() => this.trialsEstablishedGreenhouseChart());
    setTimeout(() => this.sopPytDataChart());
    setTimeout(() => this.bmsChart());
    setTimeout(() => this.onStationOnYieldChart());
    setTimeout(() => this.cropwisebreedinglinesExchangedChart());
    //setTimeout(()=>this.partnerCountryMap());
    setTimeout(() => this.fixedlinesDevelopedCropChart());
    setTimeout(() => this.locationTrailsRadialGraph());
    // setTimeout(()=>this.locationTrailsRadarGraph());
  }

  locationTrailsRadialGraph() {
    $("#location_radial_graph").html("");
    const multi_locationtrials_list = clone(this.apiData.total_programs);
    if (!multi_locationtrials_list?.length) {
      $("#location_radial_graph").html(nodata_html());
      return;
    }

    const chartData = multi_locationtrials_list.map(e => {
      const data = e.all_data.filter(d => d.trail_name && d.count).map(d => {
        const r = {};
        r[d.trail_name] = d.count;
        return r;
      }).reduce((a, b) => Object.assign(a, b), {});
      if (!Object.keys(data).some(e => e)) {
        return null;
      }
      const result = { category: e.program_name, ...data };
      return result;
    }).filter(d => d);

    const seriesList = Array.from(new Set(chartData.map(d => Object.keys(d).filter(k => k != 'category' && d[k])).flat()));

    //debugger
    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Themes end

      var chart = am4core.create("location_radial_graph", am4charts.RadarChart);
      chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

      chart.data = chartData;
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

      //chart.padding(20, 20, 20, 20);
      chart.colors.step = 4;

      var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "category";
      categoryAxis.renderer.labels.template.location = 0.5;
      categoryAxis.renderer.labels.template.horizontalCenter = "right";
      categoryAxis.renderer.labels.template.fontSize = 16;
      categoryAxis.renderer.labels.template.paddingBottom = 30;
      categoryAxis.renderer.labels.template.paddingTop = 30;
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.tooltipLocation = 0.1;
      categoryAxis.renderer.grid.template.strokeOpacity = 0.01;
      categoryAxis.renderer.axisFills.template.disabled = true;
      categoryAxis.interactionsEnabled = false;
      categoryAxis.renderer.minGridDistance = 4;

      var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
      valueAxis.tooltip.disabled = true;
      valueAxis.renderer.labels.template.horizontalCenter = "left";
      valueAxis.min = 0;
      valueAxis.max = 60;
      valueAxis.strictMinMax = true;
      valueAxis.renderer.maxLabelPosition = 0.99;
      valueAxis.renderer.minGridDistance = 20;
      valueAxis.renderer.grid.template.strokeOpacity = 0.07;
      valueAxis.renderer.axisFills.template.disabled = true;
      valueAxis.interactionsEnabled = false;

      // var series1 = chart.series.push(new am4charts.RadarColumnSeries());
      // series1.columns.template.tooltipText = "{name}: {valueX.value}";
      // series1.name = "Series 1";
      // series1.dataFields.categoryY = "category";
      // series1.dataFields.valueX = "value1";
      // series1.stacked = true;

      const createSeries = (val) => {
        var series1 = chart.series.push(new am4charts.RadarColumnSeries());
        series1.columns.template.tooltipText = "{name}: {valueX.value}";
        series1.name = val;
        series1.dataFields.categoryY = "category";
        series1.dataFields.valueX = val;
        series1.stacked = true;
      }
      seriesList.forEach(d => createSeries(d));


      chart.seriesContainer.zIndex = -1;

      chart.scrollbarX = new am4core.Scrollbar();
      chart.scrollbarX.exportable = false;
      chart.scrollbarY = new am4core.Scrollbar();
      chart.scrollbarY.exportable = false;

      chart.cursor = new am4charts.RadarCursor();
      chart.cursor.lineY.disabled = true;

      // chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa_multi-locational_trials";

    }); // end am4core.ready()



  }
  /*locationTrailsRadarGraph() {
    $("#location_radar_graph").html("");
    const multi_locationtrials_list = clone(this.apiData.total_programs);
    if (!multi_locationtrials_list?.length) {
      $("#location_radar_graph").html(nodata_html());
      return;
    }

    const chartData = multi_locationtrials_list.map(e => {
        const data = e.all_data.filter(d => d.trail_name && d.count).map(d => {
          const r = {};
          r[d.trail_name] = d.count;
          return r;
          }).reduce((a,b) => Object.assign(a,b), {});
          const result = {category: e.program_name, ...data};
    return result;
    })

  const seriesList = Array.from(new Set(chartData.map(d => Object.keys(d).filter(k => k!= 'category' && d[k])).flat()));

    am4core.ready(function() {

      // Themes begin
      am4core.useTheme(am4themes_kelly);
      am4core.useTheme(am4themes_animated);
      // Themes end
    	
      var chart = am4core.create("location_radar_graph", am4charts.RadarChart);
      chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
    	
      chart.data = chartData
    	
      //chart.padding(20, 20, 20, 20);
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
    	
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "category";
      categoryAxis.renderer.labels.template.location = 0.5;
      categoryAxis.renderer.tooltipLocation = 0.5;
    	
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.tooltip.disabled = true;
      valueAxis.renderer.labels.template.horizontalCenter = "left";
      valueAxis.min = 0;
    	
    	
      const createSeries = (val) => {
            var series1 = chart.series.push(new am4charts.RadarColumnSeries());
            series1.columns.template.tooltipText = "{name}: {valueY.value}";
            series1.columns.template.width = am4core.percent(80);
            series1.name = val;
            series1.dataFields.categoryX = "category";
            series1.dataFields.valueY = val;
            series1.stacked = true;
           }
    seriesList.forEach(d => createSeries(d));
    	
    	
    	
      chart.seriesContainer.zIndex = -1;
    	
      chart.scrollbarX = new am4core.Scrollbar();
      chart.scrollbarX.exportable = false;
      chart.scrollbarY = new am4core.Scrollbar();
      chart.scrollbarY.exportable = false;
    	
      chart.cursor = new am4charts.RadarCursor();
      chart.cursor.xAxis = categoryAxis;
      chart.cursor.fullWidthXLine = true;
      chart.cursor.lineX.strokeOpacity = 0;
      chart.cursor.lineX.fillOpacity = 0.1;
      chart.cursor.lineX.fill = am4core.color("#000000");
    	
      }); // end am4core.ready()


    
  }*/

  fixedlinesDevelopedCropChart() {
    $("#crop_wise_graph_three").html("");
    const fixedlines_developed = clone(this.apiData.fixedlines_developed_crop);
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
  }

  /*partnerCountryMap(){
    const cropCountryData = this.apiData.breedinglines_exchanged_partner_countries;

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
 }*/


  cropwisebreedinglinesExchangedChart() {
    $("#crop_wise_graph_four").html("");
    const breedinglines_exchanged_crop = this.apiData.breedinglines_exchanged_crop;
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

  onStationOnYieldChart() {
    //Graph-8
    $("#programwise_onstation_onfarm_yield").html("");
    const program_onfarm_onstation = this.apiData.verity_onfarm_onstation;
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
      // xAxis.renderer.labels.template.minGridDistance = 270;
      xAxis.renderer.minGridDistance = 0;
      xAxis.renderer.labels.template.horizontalCenter = "middle";
      xAxis.renderer.labels.template.verticalCenter = "middle";

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

      chart.data = program_onfarm_onstation.filter(d=> d.onstation || d.onfarm);

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
    var mydata = this.apiData.platforms_developed_table;
    // debugger
    const tableData = mydata.map(d => {
      const result = `
      <tr>
        <td>${d.country_name}</td>
        <td>${d.crop_name}</td>
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
  countrywiseDiagnosticChart() {
    $("#country_wise_diagnostic_graph").html("");

    //const fixedlines_developed = [...this.apiData.fixedlines_developed_country].sort(countryIndexsort);
    const diagnostic_markers_country = this.apiData.diagnostic_markers_country;
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

    //const fixedlines_developed = [...this.apiData.fixedlines_developed_country].sort(countryIndexsort);
    const assays_available_country = this.apiData.assays_available_country;
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

    //const fixedlines_developed = [...this.apiData.fixedlines_developed_country].sort(countryIndexsort);
    const qtls_markers_country = this.apiData.qtls_markers_country;
    // debugger
    $("#marker_qtl_count").html(
      qtls_markers_country.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if (!qtls_markers_country?.length) {
      $("#marker_qtl_graph").html(nodata_html());
      return;
    }

    const allValues = qtls_markers_country.map(d => d.count)

    const maxValue = Math.max(...allValues)

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
  protocolsDevelopedChart() {

    $("#program_wise_graph_one").html("");
    const protocols_developed = this.apiData.protocols_developed_country;
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
  generationsAchievedChart() {
    $("#program_wise_graph_two").html("");
    const generationsachieved = this.apiData.generationsachieved;
    let generationsachieved_counts = generationsachieved.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    let values = (generationsachieved_counts / generationsachieved.length).toFixed(2);
    $("#generationsachieved_count").html(values);
    if (!generationsachieved?.length) {
      $("#program_wise_graph_two").html(nodata_html());
      return;
    }
    const chartData = generationsachieved.filter(e => (e.count + e.target) != 0);
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
  fixedlinesDevelopedChart() {
    $("#program_wise_graph_three").html("");

    const fixedlines_developed = this.apiData.fixedlines_developed_country;
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
  breedinglinesExchangedChart() {
    $("#program_wise_graph_four").html("");
    const breedinglines_exchanged_country = this.apiData.breedinglines_exchanged_country;
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
    const npt_dus_country_crop = this.apiData.npt_dus_country_crop;
    const chartdata = npt_dus_country_crop.filter(d => d.count != 0);
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
    const npt_dus_crop_country = clone(this.apiData.npt_dus_crop_country);
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
  hybridVarietyReleasedChart() {
    //Graph -7
    $("#program_varietyreleased").html("");

    const hybrid_opv_spv_data = this.apiData.hybrid_opv_spv_data;
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
  generateHybridSvpSankeyGraph() {
    $("#program_traits_hybrid_opv_spv").html("");
    const hybrid_opv_spv_rawdata = clone(this.apiData.hybrid_opv_spv_rawdata);
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
  rcihwisemappingVarietynameVarietytargetTable() {
    var mydata = this.apiData.mapping_varietyname_varietytarget;
    $("#result").bootstrapTable({
      data: mydata,
    });
    $("tbody>tr").addClass("tbl_bg");
  }
  multiLocationtrialsChart() {
    $("#program_wise_multi_locational_trials").html("");
    const multi_locationtrials = this.apiData.multi_locationtrials_country;
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
  managedByMultiLocationtrialsChart() {
    $("#managed_by_multi_locational_trials").html("");
    const multi_locationtrials_managed_by = clone(this.apiData.multi_locationtrials_managed_by);

    // $("#crop_wise_multi_locational_trials_count").html(
    //   chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    // );
    if (!multi_locationtrials_managed_by?.length) {
      $("#managed_by_multi_locational_trials").html(nodata_html());
      return;
    }
    this.rich_piechart1("managed_by_multi_locational_trials", multi_locationtrials_managed_by)

  }
  geographicalScopeWiseChart() {
    //Graph-8
    $("#geographical_scope_wise_graph").html("");
    const geographical_scope_wise = this.apiData.geographical_scope_wise;
    if (!geographical_scope_wise?.length) {
      $("#geographical_scope_wise_graph").html(nodata_html());
      return;
    }
    const chartData = geographical_scope_wise.filter(e => (e.regional_count + e.national_count) != 0);

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
  cvChart() {
    $("#cv_graph").html("");
    const cv_trials_conducted = this.apiData.cv_trials_conducted;
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
    const heritability_measure = this.apiData.heritability_measure;
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
  nurseriesEstablishedFieldChart() {
    $("#programwise_bmsinfo").html("");
    const nurseriesestablished_field = this.apiData.nurseriesestablished_field;
    const nurseriesestablished_greenhouse = this.apiData.nurseriesestablished_greenhouse;



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
      categoryAxis.renderer.minGridDistance = 0;
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
  trialsEstablishedGreenhouseChart() {
    $("#programwise_trials_greenhouse").html("");
    const trialsestablished_field = this.apiData.trialsestablished_field;
    const trialsestablished_greenhouse = this.apiData.trialsestablished_greenhouse;



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
      categoryAxis.renderer.minGridDistance = 0;
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
    const sop_pyt_data = this.apiData.sop_pyt_data;
    const sop_ayt_data = this.apiData.sop_ayt_data;
    const sop_mlt_data = this.apiData.sop_mlt_data;
    const sop_pvs_data = this.apiData.sop_pvs_data;
    const sop_nurseries_data = this.apiData.sop_nurseries_data;

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

  }
  bmsChart() {
    $("#programwise_bms").html("");
    const bms_uploads = this.apiData.bms_uploads;
    let bms_uploads_counts = bms_uploads.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
    //let values = (generationsachieved_counts / bms_uploads.length).toFixed(2);
    $("#programwise_bms_count").html(bms_uploads_counts);
    if (!bms_uploads?.length) {
      $("#programwise_bms").html(nodata_html());
      return;
    }
    const chartData = bms_uploads.filter(e => (e.count + e.target) != 0);
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


      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      // series.name = "Actual Value"
      series.sequencedInterpolation = true;
      series.dataFields.valueY = "count";
      series.dataFields.categoryX = "program_name";
      // series.tooltipText = "[{categoryX}: bold]{program_name}-{valueY}[/]";
      series.columns.template.strokeWidth = 0;


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
      pieSeries.labels.template.fontSize = 12;
      pieSeries.labels.template.fontWeight = 400;

      pieSeries.labels.template.maxWidth = 150;
      pieSeries.labels.template.wrap = true;
      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      // pieSeries.hiddenState.properties.endAngle = -70;
      // pieSeries.hiddenState.properties.startAngle = -70;
      // pieSeries.legendSettings.labelText = "[bold {color}]{name}[/] - [bold {color}]{value}[/]";

      chart.scrollbarX = new am4core.Scrollbar();
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";

    });
  }

  generateSpillOverChart() {
    var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

    const imageSeriesData = this.country_lat_lng.map(d => {
      const result = { id: d.country_name, title: d.country_name, latitude: d.lat, longitude: d.lng, scale: 0.5, svgPath: targetSVG };
      return result;
    });

    const mapData = breedingModernization.apiData.spill_over_map_data.map(d => {
      const from = breedingModernization.country_lat_lng.find(e => e.country_id == d.country_id);
      if (d.partner_country.includes(",")) {
        return breedingModernization.country_lat_lng.filter(e => d.partner_country.split(',').includes(e.country_id)).map(e => {
          const result = { multiGeoLine: [] };
          result.multiGeoLine.push([{ latitude: from?.lat, longitude: from?.lng }, { latitude: e?.lat, longitude: e?.lng }]);
          return result;
        });
      } else {
        const to = breedingModernization.country_lat_lng.find(e => e.country_id == d.partner_country);
        const result = { multiGeoLine: [] };
        if (from && to) {
          if (d.taken == 1) {
            result.multiGeoLine.push([{ latitude: to?.lat, longitude: to?.lng }, { latitude: from?.lat, longitude: from?.lng }]);
          }
          if (d.given == 1) {
            result.multiGeoLine.push([{ latitude: from?.lat, longitude: from?.lng }, { latitude: to?.lat, longitude: to?.lng }]);
          }
          return result;
        }
      }
      return null;
    }).flat().filter(d => d?.multiGeoLine?.length);
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Define marker path

      // Create map instance
      var chart = am4core.create("spill_map", am4maps.MapChart);
      var interfaceColors = new am4core.InterfaceColorSet();

      // Set map definition
      // chart.geodata = am4geodata_worldLow;
      chart.geodata = am4geodata_worldIndiaLow;

      // Set projection
      chart.projection = new am4maps.projections.Mercator();
      chart.logo.disabled = "true";

      // Add zoom control
      chart.zoomControl = new am4maps.ZoomControl();


      // Add button
      var button = chart.chartContainer.createChild(am4core.Button);
      button.padding(5, 5, 5, 5);
      button.align = "right";
      button.marginRight = 15;
      button.events.on("hit", function () {
        chart.goHome();
      });

      button.icon = new am4core.Sprite();
      button.icon.path = "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";

      // chart.maxZoomLevel = 1
      // Set initial zoom

      chart.seriesContainer.draggable = true;
      chart.seriesContainer.resizable = false;

      chart.homeZoomLevel = 2;
      chart.homeGeoPoint = {
        latitude: -4.5570,
        longitude: 49.9466,
      };

      // Create map polygon series
      var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
      polygonSeries.exclude = ["AQ"];
      polygonSeries.useGeodata = true;
      polygonSeries.mapPolygons.template.nonScalingStroke = true;

      // Add images
      var imageSeries = chart.series.push(new am4maps.MapImageSeries());
      var imageTemplate = imageSeries.mapImages.template;
      imageTemplate.tooltipText = "{title}";
      imageTemplate.nonScaling = true;

      var marker = imageTemplate.createChild(am4core.Sprite);
      marker.path = targetSVG;
      marker.horizontalCenter = "middle";
      marker.verticalCenter = "middle";
      marker.scale = 0.7;
      marker.fill = interfaceColors.getFor("alternativeBackground");
      imageTemplate.propertyFields.latitude = "latitude";
      imageTemplate.propertyFields.longitude = "longitude";
      imageSeries.data = imageSeriesData;
      // Add lines
      var lineSeries = chart.series.push(new am4maps.MapLineSeries());
      lineSeries.dataFields.multiGeoLine = "multiGeoLine";
      lineSeries.mapLines.template.strokeWidth = 2;

      var lineTemplate = lineSeries.mapLines.template;
      lineTemplate.nonScalingStroke = true;
      lineTemplate.arrow.nonScaling = true;
      lineTemplate.arrow.width = 4;
      lineTemplate.arrow.height = 6;
      lineTemplate.stroke = interfaceColors.getFor("alternativeBackground");
      lineTemplate.fill = interfaceColors.getFor("alternativeBackground");
      lineTemplate.line.strokeOpacity = 0.4;
      lineSeries.data = mapData;
    }); // end am4core.ready()
  }
}
