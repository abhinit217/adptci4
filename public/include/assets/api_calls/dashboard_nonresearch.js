var url = window.location.origin;
const rootUrl = url+"/mtp/api/nonresearch";
// const rootUrl = "http://44.231.57.147/mtp/api/nonresearch";
// const rootUrl = "http://localhost/mtp/api/nonresearch";
// const rootUrl = "https://mpro.icrisat.org/mtp/api/nonresearch";

const post = (reqBody) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            "type": "POST",
            "url": `${rootUrl}`,
            "headers": {"Content-Type": "application/json"},
            "data": reqBody,
            "success": (response) => resolve(response),
            "error": (error) => reject(error)
        })
    });
}

const withCommas = (num) =>  new Intl.NumberFormat().format(num);
const sentenceCase = (word) => {
    word.replace("_", " ")
    return word[0].toUpperCase() + word.substring(1).toLowerCase()
};
const loadingIcon = `<div class="text-center">
    <div class="fa-3x mb-1">
        <i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>
    </div>
    <span>Loading</span>
</div>`;

const showLoader = () => {
    $("#loading-modal-container").empty().html(loadingIcon);
    $("#loading-modal").modal("show");
}

const hideLoader = () => {
    $("#loading-modal-container").empty();
    $("#loading-modal").modal("hide");
}


$(window).on("load", () => {
    $("#loading-modal").modal({backdrop: 'static', keyboard: false});
    const dashboard = new Dashboard();
    dashboard.fetchFilterValues();
    dashboard.fetchNonResearchData();
});

$(document).ready(() => {
    $("button#nonresearch-refresh").on("click", () => window.location.reload())
})


class Dashboard{
    constructor(){
        this.mediaUrl = `${window.location.origin}/mtp`;
        this.clusterFilter = $("select#filter-clusters");
        this.countryFilter = $("select#filter-countries");
        this.yearFilter = $("select#filter-years");
        this.nonResearchSubmit = $("button#nonresearch-submit");

        this.filterIndexes = {};
        this.lookupData = {};

        this.chartColors = [
            "#FFAA4C", "#EE9589", "#079BAB", "#6EA9CB", "#CB6E7E", "#288427", "#660919",
            "#0FAA4B", "#FE9590", "#179BAB", "#7EA9CB", "#DB6E7E", "#388427", "#760919",
            "#1FAA4B", "#0E9590", "#279BAB", "#8EA9CB", "#EB6E7E", "#488427", "#860919",
        ];
        this.chartColors = Array(100).fill(this.chartColors).flat();

        // main chart/number container ids 
        this.internalCommunicationsNumber = "number-internal-communications";
        this.internalCommunicationsChart = "chart-internal-communications";
        this.corporateSupportNumber = "number-corporate-support";
        this.corporateSupportChart = "chart-corporate-support";
        this.strategiesPoliciesChart = "chart-strategies-policies";
        this.digitalWorkflowChart = "chart-digital-workflow";
        this.knowledgeProductsChart = "chart-knowledge-products";
        this.processWorkflowChart = "chart-process-workflow";
        this.participantsChart = "chart-participants";

        this.allCharts = {};
        
        // details popup buttons
        this.internalCommunicationsPopup = $("a#details-internal-communications");
        this.corporateSupportPopup = $("a#details-corporate-support");
        this.strategiesPoliciesPopup = $("a#details-strategies-policies");
        this.digitalWorkflowPopup = $("a#details-digital-workflow");
        this.knowledgeProductsPopup = $("a#details-knowledge-products");
        this.processWorkflowPopup = $("a#details-process-workflow");
        this.participantsPopup = $("a#details-participants");
    }

    fetchFilterValues(){
        let reqBody = {"purpose": "FILTERS"}
        post(JSON.stringify(reqBody))
        .then(response => {
            showLoader();
            response = JSON.parse(response);
            if(response.status){
                this.loadFilterValues(response);
                this.filterIndexes = response;
                this.lookupData = response;

            } else{
                alert(response.msg);
            }
        })
        .then(() => this.nonResearchSubmit.trigger("click"))
        .catch(err => {
            console.log(err);
            alert("Unable to load filters");
        });
    }

