var url = window.location.origin;
const rootUrl = url+"/mtp/api/dashboard";

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
    dashboard.fetchOverview();
});

$(document).ready(() => {
    $("button#overview-refresh").on("click", () => window.location.reload())
})

class Dashboard{
    constructor(){
        this.mediaUrl = `${window.location.origin}/mtp`;
        this.clusterFilter = $("select#filter-clusters");
        this.cropFilter = $("select#filter-crops");
        this.countryFilter = $("select#filter-countries");
        this.yearFilter = $("select#filter-years");
        this.overviewSubmit = $("button#overview-submit");

        // Number panels
        this.numberFarmers = $("div#numbers-farmers");
        this.numberAreas = $("div#numbers-areas");
        this.numberActivities = $("div#numbers-activities");
        this.numberStudies = $("div#numbers-studies");
        this.numberCommunities = $("div#numbers-communities");
        

        this.chartColors = [
            "#FFAA4C", "#EE9589", "#079BAB", "#6EA9CB", "#CB6E7E", "#288427", "#660919",
            "#0FAA4B", "#FE9590", "#179BAB", "#7EA9CB", "#DB6E7E", "#388427", "#760919",
            "#1FAA4B", "#0E9590", "#279BAB", "#8EA9CB", "#EB6E7E", "#488427", "#860919",
        ];
        // Highcharts chart div ids + Totals in chart headings
        this.chartVarietyCountry = "chart-variety-country";
        this.numberVarietyCountry = $("span#number-variety-country");
        this.chartVarietyCrop = "chart-variety-crop";
        this.numberVarietyCrop = $("span#number-variety-crop");

        this.chartRegionSDGCountry = "chart-sdg1";
        this.chartRegionSDGCountryHelp = $("div#chart-sdg1-help");
        this.chartProgramSDGCluster = "chart-sdg2";
        this.chartProgramSDGClusterHelp = $("div#chart-sdg2-help");
        this.chartSdgHelp = $("div#chart-sdg3-help");
        // Details shortcuts
        this.sdgDetails = $("a#details-sdg");
        this.filterIndexes;

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
            } else{
                alert(response.msg);
            }
        })
        .then(() => this.overviewSubmit.trigger("click"))
        .catch(err => {
            console.log(err);
            alert("Unable to load filters");
        });
    }

    loadFilterValues(filters){

        filters.program_list.sort((a, b) => a.prog_name > b.prog_name ? 0 : -1);
        filters.cluster_list.sort((a, b) => a.cluster_name > b.cluster_name ? 0 : -1);
        filters.cluster_list.forEach(a =>  a.prog_name = a.prog_name);
        const cdata = filters.program_list.map(e => {
            let clusterOptions = filters.cluster_list.filter(f => f.prog_name == e.prog_name).map(f => {
                return {label : f.cluster_name, value : f.cluster_id, selected : true} 
            })
            return {label : e.prog_name, childern : clusterOptions, selected: true}
        })
        const clusterOptions = {
            label: 'Select Cluster',
            isGroup: true,
            data: cdata,
            // onChange: (event) => console.log(event)
        };
        this.clusterDropDwon = new MultiSelect(`clusterDropDown`, clusterOptions);
        // filters.cluster_list.sort((a, b) => a.cluster_name > b.cluster_name ? 0 : -1);
        // this.clusterFilter.empty().html(filters.cluster_list.map(e => `<option value=${e.cluster_id}>${e.cluster_name}</option>`).join("\n"));
        // this.clusterFilter.addClass("filter-multi bg_drop").multipleSelect({filter: true}).multipleSelect("checkAll").multipleSelect("refresh");

        filters.crops_list.sort((a, b) => a.crop_name > b.crop_name ? 0 : -1);
        this.cropFilter.empty().html(filters.crops_list.map(e => `<option value=${e.crop_id}>${e.crop_name}</option>`).join("\n"));
        this.cropFilter.addClass("filter-multi bg_drop").multipleSelect({filter: true}).multipleSelect("checkAll").multipleSelect("refresh");

        filters.year_list = filters.year_list.filter(e => parseInt(e.year) <= parseInt((new Date()).getFullYear()));
        filters.year_list.sort((a, b) => parseInt(a.year) > parseInt(b.year) ? 0 : -1);
        this.yearFilter.empty().html(filters.year_list.map(e => `<option value=${e.year_id}>${e.year}</option>`).join("\n"));
        this.yearFilter.addClass("filter-multi bg_drop").multipleSelect({filter: true}).multipleSelect("checkAll").multipleSelect("refresh");

        filters.region_list.sort((a, b) => a.region_name > b.region_name ? 0 : -1);
        // filters.region_list.push({"region_name": "Others", "region_id": 0});
        filters.country_list.sort((a, b) => a.country_name > b.country_name ? 0 : -1);
        filters.country_list.forEach(a =>  a.region_name = a.region_name);


        const data = filters.region_list.map(e => {
            let countryOptions = filters.country_list.filter(f => f.region_name == e.region_name).map(f => {
                return {label : f.country_name, value : f.country_id, selected : true} 
            })
            return {label : e.region_name, childern : countryOptions, selected: true}
        })
        
        const countryOptions = {
            label: 'Select Country',
            isGroup: true,
            data: data,
            // onChange: (event) => console.log(event)
        };
        this.countryDropDwon = new MultiSelect(`countryDropDown`, countryOptions);
    }

    refreshOptgroupedFilters(){
        // this.countryFilter.on("change", () =>this.countryFilter.multipleSelect("refresh"));
        // $("optroup.ml-3").on("click", () => this.countryFilter.multipleSelect("refresh"));
        // $("option.ml-5").on("click", () => this.countryFilter.multipleSelect("refresh"));
    }

    fetchOverview(){
        let reqBody = {
            "purpose": "sdg",
            "cluster_id": [],
            "country_id": [],
            "crop_id": [],
            "year_id": []
        };
        this.overviewSubmit.on("click", () => {
            showLoader();
            // reqBody["cluster_id"] = this.clusterFilter.multipleSelect("getSelects");
            reqBody["cluster_id"] = this.clusterDropDwon.getValue();
            reqBody["country_id"] = this.countryDropDwon.getValue();
            // debugger
            // reqBody["country_id"] = this.countryFilter.multipleSelect("getSelects");
            reqBody["crop_id"] = this.cropFilter.multipleSelect("getSelects");
            reqBody["year_id"] = this.yearFilter.multipleSelect("getSelects");
            if(reqBody["country_id"].length && reqBody["crop_id"].length && reqBody["year_id"].length && reqBody["cluster_id"].length){
                post(JSON.stringify(reqBody))
                .then(response => {
                    showLoader();
                    response = JSON.parse(response);
                    // debugger
                    if(response.status){
                        this.loadOverview(response);
                    } else{
                        alert("Unable to get SDG data");
                    }
                })
                .catch(err => {
                    console.log(err);
                    alert("Unable to get SDG data");
                })
                .finally(() => hideLoader())
            } else{
                hideLoader();
                alert("In each filter, at least one value must be selected")
            }
        });
    }

    loadOverview(overview){
        // Numbers panels
        this.regionSDGCountryChart(overview.region_sdg_country);
        this.programSDGClusterChart(overview.rp_sdg_cluster);

        this.sdgDetails.on("click", () => showSdgDetails({
            "sdg_wise_farmers": overview.sdg_indicater_farmers,
            "sdg_wise_area_coverd": overview.sdg_indicater_area_coverd,
            "sdg_wise_activities": overview.sdg_indicater_activities,
            "sdg_wise_communities": overview.sdg_indicater_communities,
            "sdg_wise_seed": overview.sdg_indicater_seed,
            "sdg_wise_partnership": overview.sdg_indicater_partnership,
            "sdg_wise_outreach_events": overview.sdg_indicater_outreach_events,
            "sdg_wise_demonstration": overview.sdg_indicater_demonstration,
            "sdg_wise_policy_framework": overview.sdg_indicater_policy_framework,
            "sdg_wise_breeding_materials": overview.sdg_indicater_breeding_materials,
            "sdg_wise_quantity_processed": overview.sdg_indicater_quantity_processed,
            "sdg_wise_digital_tools": overview.sdg_indicater_digital_tools,
            "sdg_wise_climate_information_tools": overview.sdg_indicater_climate_information_service_tools,
            "sdg_wise_nrm_tools": overview.sdg_indicater_nrm_tools,
            "sdg_wise_genomic_tools": overview.sdg_indicater_genomic_tools,
            "sdg_wise_innovation_system_tools": overview.sdg_indicater_innovation_system_tools,
            "sdg_wise_technologies_upscaled": overview.sdg_indicater_technologies_upscaled,
            "sdg_indicater_varieties_released": overview.sdg_indicater_varieties_released
        })) 
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

                Highcharts.chart(this.chartRegionSDGCountry, {
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

        let sdgInfo = Array.from(new Set([
            ...chartData.filter(a => a.from.startsWith("Goal")).map(a => a.from),
            ...chartData.filter(a => a.to.startsWith("Goal")).map(a => a.to)
        ])).map(e => `<span style="font-size:12px"><b>${e}</b><span>`).join("<br>");
            //this.chartProgramSDGClusterHelp.empty().html(sdgInfo);
            this.chartSdgHelp.empty().html(sdgInfo);
        
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

        Highcharts.chart(this.chartProgramSDGCluster, {
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


Highcharts.SparkLine = (a, b, c) => {
	const hasRenderToArg = typeof a === "string" || a.nodeName;
	const arguments = [a, b, c];
	let options = arguments[hasRenderToArg ? 1 : 0];
	const defaultOptions = {
	  chart: {
		renderTo:
		  (options.chart && options.chart.renderTo) || (hasRenderToArg && a),
		backgroundColor: null,
		borderWidth: 0,
		type: "line",
		margin: [2, 0, 2, 0],
		style: {
		  overflow: "visible",
		},
		skipClone: true,
	  },
	  title: {
		text: "",
	  },
	  credits: {
		enabled: false,
	  },
	  xAxis: {
		labels: {
		  enabled: false,
		},
		title: {
		  text: null,
		},
		startOnTick: false,
		endOnTick: false,
		tickPositions: [],
		visible: false,
	  },
	  yAxis: {
		endOnTick: false,
		startOnTick: false,
		labels: {
		  enabled: false,
		},
		title: {
		  text: null,
		},
		tickPositions: [0],
		visible: false
	  },
	  legend: {
		enabled: false,
	  },
	  tooltip: {
		hideDelay: 0,
		outside: true,
		shared: true,
	  },
	  plotOptions: {
		series: {
		  animation: true,
		  lineWidth: 2,
		  shadow: false,
		  states: {
			hover: {
			  lineWidth: 2,
			},
		  },
		  marker: {
			radius: 1,
			states: {
			  hover: {
				radius: 2,
			  },
			},
		  },
		  fillOpacity: 0,
		},
		column: {
		  negativeColor: "#910000",
		  borderColor: "silver",
		},
	  },
	};
  
	options = Object.assign(defaultOptions, options);
  
	return new Highcharts.Chart(a, options);
  };


let ccodes = [
    {"name":"Global","code":"GO"},
    {"name":"Asia","code":"AI"},
    {"name":"Eastern and Southern Africa","code":"EA"},
    {"name":"Western and Central Africa","code":"WC"},
    {"name":"India","code":"IN"},
    {"name":"Ethiopia","code":"ET"},
    {"name":"Kenya","code":"KE"},
    {"name":"Tanzania","code":"TZ"},
    {"name":"Mozambique","code":"MZ"},
    {"name":"Zimbabwe","code":"ZW"},
    {"name":"Nigeria","code":"NG"},
    {"name":"Niger","code":"NE"},
    {"name":"Mali","code":"ML"},
    {"name":"Afghanistan","code":"AF"},
    {"name":"Albania","code":"AL"},
    {"name":"Algeria","code":"DZ"},
    {"name":"American Samoa","code":"AS"},
    {"name":"Andorra","code":"AD"},
    {"name":"Angola","code":"AO"},
    {"name":"Anguilla","code":"AI"},
    {"name":"Antarctica","code":"AQ"},
    {"name":"Antigua and Barbuda","code":"AG"},
    {"name":"Argentina","code":"AR"},
    {"name":"Armenia","code":"AM"},
    {"name":"Aruba","code":"AW"},
    {"name":"Australia","code":"AU"},
    {"name":"Austria","code":"AT"},
    {"name":"Azerbaijan","code":"AZ"},
    {"name":"Bahamas","code":"BS"},
    {"name":"Bahrain","code":"BH"},
    {"name":"Bangladesh","code":"BD"},
    {"name":"Barbados","code":"BB"},
    {"name":"Belarus","code":"BY"},
    {"name":"Belgium","code":"BE"},
    {"name":"Belize","code":"BZ"},
    {"name":"Benin","code":"BJ"},
    {"name":"Bermuda","code":"BM"},
    {"name":"Bhutan","code":"BT"},
    {"name":"Bolivia","code":"BO"},
    {"name":"Bosnia and Herzegovina","code":"BA"},
    {"name":"Botswana","code":"BW"},
    {"name":"Bouvet Island","code":"BV"},
    {"name":"Brazil","code":"BR"},
    {"name":"British Indian Ocean Territory","code":"IO"},
    {"name":"Brunei Darussalam","code":"BN"},
    {"name":"Bulgaria","code":"BG"},
    {"name":"Burkina Faso","code":"BF"},
    {"name":"Burundi","code":"BI"},
    {"name":"Burundi","code":"BD"},
    {"name":"Cambodia","code":"KH"},
    {"name":"Cameroon","code":"CM"},
    {"name":"Canada","code":"CA"},
    {"name":"Cape Verde","code":"CV"},
    {"name":"Cayman Islands","code":"KY"},
    {"name":"Central African Republic","code":"CF"},
    {"name":"Chad","code":"TD"},
    {"name":"Chile","code":"CL"},
    {"name":"China","code":"CN"},
    {"name":"Christmas Island","code":"CX"},
    {"name":"Cocos (Keeling), Islands","code":"CC"},
    {"name":"Colombia","code":"CO"},
    {"name":"Comoros","code":"CR"},
    {"name":"Comoros","code":"KM"},
    {"name":"Congo","code":"CG"},
    {"name":"Cook Islands","code":"CK"},
    {"name":"Costa Rica","code":"CR"},
    {"name":"Croatia (Hrvatska),","code":"HR"},
    {"name":"Cuba","code":"CU"},
    {"name":"Cyprus","code":"CY"},
    {"name":"Czech Republic","code":"CZ"},
    {"name":"Denmark","code":"DK"},
    {"name":"Djibouti","code":"DB"},
    {"name":"Djibouti","code":"DJ"},
    {"name":"Dominica","code":"DM"},
    {"name":"Dominican Republic","code":"DO"},
    {"name":"DR Congo","code":"CD"},
    {"name":"East Timor","code":"TP"},
    {"name":"Ecuador","code":"EC"},
    {"name":"Egypt","code":"EG"},
    {"name":"El Salvador","code":"SV"},
    {"name":"Equatorial Guinea","code":"GQ"},
    {"name":"Eritrea","code":null},
    {"name":"Eritrea","code":"ER"},
    {"name":"Estonia","code":"EE"},
    {"name":"Falkland Islands (Malvinas),","code":"FK"},
    {"name":"Faroe Islands","code":"FO"},
    {"name":"Fiji","code":"FJ"},
    {"name":"Finland","code":"FI"},
    {"name":"France Metropolitan","code":"FX"},
    {"name":"France","code":"FR"},
    {"name":"French Guiana","code":"GF"},
    {"name":"French Polynesia","code":"PF"},
    {"name":"French Southern Territories","code":"TF"},
    {"name":"Gabon","code":"GA"},
    {"name":"Gambia","code":"GM"},
    {"name":"Georgia","code":"GE"},
    {"name":"Germany","code":"DE"},
    {"name":"Ghana","code":"GH"},
    {"name":"Gibraltar","code":"GI"},
    {"name":"Greece","code":"GR"},
    {"name":"Greenland","code":"GL"},
    {"name":"Grenada","code":"GD"},
    {"name":"Guadeloupe","code":"GP"},
    {"name":"Guam","code":"GU"},
    {"name":"Guatemala","code":"GT"},
    {"name":"Guernsey","code":"GK"},
    {"name":"Guinea","code":"GN"},
    {"name":"Guinea-Bissau","code":"GW"},
    {"name":"Guyana","code":"GY"},
    {"name":"Haiti","code":"HT"},
    {"name":"Heard and Mc Donald Islands","code":"HM"},
    {"name":"Honduras","code":"HN"},
    {"name":"Hong Kong","code":"HK"},
    {"name":"Hungary","code":"HU"},
    {"name":"Iceland","code":"IS"},
    {"name":"Indonesia","code":"ID"},
    {"name":"Iran (Islamic Republic of),","code":"IR"},
    {"name":"Iraq","code":"IQ"},
    {"name":"Ireland","code":"IE"},
    {"name":"Isle of Man","code":"IM"},
    {"name":"Israel","code":"IL"},
    {"name":"Italy","code":"IT"},
    {"name":"Ivory Coast","code":"CI"},
    {"name":"Jamaica","code":"JM"},
    {"name":"Japan","code":"JP"},
    {"name":"Jersey","code":"JE"},
    {"name":"Jordan","code":"JO"},
    {"name":"Kazakhstan","code":"KZ"},
    {"name":"Kiribati","code":"KI"},
    {"name":"Korea Democratic People's Republic of","code":"KP"},
    {"name":"Korea Republic of","code":"KR"},
    {"name":"Kosovo","code":"XK"},
    {"name":"Kuwait","code":"KW"},
    {"name":"Kyrgyzstan","code":"KG"},
    {"name":"Lao People's Democratic Republic","code":"LA"},
    {"name":"Latvia","code":"LV"},
    {"name":"Lebanon","code":"LB"},
    {"name":"Lesotho","code":"LT"},
    {"name":"Lesotho","code":"LS"},
    {"name":"Liberia","code":"LR"},
    {"name":"Libyan Arab Jamahiriya","code":"LY"},
    {"name":"Liechtenstein","code":"LI"},
    {"name":"Lithuania","code":"LT"},
    {"name":"Luxembourg","code":"LU"},
    {"name":"Macau","code":"MO"},
    {"name":"Macedonia","code":"MK"},
    {"name":"Madagascar","code":"MG"},
    {"name":"Malawi","code":"MW"},
    {"name":"Malaysia","code":"MY"},
    {"name":"Maldives","code":"MV"},
    {"name":"Malta","code":"MT"},
    {"name":"Marshall Islands","code":"MH"},
    {"name":"Martinique","code":"MQ"},
    {"name":"Mauritania","code":"MR"},
    {"name":"Mauritius","code":"MT"},
    {"name":"Mauritius","code":"MU"},
    {"name":"Mayotte","code":"TY"},
    {"name":"Mexico","code":"MX"},
    {"name":"Micronesia Federated States of","code":"FM"},
    {"name":"Moldova Republic of","code":"MD"},
    {"name":"Monaco","code":"MC"},
    {"name":"Mongolia","code":"MN"},
    {"name":"Montenegro","code":"ME"},
    {"name":"Montserrat","code":"MS"},
    {"name":"Morocco","code":"MA"},
    {"name":"Myanmar","code":"MM"},
    {"name":"Namibia","code":null},
    {"name":"Namibia","code":"NA"},
    {"name":"Nauru","code":"NR"},
    {"name":"Nepal","code":"NP"},
    {"name":"Netherlands","code":"NL"},
    {"name":"Netherlands Antilles","code":"AN"},
    {"name":"New Caledonia","code":"NC"},
    {"name":"New Zealand","code":"NZ"},
    {"name":"Nicaragua","code":"NI"},
    {"name":"Niue","code":"NU"},
    {"name":"Norfolk Island","code":"NF"},
    {"name":"Northern Mariana Islands","code":"MP"},
    {"name":"Norway","code":"NO"},
    {"name":"Oman","code":"OM"},
    {"name":"Pakistan","code":"PK"},
    {"name":"Palau","code":"PW"},
    {"name":"Palestine","code":"PS"},
    {"name":"Panama","code":"PA"},
    {"name":"Papua New Guinea","code":"PG"},
    {"name":"Paraguay","code":"PY"},
    {"name":"Peru","code":"PE"},
    {"name":"Philippines","code":"PH"},
    {"name":"Pitcairn","code":"PN"},
    {"name":"Poland","code":"PL"},
    {"name":"Portugal","code":"PT"},
    {"name":"Puerto Rico","code":"PR"},
    {"name":"Qatar","code":"QA"},
    {"name":"Reunion","code":"RE"},
    {"name":"Romania","code":"RO"},
    {"name":"Russian Federation","code":"RU"},
    {"name":"Rwanda","code":"RW"},
    {"name":"Saint Kitts and Nevis","code":"KN"},
    {"name":"Saint Lucia","code":"LC"},
    {"name":"Saint Vincent and the Grenadines","code":"VC"},
    {"name":"Samoa","code":"WS"},
    {"name":"San Marino","code":"SM"},
    {"name":"Sao Tome and Principe","code":"ST"},
    {"name":"Saudi Arabia","code":"SA"},
    {"name":"Senegal","code":"SN"},
    {"name":"Serbia","code":"RS"},
    {"name":"Seychelles","code":"SC"},
    {"name":"Sierra Leone","code":"SL"},
    {"name":"Singapore","code":"SG"},
    {"name":"Slovakia","code":"SK"},
    {"name":"Slovenia","code":"SI"},
    {"name":"Solomon Islands","code":"SB"},
    {"name":"Somalia","code":"SL"},
    {"name":"Somalia","code":"SO"},
    {"name":"Somaliland","code":"SL"},
    {"name":"South Africa","code":"SA"},
    {"name":"South Africa","code":"ZA"},
    {"name":"South Georgia South Sandwich Islands","code":"GS"},
    {"name":"Spain","code":"ES"},
    {"name":"Sri Lanka","code":"LK"},
    {"name":"St. Helena","code":"SH"},
    {"name":"St. Pierre and Miquelon","code":"PM"},
    {"name":"Sudan","code":"SD"},
    {"name":"Suriname","code":"SR"},
    {"name":"Svalbard and Jan Mayen Islands","code":"SJ"},
    {"name":"Swaziland","code":"SL"},
    {"name":"Swaziland","code":"SZ"},
    {"name":"Sweden","code":"SE"},
    {"name":"Switzerland","code":"CH"},
    {"name":"Syrian Arab Republic","code":"SY"},
    {"name":"Taiwan","code":"TW"},
    {"name":"Tajikistan","code":"TJ"},
    {"name":"United Republic of Tanzania","code":"TZ"},
    {"name":"Thailand","code":"TH"},
    {"name":"Togo","code":"TG"},
    {"name":"Tokelau","code":"TK"},
    {"name":"Tonga","code":"TO"},
    {"name":"Trinidad and Tobago","code":"TT"},
    {"name":"Tunisia","code":"TN"},
    {"name":"Turkey","code":"TR"},
    {"name":"Turkmenistan","code":"TM"},
    {"name":"Turks and Caicos Islands","code":"TC"},
    {"name":"Tuvalu","code":"TV"},
    {"name":"Uganda","code":"UG"},
    {"name":"Ukraine","code":"UA"},
    {"name":"United Arab Emirates","code":"AE"},
    {"name":"United Kingdom","code":"GB"},
    {"name":"United States","code":"US"},
    {"name":"United States minor outlying islands","code":"UM"},
    {"name":"UNKNOWN","code":"N\/A"},
    {"name":"Uruguay","code":"UY"},
    {"name":"Uzbekistan","code":"UZ"},
    {"name":"Vanuatu","code":"VU"},
    {"name":"Vatican City State","code":"VA"},
    {"name":"Venezuela","code":"VE"},
    {"name":"Vietnam","code":"VN"},
    {"name":"Virgin Islands (British),","code":"VG"},
    {"name":"Virgin Islands (U.S.),","code":"VI"},
    {"name":"Wallis and Futuna Islands","code":"WF"},
    {"name":"Western Sahara","code":"EH"},
    {"name":"Yemen","code":"YE"},
    {"name":"Zaire","code":"ZR"},
    {"name":"Zambia","code":"ZB"},
    {"name":"Zambia","code":"ZM"}
    ];