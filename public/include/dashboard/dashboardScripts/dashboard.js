var countrySegmentVal = $('#countrySegmentVal').val();

$(window).on("load", () => {
    const urlObject = new URL(window.location.href);
    const params = Array.from(urlObject.searchParams.keys()).map(a => {
        let result = {};
        result[a] = urlObject.searchParams.get(a);
        return result;
    }).reduce((a, b) => Object.assign(a, b), {});
    let dashboard = new AtpdDashboard(countrySegmentVal, params?.snId || null);
    dashboard.init();
});

var base_url = $('#base').val();

class AtpdDashboard{
    constructor(countryId, snId){
        this.initialSNId = snId;
        // Page HTML elements
        this.filterSN = $("select#filter-sn");
        this.filterPS = $("select#filter-ps")
        this.submit = $("button#submit");
        this.mapContainerId = "dashboard-map";
        this.dashboardLevelTitle = $("div#dashboard-level-title");
        this.dashboardBreadcrumb = $("div#dashboard-breadcrumb");
        this.dashboardParent = $("div#dashboard-parent");
        this.dashboardChildren = $("div#dashboard-children");
        this.subNationalLabel = $("span#label-sn");
        this.mapOptionCountry = $("span#map-option-country");
        this.mapOptionSNLevel = $("span#map-option-sn");
        this.mapViewToggle = $("input[type='radio'][name='dashboard-map-view']");
        this.mapViewChosen = "country";
        this.mapLegendContainerId = "map-legend";
        this.mapLegendContainer = $("div#map-legend");
        

        this.descSNPlural = $("span#dashboard-sn-plural");
        this.descSNCount = $("b#dashboard-sn-count");
        this.descSNList = $("ul#dashboard-sn-list");
        this.descPSType = $("b#dashboard-ps-type");

        this.popupNDContainer = $("div#national-chart-modal-container");
        this.popupNDContainerId = "national-chart-modal-container";
        this.popupND = $("div#national-chart-modal");

        // Files to be read (as alternative to API calls)
        [this.icFormData, this.rptFormData] = ["ic_form_data.csv", "rpt_form_relation.csv"];
        [this.lkpYears, this.lkpSubNational, this.lkpProductionSystem] = ["lkp_year.csv", "lkp_subnational.csv", "lkp_production_system.csv"];
        [this.lkpDimensions, this.lkpSubDimensions, this.lkpCategories, this.lkpIndicators]
            = ["lkp_dimensions.csv", "lkp_sub_dimensions.csv", "lkp_categories.csv", "lkp_indicator.csv"];
        [this.lkpDimensionWeights, this.lkpSubDimensionWeights, this.lkpCategoryWeights, this.lkpIndicatorWeights]
            = ["lkp_dimension_weight.csv", "lkp_subdimension_weight.csv", "lkp_category_weight.csv", "lkp_indicator_weight.csv"];
        [this.lkpMeasurementLevels, this.lkpMeasurementUnits] = ["lkp_level_measurement.csv", "lkp_m_units.csv"];

        // Map files, countries and subnational-levels
        this.continentMapFile = "africa.topojson";
        this.countryIndex = [
            { "id": 1, "name": "Kenya", "mapFile": "countries/kenya.topojson", "snLevel": "County", "snPlural": "Counties", "center": [-0.0236, 37.9062], "initialZoomLevel": 6.5 },
            { "id": 2, "name": "Uganda", "mapFile": "countries/uganda.topojson", "snLevel": "District", "snPlural": "Districts", "center": [1.3733, 32.2903], "initialZoomLevel": 7.5 },
            { "id": 3, "name": "Ethiopia", "mapFile": "countries/ethiopia.topojson", "snLevel": "Zone", "snPlural": "Zones", "center": [9.1450, 40.4897], "initialZoomLevel": 6 },
        ];
        this.country = this.countryIndex.find(a => a["id"] == countryId);

        // Data objects
    
        // Lookups
        this.subNationals = [];
        this.years = [];
        this.productionSystems = [];
        this.dimensions = [];
        this.subDimensions = [];
        this.categories = [];
        this.indicators = [];
        this.dimensionWeights = [];
        this.subDimensionWeights = [];
        this.categoryWeights = [];
        this.indicatorWeights = [];
        this.measurementLevels = [];
        this.units = [];
        
        // MapData
        this.map = null;
        this.mapLegend = null;
        this.continentGeoData = null;
        this.countryGeoData = null;

        // Drilldown selections
        this.chosenDimensionId = null;
        this.chosenSubDimensionId = null;
        this.chosenCategoryId = null;
        this.chosenIndicatorId = null;

        // From map
        this.clickedSNId = null;
        this.clickedSNName = null;
        this.currentDataLevel = "country";

        // Calculated Intermediate datasets
        // normals averaged and weighted at their respective levels
        // Initial load inputs
        this.formData = []; // take the form records for whole country;
        this.countryData = []; // this for all
        this.countryDataNI = []; // exclusively those records which have national level indicators
        this.countryDataSNI = []; // exclusively those records which have subnational level indicators
        this.selectedPsSnIds = []; // this either comes from the snId selected
        this.includeNationalScore = true;

        // baseline year scores across all levels (indicators, categories, subdimensions, dimensions);
        // all should have a flag called is_baseline
        this.indicatorScores = [];
        this.categoryScores = [];
        this.subDimensionScores = [];
        this.dimensionScores = [];
        this.locationScores = [];

        // min-max taken from baseline years across all levels (indicators, categories, subDimensions, dimensions)
        this.indBaselineScores = [];
        this.catBaselineScores = [];
        this.subDimBaselineScores = [];
        this.dimBaselineScores = [];

        // From map
        this.clickedSNId = null;
        this.clickedSNName = null;
        this.currentDataLevel = "country";
    }

    init = () => {
        this.mapOptionCountry.html(this.country.name);
        this.mapOptionSNLevel.html(`Disaggregated by ${this.country.snPlural}`);
        this.descSNPlural.html(this.country.snPlural);

        if (this.map != undefined || this.map != null) {
            this.map.remove();
            this.map.off();
        }
        this.mapContainerElement = L.DomUtil.get(this.mapContainerId);
        if (this.mapContainerElement != null) this.mapContainerElement._leaflet_id = null;
        this.map = L.map(this.mapContainerId, { fullscreenControl: true, zoomSnap: 0.5 });
        this.streetLayer = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");
        this.map.options.minZoom = 4;
        this.streetLayer.addTo(this.map);

        this.loadData();
    }

    loadData = () => {
        Promise.all([
            // Form relation, Input
            this.loadCSVFile(this.icFormData), this.loadCSVFile(this.rptFormData),
            // Lookup files (alternate to api)
            this.loadCSVFile(this.lkpSubNational), this.loadCSVFile(this.lkpYears), this.loadCSVFile(this.lkpProductionSystem),
            this.loadCSVFile(this.lkpDimensions), this.loadCSVFile(this.lkpSubDimensions), this.loadCSVFile(this.lkpCategories), this.loadCSVFile(this.lkpIndicators),
            this.loadCSVFile(this.lkpDimensionWeights), this.loadCSVFile(this.lkpSubDimensionWeights), this.loadCSVFile(this.lkpCategoryWeights), this.loadCSVFile(this.lkpIndicatorWeights),
            this.loadCSVFile(this.lkpMeasurementLevels), this.loadCSVFile(this.lkpMeasurementUnits),
            // Maps
            this.loadMapFile(this.continentMapFile), this.loadMapFile(this.country.mapFile)
        ])
        .then(([
            icFormResponse, rptFormResponse,
            subNationalResponse, yearsResponse, productionSystemsResponse,
            dimensionsResponse, subDimensionsResponse, categoriesResponse, indicatorsResponse,
            dimensionWeightsResponse, subDimensionWeightsResponse, categoryWeightsResponse, indicatorWeightsResponse,
            measurementLevelsResponse, measurementUnitsResponse,
            continentMapResponse, countryMapResponse
        ]) => {
            // main form datasets and form relation table
            this.formRelation = this.csvToArray(rptFormResponse).filter(a => a.country_id == this.country.id);
            this.formData = this.csvToArray(icFormResponse).filter(a => a.country_id == this.country.id);

            // lookups
            this.subNationals = this.csvToArray(subNationalResponse).filter(a => a.country_id == this.country.id);
            this.years = this.csvToArray(yearsResponse);
            this.productionSystems = this.csvToArray(productionSystemsResponse);
            this.dimensions = this.csvToArray(dimensionsResponse);
            this.subDimensions = this.csvToArray(subDimensionsResponse);
            this.categories = this.csvToArray(categoriesResponse);
            this.indicators = this.csvToArray(indicatorsResponse);
            this.dimensionWeights = this.csvToArray(dimensionWeightsResponse).filter(a => a.country_id == this.country.id);
            this.subDimensionWeights = this.csvToArray(subDimensionWeightsResponse).filter(a => a.country_id == this.country.id);
            this.categoryWeights = this.csvToArray(categoryWeightsResponse).filter(a => a.country_id == this.country.id);
            this.indicatorWeights = this.csvToArray(indicatorWeightsResponse).filter(a => a.country_id == this.country.id);
            this.measurementLevels = this.csvToArray(measurementLevelsResponse);
            this.units = this.csvToArray(measurementUnitsResponse);

            // map objects
            let continentTopoData = JSON.parse(continentMapResponse);
            this.continentGeoData = topojson.feature(continentTopoData, continentTopoData.objects.collection);
            let countryTopoData = JSON.parse(countryMapResponse);
            this.countryGeoData = topojson.feature(countryTopoData, countryTopoData.objects.collection);
        })
        .then(() => this.fillFilterOptions(this.initialSNId))
        .then(() => this.storeCountryData())
        .then(() => this.storeIndicatorScores())
        .then(() => this.storeCategoryScores())
        .then(() => this.storeSubDimensionScores())
        .then(() => this.storeDimensionScores())
        .then(() => this.storeLocationScores())
        .then(() => {
            this.submit.on("click", () => {
                this.clickedSNId = null;
                this.clickedSNName = null;
                let selectedSNValues = this.filterSN.selectpicker("val").map(a => this.num(a));
                let selectedSNList = selectedSNValues.map(a => this.subNationals.find(b => b.subnational_id == a).subnational).map(a => `<li><div>${a}</div></li>`).join("\n");
                this.subNationalLabel.empty().html(this.country.snPlural);
                this.descSNPlural.empty().html(selectedSNValues.length > 1 ? this.country.snPlural : this.country.snLevel);
                this.descSNList.empty().html(selectedSNList);
                this.descPSType.empty().html(`${$('select#filter-ps option:selected').text()} Production Systems`);
                this.descSNCount.html(selectedSNValues.length);
                let selectedPSValue = this.num(this.filterPS.selectpicker("val"));
                this.selectedPsSnIds = selectedPSValue ? this.subNationals.filter(a => a.production_system_id == selectedPSValue).map(a => a.subnational_id) : [];
                this.selectedPsSnIdsForMap = selectedPSValue ? this.subNationals.filter(a => a.production_system_id == selectedPSValue).map(a => a.subnational_id) : [];
                this.includeNationalScore = selectedPSValue ? false : true;

                if (this.countryData.length) {
                    if(this.currentDataLevel == "country") this.showLevel1();
                    else if(this.currentDataLevel == "dimension") this.showLevel2();
                    else if(this.currentDataLevel == "subdimension") this.showLevel3();
                    else if(this.currentDataLevel == "category") this.showLevel4();
                } else {
                    console.error("No data with these options, please change and try again");
                    alert("No data with these options, please change and try again");
                }

            });
            
        })
        .then(() => this.submit.trigger("click"))
        .catch(err => {
            console.error(err);
            alert("Error loading/processing files, please check console for details");
        })
        .finally(() => stopWaiting());
    }

