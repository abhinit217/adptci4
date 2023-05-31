const graphPartnerdata = async (selectedYear, selectedQuarter) => {
    getSurveyData("335").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10007 === selectedYear && ele.form_data.field_10006 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10007 === selectedYear);
        $("#partnercount335").html(data.filter(ele => ele.form_data.field_5673 && ele.country_id).filter(ele => parseInt(ele.country_id)).map(ele => ele.form_data.field_5673).length);
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10005).map(ele => ele.form_data.field_10005)));
        let allOrgTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_5424).map(ele => ele.form_data.field_5424)));
        let allLeaderTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_5675).map(ele => ele.form_data.field_5675)));
        let allGeoScopes = Array.from(new Set(data.map(ele => ele.form_data.field_5425.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));
        [allCountries, allAttrContrTypes, allOrgTypes, allLeaderTypes, allGeoScopes].forEach(ele => ele.sort());

        let chartPartnerTypes335 = [], chartOrgTypes335 = [], chartLeaderTypes335 = [], chartGeoScopes335 = [];
        allCountries.forEach(country => {
            let partnerTypes335 = {}, orgTypes335 = {}, leaderTypes335 = {}, geoScopes335 = {};
            let partnerTypes = [], orgTypes = [], leaderTypes = [], geoScopes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // partner - attr/contr types
            countryItem.forEach(el => el.form_data.field_10005 ? partnerTypes.push(el.form_data.field_10005) : null);
            Object.values(partnerTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {partnerTypes335[ele[0]] = ele[1];});
            // org type
            countryItem.forEach(el => el.form_data.field_5424 ? orgTypes.push(el.form_data.field_5424) : null);
            Object.values(orgTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {orgTypes335[ele[0]] = ele[1];});
            // leadership type
            countryItem.forEach(el => el.form_data.field_5675 ? leaderTypes.push(el.form_data.field_5675) : null);
            Object.values(leaderTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {leaderTypes335[ele[0]] = ele[1];});
            // geographic scopes
            countryItem.forEach(el => {
                (el.form_data.field_5425.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => geoScopes.push(el));
            });
            Object.values(geoScopes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {geoScopes335[ele[0]] = ele[1];});
            // country labels
            partnerTypes335["Country"] = `${countryCodes[country]}`;
            [orgTypes335, leaderTypes335, geoScopes335].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartPartnerTypes335.push(partnerTypes335);
            chartOrgTypes335.push(orgTypes335);
            chartLeaderTypes335.push(leaderTypes335);
            chartGeoScopes335.push(geoScopes335);
        });
        // generate charts
        getStackedBarChart("partnertype335", chartPartnerTypes335, "Country", allAttrContrTypes, "Number of partners (Attribution/Contribution)");
        getStackedBarChart("orgtype335", chartOrgTypes335, "Country", allOrgTypes, "Type of partner organization");
        getStackedBarChart("leadertype335", chartLeaderTypes335, "Country", allLeaderTypes, "Type of partner organization leadership");
        getStackedBarChart("geoscope335", chartGeoScopes335, "Country", allGeoScopes, "Geographic scope");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get partner data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting335").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting335").empty();
}
const assignCurrentYear = async () => {
    $("#year335").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphPartnerdata($("#year335").val(), $("#quarter335").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year335, #quarter335").on("change", async () => {
    await showWait();
    await graphPartnerdata($("#year335").val(), $("#quarter335").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
