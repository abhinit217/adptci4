const getBeneficiaryData = async (selectedYear, selectedQuarter) => {
    const allSurveyIds = ["334", "337", "338", "340", "342", "344"];
    let totalBeneficiaries = 0;
    Promise.all(allSurveyIds).then(surveys => {
        surveys.forEach(survey => {
            getSurveyData(survey).then(surveyData => {
                let formData = surveyData.map(ele => ele.form_data);
                let data;
                switch(survey){
                    case "334":
                        data = selectedQuarter
                               ? formData.filter(ele => ele.field_10004 && ele.field_10004 === selectedYear && ele.field_10003 && ele.field_10003 === selectedQuarter)
                               : formData.filter(ele => ele.field_10004 && ele.field_10004 === selectedYear);
                        totalBeneficiaries += data.map(ele => ele.field_5662? parseInt(ele.field_5662) : 0).reduce((a, b) => (a+b), 0) +
                                             data.map(ele => ele.field_5663? parseInt(ele.field_5663) : 0).reduce((a, b) => (a+b), 0);
                        break;
                    
                    case "337":
                        data = selectedQuarter
                                ? formData.filter(ele => ele.field_10013 && ele.field_10013 === selectedYear && ele.field_10012 && ele.field_10012 === selectedQuarter)
                                : formData.filter(ele => ele.field_10013 && ele.field_10013 === selectedYear);
                        totalBeneficiaries += data.map(ele => ele.field_5430? parseInt(ele.field_5430) : 0).reduce((a, b) => (a+b), 0) +
                                             data.map(ele => ele.field_5431? parseInt(ele.field_5431) : 0).reduce((a, b) => (a+b), 0);
                        break;
                    
                    case "338":
                        data = selectedQuarter
                                ? formData.filter(ele => ele.field_10016 && ele.field_10016 === selectedYear && ele.field_10015 && ele.field_10015 === selectedQuarter)
                                : formData.filter(ele => ele.field_10016 && ele.field_10016 === selectedYear);
                        totalBeneficiaries += data.map(ele => ele.field_5700? parseInt(ele.field_5700) : 0).reduce((a, b) => (a+b), 0) +
                                              data.map(ele => ele.field_5701? parseInt(ele.field_5701) : 0).reduce((a, b) => (a+b), 0);
                        break;
                    
                    case "340":
                        data = selectedQuarter
                                ? formData.filter(ele => ele.field_10022 && ele.field_10022 === selectedYear && ele.field_10021 && ele.field_10021 === selectedQuarter)
                                : formData.filter(ele => ele.field_10022 && ele.field_10022 === selectedYear);
                        totalBeneficiaries += data.map(ele => ele.field_5723? parseInt(ele.field_5723) : 0).reduce((a, b) => (a+b), 0) +
                                              data.map(ele => ele.field_5724? parseInt(ele.field_5724) : 0).reduce((a, b) => (a+b), 0);
                        break;
                    
                    case "342":
                        data = selectedQuarter
                                ? formData.filter(ele => ele.field_10025 && ele.field_10025 === selectedYear && ele.field_10024 && ele.field_10024 === selectedQuarter)
                                : formData.filter(ele => ele.field_10025 && ele.field_10025 === selectedYear);
                        totalBeneficiaries += data.map(ele => ele.field_5775? parseInt(ele.field_5775) : 0).reduce((a, b) => (a+b), 0) +
                                              data.map(ele => ele.field_5776? parseInt(ele.field_5776) : 0).reduce((a, b) => (a+b), 0);
                        break;

                    case "344":
                        data = selectedQuarter
                                ? formData.filter(ele => ele.field_10028 && ele.field_10028 === selectedYear && ele.field_10027 && ele.field_10027 === selectedQuarter)
                                : formData.filter(ele => ele.field_10028 && ele.field_10028 === selectedYear);
                        totalBeneficiaries += data.filter(ele => ele.field_5512 && ele.field_5512 === "Male").length +
                                              data.filter(ele => ele.field_5512 && ele.field_5512 === "Female").length
                        break;
                }
            }).then(() => {
                $("#beneficiarycount433").html(totalBeneficiaries);
            }).catch(err => {
                console.log(err);
                alert("Couldn't get seeds data");
            });
        })
    });
}


// DOM
const showWait = async () => {
    $("#waiting433").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting433").empty();
}
const assignCurrentYear = async () => {
    $("#year433").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await getBeneficiaryData($("#year433").val(), $("#quarter433").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year433, #quarter433").on("change", async () => {
    await showWait();
    await getBeneficiaryData($("#year433").val(), $("#quarter433").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
