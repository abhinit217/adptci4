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
                                            <h3 class="title mb-0">Edit Data</h3>
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
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Year </label>
                                                        <select class="form-control" name="year">
                                                            <option value="">Select Year</option>
                                                            <?php foreach ($lkp_year_list as $key => $option) { 
                                                                ?>
                                                                <option value = "<?php echo $option['year_id']; ?>" <?php if($option['year_id'] == $lkp_form_data[0]['year_id']){ echo 'selected';}?>><?php echo $option['year']; ?></option> 
                                                                <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Country </label>
                                                        <select class="form-control country" name="country" >
                                                            <option value="">Select Country</option>
                                                            <?php foreach ($lkp_country_list as $key => $option) { ?>
                                                                <option value = "<?php echo $option['country_id']; ?>" <?php if($option['country_id'] == $lkp_form_data[0]['country_id']){ echo 'selected';}?>><?php echo $option['country_name']; ?></option> <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Sub-national </label>
                                                        <select class="form-control county" name="county">
                                                            <option selected>Select Sub-national</option>
                                                            <?php foreach ($lkp_county_list as $key => $option) { ?>
                                                                <option value = "<?php echo $option['county_id']; ?>" <?php if($option['county_id'] == $lkp_form_data[0]['county_id']){ echo 'selected';}?>><?php echo $option['county_name']; ?></option> <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-12">
                                                    <div class="form-group form-upload col-sm-8">
                                                        <label for=""> Select Indicator </label>
                                                        <select name="indicator" id="searcht2" placeholder="Search ..." >
                                                        </select> 
                                                    </div>
                                                </div>
                                                <!-- <div class=" col-sm-12 col-xs-6 col-md-6 col-lg-8">
                                                    <div class="form-group">
                                                        <select name="search" id="searcht2" placeholder="Search ..." class="form-control">
                                                        </select>                                                        
                                                    </div>
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
                                                <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Indicator </label>
                                                        <select class="form-control indicators" name="indicators">
                                                            <option>Select Indicator</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Enter the Actual value   </label>
                                                    <input type="number" class="form-control fieldgreen" placeholder="Enter the Actual value " value="<?php echo $lkp_form_data[0]['actual_value']?>" name="actual">
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

<script src="<?php echo base_url(); ?>include/assets/plugins/sisyphus/sisyphus.min.js"></script>
<script src="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/jquery.richtext.js"></script>
<script type="text/javascript">
    
    $(function() {
        // Initialize Sisyphus
        // $("#submit_data").sisyphus();
        // $('.default_indicatorcomment').trigger('change');

        //Date picker
        $('.picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        //month picker
        $('.monthpicker').datepicker({
            format: 'yyyy-mm',
            autoclose: true,
            viewMode: "months",
            minViewMode: "months"
        });

        $('#textarea_1').richText();
        getIndicatorList();
        $('[name="indicator"]').multipleSelect({
            filter: true
        });
        
    });

    function getIndicatorList() {
        $('[name="search"]').html('');

        // AJAX to get programs
        $.ajax({
            url: '<?php echo base_url(); ?>reporting/get_indicators_list',
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
                // programs += '<option value="" >Search Indicator ... </option>';
                // response.pos.forEach(function(program, index) {
                //     programs += '<option value="' + program.id + '" >' + program.title + '</option>';
                // });
                if (response.result.lkp_indicators_list.length > 0) {
                    programs += '<option value="" >Search Indicator ... </option>';
                    
                    for (var field of response.result.lkp_indicators_list) {
                        if (field.indicator_id == <?php echo $indicator_id; ?>) {
                            var select_value = "selected";
                        } else {
                            var select_value = '';
                        }
                        // CHILD_HTML += '<option value = "' + field.indicator_id + '">' + field.indicator_name + '</option>';
                        programs += '<option value="' + field.indicator_id + '" ' + select_value + ' >' + field.indicator_name + '</option>';
                    };
                    // $('.indicators').html(CHILD_HTML);
                }
                $('[name="indicator"]').html(programs);

                // Refresh options
                // $('[name="search"]').trigger('change');
                $('[name="indicator"]').multipleSelect('refresh');
                $('select[name="indicator"]').trigger('change');
            }
        });
    }

    $('body').on('change', '[name="indicator"]', function() {
        $elem = $(this);
        indicator_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators_details",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id
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
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });    

    $('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_countys",
            type: "POST",
            dataType: "json",
            data: {
                country_id: country_id
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
        $elem.prop('disabled', true);

        $('.error').html('');

        var form_id = "submit_data";
        var surveycount = 0;
        //check common 4 fields
        // year_id,rperiod_id,country_id,crop_id
        // if ($('select[name="year_id"]').val().length == 0) {
        //     $('select[name="year_id"]').next('.error').html('This field is required');
        //     surveycount++;
        //     $('.nothingto_report').prop("checked", false);
        // }else{
        //     $('select[name="year_id"]').next('.error').html('');
        // }
        // if ($('select[name="country_id"]').val().length == 0) {
        //     $('select[name="country_id"]').next('.error').html('This field is required');
        //     surveycount++;
        //     $('.nothingto_report').prop("checked", false);
        // }else{
        //     $('select[name="country_id"]').next('.error').html('');
        // }
        // if ($('select[name="rperiod_id"]').val().length == 0) {
        //     $('select[name="rperiod_id"]').next('.error').html('This field is required');
        //     surveycount++;
        //     $('.nothingto_report').prop("checked", false);
        // }else{
        //     $('select[name="rperiod_id"]').next('.error').html('');
        // }
        // if ($('select[name="crop_id"]').val().length == 0) {
        //     $('select[name="crop_id"]').next('.error').html('This field is required');
        //     surveycount++;
        //     $('.nothingto_report').prop("checked", false);
        // }else{
        //     $('select[name="crop_id"]').next('.error').html('');
        // }
        

        if (surveycount == 0) {
            var indicatorform = new FormData($('#' + form_id)[0]);
            indicatorform.append('record_id', <?php echo $record_id;?>);
            indicatorform.append('indicator_id', $('select[name="indicator"]').val());
            indicatorform.append('year_val', $('select[name="year"]').val());
            indicatorform.append('country_val', $('select[name="country"]').val());
            indicatorform.append('county_val', $('select[name="county"]').val());
            indicatorform.append('dimension_val', $('select[name="dimension"]').val());
            indicatorform.append('subdimension_val', $('select[name="subdimension"]').val());
            indicatorform.append('category_val', $('select[name="category"]').val());
            indicatorform.append('actual_val', $('input[name="actual"]').val());
           
            indicatorform.append('submit_type', 'submit');
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/update_indicatordata',
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

    
    /*
    $('body').on('change', '.dimension', function() {
        $elem = $(this);
        dimensions_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_subdimensions",
            type: "POST",
            dataType: "json",
            data: {
                dimensions_id: dimensions_id
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
                        CHILD_HTML += '<option value = "">Select Sub-Dimension</option>';
                        for (var field of response.result.lkp_sub_dimensions_list) {
                            CHILD_HTML += '<option value = "' + field.sub_dimensions_id + '">' + field.sub_dimensions_name + '</option>';
                        };
                        $('.subdimension').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    $('body').on('change', '.subdimension', function() {
        $elem = $(this);
        sub_dimensions_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_category",
            type: "POST",
            dataType: "json",
            data: {
                sub_dimensions_id: sub_dimensions_id
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
                        
                        for (var field of response.result.lkp_categories_list) {
                            CHILD_HTML += '<option value = "' + field.categories_id + '">' + field.categories_name + '</option>';
                        };
                        $('.category').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });

    $('body').on('change', '.category', function() {
        $elem = $(this);
        category_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators",
            type: "POST",
            dataType: "json",
            data: {
                category_id: category_id
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
                        
                        for (var field of response.result.lkp_indicators_list) {
                            CHILD_HTML += '<option value = "' + field.indicator_id + '">' + field.indicator_name + '</option>';
                        };
                        $('.indicators').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    */

</script>