    fillFilterOptions = (initialSNId) => {
        let snIdsInFormData = this.uqArray(this.formData.map(a => a.county_id));
        let filterSNHtml = this.subNationals
            .filter(a => snIdsInFormData.includes(a.subnational_id))
            .map(a => `<option value="${a.subnational_id}" data-ps-type="${a.production_system_id}">${a.subnational} ${a.production_system ? `(${a.production_system})` : ""}</option>`);
        this.filterSN.html(filterSNHtml).selectpicker("selectAll");

        this.filterPS.on("change", () => {
            let chosenPSType = this.filterPS.selectpicker("val");
            if(!parseInt(chosenPSType)){
                this.filterSN.selectpicker("selectAll")
            } else{
                let chosenPS_SNs = this.subNationals.filter(a => a.production_system_id == chosenPSType && snIdsInFormData.includes(a.subnational_id)).map(a => a.subnational_id);
                this.filterSN.selectpicker("val", chosenPS_SNs);
            }
        });

        this.filterSN.on("change", () => {
            let chosenSNIds = this.filterSN.selectpicker("val").map(a => parseInt(a));
            let chosenSN_PSs = this.uqArray(this.subNationals.filter(a => chosenSNIds.includes(a.subnational_id) && a.production_system_id).map(a => a.production_system_id));
            this.filterPS.selectpicker("val", chosenSN_PSs.length > 1 ? "0" : chosenSN_PSs[0]);
        });

        if(initialSNId && !isNaN(initialSNId)){
            this.filterSN.selectpicker("val", initialSNId);
            this.filterSN.trigger("change");
            let SN_PS = this.subNationals.find(a => a.subnational_id == initialSNId).production_system_id || "0";
            $(`select#filter-ps option[value!=${SN_PS}]`).attr("disabled", "disabled");
            this.filterPS.selectpicker("refresh");
        }
    }

    storeCountryData = () => {
        // separate subnational level indicators and national level indicators 
        this.countryData = this.formData.map(a => {
            let result = {
                "m_level": a.county_id ? "subnational" : "national",
                "subnational_id": a.county_id ? a.county_id : this.country.id,
                "sn_ps_type": this.subNationals.find(b => b.subnational_id == a.county_id)?.production_system || null,
                "year": this.years.find(b => b.year_id == a.year_id).year,
                "dimension_id": a.dimension_id,
                "sub_dimension_id": a.sub_dimension_id,
                "category_id": a.category_id,
                "indicator_id": a.indicator_id,
                "actual": a.actual_value
            };
            let rptData = this.formRelation.find(b => b.indicator_id == a.indicator_id);
            result["desired_change"] = rptData.e_d_change;
            result["is_binary"] = rptData.measurement_unit_id == 40 ? true : false;
            return result;
        }).filter(a => !isNaN(a.actual));

        this.countryDataSNI = this.uqArray(this.countryData.filter(a => a.m_level == "subnational").map(a => a.indicator_id));
        this.countryDataNI = this.uqArray(this.countryData.filter(a => a.m_level == "national").map(a => a.indicator_id));
    }

    storeIndicatorScores = () => {
        // here, for each subnational, across all years, across all indicators
        // get the normal weighted scores
        let countryData = this.countryData;

        this.indicatorScores = countryData.map(a => {
            let filteredDataSet = countryData.filter(b => b.indicator_id == a.indicator_id);
            let yearsFiltered = this.uqArray(filteredDataSet.map(b => b.year));
            yearsFiltered.sort((x, y) => x > y ? 0 : -1);
            let baselineYear = yearsFiltered[0]; // take the earliest available year
            let baselineYearActuals = filteredDataSet.filter(b => b.year == baselineYear).map(b => b.actual);
            baselineYearActuals.sort((x, y) => x > y ? 0 : -1);
            let [min, max] = [baselineYearActuals[0], baselineYearActuals[baselineYearActuals.length-1]];
            
            a.is_baseline = a.year == baselineYear ? true : false;
            a.baselineMin = min;
            a.baselineMax = max;
            a.normal = a.is_binary
                ? a.desired_change
                    ? a.actual ? 100 : 0
                    : a.actual ? 0 : 100
                : a.desired_change
                    ? (max-min) ? ((a.actual-min)/(max-min))*100 : ((max || min) ? 100 : 0)
                    : (min-max) ? ((a.actual-max)/(min-max))*100 : ((max || min) ? 0 : 100)
                
            let indWtObj = this.indicatorWeights.find(b => b.indicator_id == a.indicator_id);
            let indTotalWtList = this.indicatorWeights.filter(b => b.category_id == a.category_id);

            // if its a national indicator it picks from grazing (since mixed and grazing have same values)
            // if co-indicator sum of weight is zero, then the proportion is zero
            let indProportion = a["sn_ps_type"] == "Mixed" 
                ? (this.sumArray(indTotalWtList.map(b => b.indicator_weight_mixed)) ? (indWtObj.indicator_weight_mixed)/(this.sumArray(indTotalWtList.map(b => b.indicator_weight_mixed))) : 0)
                : (this.sumArray(indTotalWtList.map(b => b.indicator_weight_grazing)) ? (indWtObj.indicator_weight_grazing)/(this.sumArray(indTotalWtList.map(b => b.indicator_weight_grazing))) : 0);
            
            a.indicator_wt_fraction = indProportion;
            a.indicator_nw = a.normal * indProportion;
            return a
        });

    }

    storeCategoryScores = () => {
        let indicatorScores = this.indicatorScores;
        // if subnational id is same as this.country.id, then it is a national indicator
        let categoryIds = this.uqArray(indicatorScores.map(a => a.category_id));

        let initialCategoryArray = categoryIds.map(a => {
            // get the average of each category (for each subnational for each year);
            // use this array later to normalize all values, by baseline
            let catObj = this.categories.find(b => b.category_id == a);
            let filteredDataSet = indicatorScores.filter(b => b.category_id == a);
            let subnationalIds = this.uqArray(filteredDataSet.map(b => b.subnational_id));
            
            let snYearlyAverages = subnationalIds.map(b => {
                let snFilteredDataset = filteredDataSet.filter(c => c.subnational_id == b && c.category_id == a);
                let yearsAvailable = this.uqArray(snFilteredDataset?.map(c => c.year) || []);
                if(yearsAvailable.length){
                    yearsAvailable.sort((x, y) => x > y ? 0 : -1);
                    let [baselineYear, recentYear] = [yearsAvailable[0], yearsAvailable[yearsAvailable.length-1]];
                    let snYearlyArr = yearsAvailable.map(c => {
                        let innerResult = {
                            "m_level": b == this.country.id ? "national" : "subnational",
                            "subnational_id": b,
                            "year": c,
                            "is_baseline": c == baselineYear ? true : false,
                            "category_id": a,
                            "sub_dimension_id": catObj.sub_dimension_id,
                            "dimension_id": catObj.dimension_id
                        };
                        let indScoresArr = snFilteredDataset.filter(d => d.year == c).map(d => d.indicator_nw);
                        let averageScore = this.sumArray(indScoresArr)/(indScoresArr.length || 1);
                        innerResult["category_avg"] = averageScore; // average of normalized and weighted indicators
                        innerResult["sn_ps_type"] = this.subNationals.find(d => d.subnational_id == b)?.production_system || null;
                        return innerResult
                    })
                    return snYearlyArr
                }
            });
            return snYearlyAverages;
        }).flat(Infinity);

        let baselineCategoryArr = initialCategoryArray.filter(a => a.is_baseline);

        this.categoryScores = initialCategoryArray.map(a => {
            let baseline = baselineCategoryArr.filter(b => b.category_id == a.category_id);
            let baselineCategoryAverages = baseline.map(b => b.category_avg);
            baselineCategoryAverages.sort((x, y) => x > y ? 0 : -1);
            let [min, max] = [baselineCategoryAverages[0], baselineCategoryAverages[baselineCategoryAverages.length-1]];  
            a.baselineMin = min;
            a.baselineMax = max;          
            a.normal = max-min ? ((a.category_avg-min)/(max-min)) * 100 : (max || min ? 100 : 0);
            let catWtObj = this.categoryWeights.find(b => b.category_id == a.category_id);
            let catTotalWtList = this.categoryWeights.filter(b => b.sub_dimension_id == a.sub_dimension_id);
            // if its a national indicator it picks from grazing (since mixed and grazing have same values)
            // if co-category sum of weight is zero, then the proportion is zero
            let catProportion = a["sn_ps_type"] == "Mixed"
                ? (this.sumArray(catTotalWtList.map(b => b.category_weight_mixed)) ? (catWtObj.category_weight_mixed)/(this.sumArray(catTotalWtList.map(b => b.category_weight_mixed))) : 0)
                : (this.sumArray(catTotalWtList.map(b => b.category_weight_grazing)) ? (catWtObj.category_weight_grazing)/(this.sumArray(catTotalWtList.map(b => b.category_weight_grazing))) : 0);
            
            a.category_wt_fraction = catProportion;
            a.category_nw = a.normal * catProportion;
            return a
        });

    }

    storeSubDimensionScores = () => {
        let categoryScores = this.categoryScores;
        let subDimensionIds = this.uqArray(categoryScores.map(a => a.sub_dimension_id));

        let initialSubDimensionArray = subDimensionIds.map(a => {
            let subDimObj = this.subDimensions.find(b => b.sub_dimension_id == a);
            let filteredDataSet = categoryScores.filter(b => b.sub_dimension_id == a);
            let subnationalIds = this.uqArray(filteredDataSet.map(b => b.subnational_id));
            let snYearlyAverages = subnationalIds.map(b => {
                let snFilteredDataset = filteredDataSet.filter(c => c.subnational_id == b && c.sub_dimension_id == a);
                let yearsAvailable = this.uqArray(snFilteredDataset?.map(c => c.year) || []);
                if(yearsAvailable.length){
                    yearsAvailable.sort((x, y) => x > y ? 0 : -1);
                    let [baselineYear, recentYear] = [yearsAvailable[0], yearsAvailable[yearsAvailable.length-1]];
                    let snYearlyArr = yearsAvailable.map(c => {
                        let innerResult = {
                            "m_level": b == this.country.id ? "national" : "subnational",
                            "subnational_id": b,
                            "year": c,
                            "is_baseline": c == baselineYear ? true : false,
                            "sub_dimension_id": a,
                            "dimension_id": subDimObj.dimension_id
                        };
                        let catScoresArr = snFilteredDataset.filter(d => d.year == c).map(d => d.category_nw);
                        let averageScore = this.sumArray(catScoresArr)/(catScoresArr.length || 1);
                        innerResult["sub_dimension_avg"] = averageScore; // average of normalized and weighted indicators
                        innerResult["sn_ps_type"] = this.subNationals.find(d => d.subnational_id == b)?.production_system || null;
                        return innerResult
                    })
                    return snYearlyArr
                }
            });
            return snYearlyAverages;
        }).flat(Infinity);

        let baselineSubDimensionArr = initialSubDimensionArray.filter(a => a.is_baseline);

        this.subDimensionScores = initialSubDimensionArray.map(a => {
            let baseline = baselineSubDimensionArr.filter(b => b.sub_dimension_id == a.sub_dimension_id);
            let baselineSubDimensionAverages = baseline.map(b => b.sub_dimension_avg);
            baselineSubDimensionAverages.sort((x, y) => x > y ? 0 : -1);
            let [min, max] = [baselineSubDimensionAverages[0], baselineSubDimensionAverages[baselineSubDimensionAverages.length-1]];  
            a.baselineMin = min;
            a.baselineMax = max;          
            a.normal = max-min ? ((a.sub_dimension_avg-min)/(max-min)) * 100 : (max || min ? 100 : 0);
            let subDimWtObj = this.subDimensionWeights.find(b => b.sub_dimension_id == a.sub_dimension_id);
            let subDimTotalWtList = this.subDimensionWeights.filter(b => b.dimension_id == a.dimension_id);
            // if its a national indicator it picks from grazing (since mixed and grazing have same values)
            // if co-category sum of weight is zero, then the proportion is zero
            let subDimProportion = a["sn_ps_type"] == "Mixed"
                ? (this.sumArray(subDimTotalWtList.map(b => b.sub_dimension_weight_mixed)) ? (subDimWtObj.sub_dimension_weight_mixed)/(this.sumArray(subDimTotalWtList.map(b => b.sub_dimension_weight_mixed))) : 0)
                : (this.sumArray(subDimTotalWtList.map(b => b.sub_dimension_weight_grazing)) ? (subDimWtObj.sub_dimension_weight_grazing)/(this.sumArray(subDimTotalWtList.map(b => b.sub_dimension_weight_grazing))) : 0);
            
            a.sub_dimension_wt_fraction = subDimProportion;
            a.sub_dimension_nw = a.normal * subDimProportion;
            return a
        });

    }

