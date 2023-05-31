const graphMaterialsData = async (selectedYear, selectedQuarter) => {
    getSurveyData("342").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10025 === selectedYear && ele.form_data.field_10024 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10025 === selectedYear);
        $("#materialcount342").html(data.filter(ele => ele.form_data.field_5772).map(ele => ele.form_data.field_5772).length);
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allAttrContrTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_10023).map(ele => ele.form_data.field_10023)));
        let allRecepientTypes = Array.from(new Set(data.map(ele => ele.form_data.field_5774.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));

        let chartLearningTypes342 = [], chartVisibilityTypes342 = [], chartrecepientTypes342 = [], chartGender342 = [];
        allCountries.forEach(country => {
            let learningTypes342 = {}, visibilityTypes342 = {}, recepientTypes342 = {}, gender342 = {};
            let learningTypes = [], visibilityTypes = [], recepientTypes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // learning types - attr/contr
            countryItem.filter(ele => ele.form_data.field_5772 && ele.form_data.field_5772 === "Learning material").forEach(ele => ele.form_data.field_10023 ? learningTypes.push(ele.form_data.field_10023): null);
            Object.values(learningTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {learningTypes342[ele[0]] = ele[1];});
            // visibility types - attr/contr
            countryItem.filter(ele => ele.form_data.field_5772 && ele.form_data.field_5772 === "Visibility material").forEach(ele => ele.form_data.field_10023 ? visibilityTypes.push(ele.form_data.field_10023): null);
            Object.values(visibilityTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {visibilityTypes342[ele[0]] = ele[1];});
            // recepient types
            countryItem.forEach(el => {
                (el.form_data.field_5774.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => recepientTypes.push(el));
            });
            Object.values(recepientTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {recepientTypes342[ele[0]] = ele[1];});
            // gender
            gender342["Male"] = countryItem.map(el => el.form_data.field_5775 ? parseInt(el.form_data.field_5775) : 0).reduce((a,b) => (a+b), 0);
            gender342["Female"] = countryItem.map(el => el.form_data.field_5776? parseInt(el.form_data.field_5776) : 0).reduce((a,b) => (a+b), 0);
            // country labels
            learningTypes342["Country"] = `${countryCodes[country]}`;
            visibilityTypes342["Country"] = `${countryCodes[country]}`;
            recepientTypes342["Country"] = countryCodes[country];
            gender342["Country"] = `${countryCodes[country]}`;
            // combine chart data
            chartLearningTypes342.push(learningTypes342);
            chartVisibilityTypes342.push(visibilityTypes342);
            chartrecepientTypes342.push(recepientTypes342);
            chartGender342.push(gender342);
        });
        getStackedBarChart("learning342", chartLearningTypes342, "Country", allAttrContrTypes, "Number of learning materials");
        getStackedBarChart("visibility342", chartVisibilityTypes342, "Country", allAttrContrTypes, "Number of visibility materials");
        getStackedBarChart("rectype342", chartrecepientTypes342, "Country", allRecepientTypes, "Recepient types");
        getStackedBarChart("gender342", chartGender342, "Country", ["Male", "Female"], "Beneficiary gender");

    }).catch(err => {
        console.log(err);
        alert("Couldn't get information and visibility materials data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting342").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting342").empty();
}
const assignCurrentYear = async () => {
    $("#year342").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphMaterialsData($("#year342").val(), $("#quarter342").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year342, #quarter342").on("change", async () => {
    await showWait();
    await graphMaterialsData($("#year342").val(), $("#quarter342").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
