<style type="text/css">
    label {
        font-weight: bold;
    }

    th {
        color: #FFFFFF;
    }
    .app-content.page-body {
        margin-top: 6rem !important;
    }
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
    .ms-parent {
        width:100% !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css"  />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<link href="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>include/assets/css/multiple-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>include/assets/js/jquery-3.5.1.min.js"></script>





<!-- Edit Data Modal -->
<div class="modal fade" id="sendBackModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Send back query</h3>
            </div>

            <?php echo form_open('', array('id' => 'sendBackForm')); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Send Back To User - <span style="font-weight:500;" id="backTo"></span></label>
                </div>
                <div class="form-group">
                    <label for="reason">Query</label> <span class="text-danger">*</span>
                    <textarea id="query" placeholder="Provide query to send back..." class="form-control" name="query" rows="5" style="resize:vertical;"></textarea>
                    <span class="query error text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Send Back</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="app-content page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 pl-0 pr-0 mb-5">
                <div class="p-3 pl-0 bg-light border border-bottom-0">
                    <div class="wrapper mt-3">
                        <div class="container-fluid">                            
                            <div class="card border-0 shadow">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <h3 class="title mb-0">Upload Data</h3>
                                        </div>
                                        <!-- <div class="">
                                            <a href="index.html" class="btn btn-light1 btn-sm"><img src="./assets/images/icon-left-arrow.svg"> Back</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <form id="submit_data">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for=""> Select Measurement level <font color="red">*</font></label>
                                                                <select class="form-control measure_level" name="measure_level" id="measure_level">
                                                                    <option value="">Select Measurement level </option>
                                                                    <?php foreach ($lkp_level_measurement as $key => $option) { ?>
                                                                        <option value="<?php echo $option['level_m_id']; ?>"><?php echo $option['level_m_name']; ?></option> <?php
                                                                        } ?>
                                                                </select>
                                                                <span class="error" style="color:red"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Year <font color="red">*</font></label>
                                                        <select class="form-control year" name="year">
                                                            <option value="">Select Year</option>
                                                            <?php foreach ($lkp_year_list as $key => $option) { 
                                                                ?>
                                                                <option value = "<?php echo $option['year_id']; ?>"><?php echo $option['year']; ?></option> 
                                                                <?php
                                                            } ?>
                                                        </select>
                                                        <span class="error" style="color:red"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Country <font color="red">*</font></label>
                                                        <select class="form-control country" name="country" >
                                                            <option value="">Select Country</option>
                                                            <?php foreach ($lkp_country_list as $key => $option) { 
                                                                if($lkp_user_list['role_id']==6 || $lkp_user_list['role_id']==5){
                                                                    $selected="selected";
                                                                    if($lkp_user_list['country_id'] == $option['country_id']){
                                                                        ?>
                                                                        <option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    $selected="";
                                                                    ?>
                                                                <option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
                                                                <?php
                                                                }
                                                                    
                                                            } ?>
                                                        </select>
                                                        <span class="error" style="color:red"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <?php 
                                                    $county_id = $lkp_user_list['country_id'];
                                                        switch ($county_id) {
                                                            case '1':
                                                                # code...
                                                                $county_name="County";
                                                                break;

                                                            case '2':
                                                                # code...
                                                                $county_name="District";
                                                                break;

                                                            case '3':
                                                                # code...
                                                                $county_name="Zone";
                                                                break;
                                                            
                                                            default:
                                                                # code...
                                                                $county_name="County / Zone / District";
                                                                break;
                                                        }
                                                        ?>
                                                    <div class="form-group form-upload sub_national" id="sub_national">
                                                        <label for=""> Select <?php echo $county_name;?> <font color="red">*</font></label>
                                                        <select class="form-control county" name="county">
                                                            <option selected>Select <?php echo $county_name;?></option>
                                                        </select>
                                                        <span class="error" style="color:red"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="dimension_div row col-sm-12 col-md-12 col-lg-12" id="dimension_div">
                                                    <div class="row col-sm-12 col-md-12">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group">
                                                                <label for=""> Select Dimension </label>
                                                                <select class="form-control dimension1" name="dimension1">
                                                                    <option value="">Select Dimension</option>
                                                                    <?php foreach ($lkp_dimensions_list as $key => $option) { ?>
                                                                        <option value = "<?php echo $option['dimensions_id']; ?>"><?php echo $option['dimensions_name']; ?></option> <?php
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for=""> Select Sub-Dimension </label>
                                                                <select class="form-control subdimension1" name="subdimension1">
                                                                    <option>Select Sub-Dimension</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for=""> Select Category </label>
                                                                <select class="form-control category1" name="category1">
                                                                    <option>Select Category</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for=""> Select Indicator </label>  <span class="ind_desc1"></span>
                                                                <select class="form-control indicators1" name="indicators1">
                                                                    <option value="">Select Indicator</option>
                                                                </select>
                                                                <p class="error" style="color: red"></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4 text-right">
                                                            <!-- <div class="form-group form-upload"> -->
                                                            <div class="col-md-12 form-group form-upload" style="margin-bottom: 15px;">
                                                                <a href="javascript:void(0);" class="btn-success btn-sm pull-right search_by_indicator " style="color: #FFFFFF !important;">Search By Indicator</a>
                                                                <p class="error" style="color: red"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row ml-1 col-sm-12 col-md-12  mb-2">
                                                        <span class="ind_desc1"></span>
                                                    </div> -->
                                                </div>
                                                <div class="col-md-12 hidden indicator_div" id="indicator_div">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-lg-8">
                                                            <div class="form-group form-upload col-sm-8">
                                                                <label for=""> Select Indicator </label>  <span class="ind_desc"></span>
                                                                <select name="indicator" clas=="indicator" id="searcht2" placeholder="Search ..." >
                                                                </select>
                                                                <span class="error" style="color:red"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                            <!-- <div class="col-md-12 excelbdiv" style="margin-bottom: 15px;"> -->
                                                                <a href="javascript:void(0);" class="btn-success btn-sm search_by_dimension" style="color: #FFFFFF !important;">Select Indicator by Dimension</a>
                                                                <p class="error" style="color: red"></p>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                                            <span class="ind_desc"></span>
                                                        </div> -->
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group">
                                                                <label for=""> Select Dimension </label>
                                                                <select class="form-control dimension" name="dimension">
                                                                    <option value="">Select Dimension</option>
                                                                    <!-- <?php foreach ($lkp_dimensions_list as $key => $option) { ?>
                                                                        <option value = "<?php echo $option['dimensions_id']; ?>"><?php echo $option['dimensions_name']; ?></option> <?php
                                                                    } ?> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for=""> Select Sub-Dimension </label>
                                                                <select class="form-control subdimension" name="subdimension">
                                                                    <option>Select Sub-Dimension</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for=""> Select Category </label>
                                                                <select class="form-control category" name="category">
                                                                    <option>Select Category</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Indicator </label>
                                                        <select class="form-control indicators" name="indicators">
                                                            <option>Select Indicator</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group form-upload">
                                                                <label for="" class="actual_text"> Enter value   </label>
                                                                <div class="actual_type" id="actual_type">
                                                                    <input type="number" class="form-control fieldgreen" placeholder="Enter the Actual value " name="actual" id="actual">
                                                                </div>
                                                            <span class="error" style="color:red"></span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Data Source   </label> <i class="fa fa-info-circle text-dark" data-toggle="popover" title="Data source Info" data-content="Info coming Soon"></i></span>
                                                    <textarea class="form-control fieldgreen" placeholder="Enter Data Source " name="data_source" id="data_source"></textarea>
                                                    <span class="error" style="color:red"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Data Sets   </label>
                                                    <!-- <textarea class="form-control fieldgreen" placeholder="Enter Data Sets " name="data_sets"></textarea> -->
                                                    <input type="file" class="form-control" name="data_sets" id="data_sets" />
                                                    <span class="error" style="color:red"></span>
                                                    </div>
                                                    <div class="file_link" id="file_link"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Remarks   </label>
                                                    <textarea class="form-control fieldgreen" placeholder="Enter Remarks " name="remarks" id="remarks"></textarea>
                                                    <span class="error" style="color:red"></span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                                    <button type="button" class="btn btn-sm btn-success pull-right submit_data">Submit data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end app-content-->
</div>
<script src="<?php echo base_url(); ?>include/assets/js/vendors/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url(); ?>include/assets/plugins/sisyphus/sisyphus.min.js"></script>
<script src="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/jquery.richtext.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js" ></script>
<script type="text/javascript">
    
    $(function() {
        // $('select').selectpicker();
        // Initialize Sisyphus
        // $("#submit_data").sisyphus();
        // $('.default_indicatorcomment').trigger('change');

        // $('select').selectpicker();

        // //Date picker
        // $('.picker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true
        // });

        // //month picker
        // $('.monthpicker').datepicker({
        //     format: 'yyyy-mm',
        //     autoclose: true,
        //     viewMode: "months",
        //     minViewMode: "months"
        // });

        getIndicatorList();
        $('[name="indicator"]').multipleSelect({
            filter: true
        });
        $('[name="country"]').trigger('change');
        // if(<?php echo $lkp_user_list['role_id']; ?>==5){
        //     $('[name="country"]').trigger('change');
        // }
        $('[data-toggle="popover"]').popover();   
    });
    $('body').on('change', '.year', function() {
        getIndicatorData();
    });
    $('body').on('change', '.county', function() {
        getIndicatorData();
    });
    $('body').on('change', '.measure_level', function() {
        $elem = $(this);
        measure_level= this.value;
        if(measure_level==1){
            $('.sub_national').hide();
        }else{
            $('.sub_national').show();
        }
        getIndicatorList();
        getIndicatorData();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/upload_get_dimensions",
            type: "POST",
            dataType: "json",
            data: {
                measure_level: measure_level
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_dimensions_list.length > 0) {
                        var CHILD_HTML = '';
                        var CHILD_HTML_EMPTY = '';
                        var CHILD_HTML_EMPTY1 = '';
                        var CHILD_HTML_EMPTY2 = '';
                        CHILD_HTML += '<option value = "">Select Dimension</option>';
                        CHILD_HTML_EMPTY += '<option value = "">Select Category</option>';
                        CHILD_HTML_EMPTY1 += '<option value = "">Select Indicator</option>';
                        CHILD_HTML_EMPTY2 += '<option value = "">Select Sub-Dimension</option>';
                        for (var field of response.result.lkp_dimensions_list) {
                            CHILD_HTML += '<option value = "' + field.dimensions_id + '">' + field.dimensions_name + '</option>';
                        };
                        $('.dimension1').html(CHILD_HTML);
                        $('.category1').html(CHILD_HTML_EMPTY);
                        $('.indicators1').html(CHILD_HTML_EMPTY1);
                        $('.subdimension1').html(CHILD_HTML_EMPTY2);
                    } else {
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });

    $('body').on('click', '.search_by_indicator', function(){
        $elem = $(this);
        $('.dimension_div').hide();
        $('.indicator_div').show();
    });
    $('body').on('click', '.search_by_dimension', function(){
        $elem = $(this);
        $('.dimension_div').show();
        $('.indicator_div').hide();
    });

    function getIndicatorList() {
        $('[name="search"]').html('');
        measure_level= $('select[name="measure_level"]').val();
        // AJAX to get programs
        $.ajax({
            url: '<?php echo base_url(); ?>reporting/get_indicators_list',
            type: 'POST',
            dataType: 'JSON',
            data: {
                year: $('[name="year"]').val(),
                measure_level_id:measure_level
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
                // programs += '<option value="" >Search Indicator ... </option>';
                // response.pos.forEach(function(program, index) {
                //     programs += '<option value="' + program.id + '" >' + program.title + '</option>';
                // });
                if (response.result.lkp_indicators_list.length > 0) {
                    programs += '<option value="" >Search Indicator ... </option>';
                    
                    for (var field of response.result.lkp_indicators_list) {
                        // CHILD_HTML += '<option value = "' + field.indicator_id + '">' + field.indicator_name + '</option>';
                        programs += '<option value="' + field.indicator_id + '" >' + field.indicator_name + '</option>';
                    };
                    // $('.indicators').html(CHILD_HTML);
                }
                $('[name="indicator"]').html(programs);

                // Refresh options
                // $('[name="search"]').trigger('change');
                $('[name="indicator"]').multipleSelect('refresh');
            }
        });
    }

    $('body').on('change', '[name="indicator"]', function() {
        $elem = $(this);
        var indicator_id= this.value;
        var measure_level = $('select[name="measure_level"]').val();
        var year_id = $('select[name="year"]').val();
        var country_id = $('select[name="country"]').val();
        var county_id = $('select[name="county"]').val();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators_details",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id,
                measure_level: measure_level,
                year_id: year_id,
                country_id: country_id,
                county_id: county_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicator_data_list.length > 0) {
                        var CHILD_HTML1 = '';                        
                        for (var field of response.result.lkp_indicator_data_list) {
                            CHILD_HTML1 += '<option value = "' + field.dimensions_id + '" selected>' + field.dimensions_name + '</option>';
                        };
                        $('.dimension').html(CHILD_HTML1);
                        var CHILD_HTML2 = '';                        
                        for (var field of response.result.lkp_indicator_data_list) {
                            CHILD_HTML2 += '<option value = "' + field.sub_dimensions_id + '" selected>' + field.sub_dimensions_name + '</option>';
                        };
                        $('.subdimension').html(CHILD_HTML2);
                        var CHILD_HTML3 = '';                        
                        for (var field of response.result.lkp_indicator_data_list) {
                            CHILD_HTML3 += '<option value = "' + field.categories_id + '" selected>' + field.categories_name + '</option>';
                        };
                        $('.category').html(CHILD_HTML3);
                        var CHILD_HTML4 = '';  
                        var CHILD_HTML5 = '';  
                        var CHILD_HTML6 = '';  
                        var actualValue =response.result.actual_value;
                        var myFile=response.result.ds_file_name;
                        var myFileURL="<?php echo base_url();?>/upload/survey/"+myFile;
                        for (var field of response.result.lkp_indicator_data_list) {
                            //hiding subdimentional if selected indicator is national type
                            if(field.lkp_level_measurement==1){
                                $('.sub_national').hide();
                            }else{
                                $('.sub_national').show();
                            }
                                                 
                            CHILD_HTML4 += '<i class="fa fa-info-circle text-dark" data-toggle="popover" title="Indicator Info" data-content="<b>About Indicator</b> - ' + field.description.replace(/\s+/g,' ').trim() + '<br/> <b>Unit of measurement</b> - ' + field.m_unit_name + '" data-html="true"></i>';
                            //changeing actual type dive based on indicator selected
                            
                            switch (field.lkp_value_type) {
                                case '1':
                                    var sel_value0="";
                                    var sel_value1="";
                                    if(actualValue ==0){
                                        sel_value0="selected";
                                    }
                                    if(actualValue ==1){
                                        sel_value1="selected";
                                    }
                                    CHILD_HTML5 += '<select name="actual" class="form-control" value="'+actualValue+'"> <option value="">select value</option> <option value="0" '+sel_value0+'>0</option><option value="1" '+sel_value1+'>1</option></select> ';
                                    break;

                                case '2':
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-maxlength="100" data-minlength="1" data-subtype="desimal">';
                                    break;

                                case '3':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-maxlength="365" data-subtype="number">';
                                    break;

                                case '4':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-maxlength="70" data-subtype="desimal">';
                                    break;

                                case '5':
                                    
                                    $sel_value0="";
                                    $sel_value1="";
                                    if($actual_value ==0){
                                        $sel_value0="selected";
                                    }
                                    if($actual_value ==1){
                                        $sel_value1="selected";
                                    }
                                    CHILD_HTML5 += '<select name="actual" class="form-control" value="'+actualValue+'"> <option value="">select value</option> <option value="1">1</option><option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> </select>';
                                    break;

                                case '6':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="0" data-subtype="number">';
                                    break;

                                case '7':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-subtype="number">';
                                    break;

                                case '8':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1000" data-subtype="number">';
                                    break;

                                case '9':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-maxlength="3000" data-subtype="desimal">';
                                    break;

                                case '10':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="number">';
                                    break;

                                case '11':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="number">';
                                    break;

                                case '12':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="desimal">';
                                    break;

                                case '13':
                                    var sel_value0="";
                                    var sel_value1="";
                                    if(actualValue ==0 && actualValue!=""){
                                        sel_value0="checked";
                                    }
                                    if(actualValue ==1){
                                        sel_value1="checked";
                                    }
                                    CHILD_HTML5 += '<div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label class="pull-right" ><input type="radio" class="form-control" name="actual" value="1" '+sel_value1+' data-subtype="desimal">Yes</label></div>\
                                    <div class="col-sm-12 col-md-6 col-lg-6"><label class="" ><input type="radio" class="form-control" name="actual" value="0" '+sel_value0+' data-subtype="desimal">No</label></div></div>';
                                    break;

                                default:
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'">';
                                    break;
                            }
                            // const dataTransfer = new DataTransfer();
                            // dataTransfer.items.add(myFile);//your file(s) reference(s)
                            // document.getElementById('data_sets').files = dataTransfer.files;
                            
                            CHILD_HTML6 += '<div class="file_link" id="file_link"><a class="form-control" href='+myFileURL+'>'+myFile+'</a></div>';
                            
                        };
                        $('.ind_desc').html(CHILD_HTML4);
                        $('.actual_type').html(CHILD_HTML5);
                        if(myFile){
                            $('#file_link').html(CHILD_HTML6);
                            document.getElementById("data_sets").value ="";
                        }else{
                            $('#file_link').html("");
                            document.getElementById("data_sets").value ="";
                        }
                        $('[data-toggle="popover"]').popover();
                        //if records exists set values in boxs
                        // document.getElementById("actual").value =response.result.actual_value;
                        document.getElementById("data_source").value =response.result.data_source;
                        document.getElementById("remarks").value =response.result.remarks;
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });    

    $('body').on('change', '[name="indicators1"]', function() {
        $elem = $(this);
        indicator_id= this.value;
        var measure_level = $('select[name="measure_level"]').val();
        var year_id = $('select[name="year"]').val();
        var country_id = $('select[name="country"]').val();
        var county_id = $('select[name="county"]').val();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators_details",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id,
                measure_level: measure_level,
                year_id: year_id,
                country_id: country_id,
                county_id: county_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicator_data_list.length > 0) {
                        var CHILD_HTML5 = ''; 
                        var CHILD_HTML6 = '';   
                        var actualValue =response.result.actual_value;
                        var myFile=response.result.ds_file_name;
                        var myFileURL="<?php echo base_url();?>/upload/survey/"+myFile;
                        for (var field of response.result.lkp_indicator_data_list) {
                            //hiding subdimentional if selected indicator is national type
                            if(field.lkp_level_measurement==1){
                                // $('.sub_national').hide();
                                // $('.actual_text').html('Enter value (Enter 0 for No, enter 1 for Yes)');
                            }else{
                                // $('.sub_national').show();
                                // $('.actual_text').html('Enter value');
                            }
                            var CHILD_HTML4 = '';                        
                            CHILD_HTML4 += '<i class="fa fa-info-circle text-dark" data-toggle="popover" title="Indicator Info" data-content="<b>About Indicator</b> - ' + field.description.replace(/\s+/g,' ').trim() + '<br/> <b>Unit of measurement</b> - ' + field.m_unit_name + '" data-html="true"></i>';

                            //changeing actual type dive based on indicator selected
                            
                            switch (field.lkp_value_type) {
                                case '1':
                                    var sel_value0="";
                                    var sel_value1="";
                                    if(actualValue ==0){
                                        sel_value0="selected";
                                    }
                                    if(actualValue ==1){
                                        sel_value1="selected";
                                    }
                                    CHILD_HTML5 += '<select name="actual" class="form-control" value="'+actualValue+'"> <option value="">select value</option> <option value="0" '+sel_value0+'>0</option><option value="1" '+sel_value1+'>1</option></select> ';
                                    break;

                                case '2':
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-maxlength="100" data-minlength="1" data-subtype="desimal">';
                                    break;

                                case '3':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-maxlength="365" data-subtype="number">';
                                    break;

                                case '4':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-maxlength="70" data-subtype="desimal">';
                                    break;

                                case '5':
                                    
                                    $sel_value0="";
                                    $sel_value1="";
                                    if($actual_value ==0){
                                        $sel_value0="selected";
                                    }
                                    if($actual_value ==1){
                                        $sel_value1="selected";
                                    }
                                    CHILD_HTML5 += '<select name="actual" class="form-control" value="'+actualValue+'"> <option value="">select value</option> <option value="1">1</option><option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> </select>';
                                    break;

                                case '6':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="0" data-subtype="number">';
                                    break;

                                case '7':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-subtype="number">';
                                    break;

                                case '8':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1000" data-subtype="number">';
                                    break;

                                case '9':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-maxlength="3000" data-subtype="desimal">';
                                    break;

                                case '10':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="number">';
                                    break;

                                case '11':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="number">';
                                    break;

                                case '12':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="desimal">';
                                    break;

                                case '13':
                                    var sel_value0="";
                                    var sel_value1="";
                                    if(actualValue ==0 && actualValue!=""){
                                        sel_value0="checked";
                                    }
                                    if(actualValue ==1){
                                        sel_value1="checked";
                                    }
                                    CHILD_HTML5 += '<div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label class="pull-right" ><input type="radio" class="form-control" name="actual" value="1" '+sel_value1+' data-subtype="desimal">Yes</label></div>\
                                    <div class="col-sm-12 col-md-6 col-lg-6"><label class="" ><input type="radio" class="form-control" name="actual" value="0" '+sel_value0+' data-subtype="desimal">No</label></div></div>';
                                    break;

                                default:
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'">';
                                    break;
                            }
                            CHILD_HTML6 += '<div class="file_link" id="file_link"><a class="form-control" href='+myFileURL+'>'+myFile+'</a></div>';
                        };
                        $('.ind_desc1').html(CHILD_HTML4);
                        $('.actual_type').html(CHILD_HTML5);
                        if(myFile){
                            document.getElementById("data_sets").value ="";
                            $('#file_link').html(CHILD_HTML6);
                        }else{
                            $('#file_link').html("");
                            document.getElementById("data_sets").value ="";
                        }
                        $('[data-toggle="popover"]').popover();
                        //if records exists set values in boxs
                        // document.getElementById("actual").value =response.result.actual_value;
                        document.getElementById("data_source").value =response.result.data_source;
                        document.getElementById("remarks").value =response.result.remarks;
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });    

    function getIndicatorData(){
        var indicator_id= "";
        $('#file_link').html("");
        document.getElementById("data_sets").value ="";
        $('input[name="actual"]').val('');
        if(  $("#dimension_div").is(":visible") == true ){
            if ($('select[name="indicators1"]').val().length == 0) {
                // 
            }else{
                indicator_id=$('select[name="indicators1"]').val();
            }
        }
        if(  $("#indicator_div").is(":visible") == true ){
            if ($('select[name="indicator"]').val().length == 0) {
                // 
            }else{
                indicator_id=$('select[name="indicator"]').val();
            }
        }
        var measure_level = $('select[name="measure_level"]').val();
        var year_id = $('select[name="year"]').val();
        var country_id = $('select[name="country"]').val();
        var county_id = $('select[name="county"]').val();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators_details",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id,
                measure_level: measure_level,
                year_id: year_id,
                country_id: country_id,
                county_id: county_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicator_data_list.length > 0) {
                        var CHILD_HTML5 = ''; 
                        var CHILD_HTML6 = '';   
                        var actualValue =response.result.actual_value;
                        var myFile=response.result.ds_file_name;
                        var myFileURL="<?php echo base_url();?>/upload/survey/"+myFile;
                        for (var field of response.result.lkp_indicator_data_list) {
                            //hiding subdimentional if selected indicator is national type
                            if(field.lkp_level_measurement==1){
                                // $('.sub_national').hide();
                                // $('.actual_text').html('Enter value (Enter 0 for No, enter 1 for Yes)');
                            }else{
                                // $('.sub_national').show();
                                // $('.actual_text').html('Enter value');
                            }
                            var CHILD_HTML4 = '';                        
                            CHILD_HTML4 += '<i class="fa fa-info-circle text-dark" data-toggle="popover" title="Indicator Info" data-content="<b>About Indicator</b> - ' + field.description.replace(/\s+/g,' ').trim() + '<br/> <b>Unit of measurement</b> - ' + field.m_unit_name + '" data-html="true"></i>';

                            //changeing actual type dive based on indicator selected
                            
                            switch (field.lkp_value_type) {
                                case '1':
                                    var sel_value0="";
                                    var sel_value1="";
                                    if(actualValue ==0){
                                        sel_value0="selected";
                                    }
                                    if(actualValue ==1){
                                        sel_value1="selected";
                                    }
                                    CHILD_HTML5 += '<select name="actual" class="form-control" value="'+actualValue+'"> <option value="">select value</option> <option value="0" '+sel_value0+'>0</option><option value="1" '+sel_value1+'>1</option></select> ';
                                    break;

                                case '2':
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-maxlength="100" data-minlength="1" data-subtype="desimal">';
                                    break;

                                case '3':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-maxlength="365" data-subtype="number">';
                                    break;

                                case '4':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-maxlength="70" data-subtype="desimal">';
                                    break;

                                case '5':
                                    
                                    $sel_value0="";
                                    $sel_value1="";
                                    if($actual_value ==0){
                                        $sel_value0="selected";
                                    }
                                    if($actual_value ==1){
                                        $sel_value1="selected";
                                    }
                                    CHILD_HTML5 += '<select name="actual" class="form-control" value="'+actualValue+'"> <option value="">select value</option> <option value="1">1</option><option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> </select>';
                                    break;

                                case '6':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="0" data-subtype="number">';
                                    break;

                                case '7':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1" data-subtype="number">';
                                    break;

                                case '8':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-minlength="1000" data-subtype="number">';
                                    break;

                                case '9':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'" data-maxlength="3000" data-subtype="desimal">';
                                    break;

                                case '10':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="number">';
                                    break;

                                case '11':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="number">';
                                    break;

                                case '12':
                                    
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'"  data-subtype="desimal">';
                                    break;

                                case '13':
                                    var sel_value0="";
                                    var sel_value1="";
                                    if(actualValue ==0 && actualValue!=""){
                                        sel_value0="checked";
                                    }
                                    if(actualValue ==1){
                                        sel_value1="checked";
                                    }
                                    CHILD_HTML5 += '<div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label class="pull-right" ><input type="radio" class="form-control" name="actual" value="1" '+sel_value1+' data-subtype="desimal">Yes</label></div>\
                                    <div class="col-sm-12 col-md-6 col-lg-6"><label class="" ><input type="radio" class="form-control" name="actual" value="0" '+sel_value0+' data-subtype="desimal">No</label></div></div>';
                                    break;

                                default:
                                    CHILD_HTML5 += '<input type="number" class="form-control" name="actual" value="'+actualValue+'">';
                                    break;
                            }
                            CHILD_HTML6 += '<div class="file_link" id="file_link"><a class="form-control" href='+myFileURL+'>'+myFile+'</a></div>';
                        };
                        $('.ind_desc1').html(CHILD_HTML4);
                        $('.actual_type').html(CHILD_HTML5);
                        if(myFile){
                            document.getElementById("data_sets").value ="";
                            $('#file_link').html(CHILD_HTML6);
                        }else{
                            $('#file_link').html("");
                            document.getElementById("data_sets").value ="";
                        }
                        $('[data-toggle="popover"]').popover();
                        //if records exists set values in boxs
                        // document.getElementById("actual").value =response.result.actual_value;
                        document.getElementById("data_source").value =response.result.data_source;
                        document.getElementById("remarks").value =response.result.remarks;
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    }

    $('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        role_id= <?php echo $lkp_user_list['role_id']; ?>;
        getIndicatorData();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_countys",
            type: "POST",
            dataType: "json",
            data: {
                country_id: country_id,
                role_id: role_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_county_list.length > 0) {
                        var CHILD_HTML = '';
                        CHILD_HTML += '<?php echo $county_name;?>';
                        for (var field of response.result.lkp_county_list) {
                            CHILD_HTML += '<option value = "' + field.county_id + '">' + field.county_name + '</option>';
                        };
                        $('.county').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });

    $('body').on('click', '.submit_data', function() {
        $elem = $(this);
        // $elem.prop('disabled', true);
        

        $('.error').html('');

        var form_id = "submit_data";
        var surveycount = 0;
        //check common 4 fields
        // year_id,rperiod_id,country_id,crop_id
        if ($('select[name="measure_level"]').val().length == 0) {
            $('select[name="measure_level"]').next('.error').html('This field is required');
            surveycount++;
        }else{            
            $('select[name="measure_level"]').next('.error').html('');
        }
        if($('select[name="year"]').val() !=1){
            if ($('select[name="county"]').val().length == 0) {
                $('select[name="county"]').next('.error').html('This field is required');
                surveycount++;
            }else{
                $('select[name="county"]').next('.error').html('');
            }
        }
        if ($('select[name="year"]').val().length == 0) {
            $('select[name="year"]').next('.error').html('This field is required');
            surveycount++;
        }else{
            $('select[name="year"]').next('.error').html('');
        }
        if ($('select[name="country"]').val().length == 0) {
            $('select[name="country"]').next('.error').html('This field is required');
            surveycount++;
        }else{
            $('select[name="country"]').next('.error').html('');
        }
        if ($('input[name="actual"]').val().length == 0) {
            $('input[name="actual"]').next('.error').html('This field is required');
            surveycount++;
        }else{
            $('input[name="actual"]').next('.error').html('');
        }
        if(  $("#dimension_div").is(":visible") == true ){
            if ($('select[name="indicators1"]').val().length == 0) {
                $('select[name="indicators1"]').next('.error').html('This field is required');
                surveycount++;
            }else{
                $('select[name="indicators1"]').next('.error').html('');
            }
        }
        if(  $("#indicator_div").is(":visible") == true ){
            if ($('select[name="indicator"]').val().length == 0) {
                $('select[name="indicator"]').next('.error').html('This field is required');
                surveycount++;
            }else{
                $('select[name="indicator"]').next('.error').html('');
            }
        }
        if ($('input[name="data_sets"]').val().length == 0) {
            $('input[name="data_sets"]').next('.error').html('');
        }else{
            
            let filesize = $('input[name="data_sets"]').val().size // On older browsers this can return NULL.
            let filesizeMB = (filesize / (1024*1024)).toFixed(2);

            if(filesizeMB <= 5) {
                // Allow the form to be submitted here.
                $('input[name="data_sets"]').next('.error').html('');
            } else {
                // alert("test value greater 5");
                // Don't allow submission of the form here.
                $('input[name="data_sets"]').next('.error').html('Uploaded file size should be less than 5 MB :'.filesize);
                surveycount++;
            }
        }

        if (surveycount == 0) {
            var indicatorform = new FormData($('#' + form_id)[0]);
            indicatorform.append('measure_level', $('select[name="measure_level"]').val());
            indicatorform.append('year_val', $('select[name="year"]').val());
            indicatorform.append('country_val', $('select[name="country"]').val());
            if(  $("#sub_national").is(":visible") == true ){
                indicatorform.append('county_val', $('select[name="county"]').val());
            }else{
                indicatorform.append('county_val', 0);
            }
            if(  $("#dimension_div").is(":visible") == true ){
                // While dimension selected actual value data
                indicatorform.append('indicator_id', $('select[name="indicators1"]').val());
                indicatorform.append('dimension_val', $('select[name="dimension1"]').val());
                indicatorform.append('subdimension_val', $('select[name="subdimension1"]').val());
                indicatorform.append('category_val', $('select[name="category1"]').val());
            }
            if(  $("#indicator_div").is(":visible") == true ){
                // while search by indicator actual data
                indicatorform.append('indicator_id', $('select[name="indicator"]').val());
                indicatorform.append('dimension_val', $('select[name="dimension"]').val());
                indicatorform.append('subdimension_val', $('select[name="subdimension"]').val());
                indicatorform.append('category_val', $('select[name="category"]').val());
            }
            indicatorform.append('actual_val', $('input[name="actual"]').val());
           
            indicatorform.append('submit_type', 'submit');
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/insert_indicatordata',
                type: 'POST',
                dataType: 'json',
                data: indicatorform,
                processData: false,
                contentType: false,
                error: function() {
                    $.toast({
                        heading: 'Warning!',
                        text: 'Please check your internet connection and try again.',
                        icon: 'error',
                        afterHidden: function() {
                            $elem.prop('disabled', false);
                        }
                    });
                },
                success: function(response) {
                    if (response.status == 0) {
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error',
                            afterHidden: function() {
                                $elem.prop('disabled', false);
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Success!',
                            text: response.msg,
                            icon: 'success',
                            afterHidden: function() {
                                $('#' + form_id).each(function() {
                                    this.reset();
                                });
                                location.reload(true);
                            }
                        });
                    }
                }
            });
        } else {
            $elem.prop('disabled', false);
        }
    });


    $('body').on('change', '.dimension1', function() {
        $elem = $(this);
        dimensions_id= this.value;
        measure_level= $('select[name="measure_level"]').val();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/upload_get_subdimensions",
            type: "POST",
            dataType: "json",
            data: {
                dimensions_id: dimensions_id,
                measure_level: measure_level
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_sub_dimensions_list.length > 0) {
                        var CHILD_HTML = '';
                        var CHILD_HTML_EMPTY = '';
                        var CHILD_HTML_EMPTY1 = '';
                        CHILD_HTML += '<option value = "">Select Sub-Dimension</option>';
                        CHILD_HTML_EMPTY += '<option value = "">Select Category</option>';
                        CHILD_HTML_EMPTY1 += '<option value = "">Select Indicator</option>';
                        for (var field of response.result.lkp_sub_dimensions_list) {
                            CHILD_HTML += '<option value = "' + field.sub_dimensions_id + '">' + field.sub_dimensions_name + '</option>';
                        };
                        $('.subdimension1').html(CHILD_HTML);
                        $('.category1').html(CHILD_HTML_EMPTY);
                        $('.indicators1').html(CHILD_HTML_EMPTY1);
                    } else {
                        // var CHILD_HTML = '';
                        // var CHILD_HTML_EMPTY = '';
                        // var CHILD_HTML_EMPTY1 = '';
                        // CHILD_HTML += '<option value = "">Select Sub-Dimension</option>';
                        // CHILD_HTML_EMPTY += '<option value = "">Select Category</option>';
                        // CHILD_HTML_EMPTY1 += '<option value = "">Select Indicator</option>';
                        // $('.subdimension1').html(CHILD_HTML);
                        // $('.category1').html(CHILD_HTML_EMPTY);
                        // $('.indicators1').html(CHILD_HTML_EMPTY1);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    $('body').on('change', '.subdimension1', function() {
        $elem = $(this);
        sub_dimensions_id= this.value;
        measure_level= $('select[name="measure_level"]').val();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/upload_get_category",
            type: "POST",
            dataType: "json",
            data: {
                sub_dimensions_id: sub_dimensions_id,
                measure_level: measure_level
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_categories_list.length > 0) {
                        var CHILD_HTML = '';
                        var CHILD_HTML_EMPTY = '';
                        CHILD_HTML += '<option value = "">Select Category</option>';
                        CHILD_HTML_EMPTY += '<option value = "">Select Indicator</option>';
                        
                        for (var field of response.result.lkp_categories_list) {
                            CHILD_HTML += '<option value = "' + field.categories_id + '">' + field.categories_name + '</option>';
                        };
                        $('.category1').html(CHILD_HTML);
                        $('.indicators1').html(CHILD_HTML_EMPTY);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });

    $('body').on('change', '.category1', function() {
        $elem = $(this);
        category_id= this.value;
        measure_level= $('select[name="measure_level"]').val();
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators",
            type: "POST",
            dataType: "json",
            data: {
                category_id: category_id,
                measure_level_id: measure_level
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicators_list.length > 0) {
                        var CHILD_HTML = '';
                        CHILD_HTML += '<option value="" >Select Indicator</option>';
                        
                        for (var field of response.result.lkp_indicators_list) {
                            CHILD_HTML += '<option value = "' + field.indicator_id + '">' + field.indicator_name + '</option>';
                        };
                        $('.indicators1').html(CHILD_HTML);
                    }else{
                        var CHILD_HTML = '';
                        CHILD_HTML += '<option value="" >No Indicator</option>';
                        $('.indicators1').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    
</script>