    loadFilterValues(filters){
        filters.cluster_list.sort((a, b) => a.cluster_name > b.cluster_name ? 0 : -1);
        this.clusterFilter.empty().html(filters.cluster_list.map(e => `<option value=${e.cluster_id}>${e.cluster_name}</option>`).join("\n"));
        this.clusterFilter.addClass("filter-multi bg_drop").multipleSelect({filter: true}).multipleSelect("checkAll").multipleSelect("refresh");

        // filters.year_list = filters.year_list.filter(e => parseInt(e.year) <= parseInt((new Date()).getFullYear()));
        filters.year_list.sort((a, b) => parseInt(a.year) > parseInt(b.year) ? 0 : -1);
        this.yearFilter.empty().html(filters.year_list.map(e => `<option value=${e.year_id}>${e.year}</option>`).join("\n"));
        this.yearFilter.addClass("filter-multi bg_drop").multipleSelect({filter: true}).multipleSelect("checkAll").multipleSelect("refresh");

        filters.region_list.sort((a, b) => a.region_name > b.region_name ? 0 : -1);
        filters.country_list.sort((a, b) => a.country_name > b.country_name ? 0 : -1);
        filters.country_list.forEach(a =>  a.region_name = a.region_name);
        const data = filters.region_list.map(e => {
            let countryOptions = filters.country_list.filter(f => f.region_name == e.region_name).map(f => {
                return {label : f.country_name, value : f.country_id, selected : true} 
            })
            return {label : e.region_name, childern : countryOptions, selected: true}
        });
        const countryOptions = {
            label: 'Select Country',
            isGroup: true,
            data: data,
            // onChange: (event) => console.log(event)
        };
        this.countryDropDwon = new MultiSelect(`countryDropDown`, countryOptions);
    }


    fetchNonResearchData(){
        let reqBody = {
            "purpose": "NONRESEARCH",
            "cluster_id": [],
            "country_id": [],
            "year_id": []
        };
        this.nonResearchSubmit.on("click", () => {
            showLoader();
            this.strategiesPoliciesPopup.unbind("click");
            this.internalCommunicationsPopup.unbind("click");
            this.corporateSupportPopup.unbind("click");
            this.digitalWorkflowPopup.unbind("click");
            this.knowledgeProductsPopup.unbind("click");
            this.processWorkflowPopup.unbind("click");
            this.participantsPopup.unbind("click");
            reqBody["cluster_id"] = this.clusterFilter.multipleSelect("getSelects");
            reqBody["country_id"] = this.countryDropDwon.getValue();
            reqBody["year_id"] = this.yearFilter.multipleSelect("getSelects");
            if(reqBody["country_id"].length && reqBody["year_id"].length && reqBody["cluster_id"].length){
                post(JSON.stringify(reqBody))
                .then(response => {
                    showLoader();
                    response = JSON.parse(response);
                    if(response.status){
                        this.loadNonResearchData(response);
                    } else{
                        alert("Unable to get non-research data");
                    }
                })
                .catch(err => {
                    console.log(err);
                    alert("Unable to get non-research data");
                })
                .finally(() => hideLoader())
            } else{
                hideLoader();
                alert("In each filter, at least one value must be selected")
            }
        });
    }

    loadNonResearchData(data){
        this.chartStrategiesPolicies(data.strategies_policies_data, data.indicater_wise_strategies_policies);
        this.chartProcessWorkflows(data.Process_workflow_standard_operating_procedures_data, data.indicater_wise_process_workflow);
        this.chartInternalCommunications(data.internal_communication_feedback_review_engagement_data, data.indicater_wise_internal_communication);
        this.chartCorporateSupport(data.rationalization_restructuring_data, data.indicater_wise_rationalization);
        this.chartDigitalWorkflow(data.digitized_workflows_processes_data, data.indicater_wise_digitized_workflows);
        this.chartKnowledgeProducts(data.knowledge_dissemination_communications_data, data.indicater_wise_knowledge_dissemination);
        this.chartParticipants(data.Internal_trainings_participants_data, data.indicater_wise_internal_trainings, data.Internal_trainings_participants_group_data);
    }

