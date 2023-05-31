class PO3 {
  constructor() {
    this.map = null;
    this.map1 = null;
    // setTimeout(() => this.generateProgramwiseMap());
    this.onRcihClick();
    this.getPO3Data();
    this.getRcihWiseData();
    this.getFilterOptions();
    $("#po3_filter").on("click", () => {
      this.getPO3Data();
      this.getRcihWiseData();
    });

    $("#dwn-csv-2").on("click", function () {
      $("#resultpo3").table2csv({
          file_name: "avisa-mapping-enduser-profile.csv",
          header_body_space: 0,
      });
    });

  $("#dwn-csv-32").on("click", function () {
      $("#resultpo32").table2csv({
          file_name: "avisa-mapping-enduser-profile.csv",
          header_body_space: 0,
      });
  });

    //setTimeout(() => this.staticCharts());
  }

  onRcihClick() {
    $("#base-rcihs3").on("click", () => {
      // setTimeout(() => {
      //   if (!this.map1) {
      //     const greenIcon = L.icon({
      //       iconUrl: `${imgUrl}map_pointer/greenmarker.png`,
      //       shadowUrl: 'https://unpkg.com/leaflet@1.3.1/dist/images/marker-shadow.png',
      //     });
      //     this.map1 = L.map("po-3-rcihs-map").setView([-11.202692, 17.873886], 3);
      //     L.tileLayer(
      //       "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw",
      //       {
      //         maxZoom: 18,
      //         attribution:
      //           'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
      //           '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
      //           'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      //         id: "mapbox/streets-v11",
      //       }
      //     ).addTo(this.map1);
      //     let markers = L.markerClusterGroup();
      //     for (let i = 0; i < RCIH.length; i++) {
      //       let rcih_name = RCIH[i]["rcih_name"];
      //       let lat = RCIH[i]["lat"];
      //       let lng = RCIH[i]["lang"];
      //       let location = RCIH[i]["location"];
      //       let Organization = RCIH[i]["Organization"];
      //       let marker = L.marker(new L.LatLng(lat, lng), {
      //         rcih_name: rcih_name,
      //         Organization: Organization,
      //         location: location,
      //         icon: greenIcon
      //       });
      //       const html = `
      //         <div class="row">
      //           <div class="col-sm-12">
      //             <span>${rcih_name}</span>
      //             <p> ${Organization}</p>
      //             <p> ${location}</p>
      //           </div>
      //         </div>
      //     `;
      //       // marker /.on('click', onMapClick);
      //       // marker.bindPopup(html);
      //       markers.addLayer(marker);
      //       /* adding click event */
      //       marker.on("click", function (e) {
      //         let name = e.target.options;
      //         // let side_info = name + "Clicked.";
      //         // adding info into side bar
      //         $("#rcih_location_p3").html(name.location);
      //         $("#rcih_organization_p3").html(name.Organization);
      //         $("#rcih_name_p3").html(name.rcih_name);
      //       });
      //     }
      //     this.map1.addLayer(markers);
      //     let popup = L.popup();
      //     //   $(".leaflet-marker-icon").attr(
      //     //     "src",
      //     //     "./assets/images/map_pointer/greenmarker.png"
      //     //   );
      //   }
      // });
      if (!this.richdata) {
        //this.getRcihWiseData();
      }
    });
  }

  getRcihWiseData() {
    showLoader();
    const request = {"purpose":"PO3", "rcih":"po3rcih"};
    const countryData=$("#po3_country_list").val();
    if(countryData?.length){
      request.country_id=countryData
    }
    post("dashboard", request).then(response => {
        this.richdata = response;
        this.rcihwisenewGenderResponsiveChart();
        this.rcihwisetargetPopulationChart();
        this.rcihwise_rcihsNarsGenderresponsiveProductChart();
        this.rcihwisegenderResponsiveProductChart();
        this.rcihwiseadoptingNewVarietiesChart();
        this.rcihwiseseedImprovedVaritiesChart();
        this.rcihwisefarmersRecycleChart();
    }).catch().finally(() => {
      setTimeout(() => 
      {hideLoader();
      }
      , 1000);
    })
  }

  generateProgramwiseMap() {
    this.map = L.map("po-3-programwise-map").setView([-11.202692, 17.873886], 3);
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
        $("#map_crops_p3").html(name.crops);
        $("#map_partners_p3").html(name.partners);
      });
    }
    this.map.addLayer(markers);
  }
  getFilterOptions(){
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
    $("#po3_country_list").multipleSelect('destroy');
      setTimeout(()=>{
        const optionData=country.map(d=>{
           return `<option value="${d.country_id}">${d.country_name}</option>`
              }).join('\n');
              $("#po3_country_list").html(optionData);
          $("#po3_country_list").multipleSelect();
      }
    )
  }
  cropList() {
    const crops = this.filterData.crops_list;
    $("#po3_crop_list").multipleSelect('destroy');
      setTimeout(()=>{
        const optionData=crops.map(d=>{
           return `<option value="${d.crop_id}">${d.crop_name}</option>`
              }).join('\n');
              $("#po3_crop_list").html(optionData);
          $("#po3_crop_list").multipleSelect();
      }
    )
  }

  getPO3Data() {
    showLoader();
    const request = { "purpose": "PO3" };
    const countryData=$("#po3_country_list").val();
    if(countryData?.length){
      request.country_id=countryData
    }
    const cropData=$("#po3_crop_list").val();
    if(cropData?.length){
      request.crop_id=cropData
    }
    post('dashboard', request).then(response => {
      // To do generate chart
      this.poThreeData = response;
      this.newGenderResponsiveChart();
      this.targetPopulationChart();
      this.rcihsNarsGenderresponsiveProductChart();
      this.genderResponsiveProductChart();
      this.adoptingNewVarietiesChart();
      this.seedImprovedVaritiesChart();
      this.farmersRecycleChart();
      this.newgenderResponsiveTable();
      this.seedImprovedVaritiesTable();


    }).catch().finally(() => {
      setTimeout(() => 
      {hideLoader();
      }
      , 1000);
    })
  }
  newgenderResponsiveTable() {
    var mydata = this.poThreeData.newgender_responsive_table;

    //debugger
    //console.log(mydata);
    const tableData= mydata.map(d =>{
      const result=`
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

    $('#resultpo3>tbody').html(tableData);
    $("tbody>tr").addClass("tbl_bg");
    
  }

  seedImprovedVaritiesTable() {
    var mydata = this.poThreeData.seed_improvedvarities_table;

    //debugger
    //console.log(mydata);
    const tableData= mydata.map(d =>{
      const result=`
      <tr>
        <td>${d.country_name}</td>
        <td>${d.crop_name}</td>
        <td>
          ${d.name}
        </td>
        <td>
          ${d.type}
        </td>
      </tr>
      `;
      return result;
    })

    $('#resultpo32>tbody').html(tableData);
    $("tbody>tr").addClass("tbl_bg");
    
  }
  //Graph -1
  newGenderResponsiveChart() {
    $("#new_gender_responsive_end_user_profiles").html("");

    const newgender_responsive = this.poThreeData.newgender_responsive;

    const newgender_responsive_count = newgender_responsive.map((e) => e?.count).filter(d=> d != undefined).reduce((a,b)=> a+b, 0) || 0
    $("#new_gender_responsive_end_user_profiles_count").html(newgender_responsive_count);
    $("#new_gender_responsive_end_user_profiles_counts").html(newgender_responsive_count);
    // new_gender_responsive_end_user_profiles
    if(!newgender_responsive?.length){
      $("#new_gender_responsive_end_user_profiles").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "new_gender_responsive_end_user_profiles",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = newgender_responsive


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of end-user profiles";
      valueAxis.title.fontWeight = "bold";
      valueAxis.renderer.minGridDistance = 100;
      valueAxis.min = 0;

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
  //Graph -2
  targetPopulationChart() {
    $("#programwise_tpes").html("");

    const target_population = this.poThreeData.target_population
    $("#programwise_tpes_count").html(
      target_population.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if(!target_population?.length){
      $("#programwise_tpes").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("programwise_tpes", am4charts.XYChart);
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = target_population


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of TPEs";
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
  //Graph -3
  rcihsNarsGenderresponsiveProductChart() {
    $("#RCIHs_and_NARS_programs_developing_gender_responsive").html("");

    const rcihs_nars_genderresponsive_product = this.poThreeData.rcihs_nars_genderresponsive_product
    $("#RCIHs_and_NARS_programs_developing_gender_responsive_count").html(
      rcihs_nars_genderresponsive_product.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if(!rcihs_nars_genderresponsive_product?.length){
      $("#RCIHs_and_NARS_programs_developing_gender_responsive").html(nodata_html());
      return;
    }
    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("RCIHs_and_NARS_programs_developing_gender_responsive", am4charts.XYChart);
      chart.logo.disabled = 'true'
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = rcihs_nars_genderresponsive_product

      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of RCIHs and NARS programs";
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

      var bullet = series.bullets.push(new am4charts.LabelBullet())
      bullet.interactionsEnabled = false
      bullet.dy = -10;
      bullet.label.text = '{valueY}'
      bullet.label.fontSize = '13px'
      bullet.label.fill = am4core.color('#000')

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
  //Graph -4
  genderResponsiveProductChart() {
    $("#new_dynamic_and_gender_responsive_product").html("");

    const genderresponsive_product = this.poThreeData.genderresponsive_product
    $("#new_dynamic_and_gender_responsive_product_count").html(
      genderresponsive_product.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    if(!genderresponsive_product?.length){
      $("#new_dynamic_and_gender_responsive_product").html(nodata_html());
      return;
    }
    am4core.ready(function () {

      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create("new_dynamic_and_gender_responsive_product", am4charts.XYChart);
      chart.logo.disabled = 'true'
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = genderresponsive_product



      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of product profiles";
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

      var bullet = series.bullets.push(new am4charts.LabelBullet())
      bullet.interactionsEnabled = false
      bullet.dy = -10;
      bullet.label.text = '{valueY}'
      bullet.label.fontSize = '13px'
      bullet.label.fill = am4core.color('#000')

      series.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
      });

      // Cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
  //Graph -5
  adoptingNewVarietiesChart() {
    $("#percent_of_women_and_youth").html("");

    const adopting_newvarieties = this.poThreeData.adopting_newvarieties
    //console.log(adopting_newvarieties);
    let youth= adopting_newvarieties.map((e) => e.youth_val).reduce((a, b) => a + b, 0) || 0
    let woman= adopting_newvarieties.map((e) => e.women_val).reduce((a, b) => a + b, 0) || 0

    let youth_persent=((youth/(youth+woman))*100);
    let woman_persent=((woman/(youth+woman))*100);

    $("#percent_of_women_and_youth_count").html(youth+woman);
    if(!adopting_newvarieties?.length){
      $("#percent_of_women_and_youth").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("percent_of_women_and_youth", am4charts.XYChart);
      chart.logo.disabled = 'true'

      chart.marginRight = 400;

      // Add data
      chart.data = adopting_newvarieties


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      //categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Percent of women and youth";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "women_val";
      series.dataFields.categoryX = "program_name";
      series.name = "Women";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "youth_val";
      series2.dataFields.categoryX = "program_name";
      series2.name = "Youth";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      // var series3 = chart.series.push(new am4charts.ColumnSeries());
      // series3.dataFields.valueY = "spvvarieties";
      // series3.dataFields.categoryX = "program";
      // series3.name = "SPV varieties";
      // series3.tooltipText = "{name}: [bold]{valueY}[/]";
      // series3.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
  //Graph -6
  seedImprovedVaritiesChart() {
    $("#percent_of_women_and_youth_quantity_seed").html("");

    const seed_improvedvarities = this.poThreeData.seed_improvedvarities
    const seed_rt = this.poThreeData.indicator_75_final_value
    //console.log(seed_improvedvarities);
    let formal_source= seed_improvedvarities.map((e) => e.formal_source).reduce((a, b) => a + b, 0) || 0
    let informal_source= seed_improvedvarities.map((e) => e.informal_source).reduce((a, b) => a + b, 0) || 0

    $("#percent_of_women_and_youth_quantity_seed_count").html(seed_rt);
    if(!seed_improvedvarities?.length){
      $("#percent_of_women_and_youth_quantity_seed").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "percent_of_women_and_youth_quantity_seed",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = seed_improvedvarities


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Percentage (%)";
      valueAxis.title.fontWeight = "bold";
      valueAxis.renderer.minGridDistance = 100;
      valueAxis.min = 0;

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
  //Graph -7
  farmersRecycleChart() {
    $("#percent_of_women_and_youth_farmer_recycle").html("");

    const farmersrecycle = this.poThreeData.farmersrecycle
    const indicator_76_final_value = this.poThreeData.indicator_76_final_value
    //console.log(farmersrecycle);
    //let total_val= farmersrecycle.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    
    $("#percent_of_women_and_youth_farmer_recycle_count").html(indicator_76_final_value);
    if(!farmersrecycle?.length){
      $("#percent_of_women_and_youth_farmer_recycle").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "percent_of_women_and_youth_farmer_recycle",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = farmersrecycle


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Percentage (%)";
      valueAxis.title.fontWeight = "bold";
      valueAxis.renderer.minGridDistance = 100;
      valueAxis.min = 0;

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

  rcih_po3_piechart(divid,data){
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
      pieSeries.labels.template.fontSize = 14;
      pieSeries.labels.template.maxWidth = 80;
      pieSeries.labels.template.wrap = true;
      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1;
      pieSeries.hiddenState.properties.endAngle = -80;
      pieSeries.hiddenState.properties.startAngle = -80;
    });
  }

  rcihwisenewGenderResponsiveChart() {
    $("#rcihwise_new_gender_responsive_end_user_profiles").html("");

    const newgender_responsive = this.richdata.newgender_responsive
    if(!newgender_responsive?.length){
      $("#rcihwise_new_gender_responsive_end_user_profiles").html(nodata_html());
      return;
    }
    this.rcih_po3_piechart("rcihwise_new_gender_responsive_end_user_profiles",newgender_responsive)
    $("#rcihwise_new_gender_responsive_end_user_profiles_count").html(
      newgender_responsive.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
  }

  rcihwisetargetPopulationChart() {
    $("#rcihwise_programwise_tpes").html("");

    const target_population = this.richdata.target_population
    if(!target_population?.length){
      $("#rcihwise_programwise_tpes").html(nodata_html());
      return;
    }
    this.rcih_po3_piechart("rcihwise_programwise_tpes",target_population)
    $("#rcihwise_programwise_tpes_count").html(
      target_population.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
    
  }

  rcihwise_rcihsNarsGenderresponsiveProductChart() {
    $("#rcihwise_RCIHs_and_NARS_programs_developing_gender_responsive").html("");

    const rcihs_nars_genderresponsive_product = this.richdata.rcihs_nars_genderresponsive_product
    if(!rcihs_nars_genderresponsive_product?.length){
      $("#rcihwise_RCIHs_and_NARS_programs_developing_gender_responsive").html(nodata_html());
      return;
    }
    this.rcih_po3_piechart("rcihwise_RCIHs_and_NARS_programs_developing_gender_responsive",rcihs_nars_genderresponsive_product)
    $("#rcihwise_RCIHs_and_NARS_programs_developing_gender_responsive_count").html(
      rcihs_nars_genderresponsive_product.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
  }

  rcihwisegenderResponsiveProductChart() {
    $("#rcihwise_new_dynamic_and_gender_responsive_product").html("");

    const genderresponsive_product = this.richdata.genderresponsive_product
    //console.log(genderresponsive_product);
    if(!genderresponsive_product?.length){
      $("#rcihwise_new_dynamic_and_gender_responsive_product").html(nodata_html());
      return;
    }
    this.rcih_po3_piechart("rcihwise_new_dynamic_and_gender_responsive_product",genderresponsive_product)
    $("#rcihwise_new_dynamic_and_gender_responsive_product_count").html(
      genderresponsive_product.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
    );
  }

  rcihwiseadoptingNewVarietiesChart() {
    $("#rcihwise_percent_of_women_and_youth").html("");

    const adopting_newvarieties = this.richdata.adopting_newvarieties
    let youth= adopting_newvarieties.map((e) => e.youth_val).reduce((a, b) => a + b, 0) || 0
    let woman= adopting_newvarieties.map((e) => e.women_val).reduce((a, b) => a + b, 0) || 0
    $("#rcihwise_percent_of_women_and_youth_count").html(youth+woman);
    if(!adopting_newvarieties?.length){
      $("#rcihwise_percent_of_women_and_youth").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("rcihwise_percent_of_women_and_youth", am4charts.XYChart);
      chart.logo.disabled = 'true'

      chart.marginRight = 400;

      // Add data
      chart.data = adopting_newvarieties


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      //categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Percent of women and youth";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "women_val";
      series.dataFields.categoryX = "program_name";
      series.name = "Women";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "youth_val";
      series2.dataFields.categoryX = "program_name";
      series2.name = "Youth";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      // var series3 = chart.series.push(new am4charts.ColumnSeries());
      // series3.dataFields.valueY = "spvvarieties";
      // series3.dataFields.categoryX = "program";
      // series3.name = "SPV varieties";
      // series3.tooltipText = "{name}: [bold]{valueY}[/]";
      // series3.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwiseseedImprovedVaritiesChart() {
    $("#rcihwise_percent_of_women_and_youth_quantity_seed").html("");

    const seed_improvedvarities = this.richdata.seed_improvedvarities
    let formal_source= seed_improvedvarities.map((e) => e.formal_source).reduce((a, b) => a + b, 0) || 0
    let informal_source= seed_improvedvarities.map((e) => e.informal_source).reduce((a, b) => a + b, 0) || 0
    $("#rcihwise_percent_of_women_and_youth_quantity_seed_count").html(formal_source+informal_source);
    if(!seed_improvedvarities?.length){
      $("#rcihwise_percent_of_women_and_youth_quantity_seed").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("rcihwise_percent_of_women_and_youth_quantity_seed", am4charts.XYChart);
      chart.logo.disabled = 'true'

      chart.marginRight = 400;

      // Add data
      chart.data = seed_improvedvarities


      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      //categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Percent of women and youth";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "formal_source";
      series.dataFields.categoryX = "program_name";
      series.name = "Formal Source";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "informal_source";
      series2.dataFields.categoryX = "program_name";
      series2.name = "Informal Source";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      // var series3 = chart.series.push(new am4charts.ColumnSeries());
      // series3.dataFields.valueY = "spvvarieties";
      // series3.dataFields.categoryX = "program";
      // series3.name = "SPV varieties";
      // series3.tooltipText = "{name}: [bold]{valueY}[/]";
      // series3.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }

  rcihwisefarmersRecycleChart() {
    $("#rcihwise_percent_of_women_and_youth_farmer_recycle").html("");

    const farmersrecycle = this.richdata.farmersrecycle
    let women_val= farmersrecycle.map((e) => e.women_val).reduce((a, b) => a + b, 0) || 0
    let informal_source= farmersrecycle.map((e) => e.informal_source).reduce((a, b,) => a + b, 0) || 0
    $("#rcihwise_percent_of_women_and_youth_farmer_recycle_count").html(women_val+informal_source);
    if(!farmersrecycle?.length){
      $("#rcihwise_percent_of_women_and_youth_farmer_recycle").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Apply chart themes
      am4core.useTheme(am4themes_animated);

      // Create chart instance
      var chart = am4core.create("rcihwise_percent_of_women_and_youth_farmer_recycle", am4charts.XYChart);
      chart.logo.disabled = 'true'

      chart.marginRight = 400;

      // Add data
      chart.data = farmersrecycle

      // Create axes
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "program_name";
      //categoryAxis.title.text = "Countries";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.minGridDistance = 20;
      categoryAxis.renderer.labels.template.rotation = 270;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Nunmber of seasons";
      valueAxis.title.fontWeight = 800;

      // Create series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.valueY = "women_val";
      series.dataFields.categoryX = "program_name";
      series.name = "Women";
      series.tooltipText = "{name}: [bold]{valueY}[/]";
      series.stacked = true;

      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.dataFields.valueY = "youth_val";
      series2.dataFields.categoryX = "program_name";
      series2.name = "Youth";
      series2.tooltipText = "{name}: [bold]{valueY}[/]";
      series2.stacked = true;

      // var series3 = chart.series.push(new am4charts.ColumnSeries());
      // series3.dataFields.valueY = "spvvarieties";
      // series3.dataFields.categoryX = "program";
      // series3.name = "SPV varieties";
      // series3.tooltipText = "{name}: [bold]{valueY}[/]";
      // series3.stacked = true;

      chart.legend = new am4charts.Legend();

      // Add cursor
      chart.cursor = new am4charts.XYCursor();
      chart.exporting.menu = new am4core.ExportMenu();
      chart.exporting.filePrefix = "avisa";
    }); // end am4core.ready()
  }
}
