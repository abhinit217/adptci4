$(window).on("load", () => {
    const urlObject = new URL(window.location.href);
    const params = Array.from(urlObject.searchParams.keys()).map(a => {
        let result = {};
        result[a] = urlObject.searchParams.get(a);
        return result;
    }).reduce((a, b) => Object.assign(a, b), {});
    let comparison = new AtpdComparison(params?.countryId, params?.snId);
    comparison.init();
});

class AtpdComparison{
    constructor(countryId, snId){
        this.initialSNId = snId;
        // Files to be read (as alternative to API calls)
        [this.icFormData, this.rptFormData] = ["ic_form_data.csv", "rpt_form_relation.csv"];
        [this.lkpYears, this.lkpSubNational, this.lkpProductionSystem] = ["lkp_year.csv", "lkp_subnational.csv", "lkp_production_system.csv"];
        [this.lkpDimensions, this.lkpSubDimensions, this.lkpCategories, this.lkpIndicators] 
                                = ["lkp_dimensions.csv", "lkp_sub_dimensions.csv", "lkp_categories.csv", "lkp_indicator.csv"];
        [this.lkpDimensionWeights, this.lkpSubDimensionWeights, this.lkpCategoryWeights, this.lkpIndicatorWeights]
                                = ["lkp_dimension_weight.csv", "lkp_subdimension_weight.csv", "lkp_category_weight.csv", "lkp_indicator_weight.csv"];
        [this.lkpMeasurementLevels, this.lkpMeasurementUnits] = ["lkp_level_measurement.csv", "lkp_m_units.csv"];

        // Data objects
        // Inputs
        this.formData = [];
        this.formRelation = [];
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
        // Output
        this.calculatedData = [];

        // page filters
        this.countryIndex = [
            {"id": 1, "name": "Kenya", "snLevel": "County", "snPlural": "Counties"},
            {"id": 2, "name": "Uganda", "snLevel": "District", "snPlural": "Districts"},
            {"id": 3, "name": "Ethiopia", "snLevel": "Zone", "snPlural": "Zones"},
        ];
        this.filterYear = $("select#filter-year");
        this.filterCountry = $("select#filter-country");
        this.filterSN = $("select#filter-sn");
        this.labelSN = $("span#label-sn");
        this.submit = $("button#submit");

        // tab filters
        this.pageFiltersApplied = $("span#page-filters-applied");
        this.l2FilterDimension = $("select#filter-l2-dimension");

        this.chosenYearId = null;
        this.chosenYear = null;
        this.chosenCountryId = countryId;
        this.country = this.countryIndex.find(a => a.id == this.chosenCountryId)
        this.chosenSNId = this.initialSNId || null;

        this.dimensionScores = [];
        this.subDimensionScores = [];
        this.categoryScores = [];
        this.indicatorScores = [];
        this.includeNationalScore = true;

        // Dimensions Tab Components
        this.dimensionsChartId = "chart-l1";
        this.dimensionsCount = $("span#count-l1");
        // Sub-Dimension Tab Components
        this.filterL2Dimensions = $("select#filter-l2-dimension");
        this.subDimensionsChartId = "chart-l2";
        this.subDimensionsCount = $("span#count-l2");
        // Categories Tab Components
        this.filterL3Dimensions = $("select#filter-l3-dimension");
        this.filterL3SubDimensions = $("select#filter-l3-subdimension");
        this.categoriesChartId = "chart-l3";
        this.categoriesCount = $("span#count-l3");
        // Indicators Tab Components
        this.filterL4Dimensions = $("select#filter-l4-dimension");
        this.filterL4SubDimensions = $("select#filter-l4-subdimension");
        this.filterL4Categories = $("select#filter-l4-category");
        this.indicatorsChartId = "chart-l4";
        this.indicatorsCount = $("span#count-l4");
    }

