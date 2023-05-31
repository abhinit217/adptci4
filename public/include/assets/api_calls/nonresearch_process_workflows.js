const showProcessWorkflowDetails = (details) => {
    let popupContent = new ProcessWorkflowDetails(details).init();
    $("#details-modal-container").empty().html(popupContent);
}


class ProcessWorkflowDetails{
    constructor(details){
        this.chartColors = [
            "#FFAA4C", "#EE9589", "#079BAB", "#6EA9CB", "#CB6E7E", "#288427", "#660919",
            "#0FAA4B", "#FE9590", "#179BAB", "#7EA9CB", "#DB6E7E", "#388427", "#760919",
            "#1FAA4B", "#0E9590", "#279BAB", "#8EA9CB", "#EB6E7E", "#488427", "#860919",
        ];
        this.chartColors = Array(100).fill(this.chartColors).flat();
        this.countryWise = details["country_wise"];
        this.regionWise = details["region_wise"];
        this.statusWise = details["status_wise"];
        this.indicatorWise = details["indicator_wise"];
    }

    init(){
        this.baseTemplate = `
            <div class="row mt-145px mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header border-bottom-0">
                            <div class="d-flex justify-content-between">
                                <div> <h4 class="text_titles mb-0">Strategies, policies</h4></div>
                                <div> <button type="button" class="close" data-dismiss="modal" style="font-size: 40px; margin-top: -13px;">&times;</button></div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Country-wise</h4>
                                    <div class="" id="details-country-wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Region-wise</h4>
                                    <div class="" id="details-region-wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Status-wise</h4>
                                    <div class="" id="details-status-wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="table-responsive" style="height: 300px;overflow-y: scroll;overflow-x: hidden;">
                                        <table class="table table-bordered">
                                            <tbody id="details-indicator-wise">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;


        setTimeout(() => {
            this.countryWiseChart(this.countryWise);
            this.regionWiseChart(this.regionWise);
            this.statusWiseChart(this.statusWise);
            this.indicatorWiseNumbers(this.indicatorWise);
            $("#details-modal").modal("show");
        }, 1000)
        return this.baseTemplate;
    }


    
    countryWiseChart(chartData){
        if(chartData.length){
            Highcharts.chart("details-country-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Status indicators"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {enabled: true, style: {backgroundColor: "black", color:"black"}},
                        showInLegend: false
                    }
                },
                legend: {enabled: false},
                tooltip: {pointFormat: " <b>{point.y}</b>"},
                series: [
                    {
                        "name": "Process, workflows, and standard operating procedures",
                        "data": chartData.map((a, i) => {
                            return {"y": a.count, "color": this.chartColors[i]};
                        })
                    }, 
                ]
            });
        } else{
            $("div#details-country-wise").empty().html("Data unavailable");
        }
    }


    regionWiseChart(chartData){
        if(chartData.length){
            Highcharts.chart("details-region-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Status indicators"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {enabled: true, style: {backgroundColor: "black", color:"black"}},
                        showInLegend: false
                    }
                },
                legend: {enabled: false},
                tooltip: {pointFormat: " <b>{point.y}</b>"},
                series: [
                    {
                        "name": "Process, workflows, and standard operating procedures",
                        "data": chartData.map((a, i) => {
                            return {"y": a.count, "color": this.chartColors[i]};
                        })
                    }, 
                ]
            });
        } else{
            $("div#details-region-wise").empty().html("Data unavailable");
        }
    }

    statusWiseChart(chartData){
        if(chartData.length){
            let total = chartData.map(a => a.count).reduce((a, b) => a+b, 0);
            Highcharts.chart("details-status-wise", {
                chart: {type: "pie"},
                credits: {enabled: false},
                title: {
                    verticalAlign: "middle",
                    floating: true,
                    y: -10,
                    text: `<span style="font-weight:bold;color:#000">${withCommas(total)} </span><small style="font-size: 12px;"></small>`,
                },
                plotOptions: {
                    pie: {
                        innerSize: "60%",
                        dataLabels: {enabled: false},
                        showInLegend: true
                    },
                },
                tooltip: {pointFormat: " <b>{point.y}</b><small></small>"},
                colors: this.chartColors,
                series: [{
                    "name": "Seed Produced",
                    "data": chartData.map(a => [a.name, a.count])
                }]
            });
        } else{
            $("div#details-status-wise").empty().html("Data unavailable");
        }
    }

    indicatorWiseNumbers(chartData){
        if(chartData.length){
            let html = chartData.map(a => {
                return `<tr>
                    <td class="light_bg">${a.program_name ? a.program_name : ""}</td>
                    <td class="light_bg">${a.cluster_name ? a.cluster_name : ""}</td>
                    <td class="light_bg">${a.name}</td>
                    <th class="dark_bg">${withCommas(a.count)}</th>
                </tr>`;
            }).join("\n");
            $("#details-indicator-wise").empty().html(html);    
        } else {
            $("#details-indicator-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
}