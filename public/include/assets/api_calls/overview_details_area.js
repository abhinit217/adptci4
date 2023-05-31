const showAreaDetails = (details) => {
    let popupContent = new AreaDetails(details).init();
    $("#details-modal-container").empty().html(popupContent);
}

class AreaDetails{
    constructor(details){
        this.chartColors = ["#fda94f", "#ee948b"];
        this.countryWise = details.country_wise.filter(a => a.area_covered_under_soil_conservation + a.area_covered_under_improved_varieties + a.area_covered_under_watershed + a.area_covered_under_no_label);
        this.indicatorWise = details.indicator_wise.filter(a => a.count);
        this.regionWise = details.region_wise.filter(a => a.area_covered_under_soil_conservation + a.area_covered_under_improved_varieties + a.area_covered_under_watershed + a.area_covered_under_no_label);
        // this.programWise = details.program_wise.filter(a => a.count);
        this.clusterWise = details.cluster_wise.filter(a => a.area_covered_under_soil_conservation + a.area_covered_under_improved_varieties + a.area_covered_under_watershed + a.area_covered_under_no_label);
        this.sdgWise = details.sdg_wise.filter(a => a.count);
    }

    init(){
        this.baseTemplate = `
            <div class="row mt-145px mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header border-bottom-0">
                            <div class="d-flex justify-content-between">
                                <div> <h4 class="text_titles mb-0">Area covered through different interventions of ICRISAT </h4></div>
                                <div> <button type="button" class="close" data-dismiss="modal" style="font-size: 40px; margin-top: -13px;">&times;</button></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Country-wise</h4>
                                    <div class="" id="details-country-wise" style="width:100%;height: 300px;"></div>
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

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Region-wise</h4>
                                    <div class="" id="details-region-wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Cluster-wise</h4>
                                    <div class="" id="details-cluster-wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-sm-12 col-md-8 col-lg-8">
                            
                            <h4 class="text_title mb-2">SDG-Indicator mapping</h4>
                                <div class="" id="details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        setTimeout(() => {
            this.countryWiseChart(this.countryWise);
            this.indicatorWiseNumbers(this.indicatorWise);
            this.regionWiseChart(this.regionWise);
            this.clusterWiseChart(this.clusterWise);
            this.sdgWiseChart(this.sdgWise);
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
                    title: {text: "Area (ha)"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {enabled: true, style: {backgroundColor: "black", color:"black"}},
                        showInLegend: true
                    }
                },
                legend: {enabled: true},
                tooltip: {
                    pointFormat: " <span style='color: {series.color}'>{series.name}</span><b> {point.y}</b><br>",
                    shared: true,
                },
                colors: this.chartColors,
                series: [
                    {"name": "Soil Conservation",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_soil_conservation};})},
                    {"name": "Improved Varieties",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_improved_varieties};})},
                    {"name": "Under Watershed",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_watershed};})},
                    {"name": "Others",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_no_label};})},
                ]
            });
        } else {
            $("#details-country-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
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
                    title: {text: "Area (ha)"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {enabled: true, style: {backgroundColor: "black", color:"black"}},
                        showInLegend: true
                    }
                },
                legend: {enabled: true},
                tooltip: {
                    pointFormat: " <span style='color: {series.color}'>{series.name}</span><b> {point.y}</b><br>",
                    shared: true,
                },
                colors: this.chartColors,
                series: [
                    {"name": "Soil Conservation",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_soil_conservation};})},
                    {"name": "Improved Varieties",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_improved_varieties};})},
                    {"name": "Under Watershed",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_watershed};})},
                    {"name": "Others",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_no_label};})},
                ]
            });
        } else {
            $("#details-region-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    clusterWiseChart(chartData){
        if(chartData.length){
            Highcharts.chart("details-cluster-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Area (ha)"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {enabled: true, style: {backgroundColor: "black", color:"black"}},
                        showInLegend: true
                    }
                },
                legend: {enabled: true},
                tooltip: {
                    pointFormat: " <span style='color: {series.color}'>{series.name}</span><b> {point.y}</b><br>",
                    shared: true,
                },
                colors: this.chartColors,
                series: [
                    {"name": "Soil Conservation",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_soil_conservation};})},
                    {"name": "Improved Varieties",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_improved_varieties};})},
                    {"name": "Under Watershed",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_watershed};})},
                    {"name": "Others",  "data": chartData.map((a, i) => {return {"y": a.area_covered_under_no_label};})},
                ]
            });
        } else {
            $("#details-cluster-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }


    sdgWiseChart(sankeyData){
        if(sankeyData.length){
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a+b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count*100)/totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if(a.from.startsWith("Goal")){
                    if(a.from.includes(".")){
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if(a.from.includes(":")){
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                } 
            });

            Highcharts.chart("details-sdg-wise", {
                chart: {type: "sankey"},
                credits: {enabled: false},
                title: {text: null},
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function(){return `<b>${this.name}</b>`;}
                },
                plotOptions: {
                    sankey: {
                        dataLabels: {enabled: true, style: {backgroundColor: "black", color:"black"}},
                        showInLegend: false
                    }
                },
                series: [{
                    keys: ['from', 'to', 'weight'],
                    data: chartData.map(a => [a["from"], a["to"], a["weight"]]),
                    name: 'SDG mapping for Indicators'
                }]
            
            });
        } else {
            $("#details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
}