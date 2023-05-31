const graphMSPlatformData = async (selectedYear, selectedQuarter) => {
    getSurveyData("338").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10016 === selectedYear && ele.form_data.field_10015 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10016 === selectedYear);
        $("#platformcount338").html(data.filter(ele => ele.form_data.field_5698 && parseInt(ele.country_id)).map(ele => ele.form_data.field_5698).length);
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10014).map(ele => ele.form_data.field_10014)));
        let allPlatformTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_5434).map(ele => ele.form_data.field_5434)));
        let allGeoScopes = Array.from(new Set(data.map(ele => ele.form_data.field_5435.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));
        [allCountries, allAttrContrTypes, allPlatformTypes, allGeoScopes].forEach(ele => ele.sort());

        let chartAttrContrTypes338 = [], chartPlatformTypes338 = [], chartGeoScopes338 = [], chartGender338 = [], chartAge35Below338 = [];
        allCountries.forEach(country => {
            let attrContrTypes338 = {}, platformTypes338 = {}, geoScopes338 = {}, gender338 = {}, age35Below338 = {};
            let attrContrTypes = [], platformTypes = [], geoScopes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // platform - attr/contr types
            countryItem.forEach(el => el.form_data.field_10014 ? attrContrTypes.push(el.form_data.field_10014) : null);
            Object.values(attrContrTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {attrContrTypes338[ele[0]] = ele[1];});
            // platform types
            countryItem.forEach(el => el.form_data.field_5434 ? platformTypes.push(el.form_data.field_5434) : null);
            Object.values(platformTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {platformTypes338[ele[0]] = ele[1];});
            // geographic scopes
            countryItem.forEach(el => {
                (el.form_data.field_5435.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => geoScopes.push(el));
            });
            Object.values(geoScopes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {geoScopes338[ele[0]] = ele[1];});
            // gender
            gender338["Male"] = countryItem.map(el => el.form_data.field_5700 ? parseInt(el.form_data.field_5700) : 0).reduce((a,b) => (a+b), 0);
            gender338["Female"] = countryItem.map(el => el.form_data.field_5701? parseInt(el.form_data.field_5701) : 0).reduce((a,b) => (a+b), 0);
            // age 35 below
            age35Below338["Stakeholder count"] = countryItem.map(el => el.form_data.field_5702 ? parseInt(el.form_data.field_5702) : 0).reduce((a,b) => (a+b), 0);
            // country labels
            attrContrTypes338["Country"] = `${countryCodes[country]}`;
            gender338["Country"] = `${country ? countryCodes[country] : "Unspecified"}`;
            [platformTypes338, geoScopes338, age35Below338].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartAttrContrTypes338.push(attrContrTypes338);
            chartPlatformTypes338.push(platformTypes338);
            chartGeoScopes338.push(geoScopes338);
            chartGender338.push(gender338);
            chartAge35Below338.push(age35Below338);
        });
        // generate charts
        getStackedBarChart("platform338", chartAttrContrTypes338, "Country", allAttrContrTypes, "Number of platforms (Attribution/Contribution)");
        getStackedBarChart("innovation338", chartPlatformTypes338, "Country", allPlatformTypes, "Type of innovation platforms");
        getStackedBarChart("geoscope338", chartGeoScopes338, "Country", allGeoScopes, "Geographic scope");
        getStackedBarChart("gender338", chartGender338, "Country", ["Male", "Female"], "Stakeholder gender");
        getStackedBarChart("age35below338", chartAge35Below338, "Country", ["Stakeholder count"], "Stakeholders aged below 35");
        
    }).catch(err => {
        console.log(err);
        alert("Couldn't get Multi-stakeholder platform data");
    });
}


// DOM
const showWait = async () => {
    $("#waiting338").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting338").empty();
}
const assignCurrentYear = async () => {
    $("#year338").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphMSPlatformData($("#year338").val(), $("#quarter338").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year338, #quarter338").on("change", async () => {
    await showWait()
    await graphMSPlatformData($("#year338").val(), $("#quarter338").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