    init = () => {
        Promise.all([
            // Form relation, Input
            this.loadCSVFile(this.icFormData), this.loadCSVFile(this.rptFormData),
            // Lookup files (alternate to api)
            this.loadCSVFile(this.lkpSubNational),  this.loadCSVFile(this.lkpYears), this.loadCSVFile(this.lkpProductionSystem),
            this.loadCSVFile(this.lkpDimensions), this.loadCSVFile(this.lkpSubDimensions), this.loadCSVFile(this.lkpCategories), this.loadCSVFile(this.lkpIndicators),
            this.loadCSVFile(this.lkpDimensionWeights), this.loadCSVFile(this.lkpSubDimensionWeights), this.loadCSVFile(this.lkpCategoryWeights), this.loadCSVFile(this.lkpIndicatorWeights),
            this.loadCSVFile(this.lkpMeasurementLevels), this.loadCSVFile(this.lkpMeasurementUnits)
        ]).then(([
            icFormResponse, rptFormResponse,
            subNationalResponse, yearsResponse, productionSystemsResponse,
            dimensionsResponse, subDimensionsResponse, categoriesResponse, indicatorsResponse,
            dimensionWeightsResponse, subDimensionWeightsResponse, categoryWeightsResponse, indicatorWeightsResponse,
            measurementLevelsResponse, measurementUnitsResponse
        ]) => {
            // Convert CSV data to JSON/Object arrays
            // Inputs
            this.formData = this.csvToArray(icFormResponse).filter(a => a.country_id == this.chosenCountryId);
            this.formDataNI = this.csvToArray(icFormResponse).filter(a => a.country_id == this.chosenCountryId && !a.county_id);
            this.formRelation = this.csvToArray(rptFormResponse);
            // Lookups
            this.subNationals = this.csvToArray(subNationalResponse).filter(a => a.country_id == this.chosenCountryId);
            this.years = this.csvToArray(yearsResponse);
            this.productionSystems = this.csvToArray(productionSystemsResponse);
            this.dimensions = this.csvToArray(dimensionsResponse);
            this.subDimensions = this.csvToArray(subDimensionsResponse);
            this.categories = this.csvToArray(categoriesResponse);
            this.indicators = this.csvToArray(indicatorsResponse);
            this.dimensionWeights = this.csvToArray(dimensionWeightsResponse).filter(a => a.country_id == this.chosenCountryId);
            this.subDimensionWeights = this.csvToArray(subDimensionWeightsResponse).filter(a => a.country_id == this.chosenCountryId);
            this.categoryWeights = this.csvToArray(categoryWeightsResponse).filter(a => a.country_id == this.chosenCountryId);
            this.indicatorWeights = this.csvToArray(indicatorWeightsResponse).filter(a => a.country_id == this.chosenCountryId);
            this.measurementLevels = this.csvToArray(measurementLevelsResponse);
            this.units = this.csvToArray(measurementUnitsResponse);
            // Intermediaries/Outputs
            this.calculatedData = [];
        })
        .then(() => this.fillPageFilters())
        .then(() => this.storeCountryData())
        .then(() => this.storeIndicatorScores())
        .then(() => this.storeCategoryScores())
        .then(() => this.storeSubDimensionScores())
        .then(() => this.storeDimensionScores())
        .then(() => this.storeLocationScores())
        .then(() => this.submit.trigger("click"))
        .catch(err => {
            console.error(err);
            alert("Error loading/processing files, please check console for details");
        })
        .finally(() => stopWaiting());
    }

