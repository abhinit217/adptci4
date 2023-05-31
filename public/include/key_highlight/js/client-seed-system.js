class ClientSeedSystem {
	constructor() {
		this.getApiData();
	}

	getApiData() {
		const request = { purpose: "CLIENTORIENTEDSEEDSYSTEM" };
		showLoader();
		post("dashboard", request)
			.then((response) => {
				if (response?.status == 1) {
					this.init(response);
				} else {
					console.error("Error in data");
				}
			})
			.catch((e) => console.error(e))
			.finally(() => hideLoader());
	}

	init(data) {
		this.apiData = data;
		this.generateLabels();
		this.generateCharts();
	}

	generateLabels() {
		const hybird_p1 = this.apiData.hybrid_opv_spv_data_4
			.map((d) => d.hybrid)
			.reduce((a, b) => a + b, 0);
		const opv_p1 = this.apiData.hybrid_opv_spv_data_4
			.map((d) => d.opv)
			.reduce((a, b) => a + b, 0);
		const spv_p1 = this.apiData.hybrid_opv_spv_data_4
			.map((d) => d.spv)
			.reduce((a, b) => a + b, 0);
		$("#hybrid_4").html(hybird_p1);
		$("#opv_4").html(opv_p1);
		$("#spv_4").html(spv_p1);
		$("#total_411").html(hybird_p1 + opv_p1 + spv_p1);

		$("#breederseed").html(this.apiData.breederseed.toFixed(2));
		$("#foundationseed").html(this.apiData.foundationseed.toFixed(2));
		$("#certifiedqdsseed").html(this.apiData.certifiedqdsseed.toFixed(2));

		$("#dwn-csv-32").on("click", function () {
			$("#resultpo32").table2csv({
				file_name: "avisa-mapping-enduser-profile.csv",
				header_body_space: 0,
			});
		});

		$("#dwn-csv-411").on("click", function () {
			$("#resultpo411").table2csv({
				file_name: "avisa-mapping-varietyname.csv",
				header_body_space: 0,
			});
		});
	}
	generateCharts() {
		setTimeout(() => this.seedImprovedVaritiesChart());
		setTimeout(() => this.seedImprovedVaritiesTable());
		setTimeout(() => this.farmersRecycleChart());
		setTimeout(() => this.demosConductedChart());
		setTimeout(() => this.cropwisedemosConductedChart());
		setTimeout(() => this.demosDifferentHostChart());
		setTimeout(() => this.demoConductMaleFemaleDisaggregationChart());
		setTimeout(() => this.fielddaysConductedChart());
		setTimeout(() => this.cropwisefielddaysConductedChart());
		setTimeout(() => this.fielddaysMaleFemaleDisaggregationChart());
		setTimeout(() => this.radioTvShowsChart());
		setTimeout(() => this.seedConductedChart());
		setTimeout(() => this.seedConductedCategoryChart());
		setTimeout(() => this.seedfairsMaleFemaleDisaggregationChart());
		setTimeout(() => this.radioTvMalefemaleDisaggregationChart());
		setTimeout(() => this.tvMalefemaleDisaggregationChart());
		setTimeout(() => this.seedDistributedSoldChart());
		setTimeout(() => this.cropwiseSeedPacksChart());
		setTimeout(() => this.distributedByNoCostCategoryChart());
		setTimeout(() => this.soldPackCategoryChart());
		setTimeout(() => this.quantitywiseSeedDistributedSoldChart());
		setTimeout(() => this.yearwiseSeedDistributedSoldChart());
		setTimeout(() => this.seedpackMaleFemaleDataChart());
		setTimeout(() => this.farmersReachedDataChart());
		setTimeout(() => this.hybridVarietyReleasedChart());
		setTimeout(() => this.generateHybridSvpSankeyGraph());
		setTimeout(() => this.hybridDataTableTable());
		setTimeout(() => this.onYieldChart());
		setTimeout(() => this.trainingEventsChart());
		setTimeout(() => this.traningStackholderChart());
		setTimeout(() => this.trainingCatogoryChart());
		setTimeout(() => this.traningCategoryStackholderChart());
		setTimeout(() => this.programWiseCropChart());
		setTimeout(() => this.programWiseCountryChart());
		setTimeout(() => this.yearCountryChart());
		setTimeout(() => this.keyproducerSeedproductionChart());
		setTimeout(() => this.generateBubbleMap());
		setTimeout(() => this.certifiedQdsSeedDataCharts());
		setTimeout(() => this.profitabilityAnalysisToolsChart());
		setTimeout(() => this.publicPrivatePartnersAdoptingChart());
		setTimeout(() => this.commercializedVarietiesChart());
	}

	seedImprovedVaritiesChart() {
		$("#percent_of_women_and_youth_quantity_seed").html("");

		const seed_improvedvarities = this.apiData.seed_improvedvarities;
		const seed_rt = this.apiData.indicator_75_final_value;
		//console.log(seed_improvedvarities);
		let formal_source =
			seed_improvedvarities
				.map((e) => e.formal_source)
				.reduce((a, b) => a + b, 0) || 0;
		let informal_source =
			seed_improvedvarities
				.map((e) => e.informal_source)
				.reduce((a, b) => a + b, 0) || 0;

		$("#percent_of_women_and_youth_quantity_seed_count").html(seed_rt);
		if (!seed_improvedvarities?.length) {
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
			chart.data = seed_improvedvarities;

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
	seedImprovedVaritiesTable() {
		var mydata = this.apiData.seed_improvedvarities_table;

		const tableData = mydata.map((d) => {
			const result = `
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
		});

		$("#resultpo32>tbody").html(tableData);
		$("tbody>tr").addClass("tbl_bg");
	}
	farmersRecycleChart() {
		$("#percent_of_women_and_youth_farmer_recycle").html("");

		const farmersrecycle = this.apiData.farmersrecycle;
		const indicator_76_final_value = this.apiData.indicator_76_final_value;
		//console.log(farmersrecycle);
		//let total_val= farmersrecycle.map((e) => e.count).reduce((a, b) => a + b, 0) || 0

		$("#percent_of_women_and_youth_farmer_recycle_count").html(
			indicator_76_final_value
		);
		if (!farmersrecycle?.length) {
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
			chart.data = farmersrecycle;

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
	demosConductedChart() {
		$("#program_demonstrationsconducted").html("");
		const demos_conducted = this.apiData.demos_conducted_country;
		//let demos_conducted_count=demos_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
		let demos_different_host_count =
			this.apiData.demos_different_host
				.map((e) => e.count)
				.reduce((a, b) => a + b, 0) || 0;
		$("#demos_conducted_count").html(demos_different_host_count);
		if (!demos_conducted?.length) {
			$("#program_demonstrationsconducted").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_demonstrationsconducted",
				am4charts.XYChart
			);
			chart.scrollbarX = new am4core.Scrollbar();
			chart.logo.disabled = "true";

			// Add data
			chart.data = demos_conducted;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 0;
			categoryAxis.renderer.labels.template.rotation = 270;

			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.tooltip.disabled = true;
			categoryAxis.renderer.minHeight = 110;

			// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.minWidth = 50;

			var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
			yAxis.extraMax = 0.2;
			yAxis.min = 0;
			yAxis.title.text = "Number of demonstrations";
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

			// on hover, make corner radiuses bigger
			var hoverState = series.columns.template.column.states.create("hover");
			hoverState.properties.cornerRadiusTopLeft = 0;
			hoverState.properties.cornerRadiusTopRight = 0;
			hoverState.properties.fillOpacity = 1;

			var bullet = series.bullets.push(new am4charts.LabelBullet());
			bullet.interactionsEnabled = false;
			bullet.dy = -10;
			bullet.label.text = "{valueY}";
			bullet.label.fontSize = "8px";
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
	cropwisedemosConductedChart() {
		$("#crop_wise_demonstrationsconducted").html("");
		const demos_conducted = this.apiData.demos_conducted_crop;
		demos_conducted.forEach((d) => {
			const esaType = esaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			const wcaType = wcaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			if (esaType) {
				d.program_name = d.program_name.replace(esaType, "ESA");
			} else if (wcaType) {
				d.program_name = d.program_name.replace(wcaType, "WCA");
			}
		});

		const programList = Array.from(
			new Set(demos_conducted.map((d) => d.program_name))
		);

		const chartData = programList.map((pName) => {
			const result = { program_name: pName };
			// if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
			//   result.program_name = pName?.substring(0, pName?.indexOf('-'))
			// }
			result["count"] = demos_conducted
				.filter((d) => d.program_name == pName)
				.map((d) => d.count)
				.reduce((v1, v2) => v1 + v2, 0);
			return result;
		});

		$("#crop_wise_demos_conducted_count").html(
			chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
		);
		if (!chartData?.length) {
			$("#crop_wise_demonstrationsconducted").html(nodata_html());
			return;
		}
		this.rcih_po4_piechart("crop_wise_demonstrationsconducted", chartData);
	}
	demosDifferentHostChart() {
		$("#hostedby_array").html("");

		const demos_different_host = this.apiData.demos_different_host.sort(
			(a, b) => a.count - b.count
		);

		// console.log(demos_different_host);
		if (!demos_different_host?.length) {
			$("#hostedby_array").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create("hostedby_array", am4charts.XYChart);
			chart.logo.disabled = "true";
			chart.scrollbarX = new am4core.Scrollbar();

			// Add data
			chart.data = demos_different_host;

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.title.text = "Number of demonstrations";
			valueAxis.title.fontWeight = "bold";

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";

			// Configure axis label
			var label = categoryAxis.renderer.labels.template;
			//label.truncate = true;
			//label.maxWidth = 120;
			label.tooltipText = "{name}";

			// Create series
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.sequencedInterpolation = true;
			series.dataFields.valueY = "count";
			series.dataFields.categoryX = "name";
			series.tooltipText = "[{categoryX}: bold]{name}-{valueY}[/]";
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
	demoConductMaleFemaleDisaggregationChart() {
		$("#demonstrationsconducted_country").html("");

		const demos_different_host_male_female_country =
			this.apiData.demos_different_host_male_female_country;
		//console.log(fielddays_malefemale_disaggregation);

		demos_different_host_male_female_country.forEach((d) => {
			d.totalCount = d.male_count + d.female_count;
			d.none = 0;
		});
		const chartData = demos_different_host_male_female_country.filter(
			(e) => e.totalCount != 0
		);

		if (!demos_different_host_male_female_country?.length) {
			$("#demonstrationsconducted_country").html(nodata_html("450px"));
			return;
		}

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"demonstrationsconducted_country",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";

			// Add data
			// demos_different_host_male_female_country.forEach(d => d.none = 0)
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 30;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.min = 0;
			valueAxis.title.text = "Percentage (%) of male / female";
			valueAxis.title.fontWeight = "bold";

			// Create series
			function createSeries(field, name) {
				// Set up series
				var series = chart.series.push(new am4charts.ColumnSeries());
				series.name = name;
				series.dataFields.valueY = field;
				series.dataFields.categoryX = "program_name";
				series.sequencedInterpolation = true;
				series.columns.template.width = am4core.percent(80);

				// Make it stacked
				series.stacked = true;

				// Configure columns
				// series.columns.template.width = am4core.percent(60);
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				labelBullet.label.fontSize = 8;
				// labelBullet.label.text = "{valueY}";
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}
			createSeries("female_count", "Female");
			createSeries("male_count", "Male");

			// Create series for total valueAxis.calculateTotals = true;
			var totalSeries = chart.series.push(new am4charts.ColumnSeries());
			totalSeries.dataFields.valueY = "none";
			totalSeries.dataFields.categoryX = "program_name";
			totalSeries.stacked = true;
			totalSeries.hiddenInLegend = true;
			totalSeries.columns.template.strokeOpacity = 0;

			var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
			totalBullet.dy = -20;
			totalBullet.label.text = "{valueY.total}";
			totalBullet.label.tooltipText = "{valueY.total}";
			totalBullet.label.hideOversized = false;
			totalBullet.label.fontSize = 10;
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 5, 5, 5);

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			// chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	fielddaysConductedChart() {
		$("#program_fielddaysconducted").html("");

		const fielddays_conducted = this.apiData.fielddays_conducted_country;
		$("#fielddays_conducted_count").html(
			fielddays_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
		);
		if (!fielddays_conducted?.length) {
			$("#program_fielddaysconducted").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_fielddaysconducted",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";
			chart.scrollbarX = new am4core.Scrollbar();

			// Add data
			chart.data = fielddays_conducted;

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.title.text = "Number of field days";
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
	cropwisefielddaysConductedChart() {
		$("#rcih_wise_fielddaysconducted").html("");

		const fielddays_conducted = this.apiData.fielddays_conducted_crop;
		fielddays_conducted.forEach((d) => {
			const esaType = esaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			const wcaType = wcaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			if (esaType) {
				d.program_name = d.program_name.replace(esaType, "ESA");
			} else if (wcaType) {
				d.program_name = d.program_name.replace(wcaType, "WCA");
			}
		});

		const programList = Array.from(
			new Set(fielddays_conducted.map((d) => d.program_name))
		);

		const chartData = programList.map((pName) => {
			const result = { program_name: pName };
			// if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
			//   result.program_name = pName?.substring(0, pName?.indexOf('-'))
			// }
			result["count"] = fielddays_conducted
				.filter((d) => d.program_name == pName)
				.map((d) => d.count)
				.reduce((v1, v2) => v1 + v2, 0);
			return result;
		});
		$("#rcih_wise_fielddays_conducted_count").html(
			chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
		);
		if (!chartData?.length) {
			$("#rcih_wise_fielddaysconducted").html(nodata_html());
			return;
		}
		this.rcih_po4_piechart("rcih_wise_fielddaysconducted", chartData);
	}
	fielddaysMaleFemaleDisaggregationChart() {
		$("#programwise_total_fielddays_malefemale").html("");

		const fielddays_malefemale_disaggregation =
			this.apiData.fielddays_malefemale_disaggregation;
		//console.log(fielddays_malefemale_disaggregation);
		if (!fielddays_malefemale_disaggregation?.length) {
			$("#programwise_total_fielddays_malefemale").html(nodata_html("750px"));
			return;
		}

		$("#fielddays_male_count").html(
			fielddays_malefemale_disaggregation
				.map((e) => e.male_count)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#fielddays_female_count").html(
			fielddays_malefemale_disaggregation
				.map((e) => e.female_count)
				.reduce((a, b) => a + b, 0) || 0
		);

		$("#fielddays_total_count").html(
			fielddays_malefemale_disaggregation
				.map((e) => e.male_count)
				.reduce((a, b) => a + b, 0) +
			fielddays_malefemale_disaggregation
				.map((e) => e.female_count)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"programwise_total_fielddays_malefemale",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";

			// Add data
			fielddays_malefemale_disaggregation.forEach((d) => (d.none = 0));
			chart.data = fielddays_malefemale_disaggregation;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 30;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.title.text = "Percentage (%) of male / female";
			valueAxis.title.fontWeight = "bold";

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
				series.columns.template.width = am4core.percent(80);
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				labelBullet.label.fontSize = 10;
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}
			createSeries("female_count", "Female");
			createSeries("male_count", "Male");

			// Create series for total valueAxis.calculateTotals = true;
			var totalSeries = chart.series.push(new am4charts.ColumnSeries());
			totalSeries.dataFields.valueY = "none";
			totalSeries.dataFields.categoryX = "program_name";
			totalSeries.stacked = true;
			totalSeries.hiddenInLegend = true;
			totalSeries.columns.template.strokeOpacity = 0;

			var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
			totalBullet.dy = -20;
			totalBullet.label.text = "{valueY.total}";
			totalBullet.label.tooltipText = "{valueY.total}";
			//totalBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
			totalBullet.label.hideOversized = false;
			totalBullet.label.fontSize = 10;
			totalBullet.label.fontWeight = 400;
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 5, 5, 5);

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			// chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	radioTvShowsChart() {
		$("#program_wise_no_of_radio_tv").html("");

		const radio_tv_shows = this.apiData.radio_tv_shows;
		//console.log(radio_tv_shows);
		let radio_shows_count =
			radio_tv_shows.map((e) => e.radio_val).reduce((a, b) => a + b, 0) || 0;
		let tv_shows_count =
			radio_tv_shows.map((e) => e.tc_val).reduce((a, b) => a + b, 0) || 0;
		$("#program_wise_no_of_radio_tvd_count").html(
			radio_shows_count + tv_shows_count
		);
		if (!radio_tv_shows?.length) {
			$("#program_wise_no_of_radio_tv").html(nodata_html("550px"));
			return;
		}

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_no_of_radio_tv",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";

			//console.log(radio_tv_shows);
			// Add data
			radio_tv_shows.forEach((d) => (d.none = 0));

			//console.log(radio_tv_shows);
			chart.data = radio_tv_shows;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.labels.template.rotation = 270;

			categoryAxis.renderer.minGridDistance = 30;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.2;
			valueAxis.calculateTotals = true;
			// valueAxis.renderer.opposite = true;
			valueAxis.title.text = "Number of radio/TV shows";
			valueAxis.title.fontWeight = 800;

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
				series.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				// labelBullet.label.text = "{valueY}";
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}

			createSeries("radio_val", "Radio");
			createSeries("tc_val", "TV");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	seedConductedChart() {
		$("#program_seedfairs").html("");

		//Graph -7
		const seed_conducted = this.apiData.seed_conducted;
		const agri_conducted = this.apiData.agri_conducted;

		const chartData = Array.from(
			new Set([...seed_conducted, ...agri_conducted].map((d) => d.program_name))
		).map((d) => {
			const result = { program_name: d, none: 0 };
			result["seed_conducted"] =
				seed_conducted.find((e) => e.program_name == d)?.count || 0;
			result["agri_conducted"] =
				agri_conducted.find((e) => e.program_name == d)?.count || 0;
			result["slno"] =
				seed_conducted.find((e) => e.program_name == d)?.slno ||
				agri_conducted.find((e) => e.program_name == d)?.slno;

			return result;
		});
		chartData.sort((a, b) => a.slno - b.slno);
		// console.log(chartData);
		let agri_conducted_count =
			this.apiData.agri_conducted
				.map((e) => e.count)
				.reduce((a, b) => a + b, 0) || 0;
		let seed_conducted_count =
			seed_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
		$("#seed_conducted_count").html(
			agri_conducted_count + seed_conducted_count
		);
		if (!seed_conducted?.length) {
			$("#program_seedfairs").html(nodata_html());
			return;
		}

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create("program_seedfairs", am4charts.XYChart);
			chart.logo.disabled = "true";

			chartData.forEach((d) => (d.none = 0));
			// console.log(chartData);
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.labels.template.rotation = 270;

			categoryAxis.renderer.minGridDistance = 30;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			// valueAxis.renderer.opposite = true;
			// valueAxis.title.text = "Number of seed/agri shows";
			valueAxis.title.text = "Number of seed fairs/ agriculture shows";
			valueAxis.title.fontWeight = 800;

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
				series.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				// labelBullet.label.text = "{valueY}";
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}

			createSeries("seed_conducted", "Seed fairs conducted");
			createSeries("agri_conducted", "Agriculture shows conducted");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	seedConductedCategoryChart() {
		$("#seedfairs_participanttype_array").html("");

		const seed_conducted_category = this.apiData.seed_conducted_category.filter(
			(d) => d.value
		);
		const agri_conducted_category = this.apiData.agri_conducted_category.filter(
			(d) => d.value
		);

		const chartData = Array.from(
			new Set(
				[...seed_conducted_category, ...agri_conducted_category].map(
					(d) => d.cname
				)
			)
		).map((d) => {
			const result = { cname: d, none: 0 };
			result["seed_conducted"] =
				seed_conducted_category.find((e) => e.cname == d)?.value || 0;
			result["agri_conducted"] =
				agri_conducted_category.find((e) => e.cname == d)?.value || 0;
			result["total"] =
				(seed_conducted_category.find((e) => e.cname == d)?.value || 0) +
				(agri_conducted_category.find((e) => e.cname == d)?.value || 0);

			return result;
		});

		const totalVal = chartData.map((d) => d.total).reduce((a, b) => a + b, 0);
		chartData.forEach((f) => (f.percent = (f.total * 100) / totalVal));

		const nonOtherData = chartData.filter((d) => d.percent > 5);
		const otherData = { cname: "Other" };
		otherData["total"] = chartData
			.filter((d) => d.percent <= 5)
			.map((f) => f.total)
			.reduce((a, b) => a + b, 0);

		const actualChartData = [...nonOtherData, otherData];

		//console.log(actualChartData);

		//console.log(chartData);
		if (!actualChartData?.length) {
			$("#seedfairs_participanttype_array").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			var chart = am4core.create(
				"seedfairs_participanttype_array",
				am4charts.PieChart3D
			);
			chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
			chart.logo.disabled = "true";

			chart.legend = new am4charts.Legend();

			chart.data = actualChartData;

			var series = chart.series.push(new am4charts.PieSeries());
			series.dataFields.value = "total";
			series.dataFields.category = "cname";
			// series.legendSettings.labelText =
			// 	"[bold {color}]{name}[/] - [bold {color}]{value}[/]";

			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	seedfairsMaleFemaleDisaggregationChart() {
		$("#programwise_seedfairs_malefemale").html("");
		const seedfairs_malefemale_disaggregation =
			this.apiData.seedfairs_malefemale_disaggregation;
		const agri_malefemale_disaggregation =
			this.apiData.agri_malefemale_disaggregation;

		const totalArr = [
			...seedfairs_malefemale_disaggregation,
			...agri_malefemale_disaggregation,
		];
		const chartData = Array.from(new Set(totalArr.map((d) => d.slno))).map(
			(slno) => {
				const male_count = totalArr
					.filter((d) => d.slno == slno)
					.map((d) => d.male_count)
					.reduce((a, b) => a + b, 0);
				const female_count = totalArr
					.filter((d) => d.slno == slno)
					.map((d) => d.female_count)
					.reduce((a, b) => a + b, 0);
				const program_name = totalArr.find((d) => d.slno == slno)?.program_name;
				return { male_count, female_count, program_name, slno };
			}
		);
		chartData.sort((a, b) => a.slno - b.slno);
		//console.log(chartData);

		if (!chartData?.length) {
			$("#programwise_seedfairs_malefemale").html(nodata_html("600px"));
			return;
		}

		$("#stakeholders_male_count").html(
			totalArr.map((e) => e.male_count).reduce((a, b) => a + b, 0) || 0
		);
		$("#stakeholders_female_count").html(
			totalArr.map((e) => e.female_count).reduce((a, b) => a + b, 0) || 0
		);

		$("#stakeholders_total_count").html(
			totalArr.map((e) => e.male_count).reduce((a, b) => a + b, 0) +
			totalArr.map((e) => e.female_count).reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"programwise_seedfairs_malefemale",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";

			// Add data
			chartData.forEach((d) => (d.none = 0));

			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.labels.template.rotation = 270;

			categoryAxis.renderer.minGridDistance = 30;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			// valueAxis.renderer.opposite = true;
			valueAxis.title.text = "Percentage (%) of male / female";
			valueAxis.title.fontWeight = 800;

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
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				// labelBullet.label.text = "{valueY}";
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}

			createSeries("male_count", "Male");
			createSeries("female_count", "Female");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	radioTvMalefemaleDisaggregationChart() {
		$("#program_wise_segregation_of_farmers").html("");

		const radio_malefemale_disaggregation =
			this.apiData.radio_malefemale_disaggregation;

		radio_malefemale_disaggregation
			.filter(
				(e) =>
					e.program_name != "Nigeria-Sorghum" &&
					e.program_name != "Uganda-Common bean"
			)
			.forEach((d) => {
				d.totalCount = d.male_count + d.female_count;
				d.none = 0;
			});
		const chartData = radio_malefemale_disaggregation.filter(
			(e) => e.totalCount != 0
		);

		if (!radio_malefemale_disaggregation?.length) {
			$("#program_wise_segregation_of_farmers").html(nodata_html("550px"));
			return;
		}

		$("#radio_male_count").html(
			radio_malefemale_disaggregation
				.map((e) => e.male_count)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#radio_female_count").html(
			radio_malefemale_disaggregation
				.map((e) => e.female_count)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#radio_total_count").html(
			radio_malefemale_disaggregation
				.map((e) => e.male_count)
				.reduce((a, b) => a + b, 0) +
			radio_malefemale_disaggregation
				.map((e) => e.female_count)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_segregation_of_farmers",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";

			// Add data
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;
			// categoryAxis.title.text = "Number of male/female";

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.title.text = "Number of male/female";
			valueAxis.title.fontWeight = "bold";
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
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
				series.columns.template.width = am4core.percent(80);
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				// labelBullet.label.text = "{valueY}";
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}

			createSeries("male_count", "Male");
			createSeries("female_count", "Female");

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
			totalBullet.label.truncate = false;
			// totalBullet.label.rota = 8;

			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			// Legend
			chart.legend = new am4charts.Legend();
			// chart.legend.position = 'top'
			chart.legend.paddingBottom = 20;
			chart.legend.labels.template.maxWidth = 95;

			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	tvMalefemaleDisaggregationChart() {
		$("#program_wise_segregation_of_farmers_tv").html("");

		const tv_malefemale_disaggregation =
			this.apiData.tv_malefemale_disaggregation;

		tv_malefemale_disaggregation.forEach((d) => {
			d.totalCount = d.male_count + d.female_count;
			d.none = 0;
		});
		const chartData = tv_malefemale_disaggregation.filter(
			(e) => e.totalCount != 0
		);

		if (!tv_malefemale_disaggregation?.length) {
			$("#program_wise_segregation_of_farmers_tv").html(nodata_html("550px"));
			return;
		}

		$("#tv_male_count").html(
			tv_malefemale_disaggregation
				.map((e) => e.male_count)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#tv_female_count").html(
			tv_malefemale_disaggregation
				.map((e) => e.female_count)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#tv_total_count").html(
			tv_malefemale_disaggregation
				.map((e) => e.male_count)
				.reduce((a, b) => a + b, 0) +
			tv_malefemale_disaggregation
				.map((e) => e.female_count)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_segregation_of_farmers_tv",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";

			// Add data
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;
			// categoryAxis.title.text = "Number of male/female";

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.title.text = "Percentage (%) of male / female";
			valueAxis.title.fontWeight = "bold";
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
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
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				// labelBullet.label.text = "{valueY}";
				labelBullet.locationY = 0.5;
				labelBullet.label.hideOversized = true;

				return series;
			}

			createSeries("male_count", "Male");
			createSeries("female_count", "Female");

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
			totalBullet.label.truncate = false;
			// totalBullet.label.rota = 8;

			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			// Legend
			chart.legend = new am4charts.Legend();
			// chart.legend.position = 'top'
			chart.legend.paddingBottom = 20;
			chart.legend.labels.template.maxWidth = 95;

			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	seedDistributedSoldChart() {
		$("#program_wise_no_of_small_seed_packs").html("");

		//Graph -15
		const seed_distributed_sold = this.apiData.seed_distributed_sold;
		//console.log(seed_distributed_sold);
		let distributed_val_count =
			seed_distributed_sold
				.map((e) => e.distributed_val)
				.reduce((a, b) => a + b, 0) || 0;
		let sold_val_count =
			seed_distributed_sold.map((e) => e.sold_val).reduce((a, b) => a + b, 0) ||
			0;
		$("#program_wise_no_of_small_seed_packs_count").html(
			distributed_val_count + sold_val_count
		);
		if (!seed_distributed_sold?.length) {
			$("#program_wise_no_of_small_seed_packs").html(nodata_html("550px"));
			return;
		}

		am4core.ready(function () {
			/**
			 * ---------------------------------------
			 * This demo was created using amCharts 4.
			 *
			 * For more information visit:
			 * https://www.amcharts.com/
			 *
			 * Documentation is available at:
			 * https://www.amcharts.com/docs/v4/
			 * ---------------------------------------
			 */

			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_no_of_small_seed_packs",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";
			chart.logo.disabled = "true";

			// Add data
			seed_distributed_sold.forEach((d) => (d.none = 0));
			chart.data = seed_distributed_sold;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.2;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Number of packs distributed/sold";
			valueAxis.title.fontWeight = 800;

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
				series.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;
				labelBullet.propertyFields.rotation = 270;

				return series;
			}

			createSeries("distributed_val", "Distributed at no cost");
			createSeries("sold_val", "Sold");

			// Create series for total
			var totalSeries = chart.series.push(new am4charts.ColumnSeries());
			totalSeries.dataFields.valueY = "none";
			totalSeries.dataFields.categoryX = "program_name";
			totalSeries.stacked = true;
			totalSeries.hiddenInLegend = true;
			totalSeries.columns.template.strokeOpacity = 0;

			// var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
			// totalBullet.dy = -20;
			// totalBullet.label.text = "{valueY.total}";
			// totalBullet.label.hideOversized = false;
			// totalBullet.label.fontSize = 10;
			// totalBullet.label.background.fill = totalSeries.stroke;
			// totalBullet.label.background.fillOpacity = 0.2;
			// totalBullet.label.padding(5, 10, 5, 10);

			var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
			totalBullet.dy = -20;
			totalBullet.label.text = "{valueY.total}";
			totalBullet.label.tooltipText = "{valueY.total}";
			//totalBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
			totalBullet.label.hideOversized = false;
			totalBullet.label.fontSize = 10;
			totalBullet.label.fontWeight = 400;
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 5, 5, 5);

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			// chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
	cropwiseSeedPacksChart() {
		$("#crop_wise_no_of_small_seed_packs").html("");
		const seed_distributed_sold_crop_wise =
			this.apiData.seed_distributed_sold_crop_wise;
		seed_distributed_sold_crop_wise.forEach((d) => {
			const esaType = esaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			const wcaType = wcaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			if (esaType) {
				d.program_name = d.program_name.replace(esaType, "ESA");
			} else if (wcaType) {
				d.program_name = d.program_name.replace(wcaType, "WCA");
			}
		});

		const programList = Array.from(
			new Set(seed_distributed_sold_crop_wise.map((d) => d.program_name))
		);

		const chartData = programList.map((pName) => {
			const result = { program_name: pName };
			// if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
			//   result.program_name = pName?.substring(0, pName?.indexOf('-'))
			// }
			result["count"] = seed_distributed_sold_crop_wise
				.filter((d) => d.program_name == pName)
				.map((d) => d.count)
				.reduce((v1, v2) => v1 + v2, 0);
			return result;
		});

		// $("#crop_wise_no_of_small_seed_packs_count").html(
		//   chartData.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
		// );
		if (!chartData?.length) {
			$("#crop_wise_no_of_small_seed_packs").html(nodata_html());
			return;
		}
		this.rcih_po4_piechart("crop_wise_no_of_small_seed_packs", chartData);
	}
	distributedByNoCostCategoryChart() {
		$("#distributed_by_no_cost").html("");

		const distributed_by_no_cost_category =
			this.apiData.distributed_by_no_cost_category;

		//console.log(chartData);
		if (!distributed_by_no_cost_category?.length) {
			$("#distributed_by_no_cost").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			var chart = am4core.create("distributed_by_no_cost", am4charts.PieChart);
			chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
			chart.logo.disabled = "true";

			chart.legend = new am4charts.Legend();

			chart.data = distributed_by_no_cost_category;

			var series = chart.series.push(new am4charts.PieSeries());
			series.dataFields.value = "value";
			series.dataFields.category = "cname";
			// series.legendSettings.labelText =
			// 	"[bold {color}]{name}[/] - [bold {color}]{value}[/]";

			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		}); // end am4core.ready()
	}
	soldPackCategoryChart() {
		$("#sold_by_category").html("");

		const sold_category = this.apiData.sold_category;

		//console.log(chartData);
		if (!sold_category?.length) {
			$("#sold_by_category").html(nodata_html());
			return;
		}

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create("sold_by_category", am4charts.PieChart);

			// Add data
			chart.data = sold_category;

			// Add and configure Series
			var pieSeries = chart.series.push(new am4charts.PieSeries());
			pieSeries.dataFields.value = "value";
			pieSeries.dataFields.category = "cname";
			pieSeries.slices.template.stroke = am4core.color("#fff");
			pieSeries.slices.template.strokeOpacity = 1;

			// This creates initial animation
			pieSeries.hiddenState.properties.opacity = 1;
			pieSeries.labels.template.fontSize = 12;
			pieSeries.labels.template.maxWidth = 120;
			pieSeries.labels.template.wrap = true;
			// pieSeries.hiddenState.properties.endAngle = -90;
			// pieSeries.hiddenState.properties.startAngle = -90;
			pieSeries.labels.template.padding = 20;
			// pieSeries.labels.template.paddingBottom = 0;
			// pieSeries.labels.template.paddingTop = 0;
			// pieSeries.labels.template.paddingBottom = 0;

			chart.hiddenState.properties.radius = am4core.percent(0);
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";

			chart.legend = new am4charts.Legend();
		}); // end am4core.ready()
		// am4core.ready(function () {
		//   // Themes begin
		//   am4core.useTheme(am4themes_animated);
		//   // Themes end

		//   var chart = am4core.create(
		//     "sold_by_category",
		//     am4charts.PieChart
		//   );
		//   chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
		//   chart.logo.disabled = "true";

		//   chart.legend = new am4charts.Legend();

		//   chart.data = sold_category;

		//   var series = chart.series.push(new am4charts.PieSeries());
		//   series.dataFields.value = "value";
		//   series.dataFields.category = "cname";
		//   series.labels.template.fontSize = 12;
		//   series.legendSettings.labelText = "[bold {color}]{name}[/] - [bold {color}]{value}[/]";

		//   chart.scrollbarX = new am4core.Scrollbar();
		//   chart.cursor = new am4charts.XYCursor();
		//   chart.exporting.menu = new am4core.ExportMenu();
		//   chart.exporting.filePrefix = "avisa";
		// }); // end am4core.ready()
	}
	quantitywiseSeedDistributedSoldChart() {
		$("#quantity_dist_sold_no_of_small_seed_packs").html("");

		//Graph -15
		const seed_pack_quantities = this.apiData.seed_pack_quantities;
		//console.log(seed_pack_quantities);
		if (!seed_pack_quantities?.length) {
			$("#quantity_dist_sold_no_of_small_seed_packs").html(
				nodata_html("550px")
			);
			return;
		}

		seed_pack_quantities.forEach((d) => {
			d.totalCount = (d.distributed_val_inkg + d.sold_val_inkg).toFixed(2);
			d.none = 0;
		});
		const chartData = seed_pack_quantities.filter((e) => e.totalCount != 0);
		$("#distributed_val_inkg").html(
			(
				seed_pack_quantities
					.map((e) => e.distributed_val_inkg)
					.reduce((a, b) => a + b, 0) || 0
			).toFixed(2)
		);
		$("#sold_val_inkg").html(
			(
				seed_pack_quantities
					.map((e) => e.sold_val_inkg)
					.reduce((a, b) => a + b, 0) || 0
			).toFixed(2)
		);

		$("#distributed_total_count").html(
			(
				seed_pack_quantities
					.map((e) => e.distributed_val_inkg)
					.reduce((a, b) => a + b, 0) +
				seed_pack_quantities
					.map((e) => e.sold_val_inkg)
					.reduce((a, b) => a + b, 0)
			).toFixed(2)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"quantity_dist_sold_no_of_small_seed_packs",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";
			chart.logo.disabled = "true";

			// Add data
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Quantity of packs distributed/sold (tons)";
			valueAxis.title.fontWeight = 800;
			// valueAxis.title.text = "Quantity (kgs)";
			// valueAxis.title.fontWeight = "bold";

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
				series.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;

				return series;
			}

			createSeries("distributed_val_inkg", "Distributed at no cost");
			createSeries("sold_val_inkg", "Sold");

			// Create series for total
			var totalSeries = chart.series.push(new am4charts.ColumnSeries());
			totalSeries.dataFields.valueY = "none";
			totalSeries.dataFields.categoryX = "program_name";
			totalSeries.stacked = true;
			totalSeries.hiddenInLegend = true;
			totalSeries.columns.template.strokeOpacity = 0;

			// var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
			// totalBullet.dy = -20;
			// totalBullet.label.text = "{valueY.total}";
			// totalBullet.label.hideOversized = false;
			// totalBullet.label.fontSize = 10;
			// totalBullet.label.background.fill = totalSeries.stroke;
			// totalBullet.label.background.fillOpacity = 0.2;
			// totalBullet.label.padding(5, 10, 5, 10);
			var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
			totalBullet.dy = -20;
			totalBullet.label.text = "{valueY.total}";
			totalBullet.label.tooltipText = "{valueY.total}";
			//totalBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
			totalBullet.label.hideOversized = false;
			totalBullet.label.fontSize = 10;
			totalBullet.label.fontWeight = 400;
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 5, 5, 5);

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			// chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
	yearwiseSeedDistributedSoldChart() {
		const cropCountryData = clone(this.apiData.year_crop_wise_data);
		// console.log(cropCountryData);

		const totalData = Object.keys(cropCountryData)
			.sort()
			.map((crop) => {
				const result = [];
				cropCountryData[crop].forEach((data) => {
					const d = clone(data);
					d.distributed_val = d.distributed_val
						? d.distributed_val
						: d.distributed_val;
					d.sold_val = d.sold_val ? d.sold_val : d.sold_val;
					//d.slno = d.index ? d.idex : d.index;
					d["crop"] = crop;
					d["none"] = 0;
					result.push(d);
				});
				return result.flat();
			})
			.flat();

		function GetSortOrder(prop) {
			return function (a, b) {
				if (a[prop] > b[prop]) {
					return 1;
				} else if (a[prop] < b[prop]) {
					return -1;
				}
				return 0;
			};
		}

		const cropsOptions = Object.keys(cropCountryData)
			.sort()
			.map((crop) => `<option value="${crop}"> ${crop} </option>`);
		cropsOptions.unshift(`<option value="All Crops"> All Crops </option>`);

		$("#seedcrop_year").html(cropsOptions);

		$("#seedcrop_year").on("change", () => {
			let filterData = [];
			if ($("#seedcrop_year").val() == "All Crops") {
				filterData = Array.from(new Set(totalData.map((d) => d.program_name)))
					.map((program_name) => {
						const result = {
							sold_val: 0,
							distributed_val: 0,
							program_name: program_name,
						};
						result.distributed_val = totalData
							.filter((d) => d.program_name == program_name)
							.map((d) => d.distributed_val)
							.reduce((v1, v2) => v1 + v2, 0);
						result.sold_val = totalData
							.filter((d) => d.program_name == program_name)
							.map((d) => d.sold_val)
							.reduce((v1, v2) => v1 + v2, 0);
						result.none = 0;
						return result;
					})
					.filter((d) => d.sold_val || d.distributed_val);
			} else {
				filterData = totalData
					.filter((d) => d.crop == $("#seedcrop_year").val())
					.filter((d) => d.sold_val || d.distributed_val);
			}
			//let chartData = filterData.sort((a,b)=>a.program_name - b.program_name);

			am4core.ready(function () {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("seed_year", am4charts.XYChart);
				chart.maskBullets = false;
				chart.numberFormatter.numberFormat = "#.#";

				// Add data
				chart.data = filterData.sort(GetSortOrder("program_name"));

				// Create axes
				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "program_name";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.renderer.labels.template.rotation = 270;
				categoryAxis.renderer.labels.template.horizontalCenter = "middle";
				categoryAxis.renderer.labels.template.verticalCenter = "middle";

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
				// valueAxis.renderer.inside = true;
				// valueAxis.renderer.labels.template.disabled = true;
				valueAxis.title.text =
					"Quantity of seed distributed/ sold as small seed packs (tons)";
				valueAxis.title.fontWeight = "bold";
				valueAxis.min = 0;
				valueAxis.extraMax = 0.1;
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
					series.tooltipText =
						"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

					// Add label
					var labelBullet = series.bullets.push(new am4charts.LabelBullet());
					//labelBullet.label.text = "{valueY}";
					labelBullet.label.fill = am4core.color("#fff");
					labelBullet.locationY = 0.5;

					return series;
				}

				createSeries("distributed_val", "Distributed at no cost");
				createSeries("sold_val", "Sold");
				//createSeries("certifiedqdsseed", "Certified QDS seed");

				// Create series for total
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
				totalBullet.label.background.fill = totalSeries.stroke;
				totalBullet.label.background.fillOpacity = 0.2;
				totalBullet.label.padding(5, 10, 5, 10);

				// Legend
				chart.legend = new am4charts.Legend();
				chart.scrollbarX = new am4core.Scrollbar();
				chart.cursor = new am4charts.XYCursor();
				chart.exporting.menu = new am4core.ExportMenu();
				chart.exporting.filePrefix = "avisa";
			});
		});
		$("#seedcrop_year").trigger("change");
	}
	farmersReachedDataChart() {
		$("#program_wise_no_of_farmers_reached_technology").html("");

		//Graph -17
		// const farmers_reached_data = this.apiData.farmers_reached_data;
		const farmers_reached_male_female =
			this.apiData.farmers_reached_male_female;
		// let demo_count = farmers_reached_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
		// $("#program_wise_no_of_farmers_reached_technology_count").html(demo_count);
		if (!farmers_reached_male_female?.length) {
			$("#program_wise_no_of_farmers_reached_technology").html(nodata_html());
			return;
		}

		farmers_reached_male_female.forEach((d) => {
			d.totalCount = d.female + d.male;
			d.none = 0;
		});
		const chartData = farmers_reached_male_female.filter(
			(e) => e.totalCount != 0
		);

		$("#technology_male_count").html(
			farmers_reached_male_female
				.map((e) => e.male)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#technology_female_count").html(
			farmers_reached_male_female
				.map((e) => e.female)
				.reduce((a, b) => a + b, 0) || 0
		);

		$("#technology_total_count").html(
			farmers_reached_male_female
				.map((e) => e.male)
				.reduce((a, b) => a + b, 0) +
			farmers_reached_male_female
				.map((e) => e.female)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_no_of_farmers_reached_technology",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";

			// Add data
			chart.data = chartData;
			chart.logo.disabled = "true";

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Percentage (%) of male / female";
			valueAxis.title.fontWeight = 800;

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
				series.columns.template.width = am4core.percent(80);
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				labelBullet.label.fontSize = 10;
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;

				return series;
			}

			createSeries("male", "Male");
			createSeries("female", "Female");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			totalBullet.label.truncate = false;

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
	hybridVarietyReleasedChart() {
		//Graph -7
		$("#program_varietyreleased_4").html("");

		const hybrid_opv_spv_data = this.apiData.hybrid_opv_spv_data_4;
		if (!hybrid_opv_spv_data?.length) {
			$("#program_varietyreleased_4").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Apply chart themes
			am4core.useTheme(am4themes_animated);

			// Create chart instance
			var chart = am4core.create(
				"program_varietyreleased_4",
				am4charts.XYChart
			);
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
		$("#program_traits_hybrid_opv_spv_4").html("");
		const hybrid_opv_spv_rawdata = clone(this.apiData.hybrid_opv_spv_rawdata);
		hybrid_opv_spv_rawdata.forEach((d) => {
			const formData = JSON.parse(d.formgroup_data);
			Object.keys(formData).forEach((e) => (d[e] = formData[e]));
		});
		const toList = Array.from(
			new Set(hybrid_opv_spv_rawdata.map((d) => d.field_197))
		);
		const countryList = Array.from(
			new Set(hybrid_opv_spv_rawdata.map((d) => d.country_name))
		);
		const cropList = Array.from(
			new Set(hybrid_opv_spv_rawdata.map((d) => d.crop_name))
		);
		const chartData = countryList
			.map((country) => {
				return cropList.map((crop) => {
					return toList.map((to) => {
						const val = hybrid_opv_spv_rawdata.filter(
							(d) =>
								d.country_name == country &&
								d.crop_name == crop &&
								d.field_197 == to
						).length;
						return {
							from: `${country}-${crop}`,
							to: to,
							value: val,
							width: 10,
						};
					});
				});
			})
			.flat()
			.flat()
			.filter((d) => d.value);
		if (!hybrid_opv_spv_rawdata?.length) {
			$("#program_traits_hybrid_opv_spv_4").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create(
				"program_traits_hybrid_opv_spv_4",
				am4charts.SankeyDiagram
			);
			chart.hiddenState.properties.opacity = 0;
			chart.logo.disabled = "true";
			chart.data = chartData;

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
			nodeTemplate.cursorOverStyle = am4core.MouseCursorStyle.pointer;
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
	hybridDataTableTable() {
		var mydata = this.apiData.mapping_varietyname_varietytarget_4;
		//console.log(mydata);
		const tableData = mydata.map((d) => {
			const result = `
      <tr>
        <td>${d.countryname}</td>
        <td>${d.cropname}</td>
        <td>${d.varietyname}</td>
        <td>${d.targetvariety}</td>
      </tr>
      `;
			return result;
		});

		$("#resultpo411>tbody").html(tableData);
		$("tbody>tr").addClass("tbl_bg");
	}
	onYieldChart() {
		//Graph-8
		$("#verity_onfarm_yield").html("");
		const program_onfarm_onstation = this.apiData.verity_onfarm_onstation_4;
		if (!program_onfarm_onstation?.length) {
			$("#verity_onfarm_yield").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			var chart = am4core.create("verity_onfarm_yield", am4charts.XYChart);
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
			yAxis.title.text = "On-farm mean yield (kg/ha)";
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

			// createSeries("onstation", "On-station yield");
			createSeries("onfarm", "On-farm mean yield ");

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
	trainingEventsChart() {
		$("#country_wise_events").html("");
		const stakeholders_trained_events =
			this.apiData.stakeholders_trained_events;
		//let demos_conducted_count=demos_conducted.map((e) => e.count).reduce((a, b) => a + b, 0) || 0
		let stakeholders_trained_events_count =
			this.apiData.stakeholders_trained_events
				.map((e) => e.count)
				.reduce((a, b) => a + b, 0) || 0;
		$("#traing_events").html(stakeholders_trained_events_count);
		$("#events_count").html(stakeholders_trained_events_count);
		if (!stakeholders_trained_events?.length) {
			$("#country_wise_events").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create("country_wise_events", am4charts.XYChart);
			chart.scrollbarX = new am4core.Scrollbar();
			chart.logo.disabled = "true";

			// Add data
			chart.data = stakeholders_trained_events;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;
			categoryAxis.renderer.labels.template.rotation = 270;

			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.tooltip.disabled = true;
			categoryAxis.renderer.minHeight = 110;

			// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.minWidth = 50;

			var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
			yAxis.extraMax = 0.2;
			yAxis.min = 0;
			yAxis.title.text = "Number of events";
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
	traningStackholderChart() {
		$("#country_wise_stackholders").html("");
		const stakeholders_trained_male_female =
			this.apiData.stakeholders_trained_male_female;
		if (!stakeholders_trained_male_female?.length) {
			$("#country_wise_stackholders").html(nodata_html());
			return;
		}

		stakeholders_trained_male_female.forEach((d) => {
			d.totalCount = d.female + d.male;
			d.none = 0;
		});
		const chartData = stakeholders_trained_male_female.filter(
			(e) => e.totalCount != 0
		);

		$("#training_male_count").html(
			stakeholders_trained_male_female
				.map((e) => e.male)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#training_female_count").html(
			stakeholders_trained_male_female
				.map((e) => e.female)
				.reduce((a, b) => a + b, 0) || 0
		);

		$("#total_stockholder_count").html(
			stakeholders_trained_male_female
				.map((e) => e.male)
				.reduce((a, b) => a + b, 0) +
			stakeholders_trained_male_female
				.map((e) => e.female)
				.reduce((a, b) => a + b, 0)
		);
		$("#training_stackholder_count").html(
			stakeholders_trained_male_female
				.map((e) => e.male)
				.reduce((a, b) => a + b, 0) +
			stakeholders_trained_male_female
				.map((e) => e.female)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"country_wise_stackholders",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";

			// Add data
			chart.data = chartData;
			chart.logo.disabled = "true";

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Percentage of stakeholders (male/ female)";
			valueAxis.title.fontWeight = 800;

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
				series.columns.template.width = am4core.percent(80);
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fontSize = 10;
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;

				return series;
			}

			createSeries("male", "Male");
			createSeries("female", "Female");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			totalBullet.label.truncate = false;

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
	trainingCatogoryChart() {
		$("#category_wise_events").html("");
		const training_category_wise_events =
			this.apiData.training_category_wise_events;
		let training_category_wise_events_count =
			this.apiData.training_category_wise_events
				.map((e) => e.value)
				.reduce((a, b) => a + b, 0) || 0;
		$("#category_count").html(training_category_wise_events_count);
		if (!training_category_wise_events?.length) {
			$("#category_wise_events").html(nodata_html());
			return;
		}
		const chartData = training_category_wise_events.filter((e) => e.value != 0);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create("category_wise_events", am4charts.XYChart);
			chart.scrollbarX = new am4core.Scrollbar();
			chart.logo.disabled = "true";

			// Add data
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "cname";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.minGridDistance = 30;
			categoryAxis.renderer.labels.template.rotation = 270;

			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.tooltip.disabled = true;
			categoryAxis.renderer.minHeight = 110;

			// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.minWidth = 50;

			var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
			yAxis.extraMax = 0.2;
			yAxis.min = 0;
			yAxis.title.text = "Number of events";
			yAxis.title.fontWeight = 800;

			// Create series
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.sequencedInterpolation = true;
			series.dataFields.valueY = "value";
			series.dataFields.categoryX = "cname";
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
	traningCategoryStackholderChart() {
		$("#category_wise_stackholders").html("");
		const training_category_wise_male_female =
			this.apiData.training_category_wise_male_female;
		if (!training_category_wise_male_female?.length) {
			$("#category_wise_stackholders").html(nodata_html());
			return;
		}

		training_category_wise_male_female.forEach((d) => {
			d.totalCount = d.female + d.male;
			d.none = 0;
		});
		const chartData = training_category_wise_male_female.filter(
			(e) => e.totalCount != 0
		);

		$("#category_stockholder_count").html(
			training_category_wise_male_female
				.map((e) => e.male)
				.reduce((a, b) => a + b, 0) +
			training_category_wise_male_female
				.map((e) => e.female)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"category_wise_stackholders",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";

			// Add data
			chart.data = chartData;
			chart.logo.disabled = "true";

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Percentage of stakeholders (male/ female)";
			valueAxis.title.fontWeight = 800;

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
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;

				return series;
			}

			createSeries("male", "Male");
			createSeries("female", "Female");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			totalBullet.label.truncate = false;

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
	programWiseCropChart() {
		const cropCountryData = clone(this.apiData.crop_country_seedtype_data);

		const totalData = Object.keys(cropCountryData)
			.sort()
			.map((crop) => {
				const result = [];
				cropCountryData[crop].forEach((data) => {
					const d = clone(data);
					d.breederseed = d.breederseed ? d.breederseed / 1000 : d.breederseed;
					d.foundationseed = d.foundationseed
						? d.foundationseed
						: d.foundationseed;
					d.certifiedqdsseed = d.certifiedqdsseed
						? d.certifiedqdsseed
						: d.certifiedqdsseed;
					d["crop"] = crop;
					d["none"] = 0;
					result.push(d);
				});
				return result.flat();
			})
			.flat();

		const countryOption = Array.from(
			new Set(totalData.map((d) => d.country_name))
		)
			.sort()
			.map((country) => `<option value="${country}"> ${country} </option>`);
		countryOption.unshift(
			`<option value="All Countries"> All Countries </option>`
		);
		$("#seedcountryselect").html(countryOption);

		$("#seedcountryselect").on("change", () => {
			let filterData = [];
			if ($("#seedcountryselect").val() == "All Countries") {
				filterData = Array.from(new Set(totalData.map((d) => d.crop))).map(
					(crop) => {
						const result = {
							breederseed: 0,
							foundationseed: 0,
							certifiedqdsseed: 0,
							crop: crop,
							none: 0,
						};
						result.breederseed = totalData
							.filter((d) => d.crop == crop)
							.map((d) => d.breederseed)
							.reduce((v1, v2) => v1 + v2);
						result.foundationseed = totalData
							.filter((d) => d.crop == crop)
							.map((d) => d.foundationseed)
							.reduce((v1, v2) => v1 + v2);
						result.certifiedqdsseed = totalData
							.filter((d) => d.crop == crop)
							.map((d) => d.certifiedqdsseed)
							.reduce((v1, v2) => v1 + v2);
						return result;
					}
				);
			} else {
				filterData = totalData.filter(
					(d) => d.country_name == $("#seedcountryselect").val()
				);
			}
			am4core.ready(function () {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("seedclass_crop", am4charts.XYChart);
				chart.maskBullets = false;
				chart.numberFormatter.numberFormat = "#.#";

				// Add data
				chart.data = filterData;

				// Create axes
				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "crop";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.renderer.labels.template.rotation = 270;
				categoryAxis.renderer.labels.template.horizontalCenter = "middle";
				categoryAxis.renderer.labels.template.verticalCenter = "middle";

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
				// valueAxis.renderer.inside = true;
				// valueAxis.renderer.labels.template.disabled = true;
				valueAxis.title.text = "Seed produced (tons)";
				valueAxis.title.fontWeight = 800;
				valueAxis.min = 0;
				valueAxis.extraMax = 0.1;
				valueAxis.calculateTotals = true;

				// Create series
				function createSeries(field, name) {
					// Set up series
					var series = chart.series.push(new am4charts.ColumnSeries());
					series.name = name;
					series.dataFields.valueY = field;
					series.dataFields.categoryX = "crop";
					series.sequencedInterpolation = true;

					// Make it stacked
					series.stacked = true;

					// Configure columns
					series.columns.template.width = am4core.percent(60);
					series.tooltipText =
						"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

					// Add label
					var labelBullet = series.bullets.push(new am4charts.LabelBullet());
					//labelBullet.label.text = "{valueY}";
					labelBullet.label.fill = am4core.color("#fff");
					labelBullet.locationY = 0.5;

					return series;
				}

				createSeries("breederseed", "Breeder seed");
				createSeries("foundationseed", "Foundation seed");
				createSeries("certifiedqdsseed", "Certified QDS seed");

				// Create series for total
				var totalSeries = chart.series.push(new am4charts.ColumnSeries());
				totalSeries.dataFields.valueY = "none";
				totalSeries.dataFields.categoryX = "crop";
				totalSeries.stacked = true;
				totalSeries.hiddenInLegend = true;
				totalSeries.columns.template.strokeOpacity = 0;

				var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
				totalBullet.dy = -20;
				totalBullet.label.text = "{valueY.total}";
				totalBullet.label.hideOversized = false;
				totalBullet.label.fontSize = 10;
				totalBullet.label.background.fill = totalSeries.stroke;
				totalBullet.label.background.fillOpacity = 0.2;
				totalBullet.label.padding(5, 10, 5, 10);
				totalBullet.label.truncate = false;

				// Legend
				chart.legend = new am4charts.Legend();
				chart.scrollbarX = new am4core.Scrollbar();
				chart.cursor = new am4charts.XYCursor();
				chart.exporting.menu = new am4core.ExportMenu();
				chart.exporting.filePrefix = "avisa";
			});
		});

		$("#seedcountryselect").trigger("change");
	}
	programWiseCountryChart() {
		const cropCountryData = clone(this.apiData.crop_country_seedtype_data);

		const totalData = Object.keys(cropCountryData)
			.sort()
			.map((crop) => {
				const result = [];
				cropCountryData[crop].forEach((data) => {
					const d = clone(data);
					d.breederseed = d.breederseed ? d.breederseed / 1000 : d.breederseed;
					d.foundationseed = d.foundationseed
						? d.foundationseed
						: d.foundationseed;
					d.certifiedqdsseed = d.certifiedqdsseed
						? d.certifiedqdsseed
						: d.certifiedqdsseed;
					d["crop"] = crop;
					d["none"] = 0;
					result.push(d);
				});
				return result.flat();
			})
			.flat();

		const cropsOptions = Object.keys(cropCountryData)
			.filter((d) => d != "Non-crop Specific")
			.sort()
			.map((crop) => `<option value="${crop}"> ${crop} </option>`);
		cropsOptions.unshift(`<option value="All Crops"> All Crops </option>`);
		$("#seedcropselect").html(cropsOptions);

		$("#seedcropselect").on("change", () => {
			let filterData = [];
			if ($("#seedcropselect").val() == "All Crops") {
				filterData = Array.from(new Set(totalData.map((d) => d.country_name)))
					.sort()
					.map((country_name) => {
						const result = {
							breederseed: 0,
							foundationseed: 0,
							certifiedqdsseed: 0,
							country_name: country_name,
							none: 0,
						};
						result.breederseed = totalData
							.filter((d) => d.country_name == country_name)
							.map((d) => d.breederseed)
							.reduce((v1, v2) => v1 + v2);
						result.foundationseed = totalData
							.filter((d) => d.country_name == country_name)
							.map((d) => d.foundationseed)
							.reduce((v1, v2) => v1 + v2);
						result.certifiedqdsseed = totalData
							.filter((d) => d.country_name == country_name)
							.map((d) => d.certifiedqdsseed)
							.reduce((v1, v2) => v1 + v2);
						return result;
					});
			} else {
				filterData = totalData.filter(
					(d) => d.crop == $("#seedcropselect").val()
				);
			}

			am4core.ready(function () {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("seedclass_country", am4charts.XYChart);
				chart.maskBullets = false;
				chart.numberFormatter.numberFormat = "#.#";

				// Add data
				chart.data = filterData;

				// Create axes
				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "country_name";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.renderer.labels.template.rotation = 270;
				categoryAxis.renderer.labels.template.horizontalCenter = "middle";
				categoryAxis.renderer.labels.template.verticalCenter = "middle";

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
				// valueAxis.renderer.inside = true;
				// valueAxis.renderer.labels.template.disabled = true;
				valueAxis.title.text = "Seed produced (tons)";
				valueAxis.title.fontWeight = 800;
				valueAxis.min = 0;
				valueAxis.extraMax = 0.1;
				valueAxis.calculateTotals = true;

				// Create series
				function createSeries(field, name) {
					// Set up series
					var series = chart.series.push(new am4charts.ColumnSeries());
					series.name = name;
					series.dataFields.valueY = field;
					series.dataFields.categoryX = "country_name";
					series.sequencedInterpolation = true;

					// Make it stacked
					//series.stacked = true;

					// Configure columns
					series.columns.template.width = am4core.percent(65);
					series.tooltipText =
						"[bold]{name}[/][font-size:14px]{categoryX}: {valueY}";
					series.stacked = true;
					series.tooltip.dy = 5;

					// Add label
					var labelBullet = series.bullets.push(new am4charts.LabelBullet());
					//labelBullet.label.text = "{valueY}";
					labelBullet.label.fill = am4core.color("#fff");
					labelBullet.locationY = 0.5;

					return series;
				}

				createSeries("breederseed", "Breeder seed");
				createSeries("foundationseed", "Foundation seed");
				createSeries("certifiedqdsseed", "Certified QDS seed");

				// Create series for total
				var totalSeries = chart.series.push(new am4charts.ColumnSeries());
				totalSeries.dataFields.valueY = "none";
				totalSeries.dataFields.categoryX = "country_name";
				totalSeries.stacked = true;
				totalSeries.hiddenInLegend = true;
				totalSeries.columns.template.strokeOpacity = 0;

				var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
				totalBullet.dy = -20;
				totalBullet.label.text = "{valueY.total}";
				totalBullet.label.hideOversized = false;
				totalBullet.label.fontSize = 10;
				totalBullet.label.background.fill = totalSeries.stroke;
				totalBullet.label.background.fillOpacity = 0.2;
				totalBullet.label.padding(5, 10, 5, 10);
				totalBullet.label.truncate = false;

				// Legend
				chart.legend = new am4charts.Legend();
				chart.scrollbarX = new am4core.Scrollbar();
				chart.cursor = new am4charts.XYCursor();
				chart.exporting.menu = new am4core.ExportMenu();
				chart.exporting.filePrefix = "avisa";
			});
		});
		$("#seedcropselect").trigger("change");
	}
	yearCountryChart() {
		const cropCountryData = clone(this.apiData.year_crop_country_seedtype_data);

		const totalData = Object.keys(cropCountryData)
			.sort()
			.map((crop) => {
				const result = [];
				cropCountryData[crop].forEach((data) => {
					const d = clone(data);
					d.breederseed = d.breederseed ? d.breederseed / 1000 : d.breederseed;
					d.foundationseed = d.foundationseed
						? d.foundationseed
						: d.foundationseed;
					d.certifiedqdsseed = d.certifiedqdsseed
						? d.certifiedqdsseed
						: d.certifiedqdsseed;
					d["crop"] = crop;
					d["none"] = 0;
					result.push(d);
				});
				return result.flat();
			})
			.flat();

		const cropsOptions = Object.keys(cropCountryData)
			.filter((d) => d != "Non-crop Specific")
			.sort()
			.map((crop) => `<option value="${crop}"> ${crop} </option>`);
		cropsOptions.unshift(`<option value="All Crops"> All Crops </option>`);
		$("#seedcropselect_year").html(cropsOptions);

		$("#seedcropselect_year").on("change", () => {
			let filterData = [];
			if ($("#seedcropselect_year").val() == "All Crops") {
				filterData = Array.from(new Set(totalData.map((d) => d.release_year)))
					.map((release_year) => {
						const result = {
							breederseed: 0,
							foundationseed: 0,
							certifiedqdsseed: 0,
							release_year: release_year,
						};
						result.breederseed = totalData
							.filter((d) => d.release_year == release_year)
							.map((d) => Number(d.breederseed.toFixed(2)))
							.reduce((v1, v2) => v1 + v2);
						result.foundationseed = totalData
							.filter((d) => d.release_year == release_year)
							.map((d) => Number(d.foundationseed.toFixed(2)))
							.reduce((v1, v2) => v1 + v2);
						result.certifiedqdsseed = totalData
							.filter((d) => d.release_year == release_year)
							.map((d) => Number(d.certifiedqdsseed.toFixed(2)))
							.reduce((v1, v2) => v1 + v2);
						result.none = 0;
						return result;
					})
					.filter(
						(d) => d.breederseed || d.certifiedqdsseed || d.foundationseed
					);
			} else {
				filterData = totalData
					.filter((d) => d.crop == $("#seedcropselect_year").val())
					.filter(
						(d) => d.breederseed || d.certifiedqdsseed || d.foundationseed
					);
			}

			am4core.ready(function () {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("seedclass_country_year", am4charts.XYChart);
				chart.maskBullets = false;
				chart.numberFormatter.numberFormat = "#.#";

				// Add data
				chart.data = filterData;

				// Create axes
				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "release_year";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
				categoryAxis.renderer.labels.template.rotation = 270;
				categoryAxis.renderer.labels.template.horizontalCenter = "middle";
				categoryAxis.renderer.labels.template.verticalCenter = "middle";

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
				// valueAxis.renderer.inside = true;
				// valueAxis.renderer.labels.template.disabled = true;
				valueAxis.title.text = "Amount of seed produced (tons)";
				valueAxis.title.fontWeight = "bold";
				valueAxis.min = 0;
				valueAxis.extraMax = 0.1;
				valueAxis.calculateTotals = true;

				// Create series
				function createSeries(field, name) {
					// Set up series
					var series = chart.series.push(new am4charts.ColumnSeries());
					series.name = name;
					series.dataFields.valueY = field;
					series.dataFields.categoryX = "release_year";
					series.sequencedInterpolation = true;

					// Make it stacked
					// series.stacked = true;

					// Configure columns
					series.columns.template.width = am4core.percent(65);
					series.tooltipText =
						"[bold]{name}[/][font-size:14px]{cateoryX}: {valueY}[/]";
					// series.columns.template.minBulletDistance = 10;
					series.stacked = true;
					// series.column.template.tooltip.maxLabelPosition = 2
					series.tooltip.dy = 5;

					// Add label
					var labelBullet = series.bullets.push(new am4charts.LabelBullet());
					// labelBullet.label.text = "{valueY}";
					labelBullet.label.fill = am4core.color("#fff");
					labelBullet.locationY = 0.5;

					return series;
				}

				createSeries("breederseed", "Breeder seed");
				createSeries("foundationseed", "Foundation seed");
				createSeries("certifiedqdsseed", "Certified QDS seed");

				// Create series for total
				var totalSeries = chart.series.push(new am4charts.ColumnSeries());
				totalSeries.dataFields.valueY = "none";
				totalSeries.dataFields.categoryX = "release_year";
				totalSeries.stacked = true;
				totalSeries.hiddenInLegend = true;
				totalSeries.columns.template.strokeOpacity = 0;

				var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
				totalBullet.dy = -20;
				totalBullet.label.text = "{valueY.total}";
				totalBullet.label.hideOversized = false;
				totalBullet.label.fontSize = 10;
				totalBullet.label.background.fill = totalSeries.stroke;
				totalBullet.label.background.fillOpacity = 0.2;
				totalBullet.label.padding(5, 10, 5, 10);
				totalBullet.label.truncate = false;

				// Legend
				chart.legend = new am4charts.Legend();
				chart.scrollbarX = new am4core.Scrollbar();
				chart.cursor = new am4charts.XYCursor();
				chart.exporting.menu = new am4core.ExportMenu();
				chart.exporting.filePrefix = "avisa";
			});
		});
		$("#seedcropselect_year").trigger("change");
	}
	keyproducerSeedproductionChart() {
		//Graph -24
		$("#key_producer_vsseedclassdata").html("");

		const country_crop_wise_category_data =
			this.apiData.country_crop_wise_category_data.filter(
				(d) => d.certified_qds || d.breeder || d.foundation
			);
		if (!country_crop_wise_category_data?.length) {
			$("#key_producer_vsseedclassdata").html(nodata_html());
			return;
		}

		// const country_crop_wise_category_data =this.apiData.country_crop_wise_category_data

		const cropsOptions = [
			...new Set(
				country_crop_wise_category_data.map(
					(d) => `<option value="${d.program_name}">${d.program_name}</option>`
				)
			),
		];
		cropsOptions.unshift(`<option value=""> All</option>`);
		$("#key_producer-selector").html(cropsOptions);

		$("#key_producer-selector").on("change", () => {
			let chartData = [];
			if ($("#key_producer-selector").val()) {
				chartData = country_crop_wise_category_data.filter(
					(d) =>
						!$("#key_producer-selector").val() ||
						$("#key_producer-selector").val() == d.program_name
				);
			} else {
				chartData = [
					...new Set(
						country_crop_wise_category_data.map((d) => d.keyproducer_name)
					),
				].map((prod) => {
					const result = { keyproducer_name: prod };
					const prodData = country_crop_wise_category_data.filter(
						(d) => d.keyproducer_name == prod
					);
					result.breeder =
						(prodData.map((d) => d.breeder).reduce((a, b) => a + b, 0) / 1000).toFixed(2);
					result.foundation = (prodData
						.map((d) => d.foundation)
						.reduce((a, b) => a + b, 0)).toFixed(2);
					result.certified_qds = (prodData
						.map((d) => d.certified_qds)
						.reduce((a, b) => a + b, 0)).toFixed(2);
					return result;
				});
			}
			chartData.forEach((d) => {
				d.none = 0;
			});

			//console.log(chartData);

			am4core.ready(function () {
				// Apply chart themes
				am4core.useTheme(am4themes_animated);

				// Create chart instance
				var chart = am4core.create(
					"key_producer_vsseedclassdata",
					am4charts.XYChart
				);

				chart.marginRight = 400;
				chart.logo.disabled = "true";

				// Add data
				// chart.data = keyproducer_seedproduction;
				chart.data = chartData;

				// Create axes
				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "keyproducer_name";
				// categoryAxis.title.text = "Countries";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 20;

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
				valueAxis.title.text = "Seed produced (tons)";
				valueAxis.title.fontWeight = 800;
				valueAxis.extraMax = 0.1;
				valueAxis.calculateTotals = true;

				// Create series
				var series = chart.series.push(new am4charts.ColumnSeries());
				series.dataFields.valueY = "breeder";
				series.dataFields.categoryX = "keyproducer_name";
				series.name = "Breeder";
				series.tooltipText = "{name}: [bold]{valueY}[/]";
				series.stacked = true;
				//series.columns.template.fill = am4core.color("#663399"); // fill

				var series2 = chart.series.push(new am4charts.ColumnSeries());
				series2.dataFields.valueY = "foundation";
				series2.dataFields.categoryX = "keyproducer_name";
				series2.name = "Foundation";
				series2.tooltipText = "{name}: [bold]{valueY}[/]";
				series2.stacked = true;
				//series2.columns.template.fill = am4core.color("#4169E1"); // fill

				var series3 = chart.series.push(new am4charts.ColumnSeries());
				series3.dataFields.valueY = "certified_qds";
				series3.dataFields.categoryX = "keyproducer_name";
				series3.name = "Certified and QDS";
				series3.tooltipText = "{name}: [bold]{valueY}[/]";
				series3.stacked = true;
				//series3.columns.template.fill = am4core.color("#F4A460"); // fill

				// Create series for total
				var totalSeries = chart.series.push(new am4charts.ColumnSeries());
				totalSeries.dataFields.valueY = "none";
				totalSeries.dataFields.categoryX = "keyproducer_name";
				totalSeries.stacked = true;
				totalSeries.hiddenInLegend = true;
				totalSeries.columns.template.strokeOpacity = 0;

				var totalBullet = totalSeries.bullets.push(new am4charts.LabelBullet());
				totalBullet.dy = -20;
				totalBullet.label.text = "{valueY.total}";
				totalBullet.label.hideOversized = false;
				totalBullet.label.fontSize = 10;
				totalBullet.label.background.fill = totalSeries.stroke;
				totalBullet.label.background.fillOpacity = 0.2;
				totalBullet.label.padding(5, 10, 5, 10);
				totalBullet.label.truncate = false;

				chart.legend = new am4charts.Legend();

				// Add cursor
				chart.scrollbarX = new am4core.Scrollbar();
				chart.cursor = new am4charts.XYCursor();
				chart.exporting.menu = new am4core.ExportMenu();
				chart.exporting.filePrefix = "avisa";
			}); // end am4core.ready()
		});

		$("#key_producer-selector").trigger("change");
	}
	generateBubbleMap() {
		const cropCountryData = clone(this.apiData.crop_country_seedtype_data);

		const totalData = Object.keys(cropCountryData)
			.sort()
			.map((crop) => {
				const result = [];
				cropCountryData[crop].forEach((data) => {
					const d = clone(data);
					d["crop"] = crop;
					d["name"] = data.country_name;
					d["id"] = countriesCodes.find(
						(c) => c.country_name == data.country_name
					)?.country_code;
					result.push(d);
				});
				return result.flat();
			})
			.flat();

		const cropsOptions = Object.keys(cropCountryData)
			.filter((d) => d != "Non-crop Specific")
			.sort()
			.map((crop) => `<option value="${crop}"> ${crop} </option>`);
		cropsOptions.unshift(`<option value="All Crops"> All Crops </option>`);
		$("#map-crop-selector").html(cropsOptions);

		$("#map-crop-selector").on("change", () => {
			let filterData = [];
			if ($("#map-crop-selector").val() == "All Crops") {
				filterData = Array.from(new Set(totalData.map((d) => d.country_name)))
					.sort()
					.map((country_name) => {
						const result = {
							breederseed: 0,
							foundationseed: 0,
							certifiedqdsseed: 0,
							country_name: country_name,
							none: 0,
						};
						result.breederseed = totalData
							.filter((d) => d.country_name == country_name)
							.map((d) => d.breederseed)
							.reduce((v1, v2) => v1 + v2, 0);
						result.foundationseed = totalData
							.filter((d) => d.country_name == country_name)
							.map((d) => d.foundationseed)
							.reduce((v1, v2) => v1 + v2, 0);
						result.certifiedqdsseed = totalData
							.filter((d) => d.country_name == country_name)
							.map((d) => d.certifiedqdsseed)
							.reduce((v1, v2) => v1 + v2, 0);
						result["name"] = country_name;
						result["id"] = countriesCodes.find(
							(c) => c.country_name == country_name
						)?.country_code;
						return result;
					})
					.filter((d) => d.id);
			} else {
				filterData = totalData.filter(
					(d) => d.crop == $("#map-crop-selector").val() && d.id
				);
			}

			let countryCodes = Array.from(
				new Set(filterData.filter((e) => e.id).map((e) => e.id))
			);
			//console.log(countryCodes);
			//console.log(filterData);
			let countryLocations = [
				{
					country: "BF",
					latitude: 12.238333,
					longitude: -1.561593,
					name: "Burkina Faso",
				},
				{
					country: "ML",
					latitude: 17.570692,
					longitude: -3.996166,
					name: "Mali",
				},
				{
					country: "ET",
					latitude: 9.145,
					longitude: 40.489673,
					name: "Ethiopia",
				},
				{
					country: "GH",
					latitude: 7.946527,
					longitude: -1.023194,
					name: "Ghana",
				},
				{
					country: "NG",
					latitude: 9.081999,
					longitude: 8.675277,
					name: "Nigeria",
				},
				{
					country: "TZ",
					latitude: -6.369028,
					longitude: 34.888822,
					name: "Tanzania",
				},
				{
					country: "UG",
					latitude: 1.373333,
					longitude: 32.290275,
					name: "Uganda",
				},
			];

			const countryColor = [
				{
					id: "BF",
					value: 695.1,
					indicators: "Burkina Faso",
				},
				{
					id: "ET",
					value: 44394.27,
					indicators: "Ethiopia",
				},
				{
					id: "GH",
					value: 139,
					indicators: "Ghana",
				},
				{
					id: "ML",
					value: 8010.61,
					indicators: "Mali",
				},
				{
					id: "NG",
					value: 6486.84,
					indicators: "Nigeria",
				},
				{
					id: "TZ",
					value: 52762.060000000005,
					indicators: "Tanzania",
				},
				{
					id: "UG",
					value: 21400.48,
					indicators: "Uganda",
				},
			];
			const slectedCountry = countryColor
				.filter(function (o1) {
					// filter out (!) items in result2
					return filterData.some(function (o2) {
						return o2.country_name === o1.indicators; // assumes unique id
					});
				})
				.map((country) => {
					const result = [];
					result.push(country);

					return result.flat();
				})
				.flat();

			//console.log(slectedCountry);

			am4core.ready(function () {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				var chart = am4core.create("bubble_map1", am4maps.MapChart);

				chart.logo.disabled = "true";
				try {
					chart.geodata = am4geodata_worldIndiaLow;
				} catch (e) {
					chart.raiseCriticalError(
						new Error(
							'Map geodata could not be loaded. Please download the latest <a href="https://www.amcharts.com/download/download-v4/">amcharts geodata</a> and extract its contents into the same directory as your amCharts files.'
						)
					);
				}

				chart.homeZoomLevel = 3;
				chart.homeGeoPoint = {
					latitude: 4,
					longitude: 15,
				};
				//chart.maxZoomLevel = 1
				chart.projection = new am4maps.projections.Mercator();

				// chart.projection = new am4maps.projections.Miller();
				// zoomout on background click
				chart.chartContainer.background.events.on("hit", function () {
					zoomOut();
				});

				var colorSet = new am4core.ColorSet();
				var morphedPolygon;

				// map polygon series (countries)
				var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
				// polygonSeries.useGeodata = true;
				// specify which countries to include
				// polygonSeries.include = ["IT", "CH", "FR", "DE", "IN", "ES", "PT", "IE", "NL", "LU", "BE", "AT", "DK"]
				// polygonSeries.include = ["BF", "ET", "GH", "ML", "NG", "TZ", "UG", "IN"]
				// polygonSeries.exclude = ["AQ","US","CA","GL","RU","SJ","AS"];
				polygonSeries.exclude = ["AQ"];
				polygonSeries.useGeodata = true;

				polygonSeries.heatRules.push({
					property: "fill",
					target: polygonSeries.mapPolygons.template,
					min: chart.colors.getIndex(2).brighten(1),
					max: chart.colors.getIndex(2).brighten(-0.3),
				});

				polygonSeries.data = slectedCountry;

				// // country area look and behavior
				var polygonTemplate = polygonSeries.mapPolygons.template;
				polygonTemplate.strokeOpacity = 1;
				polygonTemplate.stroke = am4core.color("#ffffff");
				polygonTemplate.fillOpacity = 0.5;
				polygonTemplate.tooltipText = "{name}";

				// desaturate filter for countries
				var desaturateFilter = new am4core.DesaturateFilter();
				desaturateFilter.saturation = 0.25;
				polygonTemplate.filters.push(desaturateFilter);

				// take a color from color set
				// polygonTemplate.adapter.add("fill", function (fill, target) {
				//   return colorSet.getIndex(target.dataItem.index + 1);
				// })

				// set fillOpacity to 1 when hovered
				var hoverState = polygonTemplate.states.create("hover");
				hoverState.properties.fillOpacity = 1;

				// what to do when country is clicked
				polygonTemplate.events.on("hit", function (event) {
					event.target.zIndex = 1000000;

					// console.log(event.target.dataItem._dataContext.name);
					let selected = event.target.dataItem._dataContext.name;
					pieSeries.data = chartData
						.filter((d) => d.title == selected)
						.map((d) => d.pieData)[0];
					// console.log(pieSeries.data);
					// console.log(chartData.filter(d => d.title == selected).length);

					if (chartData.filter((d) => d.title == selected) != 0) {
						selectPolygon(event.target);
					}
					// console.log(pieSeries.data);
				});

				// Pie chart
				var pieChart = chart.seriesContainer.createChild(am4charts.PieChart);
				// Set width/heigh of a pie chart for easier positioning only
				pieChart.width = 150;
				pieChart.height = 150;
				pieChart.hidden = true; // can't use visible = false!

				// because defauls are 50, and it's not good with small countries
				pieChart.chartContainer.minHeight = 1;
				pieChart.chartContainer.minWidth = 1;

				var pieSeries = pieChart.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "value";
				pieSeries.dataFields.category = "category";
				pieSeries.labels.template.maxWidth = 120;
				pieSeries.labels.template.wrap = true;
				// pieSeries.data = [{ value: 100, category: "First" }, { value: 20, category: "Second" }, { value: 10, category: "Third" }];

				let chartData = countryCodes.map((e) => {
					let indicators = filterData
						.filter((d) => d.id && d.id == e)
						.map((d) => `${d.country_name}`)
						.join("\n");
					let latitude = countryLocations
						.filter((d) => d.country == e)
						.map((d) => d.latitude);
					let longitude = countryLocations
						.filter((d) => d.country == e)
						.map((d) => d.longitude);
					let value = filterData
						.filter((d) => d.id && d.id == e)
						.map((d) => d.breederseed + d.foundationseed + d.certifiedqdsseed)
						.reduce((a, b) => a + b, 0);
					let breeder =
						filterData
							.filter((d) => d.id && d.id == e)
							.map((d) => d.breederseed)
							.reduce((a, b) => a + b, 0) / 1000;
					let foundationseed = filterData
						.filter((d) => d.id && d.id == e)
						.map((d) => d.foundationseed)
						.reduce((a, b) => a + b, 0);
					let certifiedqdsseed = filterData
						.filter((d) => d.id && d.id == e)
						.map((d) => d.certifiedqdsseed)
						.reduce((a, b) => a + b, 0);

					return {
						title: indicators,
						latitude: latitude[0],
						longitude: longitude[0],
						width: 0.3,
						height: 0.5,
						pieData: [
							{
								category: "Breeder seed",
								value: breeder,
							},
							{
								category: "Foundation seed",
								value: foundationseed,
							},
							{
								category: "Certified and QDS ",
								value: certifiedqdsseed,
							},
						],
					};
				});

				var dropShadowFilter = new am4core.DropShadowFilter();
				dropShadowFilter.blur = 4;
				pieSeries.filters.push(dropShadowFilter);

				var sliceTemplate = pieSeries.slices.template;
				sliceTemplate.fillOpacity = 1;
				sliceTemplate.strokeOpacity = 0;

				var activeState = sliceTemplate.states.getKey("active");
				activeState.properties.shiftRadius = 0; // no need to pull on click, as country circle under the pie won't make it good

				var sliceHoverState = sliceTemplate.states.getKey("hover");
				sliceHoverState.properties.shiftRadius = 0; // no need to pull on click, as country circle under the pie won't make it good

				// we don't need default pie chart animation, so change defaults
				var hiddenState = pieSeries.hiddenState;
				hiddenState.properties.startAngle = pieSeries.startAngle;
				hiddenState.properties.endAngle = pieSeries.endAngle;
				hiddenState.properties.opacity = 0;
				hiddenState.properties.visible = false;

				// series labels
				var labelTemplate = pieSeries.labels.template;
				labelTemplate.nonScaling = true;
				labelTemplate.fill = am4core.color("#FFFFFF");
				labelTemplate.fontSize = 14;
				labelTemplate.background = new am4core.RoundedRectangle();
				labelTemplate.background.fillOpacity = 0.9;
				labelTemplate.padding(4, 9, 4, 9);
				labelTemplate.background.fill = am4core.color("#7678a0");

				// we need pie series to hide faster to avoid strange pause after country is clicked
				pieSeries.hiddenState.transitionDuration = 200;

				// country label
				var countryLabel = chart.chartContainer.createChild(am4core.Label);
				countryLabel.text = "Select a country";
				countryLabel.fill = am4core.color("#7678a0");
				countryLabel.fontSize = 18;

				countryLabel.hiddenState.properties.dy = 1000;
				countryLabel.defaultState.properties.dy = 0;
				countryLabel.valign = "top";
				countryLabel.align = "left";
				countryLabel.paddingRight = 250;
				countryLabel.paddingTop = 20;
				countryLabel.hide(0);
				countryLabel.show();

				// select polygon
				function selectPolygon(polygon) {
					if (morphedPolygon != polygon) {
						var animation = pieSeries.hide();
						if (animation) {
							animation.events.on("animationended", function () {
								morphToCircle(polygon);
							});
						} else {
							morphToCircle(polygon);
						}
					}
				}

				// fade out all countries except selected
				function fadeOut(exceptPolygon) {
					for (var i = 0; i < polygonSeries.mapPolygons.length; i++) {
						var polygon = polygonSeries.mapPolygons.getIndex(i);
						if (polygon != exceptPolygon) {
							polygon.defaultState.properties.fillOpacity = 0.5;
							polygon.animate(
								[
									{ property: "fillOpacity", to: 0.5 },
									{ property: "strokeOpacity", to: 1 },
								],
								polygon.polygon.morpher.morphDuration
							);
						}
					}
				}

				function zoomOut() {
					if (morphedPolygon) {
						pieSeries.hide();
						morphBack();
						fadeOut();
						countryLabel.hide();
						morphedPolygon = undefined;
					}
				}

				function morphBack() {
					if (morphedPolygon) {
						morphedPolygon.polygon.morpher.morphBack();
						var dsf = morphedPolygon.filters.getIndex(0);
						dsf.animate(
							{ property: "saturation", to: 0.25 },
							morphedPolygon.polygon.morpher.morphDuration
						);
					}
				}

				function morphToCircle(polygon) {
					var animationDuration = polygon.polygon.morpher.morphDuration;
					// if there is a country already morphed to circle, morph it back
					morphBack();
					// morph polygon to circle
					polygon.toFront();
					polygon.polygon.morpher.morphToSingle = true;
					var morphAnimation = polygon.polygon.morpher.morphToCircle();

					polygon.strokeOpacity = 0; // hide stroke for lines not to cross countries

					polygon.defaultState.properties.fillOpacity = 1;
					polygon.animate(
						{ property: "fillOpacity", to: 1 },
						animationDuration
					);

					// animate desaturate filter
					var filter = polygon.filters.getIndex(0);
					filter.animate({ property: "saturation", to: 1 }, animationDuration);

					// save currently morphed polygon
					morphedPolygon = polygon;

					// fade out all other
					fadeOut(polygon);

					// hide country label
					countryLabel.hide();

					if (morphAnimation) {
						morphAnimation.events.on("animationended", function () {
							zoomToCountry(polygon);
						});
					} else {
						zoomToCountry(polygon);
					}
				}

				function zoomToCountry(polygon) {
					var zoomAnimation = chart.zoomToMapObject(polygon, 3, true);
					if (zoomAnimation) {
						zoomAnimation.events.on("animationended", function () {
							showPieChart(polygon);
						});
					} else {
						showPieChart(polygon);
					}
				}

				function showPieChart(polygon) {
					polygon.polygon.measure();
					var radius =
						((polygon.polygon.measuredWidth / 2) * polygon.globalScale) /
						chart.seriesContainer.scale;
					pieChart.width = radius * 2;
					pieChart.height = radius * 2;
					pieChart.radius = radius;

					var centerPoint = am4core.utils.spritePointToSvg(
						polygon.polygon.centerPoint,
						polygon.polygon
					);
					centerPoint = am4core.utils.svgPointToSprite(
						centerPoint,
						chart.seriesContainer
					);

					pieChart.x = centerPoint.x - radius;
					pieChart.y = centerPoint.y - radius;

					var fill = polygon.fill;
					var desaturated = fill.saturate(0.3);

					// console.log(pieSeries);

					for (var i = 0; i < pieSeries.dataItems.length; i++) {
						var dataItem = pieSeries.dataItems.getIndex(i);
						// console.log(dataItem);
						//dataItem.value = Math.round(Math.random() * 100);
						// dataItem.slice.fill = am4core.color("#4a2abb");
						dataItem.slice.fill = am4core.color(am4core.colors.interpolate(
							{
								b: 8,
								g: 133,
								r: 239
							},
							{
								a: 1,
								b: 146,
								g: 86,
								r: 135
							},
							i * 0.5
						));


						dataItem.label.background.fill = desaturated;
						dataItem.tick.stroke = fill;
					}

					pieSeries.show();
					pieChart.show();

					countryLabel.text = "{name}";
					countryLabel.dataItem = polygon.dataItem;
					countryLabel.fill = desaturated;
					countryLabel.show();
				}
			}); // end am4core.ready()
			{
				/* </script> */
			}
		});

		$("#map-crop-selector").trigger("change");
	}
	certifiedQdsSeedDataCharts() {
		//Graph -28
		$("#Program_wise_volume_of_certified").html("");

		const certified_qds_seed_data = this.apiData.certified_qds_seed_data.filter(
			(d) => d.count
		);
		let certified_qds_seed_data_counts =
			certified_qds_seed_data.map((e) => e.count).reduce((a, b) => a + b, 0) ||
			0;
		$("#cqdc_count").html(certified_qds_seed_data_counts);
		if (!certified_qds_seed_data?.length) {
			$("#Program_wise_volume_of_certified").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"Program_wise_volume_of_certified",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";
			chart.scrollbarX = new am4core.Scrollbar();

			// Add data
			chart.data = certified_qds_seed_data;

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.title.text = "Volume of certified/QDS seed delivered (tons)";
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
	profitabilityAnalysisToolsChart() {
		$("#analysis_tools_graph").html("");
		const profitability_analysis_tools =
			this.apiData.profitability_analysis_tools;
		profitability_analysis_tools.forEach((d) => {
			const esaType = esaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			const wcaType = wcaDivisonCountry.find((div) =>
				d.program_name.includes(div)
			);
			if (esaType) {
				d.program_name = d.program_name.replace(esaType, "ESA");
			} else if (wcaType) {
				d.program_name = d.program_name.replace(wcaType, "WCA");
			}
		});

		const programList = Array.from(
			new Set(profitability_analysis_tools.map((d) => d.program_name))
		);

		const chartData = programList.map((pName) => {
			const result = { program_name: pName };
			// if (pName == 'Common bean-ESA' || pName == 'Cowpea-WCA') {
			//   result.program_name = pName?.substring(0, pName?.indexOf('-'))
			// }
			result["count"] = profitability_analysis_tools
				.filter((d) => d.program_name == pName)
				.map((d) => d.count)
				.reduce((v1, v2) => v1 + v2, 0);
			return result;
		});
		if (!chartData?.length) {
			$("#analysis_tools_graph").html(nodata_html());
			return;
		}
		this.rcih_po4_piechart("analysis_tools_graph", chartData);
	}
	publicPrivatePartnersAdoptingChart() {
		$("#digital_seed_cataloge_graph").html("");
		const public_private_partners_adopting =
			this.apiData.public_private_partners_adopting;
		if (!public_private_partners_adopting?.length) {
			$("#digital_seed_cataloge_graph").html(nodata_html());
			return;
		}

		public_private_partners_adopting.forEach((d) => {
			d.totalCount = d.private_val + d.public_val;
			d.none = 0;
		});
		const chartData = public_private_partners_adopting.filter(
			(e) => e.totalCount != 0
		);

		$("#digital_seed_cataloge_count").html(
			public_private_partners_adopting
				.map((e) => e.public_val)
				.reduce((a, b) => a + b, 0) +
			public_private_partners_adopting
				.map((e) => e.private_val)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"digital_seed_cataloge_graph",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";

			// Add data
			chart.data = chartData;
			chart.logo.disabled = "true";

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Percentage of public/private partners";
			valueAxis.title.fontWeight = 800;

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
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;

				labelBullet.label.adapter.add("text", function (text, target) {
					if (target.dataItem && target.dataItem.valueY == 0) {
						return "";
					}
					return text;
				});

				return series;
			}

			createSeries("private_val", "Private");
			createSeries("public_val", "Public");

			// Create series for total
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			totalBullet.label.truncate = false;

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}

	rcih_po4_piechart(divid, data) {
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end
			// Create chart instance
			var chart = am4core.create(divid, am4charts.PieChart);
			chart.legend = new am4charts.Legend();

			chart.legend.maxHeight = 150;
			chart.legend.scrollable = true;
			chart.logo.disabled = "true";

			// Add data
			chart.data = data;
			// Add and configure Series
			var pieSeries = chart.series.push(new am4charts.PieSeries());
			pieSeries.dataFields.value = "count";
			pieSeries.dataFields.category = "program_name";
			pieSeries.slices.template.stroke = am4core.color("#fff");
			pieSeries.slices.template.strokeWidth = 2;
			pieSeries.slices.template.strokeOpacity = 1;
			// pieSeries.labels.template.fontSize = 10;
			pieSeries.labels.template.fontWeight = 400;
			pieSeries.labels.template.maxWidth = 120;
			pieSeries.labels.template.wrap = true;

			// This creates initial animation
			pieSeries.hiddenState.properties.opacity = 1;
			// pieSeries.hiddenState.properties.endAngle = -80;
			// pieSeries.hiddenState.properties.startAngle = -80;
			// pieSeries.legendSettings.labelText =
			// 	"[bold {color}]{name}[/] - [bold {color}]{value}[/]";

			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}

	commercializedVarietiesChart() {
		//Graph -29
		$("#Program_wise_percent_of_farmers").html("");

		const commercialized_varieties =
			this.apiData.commercialized_varieties.filter((d) => d.count);
		let commercialized_varieties_counts =
			commercialized_varieties.map((e) => e.count).reduce((a, b) => a + b, 0) ||
			0;
		let value = (
			commercialized_varieties_counts / commercialized_varieties.length
		).toFixed(2);
		$("#promoted_tech_count").html(value);
		$("#rcih_wise_percent_of_farmers_count").html(value);
		if (!commercialized_varieties?.length) {
			$("#Program_wise_percent_of_farmers").html(nodata_html());
			return;
		}

		// debugger
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"Program_wise_percent_of_farmers",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";
			chart.scrollbarX = new am4core.Scrollbar();

			// Add data
			chart.data = commercialized_varieties;

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.title.text = "Percent of farmers";
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

	seedpackMaleFemaleDataChart() {
		$("#program_wise_segregation_of_beneficiaries").html("");

		//Graph -16
		const seedpack_male_female_data = this.apiData.seedpack_male_female_data;
		if (!seedpack_male_female_data?.length) {
			$("#program_wise_segregation_of_beneficiaries").html(
				nodata_html("550px")
			);
			return;
		}

		seedpack_male_female_data.forEach((d) => {
			d.totalCount = d.male_val + d.female_val;
			d.none = 0;
		});
		const chartData = seedpack_male_female_data.filter(
			(e) => e.totalCount != 0
		);

		$("#seedpack_male_count").html(
			seedpack_male_female_data
				.map((e) => e.male_val)
				.reduce((a, b) => a + b, 0) || 0
		);
		$("#seedpack_female_count").html(
			seedpack_male_female_data
				.map((e) => e.female_val)
				.reduce((a, b) => a + b, 0) || 0
		);

		$("#seedpack_total_count").html(
			seedpack_male_female_data
				.map((e) => e.male_val)
				.reduce((a, b) => a + b, 0) +
			seedpack_male_female_data
				.map((e) => e.female_val)
				.reduce((a, b) => a + b, 0)
		);

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_segregation_of_beneficiaries",
				am4charts.XYChart
			);
			chart.maskBullets = false;
			chart.numberFormatter.numberFormat = "#.#";
			chart.logo.disabled = "true";

			// Add data
			chart.data = chartData;

			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "program_name";
			categoryAxis.renderer.grid.template.location = 0;
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.horizontalCenter = "middle";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.renderer.minGridDistance = 10;

			// categoryAxis.title.text = "Number of male/female";
			// categoryAxis.title.fontWeight = 800;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			// valueAxis.renderer.inside = true;
			// valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;
			valueAxis.extraMax = 0.1;
			valueAxis.calculateTotals = true;
			valueAxis.renderer.maxLabelPosition = 0.99;
			valueAxis.title.text = "Percentage (%) of male / female";
			valueAxis.title.fontWeight = 800;

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
				series.columns.template.width = am4core.percent(80);
				series.columns.template.tooltipText =
					"[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY.totalPercent.formatNumber('#.00')}%";
				series.dataFields.valueYShow = "totalPercent";
				// Add label
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
				labelBullet.label.fontSize = 10;
				// labelBullet.label.text = "{valueY}";
				labelBullet.label.fill = am4core.color("#fff");
				labelBullet.locationY = 0.5;

				return series;
			}

			createSeries("male_val", "Male");
			createSeries("female_val", "Female");

			// Create series for total valueAxis.calculateTotals = true;
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
			totalBullet.label.background.fill = totalSeries.stroke;
			totalBullet.label.background.fillOpacity = 0.2;
			totalBullet.label.padding(5, 10, 5, 10);
			totalBullet.label.truncate = false;

			// Legend
			chart.legend = new am4charts.Legend();
			chart.scrollbarX = new am4core.Scrollbar();
			chart.cursor = new am4charts.XYCursor();
			chart.exporting.menu = new am4core.ExportMenu();
			chart.exporting.filePrefix = "avisa";
		});
	}
} // class end
