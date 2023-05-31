class Communication {
	constructor() {
		this.getApiData();
	}

	getApiData() {
		const request = { purpose: "COMMUNICATIONS" };
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
		$("#dwn-csv-22").on("click", function () {
			$("#resultpo2").table2csv({
				file_name: "avisa-advocacy-tools.csv",
				header_body_space: 0,
			});
		});
		$("#dwn-csv-9").on("click", function () {
			$("#resultpo4").table2csv({
				file_name: "avisa-communication_tool.csv",
				header_body_space: 0,
			});
		});

		$("#dwn-csv-22").on("click", function () {
			$("#resultpo2").table2csv({
				file_name: "avisa-advocacy-tools.csv",
				header_body_space: 0,
			});
		});
		$("#dwn-csv-10").on("click", function () {
			$("#resultpo5").table2csv({
				file_name: "avisa-success-impact.csv",
				header_body_space: 0,
			});
		});
	}
	generateCharts() {
		setTimeout(() => this.newtoolsAdoptedChart());
		setTimeout(() => this.communicationApproachesChart());
		setTimeout(() => this.advocacyToolsChart());
		setTimeout(() => this.successImpactStoriesChart());
		setTimeout(() => this.lobbyingToolsDataChart());
		setTimeout(() => this.lobbyingToolsDataTableTable());
		setTimeout(() => this.advocacyToolsTable());
		setTimeout(() => this.sesuccessImpactStoriesTable());
	}

	lobbyingToolsDataChart() {
		//Graph -30
		$("#Program_wise_no_of_lobbying").html("");

		const lobbying_tools_data = this.apiData.lobbying_tools_data;
		let lobbying_tools_data_count =
			lobbying_tools_data.map((e) => e.count).reduce((a, b) => a + b, 0) || 0;
		$("#Program_wise_no_of_lobbying_count").html(lobbying_tools_data_count);
		if (!lobbying_tools_data?.length) {
			$("#Program_wise_no_of_lobbying").html(nodata_html());
			return;
		}
		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"Program_wise_no_of_lobbying",
				am4charts.XYChart
			);
			chart.logo.disabled = "true";
			chart.scrollbarX = new am4core.Scrollbar();

			// Add data
			chart.data = lobbying_tools_data;

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.title.text = "Number of lobbying/communication tools";
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
	lobbyingToolsDataTableTable() {
		var mydata = this.apiData.lobbying_tools_data_table;
		//console.log(mydata);
		const tableData = mydata.map((d) => {
			const result = `
      <tr>
        <td>${d.country_name}</td>
        <td>${d.crop_name}</td>
        <td>${d.name}</td>
        <td>
          <a href="${d.link}" target="_blank" class="text-dark">${d.link}</a>
        </td>
      </tr>
      `;
			return result;
		});

		$("#resultpo4>tbody").html(tableData);
		$("tbody>tr").addClass("tbl_bg");
	}

	sesuccessImpactStoriesTable() {
		var mydata = this.apiData.success_impactstories_table;

		const tableData = mydata.map((group) => {
			const child = group.child;
			if (child.length) {
				return group.child
					.map((data, i) => {
						let tData = ``;
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
					})
					.join();
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
				
				`;
			}
		});

		$("#resultpo5>tbody").html(tableData);
		$("tbody>tr").addClass("tbl_bg");
	}

	newtoolsAdoptedChart() {
		$("#program_wise_new_tools").html("");
		let newtools_adopted = this.apiData.newtools_adopted_country;
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
	communicationApproachesChart() {
		$("#program_wise_no_of_communication").html("");
		const communication_approaches =
			this.apiData.communication_approaches_country;
		$("#program_wise_no_of_communication_count").html(
			communication_approaches.map((e) => e.count).reduce((a, b) => a + b, 0) ||
				0
		);
		if (!communication_approaches?.length) {
			$("#program_wise_no_of_communication").html(nodata_html());
			return;
		}

		am4core.ready(function () {
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end

			// Create chart instance
			var chart = am4core.create(
				"program_wise_no_of_communication",
				am4charts.XYChart
			);
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
	advocacyToolsChart() {
		$("#programwise_advocacy_tools").html("");
		const advocacy_tools = this.apiData.advocacy_tools;
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
			var chart = am4core.create(
				"programwise_advocacy_tools",
				am4charts.XYChart
			);
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

	successImpactStoriesChart() {
		$("#program_wise_number_of_success_and_impact_stories").html("");

		const success_impactstories = this.apiData.success_impactstories;
		const count = success_impactstories.map(d=> d.count).reduce((a,b)=> a+b,0)
		//debugger
		$("#program_wise_number_of_success_and_impact_stories_count").html(count);

		if (!success_impactstories?.length) {
			$("#program_wise_number_of_success_and_impact_stories").html(
				nodata_html()
			);
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
			chart.data = success_impactstories;

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
	advocacyToolsTable() {
		var mydata = this.apiData.advocacy_tools_table;
		const tableData = mydata.map((d) => {
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
		});

		$("#resultpo2>tbody").html(tableData);
		$("tbody>tr").addClass("tbl_bg");
	}
}
