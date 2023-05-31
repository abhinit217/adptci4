const graphFarmerData = async (selectedYear, selectedQuarter) => {
    getSurveyData("344").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10028 === selectedYear && ele.form_data.field_10027 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10028 === selectedYear);
        let gender344 = [];
        ["Male", "Female"].forEach(gnd => {
            let chartGender = {};
            chartGender["Gender"] = gnd;
            chartGender["Farmer count"] = data.filter(ele => ele.form_data.field_5512 === gnd).length;
            gender344.push(chartGender);
        });
        $("#farmercount344").html(gender344.map(ele => ele["Farmer count"]).reduce((a,b) => (a+b), 0));
        // getBarChart("gender344", gender344, "Gender", "Farmer count", "Farmer count", "Registered farmers by gender");
        getStackedBarChart("gender344", gender344, "Gender", ["Farmer count"], "Registered farmers by gender");
    }).catch(err => {
        console.log(err);
        alert("Couldn't get farmers data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting344").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting344").empty();
}
const assignCurrentYear = async () => {
    $("#year344").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphFarmerData($("#year344").val(), $("#quarter344").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year344, #quarter344").on("change", async () => {
    await showWait();
    await graphFarmerData($("#year344").val(), $("#quarter344").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
