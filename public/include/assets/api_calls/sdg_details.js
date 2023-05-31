const showSdgDetails = (details) => {
    let popupContent = new SdgDetails(details).init();
    $("#details-modal-container").empty().html(popupContent);
}

class SdgDetails {
    // mostly segregation by gender
    constructor(details) {
        this.chartColors = ["#fda94f", "#ee948b", "grey"];
        this.mediaUrl = `${window.location.origin}/mtp`;
        this.sdgWiseFarmer = details.sdg_wise_farmers
        this.sdg_wise_area_coverd = details.sdg_wise_area_coverd
        this.sdgWiseSeed = details.sdg_wise_seed
        this.sdgWisePartnership = details.sdg_wise_partnership
        this.sdgWiseOutreach = details.sdg_wise_outreach_events
        this.sdgWiseDemonstration = details.sdg_wise_demonstration
        this.sdgWisePolicyFramework = details.sdg_wise_policy_framework
        this.sdgWiseBreedingMaterials = details.sdg_wise_breeding_materials
        this.sdgWiseQuantityProcessed = details.sdg_wise_quantity_processed
        this.sdgWiseDigitalTools = details.sdg_wise_digital_tools
        this.sdgWiseClimateTools = details.sdg_wise_climate_information_tools
        this.sdgWiseNrmTools = details.sdg_wise_nrm_tools
        this.sdgWiseGenomicTools = details.sdg_wise_genomic_tools
        this.sdgWiseInnovationTools = details.sdg_wise_innovation_system_tools
        this.sdgWiseTechnologiesUpscaled = details.sdg_wise_technologies_upscaled
        this.sdgWiseVarietiesReleased = details.sdg_indicater_varieties_released
    }

