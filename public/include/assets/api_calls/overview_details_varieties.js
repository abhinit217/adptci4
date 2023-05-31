const showVarietiesDetails = (details) => {
    let popupContent = new VarietiesDetails(details).init();
    $("#details-modal-container").empty().html(popupContent);
}


class VarietiesDetails{
    constructor(details){
        this.mediaUrl = `${window.location.origin}/mtp`;
        this.chartColors = [
            "#FFAA4C", "#EE9589", "#079BAB", "#6EA9CB", "#CB6E7E", "#288427", "#660919",
            "#0FAA4B", "#FE9590", "#179BAB", "#7EA9CB", "#DB6E7E", "#388427", "#760919",
            "#1FAA4B", "#0E9590", "#279BAB", "#8EA9CB", "#EB6E7E", "#488427", "#860919",
        ];
        this.chartColors = Array(100).fill(this.chartColors).flat();
        
        this.countryWise = details.country_wise.filter(a => a.count);
        this.regionWise = details.region_wise.filter(a => a.count);
        this.clusterWise = details.cluster_wise.filter(a => a.count);
        this.indicatorWise = details.indicator_wise.filter(a => a.count);
        this.sdgWise = details.sdg_wise.filter(a => a.count);
        this.publicationsWise = details.publications_wise.filter(a => a.count);

        this.tableData = details.table_data;
        
        this.lookupData = details.lookup_data;
        this.varietiesWise = details.varieties_wise.filter(a => a.count);
        this.cropWise = details.crop_wise.filter(a => a.hcount + a.gcount + a.bcount);

        this.regionSdgWise = details.region_country_sdg;
        this.programSdgWise = details.program_cluster_sdg;
    }