    storeDimensionScores = () => {
        let subDimensionScores = this.subDimensionScores;
        let dimensionIds = this.uqArray(subDimensionScores.map(a => a.dimension_id));

        let initialDimensionArray = dimensionIds.map(a => {
            let filteredDataSet = subDimensionScores.filter(b => b.dimension_id == a);
            let subnationalIds = this.uqArray(filteredDataSet.map(b => b.subnational_id));
            let snYearlyAverages = subnationalIds.map(b => {
                let snFilteredDataset = filteredDataSet.filter(c => c.subnational_id == b && c.dimension_id == a);
                let yearsAvailable = this.uqArray(snFilteredDataset?.map(c => c.year) || []);
                if(yearsAvailable.length){
                    yearsAvailable.sort((x, y) => x > y ? 0 : -1);
                    let [baselineYear, recentYear] = [yearsAvailable[0], yearsAvailable[yearsAvailable.length-1]];
                    let snYearlyArr = yearsAvailable.map(c => {
                        let innerResult = {
                            "m_level": b == this.country.id ? "national" : "subnational",
                            "subnational_id": b,
                            "year": c,
                            "is_baseline": c == baselineYear ? true : false,
                            "dimension_id": a
                        };
                        let subDimScoreArr = snFilteredDataset.filter(d => d.year == c).map(d => d.sub_dimension_nw);
                        let averageScore = this.sumArray(subDimScoreArr)/(subDimScoreArr.length || 1);
                        innerResult["dimension_avg"] = averageScore; // average of normalized and weighted indicators
                        innerResult["sn_ps_type"] = this.subNationals.find(d => d.subnational_id == b)?.production_system || null;
                        return innerResult
                    })
                    return snYearlyArr
                }
            });
            return snYearlyAverages;
        }).flat(Infinity);

        let baselineDimensionArr = initialDimensionArray.filter(a => a.is_baseline);

        this.dimensionScores = initialDimensionArray.map(a => {
            let baseline = baselineDimensionArr.filter(b => b.dimension_id == a.dimension_id);
            let baselineDimensionAverages = baseline.map(b => b.dimension_avg);
            baselineDimensionAverages.sort((x, y) => x > y ? 0 : -1);
            let [min, max] = [baselineDimensionAverages[0], baselineDimensionAverages[baselineDimensionAverages.length-1]];  
            a.baselineMin = min;
            a.baselineMax = max;          
            a.normal = max-min ? ((a.dimension_avg-min)/(max-min)) * 100 : (max || min ? 100 : 0);
            let dimWtObj = this.dimensionWeights.find(b => b.dimension_id == a.dimension_id);
            let dimTotalWtList = this.dimensionWeights;
            // if its a national indicator it picks from grazing (since mixed and grazing have same values)
            // if co-category sum of weight is zero, then the proportion is zero
            let dimProportion = a["sn_ps_type"] == "Mixed"
                ? (this.sumArray(dimTotalWtList.map(b => b.dimension_weight_mixed)) ? (dimWtObj.dimension_weight_mixed)/(this.sumArray(dimTotalWtList.map(b => b.dimension_weight_mixed))) : 0)
                : (this.sumArray(dimTotalWtList.map(b => b.dimension_weight_grazing)) ? (dimWtObj.dimension_weight_grazing)/(this.sumArray(dimTotalWtList.map(b => b.dimension_weight_grazing))) : 0);
            
            a.dimension_wt_fraction = dimProportion;
            a.dimension_nw = a.normal * dimProportion;
            return a
        });
    }

    storeLocationScores = () => {
        let dimensionScores = this.dimensionScores;
        let subnationalIds = this.uqArray(dimensionScores.map(a => a.subnational_id));
        // here only average the dimension scores, no further normalization required

        this.locationScores = subnationalIds.map(a => {
            let filteredDataSet = dimensionScores.filter(b => b.subnational_id == a);
            let yearsAvailable = this.uqArray(filteredDataSet.map(b => b.year));
            if(yearsAvailable.length){
                yearsAvailable.sort((x, y) => x > y ? 0 : -1);
                let [baselineYear, recentYear] = [yearsAvailable[0], yearsAvailable[yearsAvailable.length-1]];
                let snYearlyArr = yearsAvailable.map(c => {
                    let innerResult = {
                        "m_level": a == this.country.id ? "national" : "subnational",
                        "subnational_id": a,
                        "year": c,
                        "is_baseline": c == baselineYear ? true : false,
                    };
                    let subDimScoreArr = filteredDataSet.filter(d => d.year == c).map(d => d.dimension_nw);
                    let averageScore = this.sumArray(subDimScoreArr)/(subDimScoreArr.length || 1);
                    innerResult["location_avg"] = averageScore; // average of normalized and weighted indicators
                    innerResult["sn_ps_type"] = this.subNationals.find(d => d.subnational_id == a)?.production_system || null;
                    return innerResult
                })
                return snYearlyArr
            }
        }).flat(Infinity);
    }

    renderMapData = (dataLevel, dataLevelId) => {
        if(dataLevel == "country"){
            let calculatedMapData = this.locationScores;
            this.renderMapTabData(calculatedMapData, "location_avg");
        } else if(dataLevel == "dimension"){
            let calculatedMapData = this.dimensionScores.filter(a => a.dimension_id == dataLevelId);
            this.renderMapTabData(calculatedMapData, "dimension_nw");
        } else if(dataLevel == "subdimension"){
            let calculatedMapData = this.subDimensionScores.filter(a => a.sub_dimension_id == dataLevelId);
            this.renderMapTabData(calculatedMapData, "sub_dimension_nw");
        } else if(dataLevel == "category"){
            let calculatedMapData = this.categoryScores.filter(a => a.category_id == dataLevelId);
            this.renderMapTabData(calculatedMapData, "category_nw");
        }
    }

    renderMapTabData = (calculatedMapData, scoreColumn) => {
        let allYears = this.uqArray(calculatedMapData.map(a => a.year));
        allYears.sort((x, y) => x > y ? -1 : 0); // descending
        let latestYear = allYears[0];

        let subnationalData = this.selectedPsSnIdsForMap.length
            ? calculatedMapData.filter(a => a.m_level == "subnational" && a.year == latestYear && this.selectedPsSnIdsForMap.includes(a.subnational_id))
            : calculatedMapData.filter(a => a.m_level == "subnational" && a.year == latestYear);
        let nationalData = calculatedMapData.filter(a => a.m_level == "national" && a.year == latestYear);
        
        let snInLatestYear = this.uqArray(subnationalData.map(a => a.subnational_id));
        let subnationalScoreArr = subnationalData.map(a => a[scoreColumn]);
        let subNationalScore = this.sumArray(subnationalScoreArr)/(subnationalScoreArr.length || 1);
        let nationalScoreArr = nationalData.map(a => a[scoreColumn]);
        let nationalScore = this.sumArray(nationalScoreArr)/(nationalScoreArr.length || 1);
        let psVal = this.num(this.filterPS.val())
        let countryScore =  psVal ?  subNationalScore : subNationalScore + nationalScore  // use this for country map

        // MAP object - Country
        this.continentGeoData.features.forEach(a => {
            delete a.properties?.score;
            delete a.properties?.color;
            if (a.properties.country_id == this.country.id) {
                a.properties.score = countryScore;
                a.properties.color = "green";
            }
        });

        // MAP object - Disaggregated by subnationals
        this.countryGeoData.features.forEach(a => {
            delete a.properties?.score;
            if (snInLatestYear.includes(Number(a.properties.subnational_level_id))){
                let snScoreObj = subnationalData.find(b => b.subnational_id == a.properties.subnational_level_id);
                a.properties.score = snScoreObj.hasOwnProperty(scoreColumn) ? snScoreObj[scoreColumn] : null;
            }
        });

        let bounds = L.geoJson(this.countryGeoData, {}).getBounds();
        this.mapViewChosen = $("input[type='radio'][name='dashboard-map-view']:checked").val();
        $(`input[type='radio'][value='${this.mapViewChosen}']`).prop("checked", true);
        this.mapViewToggle.on("change", () => {
            this.mapViewChosen = $("input[type='radio'][name='dashboard-map-view']:checked").val();
            if (this.mapViewChosen == "country") {
                this.plotMap(this.continentGeoData, "country");
                this.mapLegendContainer.hide();
            } else if (this.mapViewChosen == "sn") {
                this.plotMap(this.countryGeoData, "sn")
                this.mapLegendContainer.show();
                let selectedSNValues = this.filterSN.selectpicker("val").map(a => this.num(a));
                if(selectedSNValues.length == 1) d3.select(`path#sn${selectedSNValues[0]}`).attr("stroke-width", "2px").attr("fill-opacity", 1);
                if(this.clickedSNId) d3.select(`path#sn${this.clickedSNId}`).attr("stroke-width", "2px").attr("fill-opacity", 1);
            };
            this.map.fitBounds(bounds);
        });
        this.mapViewToggle.trigger("change");

    }