    fillPageFilters = () => {
        // years
        this.years.sort((a, b) => a.year > b.year ? -1 : 0);
        let yearFilterHtml = this.years.map(a => `<option value="${a.year_id}">${a.year}</option>`).join("\n");
        this.filterYear.empty().html(yearFilterHtml).selectpicker("refresh");
        this.chosenYearId = eval($("select#filter-year option:first").val());
        this.chosenYear = eval($("select#filter-year option:first").text());
        this.filterYear.selectpicker("val", $("select#filter-year option:first").val());
        this.filterYear.selectpicker("refresh");


        // SNs
        let chosenCountryObj = this.countryIndex.find(a => a.id == this.chosenCountryId);
        let labelSN = `${chosenCountryObj.snLevel} (${chosenCountryObj.name})`;
        let snInInputForm = this.uqArray(this.formData.map(a => a.county_id));
        let snHtml = `<option value="">ALL ${chosenCountryObj.snPlural.toLocaleUpperCase()}</option>` + this.subNationals.filter(a => a.country_id == this.chosenCountryId && snInInputForm.includes(a.subnational_id))
            .map(a => `<option value="${a.subnational_id}">${a.subnational} (${a.production_system})</option>`).join("\n");
        this.filterSN.empty().html(snHtml).selectpicker("refresh");
                
        this.labelSN.empty().html(labelSN);
        this.chosenSNId = eval($("select#filter-sn option:first").val());
        this.filterSN.selectpicker("val", $("select#filter-sn option:first").val() ? this.initialSNId : this.chosenSNId);
        this.filterSN.selectpicker("refresh");


        // submit to calculate next;
        this.submit.on("click", () => {
            this.chosenYearId = eval(this.filterYear.selectpicker("val"));
            this.chosenYear = eval($("select#filter-year option:selected").text());
            this.chosenSNId = eval(this.filterSN.selectpicker("val"));
            let chosenSN = this.chosenSNId ? `${this.subNationals.find(a => a.subnational_id ==  this.filterSN.selectpicker("val")).subnational}, ` : "";
            let chosenCountry = this.countryIndex.find(a => a.id ==  this.chosenCountryId).name;
            this.includeNationalScore = this.filterSN.val() ? false : true;
            
            this.pageFiltersApplied.empty().html(`<b>${chosenSN}${chosenCountry}</b>`);
            if (this.formData.length) {
                this.showLevel1();
                this.showLevel2();
                this.showLevel3();
                this.showLevel4();
            } else {
                console.error("No data with these options, please change and try again");
                alert("No data with these options, please change and try again");
            }
        });

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



    showLevel1 = () => {
        let inputDimensionIds = this.uqArray(this.dimensionScores.map(a => a.dimension_id));
        let twoYears = [this.chosenYear, this.chosenYear - 1];
        this.dimensionsCount.empty().html(`(${inputDimensionIds.length})`);
        
        // L1. Dimensions Tab
        let dimensionsChartData = inputDimensionIds.map(a => {
            let result = {"dimension": this.dimensions.find(b => b.dimension_id == a).dimension_name};
            result["series"] = twoYears.map(y => {
                let innerResult = {"year": y};
                let yearData = this.dimensionScores.filter(b => b.dimension_id == a && b.year == y);
                let subNationalData = yearData.filter(b => b.subnational_id != this.country.id);
                let subNationalAvg = this.sumArray(subNationalData.map(b => b.dimension_nw))/(subNationalData.length || 1);
                let nationalData = yearData.filter(b => b.subnational_id == this.country.id);
                let nationalAvg = this.sumArray(nationalData.map(b => b.dimension_nw))/(nationalData.length || 1);
                let score = this.includeNationalScore ? nationalAvg + subNationalAvg : subNationalAvg
                innerResult["score"] = score;
                return innerResult;
            });
            return {"name": result["dimension"], "data": result["series"].map(b => b.score)}
        });
        this.plotColumnsChart("bar-chart-l1", twoYears, dimensionsChartData);
    }

    showLevel2 = () => {
        let inputSubDimensionIds = this.uqArray(this.subDimensionScores.map(a => a.sub_dimension_id));
        let twoYears = [this.chosenYear, this.chosenYear - 1];

        // L2. Sub-Dimensions Tab
        let l2DimensionsFilterHtml = this.dimensions.map(a => `<option value="${a.dimension_id}">${a.dimension_name}</option>`);
        this.filterL2Dimensions.empty().html(l2DimensionsFilterHtml).selectpicker("refresh");
        this.filterL2Dimensions.selectpicker("val", $("select#filter-l2-dimension option:first").val());
        this.filterL2Dimensions.selectpicker("refresh");
        this.filterL2Dimensions.unbind("change");
        this.filterL2Dimensions.on("change", () => {
            let dimId = this.filterL2Dimensions.selectpicker("val");
            let subDimensionIds = this.subDimensions.filter(b => b.dimension_id == dimId).map(b => b.sub_dimension_id);
            let subDimensionsChartData = subDimensionIds.map(a => {
                let result = {"sub_dimension": this.subDimensions.find(b => b.sub_dimension_id == a).sub_dimension_name};
                result["series"] = twoYears.map(y => {
                    let innerResult = {"year": y};
                    let yearData = this.subDimensionScores.filter(b => b.sub_dimension_id == a && b.year == y);
                    let subNationalData = yearData.filter(b => b.subnational_id != this.country.id);
                    let subNationalAvg = this.sumArray(subNationalData.map(b => b.sub_dimension_nw))/(subNationalData.length || 1);
                    let nationalData = yearData.filter(b => b.subnational_id == this.country.id);
                    let nationalAvg = this.sumArray(nationalData.map(b => b.sub_dimension_nw))/(nationalData.length || 1);
                    let score = this.includeNationalScore ? nationalAvg + subNationalAvg : subNationalAvg
                    innerResult["score"] = score;
                    return innerResult;
                });
                return {"name": result["sub_dimension"], "data": result["series"].map(b => b.score)}
            });
            this.subDimensionsCount.empty().html(subDimensionsChartData.length ? `(${subDimensionsChartData.length})` : "");
            this.plotColumnsChart("bar-chart-l2", twoYears, subDimensionsChartData);
            this.filterL2Dimensions.selectpicker("refresh");
        }).trigger("change")
    }

    showLevel3 = () => {
        let inputCategoryIds = this.uqArray(this.calculatedData.map(a => a.category_id));
        let twoYears = [this.chosenYear, this.chosenYear - 1];

        // L3. Categories Tab
        let l3DimensionsFilterHtml = this.dimensions.map(a => `<option value="${a.dimension_id}">${a.dimension_name}</option>`);
        this.filterL3Dimensions.empty().html(l3DimensionsFilterHtml).selectpicker("refresh");
        this.filterL3Dimensions.selectpicker("val", $("select#filter-l3-dimension option:first").val());
        this.filterL3Dimensions.selectpicker("refresh");
        this.filterL3Dimensions.unbind("change")
        this.filterL3Dimensions.on("change", () => {
            let l3SubDimensionsFilterHtml = this.subDimensions.filter(a => a.dimension_id == this.filterL3Dimensions.selectpicker("val"))
                                    .map(a => `<option value="${a.sub_dimension_id}">${a.sub_dimension_name}</option>`);
            this.filterL3SubDimensions.empty().html(l3SubDimensionsFilterHtml);
            this.filterL3SubDimensions.selectpicker("val", $("select#filter-l3-subdimension option:first").val());
            this.filterL3SubDimensions.selectpicker("refresh");
            this.filterL3SubDimensions.unbind("change");
            this.filterL3SubDimensions.on("change", () => {
                let dimId = this.filterL3Dimensions.selectpicker("val");
                let subDimId = this.filterL3SubDimensions.selectpicker("val");
                let categoryIds = this.categories.filter(b => b.dimension_id == dimId && b.sub_dimension_id == subDimId).map(b => b.category_id);
                let categoriesChartData = categoryIds.map(a => {
                    let result = {"category": this.categories.find(b => b.category_id == a).category_name};
                    result["series"] = twoYears.map(y => {
                        let innerResult = {"year": y};
                        let yearData = this.categoryScores.filter(b => b.category_id == a && b.year == y);
                        let subNationalData = yearData.filter(b => b.subnational_id != this.country.id);
                        let subNationalAvg = this.sumArray(subNationalData.map(b => b.category_nw))/(subNationalData.length || 1);
                        let nationalData = yearData.filter(b => b.subnational_id == this.country.id);
                        let nationalAvg = this.sumArray(nationalData.map(b => b.category_nw))/(nationalData.length || 1);
                        let score = this.includeNationalScore ? nationalAvg + subNationalAvg : subNationalAvg
                        innerResult["score"] = score;
                        return innerResult;
                    });
                    return {"name": result["category"], "data": result["series"].map(b => b.score)}
                })
                this.categoriesCount.empty().html(categoriesChartData.length ? `(${categoriesChartData.length})` : "");
                this.plotColumnsChart("bar-chart-l3", twoYears, categoriesChartData);
                this.filterL3SubDimensions.selectpicker("refresh");
            }).trigger("change")
            this.filterL3Dimensions.selectpicker("refresh");
        }).trigger("change")
       
        
    }

    showLevel4 = () => {
        let inputIndicatorIds = this.uqArray(this.calculatedData.map(a => a.indicator_id));
        let twoYears = [this.chosenYear, this.chosenYear - 1];

        // L4. Indicators Tab
        let l4DimensionsFilterHtml = this.dimensions.map(a => `<option value="${a.dimension_id}">${a.dimension_name}</option>`);
        this.filterL4Dimensions.empty().html(l4DimensionsFilterHtml).selectpicker("refresh");
        this.filterL4Dimensions.selectpicker("val", $("select#filter-l4-dimension option:first").val());
        this.filterL4Dimensions.selectpicker("refresh");
        this.filterL4Dimensions.unbind("change");
        this.filterL4Dimensions.on("change", () => {
            let l4SubDimensionsFilterHtml = this.subDimensions.filter(a => a.dimension_id == this.filterL4Dimensions.selectpicker("val"))
                                                        .map(a => `<option value="${a.sub_dimension_id}">${a.sub_dimension_name}</option>`);
            this.filterL4SubDimensions.empty().html(l4SubDimensionsFilterHtml);
            this.filterL4SubDimensions.selectpicker("val", $("select#filter-l4-subdimension option:first").val());
            this.filterL4SubDimensions.selectpicker("refresh");
            this.filterL4SubDimensions.unbind("change");
            this.filterL4SubDimensions.on("change", () => {
                let l4CategoriesFilterHtml = this.categories.filter(b => b.dimension_id == this.filterL4Dimensions.selectpicker("val") && b.sub_dimension_id == this.filterL4SubDimensions.selectpicker("val"))
                                                    .map(b => `<option value="${b.category_id}">${b.category_name}</option>`);
                this.filterL4Categories.empty().html(l4CategoriesFilterHtml);
                this.filterL4Categories.selectpicker("val", $("select#filter-l4-category option:first").val());
                this.filterL4Categories.selectpicker("refresh");
                this.filterL4Categories.unbind("change");
                this.filterL4Categories.on("change", () => {
                    let dimId = this.filterL4Dimensions.selectpicker("val");
                    let subDimId = this.filterL4SubDimensions.selectpicker("val");
                    let catId = this.filterL4Categories.selectpicker("val");
                    let indicatorIds = this.indicators.filter(c => c.dimension_id == dimId && c.sub_dimension_id == subDimId && c.category_id == catId).map(c => c.indicator_id);
                    

                    let indicatorsChartData = indicatorIds.map(a => {
                        let result = {"indicator": this.indicators.find(b => b.indicator_id == a).indicator_name};
                        result["series"] = twoYears.map(y => {
                            let innerResult = {"year": y};
                            let yearData = this.indicatorScores.filter(b => b.indicator_id == a && b.year == y);
                            let subNationalData = yearData.filter(b => b.subnational_id != this.country.id);
                            let subNationalAvg = this.sumArray(subNationalData.map(b => b.indicator_nw))/(subNationalData.length || 1);
                            let nationalData = yearData.filter(b => b.subnational_id == this.country.id);
                            let nationalAvg = this.sumArray(nationalData.map(b => b.indicator_nw))/(nationalData.length || 1);
                            let score = this.includeNationalScore ? nationalAvg + subNationalAvg : subNationalAvg
                            innerResult["score"] = score;
                            return innerResult;
                        });
                        return {"name": result["indicator"], "data": result["series"].map(b => b.score)}
                    })

                    this.indicatorsCount.empty().html(indicatorsChartData.length ? `(${indicatorsChartData.length})` : "");
                    this.plotColumnsChart("bar-chart-l4", twoYears, indicatorsChartData);
                    this.filterL4Categories.selectpicker("refresh");
                }).trigger("change");
                this.filterL4SubDimensions.selectpicker("refresh");
            }).trigger("change");
            this.filterL4Dimensions.selectpicker("refresh");
        }).trigger("change");
        
    }

    plotSpiderChart = (chartContainerId, chartData, category) => {
        $(`div#${chartContainerId}`).empty();
        let scoreArray = chartData.map(a => a.series.map(b => b.score)).flat();
        if(scoreArray.length && scoreArray.every(a => a !== null && !isNaN(a))){
            Highcharts.chart(chartContainerId, {
                chart: {
                    polar: true, 
                    type: 'spline'
                },
                credits: {enabled: false},
                exporting: {enabled: true},
                legend: {enabled: true},
                title: {text: null},
                yAxis: {gridLineInterpolation: 'polygon', lineWidth: 0, min: null},
                pane: {size: '80%', startAngle: 0, endAngle: 360},
                xAxis: {
                    categories: chartData[0].series.map(a => a[category]),
                    tickmarkPlacement: 'on',
                    lineWidth: 0
                },
                tooltip: {
                    shared: true,
                    pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.4f}</b><br/>'
                },
                series: chartData.map(a => {
                    return {
                        "name": a.year,
                        "data": a.series.map(b => b.score),
                        "pointPlacement": 'on'
                    }
                }),
                responsive: {
                    rules: [{
                        condition: {maxWidth: 500},
                        chartOptions: {
                            legend: { align: 'center',  verticalAlign: 'bottom', layout: 'horizontal'},
                            pane: {size: '80%'}
                        }
                    }]
                }

            });
        } else {
            $(`div#${chartContainerId}`).empty().html(`<div class="text-center">
                <span class="pt-5">Data is unavailable for this selection</span>
            </div>`);
        }
    }

