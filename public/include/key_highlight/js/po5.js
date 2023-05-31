class PO5 {
  constructor() {
    this.map = null;
    this.map1 = null;
    // setTimeout(() => this.generateProgramwiseMap());
    this.onRcihClick();
    this.getPO5Data();
    this.getRcihWiseData();
    this.getFilterOptions();
    $("#po5_filter").on("click", () => {
      this.getPO5Data();
      this.getRcihWiseData();
    });

    $("#dwn-csv-10").on("click", function () {
      $("#resultpo5").table2csv({
          file_name: "avisa-success-impact.csv",
          header_body_space: 0,
      });
  });
    
  }

  onRcihClick() {
    $("#base-rcihs5").on("click", () => {
      // setTimeout(() => {
      //   if (!this.map1) {
      //     const greenIcon = L.icon({
      //       iconUrl: `${imgUrl}map_pointer/greenmarker.png`,
      //       shadowUrl: 'https://unpkg.com/leaflet@1.3.1/dist/images/marker-shadow.png',
      //     });
      //     this.map1 = L.map("po-5-rcihs-map").setView([-11.202692, 17.873886], 3);
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
      //         $("#rcih_location_p5").html(name.location);
      //         $("#rcih_organization_p5").html(name.Organization);
      //         $("#rcih_name_p5").html(name.rcih_name);
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
    const request = { "purpose": "PO5", "rcih": "po5rcih" };
    const countryData=$("#po5_country_list").val();
    if(countryData?.length){
      request.country_id=countryData
    }
    post("dashboard", request).then(response => {
      this.richdata = response;
      this.rcihwisepo5NarsRchisAdoptingDataChart();
      this.rcihwisepo5NarsRchisPipsDataChart();
      this.rcihwisesuccessImpactStoriesChart();
      this.rcihwisepeoplereachedSuccessImpactStoriesChart();

    }).catch().finally(() => {
      setTimeout(() => hideLoader(), 1000);
    });
  }

  generateProgramwiseMap() {
    this.map = L.map("po-5-programwise-map").setView([-11.202692, 17.873886], 3);
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
        $("#map_crops_p5").html(name.crops);
        $("#map_partners_p5").html(name.partners);
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
    $("#po5_country_list").multipleSelect('destroy');
      setTimeout(()=>{
        const optionData=country.map(d=>{
           return `<option value="${d.country_id}">${d.country_name}</option>`
              }).join('\n');
              $("#po5_country_list").html(optionData);
          $("#po5_country_list").multipleSelect();
      }
    )
  }
  cropList() {
    const crops = this.filterData.crops_list;
    $("#po5_crop_list").multipleSelect('destroy');
      setTimeout(()=>{
        const optionData=crops.map(d=>{
           return `<option value="${d.crop_id}">${d.crop_name}</option>`
              }).join('\n');
              $("#po5_crop_list").html(optionData);
          $("#po5_crop_list").multipleSelect();
      }
    )
  }

  getPO5Data() {
    showLoader();
    const request = { "purpose": "PO5" };
    const countryData=$("#po5_country_list").val();
    if(countryData?.length){
      request.country_id=countryData
    }
    const cropData=$("#po5_crop_list").val();
    if(cropData?.length){
      request.crop_id=cropData
    }
    post('dashboard', request).then(response => {
      // To do generate chart
      this.poFiveData = response;

      this.po5NarsRchisAdoptingDataChart();
      this.po5NarsRchisPipsDataChart();
      this.successImpactStoriesChart();
      this.peoplereachedSuccessImpactStoriesChart();
      this.sesuccessImpactStoriesTable();

    }).catch().finally(() => {
      setTimeout(() => hideLoader(), 1000);
    });
  }
  sesuccessImpactStoriesTable() {
    
    var mydata = this.poFiveData.success_impactstories_table;
    //console.log(mydata);
    // const tableData= mydata.map(d =>{
    //   const result=`
    //   <tr>
    //     <td>${d.country}</td>
    //     <td>${d.crop}</td>
    //     <td>${d.name}</td>
    //     <td>${d.type}</td>
    //     <td>
    //       <a href="${d.link}" target="_blank" class="text-dark">${d.link}</a>
    //     </td>
    //   </tr>
    //   `;
    //   return result;
    // })

		const tableData = mydata.map(group => {
			const child = group.child;
			if (child.length) {
				 return group.child.map((data, i) => {
				let tData  = ``;
						if (i == 0) {
								tData += `\n <td rowspan="${child.length}">
										${group.country}
									</td>
									<td rowspan="${child.length}">
										${group.crop}
									</td>
									<td rowspan="${child.length}">
										${group.name}
									</td>
									\n`;
							}
							
							tData += `\n
							<td>${data.type}</td>
							<td>
							<a href="${data.link}" target="_blank" class="text-dark">${data.link}</a>
							</td>
							\n`;
							return `<tr>
							${tData}
						</tr>
				`;
		
					
					}).join();
			} else {
				return `
				<tr>
					\n <td>
										${group.country}
									</td>
									<td>
										${group.crop}
									</td>
									<td>
										${group.name}
									</td>
									<td></td>
									<td></td>
									\n
				
				</tr>
				
				`
			}
		});
    
    $('#resultpo5>tbody').html(tableData);
    $("tbody>tr").addClass("tbl_bg");
    
  }
  //Graph -1
  po5NarsRchisAdoptingDataChart() {
    const po5_nars_rchis_adopting_data = this.poFiveData.po5_nars_rchis_adopting_data;

    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_number_of_NARS_digitized_MLE",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = po5_nars_rchis_adopting_data


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of NARS";
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
      bullet.label.fontSize = "12px";
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
  po5NarsRchisPipsDataChart() {
    $("#program_wise_number_of_NARS_PIPs_developed").html("");
    const po5_nars_rchis_pips_data = this.poFiveData.po5_nars_rchis_pips_data;
    if(!po5_nars_rchis_pips_data?.length){
      $("#program_wise_number_of_NARS_PIPs_developed").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_number_of_NARS_PIPs_developed",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = po5_nars_rchis_pips_data


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of NARS";
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
      bullet.label.fontSize = "12px";
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
  successImpactStoriesChart() {
    $("#program_wise_number_of_success_and_impact_stories").html("");

    const success_impactstories = this.poFiveData.success_impactstories;
    if(!success_impactstories?.length){
      $("#program_wise_number_of_success_and_impact_stories").html(nodata_html());
      return;
    }
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_number_of_success_and_impact_stories",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = success_impactstories


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of success and impact stories";
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
      bullet.label.fontSize = "12px";
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
  //Graph -4
  peoplereachedSuccessImpactStoriesChart() {
    const peoplereached_success_impactstories = this.poFiveData.peoplereached_success_impactstories;

    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      // Create chart instance
      var chart = am4core.create(
        "program_wise_number_of_people_reached_by_the_success_and_impact",
        am4charts.XYChart
      );
      chart.logo.disabled = "true";
      chart.scrollbarX = new am4core.Scrollbar();

      // Add data
      chart.data = peoplereached_success_impactstories


      // Create value axis
      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.title.text = "Number of People reached";
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
      bullet.label.fontSize = "12px";
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

  rcih_po5_piechart(divid,data){
    am4core.ready(function () {
      // Themes begin
      am4core.useTheme(am4themes_animated);
      // Themes end

      var chart = am4core.create(divid, am4charts.PieChart3D);
      chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
      chart.logo.disabled = "true";

      chart.legend = new am4charts.Legend();

      chart.data = data;

      var series = chart.series.push(new am4charts.PieSeries3D());
      series.dataFields.value = "count";
      series.dataFields.category = "program_name";
      series.labels.template.maxWidth = 90;
      series.labels.template.wrap = true;
    }); // end am4core.ready()
  }

  rcihwisepo5NarsRchisAdoptingDataChart() {
    const po5_nars_rchis_adopting_data = this.richdata.po5_nars_rchis_adopting_data;
    this.rcih_po5_piechart("rcih_wise_number_of_NARS_digitized_MLE",po5_nars_rchis_adopting_data)
    
  }

  rcihwisepo5NarsRchisPipsDataChart() {
    $("#rcih_wise_number_of_NARS_PIPs_developed").html("");

    const po5_nars_rchis_pips_data = this.richdata.po5_nars_rchis_pips_data;
    if(!po5_nars_rchis_pips_data?.length){
      $("#rcih_wise_number_of_NARS_PIPs_developed").html(nodata_html());
      return;
    }
    this.rcih_po5_piechart("rcih_wise_number_of_NARS_PIPs_developed",po5_nars_rchis_pips_data)
  }

  rcihwisesuccessImpactStoriesChart() {
    $("#rcih_wise_number_of_success_and_impact_stories").html("");
    const success_impactstories = this.richdata.success_impactstories;
    if(!success_impactstories?.length){
      $("#rcih_wise_number_of_success_and_impact_stories").html(nodata_html());
      return;
    }
    this.rcih_po5_piechart("rcih_wise_number_of_success_and_impact_stories",success_impactstories)
    
  }

  rcihwisepeoplereachedSuccessImpactStoriesChart() {
    const peoplereached_success_impactstories = this.richdata.peoplereached_success_impactstories;
    this.rcih_po5_piechart("rcih_wise_number_of_people_reached_by_the_success_and_impact",peoplereached_success_impactstories)
  }

}

