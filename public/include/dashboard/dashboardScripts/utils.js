const loadingIcon = `<div class="text-center">
    <div class="fa-3x mb-1">
        <i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>
    </div>
    <span>Loading</span>
</div>`;

const startWaiting = () => {
    $("#loading-modal-container").empty().html(loadingIcon);
    $("#loading-modal").modal("show");
}

const stopWaiting = () => {
    $("#loading-modal-container").empty();
    $("#loading-modal").modal("hide");
}

const highchartsDefaults = {
    chart: {style: {fontFamily: 'Open Sans, sans-serif'}},
    labels: {style: {fontFamily: 'Open Sans, sans-serif'}},
    tooltip: {style: {fontFamily: 'Open Sans, sans-serif'}},
    xAxis: {labels: {style: {fontFamily: 'Open Sans, sans-serif'}}},
    yAxis: {labels: {style: {fontFamily: 'Open Sans, sans-serif'}}}
};

Highcharts.setOptions(highchartsDefaults);