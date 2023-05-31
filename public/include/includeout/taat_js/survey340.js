const graphCampaignData = async (selectedYear, selectedQuarter) => {
    getSurveyData("340").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10022 === selectedYear && ele.form_data.field_10021 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10022 === selectedYear);
        $("#campaigncount340").html(data.filter(ele => ele.form_data.field_10032).map(ele => ele.form_data.field_10032).length);
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10020).map(ele => ele.form_data.field_10020)));
        let allParticipantTypes = Array.from(new Set(data.map(ele => ele.form_data.field_5439.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));

        let chartAttrContrTypes340 = [], chartParticipantTypes340 = [], chartGender340 = [], chartAge35Below340 = [];
        allCountries.forEach(country => {
            let attrContrTypes340 = {}, participantTypes340 = {}, gender340 = {}, age35Below340 = {};
            let attrContrTypes = [], participantTypes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // campaign - attr/contr types
            countryItem.forEach(el => el.form_data.field_10020 ? attrContrTypes.push(el.form_data.field_10020) : null);
            Object.values(attrContrTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {attrContrTypes340[ele[0]] = ele[1];});
            // participant types
            countryItem.forEach(el => {
                (el.form_data.field_5439.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => participantTypes.push(el));
            });
            Object.values(participantTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {participantTypes340[ele[0]] = ele[1];});
            // gender
            gender340["Male"] = countryItem.map(el => el.form_data.field_5723 ? parseInt(el.form_data.field_5723) : 0).reduce((a,b) => (a+b), 0);
            gender340["Female"] = countryItem.map(el => el.form_data.field_5724? parseInt(el.form_data.field_5724) : 0).reduce((a,b) => (a+b), 0);
            // age 35 below
            age35Below340["Participant count"] = countryItem.map(el => el.form_data.field_10033 ? parseInt(el.form_data.field_10033) : 0).reduce((a,b) => (a+b), 0);
            // country labels
            attrContrTypes340["Country"] = `${countryCodes[country]}`;
            gender340["Country"] = `${countryCodes[country]}`;
            [participantTypes340, age35Below340].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartAttrContrTypes340.push(attrContrTypes340);
            chartParticipantTypes340.push(participantTypes340);
            chartGender340.push(gender340);
            chartAge35Below340.push(age35Below340);
        });
        getStackedBarChart("campaigntype340", chartAttrContrTypes340, "Country", allAttrContrTypes, "Number of campaign/promotional activity (Attribution/Contribution)");
        getStackedBarChart("participanttype340", chartParticipantTypes340, "Country", allParticipantTypes, "Participant type wise campaign/ promotional activity");
        getStackedBarChart("gender340", chartGender340, "Country", ["Male", "Female"], "Participants gender");
        getStackedBarChart("age35below340", chartAge35Below340, "Country", ["Participant count"], "Participants aged below 35");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get Multi-stakeholder platform data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting340").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting340").empty();
}
const assignCurrentYear = async () => {
    $("#year340").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphCampaignData($("#year340").val(), $("#quarter340").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year340, #quarter340").on("change", async () => {
    await showWait();
    await graphCampaignData($("#year340").val(), $("#quarter340").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
