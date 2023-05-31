const graphTechnologyData = async (selectedYear, selectedQuarter) => {
    getSurveyData("339").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10019 === selectedYear && ele.form_data.field_10018 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10019 === selectedYear);
        $("#techcount339").html(data.filter(ele => ele.form_data.field_5703).map(ele => ele.form_data.field_5703).length);
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10017).map(ele => ele.form_data.field_10017)));
        let allTechTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_5436).map(ele => ele.form_data.field_5436)));
        let allInputsPractices = Array.from(new Set(data.map(ele => ele.form_data.field_5704.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));

        let chartAttrContrTypes339 = [], chartTechTypes339 = [], chartInputsPractices339 = [];
        allCountries.forEach(country => {
            let attrContrTypes339 = {}, techTypes339 = {}, inputsPractices339 = {}
            let attrContrTypes = [], techTypes = [], inputsPractices = [];
            let countryItem = data.filter(el => el.country_id === country);
            // technology - attr/contr types
            countryItem.forEach(el => el.form_data.field_10017 ? attrContrTypes.push(el.form_data.field_10017) : null);
            Object.values(attrContrTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {attrContrTypes339[ele[0]] = ele[1];});
            // tehnology types
            countryItem.forEach(el => el.form_data.field_5436 ? techTypes.push(el.form_data.field_5436) : null);
            Object.values(techTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {techTypes339[ele[0]] = ele[1];});
            // inputs practices
            countryItem.forEach(el => {
                (el.form_data.field_5704.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => inputsPractices.push(el));
            });
            Object.values(inputsPractices.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {inputsPractices339[ele[0]] = ele[1];});
            // country labels
            attrContrTypes339["Country"] = `${countryCodes[country]}`;
            [techTypes339, inputsPractices339].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartAttrContrTypes339.push(attrContrTypes339);
            chartTechTypes339.push(techTypes339);
            chartInputsPractices339.push(inputsPractices339);
        });
        getStackedBarChart("techtype339-a", chartAttrContrTypes339, "Country", allAttrContrTypes, "Number of technologies deployed (Attribution/Contribution)");
        getStackedBarChart("techtype339-b", chartTechTypes339, "Country", allTechTypes, "Type of technologies deployed");
        getStackedBarChart("inputs339", chartInputsPractices339, "Country", allInputsPractices, "Types of inputs and practices used");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get Multi-stakeholder platform data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting339").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting339").empty();
}
const assignCurrentYear = async () => {
    $("#year339").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphTechnologyData($("#year339").val(), $("#quarter339").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year339, #quarter339").on("change", async () => {
    await showWait();
    await graphTechnologyData($("#year339").val(), $("#quarter339").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
