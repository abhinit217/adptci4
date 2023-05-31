const graphSeedData = async (selectedYear, selectedQuarter) => {
    getSurveyData("355").then(surveyData => {
        let data = selectedQuarter
                   ? surveyData.filter(ele => ele.form_data.field_10031 === selectedYear && ele.form_data.field_10030 === selectedQuarter)
                   : surveyData.filter(ele => ele.form_data.field_10031 === selectedYear);
        $("#breedercount355").html(data.map(ele => ele.form_data.field_5797 ? parseFloat(ele.form_data.field_5797) : 0).reduce((a, b) => (a+b), 0));
        $("#basiccount355").html(data.map(ele => ele.form_data.field_5803 ? parseFloat(ele.form_data.field_5803) : 0).reduce((a, b) => (a+b), 0));
        $("#foundationcount355").html(data.map(ele => ele.form_data.field_5799 ? parseFloat(ele.form_data.field_5799) : 0).reduce((a, b) => (a+b), 0));
        $("#certifiedcount355").html(data.map(ele => ele.form_data.field_5801 ? parseFloat(ele.form_data.field_5801) : 0).reduce((a, b) => (a+b), 0));
        
        let countries = Array.from(new Set(data.map(ele => ele.country_id)));
        let seedTypes355 = [];
        countries.forEach(country => {
            let chartSeedTypes = {};
            let countryItem = data.filter(el => el.country_id === country);
            chartSeedTypes["Breeder"] = countryItem.map(ele => ele.form_data.field_5797 ? parseFloat(ele.form_data.field_5797) : 0).reduce((a, b) => (a+b), 0)/1000;
            chartSeedTypes["Basic"] = countryItem.map(ele => ele.form_data.field_5803 ? parseFloat(ele.form_data.field_5803) : 0).reduce((a, b) => (a+b), 0);
            chartSeedTypes["Foundation"] = countryItem.map(ele => ele.form_data.field_5799 ? parseFloat(ele.form_data.field_5799) : 0).reduce((a, b) => (a+b), 0);
            chartSeedTypes["Certified"] = countryItem.filter(el => el.country_id === country).map(ele => ele.form_data.field_5801 ? parseFloat(ele.form_data.field_5801) : 0).reduce((a, b) => (a+b), 0);
            chartSeedTypes["Country"] = country ? countryCodes[country] : "Unspecified";
            seedTypes355.push(chartSeedTypes);
        });
        getStackedBarChart("countrywise355", seedTypes355, "Country", ["Breeder", "Basic", "Foundation", "Certified"], "Country wise production of all the 4 category of seed (all in Tons)");

        let allProducerTypes = Array.from(new Set(data.map(ele => {
            let breederProducer = ele.form_data.field_5798.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").split(",");
            let foundationProducer = ele.form_data.field_5800.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").split(",");
            let certifiedProducer = ele.form_data.field_5802.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").split(",");
            let basicProducer = ele.form_data.field_5804.replace(/\[/, "").replace(/\]/, "").replace(/\"/g, "").replace(/\" /g, "\"").replace(/&#44;/g, ",").split(",");
            return breederProducer.concat(foundationProducer.concat(certifiedProducer.concat(basicProducer)));
        }).flat()));
        
        let producerTypes355 = [];
        allProducerTypes.forEach(type => {
            let chartProducerType = {};
            chartProducerType["Producer"] = type;
            chartProducerType["Breeder"] = data.filter(el => el.form_data.field_5798.includes(type)).map(ele => ele.form_data.field_5797 ? parseFloat(ele.form_data.field_5797): 0).reduce((a, b) => (a+b), 0)/1000;
            chartProducerType["Foundation"] = data.filter(el => el.form_data.field_5800.includes(type)).map(ele => ele.form_data.field_5799 ? parseFloat(ele.form_data.field_5799): 0).reduce((a, b) => (a+b), 0);
            chartProducerType["Certified"] = data.filter(el => el.form_data.field_5802.includes(type)).map(ele => ele.form_data.field_5801 ? parseFloat(ele.form_data.field_5801): 0).reduce((a, b) => (a+b), 0);
            chartProducerType["Basic"] = data.filter(el => el.form_data.field_5804.includes(type)).map(ele => ele.form_data.field_5803 ? parseFloat(ele.form_data.field_5803): 0).reduce((a, b) => (a+b), 0);
            producerTypes355.push(chartProducerType);
        });
        getStackedBarChart("producertype355", producerTypes355, "Producer", ["Breeder", "Basic", "Foundation", "Certified"], "Key producer wise seed production (all in Tons)");

        let breederProd355 = [], foundationProd355 = [], certifiedProd355 = [], basicProd355 = [];
        allProducerTypes.forEach(type => {
            let chartBreederProd = {}, chartFoundationProd = {}, chartCertifiedProd = {}, chartBasicProd = {};
            [chartBreederProd, chartFoundationProd, chartCertifiedProd, chartBasicProd].forEach(ele => ele["Producer"] = type);
            chartBreederProd["Quantity (Kg)"] = data.filter(el => el.form_data.field_5798.includes(type)).map(ele => ele.form_data.field_5797 ? parseFloat(ele.form_data.field_5797): 0).reduce((a, b) => (a+b), 0);
            chartFoundationProd["Quantity (T)"] = data.filter(el => el.form_data.field_5800.includes(type)).map(ele => ele.form_data.field_5799 ? parseFloat(ele.form_data.field_5799): 0).reduce((a, b) => (a+b), 0);
            chartCertifiedProd["Quantity (T)"] = data.filter(el => el.form_data.field_5802.includes(type)).map(ele => ele.form_data.field_5801 ? parseFloat(ele.form_data.field_5801): 0).reduce((a, b) => (a+b), 0);
            chartBasicProd["Quantity (T)"] = data.filter(el => el.form_data.field_5804.includes(type)).map(ele => ele.form_data.field_5803 ? parseFloat(ele.form_data.field_5803): 0).reduce((a, b) => (a+b), 0);
            
            breederProd355.push(chartBreederProd);
            foundationProd355.push(chartFoundationProd);
            certifiedProd355.push(chartCertifiedProd);
            basicProd355.push(chartBasicProd);
            
        });
        // getBarChart("breeder355", breederProd355, "Producer", "quantity", "Quantity (Kg)", "Category-wise key producer for breeder seed");
        // getBarChart("foundation355", foundationProd355, "Producer", "quantity", "Quantity (T)", "Category-wise key producer for foundation seed");
        // getBarChart("certified355", certifiedProd355, "Producer", "quantity", "Quantity (T)", "Category-wise key producer for certified seed");
        // getBarChart("basic355", basicProd355, "Producer", "quantity", "Quantity (T)", "Category-wise key producer for basic seed");

        getStackedBarChart("breeder355", breederProd355, "Producer", ["Quantity (Kg)"],  "Category-wise key producer for breeder seed");
        getStackedBarChart("foundation355", foundationProd355, "Producer", ["Quantity (T)"],  "Category-wise key producer for foundation seed");
        getStackedBarChart("certified355", certifiedProd355, "Producer", ["Quantity (T)"],  "Category-wise key producer for certified seed");
        getStackedBarChart("basic355", basicProd355, "Producer", ["Quantity (T)"], "Category-wise key producer for basic seed");

    }).catch(err => {
        console.log(err);
        alert("Couldn't get seeds data");
    });
}

// DOM
const showWait = async () => {
    $("#waiting355").html("Please wait while the data is being filtered...")
}
const hideWait = async() => {
    $("#waiting355").empty();
}
const assignCurrentYear = async () => {
    $("#year355").val(new Date().getFullYear().toString());
}
$(window).on("load", async () => {
    await assignCurrentYear();
    await showWait();
    await graphSeedData($("#year355").val(), $("#quarter355").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
$("#year355, #quarter355").on("change", async () => {
    await showWait();
    await graphSeedData($("#year355").val(), $("#quarter355").val());
    setTimeout(async () => {await hideWait();}, 1000);
});
