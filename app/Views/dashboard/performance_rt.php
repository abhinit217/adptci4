
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
        #belowdiv {
            position:relative;
            top:420px;
        }
        /* .multiselect-selected-text{
            display: inline-block;
            max-width: 100%;
            word-break: break-all;
            white-space: normal;
        }
        .multiselect {
            white-space: normal !important;
            max-width: 200px;
        } */

    </style>
    <style>
    .clear{
	clear:both;
	margin-top: 20px;
   }
   
   #searchResult{
	list-style: none;
	padding: 0px;
	width: 250px;
	position: absolute;
	margin: 0;
   }
   
   #searchResult li{
	background: lavender;
	/* padding: 4px; */
	margin-bottom: 1px;
   }
   
   #searchResult li:nth-child(even){
	background: cadetblue;
	color: white;
   }
   
   #searchResult li:hover{
	cursor: pointer;
   }
   
   /* .ms-parent input[type=text]{
	padding: 5px;
	width: 700px;
	letter-spacing: 1px;
   } */
   .ms-drop ul > li.hide-radio label {
        margin-bottom: 0;
        padding: 5px 8px;
        white-space: inherit;
    }
    .ms-drop {
        z-index: 9 !important;
        left: 0;
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
                                                                $selected = ($key == 1) ? 'selected' : ''; ?>
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
                                                        <select name="cluster" id="cluster" placeholder="Select Cluster" multiple class="form-control"></select>
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
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <h4 class="title ind_count">INDICATORS </h4>
                                </div>
                                <div class=" col-sm-12 col-xs-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <!-- <span class="search"><img src="<?php echo base_url(); ?>include/assets/images/search.png"></span> -->
                                        <select name="search" id="searcht2" placeholder="Search ..." class="form-control">
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 text-right">
                                    <div class="d-flex justify-content-end">
                                        <!-- <div class="pr-3">
                                            <input class="form-control form_height" id="myInput" type="text"
                                                placeholder="Search.." style="width: 250px;border-radius: 30px;">
                                            <span class="search1"><img src="<?php echo base_url(); ?>include/assets/images/search.png"></span>
                                        </div> -->
                                        <div class="pr-3 pl-3">
                                            <ul class="nav nav-tabs border-0">
                                                <li class="pr-3 active"><a onclick="gridView();" href="#" ><img
                                                            src="<?php echo base_url(); ?>include/assets/images/grid_active.png" height="19px"></a></li>
                                                <!-- <li class="pr-3 active"><a data-toggle="tab" href="#grid_view"><img
                                                            src="<?php echo base_url(); ?>include/assets/images/grid_active.png" height="19px"></a></li> -->
                                                <li><a onclick="listView();" href="#" ><img
                                                            src="<?php echo base_url(); ?>include/assets/images/list_normal.png" height="19px"></a></li>
                                                <!-- <li><a href="<?php echo base_url(); ?>dashboard/performance_list/" ><img
                                                            src="<?php echo base_url(); ?>include/assets/images/list_normal.png" height="19px"></a></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
            if($('#grid_view.tab-pane').hasClass('active')){
                getProgramDetails();
            }else{
                getProgramDetailsList();
            }
            getIndicatorList();
        }).multipleSelect({
            filter: true
        });

        $('[name="year"]').trigger('change');
        $('[name="search"]').on('change', function(event) {
            if($('#grid_view.tab-pane').hasClass('active')){
                getProgramDetails();
            }else{
                getProgramDetailsList();
            }
        }).multipleSelect({
            filter: true
        });
        
       
    });



    function getIndicatorList() {
        $('[name="search"]').html('');

        // AJAX to get programs
        $.ajax({
            url: '<?php echo base_url(); ?>result_tracker/get_indicator_list',
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
                programs += '<option value="" >Search Indicator ... </option>';
                response.pos.forEach(function(program, index) {
                    programs += '<option value="' + program.id + '" >' + program.title + '</option>';
                });
                $('[name="search"]').html(programs);

                // Refresh options
                // $('[name="search"]').trigger('change');
                $('[name="search"]').multipleSelect('refresh');
            }
        });
    }
    function getProgram() {
        $('[name="program"]').html('');

        // AJAX to get programs
        $.ajax({
            url: '<?php echo base_url(); ?>result_tracker/get_program',
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
            url: '<?php echo base_url(); ?>result_tracker/get_clusters',
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
                    clusters += '<option value="' + cluster.cluster_id + '" selected>' + cluster.cluster_name + '</option>';
                });
                $('[name="cluster"]').html(clusters);

                // Refresh options
                $('[name="cluster"]').trigger('change');
                $('[name="cluster"]').multipleSelect('refresh');
            }
        });
    }
    function listView() {
        getProgramDetailsList();
    }
    function gridView() {
        getProgramDetails();
    }
    function getProgramDetails() {
        $('.table_list').html('');
        const clusterdata =$('[name="cluster"]').val();
        const clusterdata2 =clusterdata.length;
        if($('[name="search"]').val()){
            // $("#cluster").multiselect("deselectAll", false);
            
        }
        // else{
        //     $("#search").multiselect("deselectAll", false);
        // }
        // AJAX to get po details
        if(clusterdata2 > 0){
            $.ajax({
                url: '<?php echo base_url(); ?>result_tracker/get_program_details',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    year: $('[name="year"]').val(),
                    program: $('[name="program"]').val(),
                    cluster: $('[name="cluster"]').val(),
                    indicator: $('[name="search"]').val()
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

                    // <div class="plus-minus-toggle collapsed" data-toggle="collapse" data-target="#indicator${indicator['id']}"></div>
                    var user_role = <?php echo $this->session->userdata('role'); ?>;
                    var $po = response.po_list[0];
                    var name="";
                    var hname="";
                    var name2="";
                    var color="green";
                    var ind_count=0;
                    var cahrtids =[]; 
                    var name2="";
                    var hname2="";
                    var name22="";
                    var color2="green";
                    var ind_count2=0;
                    var cahrtids1 =[];                
                    var HTML = `
                        <div id="grid_view" class="tab-pane active">
                            <div class="row">`;
                            $po['cluster_list'].forEach(function($output, $key) {
                                if ($output['indicator_list'].length > 0) {  
                                    if($output['cluster_id'] == 7) {
                                        name="Indicator #7.1.1 Number of Market-informed gender-responsive product profiles developed";
                                        hname=name.substring(0, 17);
                                        name2=name.substring(17,91);
                                        HTML += `
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <div class="card shadow border-0">
                                                    <div class="card-body pb-0">`;
                                                        HTML += `
                                                        <div class="row">
                                                            <div class="col-sm-12 col-lg-6">
                                                                <span class="title"> ${hname} 
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
                                                            </div>
                                                            <div class="col-sm-12 col-lg-6">
                                                                <div class="d-flex justify-content-around flex-wrap">
                                                                    <div >
                                                                        <h4 class="text_small text-success">Target - <b
                                                                                class="font-12px">57</b></h4>
                                                                    </div>
                                                                    
                                                                    <div>
                                                                        <h4 class="text_small text-info">Actual - <b
                                                                                class="font-12px">${$output['14_actual_count']}</b></h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                            <div class="row mt-3">
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <span class="font-12px text-left">${name2}
                                                                        <span class="dropdown-toggle grid text-primary" data-toggle="dropdown">
                                                                            more...
                                                                        </span>
                                                                        <ul class="dropdown-menu text_notification">
                                                                            <li>${name} </li>
                                                                        </ul>
                                                                    </span>
                                                                        <div >
                                                                            <h4 class="text_small mt-3" style="color:blue;">Uploads - <b
                                                                                    class="font-12px">${$output['14_record_count']}</b></h4>
                                                                        </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <div class="" id="14_1" style="width: 100%;height:130px;"></div>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>`;
                                            // number = 0;
                                            number = 57 <=0 ? 0 : ($output['14_actual_count']/ 57)*100;
                                            number = number.toFixed(2);
                                            number1 = number > 100 ? 100 : number;
                                            color = number <= 1 ? "gray" : number <= 60 ? "red" : number <= 85 ? "#FFAA4C" : number <= 100 ? "green" : number > 100 ? "blue":"green";
                                            // color = number <= 60 ? "red" : "green";
                                            cahrtids.push({chartid:'14_1',number:number,number1:number1,color:color});
                                    }                                         
                                    $output['indicator_list'].forEach(function(indicator, $key) {
                                        
                                        if(Array.isArray(indicator['derived_inds']) && indicator['derived_inds'].length){
                                        // array exists and is not empty
                                        indicator['derived_inds'].forEach(function($d_indicator, $d_key) {
                                            ind_count++;
                                            name="";
                                            name= $d_indicator['d_title'].replace(':', "");
                                            hname=name.substring(0, 17);
                                            name2=name.substring(17,91);
                                            HTML += `
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <div class="card shadow border-0">
                                                    <div class="card-body pb-0">`;
                                                        HTML += `
                                                        <div class="row">
                                                            <div class="col-sm-12 col-lg-6">
                                                                <span class="title"> ${hname}
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
                                                            </div>
                                                            <div class="col-sm-12 col-lg-6">
                                                                <div class="d-flex justify-content-around flex-wrap">
                                                                    <div >
                                                                        <h4 class="text_small text-success">Target - <b
                                                                                class="font-12px">${$d_indicator['d_target']}</b></h4>
                                                                    </div>
                                                                    
                                                                    <div>
                                                                        <h4 class="text_small text-info">Actual - <b
                                                                                class="font-12px">${$d_indicator['d_actual_count']}</b></h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                            <div class="row mt-3">
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <span class="font-12px text-left">${name2}
                                                                        <span class="dropdown-toggle grid text-primary" data-toggle="dropdown">
                                                                            more...
                                                                        </span>
                                                                        <ul class="dropdown-menu text_notification">
                                                                            <li>${name} </li>
                                                                        </ul>
                                                                    </span>
                                                                        <div >
                                                                            <h4 class="text_small mt-3" style="color:blue;">Uploads - <b
                                                                                    class="font-12px">${indicator['record_count']}</b></h4>
                                                                        </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <div class="" id="${$d_indicator['d_ind_id']}" style="width: 100%;height:130px;"></div>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>`;
                                            // load_speedmeter(indicator['target']);
                                            number = $d_indicator['d_target'] <=0 ? 0 :($d_indicator['d_actual_count']/ $d_indicator['d_target'])*100;
                                            number = Number(number.toFixed(2));
                                            number1 = number > 100 ? 100 : number;
                                            color = number <= 1 ? "gray" : number <= 60 ? "red" : number <= 85 ? "#FFAA4C" : number <= 100 ? "green" : number > 100 ? "blue":"green";
                                            // color = number <= 60 ? "red" : "green";
                                            cahrtids.push({chartid:$d_indicator['d_ind_id'],number:number,number1:number1,color:color});
                                            });
                                        }else{
                                            ind_count++;
                                            name="";
                                            name= indicator['title'].replace(':', "");
                                            hname=name.substring(0, 17);
                                            name2=name.substring(17,91);
                                            // ${$po['prog_name']}
                                            HTML += `
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <div class="card shadow border-0">
                                                    <div class="card-body pb-0">`;
                                                        HTML += `
                                                        <div class="row">
                                                            <div class="col-sm-12 col-lg-6">
                                                                <span class="title"> ${hname}
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
                                                            </div>
                                                            <div class="col-sm-12 col-lg-6">
                                                                <div class="d-flex justify-content-around flex-wrap">
                                                                    <div >
                                                                        <h4 class="text_small text-success">Target - <b
                                                                                class="font-12px">${indicator['target']}</b></h4>
                                                                    </div>
                                                                    
                                                                    <div>
                                                                        <h4 class="text_small text-info">Actual - <b
                                                                                class="font-12px">${indicator['actual_count']}</b></h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                            <div class="row mt-3">
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <span class="font-12px text-left">${name2}
                                                                        <span class="dropdown-toggle grid text-primary" data-toggle="dropdown">
                                                                            more...
                                                                        </span>
                                                                        <ul class="dropdown-menu text_notification">
                                                                            <li>${name} </li>
                                                                        </ul>
                                                                    </span>
                                                                        <div >
                                                                            <h4 class="text_small mt-3" style="color:blue;">Uploads - <b
                                                                                    class="font-12px">${indicator['record_count']}</b></h4>
                                                                        </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <div class="" id="${indicator['id']}" style="width: 100%;height:130px;"></div>
                                                                </div>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>`;
                                            // load_speedmeter(indicator['target']);
                                            number = indicator['target'] <=0 ? 0 :(indicator['actual_count']/ indicator['target'])*100;
                                            number = Number(number.toFixed(2));
                                            number1 = number > 100 ? 100 : number;
                                            color = number <= 1 ? "gray" : number <= 60 ? "red" : number <= 85 ? "#FFAA4C" : number <= 100 ? "green" : number > 100 ? "blue":"green";
                                            // color = number <= 60 ? "red" : "green";
                                            cahrtids.push({chartid:indicator['id'],number:number,number1:number1,color:color});
                                        }
                                    });
                                };
                                // ind_count =$output['indicator_list'].length
                            });
                        HTML += `</div>
                        </div>`;

                    
                    
                    $('.table_list').html(HTML);
                    // var HTML1 = `INDICATORS <small>(${ind_count})</small>`;
                    var HTML1 = `INDICATORS <small>(${ind_count})</small>`;
                    $('.ind_count').html(HTML1);
                    setTimeout(() => {
                        cahrtids.forEach(function(data, index) {
                            load_speedmeter(data['number'],data['number1'],data['chartid'],data['color']);
                        });
                    });
                    
                    
                    // getPoDetailsCounters();
                }
            });
        }else{
            var HTML =`<div>Please select clusters</div>`;
            $('.table_list').html(HTML);
            var HTML1 = `INDICATORS <small>(0)</small>`;
                    $('.ind_count').html(HTML1);
        }
    }
    function getProgramDetailsList() {
        $('.table_list').html('');

        // AJAX to get po details
        $.ajax({
            url: '<?php echo base_url(); ?>result_tracker/get_program_details',
            type: 'POST',
            dataType: 'JSON',
            data: {
                year: $('[name="year"]').val(),
                program: $('[name="program"]').val(),
                cluster: $('[name="cluster"]').val(),
                indicator: $('[name="search"]').val()
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

                // <div class="plus-minus-toggle collapsed" data-toggle="collapse" data-target="#indicator${indicator['id']}"></div>
                var user_role = <?php echo $this->session->userdata('role'); ?>;
                var $po = response.po_list[0];
                var name="";
                var hname="";
                var name2="";
                var color="green";
                var ind_count=0;
                var cahrtids =[]; 
                var name2="";
                var hname2="";
                var name22="";
                var color2="green";
                var ind_count2=0;
                var cahrtids1 =[];                
                var HTML = `
                    <div id="list_view" class="tab-pane active">
                        <div class="row">`;
                        $po['cluster_list'].forEach(function($output, $key) {
                            if ($output['indicator_list'].length > 0) {  
                                if($output['cluster_id'] == 7) {
                                    name="Indicator #7.1.1 Number of Market-informed gender-responsive product profiles developed";
                                    hname=name.substring(0, 17);
                                    name2=name.substring(17,91);
                                    number = 57 <=0 ? 0 : ($output['14_actual_count']/ 57)*100;
                                    number = number.toFixed(2);
                                    number1 = number > 100 ? 100 : number;
                                    color = number <= 1 ? "gray" : number <= 60 ? "red" : number <= 85 ? "#FFAA4C" : number <= 100 ? "green" : number > 100 ? "blue":"green";

                                        HTML += `
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="card border-0 shadow mb-3">
                                                    <div class="card-body pb-0">`;
                                                        HTML += `
                                                        <div class="row">
                                                            <div class="col-sm-12 col-lg-12">
                                                                <span class="title mb-1"> ${hname}
                                                                    <span class="dropdown pointer">
                                                                        <span class="dropdown-toggle grid"
                                                                            data-toggle="dropdown">
                                                                            <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                                        </span>
                                                                        <ul class="dropdown-menu text_notification">
                                                                            <li>${name}</li>
                                                                        </ul>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-6">
                                                                <p class="font-12px text-left">${name}</p>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-1">
                                                                <div class="text-center"><span class="target_text text-success">Target</span></div>
                                                                <div class="text-center"><span class="target_count">57</span></div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-1">
                                                                <div class="text-center"><span class="actual_text text-info">Actual</span></div>
                                                                <div class="text-center"><span class="actual_count">${$output['14_actual_count']}</span></div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-1">
                                                                <div class="text-center"><span class="actual_text" style="color:blue;">Uploads</span></div>
                                                                <div class="text-center"><span class="actual_count">${$output['14_record_count']}</span></div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-2">
                                                                <div class="" id="14_1"
                                                                    style="width: 100%;height:80px; margin-top: -9px;"></div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-1">
                                                            <span class="actual_text" ><span
                                                                        class="actual_count" style="color:`+color+`;">`+number+`%</span></span>
                                                            </div>  
                                                        </div>                                              
                                                    </div>
                                                </div>
                                            </div>`;
                                        cahrtids.push({chartid:'14_1',number:number,number1:number1,color:color});
                                }                                         
                                $output['indicator_list'].forEach(function(indicator, $key) {
                                    if(Array.isArray(indicator['derived_inds']) && indicator['derived_inds'].length){
                                        // array exists and is not empty
                                        indicator['derived_inds'].forEach(function($d_indicator, $d_key) {
                                            ind_count++;
                                            name="";
                                            name= $d_indicator['d_title'].replace(':', "");
                                            hname=name.substring(0, 17);
                                            name2=name.substring(17,91);
                                            number = $d_indicator['d_target'] <=0 ? 0 :($d_indicator['d_actual_count']/ $d_indicator['d_target'])*100;
                                            number = Number(number.toFixed(2));
                                            number1 = number > 100 ? 100 : number;
                                            color = number <= 1 ? "gray" : number <= 60 ? "red" : number <= 85 ? "#FFAA4C" : number <= 100 ? "green" : number > 100 ? "blue":"green";
                                            HTML += `
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="card border-0 shadow mb-3">
                                                        <div class="card-body pb-0">`;
                                                            HTML += `
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-12">
                                                                    <span class="title mb-1"> ${hname}
                                                                        <span class="dropdown pointer">
                                                                            <span class="dropdown-toggle grid"
                                                                                data-toggle="dropdown">
                                                                                <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                                            </span>
                                                                            <ul class="dropdown-menu text_notification">
                                                                                <li>${name}</li>
                                                                            </ul>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <p class="font-12px text-left">${name}</p>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="target_text text-success">Target</span></div>
                                                                    <div class="text-center"><span class="target_count">${$d_indicator['d_target']}</span></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="actual_text text-info">Actual</span></div>
                                                                    <div class="text-center"><span class="actual_count">${$d_indicator['d_actual_count']}</span></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="actual_text" style="color:blue;">Uploads</span></div>
                                                                    <div class="text-center"><span class="actual_count">${indicator['record_count']}</span></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-2">
                                                                    <div class="" id="`+$d_indicator['d_ind_id']+`"
                                                                        style="width: 100%;height:80px; margin-top: -9px;"></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="actual_text" ></span></div>
                                                                    <div class="text-center"><span class="actual_count" style="color:`+color+`;">`+number+`%</span></div>
                                                                </div>  
                                                            </div>                                              
                                                        </div>
                                                    </div>
                                                </div>`;
                                            cahrtids.push({chartid:$d_indicator['d_ind_id'],number:number,number1:number1,color:color});
                                        });
                                    }else{
                                        ind_count++;
                                        name="";
                                        name= indicator['title'].replace(':', "");
                                        hname=name.substring(0, 17);
                                        name2=name.substring(17,91);
                                        number = indicator['target'] <=0 ? 0 :(indicator['actual_count']/ indicator['target'])*100;
                                        number = Number(number.toFixed(2));
                                        number1 = number > 100 ? 100 : number;
                                        color = number <= 1 ? "gray" : number <= 60 ? "red" : number <= 85 ? "#FFAA4C" : number <= 100 ? "green" : number > 100 ? "blue":"green";

                                        HTML += `
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="card border-0 shadow mb-3">
                                                        <div class="card-body pb-0">`;
                                                            HTML += `
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-12">
                                                                    <span class="title mb-1"> ${hname}
                                                                        <span class="dropdown pointer">
                                                                            <span class="dropdown-toggle grid"
                                                                                data-toggle="dropdown">
                                                                                <img src="<?php echo base_url(); ?>include/assets/images/exclamation.png" height="16px">
                                                                            </span>
                                                                            <ul class="dropdown-menu text_notification">
                                                                                <li>${name}</li>
                                                                            </ul>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <p class="font-12px text-left">${name}</p>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="target_text text-success">Target</span></div>
                                                                    <div class="text-center"><span class="target_count ">${indicator['target']}</span></div>
                                                                    
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="actual_text text-info">Actual</span></div>
                                                                    <div class="text-center"><span class="actual_count">${indicator['actual_count']}</span></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="actual_text" style="color:blue;">Uploads</span></div>
                                                                    <div class="text-center"><span class="actual_count">${indicator['record_count']}</span></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-2">
                                                                    <div class="" id="`+indicator['id']+`"
                                                                        style="width: 100%;height:80px; margin-top: -9px;"></div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-1">
                                                                    <div class="text-center"><span class="" style="color:white;">%</span></div>
                                                                    <div class="text-center"><span class="actual_count" style="color:`+color+`;">`+number+`%</span></div>
                                                                </div>  
                                                            </div>                                              
                                                        </div>
                                                    </div>
                                                </div>`;
                                        cahrtids.push({chartid:indicator['id'],number:number,number1:number1,color:color});
                                    }
                                });
                            };
                        });
                    HTML += `</div>
                    </div>`;
                $('.table_list').html(HTML);
                var HTML1 = `INDICATORS <small>(${ind_count})</small>`;
                $('.ind_count').html(HTML1);
                setTimeout(() => {
                    cahrtids.forEach(function(data, index) {
                        load_speedmeter(data['number'],data['number1'],data['chartid'],data['color']);
                    });
                });
                
                // getPoDetailsCounters();
            }
        });
    }
