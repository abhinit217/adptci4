const script = document.getElementById('dashboard_api');
const baseURL = script.getAttribute('data-baseurl');

const rootUrl = baseURL+"api/taat_hib/get_surveydata";

const getSurveyData = (survey_id) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: rootUrl,
            data: {"survey_id": survey_id},
            success: (response) => {
                delete response["status"];
                response["survey_data"].forEach(ele => {
                    ele["form_data"] = JSON.parse(ele["form_data"]);
                });
                resolve(response.survey_data);
            },
            error: (err) =>{
                reject(err);
                alert(`Cannot connect to the path ${rootUrl}`);
            }
        });
    });
}

const countryCodes = {
    "1" : "India",
    "2" : "Burkina Faso",
    "3" : "Kenya",
    "4" : "Malawi",
    "5" : "Tanzania",
    "6" : "Uganda",
    "7" : "Zimbabwe",
    "8" : "DR Congo",
    "9" : "Burundi",
    "10" : "Rwanda",
    "11" : "Chad",
    "12" : "Mali",
    "13" : "Niger",
    "14" : "Nigeria",
    "15" : "Senegal",
    "16" : "Sudan"
};