    init(){
        let countryWise2 = this.countryWise.map(a => {
            a.id = ccodes.find(b => b.name == a.name)?.code;
            a.value = a.count;
            return a;
        }).filter(a => a.id && a.count);

        let availableCropIds = Array.from(new Set(this.tableData.map(a => a.crop_id)));
        let cropFarmStationWiseData = availableCropIds.map(a => {
            
            let crop = this.lookupData.crops_list.find(b => b.crop_id == a).crop_name;
            let varietiesData = this.tableData.filter(b => b.crop_id == a).map(b => JSON.parse(b.form_data));
            let varieties = Array.from(new Set(varietiesData.map(b => b.field_1319)))
            let quantities = varieties.map(b => {
                let varieties_id = b;
                let yield_on_station = varietiesData.filter(c => c.field_1319 == b).map(c => Number(c.field_1336) || 0).reduce((x, y) => x+y, 0);
                let yield_on_farm = varietiesData.filter(c => c.field_1319 == b).map(c => Number(c.field_1337) || 0).reduce((x, y) => x+y, 0);
                return {"varieties_id": varieties_id, "yield_on_station": yield_on_station, "yield_on_farm": yield_on_farm};
            })
            return {[crop]: quantities}
        });

        let cropOptions = this.lookupData.crops_list.map(a => {
            return {"value": a.crop_id, "label": a.crop_name}
        });
        cropOptions = [{"value": 0, "label": "All Crops"}, ...cropOptions];
        let primaryTraitWiseData = {};
        cropOptions.forEach(a => {
            if(a.value){
                let cropTableData = this.tableData.filter(b => b.crop_id == a.value);
                if(cropTableData.length){
                    let allPrimaryTraits = cropTableData.map(b => JSON.parse(b.form_data)).map(b => b.field_1344).filter(b => b);
                    let traitCounts = Array.from(new Set(allPrimaryTraits)).map(b => {
                        let count = allPrimaryTraits.filter(c => c == b).length
                        return {"name": b, "count": count}
                    }).filter(b => b.count);
                    primaryTraitWiseData[a.label] = traitCounts;
                } else{
                    primaryTraitWiseData[a.label] = [];
                }
            } else{
                let allPrimaryTraits = this.tableData.map(b => JSON.parse(b.form_data)).map(b => b.field_1344).filter(b => b);
                let traitCounts = Array.from(new Set(allPrimaryTraits)).map(b => {
                    let count = allPrimaryTraits.filter(c => c == b).length
                    return {"name": b, "count": count}
                }).filter(b => b.count);
                primaryTraitWiseData[a.label] = traitCounts || [];
            }
        });

        this.baseTemplate = `
            <div class="row mt-145px mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header border-bottom-0">
                            <div class="d-flex justify-content-between">
                                <div> <h4 class="text_titles mb-0">Varieties Released</h4></div>
                                <div> <button type="button" class="close" data-dismiss="modal" style="font-size: 40px; margin-top: -13px;">&times;</button></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">ICRISAT variety released</h4>
                                    <div class="" id="details-varieties-wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">ICRISAT variety released</h4>
                                    <div class="d-flex text-center" id="details-varieties-wise2" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Hybrid/Variety release across countries </h4>
                                    <div id="map-variety-wise" style="height: 500px;"></div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">Crop-wise hybrid/ variety released</h4>
                                    <div class="" id="details-crop-wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text_title mb-2">On-station and on-farm yield of varieties</h4>
                                    <div class="" id="details-farmstation-wise" style="width:100%;height: 640px;"></div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">
                                        Trait-wise varieties released &nbsp;&nbsp;
                                        <select id="fltr-crop1" class="border border-0"></select>
                                        <div class="" id="details-p-traits-wise" style="width:100%;height: 300px;"></div>
                                    </h4>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Scientific publications </h4>
                                    <div class="" id="details-publications-wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-8 col-lg-8">
                                    <div class="card_indicator1" style="background: #fff;">
                                    <div class="card shadow border-0 mt-4">
                                        <div class="card-body">
                                            <h3 class="text_title mb-2">ICRISAT's contribution towards SDGs -  Region & Country wise</h3>
                                            <div class="" id="details-chart-sdg1" style="width:100%;height: 475px;"></div>
                                        </div>
                                    </div>
                                    <div class="card shadow border-0 mt-4">
                                        <div class="card-body">
                                            <h3 class="text_title mb-2">ICRISAT's contribution towards SDGs -  Program & Cluster wise</h3>
                                            <div class="" id="details-chart-sdg2" style="width:100%;height: 475px;"></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="card shadow border-0 mt-4 card_indicator">
                                            <div class="card-body p-2">
                                            <table class="table table-bordered" >
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-01.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 1. End poverty in all its forms everywhere</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-02.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 2. End hunger, achieve food security and improved nutrition and promote sustainable agriculture</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-03.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold">  Goal 3: Ensure healthy lives and promote well-being for all at all ages </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-04.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 4. Ensure inclusive and equitable quality education and promote lifelong learning opportunities for all</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-05.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 5. Achieve gender equality and empower all women and girls</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-06.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 6. Ensure availability and sustainable management of water and sanitation for all</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-07.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 7. Ensure access to affordable, reliable, sustainable and modern energy for all </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-08.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 8. Promote sustained, inclusive and sustainable economic growth, full and productive employment and decent work for all</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-09.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 9. Build resilient infrastructure, promote inclusive and sustainable industrialization and foster innovation</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-10.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 10. Reduce inequality within and among countries</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-11.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 11. Make cities and human settlements inclusive, safe, resilient and sustainable</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-12.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 12. Ensure sustainable consumption and production patterns</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-13.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 13. Take urgent action to combat climate change and its impacts</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-14.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 14. Conserve and sustainably use the oceans, seas and marine resources for sustainable development</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-15.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 15. Protect, restore and promote sustainable use of terrestrial ecosystems, sustainably manage forests, combat desertification, and halt and reverse land degradation and halt biodiversity loss</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-16.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 16. Promote peaceful and inclusive societies for sustainable development, provide access to justice for all and build effective, accountable and inclusive institutions at all levels</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center p-0"><img src="${this.mediaUrl}/include/assets/images/sdgs/E-WEB-Goal-17.png" style="width:150px;"></td>
                                                            <td class="font-weight-bold"> Goal 17. Strengthen the means of implementation and revitalize the Global Partnership for Sustainable Development</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            <!-- <div class="mt-3" id="chart-sdg3-help"></div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
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

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Region-wise</h4>
                                    <div class="" id="details-region-wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="text_title mb-2">Cluster-wise</h4>
                                    <div class="" id="details-cluster-wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>

                            <div class="row mt-2">
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

            this.varietiesWiseChart(this.varietiesWise);
            this.cropWiseChart(this.cropWise);
            this.countryWiseMap(countryWise2);
            this.farmStationWiseChart(cropFarmStationWiseData);
            this.publicationsWiseChart(this.publicationsWise);
            this.traitWiseChart(cropOptions, primaryTraitWiseData);

            this.regionSDGCountryChart(this.regionSdgWise);
            this.programSDGClusterChart(this.programSdgWise);

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
                    title: {text: "Number of Activities"},
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
                        "name": "Activities",
                        "data": chartData.map((a, i) => {
                            return {"y": a.count, "color": this.chartColors[i]};
                        })
                    }, 
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
                    title: {text: "Number of Varieties"},
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
                        "name": "Varieties",
                        "data": chartData.map((a, i) => {
                            return {"y": a.count, "color": this.chartColors[i]};
                        })
                    }, 
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
                    title: {text: "Number of Varieties"},
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
                        "name": "Varieties",
                        "data": chartData.map((a, i) => {
                            return {"y": a.count, "color": this.chartColors[i]};
                        })
                    }, 
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

    varietiesWiseChart(chartData){
        if(chartData.length){
            let total = chartData.map(a => a.count).reduce((a, b) => a+b, 0) || 0;
            Highcharts.chart("details-varieties-wise", {
                chart: {type: "pie"},
                credits: {enabled: false},
                title: {
                    verticalAlign: "middle",
                    floating: true,
                    y: -10,
                    text: `<span style="font-weight:bold;color:#000">${total}</span>`
                },
                plotOptions: {
                    pie: {
                        innerSize: "0%",
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        },
                        showInLegend: true,
                    },
                },
                colors: this.chartColors,
                series: [{
                    "name": "Varieties",
                    "data": chartData.map(a => [a.name, a.count])
                }]
            });

            let cards = chartData.map(a => {
                return `<div class="mx-3 px-2 text-center">
                    <h2 class="mb-2"><div data-tabnum="0" class="d-inline-block">${a.count}</div></h2>
                    <p>${a.name}</p>
                </div>`
            }).join("\n") + `<div class="mx-3 px-2 text-center">
                <h2 class="mb-2"><div data-tabnum="0" class="d-inline-block">${total}</div></h2>
                <p>Total</p>
            </div>`;
            $("#details-varieties-wise2").html(cards)
        } else {
            $("#details-varieties-wise, #details-varieties-wise2").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    cropWiseChart(chartData){
        if(chartData.length){

            Highcharts.chart("details-crop-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Varieties"},
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
                    {"name": "Breeding Material",  "data": chartData.map((a, i) => {return {"y": a.bcount};})},
                    {"name": "Hybrid",  "data": chartData.map((a, i) => {return {"y": a.hcount};})},
                    {"name": "Germplasm",  "data": chartData.map((a, i) => {return {"y": a.gcount};})},
                ]
            });

        } else{
            $("#details-crop-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    countryWiseMap(mapData){
        am4core.ready(function () {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("map-variety-wise", am4maps.MapChart);
            mapData.forEach((d, i) => d.color = chart.colors.getIndex(i));
            chart.geodata = am4geodata_worldIndiaLow;
            chart.projection = new am4maps.projections.Miller();
            chart.logo.disabled = "true";
            chart.numberFormatter.numberFormat = "#,###.##";
      
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
            polygonSeries.exclude = ["AQ"];
            polygonSeries.useGeodata = true;
            polygonSeries.nonScalingStroke = true;
            polygonSeries.strokeWidth = 0.5;
            polygonSeries.calculateVisualCenter = true;
      
            var imageSeries = chart.series.push(new am4maps.MapImageSeries());
            imageSeries.data = mapData;
            imageSeries.dataFields.value = "value";
      
            var imageTemplate = imageSeries.mapImages.template;
            imageTemplate.nonScaling = true;
      
            var circle = imageTemplate.createChild(am4core.Circle);
            circle.fillOpacity = 0.7;
            circle.propertyFields.fill = "color";
            circle.tooltipText = "{name}: [bold]{value}";
      
            imageSeries.heatRules.push({
                target: circle,
                property: "radius",
                min: 10,
                max: 40,
                dataField: "value",
              });
        
            imageTemplate.adapter.add("latitude", function (latitude, target) {
                var polygon = polygonSeries.getPolygonById(
                  target.dataItem.dataContext.id
                );
                if (polygon) {
                  return polygon.visualLatitude;
                }
                return latitude;
              });
        
            imageTemplate.adapter.add("longitude", function (longitude, target) {
                var polygon = polygonSeries.getPolygonById(
                  target.dataItem.dataContext.id
                );
                if (polygon) {
                  return polygon.visualLongitude;
                }
                return longitude;
              });
        
            var label = imageTemplate.createChild(am4core.Label);
            label.text = "{value}";
            label.horizontalCenter = "middle";
            label.verticalCenter = "middle";
            label.padding(-10, 0, 0, 0);
            label.fontSize = 10;
            label.adapter.add("dy", function (dy, target) {
                var circle = target.parent.children.getIndex(0);
                return circle.pixelRadius;
            });

            chart.exporting.menu = new am4core.ExportMenu();
            chart.exporting.adapter.add("data", function(data) {
                data.data = [];
                for(var i = 0; i < imageSeries.data.length; i++) {
                    var row = imageSeries.data[i];
                    data.data.push({
                        id: row.id,
                        value: row.value
                    });
                }
                return data;
            });
        });
    }

    farmStationWiseChart(chartData){
        const responseObject = chartData.reduce((x,y) => Object.assign(x,y), {});
		const c_chartData = Object.keys(responseObject).filter(k => responseObject[k]?.length).map(k => {
    
			const yield_on_station = responseObject[k].map(d => {
			 return {category: `${k.trim()}-${d.varieties_id}-yield_on_station`, l1:k.trim(), l2: `${k.trim()}-${d.varieties_id}`, l3: 'yield_on_station', l4: d.varieties_id, station_value: d.yield_on_station, farm_value: d.yield_on_farm}
			 })
			   
		   return [...yield_on_station].sort((a, b) => a.l2.localeCompare(b.l2));
		 }).flat();
		const l1Range = Array.from(new Set(c_chartData.map(d => d.l1)));
		const l2Range = Array.from(new Set(c_chartData.map(d => d.l2)));
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end
    
            var chart = am4core.create("details-farmstation-wise", am4charts.XYChart);
    
            // some extra padding for range labels
            chart.paddingBottom = 50;
    
            chart.cursor = new am4charts.XYCursor();
            chart.scrollbarX = new am4core.Scrollbar();
    
            // will use this to store colors of the same items
            var colors = {};
            
            
    
            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.minGridDistance = 60;
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataItems.template.text = "";
    
            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.min = 0.5;
            valueAxis.max = 6500;
            valueAxis.extraMax = 0.2; 
            valueAxis.renderer.minGridDistance = 10;
            valueAxis.strictMinMax = true;
            //valueAxis.logarithmic = true;
            //valueAxis.fill = am4core.color('#ff0000')
            valueAxis.title.text = "KG/Ha";
    
            
    
            // single column series for all data
            var columnSeries = chart.series.push(new am4charts.ColumnSeries());
            columnSeries.columns.template.width = am4core.percent(80);
            columnSeries.tooltipText = "{l1} - {l2} - yield_on_station - {valueY}";
            columnSeries.dataFields.categoryX = "category";
            columnSeries.dataFields.valueY = "station_value";
            columnSeries.name = "Yield on station";
            columnSeries.fontSize = 18;
            columnSeries.columns.template.fill = am4core.color("#d79494");
    
            var columnSeries1 = chart.series.push(new am4charts.ColumnSeries());
            columnSeries1.columns.template.width = am4core.percent(80);
            columnSeries1.tooltipText = "{l1} - {l2} - yield_on_farm - {valueY}";
            columnSeries1.dataFields.categoryX = "category";
            columnSeries1.dataFields.valueY = "farm_value";
            columnSeries1.name = "Yield on farm";
            columnSeries1.fontSize = 18;
            columnSeries1.columns.template.fill = am4core.color("#7cb5ec");
    
            // second value axis for quantity
            var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis2.renderer.opposite = true;
            valueAxis2.syncWithAxis = valueAxis;
            valueAxis2.tooltip.disabled = true;
            //valueAxis2.fill = am4core.color('#ff00ff')
    
            
    
    
            var rangeTemplate = categoryAxis.axisRanges.template;
            rangeTemplate.tick.disabled = false;
            rangeTemplate.tick.location = 0;
            rangeTemplate.tick.strokeOpacity = 0.6;
            rangeTemplate.tick.length = 0;
            rangeTemplate.grid.strokeOpacity = 0.5;
            rangeTemplate.label.tooltip = new am4core.Tooltip();
            rangeTemplate.label.tooltip.dy = -10;
            rangeTemplate.label.cloneTooltip = false;
    
                l1Range.forEach(d => {
                        const tempArray = c_chartData.filter(e => e.l1 == d);
                        var range = categoryAxis.axisRanges.create();
                        range.category = tempArray[0].category;
                        range.endCategory = tempArray[tempArray.length - 1].category;
                        range.label.text = tempArray[0].l1;
                        range.label.dy = 200;
                        range.label.truncate = true;
                        range.label.fontWeight = "bold";
                        range.label.tooltipText = tempArray[0].l1;
                        range.tick.length = 200;
                })
                
                l2Range.forEach(d => {
                        const tempArray = c_chartData.filter(e => e.l2 == d);
                        var range = categoryAxis.axisRanges.create();
                        range.category = tempArray[0].category;
                        range.endCategory = tempArray[tempArray.length - 1].category;
                        range.label.text = tempArray[0].l4;
                        range.label.dy = 5;
                        range.label.truncate = true;
                        range.label.fontSize = 12;
                        range.label.fontWeight = "400";
                        //range.label.tooltipText = tempArray[0].l2;
    
                        range.label.tooltipText = tempArray[0].l4;
                        range.label.rotation = -90;
                        range.label.horizontalCenter = "right";
                        range.label.verticalCenter = "middle";
                })
    
    
            chart.data = c_chartData;
    
    
            // last tick
            var range = categoryAxis.axisRanges.create();
            range.category = chart.data[chart.data.length - 1].category;
            range.label.disabled = true;
            range.tick.location = 1;
            range.grid.location = 1;
            chart.legend = new am4charts.Legend();
            chart.legend.position = 'top';
    
            // chart.exporting.filePrefix = "veriety_wise";
            // exportAmchart('dwn-img-117',chart)
    
            chart.logo.disabled = "true";
    
        });
    }

    publicationsWiseChart(chartData){
        if(chartData.length){
            let total = chartData.map(a => a.count).reduce((a, b) => a+b, 0) || 0;
            Highcharts.chart("details-publications-wise", {
                chart: {type: "pie"},
                credits: {enabled: false},
                title: {
                    verticalAlign: "middle",
                    floating: true,
                    y: -10,
                    text: `<span style="font-weight:bold;color:#000">${total}</span>`
                },
                plotOptions: {
                    pie: {
                        innerSize: "0%",
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        },
                        showInLegend: true,
                    },
                },
                colors: this.chartColors,
                series: [{
                    "name": "Publications",
                    "data": chartData.map(a => [a.name, a.count])
                }]
            });

            
        } else {
            $("#details-publications-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    traitWiseChart(cropOptions, chartData1){
        $("#fltr-crop1").empty().html(cropOptions.map(a => `<option value="${a.label}">${a.label}</option>`));
        this.traitWiseChartVary(chartData1["All Crops"]);
        $("#fltr-crop1").on("change", () => {
            this.traitWiseChartVary(chartData1[$("#fltr-crop1").val()]);
        })
    }

    traitWiseChartVary(chartData1){
        this.primaryTraitWiseChart(chartData1);
    }

    primaryTraitWiseChart(chartData){
        if(chartData.length){
            Highcharts.chart("details-p-traits-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Count"},
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
                        "name": "Traits",
                        "data": chartData.map((a, i) => {
                            return {"y": a.count, "color": this.chartColors[0]};
                        })
                    }, 
                ]
            });
        } else{
            $("#details-p-traits-wise").empty().html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    regionSDGCountryChart(sankeyData){

        let sdgInfo = Array.from(new Set([
            ...sankeyData.filter(a => a.from.startsWith("Goal")).map(a => a.from),
            ...sankeyData.filter(a => a.to.startsWith("Goal")).map(a => a.to)
        ])).map(e => `<span style="font-size:12px"><b>${e}</b><span>`).join("<br>");
        //this.chartRegionSDGCountryHelp.empty().html(sdgInfo);

        sankeyData.forEach(a => {
            if(a.from.startsWith("Goal")){
                if(a.from.includes(".")){
                    a.from = a.from.slice(0, a.from.indexOf("."))
                } else if(a.from.includes(":")){
                    a.from = a.from.slice(0, a.from.indexOf(":"))
                }
            } 

            if(a.to.startsWith("Goal")){
                if(a.to.includes(".")){
                    a.to = a.to.slice(0, a.to.indexOf("."))
                } else if(a.to.includes(":")){
                    a.to = a.to.slice(0, a.to.indexOf(":"))
                }
            }
        });
        post(JSON.stringify({"purpose": "FILTERS"}))
        .then(response => {
            response = JSON.parse(response)
            if(response.status){
                // Regions
                let regions = response.region_list;
                regions.sort((a, b) => a.region_name > b.region_name ? 0 : -1);
                regions.push({"region_name": "Other", "region_id": null})
                let region_names = regions.map(b => b.region_name);
                
                // SDGs
                let sdgs = Array.from(new Set([
                    ...sankeyData.filter(a => a.from.startsWith("Goal")).map(a => a.from),
                    ...sankeyData.filter(a => a.to.startsWith("Goal")).map(a => a.to)
                ]));

                // Countries
                let countries = response.country_list.filter(a => !region_names.includes(a.country_name));
                countries.sort((a, b) => a.country_name > b.country_name ? 0 : -1);
                let country_names = countries.map(b => b.country_name);
                
                let chartData = [];
                region_names.forEach(r => {
                    let regionItems = sankeyData.filter(a => a.from == r && sdgs.includes(a.to));
                    regionItems.forEach(a => {
                        let chartDataItem = {"from": a["from"], "to": a["to"], "count": a["count"]};
                        chartData.push(chartDataItem);
                    });
                });
                region_names.forEach(e => {
                    let region_sankey = chartData.filter(f => f.from == e);
                    if(region_sankey.length){
                        let totalCount = region_sankey.map(g => g.count).reduce((g, h) => g+h, 0);
                        region_sankey.forEach(g => {
                            g.totalCount = totalCount;
                            g.weight = (g.count*100)/totalCount;
                        })
                    }
                })
                sdgs.forEach(s => {
                    let sdgItems = sankeyData.filter(a => a.from == s && country_names.includes(a.to));
                    sdgItems.forEach(a => {
                        let chartDataItem = {"from": a["from"], "to": a["to"], "count": a["count"]};
                        chartData.push(chartDataItem);
                    });
                });
                sdgs.forEach(e => {
                    let sdg_sankey = chartData.filter(f => f.from == e);
                    if(sdg_sankey.length){
                        let totalCount = sdg_sankey.map(g => g.count).reduce((g, h) => g+h, 0);
                        sdg_sankey.forEach(g => {
                            g.totalCount = totalCount;
                            g.weight = (g.count*100)/totalCount;
                        })
                    }
                })

                Highcharts.chart("details-chart-sdg1", {
                    chart: {type: "sankey"},
                    credits: {enabled: false},
                    title: {text: null},
                    tooltip: {
                        pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <b>{point.weight:.2f} %</b>',
                        nodeFormatter: function(){return `<b>${this.name}</b>`;}
                    },
                    plotOptions: {
                        sankey: {
                            animation: true,
                            dataLabels: {
                                enabled: true, 
                                style: {backgroundColor: "black", color:"black"},
                            },
                            showInLegend: false
                        }
                    },
                    series: [{
                        keys: ['from', 'to', 'weight'],
                        data: chartData.map(a => [a["from"], a["to"], a["weight"]]),
                        name: 'SDG mapping for Regions, Countries'
                    }]
                
                });
            }
        })
        .catch(err => console.log(err));
    }

    programSDGClusterChart(chartData){
        
        chartData.forEach(a => {
            if(a.from.startsWith("Goal")){
                if(a.from.includes(".")){
                    a.from = a.from.slice(0, a.from.indexOf("."))
                } else if(a.from.includes(":")){
                    a.from = a.from.slice(0, a.from.indexOf(":"))
                }
            } 

            if(a.to.startsWith("Goal")){
                if(a.to.includes(".")){
                    a.to = a.to.slice(0, a.to.indexOf("."))
                } else if(a.to.includes(":")){
                    a.to = a.to.slice(0, a.to.indexOf(":"))
                }
            }
        });

        let rps = Array.from(new Set(chartData.filter(r => !r.from.startsWith("Goal")).map(r => r.from)));
        rps.forEach(r => {
            let rp_sankey = chartData.filter(e => e.from == r);
            if(rp_sankey.length){
                let totalCount = rp_sankey.map(g => g.count).reduce((g, h) => g+h, 0);
                rp_sankey.forEach(g => {
                    g.totalCount = totalCount;
                    g.weight = (g.count*100)/g.totalCount;
                })
            }
        })
        let sdgs = Array.from(new Set(chartData.filter(s => s.from.startsWith("Goal")).map(s => s.from)));
        sdgs.forEach(s => {
            let sdg_sankey = chartData.filter(e => e.from == s);
            if(sdg_sankey.length){
                let totalCount = sdg_sankey.map(g => g.count).reduce((g, h) => g+h, 0);
                sdg_sankey.forEach(g => {
                    g.totalCount = totalCount;
                    g.weight = (g.count*100)/g.totalCount;
                })
            }
        })

        Highcharts.chart("details-chart-sdg2", {
            chart: {type: "sankey"},
            credits: {enabled: false},
            title: {text: null},
            tooltip: {
                pointFormat: '<b>{point.from}</b> to <b>{point.to}</b>: <b>{point.weight:.2f} %</b>',
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
                name: 'SDG mapping for Programs, Clusters'
            }]
        
        });
    }
}
