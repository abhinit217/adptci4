const graphStakeholderData =  async (selectedYear, selectedQuarter) => {
    getSurveyData("334").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10004 === selectedYear && ele.form_data.field_10003 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10004 === selectedYear);
        $("#eventcount334").html(data.filter(ele => ele.form_data.field_5657 && ele.country_id).filter(ele => parseInt(ele.country_id)).length);
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10002).map(ele => ele.form_data.field_10002)));
        let allPolicyThemeAreas = Array.from(new Set(data.map(ele => ele.form_data.field_5422.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));
        let allStakeholderTypes = Array.from(new Set(data.map(ele => ele.form_data.field_5423.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));
        [allCountries, allAttrContrTypes, allPolicyThemeAreas, allStakeholderTypes].forEach(ele => ele.sort());
        // arranging chart data
        let chartEventTypes334 = [], chartPolicyThemeAreas334 = [], chartStakeholderTypes334 = [], chartGender334 = [], chartAge35Below = [];
        allCountries.forEach(country => {
            let eventTypes334 = {}, policyThemeAreas334 = {}, stakeholderTypes334 = {}, gender334 = {}, age35Below334 = {};
            let eventTypes = [], policyThemeAreas = [], stakeholderTypes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // events - attr/contr
            countryItem.forEach(el => el.form_data.field_10002 ? eventTypes.push(el.form_data.field_10002) : null);
            Object.values(eventTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {eventTypes334[ele[0]] = ele[1];});
            // policy theme areas
            countryItem.forEach(el => {
                (el.form_data.field_5422.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => policyThemeAreas.push(el));
            });
            Object.values(policyThemeAreas.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {policyThemeAreas334[ele[0]] = ele[1];});
            // stakeholder types
            countryItem.forEach(el => {
                (el.form_data.field_5423.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => stakeholderTypes.push(el));
            });
            Object.values(stakeholderTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {stakeholderTypes334[ele[0]] = ele[1];});
            // gender
            gender334["Male"] = countryItem.map(el => parseInt(el.form_data.field_5662)).reduce((a,b) => (a+b), 0);
            gender334["Female"] = countryItem.map(el => parseInt(el.form_data.field_5663)).reduce((a,b) => (a+b), 0);
            // age 35 below
            age35Below334["Stakeholder count"] = countryItem.map(el => parseInt(el.form_data.field_5664)).reduce((a,b) => (a+b), 0);
            // country labels
            eventTypes334["Country"] = `${countryCodes[country]}`;
            gender334["Country"] = `${countryCodes[country]}`;
            [policyThemeAreas334, stakeholderTypes334, age35Below334].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartEventTypes334.push(eventTypes334);
            chartPolicyThemeAreas334.push(policyThemeAreas334);
            chartStakeholderTypes334.push(stakeholderTypes334);
            chartGender334.push(gender334);
            chartAge35Below.push(age35Below334);
        });
        // generate charts
        getStackedBarChart("eventtype334", chartEventTypes334, "Country", allAttrContrTypes, "Number of events (Attribution/Contribution)");
        getStackedBarChart("policytheme334", chartPolicyThemeAreas334, "Country", allPolicyThemeAreas, "Policy thematic area");
        getStackedBarChart("stakeholder334", chartStakeholderTypes334, "Country", allStakeholderTypes, "Stakeholder types engaged in the workshop");
        getStackedBarChart("gender334", chartGender334, "Country", ["Male", "Female"], "Stakeholders gender");
        getStackedBarChart("age35Below334", chartAge35Below, "Country", ["Stakeholder count"], "Stakeholders aged below 35");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get stakeholder data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting334").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting334").empty();
}
const assignCurrentYear = async () => {
    $("#year334").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphStakeholderData($("#year334").val(), $("#quarter334").val());
    setTimeout(async () => {await hideWait();}, 1000);
    
});
$("#year334, #quarter334").on("change", async () => {
    await showWait();
    await graphStakeholderData($("#year334").val(), $("#quarter334").val());
    setTimeout(async () => {await hideWait();}, 1000);
});


