
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <style type="text/css">
        .form-control button {
            border: none !important;
        }
        .dropdown.pointer{
            display: inline;
        }
        .stricky{
            position: fixed;
            top: 53px;
            width: 100%;
            z-index: 111;
        }
        .search1 {
            position: absolute;
            right: 89px;
            top: 2px;
        }
        .filter-multi>button.ms-choice {
            display: block;
                width: 100%;
                height: 26px;
                padding: 0px;
                overflow: hidden;
                cursor: pointer;
                border: 0px solid #aaa;
                text-align: left;
                white-space: nowrap;
                line-height: 38px;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                background-color: #004b03!important;
        }
        .filter-multi.bg_drop {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 0.9375rem;
            line-height: 1.6;
            background-color: #004b03;
            background-clip: padding-box;
            border: 1px solid #d3dfea;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            border-radius: 5px;
            outline: 0;
            color: #4454c3;
            opacity: 1;
        }
        .form-control span {
            margin: 5px;
        }
        .shadow {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        @media only screen and (max-width: 600px){
        .stricky {
                position: relative;
                top: 4px;
                width: auto;
                z-index: 111;
            }
        }

    </style>

    <div class="app-content page-body mb-5">
        <div class="container-fluid">
            <div class="row stricky">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card bg_filters">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-8 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-11 col-lg-11">
                                            <div class="row">
                                                <div class="col-xs-4 col-md-3 col-lg-3 col-sm-12">
                                                    <div class="form-group">
                                                        <!-- <label class="form-label">Select Year</label> -->
                                                        <select name="year" placeholder="Select Year(s)" class="form-control">
                                                            <?php foreach ($year_list as $key => $year) {
                                                                $selected = ($key == 0) ? 'selected' : ''; ?>
                                                                <option value="<?php echo $year['year_id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $year['year']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-md-3 col-lg-3 col-sm-12">
                                                    <div class="form-group">
                                                        <!-- <label class="form-label">Select Program</label> -->
                                                        <select name="program" placeholder="Select Program" class="form-control"></select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-md-6 col-lg-6 col-sm-12">
                                                    <div class="form-group">
                                                        <!-- <label class="form-label">Select Cluster</label> -->
                                                        <select name="cluster" placeholder="Select Cluster" class="form-control"></select>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <select multiple="multiple" class="filter-multi  bg_drop"  title="All Clusters">
                                                        <option value="">2019</option>
                                                        <option value="">2020</option>
                                                        <option value="" selected>2021</option>
                                                    </select>
                                                </div>-->
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-12 col-md-1 col-lg-1">
                                            <button class="btn btn_apply">Apply</button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br/>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card mt-3 border-0">

                        <div class="card-header bg-white border-0">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <h4 class="title ind_count">INDICATORS </h4>
                                </div>
                                <!-- <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                                    <div class="d-flex justify-content-end">
                                        <div class="pr-3">
                                            <input class="form-control form_height" id="myInput" type="text"
                                                placeholder="Search.." style="width: 250px;border-radius: 30px;">
                                            <span class="search1"><img src="<?php echo base_url(); ?>include/assets/images/search.png"></span>
                                        </div>
                                        <div class="pr-3 pl-3">
                                            <ul class="nav nav-tabs border-0">
                                                <li class="pr-3 active"><a data-toggle="tab" href="#grid_view"><img
                                                            src="<?php echo base_url(); ?>include/assets/images/grid_active.png" height="19px"></a></li>
                                                <li><a data-toggle="tab" href="#list_view"><img
                                                            src="<?php echo base_url(); ?>include/assets/images/list_normal.png" height="19px"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="tab-content table_list">
                                <div id="grid_view" class="tab-pane active">
                                    <!-- <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="card shadow border-0">
                                                <div class="card-body pb-0">
                                                    <span class="title">RFSS 1.3.2
                                                        <span class="dropdown pointer">
                                                            <span class="dropdown-toggle grid" data-toggle="dropdown">
                                                                <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                            </span>
                                                            <ul class="dropdown-menu text_notification">
                                                                <li>Additional information that was added during
                                                                    recording the reading of this indicator would be
                                                                    shown on this overlay when user hover/clicks the ‘i’
                                                                    icon. </li>
                                                            
                                                            </ul>
                                                        </span>
                                                    </span>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <p class="font-12px"> Number of communities involved in pilots of climate-smart innovations and approaches</p>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="d-flex justify-content-around">
                                                                <div>
                                                                    <h4 class="text_small">Actual - <b
                                                                            class="font-12px">0</b></h4>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text_small">Target - <b
                                                                            class="font-12px">3</b></h4>
                                                                </div>
                                                            </div>
                                                            <div class="" id="chart_one"
                                                                style="width: 100%;height:150px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="card shadow border-0">
                                                <div class="card-body pb-0">
                                                    <span class="title">RFSS 2.1.2
                                                        <span class="dropdown pointer">
                                                            <span class="dropdown-toggle grid" data-toggle="dropdown">
                                                                <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                            </span>
                                                            <ul class="dropdown-menu text_notification">
                                                                <li>Additional information that was added during
                                                                    recording the reading of this indicator would be
                                                                    shown on this overlay when user hover/clicks the ‘i’
                                                                    icon. </li>
                                                            </ul>
                                                        </span>
                                                    </span>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <p class="font-12px"> Number of communities/farmers participating in the pilot</p>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="d-flex justify-content-around">
                                                                <div>
                                                                    <h4 class="text_small">Actual - <b
                                                                            class="font-12px">1500</b></h4>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text_small">Target - <b
                                                                            class="font-12px">5150</b></h4>
                                                                </div>
                                                            </div>
                                                            <div class="" id="chart_two"
                                                                style="width: 100%;height:150px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="card shadow border-0">
                                                <div class="card-body pb-0">
                                                    <span class="title">RFFS 3.1.2
                                                        <span class="dropdown pointer">
                                                            <span class="dropdown-toggle grid" data-toggle="dropdown">
                                                                <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                            </span>
                                                            <ul class="dropdown-menu text_notification">
                                                                <li>Additional information that was added during
                                                                    recording the reading of this indicator would be
                                                                    shown on this overlay when user hover/clicks the ‘i’
                                                                    icon. </li>
                                                            
                                                            </ul>
                                                        </span>
                                                    </span>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <p class="font-12px"> Number of communities/farmers benefitted because of the science-backed innovations in the learning sites </p>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="d-flex justify-content-around">
                                                                <div>
                                                                    <h4 class="text_small">Actual - <b
                                                                            class="font-12px">0</b></h4>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text_small">Target - <b
                                                                            class="font-12px">25200</b></h4>
                                                                </div>
                                                            </div>
                                                            <div class="" id="chart_three"
                                                                style="width: 100%;height:150px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="card shadow border-0">
                                                <div class="card-body pb-0">
                                                    <span class="title">RFFS 3.1.2
                                                        <span class="dropdown pointer">
                                                            <span class="dropdown-toggle grid" data-toggle="dropdown">
                                                                <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                            </span>
                                                            <ul class="dropdown-menu text_notification">
                                                                <li>Additional information that was added during
                                                                    recording the reading of this indicator would be
                                                                    shown on this overlay when user hover/clicks the ‘i’
                                                                    icon. </li>
                                                            
                                                            </ul>
                                                        </span>
                                                    </span>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <p class="font-12px"> Number of communities/farmers benefitted because of the science-backed innovations in the learning sites </p>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="d-flex justify-content-around">
                                                                <div>
                                                                    <h4 class="text_small">Actual - <b
                                                                            class="font-12px">0</b></h4>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text_small">Target - <b
                                                                            class="font-12px">25200</b></h4>
                                                                </div>
                                                            </div>
                                                            <div class="" id="chart_three"
                                                                style="width: 100%;height:150px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(function() {
            $('[name="year"]').on('change', function(event) {
                getProgram();
            }).multipleSelect({
                filter: true
            });

            $('[name="program"]').on('change', function(event) {
                getClusters();
            }).multipleSelect({
                filter: true
            });

            $('[name="cluster"]').on('change', function(event) {
                getProgramDetails();
            }).multipleSelect({
                filter: true
            });

            $('[name="year"]').trigger('change');
        });

        function getProgram() {
            $('[name="program"]').html('');

            // AJAX to get programs
            $.ajax({
                url: '<?php echo base_url(); ?>helper/get_program',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    year: $('[name="year"]').val()
                },
                error: function() {
                    $.toast({
                        stack: false,
                        icon: 'error',
                        position: 'bottom-right',
                        showHideTransition: 'slide',
                        heading: 'Network Error!',
                        text: 'Please check your internet connection.'
                    });
                },
                success: function(response) {
                    if (response.status == 0) {
                        $.toast({
                            stack: false,
                            icon: 'error',
                            position: 'bottom-right',
                            showHideTransition: 'slide',
                            heading: 'Error!',
                            text: response.msg
                        });
                        return false;
                    }
                    var programs = '';
                    var counter = 0;
                    var selected = "" + response.selected;
                    var selArr = selected.split(',');
                    response.pos.forEach(function(program, index) {
                        programs += '<option value="' + program.prog_id + '" >' + program.prog_name + '</option>';
                    });
                    $('[name="program"]').html(programs);

                    // Refresh options
                    $('[name="program"]').trigger('change');
                    $('[name="program"]').multipleSelect('refresh');
                }
            });
        }

        function getClusters(argument) {
            $('[name="cluster"]').html('');

            // AJAX to get programs
            $.ajax({
                url: '<?php echo base_url(); ?>helper/get_clusters',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    year: $('[name="year"]').val(),
                    program: $('[name="program"]').val()
                },
                error: function() {
                    $.toast({
                        stack: false,
                        icon: 'error',
                        position: 'bottom-right',
                        showHideTransition: 'slide',
                        heading: 'Network Error!',
                        text: 'Please check your internet connection.'
                    });
                },
                success: function(response) {
                    if (response.status == 0) {
                        $.toast({
                            stack: false,
                            icon: 'error',
                            position: 'bottom-right',
                            showHideTransition: 'slide',
                            heading: 'Error!',
                            text: response.msg
                        });
                        return false;
                    }
                    var clusters = '';
                    var counter = 0;
                    var selected = "" + response.selected;
                    var selArr = selected.split(',');
                    response.clusters.forEach(function(cluster, index) {
                        clusters += '<option value="' + cluster.cluster_id + '" >' + cluster.cluster_name + '</option>';
                    });
                    $('[name="cluster"]').html(clusters);

                    // Refresh options
                    $('[name="cluster"]').trigger('change');
                    $('[name="cluster"]').multipleSelect('refresh');
                }
            });
        }
        function getProgramDetails() {
            $('.table_list').html('');

            // AJAX to get po details
            $.ajax({
                url: '<?php echo base_url(); ?>helper/get_program_details',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    year: $('[name="year"]').val(),
                    program: $('[name="program"]').val(),
                    cluster: $('[name="cluster"]').val(),
                },
                error: function() {
                    $.toast({
                        stack: false,
                        icon: 'error',
                        position: 'bottom-right',
                        showHideTransition: 'slide',
                        heading: 'Network Error!',
                        text: 'Please check your internet connection.'
                    });
                },
                success: function(response) {
                    if (response.status == 0) {
                        if (response.msg && response.msg.length == 0) {
                            $.toast({
                                stack: false,
                                icon: 'error',
                                position: 'bottom-right',
                                showHideTransition: 'slide',
                                heading: 'Error!',
                                text: response.msg
                            });
                        }
                        return false;
                    }

                    // <div class="plus-minus-toggle collapsed" data-toggle="collapse" data-target="#indicator${$indicator['id']}"></div>
                    var user_role = <?php echo $this->session->userdata('role'); ?>;
                    var $po = response.po_list[0];
                    var name="";
                    var hname="";
                    var ind_count=0;
                    var cahrtids =[];
                    var HTML = `<div id="grid_view" class="tab-pane active">
                                    <div class="row">`;
                                    $po['cluster_list'].forEach(function($output, $key) {
                                        if ($output['indicator_list'].length > 0) {                                            
                                            $output['indicator_list'].forEach(function($indicator, $key) {
                                                
                                                name="";
                                                name= $indicator['title'];
                                                hname=name.substring(0, 17);
                                                // ${$po['prog_name']}
                                                HTML += `
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="card shadow border-0">
                                                        <div class="card-body pb-0">`;
                                                            HTML += `<span class="title"> ${hname}<span class="dropdown pointer">
                                                                    <span class="dropdown-toggle grid" data-toggle="dropdown">
                                                                        <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                                    </span>
                                                                    <ul class="dropdown-menu text_notification">
                                                                        <li>Additional information that was added during
                                                                            recording the reading of this indicator would be
                                                                            shown on this overlay when user hover/clicks the ‘i’
                                                                            icon. </li>
                                                                    </ul>
                                                                </span>
                                                            </span>
                                                            <div class="row mt-3">
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <p class="font-12px">${name}</p>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <div class="d-flex justify-content-around">
                                                                        <div>
                                                                            <h4 class="text_small">Actual - <b
                                                                                    class="font-12px">${$indicator['actual_count']}</b></h4>
                                                                        </div>
                                                                        <div>
                                                                            <h4 class="text_small">Target - <b
                                                                                    class="font-12px">${$indicator['target']}</b></h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="" id="${$indicator['id']}" style="width: 100%;height:150px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            // load_speedmeter($indicator['target']);
                                            number = $indicator['target'] <=0 ? 0 :($indicator['actual_count']/ $indicator['target'])*100;
                                            number = number > 100 ? 100 : Number(number.toFixed(2))
                                            cahrtids.push({chartid:$indicator['id'],number:number});
                                            });
                                        };
                                        ind_count =$output['indicator_list'].length
                                    });
                                HTML += `</div>
                                </div>`;

                    $('.table_list').html(HTML);
                    var HTML1 = `INDICATORS <small>(${ind_count})</small>`;
                    $('.ind_count').html(HTML1);
                    setTimeout(() => {
                        cahrtids.forEach(function(data, index) {
                            load_speedmeter(data['number'],data['chartid']);
                        });
                    });
                    
                    
                    // getPoDetailsCounters();
                }
            });
        }
    </script>
    
    <script>
       
        function load_speedmeter(data_count, meter_name) {
                
            var gaugeOptions = {
                chart: {
                    type: 'gauge'
                },

                title: null,

                pane: {
                    center: ['50%', '50%'],
                    size: '100%',
                    startAngle: -90,
                    endAngle: 90,
                    background: {
                        backgroundColor:
                            Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                        innerRadius: '100%',
                        outerRadius: '100%',
                        shape: 'arc'
                    }
                },

                exporting: {
                    enabled: false
                },

                tooltip: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                // the value axis
                yAxis: {
                    stops: [
                        [0.1, '#55BF3B'], // green
                        [0.5, '#DDDF0D'], // yellow
                        [0.9, '#DF5353'] // red
                    ],
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickInterval: null,
                    tickAmount: 0,
                    title: {
                        y: -40
                    },
                    labels: {
                        y: 0,
                        enabled: false
                    },
                    plotBands: [{
                        from: -40,
                        to: 0,
                        color: 'red'
                    }, {
                        from: 0,
                        to: 30,
                        color: '#ED553B'
                    },
                    {
                        from: 30,
                        to: 60,
                        color: 'gray'
                    }, {
                        from: 60,
                        to: 80,
                        color: 'green'
                    }, {
                        from: 80,
                        to: 120,
                        color: '#FFAA4C'
                    }]
                },

                plotOptions: {
                    gauge: {
                        dataLabels: {
                            y: 5,
                            borderWidth: 0,
                            useHTML: true
                        }
                    }
                }
            };

            var chartRpm = Highcharts.chart(meter_name, Highcharts.merge(gaugeOptions, {
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: '<span style="font-weight:bold;font-size:12px;color:green">'+[data_count]+'%</span>',
                        y: 50
                    }
                },

                series: [{
                    name: 'Target',
                    data: [data_count],
                    dataLabels: {
                        format:
                            '<div style="text-align:center">' +
                            '' +
                            '<span style="font-size:12px;opacity:0.4">' + '</div>'
                    },
                    tooltip: {
                        valueSuffix: ' revolutions/min'
                    }
                }]

            }));
        }
    </script>

    <!-- <script>
        var gaugeOptions = {
            chart: {
                type: 'gauge'
            },

            title: null,

            pane: {
                center: ['50%', '50%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '100%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#55BF3B'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#DF5353'] // red
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 0,
                title: {
                    y: -40
                },
                labels: {
                    y: 0,
                    enabled: false
                },
                plotBands: [{
                    from: -40,
                    to: 0,
                    color: 'red'
                }, {
                    from: 0,
                    to: 30,
                    color: '#ED553B'
                },
                {
                    from: 30,
                    to: 60,
                    color: 'gray'
                }, {
                    from: 60,
                    to: 80,
                    color: 'green'
                }, {
                    from: 80,
                    to: 120,
                    color: '#FFAA4C'
                }]
            },

            plotOptions: {
                gauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };



        // The RPM gauge
        var chartRpm = Highcharts.chart('chart_two', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: '<span style="font-weight:bold;font-size:12px;color:green">0%</span>',
                    y: 50
                }
            },

            series: [{
                name: 'Target',
                data: [29.12],
                dataLabels: {
                    format:
                        '<div style="text-align:center">' +
                        '' +
                        '<span style="font-size:12px;opacity:0.4">' + '</div>'
                },
                tooltip: {
                    valueSuffix: ' revolutions/min'
                }
            }]

        }));

    </script>

    <script>
        var gaugeOptions = {
            chart: {
                type: 'gauge'
            },

            title: null,

            pane: {
                center: ['50%', '50%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '100%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#55BF3B'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#DF5353'] // red
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 10,
                title: {
                    y: -40
                },
                labels: {
                    y: 0,
                    enabled: false
                },
                plotBands: [{
                    from: -40,
                    to: 0,
                    color: 'red'
                }, {
                    from: 0,
                    to: 30,
                    color: '#ED553B'
                },
                {
                    from: 30,
                    to: 60,
                    color: 'gray'
                }, {
                    from: 60,
                    to: 80,
                    color: 'green'
                }, {
                    from: 80,
                    to: 120,
                    color: '#FFAA4C'
                }]
            },

            plotOptions: {
                gauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };



        // The RPM gauge
        var chartRpm = Highcharts.chart('chart_three', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: '<span style="font-weight:bold;font-size:12px;color:green">0%</span>',
                    y: 50
                }
            },

            series: [{
                name: 'Target',
                data: [0],
                dataLabels: {
                    format:
                        '<div style="text-align:center">' +
                        '' +
                        '<span style="font-size:12px;opacity:0.4">' + '</div>'
                },
                tooltip: {
                    valueSuffix: ' revolutions/min'
                }
            }]

        }));
    </script>

    <script>
        var gaugeOptions = {
            chart: {
                type: 'gauge'
            },

            title: null,

            pane: {
                center: ['50%', '50%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '100%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#55BF3B'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#DF5353'] // red
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 10,
                title: {
                    y: -40
                },
                labels: {
                    y: 0,
                    enabled: false
                },
                plotBands: [{
                    from: -40,
                    to: 0,
                    color: 'red'
                }, {
                    from: 0,
                    to: 30,
                    color: '#ED553B'
                },
                {
                    from: 30,
                    to: 60,
                    color: 'gray'
                }, {
                    from: 60,
                    to: 80,
                    color: 'green'
                }, {
                    from: 80,
                    to: 120,
                    color: '#FFAA4C'
                }]
            },

            plotOptions: {
                gauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };



        // The RPM gauge
        var chartRpm = Highcharts.chart('chart_four', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: '<span style="font-weight:bold;font-size:12px;color:green">0%</span>',
                    y: 50
                }
            },

            series: [{
                name: 'Target',
                data: [0],
                dataLabels: {
                    format:
                        '<div style="text-align:center">' +
                        '' +
                        '<span style="font-size:12px;opacity:0.4">' + '</div>'
                },
                tooltip: {
                    valueSuffix: ' revolutions/min'
                }
            }]

        }));

    </script> -->
