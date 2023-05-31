const graphTrainingData = async (selectedYear, selectedQuarter) => {
    getSurveyData("337").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10013 === selectedYear && ele.form_data.field_10012 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10013 === selectedYear);
        let maleParticipants = data.map(ele => ele.form_data.field_5430 ? parseInt(ele.form_data.field_5430) : 0).reduce((a, b) => (a+b), 0);
        let femaleParticipants = data.map(ele => ele.form_data.field_5431 ? parseInt(ele.form_data.field_5431) : 0).reduce((a, b) => (a+b), 0);
        $("#participants337").html(maleParticipants + femaleParticipants);
        $("#male337").html(maleParticipants);
        $("#female337").html(femaleParticipants);
        $("#trainings337").html(data.filter(ele => ele.form_data.field_5682).map(ele => ele.form_data.field_5682).length);
        $("#age35below337").html(data.map(ele => ele.form_data.field_5688 ? parseInt(ele.form_data.field_5688) : 0).reduce((a, b) => (a+b), 0));
        let allCountries = Array.from(new Set(data.filter(ele => parseInt(ele.country_id)).map(ele => ele.country_id)));
        let allTrainingTypes = Array.from(new Set(data.filter(ele => ele.form_data.field_5683).map(ele => ele.form_data.field_5683)));
        let allParticipantTypes = Array.from(new Set(data.map(ele => ele.form_data.field_5432.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(",")).flat()));

        let chartTrainingTypes337 = [], chartParticipantTypes337 = [], chartGender337 = [], chartAge35Below337 = [];
        allCountries.forEach(country => {
            let trainingTypes337 = {}, participantTypes337 = {}, gender337 = {}, age35Below337 = {};
            let trainingTypes = [], participantTypes = [];
            let countryItem = data.filter(el => el.country_id === country);
            // training types
            countryItem.forEach(el => el.form_data.field_5683 ? trainingTypes.push(el.form_data.field_5683) : null);
            Object.values(trainingTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {trainingTypes337[ele[0]] = ele[1];}); 
            // participant types
            countryItem.forEach(el => {
                (el.form_data.field_5432.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").replace(/\\\//g, "/").split(","))
                .forEach(el => participantTypes.push(el));
            });
            Object.values(participantTypes.reduce((c, v) => {c[v] = c[v] || [v, 0]; c[v][1]++; return c;},{})).forEach(ele => {participantTypes337[ele[0]] = ele[1];});
            // gender
            gender337["Male"] = countryItem.map(el => el.form_data.field_5430 ? parseInt(el.form_data.field_5430) : 0).reduce((a,b) => (a+b), 0);
            gender337["Female"] = countryItem.map(el => el.form_data.field_5431? parseInt(el.form_data.field_5431) : 0).reduce((a,b) => (a+b), 0);
            // age 35 below
            age35Below337["Participant count"] = countryItem.map(el => el.form_data.field_5688 ? parseInt(el.form_data.field_5688) : 0).reduce((a,b) => (a+b), 0);
            // country labels
            gender337["Country"] = `${country ? countryCodes[country] : "Unspecified"}`;
            [trainingTypes337, participantTypes337, age35Below337].forEach(ele => ele["Country"] = countryCodes[country]);
            // combine chart data
            chartTrainingTypes337.push(trainingTypes337);
            chartParticipantTypes337.push(participantTypes337);
            chartGender337.push(gender337);
            chartAge35Below337.push(age35Below337);
        });
        // generate charts
        getStackedBarChart("training337", chartTrainingTypes337, "Country", allTrainingTypes, "Training category wise events");
        getStackedBarChart("participant337", chartParticipantTypes337, "Country", allParticipantTypes, "Training category wise participants");
        getStackedBarChart("gender337", chartGender337, "Country", ["Male", "Female"], "Participants gender");
        getStackedBarChart("age35below337-a", chartAge35Below337, "Country", ["Participant count"], "Participants aged below 35");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get participant/training data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting337").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting337").empty();
}
const assignCurrentYear = async () => {
    $("#year337").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphTrainingData($("#year337").val(), $("#quarter337").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year337, #quarter337").on("change", async () => {
    await showWait();
    await graphTrainingData($("#year337").val(), $("#quarter337").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
