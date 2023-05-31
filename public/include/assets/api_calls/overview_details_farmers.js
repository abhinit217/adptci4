const showFarmersDetails = (details) => {
    let popupContent = new FarmersDetails(details).init();
    $("#details-modal-container").empty().html(popupContent);
}

class FarmersDetails{
    // mostly segregation by gender
    constructor(details){
        this.chartColors = ["#fda94f", "#ee948b", "grey"];
        this.mediaUrl = `${window.location.origin}/mtp`;

        this.countryWise = details.country_wise;
        this.genderWise = details.gender_wise;
        this.indicatorWise = details.indicator_wise;
        this.regionWise = details.region_wise;
        this.programWise = details.program_wise;
        this.sdgWise = details.sdg_wise
    }

    init(){
        this.baseTemplate = `
            <div class="row mt-145px mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header border-bottom-0">
                            <div class="d-flex justify-content-between">
                            <div> <h4 class="text_titles mb-0 text-uppercase">FARMERS AND RURAL COMMUNITIES REACHED THROUGH ICRISAT INTERVENTIONS AND TECHNOLOGIES</h4></div>
                            <div> <button type="button" class="close" data-dismiss="modal" style="font-size: 40px; margin-top: -13px;">&times;</button></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-7 col-lg-7">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8 col-lg-8">
                                            <h4 class="text_title mb-2 text-uppercase">Country-wise</h4>
                                            <div id="details-country-wise" style="width:100%;height: 300px;"></div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="mt-100px">
                                                <h3 class="text_title text-uppercase">Farmers</h3>
                                                <div class="d-flex justify-content-between align-items-center flex-wrap" id="details-gender-wise">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-5 col-lg-5">
                                    <div class="table-responsive" style="height: 300px;overflow-y: scroll;overflow-x: hidden;">
                                        <table class="table table-bordered">
                                            <tbody id="details-indicator-wise">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2 text-uppercase">Region-wise</h4>
                                <div class="" id="details-region-wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2 text-uppercase">Program-wise</h4>
                                    <div class="" id="details-program-wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-sm-12 col-md-8 col-lg-8">
                               <h4 class="text_title mb-2 text-uppercase">SDG-Indicator mapping </h4>
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
            this.genderWiseNumbers(this.genderWise);
            this.indicatorWiseNumbers(this.indicatorWise);
            this.regionWiseChart(this.regionWise);
            this.programWiseChart(this.programWise);
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
                    title: {text: "Farmers"},
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
                    {"name": "Male",  "data": chartData.map((a, i) => {return {"y": a.male};})},
                    {"name": "Female",  "data": chartData.map((a, i) => {return {"y": a.female};})},
                    {"name": "N/A",  "data": chartData.map((a, i) => {return {"y": a.no_gender};})},
                ]
            });
        } else{
            $("#details-country-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    genderWiseNumbers(chartData){
        let total = Object.values(chartData).reduce((a, b) => a + b, 0);
        let male = Math.round((chartData["male"]*100)/total, 1);
        let female = Math.round((chartData["female"]*100)/total, 1);
        let aci = Math.round((chartData["aci"]*100)/total, 1);
        let html = `
            <div class="align-items-start">
                <h2 class="font-24px">${withCommas(total)}</h2>
                <p class="mb-0 text_small">Total Farmer</p>
            </div>
            <div>
                <p class="mb-0 text_pos1">________ <span>${female} %</span></p>
                <p class="mb-0"><img src="${this.mediaUrl}/include/assets/images/female.png"></p>
                <p class="mb-0 text_small">Female</p>
            </div>
            <div>
                <p class="mb-0 text_pos2"> <span>${male} %</span>________</p>
                <p class="mb-0"><img src="${this.mediaUrl}/include/assets/images/male.png"></p>
                <p class="mb-0 text_small">MALE</p>
            </div>
            <div class="pr-4">
                <p class="mb-0 text_pos text-center"> <span>${aci} %</span></p>
                <p class="mb-0"><img src="${this.mediaUrl}/include/assets/images/youth.svg"></p>
                <p class="mb-0 text_small">Gender N/A</p>
            </div>
        `
        $("#details-gender-wise").empty().html(html);
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
        } else{
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
                    title: {text: "Farmers"},
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
                    {"name": "Male",  "data": chartData.map((a, i) => {return {"y": a.male};})},
                    {"name": "Female",  "data": chartData.map((a, i) => {return {"y": a.female};})},
                    {"name": "N/A",  "data": chartData.map((a, i) => {return {"y": a.no_gender};})},
                ]
            });
        } else{
            $("#details-region-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    programWiseChart(chartData){
        if(chartData.length){
            Highcharts.chart("details-program-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Farmers"},
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
                    {"name": "Male",  "data": chartData.map((a, i) => {return {"y": a.male};})},
                    {"name": "Female",  "data": chartData.map((a, i) => {return {"y": a.female};})},
                    {"name": "N/A",  "data": chartData.map((a, i) => {return {"y": a.no_gender};})},
                ]
            });
        } else{
            $("#details-program-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
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
        } else{
            $("#details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
}