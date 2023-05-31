const graphPartnershipData = async (selectedYear, selectedQuarter) => {
    getSurveyData("336").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10010 === selectedYear && ele.form_data.field_10009 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10010 === selectedYear);
        $("#partnershipcount336").html(data.filter(ele => ele.form_data.field_5676 && ele.country_id).filter(ele => parseInt(ele.country_id)).map(ele => ele.form_data.field_5676).length)
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10008).map(ele => ele.form_data.field_10008)));
        let allPartnershipTypes = Array.from(new Set(data.map(ele => ele.form_data.field_5429.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));
        let allGeoScopes = Array.from(new Set(data.map(ele => ele.form_data.field_5428.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));
        [allCountries, allAttrContrTypes, allPartnershipTypes, allGeoScopes].forEach(ele => ele.sort());

        let chartAttrContrTypes336 = [], chartPartnershipTypes336 = [], chartGeoScopes336 = [];
        allCountries.forEach(country => {
            let attrContrTypes336 = {}, partnershipTypes336 = {}, geoScopes336 = {};
            let attrContrTypes = [], partnershipTypes = [], geoScopes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // partnership - attr/contr types
            countryItem.forEach(el => el.form_data.field_10008 ? attrContrTypes.push(el.form_data.field_10008) : null);
            Object.values(attrContrTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {attrContrTypes336[ele[0]] = ele[1];});
            // partnership types
            countryItem.forEach(el => {
                (el.form_data.field_5429.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => partnershipTypes.push(el));
            });
            Object.values(partnershipTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {partnershipTypes336[ele[0]] = ele[1];});
            // geographic scopes
            countryItem.forEach(el => {
                (el.form_data.field_5428.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => geoScopes.push(el));
            });
            Object.values(geoScopes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {geoScopes336[ele[0]] = ele[1];});
            // country labels
            attrContrTypes336["Country"] = `${countryCodes[country]}`;
            [partnershipTypes336, geoScopes336].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartAttrContrTypes336.push(attrContrTypes336);
            chartPartnershipTypes336.push(partnershipTypes336);
            chartGeoScopes336.push(geoScopes336);
        });
        // generate charts
        getStackedBarChart("partnershiptype336", chartAttrContrTypes336, "Country", allAttrContrTypes, "Number of partnersips (Attribution/Contribution)");
        getStackedBarChart("orgtype336", chartPartnershipTypes336, "Country", allPartnershipTypes, "Type of partnerships");
        getStackedBarChart("geoscope336", chartGeoScopes336, "Country", allGeoScopes, "Geographic scope");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get partnership data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting336").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting336").empty();
}
const assignCurrentYear = async () => {
    $("#year336").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphPartnershipData($("#year336").val(), $("#quarter336").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year336, #quarter336").on("change", async () => {
    await showWait();
    await graphPartnershipData($("#year336").val(), $("#quarter336").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