</script>
    
    <script>
       
        function load_speedmeter(data_count,data_count_value, meter_name, color) {
            var color1=color;
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
                    // Colors: 0=Grey; 1-60% - Red; 61-85% - Yellow; 86-100 – Green; >100% - Blue
                    plotBands: [{
                        from: 0,
                        to: 1,
                        color: 'grey'
                    }, {
                        from: 2,
                        to: 60,
                        color: 'red'
                    },
                    {
                        from: 61,
                        to: 85,
                        color: '#FFAA4C'
                    }, {
                        from: 86,
                        to: 100,
                        color: 'green'
                    }, {
                        from: 100,
                        to: 150,
                        color: 'blue'
                    }
                    ]
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
                        text: '<span style="font-weight:bold;font-size:12px;color:'+color1+'">'+[data_count]+'%</span>',
                        y: 50
                    }
                },

                series: [{
                    name: 'Target',
                    data: [data_count_value],
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

<script>
    function list_speedmeter(data_count,data_count_value, meter_name, color) {
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
                // title: {
                //     y: -40
                // },
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
        var chartRpm = Highcharts.chart(meter_name, Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: -30,
                max: 100,
                // title: {
                //     text: '<span style="font-weight:bold;font-size:12px;color:green">-32.2%</span>',
                //     y: 50
                // }
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