    chartInternalCommunications(dataPoints, indicatorPoints){
        if(this.allCharts[this.internalCommunicationsChart]){
            this.allCharts[this.internalCommunicationsChart].destroy();
            this.allCharts[this.internalCommunicationsChart] = null;
            $(`div#${this.internalCommunicationsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
        this.internalCommunicationsPopup.unbind("click");
        if(dataPoints.length){
            // $(`h2#${this.internalCommunicationsNumber}`).empty().html(withCommas(dataPoints.length));

            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let count = dataPoints.filter(b => b.lkp_cluster_id == a).length;
                return {"name": name, "count": count};
            });

            if(clusterWiseData.length){
                let total = clusterWiseData.map(a => a.count).reduce((a, b) => a+b, 0);
                this.allCharts[this.internalCommunicationsChart] = Highcharts.chart(this.internalCommunicationsChart, {
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
                        "name": "INTERNAL COMMUNICATION FEEDBACK, REVIEW AND ENGAGEMENT",
                        "data": clusterWiseData.map(a => [a.name, a.count])
                    }]
                });
            } else{
                $(`div#${this.internalCommunicationsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
                // $(`div#${this.internalCommunicationsChart}`).empty().html("Data unavailable")
            }

            
            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let count = dataPoints.filter(b => b.country_id == a).length;
                let region_name = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": count, "region_name": region_name};
            });

            let uniqueRegions = Array.from(new Set(countryWiseData.map(a => a.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);

            let indicatorWiseData = indicatorPoints.map(a => {
                a.count = dataPoints.filter(b => b.form_id == a.indicator_id).length; 
                return a;
            }).filter(a => a.count);

            this.internalCommunicationsPopup.on("click", () => {
                showInternalCommunicationsDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "indicator_wise": indicatorWiseData
                });
            });
        } else{
            $(`div#${this.internalCommunicationsNumber}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
            // $(`h2#${this.internalCommunicationsNumber}`).empty().html("Data unavailable");
        }
    }

    chartCorporateSupport(dataPoints, indicatorPoints){
        if(this.allCharts[this.corporateSupportChart]){
            this.allCharts[this.corporateSupportChart].destroy();
            this.allCharts[this.corporateSupportChart] = null;
            $(`div#${this.corporateSupportChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
        this.corporateSupportPopup.unbind("click");
        if(dataPoints.length){
            // $(`h2#${this.corporateSupportNumber}`).empty().html(withCommas(dataPoints.length));

            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let count = dataPoints.filter(b => b.lkp_cluster_id == a).length;
                return {"name": name, "count": count};
            });

            if(clusterWiseData.length){
                let total = clusterWiseData.map(a => a.count).reduce((a, b) => a+b, 0);
                this.allCharts[this.corporateSupportChart] = Highcharts.chart(this.corporateSupportChart, {
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
                        "name": "RATIONALIZATION, RESTRUCTURING AND RE-ENERGISING CORPORATE SUPPORT FUNCTIONS AND UNITS",
                        "data": clusterWiseData.map(a => [a.name, a.count])
                    }]
                });
            } else{
                $(`div#${this.corporateSupportChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
            }
            
            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let count = dataPoints.filter(b => b.country_id == a).length;
                let region_name = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": count, "region_name": region_name};
            });

            let uniqueRegions = Array.from(new Set(countryWiseData.map(a => a.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);

            let indicatorWiseData = indicatorPoints.map(a => {
                a.count = dataPoints.filter(b => b.form_id == a.indicator_id).length; 
                return a;
            }).filter(a => a.count);

            this.corporateSupportPopup.on("click", () => {
                showCorporateSupportDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "indicator_wise": indicatorWiseData
                });
            });
        } else{
            $(`h2#${this.corporateSupportNumber}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
    }

    chartStrategiesPolicies(dataPoints, indicatorPoints){
        if(this.allCharts[this.strategiesPoliciesChart]){
            this.allCharts[this.strategiesPoliciesChart].destroy();
            this.allCharts[this.strategiesPoliciesChart] = null;
        }
        this.strategiesPoliciesPopup.unbind("click");
        if(dataPoints.length){
            // dataPoints.forEach(a => a.form_data= JSON.parse(a.form_data));
            
            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let clusterList = dataPoints.filter(b => b.lkp_cluster_id == a);
                let fr133 = clusterList.filter(b => b.form_id == 133);
                let fr133_fl1089 = fr133.length ? fr133.map(b => JSON.parse(b.form_data)).filter(b => b.field_1089 == "Implemented").length : 0;
                let fr134 = clusterList.filter(b => b.form_id == 134);
                let fr134_fl1092 = fr134.length ? fr134.map(b => JSON.parse(b.form_data)).filter(b => b.field_1092 == "Implemented").length : 0;
                let fr137 = clusterList.filter(b => b.form_id == 137);
                let fr137_fl1108 = fr137.length ? fr137.map(b => JSON.parse(b.form_data)).filter(b => b.field_1108 == "Implemented").length : 0;
                let fr150 = clusterList.filter(b => b.form_id == 150);
                let fr150_fl1153 = fr150.length ? fr150.map(b => JSON.parse(b.form_data)).filter(b => b.field_1153 == "Reviewed").length : 0;
                let fr119 = clusterList.filter(b => b.form_id == 119);
                let fr119_fl1026 = fr119.length ? fr119.map(b => JSON.parse(b.form_data)).filter(b => b.field_1026).length : 0;
                let fr120 = clusterList.filter(b => b.form_id == 120);
                let fr120_fl1030 = fr120.length ? fr120.map(b => JSON.parse(b.form_data)).filter(b => b.field_1030).length : 0;
                let fr145 = clusterList.filter(b => b.form_id == 145);
                let fr145_fl1137 = fr145.length ? fr145.map(b => JSON.parse(b.form_data)).filter(b => b.field_1137).length : 0;
                return {"name": name, "count": fr133_fl1089 + fr134_fl1092 + fr137_fl1108 + fr150_fl1153 + fr119_fl1026 + fr120_fl1030 + fr145_fl1137};
            }).filter(a => a.count);
            
            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let countryList = dataPoints.filter(b => b.country_id == a);
                let fr133 = countryList.filter(b => b.form_id == 133);
                let fr133_fl1089 = fr133.length ? fr133.map(b => JSON.parse(b.form_data)).filter(b => b.field_1089 == "Implemented").length : 0;
                let fr134 = countryList.filter(b => b.form_id == 134);
                let fr134_fl1092 = fr134.length ? fr134.map(b => JSON.parse(b.form_data)).filter(b => b.field_1092 == "Implemented").length : 0;
                let fr137 = countryList.filter(b => b.form_id == 137);
                let fr137_fl1108 = fr137.length ? fr137.map(b => JSON.parse(b.form_data)).filter(b => b.field_1108 == "Implemented").length : 0;
                let fr150 = countryList.filter(b => b.form_id == 150);
                let fr150_fl1153 = fr150.length ? fr150.map(b => JSON.parse(b.form_data)).filter(b => b.field_1153 == "Reviewed").length : 0;
                let fr119 = countryList.filter(b => b.form_id == 119);
                let fr119_fl1026 = fr119.length ? fr119.map(b => JSON.parse(b.form_data)).filter(b => b.field_1026).length : 0;
                let fr120 = countryList.filter(b => b.form_id == 120);
                let fr120_fl1030 = fr120.length ? fr120.map(b => JSON.parse(b.form_data)).filter(b => b.field_1030).length : 0;
                let fr145 = countryList.filter(b => b.form_id == 145);
                let fr145_fl1137 = fr145.length ? fr145.map(b => JSON.parse(b.form_data)).filter(b => b.field_1137).length : 0;
                let regionName = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": fr133_fl1089 + fr134_fl1092 + fr137_fl1108 + fr150_fl1153 + fr119_fl1026 + fr120_fl1030 + fr145_fl1137, "region_name": regionName};
            }).filter(a => a.count);

            let uniqueRegions = Array.from(new Set(countryWiseData.map(e => e.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);

            let formDataCollective = dataPoints.map(a => a.form_data);
            let uniqueStatuses = [
                "On hold", "Drafted", "Under review", "Approved",
                "Implemented", "Review Initiated", "Review completed", 
                "Benchmarked", "Initiated", "New", "Reviewed", "Updated",
                // "Completed"
            ]
            let statusWiseDataIncomplete = uniqueStatuses.map(a => {
                let count = 0;
                formDataCollective.forEach(fd => {
                    let fdKeys = Object.keys(fd);
                    count += (fdKeys.includes("field_1089") && fd.field_1089 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1092") && fd.field_1092 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1108") && fd.field_1108 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1153") && fd.field_1153 == a)  ? 1 : 0;
                })
                return {"name": a, "count": count}
            });
            let statusWiseDataComplete = {"name": "Completed"};
            let fr119 = dataPoints.filter(b => b.form_id == 119);
            let fr119_fl1026 = fr119.length ? fr119.map(b => JSON.parse(b.form_data)).filter(b => b.field_1026).length : 0;
            let fr120 = dataPoints.filter(b => b.form_id == 120);
            let fr120_fl1030 = fr120.length ? fr120.map(b => JSON.parse(b.form_data)).filter(b => b.field_1030).length : 0;
            let fr145 = dataPoints.filter(b => b.form_id == 145);
            let fr145_fl1137 = fr145.length ? fr145.map(b => JSON.parse(b.form_data)).filter(b => b.field_1137).length : 0;
            statusWiseDataComplete["count"] = fr119_fl1026 + fr120_fl1030 + fr145_fl1137;

            let statusWiseData = [...statusWiseDataIncomplete, statusWiseDataComplete].filter(a => a.count);

            
            let frFlMap = {
                133: {"field_id": "field_1089", "answer": "Implemented"},
                134: {"field_id": "field_1092", "answer": "Implemented"},
                137: {"field_id": "field_1108", "answer": "Implemented"},
                150: {"field_id": "field_1153", "answer": "Reviewed"},
                119: {"field_id": "field_1026", "answer": "Completed"},
                120: {"field_id": "field_1030", "answer": "Completed"},
                145: {"field_id": "field_1137", "answer": "Completed"},
            };
            let indicatorWiseData = indicatorPoints.map(a => {
                let dpObj = dataPoints.filter(b => b.form_id == a.indicator_id).map(b => JSON.parse(b.form_data));
                if(Object.keys(frFlMap).includes(a.indicator_id)){
                    let [fieldId, responseText] = [frFlMap[a.indicator_id]["field_id"], frFlMap[a.indicator_id]["answer"] || undefined];
                    if(responseText !== "Completed"){
                        a.count = dpObj.filter(c => Object.keys(c).includes(fieldId))?.filter(c => c[fieldId] == responseText)?.length || 0;
                    } else{
                        a.count = dpObj.filter(c => Object.keys(c).includes(fieldId))?.filter(c => c[fieldId])?.length || 0;
                    } 
                    return a;
                }
            }).filter(a => a && a.count);


            if(clusterWiseData.length){
                let total = clusterWiseData.map(a => a.count).reduce((a, b) => a+b, 0);
                this.allCharts[this.strategiesPoliciesChart] = Highcharts.chart(this.strategiesPoliciesChart, {
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
                        "name": "Strategies, Policies",
                        "data": clusterWiseData.map(a => [a.name, a.count])
                    }]
                });
            } else{
                $(`div#${this.strategiesPoliciesChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
            }
            
            this.strategiesPoliciesPopup.on("click", () => {
                showStrategiesPoliciesDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "status_wise": statusWiseData,
                    "indicator_wise": indicatorWiseData
                })
            });

        } else{
            $(`div#${this.strategiesPoliciesChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
    }

    chartProcessWorkflows(dataPoints, indicatorPoints){
        if(this.allCharts[this.processWorkflowChart]){
            this.allCharts[this.processWorkflowChart].destroy();
            this.allCharts[this.processWorkflowChart] = null;
            $(`div#${this.processWorkflowChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
        this.processWorkflowPopup.unbind("click");
        if(dataPoints.length){
            dataPoints.forEach(a => a.form_data= JSON.parse(a.form_data));
            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let clusterList = dataPoints.filter(b => b.lkp_cluster_id == a);
                let fr100 = clusterList.filter(b => b.form_id == 100);
                let fr100_fl958 = fr100.length ? fr100.map(b => b.form_data).filter(b => b.field_958 == "Implemented").length : 0;
                let fr103 = clusterList.filter(b => b.form_id == 103);
                let fr103_fl969 = fr103.length ? fr103.map(b => b.form_data).filter(b => b.field_969 == "Recruited").length : 0;
                let fr130 = clusterList.filter(b => b.form_id == 130);
                let fr130_fl1078 = fr130.length ? fr130.map(b => b.form_data).filter(b => b.field_1078 == "Implemented").length : 0;
                let fr112 = clusterList.filter(b => b.form_id == 112);
                let fr112_fl999 = fr112.length ? fr112.map(b => b.form_data).filter(b => b.field_999 == "Implemented").length : 0;
                let fr113 = clusterList.filter(b => b.form_id == 113);
                let fr113_fl1002 = fr113.length ? fr113.map(b => b.form_data).filter(b => b.field_1002).length : 0;
                let fr121 = clusterList.filter(b => b.form_id == 121);
                let fr121_fl1034 = fr121.length ? fr121.map(b => b.form_data).filter(b => b.field_1034 == "Implemented").length : 0;
                let fr123 = clusterList.filter(b => b.form_id == 123);
                let fr123_fl1042 = fr123.length ? fr123.map(b => b.form_data).filter(b => b.field_1042 == "Completed").length : 0;
                let fr124 = clusterList.filter(b => b.form_id == 124);
                let fr124_fl1046 = fr124.length ? fr124.map(b => b.form_data).filter(b => b.field_1046 == "Implemented").length : 0;
                let fr125 = clusterList.filter(b => b.form_id == 125);
                let fr125_fl1049 = fr125.length ? fr125.map(b => b.form_data).filter(b => b.field_1049 == "Implemented").length : 0;
                let fr153 = clusterList.filter(b => b.form_id == 153);
                let fr153_fl1163 = fr153.length ? fr153.map(b => b.form_data).filter(b => b.field_1163 == "Completed").length : 0;
                let fr146 = clusterList.filter(b => b.form_id == 146);
                let fr146_fl1140 = fr146.length ? fr146.map(b => b.form_data).filter(b => b.field_1140 == "Completed").length : 0;
                return {"name": name, "count": fr100_fl958 + fr103_fl969 + fr130_fl1078 + fr112_fl999 + fr113_fl1002 + fr121_fl1034 + fr123_fl1042 + fr124_fl1046 + fr125_fl1049 + fr153_fl1163 + fr146_fl1140};
            }).filter(a => a.count);

            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let countryList = dataPoints.filter(b => b.country_id == a);
                let fr100 = countryList.filter(b => b.form_id == 100);
                let fr100_fl958 = fr100.length ? fr100.map(b => b.form_data).filter(b => b.field_958 == "Implemented").length : 0;
                let fr103 = countryList.filter(b => b.form_id == 103);
                let fr103_fl969 = fr103.length ? fr103.map(b => b.form_data).filter(b => b.field_969 == "Recruited").length : 0;
                let fr130 = countryList.filter(b => b.form_id == 130);
                let fr130_fl1078 = fr130.length ? fr130.map(b => b.form_data).filter(b => b.field_1078 == "Implemented").length : 0;
                let fr112 = countryList.filter(b => b.form_id == 112);
                let fr112_fl999 = fr112.length ? fr112.map(b => b.form_data).filter(b => b.field_999 == "Implemented").length : 0;
                let fr113 = countryList.filter(b => b.form_id == 113);
                let fr113_fl1002 = fr113.length ? fr113.map(b => b.form_data).filter(b => b.field_1002).length : 0;
                let fr121 = countryList.filter(b => b.form_id == 121);
                let fr121_fl1034 = fr121.length ? fr121.map(b => b.form_data).filter(b => b.field_1034 == "Implemented").length : 0;
                let fr123 = countryList.filter(b => b.form_id == 123);
                let fr123_fl1042 = fr123.length ? fr123.map(b => b.form_data).filter(b => b.field_1042 == "Completed").length : 0;
                let fr124 = countryList.filter(b => b.form_id == 124);
                let fr124_fl1046 = fr124.length ? fr124.map(b => b.form_data).filter(b => b.field_1046 == "Implemented").length : 0;
                let fr125 = countryList.filter(b => b.form_id == 125);
                let fr125_fl1049 = fr125.length ? fr125.map(b => b.form_data).filter(b => b.field_1049 == "Implemented").length : 0;
                let fr153 = countryList.filter(b => b.form_id == 153);
                let fr153_fl1163 = fr153.length ? fr153.map(b => b.form_data).filter(b => b.field_1163 == "Completed").length : 0;
                let fr146 = countryList.filter(b => b.form_id == 146);
                let fr146_fl1140 = fr146.length ? fr146.map(b => b.form_data).filter(b => b.field_1140 == "Completed").length : 0;
                let regionName = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": fr100_fl958 + fr103_fl969 + fr130_fl1078 + fr112_fl999 + fr113_fl1002 + fr121_fl1034 + fr123_fl1042 + fr124_fl1046 + fr125_fl1049 + fr153_fl1163 + fr146_fl1140, "region_name": regionName};
            }).filter(a => a.count);


            let uniqueRegions = Array.from(new Set(countryWiseData.map(e => e.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);


            let formDataCollective = dataPoints.map(a => a.form_data);
            let uniqueStatuses = [
                "On hold", "Initiated", "In progress", "Recruited", "Male", "Female",
                 "Drafted", "Approved", "Implemented", "Completed", "In-progress", "In testing"
            ];
            let statusWiseData1 = uniqueStatuses.map(a => {
                let count = 0;
                formDataCollective.forEach(fd => {
                    let fdKeys = Object.keys(fd);
                    count += (fdKeys.includes("field_958") && fd.field_958 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_969") && fd.field_969 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1078") && fd.field_1078 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_999") && fd.field_999 == a)  ? 1 : 0;
                    // count += (fdKeys.includes("field_1002") && fd.field_1002)  ? 1 : 0;
                    count += (fdKeys.includes("field_1034") && fd.field_1034 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1042") && fd.field_1042 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1046") && fd.field_1046 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1049") && fd.field_1049 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1163") && fd.field_1163 == a)  ? 1 : 0;
                    count += (fdKeys.includes("field_1140") && fd.field_1140 == a)  ? 1 : 0;
                })
                return {"name": a, "count": count}
            });

            // change here
            let fr113 = dataPoints.filter(b => b.form_id == 113);
            let fr113_fl1002 = fr113.length ? fr113.map(b => b.form_data).filter(b => b.field_1002).length : 0;
            let statusWiseData2 = statusWiseData1.find(a => a.name == "Completed")
            statusWiseData2.count += fr113_fl1002 || 0;

            let statusWiseData = statusWiseData1.filter(a => a.count);

            if(clusterWiseData.length){
                let total = clusterWiseData.map(a => a.count).reduce((a, b) => a+b, 0);
                this.allCharts[this.processWorkflowChart] = Highcharts.chart(this.processWorkflowChart, {
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
                        "name": "processWorkflowChart",
                        "data": clusterWiseData.map(a => [a.name, a.count])
                    }]
                });
            } else{
                $(`div#${this.processWorkflowChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
            }


            let frFlMap = {
                100: {"field_id": "field_958", "answer": "Implemented"},
                103: {"field_id": "field_969", "answer": "Recruited"},
                130: {"field_id": "field_1078", "answer": "Implemented"},
                112: {"field_id": "field_999", "answer": "Implemented"},
                113: {"field_id": "field_1002", "answer": "TOTAL"},
                121: {"field_id": "field_1034", "answer": "Implemented"},
                123: {"field_id": "field_1042", "answer": "Completed"},
                124: {"field_id": "field_1046", "answer": "Implemented"},
                125: {"field_id": "field_1049", "answer": "Implemented"},
                153: {"field_id": "field_1163", "answer": "Completed"},
                146: {"field_id": "field_1140", "answer": "Completed"},
                
            };
            let indicatorWiseData = indicatorPoints.map(a => {
                let dpObj = dataPoints.filter(b => b.form_id == a.indicator_id).map(b => b.form_data);
                if(Object.keys(frFlMap).includes(a.indicator_id)){
                    let [fieldId, responseText] = [frFlMap[a.indicator_id]["field_id"], frFlMap[a.indicator_id]["answer"] || undefined];
                    if(responseText !== "TOTAL"){
                        a.count = dpObj.filter(c => Object.keys(c).includes(fieldId))?.filter(c => c[fieldId] == responseText)?.length || 0;
                    } else{
                        a.count = dpObj.filter(c => Object.keys(c).includes(fieldId))?.filter(c => c[fieldId])?.length || 0;
                    } 
                    return a;
                }
            }).filter(a => a && a.count);
            

            this.processWorkflowPopup.on("click", () => {
                showProcessWorkflowDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "status_wise": statusWiseData,
                    "indicator_wise": indicatorWiseData
                })
            });

        } else{
            $(`div#${this.processWorkflowChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }

    }

    chartDigitalWorkflow(dataPoints, indicatorPoints){
        if(this.allCharts[this.digitalWorkflowChart]){
            this.allCharts[this.digitalWorkflowChart].destroy();
            this.allCharts[this.digitalWorkflowChart] = null;
            $(`div#${this.digitalWorkflowChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
        this.digitalWorkflowPopup.unbind("click");
        if(dataPoints.length){
            dataPoints.forEach(a => a.form_data= JSON.parse(a.form_data));
            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let count = dataPoints.filter(b => b.lkp_cluster_id == a).length;
                return {"name": name, "count": count};
            });

            if(clusterWiseData.length){
                this.allCharts[this.digitalWorkflowChart] = Highcharts.chart(this.digitalWorkflowChart, {
                    chart: {type: "column"},
                    credits: {enabled: false},
                    title: {text: null},
                    xAxis: {
                        categories: clusterWiseData.map(a => a.name),
                        title: {text: null}
                    },
                    yAxis: {
                        min: 0,
                        title: {text: "Submissions"},
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
                            "name": "Digitized workflows and processes",
                            "data": clusterWiseData.map((a, i) => {
                                return {"y": a.count, "color": this.chartColors[i]};
                            })
                        }, 
                    ]
                });
            } else{
                $(`div#${this.digitalWorkflowChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
            }


            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let count = dataPoints.filter(b => b.country_id == a).length;
                let region_name = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": count, "region_name": region_name};
            });

            let uniqueRegions = Array.from(new Set(countryWiseData.map(a => a.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);

            let indicatorWiseData = indicatorPoints.map(a => {
                a.count = dataPoints.filter(b => b.form_id == a.indicator_id).length; 
                return a;
            }).filter(a => a.count);

            this.digitalWorkflowPopup.on("click", () => {
                showDigitalWorkflowDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "indicator_wise": indicatorWiseData
                })
            });

        } else {
            $(`div#${this.digitalWorkflowChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
    }

    chartKnowledgeProducts(dataPoints, indicatorPoints){
        if(this.allCharts[this.knowledgeProductsChart]){
            this.allCharts[this.knowledgeProductsChart].destroy();
            this.allCharts[this.knowledgeProductsChart] = null;
            $(`div#${this.knowledgeProductsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
        this.knowledgeProductsPopup.unbind("click");
        if(dataPoints.length){
            dataPoints.forEach(a => a.form_data= JSON.parse(a.form_data));
            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let count = dataPoints.filter(b => b.lkp_cluster_id == a).length;
                return {"name": name, "count": count};
            });

            if(clusterWiseData.length){
                let total = clusterWiseData.map(a => a.count).reduce((a, b) => a+b, 0);
                this.allCharts[this.knowledgeProductsChart] = Highcharts.chart(this.knowledgeProductsChart, {
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
                        "name": "Knowledge Products",
                        "data": clusterWiseData.map(a => [a.name, a.count])
                    }]
                });
            } else{
                $(`div#${this.knowledgeProductsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`)
            }


            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let count = dataPoints.filter(b => b.country_id == a).length;
                let region_name = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": count, "region_name": region_name};
            });

            let uniqueRegions = Array.from(new Set(countryWiseData.map(a => a.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);

            let cropIds = Array.from(new Set(dataPoints.map(a => a.crop_id)));
            let cropWiseData = cropIds.map(a => {
                let name = this.lookupData.crops_list.find(b => b.crop_id == a).crop_name;
                let count = dataPoints.filter(b => b.crop_id == a).length;
                return {"name": name, "count": count};
            }).filter(a => a.count);


            let scienceOutlets = dataPoints.filter(a => a.form_data && a.form_id == 159).map(a => a.form_data)
            let scienceOutletTypes = Array.from(new Set(scienceOutlets.map(b => b.field_1175)));
            let scienceOutletWiseData = scienceOutletTypes.map(a => {
                let count = scienceOutlets.filter(b => b.field_1175 && b.field_1175 == a).length;
                return {"name": a, "count": count};
            });

            let mediaOutlets = dataPoints.filter(a => a.form_data && a.form_id == 162).map(a => a.form_data)
            let mediaOutletTypes = Array.from(new Set(mediaOutlets.map(b => b.field_1224)));
            let mediaOutletWiseData = mediaOutletTypes.map(a => {
                let count = mediaOutlets.filter(b => b.field_1224 && b.field_1224 == a).length;
                return {"name": a, "count": count};
            });

            let indicatorWiseData = indicatorPoints.map(a => {
                a.count = dataPoints.filter(b => b.form_id == a.indicator_id).length; 
                return a;
            }).filter(a => a.count);

            this.knowledgeProductsPopup.on("click", () => {
                showKnowledgeProductDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "crop_wise": cropWiseData,
                    "scienceoutlet_wise": scienceOutletWiseData,
                    "mediaoutlet_wise": mediaOutletWiseData,
                    "indicator_wise": indicatorWiseData
                })
            });

        } else{
            $(`div#${this.knowledgeProductsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
    }

    chartParticipants(dataPoints, indicatorPoints, groupData){
        if(this.allCharts[this.participantsChart]){
            this.allCharts[this.participantsChart].destroy();
            this.allCharts[this.participantsChart] = null;
            $(`div#${this.participantsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
        this.participantsPopup.unbind("click");
        if(dataPoints.length){
            dataPoints.forEach(a => a.form_data= JSON.parse(a.form_data));
            groupData.forEach(a => a.formgroup_data= JSON.parse(a.formgroup_data));

            let clusterIds = Array.from(new Set(dataPoints.map(a => a.lkp_cluster_id)));
            let clusterWiseData = clusterIds.map(a => {
                let name = this.lookupData.cluster_list.find(b => b.cluster_id == a).cluster_name;
                let count = dataPoints.filter(b => b.lkp_cluster_id == a).length;
                return {"name": name, "count": count};
            });

            if(clusterWiseData.length){
                let total = clusterWiseData.map(a => a.count).reduce((a, b) => a+b, 0);
                this.allCharts[this.participantsChart] = Highcharts.chart(this.participantsChart, {
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
                        "name": "Digitized workflows and processes",
                        "data": clusterWiseData.map(a => [a.name, a.count])
                    }]
                });
            } else{
                $(`div#${this.participantsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`)
            }

            let countryIds = Array.from(new Set(dataPoints.map(a => a.country_id)));
            let countryWiseData = countryIds.map(a => {
                let name = this.lookupData.country_list.find(b => b.country_id == a).country_name;
                let count = dataPoints.filter(b => b.country_id == a).length;
                let region_name = this.lookupData.country_list.find(b => b.country_id == a).region_name;
                return {"name": name, "count": count, "region_name": region_name};
            });

            let uniqueRegions = Array.from(new Set(countryWiseData.map(a => a.region_name)));
            let regionWiseData = uniqueRegions.map(a => {
                let regionList = countryWiseData.filter(b => b.region_name == a)
                return {"name": a, "count": regionList.map(b => b.count).reduce((x, y) => x+y, 0)};
            }).filter(a => a.count);


            let indicatorWiseData = indicatorPoints.map(a => {
                a.count = dataPoints.filter(b => b.form_id == a.indicator_id).length; 
                return a;
            }).filter(a => a.count);

            let genderWiseData = {
                "male": groupData.map(a => a.formgroup_data).map(b => !isNaN(b.field_1100) ? Number(b.field_1100) : 0).reduce((x, y) => (x+y), 0),
                "female": groupData.map(a => a.formgroup_data).map(b => !isNaN(b.field_1099) ? Number(b.field_1099) : 0).reduce((x, y) => (x+y), 0)
            }

            this.participantsPopup.on("click", () => {
                showParticipantsDetails({
                    "country_wise": countryWiseData,
                    "region_wise": regionWiseData,
                    "gender_wise": genderWiseData,
                    "indicator_wise": indicatorWiseData
                })
            });
            

        } else{
            $(`div#${this.participantsChart}`).empty().html(`<div class="text-center my-auto data_middle">Data unavailable</div>`);
        }
    }

}