    init() {
        this.baseTemplate = `
            <div class="row mt-145px mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header border-bottom-0">
                            <div class="d-flex justify-content-between">
                            <div class="title-center"> 
                                <h4 class="text_titles mb-2 text-uppercase">SDG-Indicator mapping </h4>
                            </div>
                            <div> <button type="button" class="close" data-dismiss="modal" style="font-size: 40px; margin-top: -13px;">&times;</button></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                               <div class="col-sm-12 col-md-12 col-lg-12">
                               <h4 class="text_title mb-0 text-uppercase">FARMERS AND RURAL COMMUNITIES REACHED THROUGH ICRISAT INTERVENTIONS AND TECHNOLOGIES</h4>
                               <div class="" id="details-sdg-wise" style="width:100%;height: 400px;"></div>
                               </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Area covered through different interventions of ICRISAT </h4>
                                    <div class="" id="area-details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2 text-uppercase">QUANTITY OF SEED PRODUCED</h4>
                                    <div class="" id="seed-details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2 text-uppercase">NUMBER OF PARTNERSHIPS DEVELOPED</h4>
                                    <div class="" id="partnership-details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of outreach events and campaigns conducted</h4>
                                    <div class="" id="outreach-details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of demonstrations/benchmark sites established</h4>
                                    <div class="" id="demo-details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">NUMBER OF POLICY FRAMEWORKS DEVELOPED AND INFLUENCED</h4>
                                    <div class="" id="policy-details-sdg-wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">NUMBER OF PROCESSING UNITS ESTABLISHED/SUPPORTED</h4>
                                    <div class="" id="processed_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">DIGITAL TOOLS AND PLATFORMS DEVELOPED</h4>
                                    <div class="" id="digitaltools_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of Climate Information service Tools</h4>
                                    <div class="" id="climatetools_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of NRM tools</h4>
                                    <div class="" id="nrmtools_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of Genomic tools and innovations developed</h4>
                                    <div class="" id="ginomictools_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of innovation system tools and technologies developed</h4>
                                    <div class="" id="innovationtools_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">TECHNOLOGIES UPSCALED</h4>
                                    <div class="" id="technologies_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Varieties Released</h4>
                                    <div class="" id="varieties_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Number of breeding materials</h4>
                                    <div class="" id="breeding_details_sdg_wise" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        setTimeout(() => {
            this.sdgWiseFarmerChart(this.sdgWiseFarmer);
            this.sdgWiseAreaChart(this.sdg_wise_area_coverd);
            this.sdgWiseSeedChart(this.sdgWiseSeed);
            this.sdgWisePartnershipChart(this.sdgWisePartnership);
            this.sdgWiseOutreachChart(this.sdgWiseOutreach);
            this.sdgWiseDemonstrationChart(this.sdgWiseDemonstration);
            this.sdgWisePolicyFrameworkChart(this.sdgWisePolicyFramework);
            this.sdgWiseBreedingMaterialsChart(this.sdgWiseBreedingMaterials);
            this.sdgWiseQuantityProcessedChart(this.sdgWiseQuantityProcessed);
            this.sdgWiseDigitalToolsChart(this.sdgWiseDigitalTools);
            this.sdgWiseClimateToolsChart(this.sdgWiseClimateTools);
            this.sdgWiseNrmToolsChart(this.sdgWiseNrmTools);
            this.sdgWiseGenomicToolsChart(this.sdgWiseGenomicTools);
            this.sdgWiseInnovationToolsChart(this.sdgWiseInnovationTools);
            this.sdgWiseTechnologiesUpscaledChart(this.sdgWiseTechnologiesUpscaled);
            this.sdgWiseVarietiesReleasedChart(this.sdgWiseVarietiesReleased);
            $("#details-modal").modal("show");
        }, 1000)



        return this.baseTemplate;
    }

    sdgWiseInnovationToolsChart(sankeyData){
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

            Highcharts.chart("innovationtools_details_sdg_wise", {
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
            $("#innovationtools_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable`);
        }
    }

    sdgWiseGenomicToolsChart(sankeyData){
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

            Highcharts.chart("ginomictools_details_sdg_wise", {
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
            $("#ginomictools_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable`);
        }
    }

    sdgWiseNrmToolsChart(sankeyData){
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

            Highcharts.chart("nrmtools_details_sdg_wise", {
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
            $("#nrmtools_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable`);
        }
    }

    sdgWiseClimateToolsChart(sankeyData){
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

            Highcharts.chart("climatetools_details_sdg_wise", {
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
            $("#climatetools_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable`);
        }
    }

    sdgWiseFarmerChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("details-sdg-wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
    sdgWiseAreaChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("area-details-sdg-wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
            $("#area-details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWiseSeedChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("seed-details-sdg-wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
            $("#seed-details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWisePartnershipChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("partnership-details-sdg-wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
            $("#partnership-details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    sdgWiseOutreachChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("outreach-details-sdg-wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
            $("#outreach-details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWiseDemonstrationChart(sankeyData){
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

            Highcharts.chart("demo-details-sdg-wise", {
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
            $("#demo-details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWisePolicyFrameworkChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("policy-details-sdg-wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
            $("#policy-details-sdg-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWiseBreedingMaterialsChart(sankeyData) {
        if (sankeyData.length) {
            let sdgs = Array.from(new Set(sankeyData.map(e => e.from)));
            let chartData = sdgs.map(s => {
                let filteredSdgs = sankeyData.filter(a => a.from == s)
                let totalCount = filteredSdgs.map(a => a.count).reduce((a, b) => a + b, 0);
                filteredSdgs.forEach(a => a.weight = Number(((a.count * 100) / totalCount).toFixed(2)))
                return filteredSdgs;
            }).flat(1);

            chartData.forEach(a => {
                if (a.from.startsWith("Goal")) {
                    if (a.from.includes(".")) {
                        a.from = a.from.slice(0, a.from.indexOf("."))
                    } else if (a.from.includes(":")) {
                        a.from = a.from.slice(0, a.from.indexOf(":"))
                    }
                }
            });

            Highcharts.chart("breeding_details_sdg_wise", {
                chart: { type: "sankey" },
                credits: { enabled: false },
                title: { text: null },
                tooltip: {
                    pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <br><b>{point.weight:.2f} %</b>',
                    nodeFormatter: function () { return `<b>${this.name}</b>`; }
                },
                plotOptions: {
                    sankey: {
                        dataLabels: { enabled: true, style: { backgroundColor: "black", color: "black" } },
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
            $("#breeding_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }

    }
    sdgWiseQuantityProcessedChart(sankeyData){
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

            Highcharts.chart("processed_details_sdg_wise", {
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
            $("#processed_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWiseDigitalToolsChart(sankeyData){
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

            Highcharts.chart("digitaltools_details_sdg_wise", {
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
            $("#digitaltools_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable`);
        }
    }
    sdgWiseTechnologiesUpscaledChart(sankeyData){
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

            Highcharts.chart("technologies_details_sdg_wise", {
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
            $("#technologies_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
    sdgWiseVarietiesReleasedChart(sankeyData){
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

            Highcharts.chart("varieties_details_sdg_wise", {
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
            $("#varieties_details_sdg_wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }
}