    plotColumnsChart = (chartContainerId, categories, chartData) => {
        $(`div#${chartContainerId}`).empty();
        if(categories.length && chartData.length){
            Highcharts.chart(chartContainerId, {
                chart: {type: 'column'},
                credits: {enabled: false},
                exporting: {enabled: true},
                legend: {enabled: true},
                title: {text: null},
                xAxis: {
                    categories: categories,
                    crosshair: true,
                    title: {text: "Year"}
                },
                yAxis: {
                    title: {text: "Score"}
                },
                tooltip: {
                    shared: false,
                    pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.4f}</b><br/>'
                },
                series: chartData

            });
        } else {
            $(`div#${chartContainerId}`).empty().html(`<div class="text-center">
                <span class="pt-5">Data is unavailable for this selection</span>
            </div>`);
        }
    }


    loadCSVFile = (fileName) => new Promise((resolve, reject) => {
        $.ajax({
            "type": "GET",
            "url": `./assets/data/${fileName}`,
            "beforeSend": () => startWaiting(),
            "success": response => resolve(response),
            "error": err => reject(err)
        });
    });

    csvToArray = (csvText) => {
        let wb = XLSX.read(csvText, {type:"binary"});
        let rows = XLSX.utils.sheet_to_json(wb.Sheets.Sheet1, {header:1, raw:false});
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