    showLevel1 = () => {
        // Parent -> Country, Children -> Dimensions
        this.currentDataLevel = "country";
        this.dashboardParent.empty();
        this.dashboardChildren.empty();

        // MAP
        this.renderMapData("country", null);
        
        // BREADCRUMB - Arrange template
        this.dashboardLevelTitle.empty().html(`Dimensions (${this.dimensions.length})`);
        this.dashboardBreadcrumb.empty().html(`<a id="x-level" class="d-breadcrumb">Dimensions</a>`);

        // CHILDREN
        let childrenData = this.selectedPsSnIds.length 
            ? this.dimensionScores.filter(a => [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id)) 
            : this.dimensionScores; // sn filter applicable here
        let inputDimensionIds = this.uqArray(childrenData.map(a => a.dimension_id));
        // CHILDREN - Arrange data
        let children = this.dimensions.map(a => {
            let result = { "dimension_id": a.dimension_id };
            let isDimensionInForm = inputDimensionIds.includes(a.dimension_id);
            result["is_in_form"] = isDimensionInForm;
            if(isDimensionInForm){
                let filteredDataSet = childrenData.filter(b => b.dimension_id == a.dimension_id);
                let uqYears = this.uqArray(filteredDataSet.map(b => b.year));
                uqYears.sort((x, y) => x > y ? 0 : -1);
                let recentTwoYears = uqYears.slice(-2);

                let yearlyScores = uqYears.map(b => {
                    let yearFilteredData = filteredDataSet.filter(c => c.year == b);
                    let yearFilteredDataSubNat = yearFilteredData.filter(c => c.m_level == "subnational");
                    let yearFilteredDataNat = yearFilteredData.filter(c => c.m_level == "national");
                    let snInYear = this.uqArray(yearFilteredDataSubNat.map(c => c.subnational_id));
                    let subNatValueArr = yearFilteredDataSubNat.map(c => c.dimension_nw);
                    let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                    let natValueArr = yearFilteredDataNat.map(c => c.dimension_nw);
                    let natScore = this.sumArray(natValueArr);
                    let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                    return {"year": b, "score": score};
                });

                result["yearly_scores"] = yearlyScores;
                let recentChange = yearlyScores.find(b => b.year == recentTwoYears[1]).score - yearlyScores.find(b => b.year == recentTwoYears[0]).score;
                result["latest_score"] = yearlyScores.find(b => b.year == recentTwoYears[1]).score;
                result["change"] = recentChange > 0 ? "Positive" : (recentChange < 0 ? "Negative" : "No Change");

                // subdimension summary
                let childSubDimensionData = this.subDimensionScores.filter(b => b.dimension_id == a.dimension_id);
                let uqAvailableSubDimensionIds = this.uqArray(childSubDimensionData.map(b => b.sub_dimension_id));
                let subDimensionChangesCheck = uqAvailableSubDimensionIds.map(b => {
                    let sdFilteredDataSet = childSubDimensionData.filter(c => c.sub_dimension_id == b)
                    let sdYears = this.uqArray(sdFilteredDataSet.map(c => c.year));
                    sdYears.sort((x, y) => x > y ? 0 : -1);
                    let recentTwoYears = sdYears.slice(-2);
                    let r2SdScores = recentTwoYears.map(c => {
                        let yearFilteredData = sdFilteredDataSet.filter(d => d.year == c);
                        let yearFilteredDataSubNat = yearFilteredData.filter(d => d.m_level == "subnational");
                        let yearFilteredDataNat = yearFilteredData.filter(d => d.m_level == "national");
                        let snInYear = this.uqArray(yearFilteredDataSubNat.map(d => d.subnational_id));
                        let subNatValueArr = yearFilteredDataSubNat.map(d => d.sub_dimension_nw);
                        let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                        let natValueArr = yearFilteredDataNat.map(d => d.sub_dimension_nw);
                        let natScore = this.sumArray(natValueArr);
                        let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                        return score;
                    });
                    let r2SdChange = r2SdScores[1] - r2SdScores[0];
                    return r2SdChange > 0 ? "Positive" : (r2SdChange < 0 ? "Negative" : "No Change");
                })

                let subDimensionChanges = ["Positive", "Negative", "No Change"].map(b => {
                    return { "change": b, "count": subDimensionChangesCheck.filter(c => c === b).length }
                });
                result["sub_changes"] = subDimensionChanges;
            }
            return result;
            
        });
        
        // PARENT
        let parentData = this.selectedPsSnIds.length 
            ? this.locationScores.filter(a => [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.locationScores; // sn filter applicable here
        let uqYears = this.uqArray(parentData.map(a => a.year));
        uqYears.sort((x, y) => x > y ? 0 : -1);
        // PARENT - Arrange Data
        let parentYearlyScores = uqYears.map(a => {
            let filteredDataSet = parentData.filter(b => b.year == a);
            let filteredDataSetSubNat = filteredDataSet.filter(b => b.m_level == "subnational");
            let filteredDataSetNat = filteredDataSet.filter(b => b.m_level == "national");
            let snInYear = this.uqArray(filteredDataSetSubNat.map(b => b.subnational_id));
            let subNatValueArr = filteredDataSetSubNat.map(b => b.location_avg);
            let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
            let natValueArr = filteredDataSetNat.map(b => b.location_avg);
            let natScore = this.sumArray(natValueArr);
            let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
            return {"year": a, "score": score};
        });
        let recentTwoYears = uqYears.slice(-2);
        let parentCurrentScore = parentYearlyScores.find(c => c.year == recentTwoYears[1]).score
        let parentRecentChange = parentCurrentScore - parentYearlyScores.find(c => c.year == recentTwoYears[0]).score;
        let childChanges = `<th>Dimensions</th>` + ["Positive", "Negative", "No Change"]
            .map(b => { return { "change": b, "count": children.filter(c => c.change === b).length } })
            .map(a => {
                let cellArrow = a.change == "Positive"
                    ? `<i class="fa fa-arrow-up text-success"></i>`
                    : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                return `<th>${a.count}&nbsp;${cellArrow} </th>`
            }).join("\n");
        let parent = {
            "current_score": parentCurrentScore,
            "yearly_scores": parentYearlyScores,
            "change": parentRecentChange > 0 ? "Positive" : (parentRecentChange < 0 ? "Negative" : "No Change"),
            "child_changes": childChanges,
        };
        // PARENT - Prepare template
        let parentHtml = `<ul style="padding-left:0;">
            <li class="list-group-item shadow mb-2 border-0" id="country${this.country.id}" style="background-color: #A4C7B399;">
                <span class="heading_text" id="label-location">
                    ${this.clickedSNName ? `${this.country.snLevel}: ${this.clickedSNName}` :  `Country: ${this.country.name}`}
                </span>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-country${this.country.id}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-country${this.country.id}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-country${this.country.id}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered w-100">
                            <tbody><tr id="children-country${this.country.id}" class="text-center"></tr></tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="expand-graph-country${this.country.id}">
                    <div id="chart-line-country${this.country.id}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>
        </ul>`;
        // PARENT - Render data to template
        this.dashboardParent.empty().html(parentHtml);
        let trendLineColor = parent.change == "Positive" ? "green" : (parent.change == "Negative" ? "red" : "grey");
        let recentChangeArrow = parent.change == "Positive"
            ? `<i class="fa fa-arrow-up"></i>`
            : (parent.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
        $(`div#current-country${this.country.id}`).html(`<h4 style="color:${trendLineColor}">${Number(parent.current_score).toFixed(4)}&nbsp;${recentChangeArrow}</h4>`)
        $(`tr#children-country${this.country.id}`).html(parent.child_changes);
        this.plotTrendLine(parent.yearly_scores, `chart-sparkline-country${this.country.id}`, "sparkline", "Score", "normal", "grey", "score", null);
        this.plotTrendLine(parent.yearly_scores, `chart-line-country${this.country.id}`, "line", "Score", "normal", "grey", "score", null);

        // CHILDREN - Prepare template
        let childrenHtml = this.dimensions.map(d => {
            let name = this.dimensions.find(a => a.dimension_id == d.dimension_id).dimension_name;
            let isDimensionInForm = inputDimensionIds.includes(d.dimension_id);
            return isDimensionInForm
                ? `<li class="list-group-item shadow mb-2 border-0" id="d${d.dimension_id}">
                <div>
                    <img src="${base_url}/include/dashboard/images/present.png" class="pr-2" height="12px" title="Present">
                    <span class="heading_text">${name}</span>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-d${d.dimension_id}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-d${d.dimension_id}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-d${d.dimension_id}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                       <div class="table-responsive">
                       <table class="table table-sm table-bordered w-100">
                       <tbody><tr id="children-d${d.dimension_id}" class="text-center"></tr></tbody>
                   </table></div>
                    </div>
                    <div class="col-sm-12 col-md-1 col-lg-1">
                        <a id="d${d.dimension_id}-next" class="d-next" data-dim-id="${d.dimension_id}"> 
                            <img class=""  src="${base_url}/include/dashboard/images/Arrow_Right.svg" />
                        </a>
                    </div>
                </div>
                <div class="collapse" id="expand-graph-d${d.dimension_id}">
                    <div id="chart-line-d${d.dimension_id}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>`
                : `<li class="list-group-item shadow mb-2 border-0">
                <span>
                    <img src="${base_url}/include/dashboard/images/absent.png" class="pr-2" height="12px" title="Absent">
                    <span class="heading_text">${name}</span>
                </span>
            </li>`;
        }).join("\n");
        this.dashboardChildren.empty().html(`<ul style="padding-left:0;">${childrenHtml}</ul>`);
        // CHILDREN - Render data to template
        children.forEach(d => {
            let isDimensionInForm = inputDimensionIds.includes(d.dimension_id);
            if (isDimensionInForm) {
                let trendLineColor = d.change == "Positive" ? "green" : (d.change == "Negative" ? "red" : "grey");
                this.plotTrendLine(d.yearly_scores, `chart-sparkline-d${d.dimension_id}`, "sparkline", "Score", "normal", "grey", "score", null);
                this.plotTrendLine(d.yearly_scores, `chart-line-d${d.dimension_id}`, "line", "Score", "normal", "grey", "score", null);
                let recentChangeArrow = d.change == "Positive"
                    ? `<i class="fa fa-arrow-up"></i>`
                    : (d.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
                $(`div#current-d${d.dimension_id}`).html(`<h6 style="color: ${trendLineColor};">${Number(d.latest_score).toFixed(4)}&nbsp;${recentChangeArrow}</h6>`);
                let sdSummary = `<th>Sub-Dimensions</th>` + d.sub_changes.map(a => {
                    let cellArrow = a.change == "Positive"
                        ? `<i class="fa fa-arrow-up text-success"></i>`
                        : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                    return `<th>${a.count}&nbsp;${cellArrow} </th>`
                }).join("\n");
                $(`tr#children-d${d.dimension_id}`).html(sdSummary);
            }
        });

        // BREADCRUMB - Bind Events
        $("a.d-next").on("click", e => { this.chosenDimensionId = $(e.currentTarget).data("dim-id"); this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel2(); });
        $("a#x-level").on("click", () => { this.chosenDimensionId = null; this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel1();});
    }

    showLevel2 = () => {
        // Parent -> Dimension, Children -> Sub-Dimensions
        this.currentDataLevel = "dimension";
        this.dashboardParent.empty();
        this.dashboardChildren.empty();

        // MAP
        this.renderMapData("dimension", this.chosenDimensionId);
        
        // BREADCRUMB - Arrange
        let dimName = this.dimensions.find(a => a.dimension_id == this.chosenDimensionId).dimension_name;
        this.dashboardLevelTitle.empty().html(`Sub-Dimensions (${this.subDimensions.filter(a => a.dimension_id == this.chosenDimensionId).length})`);
        this.dashboardBreadcrumb.empty().html(`
            <a id="x-level" class="d-breadcrumb">Dimensions</a>&nbsp;/&nbsp;
            <a id="d-level" class="d-breadcrumb" data-dim-id="${this.chosenDimensionId}">${dimName}</a>
        `);

        // CHILDREN
        let childrenData = this.selectedPsSnIds.length
            ? this.subDimensionScores.filter(a => a.dimension_id == this.chosenDimensionId && [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.subDimensionScores.filter(a => a.dimension_id == this.chosenDimensionId); // sn filter applicable here
        let inputSubDimensionIds = this.uqArray(childrenData.map(a => a.sub_dimension_id));
        // CHILDREN - Arrange data
        let children = this.subDimensions.filter(a => a.dimension_id == this.chosenDimensionId).map(a => {
            let result = { "dimension_id": a.dimension_id, "sub_dimension_id": a.sub_dimension_id };
            let isSubDimensionInForm = inputSubDimensionIds.includes(a.sub_dimension_id);
            result["is_in_form"] = isSubDimensionInForm;
            if(isSubDimensionInForm){
                let filteredDataSet = childrenData.filter(b => b.sub_dimension_id == a.sub_dimension_id);
                let uqYears = this.uqArray(filteredDataSet.map(b => b.year));
                uqYears.sort((x, y) => x > y ? 0 : -1);
                let recentTwoYears = uqYears.slice(-2);

                let yearlyScores = uqYears.map(b => {
                    let yearFilteredData = filteredDataSet.filter(c => c.year == b);
                    let yearFilteredDataSubNat = yearFilteredData.filter(c => c.m_level == "subnational");
                    let yearFilteredDataNat = yearFilteredData.filter(c => c.m_level == "national");
                    let snInYear = this.uqArray(yearFilteredDataSubNat.map(c => c.subnational_id));
                    let subNatValueArr = yearFilteredDataSubNat.map(c => c.sub_dimension_nw);
                    let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                    let natValueArr = yearFilteredDataNat.map(c => c.sub_dimension_nw);
                    let natScore = this.sumArray(natValueArr);
                    let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                    return {"year": b, "score": score};
                });

                result["yearly_scores"] = yearlyScores;
                let recentChange = yearlyScores.find(b => b.year == recentTwoYears[1]).score - yearlyScores.find(b => b.year == recentTwoYears[0]).score;
                result["latest_score"] = yearlyScores.find(b => b.year == recentTwoYears[1]).score;
                result["change"] = recentChange > 0 ? "Positive" : (recentChange < 0 ? "Negative" : "No Change");

                // category summary
                let childCategoryData = this.categoryScores.filter(b => b.dimension_id == a.dimension_id && b.sub_dimension_id == a.sub_dimension_id);
                let uqAvailableCategoryIds = this.uqArray(childCategoryData.map(b => b.category_id));
                let categoryChangesCheck = uqAvailableCategoryIds.map(b => {
                    let catFilteredSet = childCategoryData.filter(c => c.category_id == b)
                    let sdYears = this.uqArray(catFilteredSet.map(c => c.year));
                    sdYears.sort((x, y) => x > y ? 0 : -1);
                    let recentTwoYears = sdYears.slice(-2);
                    let r2CatScores = recentTwoYears.map(c => {
                        let yearFilteredData = catFilteredSet.filter(d => d.year == c);
                        let yearFilteredDataSubNat = yearFilteredData.filter(d => d.m_level == "subnational");
                        let yearFilteredDataNat = yearFilteredData.filter(d => d.m_level == "national");
                        let snInYear = this.uqArray(yearFilteredDataSubNat.map(d => d.subnational_id));
                        let subNatValueArr = yearFilteredDataSubNat.map(d => d.category_nw);
                        let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                        let natValueArr = yearFilteredDataNat.map(d => d.category_nw);
                        let natScore = this.sumArray(natValueArr);
                        let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                        return score;
                    });
                    let r2CatChange = r2CatScores[1] - r2CatScores[0];
                    return r2CatChange > 0 ? "Positive" : (r2CatChange < 0 ? "Negative" : "No Change");
                })

                let categoryChanges = ["Positive", "Negative", "No Change"].map(b => {
                    return { "change": b, "count": categoryChangesCheck.filter(c => c === b).length }
                });
                result["sub_changes"] = categoryChanges;
            }
            return result;
            
        });
        
        // PARENT
        let parentData = this.selectedPsSnIds.length
            ? this.dimensionScores.filter(a => a.dimension_id == this.chosenDimensionId && [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.dimensionScores.filter(a => a.dimension_id == this.chosenDimensionId); // sn filter applicable here
        let uqYears = this.uqArray(parentData.map(a => a.year));
        uqYears.sort((x, y) => x > y ? 0 : -1);
        // PARENT - Arrange data
        let parentYearlyScores = uqYears.map(a => {
            let filteredDataSet = parentData.filter(b => b.year == a);
            let filteredDataSetSubNat = filteredDataSet.filter(b => b.m_level == "subnational");
            let filteredDataSetNat = filteredDataSet.filter(b => b.m_level == "national");
            let snInYear = this.uqArray(filteredDataSetSubNat.map(b => b.subnational_id));
            let subNatValueArr = filteredDataSetSubNat.map(b => b.dimension_nw);
            let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
            let natValueArr = filteredDataSetNat.map(b => b.dimension_nw);
            let natScore = this.sumArray(natValueArr);
            let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
            return {"year": a, "score": score};
        });
        let recentTwoYears = uqYears.slice(-2);
        let parentCurrentScore = parentYearlyScores.find(c => c.year == recentTwoYears[1]).score
        let parentRecentChange = parentCurrentScore - parentYearlyScores.find(c => c.year == recentTwoYears[0]).score;
        let childChanges = `<th>Dimensions</th>` + ["Positive", "Negative", "No Change"]
            .map(b => { return { "change": b, "count": children.filter(c => c.change === b).length } })
            .map(a => {
                let cellArrow = a.change == "Positive"
                    ? `<i class="fa fa-arrow-up text-success"></i>`
                    : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                return `<th>${a.count}&nbsp;${cellArrow} </th>`
            }).join("\n");
        let parent = {
            "current_score": parentCurrentScore,
            "yearly_scores": parentYearlyScores,
            "change": parentRecentChange > 0 ? "Positive" : (parentRecentChange < 0 ? "Negative" : "No Change"),
            "child_changes": childChanges,
        };
        // PARENT - Prepare template
        let parentHtml = `<ul style="padding-left:0;">
            <li class="list-group-item shadow mb-2 border-0" id="d${this.chosenDimensionId}" style="background-color: #A4C7B399;">
                <span class="heading_text">
                    DIMENSION: <b>${dimName}</b>
                </span>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-d${this.chosenDimensionId}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-d${this.chosenDimensionId}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-d${this.chosenDimensionId}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered w-100">
                        <tbody><tr id="children-d${this.chosenDimensionId}" class="text-center"></tr></tbody>
                    </table>
                    </div>
                      
                    </div>
                </div>
                <div class="collapse" id="expand-graph-d${this.chosenDimensionId}">
                    <div id="chart-line-d${this.chosenDimensionId}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>
        </ul>`;
        this.dashboardParent.empty().html(parentHtml);
        // PARENT - Render data to template
        let trendLineColor = parent.change == "Positive" ? "green" : (parent.change == "Negative" ? "red" : "grey");
        let recentChangeArrow = parent.change == "Positive"
            ? `<i class="fa fa-arrow-up"></i>`
            : (parent.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
        $(`div#current-d${this.chosenDimensionId}`).html(`<h4 style="color:${trendLineColor}">${Number(parent.current_score).toFixed(4)}&nbsp;${recentChangeArrow}</h4>`)
        $(`tr#children-d${this.chosenDimensionId}`).html(parent.child_changes);
        this.plotTrendLine(parent.yearly_scores, `chart-sparkline-d${this.chosenDimensionId}`, "sparkline", "Score", "normal", "grey", "score", null);
        this.plotTrendLine(parent.yearly_scores, `chart-line-d${this.chosenDimensionId}`, "line", "Score", "normal", "grey", "score", null);

        // CHILDREN - Prepare template
        let childrenHtml = this.subDimensions.filter(a => a.dimension_id == this.chosenDimensionId).map(s => {
            let name = this.subDimensions.find(a => a.sub_dimension_id == s.sub_dimension_id).sub_dimension_name;
            let isSubDimensionInForm = inputSubDimensionIds.includes(s.sub_dimension_id);
            return isSubDimensionInForm
                ? `<li class="list-group-item shadow mb-2 border-0" id="s${s.sub_dimension_id}">
                <div>
                    <img src="${base_url}/include/dashboard/images/present.png" class="pr-2" height="12px" title="Present">
                    <span class="heading_text">${name}</span>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-s${s.sub_dimension_id}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-s${s.sub_dimension_id}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-s${s.sub_dimension_id}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered w-100">
                            <tbody><tr id="children-s${s.sub_dimension_id}" class="text-center"></tr></tbody>
                        </table>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-1 col-lg-1">
                        <a id="s${s.sub_dimension_id}-next" class="s-next" data-subdim-id="${s.sub_dimension_id}"> 
                            <img class=""  src="${base_url}/include/dashboard/images/Arrow_Right.svg" />
                        </a>
                    </div>
                </div>
                <div class="collapse" id="expand-graph-s${s.sub_dimension_id}">
                    <div id="chart-line-s${s.sub_dimension_id}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>`
                : `<li class="list-group-item shadow mb-2 border-0">
                <span>
                    <img src="${base_url}/include/dashboard/images/absent.png" class="pr-2" height="12px" title="Absent">
                    <span class="heading_text">${name}</span>
                </span>
            </li>`;
        }).join("\n");
        this.dashboardChildren.empty().html(`<ul style="padding-left:0;">${childrenHtml}</ul>`);
        // CHILDREN - Render data to template
        children.forEach(s => {
            let isSubDimensionInForm = inputSubDimensionIds.includes(s.sub_dimension_id);
            if (isSubDimensionInForm) {
                let trendLineColor = s.change == "Positive" ? "green" : (s.change == "Negative" ? "red" : "grey");
                this.plotTrendLine(s.yearly_scores, `chart-sparkline-s${s.sub_dimension_id}`, "sparkline", "Score", "normal", "grey", "score", null);
                this.plotTrendLine(s.yearly_scores, `chart-line-s${s.sub_dimension_id}`, "line", "Score", "normal", "grey", "score", null);
                let recentChangeArrow = s.change == "Positive"
                    ? `<i class="fa fa-arrow-up"></i>`
                    : (s.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
                $(`div#current-s${s.sub_dimension_id}`).html(`<h6 style="color: ${trendLineColor};">${Number(s.latest_score).toFixed(4)}&nbsp;${recentChangeArrow}</h6>`);
                let sdSummary = `<th>Categories</th>` + s.sub_changes.map(a => {
                    let cellArrow = a.change == "Positive"
                        ? `<i class="fa fa-arrow-up text-success"></i>`
                        : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                    return `<th>${a.count}&nbsp;${cellArrow} </th>`
                }).join("\n");
                $(`tr#children-s${s.sub_dimension_id}`).html(sdSummary);
            }
        });


        // BREADCRUMB - Bind Events
        $("a.s-next").on("click", e => { this.chosenSubDimensionId = $(e.currentTarget).data("subdim-id"); this.chosenIndicatorId = null; this.showLevel3(); });
        $("a#x-level").on("click", () => { this.chosenDimensionId = null; this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel1(); });
        $("a#d-level").on("click", () => { this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel2(); });
    }

    showLevel3 = () => {
        // Parent -> Sub-Dimension, Children -> Categories
        this.currentDataLevel = "subdimension";
        this.dashboardParent.empty();
        this.dashboardChildren.empty();

        // MAP
        this.renderMapData("subdimension", this.chosenSubDimensionId);
        
        // BREADCRUMB - Arrange
        let dimName = this.dimensions.find(a => a.dimension_id == this.chosenDimensionId).dimension_name;
        let subDimName = this.subDimensions.find(a => a.sub_dimension_id == this.chosenSubDimensionId).sub_dimension_name;
        this.dashboardLevelTitle.empty().html(`Categories (${this.categories.filter(a => a.sub_dimension_id == this.chosenSubDimensionId).length})`);
        this.dashboardBreadcrumb.empty().html(`
            <a id="x-level" class="d-breadcrumb">Dimensions</a>&nbsp;/&nbsp;
            <a id="d-level" class="d-breadcrumb" data-dim-id="${this.chosenDimensionId}">${dimName}</a>&nbsp;/&nbsp;
            <a id="s-level" class="d-breadcrumb" data-subdim-id="${this.chosenSubDimensionId}">${subDimName}</a>
        `);

        // CHILDREN
        let childrenData = this.selectedPsSnIds.length
            ? this.categoryScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId && [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.categoryScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId); // sn filter applicable here
        let inputCategoryIds = this.uqArray(childrenData.map(a => a.category_id));
        // CHILDREN - Arrange data
        let children = this.categories.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId).map(a => {
            let result = { "dimension_id": a.dimension_id, "sub_dimension_id": a.sub_dimension_id, "category_id": a.category_id};
            let isCategoryInForm = inputCategoryIds.includes(a.category_id);
            result["is_in_form"] = isCategoryInForm;
            if(isCategoryInForm){
                let filteredDataSet = childrenData.filter(b => b.category_id == a.category_id);
                let uqYears = this.uqArray(filteredDataSet.map(b => b.year));
                uqYears.sort((x, y) => x > y ? 0 : -1);
                let recentTwoYears = uqYears.slice(-2);

                let yearlyScores = uqYears.map(b => {
                    let yearFilteredData = filteredDataSet.filter(c => c.year == b);
                    let yearFilteredDataSubNat = yearFilteredData.filter(c => c.m_level == "subnational");
                    let yearFilteredDataNat = yearFilteredData.filter(c => c.m_level == "national");
                    let snInYear = this.uqArray(yearFilteredDataSubNat.map(c => c.subnational_id));
                    let subNatValueArr = yearFilteredDataSubNat.map(c => c.category_nw);
                    let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                    let natValueArr = yearFilteredDataNat.map(c => c.category_nw);
                    let natScore = this.sumArray(natValueArr);
                    let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                    return {"year": b, "score": score};
                });

                result["yearly_scores"] = yearlyScores;
                let recentChange = yearlyScores.find(b => b.year == recentTwoYears[1]).score - yearlyScores.find(b => b.year == recentTwoYears[0]).score;
                result["latest_score"] = yearlyScores.find(b => b.year == recentTwoYears[1]).score;
                result["change"] = recentChange > 0 ? "Positive" : (recentChange < 0 ? "Negative" : "No Change");

                // indicator summary
                let childIndicatorData = this.indicatorScores.filter(b => b.dimension_id == a.dimension_id && b.sub_dimension_id == a.sub_dimension_id && b.category_id == a.category_id);
                let uqAvailableIndicatorIds = this.uqArray(childIndicatorData.map(b => b.indicator_id));
                let indicatorChangesCheck = uqAvailableIndicatorIds.map(b => {
                    let indFilteredSet = childIndicatorData.filter(c => c.indicator_id == b)
                    let sdYears = this.uqArray(indFilteredSet.map(c => c.year));
                    sdYears.sort((x, y) => x > y ? 0 : -1);
                    let recentTwoYears = sdYears.slice(-2);
                    let r2IndScores = recentTwoYears.map(c => {
                        let yearFilteredData = indFilteredSet.filter(d => d.year == c);
                        let yearFilteredDataSubNat = yearFilteredData.filter(d => d.m_level == "subnational");
                        let yearFilteredDataNat = yearFilteredData.filter(d => d.m_level == "national");
                        let snInYear = this.uqArray(yearFilteredDataSubNat.map(d => d.subnational_id));
                        let subNatValueArr = yearFilteredDataSubNat.map(d => d.indicator_nw);
                        let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                        let natValueArr = yearFilteredDataNat.map(d => d.indicator_nw);
                        let natScore = this.sumArray(natValueArr);
                        let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                        return score;
                    });
                    let r2IndChange = r2IndScores[1] - r2IndScores[0];
                    return r2IndChange > 0 ? "Positive" : (r2IndChange < 0 ? "Negative" : "No Change");
                });
                let categoryChanges = ["Positive", "Negative", "No Change"].map(b => {
                    return { "change": b, "count": indicatorChangesCheck.filter(c => c === b).length }
                });
                result["sub_changes"] = categoryChanges;
            }
            return result;
            
        });
        
        // PARENT
        let parentData = this.selectedPsSnIds.length
            ? this.subDimensionScores.filter(a => 
                a.dimension_id == this.chosenDimensionId
                 && a.sub_dimension_id == this.chosenSubDimensionId 
                 && [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.subDimensionScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId); // sn filter applicable here
        let uqYears = this.uqArray(parentData.map(a => a.year));
        uqYears.sort((x, y) => x > y ? 0 : -1);
        // PARENT - Arrange data
        let parentYearlyScores = uqYears.map(a => {
            let filteredDataSet = parentData.filter(b => b.year == a);
            let filteredDataSetSubNat = filteredDataSet.filter(b => b.m_level == "subnational");
            let filteredDataSetNat = filteredDataSet.filter(b => b.m_level == "national");
            let snInYear = this.uqArray(filteredDataSetSubNat.map(b => b.subnational_id));
            let subNatValueArr = filteredDataSetSubNat.map(b => b.sub_dimension_nw);
            let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
            let natValueArr = filteredDataSetNat.map(b => b.sub_dimension_nw);
            let natScore = this.sumArray(natValueArr);
            let score = this.includeNationalScore ? subNatScore + natScore : subNatScore;// here exempt natScore if only one SN is selected or Production/Grazing 
            return {"year": a, "score": score};
        });
        let recentTwoYears = uqYears.slice(-2);
        let parentCurrentScore = parentYearlyScores.find(c => c.year == recentTwoYears[1]).score
        let parentRecentChange = parentCurrentScore - parentYearlyScores.find(c => c.year == recentTwoYears[0]).score;
        let childChanges = `<th>Dimensions</th>` + ["Positive", "Negative", "No Change"]
            .map(b => { return { "change": b, "count": children.filter(c => c.change === b).length } })
            .map(a => {
                let cellArrow = a.change == "Positive"
                    ? `<i class="fa fa-arrow-up text-success"></i>`
                    : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                return `<th>${a.count}&nbsp;${cellArrow} </th>`
            }).join("\n");
        let parent = {
            "current_score": parentCurrentScore,
            "yearly_scores": parentYearlyScores,
            "change": parentRecentChange > 0 ? "Positive" : (parentRecentChange < 0 ? "Negative" : "No Change"),
            "child_changes": childChanges,
        };
        // PARENT - Prepare template
        let parentHtml = `<ul style="padding-left:0;">
            <li class="list-group-item shadow mb-2 border-0" id="s${this.chosenSubDimensionId}" style="background-color: #A4C7B399;">
                <span class="heading_text">
                    SUB-DIMENSION: <b>${subDimName}</b>
                </span>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-s${this.chosenSubDimensionId}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-s${this.chosenSubDimensionId}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-s${this.chosenSubDimensionId}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="table-responsive">
                    <table class="table table-sm table-bordered w-100">
                        <tbody><tr id="children-s${this.chosenSubDimensionId}" class="text-center"></tr></tbody>
                    </table>
                    </div>
                    </div>
                </div>
                <div class="collapse" id="expand-graph-s${this.chosenSubDimensionId}">
                    <div id="chart-line-s${this.chosenSubDimensionId}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>
        </ul>`;
        this.dashboardParent.empty().html(parentHtml);
        // PARENT - render data to template
        let trendLineColor = parent.change == "Positive" ? "green" : (parent.change == "Negative" ? "red" : "grey");
        let recentChangeArrow = parent.change == "Positive"
            ? `<i class="fa fa-arrow-up"></i>`
            : (parent.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
        $(`div#current-s${this.chosenSubDimensionId}`).html(`<h4 style="color:${trendLineColor}">${Number(parent.current_score).toFixed(4)}&nbsp;${recentChangeArrow}</h4>`)
        $(`tr#children-s${this.chosenSubDimensionId}`).html(parent.child_changes);
        this.plotTrendLine(parent.yearly_scores, `chart-sparkline-s${this.chosenSubDimensionId}`, "sparkline", "Score", "normal", "grey", "score", null);
        this.plotTrendLine(parent.yearly_scores, `chart-line-s${this.chosenSubDimensionId}`, "line", "Score", "normal", "grey", "score", null);

        // CHILDREN - Prepare template
        let childrenHtml = this.categories.filter(a => a.sub_dimension_id == this.chosenSubDimensionId).map(c => {
            let name = this.categories.find(a => a.category_id == c.category_id).category_name;
            let isCategoryInForm = inputCategoryIds.includes(c.category_id);
            return isCategoryInForm
                ? `<li class="list-group-item shadow mb-2 border-0" id="c${c.category_id}">
                <div>
                    <img src="${base_url}/include/dashboard/images/present.png" class="pr-2" height="12px" title="Present">
                    <span class="heading_text">${name}</span>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-c${c.category_id}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-c${c.category_id}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-c${c.category_id}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5">
                    <div class="table-responsive">
                    <table class="table table-sm table-bordered w-100">
                        <tbody><tr id="children-c${c.category_id}" class="text-center"></tr></tbody>
                    </table>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-1 col-lg-1">
                        <a id="c${c.category_id}-next" class="c-next" data-cat-id="${c.category_id}"> 
                            <img class=""  src="${base_url}/include/dashboard/images/Arrow_Right.svg" />
                        </a>
                    </div>
                </div>
                <div class="collapse" id="expand-graph-c${c.category_id}">
                    <div id="chart-line-c${c.category_id}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>`
                : `<li class="list-group-item shadow mb-2 border-0">
                <span>
                    <img src="${base_url}/include/dashboard/images/absent.png" class="pr-2" height="12px" title="Absent">
                    <span class="heading_text">${name}</span>
                </span>
            </li>`;
        }).join("\n");
        this.dashboardChildren.empty().html(`<ul style="padding-left:0;">${childrenHtml}</ul>`);
        // CHILDREN - Render data to template
        children.forEach(c => {
            let isCategoryInForm = inputCategoryIds.includes(c.category_id);
            if (isCategoryInForm) {
                let trendLineColor = c.change == "Positive" ? "green" : (c.change == "Negative" ? "red" : "grey");
                this.plotTrendLine(c.yearly_scores, `chart-sparkline-c${c.category_id}`, "sparkline", "Score", "normal", "grey", "score", null);
                this.plotTrendLine(c.yearly_scores, `chart-line-c${c.category_id}`, "line", "Score", "normal", "grey", "score", null);
                let recentChangeArrow = c.change == "Positive"
                    ? `<i class="fa fa-arrow-up"></i>`
                    : (c.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
                $(`div#current-c${c.category_id}`).html(`<h6 style="color: ${trendLineColor};">${Number(c.latest_score).toFixed(4)}&nbsp;${recentChangeArrow}</h6>`);
                let catSummary = `<th>Categories</th>` + c.sub_changes.map(a => {
                    let cellArrow = a.change == "Positive"
                        ? `<i class="fa fa-arrow-up text-success"></i>`
                        : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                    return `<th>${a.count}&nbsp;${cellArrow} </th>`
                }).join("\n");
                $(`tr#children-c${c.category_id}`).html(catSummary);
            }
        });

        
        // BREADCRUMB - Bind Events
        $("a.c-next").on("click", e => { this.chosenCategoryId = $(e.currentTarget).data("cat-id"); this.chosenIndicatorId = null; this.showLevel4(); });
        $("a#x-level").on("click", () => { this.chosenDimensionId = null; this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel1(); });
        $("a#d-level").on("click", () => { this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel2(); });
        $("a#s-level").on("click", () => { this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel3(); });
    }

    showLevel4 = () => {
        // Parent -> Category, Children -> Indicators
        this.currentDataLevel = "category";
        this.dashboardParent.empty();
        this.dashboardChildren.empty();

        // BREADCRUMB - Arrange template
        let dimName = this.dimensions.find(a => a.dimension_id == this.chosenDimensionId).dimension_name;
        let subDimName = this.subDimensions.find(a => a.sub_dimension_id == this.chosenSubDimensionId).sub_dimension_name;
        let catName = this.categories.find(a => a.category_id == this.chosenCategoryId).category_name;
        this.dashboardLevelTitle.empty().html(`Indicators (${this.indicators.filter(a => a.category_id == this.chosenCategoryId).length})`);
        this.dashboardBreadcrumb.empty().html(`
            <a id="x-level" class="d-breadcrumb">Dimensions</a>&nbsp;/&nbsp;
            <a id="d-level" class="d-breadcrumb" data-dim-id="${this.chosenDimensionId}">${dimName}</a>&nbsp;/&nbsp;
            <a id="s-level" class="d-breadcrumb" data-subdim-id="${this.chosenSubDimensionId}">${subDimName}</a>&nbsp;/&nbsp;
            <a id="c-level" class="d-breadcrumb" data-cat-id="${this.chosenCategoryId}">${catName}</a>
        `);

        // MAP
        this.renderMapData("category", this.chosenCategoryId);

        // CHILDREN
        let childrenData = this.selectedPsSnIds.length
            ? this.indicatorScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId && a.category_id == this.chosenCategoryId && [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.indicatorScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId && a.category_id == this.chosenCategoryId); // sn filter applicable here
        let inputIndicatorIds = this.uqArray(childrenData.map(a => a.indicator_id));
        // CHILDREN - Arrange data
        let children = this.indicators.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId && a.category_id == this.chosenCategoryId).map(a => {
            let result = { "dimension_id": a.dimension_id, "sub_dimension_id": a.sub_dimension_id, "category_id": a.category_id, "indicator_id": a.indicator_id};
            let isIndicatorInForm = inputIndicatorIds.includes(a.indicator_id);
            result["is_in_form"] = isIndicatorInForm;
            if(isIndicatorInForm){
                let filteredDataSet = childrenData.filter(b => b.indicator_id == a.indicator_id);
                let uqYears = this.uqArray(filteredDataSet.map(b => b.year));
                uqYears.sort((x, y) => x > y ? 0 : -1);
                let recentTwoYears = uqYears.slice(-2);
                let yearlyScores = uqYears.map(b => {
                    let yearFilteredData = filteredDataSet.filter(c => c.year == b);
                    let yearFilteredDataSubNat = yearFilteredData.filter(c => c.m_level == "subnational");
                    let yearFilteredDataNat = yearFilteredData.filter(c => c.m_level == "national");
                    let snInYear = this.uqArray(yearFilteredDataSubNat.map(c => c.subnational_id));
                    let subNatValueArr = yearFilteredDataSubNat.map(c => c.indicator_nw);
                    let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                    let natValueArr = yearFilteredDataNat.map(c => c.indicator_nw);
                    let natScore = this.sumArray(natValueArr);
                    let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
                    return {"year": b, "score": score};
                });
                result["yearly_scores"] = yearlyScores;
                let recentChange = yearlyScores.find(b => b.year == recentTwoYears[1]).score - yearlyScores.find(b => b.year == recentTwoYears[0]).score;
                result["latest_score"] = yearlyScores.find(b => b.year == recentTwoYears[1]).score;
                result["change"] = recentChange > 0 ? "Positive" : (recentChange < 0 ? "Negative" : "No Change");

                // subnational summary
                let childSubNationalData = filteredDataSet.filter(b => b.m_level == "subnational");
                let uqAvailableSnIds = this.uqArray(childSubNationalData.map(b => b.subnational_id));
                let snChangesCheck = uqAvailableSnIds.map(b => {
                    let snFilteredSet = childSubNationalData.filter(c => c.subnational_id == b);
                    let sdYears = this.uqArray(snFilteredSet.map(c => c.year));
                    sdYears.sort((x, y) => x > y ? 0 : -1);
                    let recentTwoYears = sdYears.slice(-2);
                    let r2SnScores = recentTwoYears.map(c => {
                        let yearFilteredData = snFilteredSet.filter(d => d.year == c);
                        let snInYear = this.uqArray(yearFilteredData.map(d => d.subnational_id));
                        let subNatValueArr = yearFilteredData.map(d => d.indicator_nw);
                        let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
                        let score = subNatScore;
                        return score;
                    });
                    let r2SnChange = r2SnScores[1] - r2SnScores[0];
                    return r2SnChange > 0 ? "Positive" : (r2SnChange < 0 ? "Negative" : "No Change");
                });
                let snChanges = ["Positive", "Negative", "No Change"].map(b => {
                    return { "change": b, "count": snChangesCheck.filter(c => c === b).length }
                });
                result["sub_changes"] = snChanges;

            }
            
            return result;
        });

        // PARENT
        let parentData = this.selectedPsSnIds.length
            ? this.categoryScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId && a.category_id == this.chosenCategoryId && [...this.selectedPsSnIds, this.country.id].includes(a.subnational_id))
            : this.categoryScores.filter(a => a.dimension_id == this.chosenDimensionId && a.sub_dimension_id == this.chosenSubDimensionId && a.category_id == this.chosenCategoryId); // sn filter applicable here
        let uqYears = this.uqArray(parentData.map(a => a.year));
        uqYears.sort((x, y) => x > y ? 0 : -1);
        // PARENT - Arrange data
        let parentYearlyScores = uqYears.map(a => {
            let filteredDataSet = parentData.filter(b => b.year == a);
            let filteredDataSetSubNat = filteredDataSet.filter(b => b.m_level == "subnational");
            let filteredDataSetNat = filteredDataSet.filter(b => b.m_level == "national");
            let snInYear = this.uqArray(filteredDataSetSubNat.map(b => b.subnational_id));
            let subNatValueArr = filteredDataSetSubNat.map(b => b.category_nw);
            let subNatScore = this.sumArray(subNatValueArr)/(snInYear.length || 1);
            let natValueArr = filteredDataSetNat.map(b => b.category_nw);
            let natScore = this.sumArray(natValueArr);
            let score = this.includeNationalScore ? subNatScore + natScore : subNatScore; // here exempt natScore if only one SN is selected or Production/Grazing 
            return {"year": a, "score": score};
        });
        let recentTwoYears = uqYears.slice(-2);
        let parentCurrentScore = parentYearlyScores.find(c => c.year == recentTwoYears[1]).score
        let parentRecentChange = parentCurrentScore - parentYearlyScores.find(c => c.year == recentTwoYears[0]).score;
        let childChanges = `<th>Dimensions</th>` + ["Positive", "Negative", "No Change"]
            .map(b => { return { "change": b, "count": children.filter(c => c.change === b).length } })
            .map(a => {
                let cellArrow = a.change == "Positive"
                    ? `<i class="fa fa-arrow-up text-success"></i>`
                    : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`)
                return `<th>${a.count}&nbsp;${cellArrow} </th>`
            }).join("\n");
        let parent = {
            "current_score": parentCurrentScore,
            "yearly_scores": parentYearlyScores,
            "change": parentRecentChange > 0 ? "Positive" : (parentRecentChange < 0 ? "Negative" : "No Change"),
            "child_changes": childChanges,
        };
        // PARENT - Arrange template
        let parentHtml = `<ul style="padding-left:0;">
            <li class="list-group-item shadow mb-2 border-0" id="c${this.chosenCategoryId}" style="background-color: #A4C7B399;">
                <span class="heading_text">
                    CATEGORY: <b>${catName}</b>
                </span>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <div id="current-c${this.chosenCategoryId}" class="text-center"></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10">
                                <div id="chart-sparkline-c${this.chosenCategoryId}" style="height:70px;width: 100%;"></div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                <div data-toggle="collapse" data-target="#expand-graph-c${this.chosenCategoryId}">
                                    <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="table-responsive">
                    <table class="table table-sm table-bordered w-100">
                        <tbody><tr id="children-c${this.chosenCategoryId}" class="text-center"></tr></tbody>
                    </table></div>
                    </div>
                </div>
                <div class="collapse" id="expand-graph-c${this.chosenCategoryId}">
                    <div id="chart-line-c${this.chosenCategoryId}" style="height: 200px; width: 100%;"></div>
                </div>
            </li>
        </ul>`;
        this.dashboardParent.empty().html(parentHtml);
        // PARENT - Render data to template
        let trendLineColor = parent.change == "Positive" ? "green" : (parent.change == "Negative" ? "red" : "grey");
        let recentChangeArrow = parent.change == "Positive"
            ? `<i class="fa fa-arrow-up"></i>`
            : (parent.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
        $(`div#current-c${this.chosenCategoryId}`).html(`<h4 style="color:${trendLineColor}">${Number(parent.current_score).toFixed(4)}&nbsp;${recentChangeArrow}</h4>`)
        $(`tr#children-c${this.chosenCategoryId}`).html(parent.child_changes);
        this.plotTrendLine(parent.yearly_scores, `chart-sparkline-c${this.chosenCategoryId}`, "sparkline", "Score", "normal", "grey", "score", null);
        this.plotTrendLine(parent.yearly_scores, `chart-line-c${this.chosenCategoryId}`, "line", "Score", "normal", "grey", "score", null);

        // CHILDREN - Arrange template
        let childrenHtml = this.indicators.filter(a => a.category_id == this.chosenCategoryId).map(i => {
            let name = this.indicators.find(a => a.indicator_id == i.indicator_id).indicator_name;
            let isIndicatorInForm = inputIndicatorIds.includes(i.indicator_id);
            let unitsId = this.formRelation.find(b => b.indicator_id == i.indicator_id).measurement_unit_id;
            let units = this.units.find(b => b.m_unit_id == unitsId)?.m_unit_name || null;
            let hasNationalData = this.uqArray(this.indicatorScores.filter(x => x.m_level == "national").map(x => x.indicator_id)).includes(i.indicator_id);
            let nationalDataPopup = hasNationalData
                ? `
                    <a id="i${i.indicator_id}-next" class="i-next" data-ind-id="${i.indicator_id}" title="National Level Reported" role="button"> 
                        <img class="" height="20px" width="20px"  src="${base_url}/include/dashboard/images/Arrow_Right.svg" />
                    </a>
                `: "";
            let mLevel = hasNationalData ? "National" : this.country.snLevel

            // based on whether a county is clicked or grazing/mixed production system selected, show or hide this below thing
            let isIndicatorNationalLevel = this.countryDataNI.includes(i.indicator_id) ? true : false;
            this.includeNationalScore = this.selectedPsSnIds.length ? true : false
            let hideChild = this.includeNationalScore && isIndicatorNationalLevel
            let toggleChildStyle = hideChild ? `style="display: none;"` : ``;

            return isIndicatorInForm
                ? `<li class="list-group-item shadow mb-2 border-0" id="i${i.indicator_id}" ${toggleChildStyle}>
                    <div class="block">
                        <img src="${base_url}/include/dashboard/images/present.png" class="pr-2" height="12px" title="Present">
                        <span class="heading_text">${name}&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle text-dark" title="${mLevel} Level\n(${units})"></i></span>
                        <div class="float-right">${nationalDataPopup}</div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-2 col-lg-2">
                            <div id="current-i${i.indicator_id}" class="text-center"></div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="row">
                                <div class="col-sm-10 col-md-10 col-lg-10">
                                    <div id="chart-sparkline-i${i.indicator_id}" style="height:70px;width: 100%;"></div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                                    <div data-toggle="collapse" data-target="#expand-graph-i${i.indicator_id}">
                                        <a role="button" title="Expand"><button class="btn btn-sm btn-light mt-2"><i class="fa fa-expand text-dark"></i></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="table-responsive">
                                    <table class="table table-sm table-bordered w-100">
                                    <tbody><tr id="children-i${i.indicator_id}" class="text-center"></tr></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- div class="col-sm-12 col-md-1 col-lg-1">
                            <a id="i${i.indicator_id}-next" class="i-next" data-ind-id="${i.indicator_id}"> 
                                <img class=""  src="${base_url}/include/dashboard/images/Arrow_Right.svg" />
                            </a>
                        </div -->
                    </div>
                    <div class="collapse" id="expand-graph-i${i.indicator_id}">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div id="chart-line-i${i.indicator_id}-1" style="height: 200px; width: 100%;"></div>
                            </div>
                            <!-- div class="col-sm-12 col-md-6 col-lg-6">
                                <div id="chart-line-i${i.indicator_id}-2" style="height: 200px; width: 100%;"></div>
                            </div -->
                        </div>
                    </div>
                </li>`
                : `<li class="list-group-item shadow mb-2 border-0" id="i${i.indicator_id}" ${toggleChildStyle}>
                    <div class="block">
                        <img src="${base_url}/include/dashboard/images/images/absent.png" class="pr-2" height="12px" title="Present">
                        <span class="heading_text">${name}&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle text-dark" title="${mLevel} Level\n(${units})"></i></span>
                        <div class="float-right">${nationalDataPopup}</div>
                    </div>
                </li>`;
        }).join("\n");
        this.dashboardChildren.empty().html(`<ul style="padding-left:0;">${childrenHtml}</ul>`);
        // CHILDREN - Render data to template
        children.forEach(i => {
            let isIndicatorInForm = inputIndicatorIds.includes(i.indicator_id);
            let unitsId = this.formRelation.find(b => b.indicator_id == i.indicator_id).measurement_unit_id;
            let units = this.units.find(b => b.m_unit_id == unitsId)?.m_unit_name || null;
            if (isIndicatorInForm) {
                let trendLineColor = i.change == "Positive" ? "green" : (i.change == "Negative" ? "red" : "grey");
                this.plotTrendLine(i.yearly_scores, `chart-sparkline-i${i.indicator_id}`, "sparkline", "Score", "normal", "grey", "score", null);
                this.plotTrendLine(i.yearly_scores, `chart-line-i${i.indicator_id}-1`, "line", "Score", "normal", "grey", "score", null);
                // this.plotTrendLine(i.yearly_scores, `chart-line-i${i.indicator_id}-2`, "line", units, "actual", trendLineColor, "actual", null);
                let recentChangeArrow = i.change == "Positive"
                    ? `<i class="fa fa-arrow-up"></i>`
                    : (i.change == "Negative" ? `<i class="fa fa-arrow-down"></i>` : `<i class="fa fa-arrows-h"></i>`);
                $(`div#current-i${i.indicator_id}`).html(`<h6 style="color: ${trendLineColor};">${Number(i.latest_score).toFixed(4)}&nbsp;${recentChangeArrow}</h6>`);
                let sdSummary = `<th>${this.country.snPlural}</th>` + i.sub_changes.map(a => {
                    let cellArrow = a.change == "Positive"
                        ? `<i class="fa fa-arrow-up text-success"></i>`
                        : (a.change == "Negative" ? `<i class="fa fa-arrow-down text-danger"></i>` : `<i class="fa fa-arrows-h text-muted"></i>`);
                    return `<th>${a.count}&nbsp;${cellArrow} </th>`
                }).join("\n");
                $(`tr#children-i${i.indicator_id}`).html(sdSummary);
            }
            $(`a#i${i.indicator_id}-next`).on("click", () => {
                let name = this.indicators.find(a => a.indicator_id == i.indicator_id).indicator_name;
                this.showLevel4NI(i.indicator_id, units, name)
            });
        });

        // BREADCRUMB - Bind Events
        // $("a.i-next").on("click", e => {this.chosenIndicatorId = $(e.currentTarget).data("ind-id"); this.showLevel5()});
        $("a#x-level").on("click", () => { this.chosenDimensionId = null; this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel1(); });
        $("a#d-level").on("click", () => { this.chosenSubDimensionId = null; this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel2(); });
        $("a#s-level").on("click", () => { this.chosenCategoryId = null; this.chosenIndicatorId = null; this.showLevel3(); });
        $("a#c-level").on("click", () => { this.chosenIndicatorId = null; this.showLevel4(); });
    }

    showLevel4NI = (indicator_id, units, name) => {
        let indNIData =  this.indicatorScores.filter(a => a.m_level == "national").filter(a => a.indicator_id == indicator_id)
        let indNIDataUqYears = this.uqArray(indNIData.map(a => a.year));
        let chartData = indNIDataUqYears.map(a => {
            let result = {};
            result["year"] = a;
            result["actual"] = this.sumArray(indNIData.filter(b => b.year == a).map(b => b.actual));
            return result;
        });
        chartData.sort((a, b) => a.year > b.year ? 0 : -1);
        indNIDataUqYears.sort((a, b) => a > b ? -1 : 0);
        let difference = this.num(chartData.find(x => x.year == indNIDataUqYears[0])?.actual) - this.num(chartData.find(x => x.year_id == indNIDataUqYears[1])?.actual);
        let trendLineColor = difference > 0 ? "green" : (difference < 0 ? "red" : "grey");
        this.popupNDContainer.empty();
        this.plotTrendLine(chartData, this.popupNDContainerId, "line", units, "actual", trendLineColor, "actual", name);
        this.popupND.modal("show");
    }

    plotMap = (geoData, geoLevel) => {
        this.reloadSvgHolder();
        let tooltip;
        let vals = this.scaleVals(geoData.features);
        let polygons = L.d3SvgOverlay((selection, projection) => {
            let geoDataFeatures = geoLevel == "country" ? geoData.features.filter(a => a.properties.country_id == this.country.id) : geoData.features;
            let locationGroup = selection.selectAll("path").data(geoDataFeatures);
            const heatScale = d3.scaleSequential(d3.interpolateHsl("red", "green")).domain([vals.min, vals.max]);
            locationGroup.enter()
                .append("path")
                .attr("d", d => projection.pathFromGeojson(d))
                .attr("id", d => {
                    return geoLevel == "country"
                        ? (d.properties.country_id ? `c${d.properties.country_id}` : null)
                        : (d.properties.subnational_level_id ? `sn${d.properties.subnational_level_id}` : null)
                })
                .attr("style", "z-index:2000;pointer-events:visiblePainted !important")
                .attr("fill", d =>
                    d.properties.score
                        ? geoLevel == "sn" ? heatScale(d.properties.score) : "green"
                        : "lightgrey"
                )
                .attr("stroke", "black")
                .attr("stroke-width", "0.5px")
                .attr("fill-opacity", geoLevel == "sn" ? 7/8 : 9/10)
                .on("mouseenter", (e, d) => {
                    if (d.properties.score) {
                        let polygonId = geoLevel == "country" ? d.properties.country_id : d.properties.subnational_level_id;
                        geoLevel == "country" ? d3.select(`path#c${polygonId}`).attr("cursor", "pointer") : d3.select(`path#sn${polygonId}`).attr("cursor", "pointer");
                        let tooltipContent = geoLevel == "country" ? `${d.properties.country}` : `${d.properties.subnational_level}`
                        tooltipContent = d.properties.score ? `${tooltipContent} (${Number(d.properties.score).toFixed(4)})` : tooltipContent
                        tooltip = projection.layer.bindTooltip(tooltipContent).openTooltip(
                            L.latLng(projection.layerPointToLatLng(projection.pathFromGeojson.centroid(d)))
                        );
                    }
                })
                .on("mouseleave", (e, d) => { if (d.properties.score) tooltip.closeTooltip(); })
                .on("click", (e, d) => {
                    if (d.properties.score) {
                        if (geoLevel == "sn") {
                            this.onSingleSNClick(d.properties.subnational_level_id);
                            $("input[type='radio'][value='sn']").prop("checked", true);
                            this.plotMap(this.countryGeoData, "sn");
                            d3.select(`path#sn${d.properties.subnational_level_id}`).attr("stroke-width", "2px").attr("fill-opacity", 1);
                        } else if (geoLevel == "country") {
                            this.onCountryClick();
                            $("input[type='radio'][value='country']").prop("checked", true);
                            this.plotMap(this.continentGeoData, "country");
                        }
                    }
                })

        }, { id: geoLevel });
        polygons.addTo(this.map);
    }

    onCountryClick = () => {
        // let psTypeId = parseInt(this.filterPS.selectpicker("val"))

        // if(psTypeId){
        //     this.clickedSNId = null;
        //     let selectedSNValues = psTypeId 
        //         ? this.subNationals.filter(a => a.production_system_id == psTypeId).map(a => a.subnational_id)
        //         : this.subNationals.map(a => a.subnational_id);
        //     let selectedSNList = selectedSNValues.map(a => this.subNationals.find(b => b.subnational_id == a).subnational).map(a => `<li><div>${a}</div></li>`).join("\n");
        //     this.subNationalLabel.empty().html(this.country.snPlural);
        //     this.descSNPlural.empty().html(selectedSNValues.length > 1 ? this.country.snPlural : this.country.snLevel);
        //     this.descSNList.empty().html(selectedSNList);
        //     this.descPSType.empty().html(`${$('select#filter-ps option:selected').text()} Production Systems`);
        //     this.descSNCount.html(selectedSNValues.length);
        //     this.filterSN.selectpicker("val", selectedSNValues);
        //     this.includeNationalScore = psTypeId ? false : true;
        //     $("span#label-location").empty().html(`Country: ${this.country.name}`);
        // } else{
        //     this.filterSN.selectpicker("val", this.subNationals.map(a => a.subnational_id));
        // }

        // this.submit.trigger("click");
        // if(this.currentDataLevel == "country") this.showLevel1();
        // else if(this.currentDataLevel == "dimension") this.showLevel2();
        // else if(this.currentDataLevel == "subdimension") this.showLevel3();
        // else if(this.currentDataLevel == "category") this.showLevel4();

        // debugger;
        // this.clickedSNName = null;

        this.clickedSNId = null;
        let psTypeId = parseInt(this.filterPS.selectpicker("val"))
        if(psTypeId){
            let selectedSNValues = this.subNationals.filter(a => a.production_system_id == psTypeId).map(a => a.subnational_id);
            this.includeNationalScore = false;
            this.filterSN.selectpicker("val", selectedSNValues);
            this.submit.trigger("click");
        } else{
            this.includeNationalScore = true;
            this.filterSN.selectpicker("val", this.subNationals.map(a => a.subnational_id));
            this.submit.trigger("click");
        }
        debugger;
    }

    onSingleSNClick = (snId) => {
        this.clickedSNId = snId;
        let psType = this.subNationals.find(a => a.subnational_id == snId).production_system || "All";
        let snName = this.subNationals.find(a => a.subnational_id == snId).subnational;
        this.descSNPlural.empty().html(this.country.snLevel);
        this.descSNCount.html(1);
        this.descSNList.empty().html(`<li><div>${snName}</div></li>`);
        this.descPSType.empty().html(`${psType} Production Systems`);

        this.selectedPsSnIds = [snId];
        this.filterSN.selectpicker("val", [snId]);
        this.includeNationalScore = false;
        
        if(this.currentDataLevel == "country") this.showLevel1();
        else if(this.currentDataLevel == "dimension") this.showLevel2();
        else if(this.currentDataLevel == "subdimension") this.showLevel3();
        else if(this.currentDataLevel == "category") this.showLevel4();
        this.clickedSNName = snName;
        debugger
        $("span#label-location").empty().html(`${this.country.snLevel}: ${snName}`);
    }

    scaleVals(features) {
        d3.select("svg.legend-svg")?.remove("*");
        let values = features.map((d) => d.properties.score).filter(Boolean);
        values.sort((a, b) => a > b ? 0 : -1);
        let valObj = { "min": Math.min(...values), "max": Math.max(...values), "all": values };
        if (this.mapViewChosen == "sn") {
            this.drawHeatLegend(valObj.min, valObj.max)
        } else if (this.mapViewChosen == "country") {
            this.mapLegendContainer.hide();
        }
        return valObj;
    }

    drawHeatLegend = (min, max) => {
        const [w, h] = [20, 180];
        this.mapLegend?.selectAll("*").remove();
        this.mapLegend = d3.select("#map-legend").append("svg").attr("class", "legend-svg").attr("height", "100%");
        let gradient = this.mapLegend.append("defs")
            .append("svg:linearGradient")
            .attr("id", "gradient")
            .attr("x1", "100%")
            .attr("y1", "0%")
            .attr("x2", "100%")
            .attr("y2", "100%")
            .attr('spreadMethod', 'pad');
        let lowColor = d3.interpolateHsl("red", "green")(0);
        let highColor = d3.interpolateHsl("red", "green")(1);
        gradient.append('stop').attr('offset', '0%').attr('stop-color', highColor).attr('stop-opacity', 3/5)
        gradient.append('stop').attr('offset', '100%').attr('stop-color', lowColor).attr('stop-opacity', 3/5)
        const legend = this.mapLegend.append('g').attr('id', 'map-legend-svg');
        legend.append('rect').attr('width', w).attr('height', h).style('fill', 'url(#gradient');
        const axisScale = d3.scaleSequential().range([h - 5, 5]).domain([min - 0.05, max + 0.05])
        const axis = d3.axisRight(axisScale);
        axis.ticks(5);
        legend.append('g').attr('class', 'axis').attr('transform', `translate(${w}, ${0})`).call(axis)
    }


    plotTrendLine = (chartData, chartContainerId, chartSize, yAxisTitle, valueType, trendLineColor, value, name) => {
        Highcharts.chart(chartContainerId, {
            chart: {backgroundColor: 'transparent'},
            credits: { enabled: false },
            exporting: { enabled: chartSize == "line" ? true : false },
            legend: { enabled: false },
            title: { 
                text: name ? name: null,
                style: {fontSize: name ? "12px": null},
            },
            yAxis: {
                min: valueType == "actual" ? 0 : null,
                gridLineWidth: chartSize == "line" ? 1 : 0,
                labels: { enabled: chartSize == "line" ? true : false },
                title: { text: chartSize == "line" ? yAxisTitle : null, align: 'middle' },
            },
            xAxis: {
                title: { text: chartSize == "line" ? "Year" : null },
                labels: { enabled: chartSize == "line" ? true : false },
                categories: chartData.map(a => a.year),
            },
            tooltip: {
                valueDecimals: 2,
                formatter: function () {
                    return `<b>${parseFloat(Number(this.y).toFixed(4))}</b> (${this.x})`;
                }
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false,
                        enabled: false
                    },
                }
            },
            series: [{
                name: "",
                data: chartData.map(a => a[value]),
                color: trendLineColor
            }]

        })
    }

    loadCSVFile = (fileName) => new Promise((resolve, reject) => {
        $.ajax({
            "type": "GET",
            "url": `${base_url}/include/dashboard/data/${fileName}`,
            "beforeSend": () => startWaiting(),
            "success": response => resolve(response),
            "error": err => reject(err)
        });
    });

    loadMapFile = (mapFile) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                "type": "GET",
                "url": `${base_url}/include/dashboard/maps/${mapFile}`,
                "success": response => resolve(response),
                "error": err => reject(err)
            })
        });
    }

    reloadSvgHolder = () => {
        this.map.eachLayer((l) => {
            if (l.options.id && l.options.id.indexOf("country") === 0) this.map.removeLayer(l);
            if (l.options.id && l.options.id.indexOf("sn") === 0) this.map.removeLayer(l);
        });
    }

    csvToArray = (csvText) => {
        let wb = XLSX.read(csvText, { type: "binary" });
        let rows = XLSX.utils.sheet_to_json(wb.Sheets.Sheet1, { header: 1, raw: false });
        let header = rows[0];
        let body = rows.slice(1,);
        let data = body.map(a => {
            let result = {};
            header.forEach((b, i) => result[b] = ["NULL", undefined, null].includes(a[i]) ? null : (isNaN(a[i]) ? a[i].replace(/\"/g, "") : this.num(a[i])));
            return result;
        });
        return data;
    }

    uqArray = (arr) => [...new Set(arr)];
    sumArray = (arr) => arr.reduce((a, b) => a + b, 0);
    num = (val) => !isNaN(val) ? parseFloat(val) : 0;
}