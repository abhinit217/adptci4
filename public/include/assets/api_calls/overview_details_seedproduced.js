const showSeedProducedDetails = (details) => {
    let popupContent = new SeedProducedDetails(details).init();
    $("#details-modal-container").empty().html(popupContent);
}

class SeedProducedDetails{
    constructor(details){
        this.chartColors = [
            "#FFAA4C", "#EE9589", "#079BAB", "#6EA9CB", "#CB6E7E", "#288427", "#660919",
            "#0FAA4B", "#FE9590", "#179BAB", "#7EA9CB", "#DB6E7E", "#388427", "#760919",
            "#1FAA4B", "#0E9590", "#279BAB", "#8EA9CB", "#EB6E7E", "#488427", "#860919",
        ];
        this.chartColors = Array(100).fill(this.chartColors).flat();
        this.tableData = details.table_data;
        this.lookupData = details.lookup_data;
        this.seedTypes = details.seed_types;
        this.indicatorWise = details.indicator_wise;
        this.sdgWise = details.sdg_wise;
    }

    init(){
        let masterData = this.tableData.map(a => {
            let data = {}
            data["country"] = this.lookupData.country_list.find(b => a.country_id == b.country_id).country_name;
            data["region"] = this.lookupData.country_list.find(b => a.country_id == b.country_id).region_name;
            data["crop"] = this.lookupData.crops_list.find(b => a.crop_id == b.crop_id).crop_name;
            let fd = JSON.parse(a.form_data);
            // BREEDER
            let breederEntries = ["field_1409", "field_1410", "field_1411", "field_1412", "field_1413", "field_1414", "field_1444"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            let breederValues = fd["field_1415"] == "Tonnes" ?  breederEntries.map(e => e) : breederEntries.map(e => e/1e3);
            let breederTotal = breederValues.reduce((a, b) => a+b, 0);
            // FOUNDATION
            let foundationEntries = ["field_1417", "field_1418", "field_1419", "field_1420", "field_1445", "field_1421", "field_1422"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            let foundationValues = fd["field_1423"] == "Tonnes" ?  foundationEntries.map(e => e) : foundationEntries.map(e => e/1e3);
            let foundationTotal = foundationValues.reduce((a, b) => a+b, 0);
            // CERTIFIED
            let certifiedEntries = ["field_1425", "field_1426", "field_1427", "field_1428", "field_1446", "field_1429", "field_1430"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            let certifiedValues = fd["field_1431"] == "Tonnes" ?  certifiedEntries.map(e => e) : certifiedEntries.map(e => e/1e3);
            let certifiedTotal = certifiedValues.reduce((a, b) => a+b, 0);
            // QDS
            let qdsEntries = ["field_1433", "field_1434", "field_1435", "field_1436", "field_1447", "field_1437", "field_1438"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            let qdsValues = fd["field_1439"] == "Tonnes" ?  qdsEntries.map(e => e) : qdsEntries.map(e => e/1e3);
            let qdsTotal = qdsValues.reduce((a, b) => a+b, 0);

            // CGIAR
            let cgiarEntries = ["field_1409", "field_1417", "field_1425", "field_1433"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            cgiarEntries[0] = fd["field_1415"] == "Tonnes" ? cgiarEntries[0] : cgiarEntries[0]/1e3;
            cgiarEntries[1] = fd["field_1423"] == "Tonnes" ? cgiarEntries[1] : cgiarEntries[0]/1e3;
            cgiarEntries[2] = fd["field_1431"] == "Tonnes" ? cgiarEntries[2] : cgiarEntries[0]/1e3;
            cgiarEntries[3] = fd["field_1439"] == "Tonnes" ? cgiarEntries[3] : cgiarEntries[0]/1e3;
            let cgiarTotal = cgiarEntries.reduce((a, b) => a+b, 0);
            // NARS
            let narsEntries = ["field_1410", "field_1418", "field_1426", "field_1434"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            narsEntries[0] = fd["field_1415"] == "Tonnes" ? narsEntries[0] : narsEntries[0]/1e3;
            narsEntries[1] = fd["field_1423"] == "Tonnes" ? narsEntries[1] : narsEntries[0]/1e3;
            narsEntries[2] = fd["field_1431"] == "Tonnes" ? narsEntries[2] : narsEntries[0]/1e3;
            narsEntries[3] = fd["field_1439"] == "Tonnes" ? narsEntries[3] : narsEntries[0]/1e3;
            let narsTotal = narsEntries.reduce((a, b) => a+b, 0);
            // NGO
            let ngoEntries = [ "field_1411", "field_1419", "field_1427", "field_1435"].map(e => fd[e]).map(e => parseFloat(e) || 0);
            ngoEntries[0] = fd["field_1415"] == "Tonnes" ? ngoEntries[0] : ngoEntries[0]/1e3;
            ngoEntries[1] = fd["field_1423"] == "Tonnes" ? ngoEntries[1] : ngoEntries[0]/1e3;
            ngoEntries[2] = fd["field_1431"] == "Tonnes" ? ngoEntries[2] : ngoEntries[0]/1e3;
            ngoEntries[3] = fd["field_1439"] == "Tonnes" ? ngoEntries[3] : ngoEntries[0]/1e3;
            let ngoTotal = ngoEntries.reduce((a, b) => a+b, 0);
            // Seed Company
            let seedCompanyEntries = [ "field_1412", "field_1420", "field_1428", "field_1436" ].map(e => fd[e]).map(e => parseFloat(e) || 0);
            seedCompanyEntries[0] = fd["field_1415"] == "Tonnes" ? seedCompanyEntries[0] : seedCompanyEntries[0]/1e3;
            seedCompanyEntries[1] = fd["field_1423"] == "Tonnes" ? seedCompanyEntries[1] : seedCompanyEntries[0]/1e3;
            seedCompanyEntries[2] = fd["field_1431"] == "Tonnes" ? seedCompanyEntries[2] : seedCompanyEntries[0]/1e3;
            seedCompanyEntries[3] = fd["field_1439"] == "Tonnes" ? seedCompanyEntries[3] : seedCompanyEntries[0]/1e3;
            let seedCompanyTotal = seedCompanyEntries.reduce((a, b) => a+b, 0);
            // Farmer-Growers
            let farmerGrowerEntries = [ "field_1444", "field_1445", "field_1446", "field_1447" ].map(e => fd[e]).map(e => parseFloat(e) || 0);
            farmerGrowerEntries[0] = fd["field_1415"] == "Tonnes" ? farmerGrowerEntries[0] : farmerGrowerEntries[0]/1e3;
            farmerGrowerEntries[1] = fd["field_1423"] == "Tonnes" ? farmerGrowerEntries[1] : farmerGrowerEntries[0]/1e3;
            farmerGrowerEntries[2] = fd["field_1431"] == "Tonnes" ? farmerGrowerEntries[2] : farmerGrowerEntries[0]/1e3;
            farmerGrowerEntries[3] = fd["field_1439"] == "Tonnes" ? farmerGrowerEntries[3] : farmerGrowerEntries[0]/1e3;
            let farmerGrowerTotal = farmerGrowerEntries.reduce((a, b) => a+b, 0);
            // Others
            let otherEntries = [ "field_1413", "field_1421", "field_1429", "field_1437" ].map(e => fd[e]).map(e => parseFloat(e) || 0);
            otherEntries[0] = fd["field_1415"] == "Tonnes" ? otherEntries[0] : otherEntries[0]/1e3;
            otherEntries[1] = fd["field_1423"] == "Tonnes" ? otherEntries[1] : otherEntries[0]/1e3;
            otherEntries[2] = fd["field_1431"] == "Tonnes" ? otherEntries[2] : otherEntries[0]/1e3;
            otherEntries[3] = fd["field_1439"] == "Tonnes" ? otherEntries[3] : otherEntries[0]/1e3;
            let otherTotal = otherEntries.reduce((a, b) => a+b, 0);
            // Not applicable
            let naEntries = [ "field_1414", "field_1422", "field_1430", "field_1438" ].map(e => fd[e]).map(e => parseFloat(e) || 0);
            naEntries[0] = fd["field_1415"] == "Tonnes" ? naEntries[0] : naEntries[0]/1e3;
            naEntries[1] = fd["field_1423"] == "Tonnes" ? naEntries[1] : naEntries[0]/1e3;
            naEntries[2] = fd["field_1431"] == "Tonnes" ? naEntries[2] : naEntries[0]/1e3;
            naEntries[3] = fd["field_1439"] == "Tonnes" ? naEntries[3] : naEntries[0]/1e3;
            let naTotal = naEntries.reduce((a, b) => a+b, 0);

            data["breeder"] = breederTotal;
            data["foundation"] = foundationTotal;
            data["certified"] = certifiedTotal;
            data["qds"] = qdsTotal;

            data["CGIAR"] = cgiarTotal;
            data["NARS"] = narsTotal;
            data["NGO"] = ngoTotal;
            data["Seed Company"] = seedCompanyTotal;
            data["Farmer Grower"] = farmerGrowerTotal;
            data["Others"] = otherTotal;
            data["NA"] = naTotal;
            
            return data;
        });
        
        let availableCountries = Array.from(new Set(masterData.map(a => a.country)));
        let countryWiseData = availableCountries.map(a => {
            let name = a;
            let quantity = Number(masterData.filter(b => b.country == a).map(b => b["breeder"] + b["foundation"] + b["certified"] + b["qds"]).reduce((x, y) => x+y, 0).toFixed(2))
            return {"name": name, "quantity": quantity}
        });
        let countryWiseSeedTypeData = availableCountries.map(a => {
            let name = a;
            let breeder = Number(masterData.filter(b => b.country == a).map(b => b["breeder"]).reduce((x, y) => x+y, 0).toFixed(2));
            let foundation = Number(masterData.filter(b => b.country == a).map(b => b["foundation"]).reduce((x, y) => x+y, 0).toFixed(2));
            let certified = Number(masterData.filter(b => b.country == a).map(b => b["certified"]).reduce((x, y) => x+y, 0).toFixed(2));
            let qds = Number(masterData.filter(b => b.country == a).map(b => b["qds"]).reduce((x, y) => x+y, 0).toFixed(2));
            return {"name": name, "breeder": breeder, "foundation": foundation, "certified": certified, "qds": qds}
        });
        

        let availableRegions = Array.from(new Set(masterData.map(a => a.region)));
        let regionWiseData = availableRegions.map(a => {
            let name = a;
            let quantity = Number(masterData.filter(b => b.region == a).map(b => b["breeder"] + b["foundation"] + b["certified"] + b["qds"]).reduce((x, y) => x+y, 0).toFixed(2))
            return {"name": name, "quantity": quantity}
        });

        let availableCrops = Array.from(new Set(masterData.map(a => a.crop)));
        let cropWiseData = availableCrops.map(a => {
            let name = a;
            let quantity = Number(masterData.filter(b => b.crop == a).map(b => b["breeder"] + b["foundation"] + b["certified"] + b["qds"]).reduce((x, y) => x+y, 0).toFixed(2))
            return {"name": name, "quantity": quantity}
        });

        let countryVsCropData = {};
        ["breeder", "foundation", "certified", "qds"].forEach(e => {
            let chartData = [];
            availableCountries.forEach(cn => {
                availableCrops.forEach(cr => {
                    let countryTotal = masterData.filter(m => m.country == cn).map(a => a[e]).reduce((a, b) => a+b, 0);
                    let innerDataItem = masterData.filter(m => m.crop == cr && m.country == cn);
                    if(innerDataItem.length){
                        let dataItem = {};
                        dataItem["from"] = cn;
                        dataItem["to"] = cr;
                        let cropQn = innerDataItem.map(a => a[e]).reduce((a, b) => a+b, 0)
                        dataItem["weight"] = Number(((cropQn*100)/countryTotal).toFixed(2));
                        chartData.push(dataItem);
                    }
                })
            })
            countryVsCropData[e] = chartData.filter(e => e.weight)
        });

        let producerVsCropData = {};
        ["breeder", "foundation", "certified", "qds"].forEach(e => {
            let chartData = [];
            ["CGIAR", "NARS", "NGO", "Seed Company", "Farmer Grower", "Others", "NA"].forEach(pr => {
                availableCrops.forEach(cr => {
                    let producerTotal = masterData.filter(m => m[pr]).map(a => a[e]).reduce((a, b) => a+b, 0);
                    let innerDataItem = masterData.filter(m => m[pr] && m.crop == cr);
                    if(innerDataItem.length){
                        let dataItem = {};
                        dataItem["from"] = pr;
                        dataItem["to"] = cr;
                        let cropQn = innerDataItem.map(a => a[e]).reduce((a, b) => a+b, 0);
                        dataItem["weight"] = Number(((cropQn*100)/producerTotal).toFixed(2));
                        chartData.push(dataItem);
                    }
                })
            });
            producerVsCropData[e] = chartData.filter(e => e);
        });

        let cropWiseSeedTypeData = availableCrops.map(a => {
            let breeder = Number(masterData.filter(b => b.crop == a).map(b => b["breeder"]).reduce((x, y) => x+y, 0).toFixed(2));
            let foundation = Number(masterData.filter(b => b.crop == a).map(b => b["foundation"]).reduce((x, y) => x+y, 0).toFixed(2));
            let certified = Number(masterData.filter(b => b.crop == a).map(b => b["certified"]).reduce((x, y) => x+y, 0).toFixed(2));
            let qds = Number(masterData.filter(b => b.crop == a).map(b => b["qds"]).reduce((x, y) => x+y, 0).toFixed(2));
            
            return {"name": a, "breeder": breeder, "foundation": foundation, "certified": certified, "qds": qds}
        })

        let cropWiseSeedTypeDataAll = {
            "name": "All Crops",
            "breeder": Number(cropWiseSeedTypeData.map(a => a.breeder).reduce((x, y) => x+y, 0).toFixed(2)),
            "foundation": Number(cropWiseSeedTypeData.map(a => a.foundation).reduce((x, y) => x+y, 0).toFixed(2)),
            "certified": Number(cropWiseSeedTypeData.map(a => a.certified).reduce((x, y) => x+y, 0).toFixed(2)),
            "qds": Number(cropWiseSeedTypeData.map(a => a.qds).reduce((x, y) => x+y, 0).toFixed(2)),
        }
        let cropWiseSeedType = [cropWiseSeedTypeDataAll, ...cropWiseSeedTypeData];


        let availableYearIds = Array.from(new Set(this.tableData.map(a => a.year_id)));
        let availableCropIds = Array.from(new Set(this.tableData.map(a => a.crop_id)));
        let cwstYearWiseData = availableCropIds.map(a => {
            let data = {"name": this.lookupData.crops_list.find(b => b.crop_id == a).crop_name};
            data["breederYearly"] = availableYearIds.map(b => {
                let innerData = {"year": this.lookupData.year_list.find(c => c.year_id == b).year};
                let fd = this.tableData.filter(c => c.year_id == b && c.crop_id == a).map(c => JSON.parse(c.form_data))
                let fdCompiled = fd.map(d => {
                    let vals = ["field_1409", "field_1410", "field_1411", "field_1412", "field_1413", "field_1414", "field_1444"].map(e => d[e]).map(e => d["field_1415"] == "Tonnes" ? parseFloat(e) : parseFloat(e/1e3) || 0)
                    return vals.reduce((x, y) => (x+y), 0);
                })
                innerData["quantity"] = fdCompiled.reduce((u, v) => (u+v), 0);
                return innerData;
            });
            data["foundationYearly"] = availableYearIds.map(b => {
                let innerData = {"year": this.lookupData.year_list.find(c => c.year_id == b).year};
                let fd = this.tableData.filter(c => c.year_id == b && c.crop_id == a).map(c => JSON.parse(c.form_data))
                let fdCompiled = fd.map(d => {
                    let vals = ["field_1417", "field_1418", "field_1419", "field_1420", "field_1445", "field_1421", "field_1422"].map(e => d[e]).map(e => d["field_1423"] == "Tonnes" ? parseFloat(e) : parseFloat(e/1e3) || 0)
                    return vals.reduce((x, y) => (x+y), 0);
                })
                innerData["quantity"] = fdCompiled.reduce((u, v) => (u+v), 0);
                return innerData;
            });
            data["certifiedYearly"] = availableYearIds.map(b => {
                let innerData = {"year": this.lookupData.year_list.find(c => c.year_id == b).year};
                let fd = this.tableData.filter(c => c.year_id == b && c.crop_id == a).map(c => JSON.parse(c.form_data))
                let fdCompiled = fd.map(d => {
                    let vals = ["field_1425", "field_1426", "field_1427", "field_1428", "field_1446", "field_1429", "field_1430"].map(e => d[e]).map(e => d["field_1431"] == "Tonnes" ? parseFloat(e) : parseFloat(e/1e3) || 0)
                    return vals.reduce((x, y) => (x+y), 0);
                })
                innerData["quantity"] = fdCompiled.reduce((u, v) => (u+v), 0);
                return innerData;
            });
            data["qdsYearly"] = availableYearIds.map(b => {
                let innerData = {"year": this.lookupData.year_list.find(c => c.year_id == b).year};
                let fd = this.tableData.filter(c => c.year_id == b && c.crop_id == a).map(c => JSON.parse(c.form_data))
                let fdCompiled = fd.map(d => {
                    let vals = ["field_1433", "field_1434", "field_1435", "field_1436", "field_1447", "field_1437", "field_1438"].map(e => d[e]).map(e => d["field_1439"] == "Tonnes" ? parseFloat(e) : parseFloat(e/1e3) || 0)
                    return vals.reduce((x, y) => (x+y), 0);
                })
                innerData["quantity"] = fdCompiled.reduce((u, v) => (u+v), 0);
                return innerData;
            });
            return data;
        });

        let cwstYearWiseAll = {"name": "All Crops"};
        let availableYears = this.lookupData.year_list.map(a => a.year);
        cwstYearWiseAll["breederYearly"] =  availableYears.map(y => {
            let yobj = cwstYearWiseData.map(a => a.breederYearly.filter(b => b.year == y)).flat()
            return {"year": y, "quantity": yobj.map(c => c.quantity).reduce((x, y) => x+y, 0)}
        });
        cwstYearWiseAll["foundationYearly"] = availableYears.map(y => {
            let yobj = cwstYearWiseData.map(a => a.foundationYearly.filter(b => b.year == y)).flat()
            return {"year": y, "quantity": yobj.map(c => c.quantity).reduce((x, y) => x+y, 0)}
        });
        cwstYearWiseAll["certifiedYearly"] = availableYears.map(y => {
            let yobj = cwstYearWiseData.map(a => a.certifiedYearly.filter(b => b.year == y)).flat()
            return {"year": y, "quantity": yobj.map(c => c.quantity).reduce((x, y) => x+y, 0)}
        });
        cwstYearWiseAll["qdsYearly"] = availableYears.map(y => {
            let yobj = cwstYearWiseData.map(a => a.qdsYearly.filter(b => b.year == y)).flat()
            return {"year": y, "quantity": yobj.map(c => c.quantity).reduce((x, y) => x+y, 0)}
        });
        let cwstYearWise = [cwstYearWiseAll, ...cwstYearWiseData];


        let cwst = cropWiseSeedType.map(a => {
            let yw = cwstYearWise.find(b => b.name == a.name);
            return {...a, ...yw};
        });


        let countryCropMapData = {};
        ["breeder", "foundation", "certified", "qds"].forEach(e => {
            countryCropMapData[e] = countryWiseSeedTypeData.map(a => {
                let country_code = ccodes.find(b => b.name == a.name)?.code;
                if(country_code){
                    return {"id": country_code, "name": a.name, "value": a[e]}
                }
            }).filter(a => a && a.value);
        });




        this.baseTemplate = `
            <div class="row mt-145px mt-5">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card shadow border-0 mt-3">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex justify-content-between">
                            <div> <h4 class="text_titles mb-0 text-uppercase">QUANTITY OF SEED PRODUCED</h4></div>
                            <div> <button type="button" class="close" data-dismiss="modal" style="font-size: 40px; margin-top: -13px;">&times;</button></div>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h4 class="text_title mb-2">
                                    Seed Produced &nbsp;&nbsp;
                                    <select id="fltr-crop1" class="border border-0"></select>
                                </h4>
                                <div class="row">
                                    <div class="col-sm-12 col-md-7 col-lg-7">
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4 col-lg-4">Breeder</div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div id="chart-breeder-mini" style="height: 50px;"></div>
                                            </div> 
                                            <div class="col-sm-4 col-md-4 col-lg-4"><span id="number-breeder-mini"></span></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4 col-lg-4">Foundation</div> 
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div id="chart-foundation-mini" style="height: 50px;"></div>
                                            </div> 
                                            <div class="col-sm-4 col-md-4 col-lg-4"><span id="number-foundation-mini"></span></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4 col-lg-4">Certified</div> 
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div id="chart-certified-mini" style="height: 50px;"></div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4"><span id="number-certified-mini"></span></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 col-md-4 col-lg-4">QDS</div> 
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div id="chart-qds-mini" style="height: 50px;"></div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4"><span id="number-qds-mini"></span></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <div id="chart-typewise" style="height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h4 class="text_title mb-2">
                                Seeds produced across countries &nbsp;&nbsp;
                                <select id="fltr-cropseedtype-map" class="border border-0">
                                    <option value="breeder" selected>Breeder</option>
                                    <option value="foundation">Foundation</option>
                                    <option value="certified">Certified</option>
                                    <option value="qds">QDS</option>
                                </select>
                            </h4>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div id="map-cropseedtype-wise" style="height: 500px;"></div>
                            </div>
                        </div>

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
                                <h4 class="text_title mb-2">Country-wise seed types</h4>
                                <div class="" id="details-countryseedtype-wise" style="width:100%;height: 300px;"></div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">Crop-wise</h4>
                                <div class="" id="details-crop-wise" style="width:100%;height: 300px;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">Breeder seed production by country</h4>
                                <div id="chart-breeder" style="height: 400px;"></div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">Foundation seed production by country</h4>
                                <div id="chart-foundation" style="height: 400px;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">Certified seed production by country</h4>
                                <div id="chart-certified" style="height: 400px;"></div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">QDS seed production by country</h4>
                                <div id="chart-qds" style="height: 400px;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">
                                    Country-wise crop seed production &nbsp;&nbsp;
                                    <select id="fltr-country-seedtype" class="border border-0">
                                        <option value="breeder" selected>Breeder</option>
                                        <option value="foundation">Foundation</option>
                                        <option value="certified">Certified</option>
                                        <option value="qds">QDS</option>
                                    </select>
                                </h4>
                                <div class="" id="details-country-x-crop" style="width:100%;height: 450px;"></div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">
                                    Producer category-wise crop seed production &nbsp;&nbsp;
                                    <select id="fltr-producer-seedtype" class="border border-0">
                                        <option value="breeder" selected>Breeder</option>
                                        <option value="foundation">Foundation</option>
                                        <option value="certified">Certified</option>
                                        <option value="qds">QDS</option>
                                    </select>
                                </h4>
                                <div class="" id="details-producer-x-crop" style="width:100%;height: 450px;"></div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="table-responsive" style="height: 165px;overflow-y: scroll;overflow-x: hidden;">
                                    <table class="table table-bordered">
                                        <tbody id="details-indicator-wise">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <h4 class="text_title mb-2 text-uppercase">SDG-Indicator mapping</h4>
                                <div class="" id="details-sdg-wise" style="width:100%;height: 400px;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        `;

        setTimeout(() => {
            this.typeWiseChart(cwst)
            this.countryWiseChart(countryWiseData);
            this.regionWiseChart(regionWiseData);
            this.countryWiseSeedTypeChart(countryWiseSeedTypeData);
            this.cropWiseChart(cropWiseData);
            this.countryXCropChart(countryVsCropData);
            this.producerXCropChart(producerVsCropData);
            this.indicatorWiseNumbers(this.indicatorWise);
            this.sdgWiseChart(this.sdgWise);
            this.countryWiseQuantityMap(countryCropMapData);
            this.breederChart(countryCropMapData["breeder"]);
            this.foundationChart(countryCropMapData["foundation"]);
            this.certifiedChart(countryCropMapData["certified"]);
            this.qdsChart(countryCropMapData["qds"]);
            $("#details-modal").modal("show");
        }, 1000);

        return this.baseTemplate;

    }

    typeWiseChart(cwst){
        let cropOptions = cwst.map(a => `<option value="${a.name}">${a.name}</option>`).join("\n");
        $("select#fltr-crop1").empty().html(cropOptions);
        this.typeWiseChartVARY(cwst.find(a => a.name == "All Crops"));
        $("select#fltr-crop1").on("change", () => {
            this.typeWiseChartVARY(cwst.find(a => a.name == $("select#fltr-crop1").val()))
        });
    }

    typeWiseChartVARY(chartData){
        $("span#number-breeder-mini").empty().html(`${(chartData.breeder).toFixed(2)} Tonnes`);
        $("span#number-foundation-mini").empty().html(`${(chartData.foundation).toFixed(2)} Tonnes`);
        $("span#number-certified-mini").empty().html(`${(chartData.certified).toFixed(2)} Tonnes`);
        $("span#number-qds-mini").empty().html(`${(chartData.qds).toFixed(2)} Tonnes`);

        this.typeWiseSparklineChart("chart-breeder-mini", chartData.breederYearly, this.chartColors[0]);
        this.typeWiseSparklineChart("chart-foundation-mini", chartData.foundationYearly, this.chartColors[1]);
        this.typeWiseSparklineChart("chart-certified-mini", chartData.certifiedYearly, this.chartColors[2]);
        this.typeWiseSparklineChart("chart-qds-mini", chartData.qdsYearly, this.chartColors[3]);

        this.typeWiseBarChart("chart-typewise", [
            {"name": "Breeder", "quantity": Number((chartData.breeder).toFixed(2)), "color": this.chartColors[0]},
            {"name": "Foundation", "quantity": Number((chartData.foundation).toFixed(2)), "color": this.chartColors[1]},
            {"name": "Certified", "quantity": Number((chartData.certified).toFixed(2)), "color": this.chartColors[2]},
            {"name": "QDS", "quantity": Number((chartData.qds).toFixed(2)), "color": this.chartColors[3]},
        ])
        // this.typeWiseBarChart("chart-typewise", [
        //     {"name": "Breeder", "quantity": Number((chartData.breeder).toFixed(2)), "color": "red"},
        //     {"name": "Foundation", "quantity": Number((chartData.foundation).toFixed(2)), "color": "blue"},
        //     {"name": "Certified", "quantity": Number((chartData.certified).toFixed(2)), "color": "yellow"},
        //     {"name": "QDS", "quantity": Number((chartData.qds).toFixed(2)), "color": "green"},
        // ])
    }


    typeWiseSparklineChart(container, chartData, color){
        const chart = Highcharts.SparkLine(container, {
            series: [
                {
                  data: chartData.map((d) => Number(Number(d.quantity  || 0).toFixed(2))),
                  color: color
                },
            ],
            tooltip: {
                formatter: () => {
                    const currentData = chartData[chart.hoverPoint.index];
                    return `<span>${
                        currentData.year
                    } <br/> <b> ${currentData.quantity.toFixed(2)} </b></span>`;
                },
            },
            exporting: {
                enabled: false
            }
        });
    }

    typeWiseBarChart(container, chartData){
        Highcharts.chart(container, {
            chart: {type: "column"},
            credits: {enabled: false},
            title: {text: null},
            xAxis: {
                categories: chartData.map(a => a.name),
                title: {text: null}
            },
            yAxis: {
                min: 0,
                title: {text: "Quantity (Tonnes)"},
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
                    "name": "Seed Type",
                    "data": chartData.map((a, i) => {
                        return {"y": a.quantity, "color": a.color};
                    })
                }, 
            ]
        });
    }

    countryWiseQuantityMap(cwqm){
        this.countryWiseQuantityMapVARY(cwqm["breeder"]);
        $("select#fltr-cropseedtype-map").on("change", () => {
            let mapData = cwqm[$("select#fltr-cropseedtype-map").val()];
            this.countryWiseQuantityMapVARY(mapData);
        })
    }

    breederChart(chartData){
        Highcharts.chart("chart-breeder", {
            chart: {type: "column"},
            credits: {enabled: false},
            title: {text: null},
            xAxis: {
                categories: chartData.map(a => a.name),
                title: {text: null}
            },
            yAxis: {
                min: 0,
                title: {text: "Quantity (Tonnes)"},
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
                    "name": "Seed Type",
                    "data": chartData.map((a, i) => {
                        return {"y": a.value, "color": this.chartColors[0]};
                    })
                }, 
            ]
        });
    }

    foundationChart(chartData){
        Highcharts.chart("chart-foundation", {
            chart: {type: "column"},
            credits: {enabled: false},
            title: {text: null},
            xAxis: {
                categories: chartData.map(a => a.name),
                title: {text: null}
            },
            yAxis: {
                min: 0,
                title: {text: "Quantity (Tonnes)"},
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
                    "name": "Seed Type",
                    "data": chartData.map((a, i) => {
                        return {"y": a.value, "color": this.chartColors[1]};
                    })
                }, 
            ]
        });
    }

    certifiedChart(chartData){
        Highcharts.chart("chart-certified", {
            chart: {type: "column"},
            credits: {enabled: false},
            title: {text: null},
            xAxis: {
                categories: chartData.map(a => a.name),
                title: {text: null}
            },
            yAxis: {
                min: 0,
                title: {text: "Quantity (Tonnes)"},
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
                    "name": "Seed Type",
                    "data": chartData.map((a, i) => {
                        return {"y": a.value, "color": this.chartColors[2]};
                    })
                }, 
            ]
        });
    }

    qdsChart(chartData){
        Highcharts.chart("chart-qds", {
            chart: {type: "column"},
            credits: {enabled: false},
            title: {text: null},
            xAxis: {
                categories: chartData.map(a => a.name),
                title: {text: null}
            },
            yAxis: {
                min: 0,
                title: {text: "Quantity (Tonnes)"},
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
                    "name": "Seed Type",
                    "data": chartData.map((a, i) => {
                        return {"y": a.value, "color": this.chartColors[3]};
                    })
                }, 
            ]
        });
    }

    countryWiseQuantityMapVARY(mapData){
        am4core.ready(function () {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("map-cropseedtype-wise", am4maps.MapChart);
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
            circle.tooltipText = "{name}: [bold]{value}[/] Tonnes";
      
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
                    title: {text: "Tonnes"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true, 
                            style: {backgroundColor: "black", color:"black"}
                        },
                        showInLegend: false
                    }
                },
                legend: {enabled: false},
                tooltip: {pointFormat: " <b>{point.y}</b>"},
                series: [
                    {
                        "name": "Country",
                        "data": chartData.map((a, i) => {
                            return {"y": a.quantity, "color": this.chartColors[i]};
                        })
                    }, 
                ]
            });
        } else {
            $("#details-country-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
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
                    title: {text: "Tonnes"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true, 
                            style: {backgroundColor: "black", color:"black", 
                        }},
                        showInLegend: false
                    }
                },
                legend: {enabled: false},
                tooltip: {pointFormat: " <b>{point.y}</b>"},
                series: [
                    {
                        "name": "Region",
                        "data": chartData.map((a, i) => {
                            return {"y": a.quantity, "color": this.chartColors[i]};
                        })
                    }, 
                ]
            });
        } else {
            $("#details-region-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    countryWiseSeedTypeChart(chartData){
        if(chartData.length){
            Highcharts.chart("details-countryseedtype-wise", {
                chart: {type: "column"},
                credits: {enabled: false},
                title: {text: null},
                xAxis: {
                    categories: chartData.map(a => a.name),
                    title: {text: null}
                },
                yAxis: {
                    min: 0,
                    title: {text: "Tonnes"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true, 
                            style: {backgroundColor: "black", color:"black", 
                            formatter: function () {
                                return parseFloat(this.y.toFixed(2)).toLocaleString();
                            }
                        }},
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
                    {"name": "Breeder",  "data": chartData.map((a, i) => {return {"y": a.breeder};})},
                    {"name": "Foundation",  "data": chartData.map((a, i) => {return {"y": a.foundation};})},
                    {"name": "Certified",  "data": chartData.map((a, i) => {return {"y": a.certified};})},
                    {"name": "QDS",  "data": chartData.map((a, i) => {return {"y": a.qds};})}
                ]
            });
        } else {
            $("#details-countryseedtype-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
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
                    title: {text: "Tonnes"},
                    allowDecimals: false
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true, 
                            style: {backgroundColor: "black", color:"black"
                        }},
                        showInLegend: false
                    }
                },
                legend: {enabled: false},
                tooltip: {pointFormat: " <b>{point.y}</b>"},
                series: [
                    {
                        "name": "Crop",
                        "data": chartData.map((a, i) => {
                            return {"y": a.quantity, "color": this.chartColors[i]};
                        })
                    }, 
                ]
            });
        } else {
            $("#details-crop-wise").css("height", "50px").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    countryXCropChart(masterChartData){
        this.countryXCropChartVARY(masterChartData["breeder"]);
        $("select#fltr-country-seedtype").on("change", () => {
            let charData = masterChartData[$("select#fltr-country-seedtype").val()]
            this.countryXCropChartVARY(charData);
        });
    }

    countryXCropChartVARY(chartData){
        if(chartData.length){
            Highcharts.chart("details-country-x-crop", {
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
        } else {
            $("#details-country-x-crop").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

    producerXCropChart(masterChartData){
        this.producerXCropChartVARY(masterChartData["breeder"]);
        $("select#fltr-producer-seedtype").on("change", () => {
            let charData = masterChartData[$("select#fltr-producer-seedtype").val()]
            this.producerXCropChartVARY(charData);
        });
    }

    producerXCropChartVARY(chartData){
        if(chartData.length){
            Highcharts.chart("details-producer-x-crop", {
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
        } else {
            $("#details-producer-x-crop").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }


    indicatorWiseNumbers(chartData){
        if(chartData.length){
            let html = chartData.map(a => {
                return `<tr>
                    <td class="light_bg">${a.program_name ? a.program_name : ""}</td>
                    <td class="light_bg">${a.cluster_name ? a.cluster_name : ""}</td>
                    <td class="light_bg">${a.name}</td>
                    <th class="dark_bg">${a.count_array.map(b => `<b>${b.name}<b>: <span>${b.count}</span><br>`).join("\n")}</th>
                </tr>`;
            }).join("\n");
            $("#details-indicator-wise").empty().html(html);
        } else {
            $("#details-indicator-wise").html(`<div class="text-center my-auto">Data unavailable</div>`);
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
            $("#details-sdg-wise").html(`<div class="text-center my-auto">Data unavailable</div>`);
        }
    }

}