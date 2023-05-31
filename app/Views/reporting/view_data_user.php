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
</style>
<link href="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />


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
                                            <h3 class="title mb-0">Validate Data</h3>
                                        </div>
                                        <!-- <div class="">
                                            <a href="index.html" class="btn btn-light1 btn-sm"><img src="./assets/images/icon-left-arrow.svg"> Back</a>
                                        </div> -->
                                    </div>
                                    <!-- <button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Refresh data</button> -->
                                </div>
                                <div class="card-body p-3">
                                    <form id="submit_data">
                                        <div class="form">
                                            <div class="row">
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
                                                <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Year </label>
                                                        <select class="form-control" name="year">
                                                            <option value="">Select Year</option>
                                                            <?php foreach ($lkp_year_list as $key => $option) { 
                                                                ?>
                                                                <option value = "<?php echo $option['year_id']; ?>"><?php echo $option['year']; ?></option> 
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
                                                                <option value = "<?php echo $option['country_id']; ?>"><?php echo $option['country_name']; ?></option> <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select County </label>
                                                        <select class="form-control county" name="">
                                                            <option selected>Select County</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label for=""> Select Dimension </label>
                                                        <select class="form-control dimension" name="dimension">
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
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Indicator </label>
                                                        <select class="form-control indicators" name="indicators">
                                                            <option>Select Indicator</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Enter the Actual value   </label>
                                                    <input type="number" class="form-control fieldgreen" placeholder="Enter the Actual value " value="4" name="">
                                                    </div>
                                                </div>
                                                

                                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                                <button class="btn btn-sm btn-success">filter</button>
                                                </div> -->
                                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                                    <a href="<?php echo base_url(); ?>reporting/upload_data" class="btn btn-sm btn-success"> Add</a>
                                                </div> 
                                            </div>
                                            <div id="datadiv">
                                                <table>
                                                    <tr><td>Please select indicator to view data<td></tr>
                                                </table>                                               
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
                        var CHILD_HTML_EMPTY = '';
                        var CHILD_HTML_EMPTY1 = '';
                        CHILD_HTML += '<option value = "">Select Sub-Dimension</option>';
                        CHILD_HTML_EMPTY += '<option value = "">Select Category</option>';
                        CHILD_HTML_EMPTY1 += '<option value = "">Select Indicator</option>';
                        for (var field of response.result.lkp_sub_dimensions_list) {
                            CHILD_HTML += '<option value = "' + field.sub_dimensions_id + '">' + field.sub_dimensions_name + '</option>';
                        };
                        $('.subdimension').html(CHILD_HTML);
                        $('.category').html(CHILD_HTML_EMPTY);
                        $('.indicators').html(CHILD_HTML_EMPTY1);
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
                        var CHILD_HTML_EMPTY = '';
                        CHILD_HTML += '<option value = "">Select Category</option>';
                        CHILD_HTML_EMPTY += '<option value = "">Select Indicator</option>';
                        for (var field of response.result.lkp_categories_list) {
                            CHILD_HTML += '<option value = "' + field.categories_id + '">' + field.categories_name + '</option>';
                        };
                        $('.category').html(CHILD_HTML);
                        $('.indicators').html(CHILD_HTML_EMPTY);
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
                        CHILD_HTML += '<option value = "">Select Indicator</option>';
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

    $('body').on('change', '.indicators', function() {
        $elem = $(this);
        indicator_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicator_data_user",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id,
                user_country: <?php echo $country_id;?>
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicator_data_list.length > 0) {
                        var CHILD_HTML = '';
                        CHILD_HTML += '<table class="table datatable">\
                            <thead>\
                                <th>Year</th>\
                                <th>Country</th>\
                                <th><?php echo $county_name;?></th>\
                                <th>Actual Value</th>\
                                <th>Status</th>\
                                <th>Send Back</th>\
                            </thead>\
                            <tbody>';
                            var query_status=0;
                        for (var queryfield of response.result.lkp_query_list) {
                            query_status=1;
                        }
                        for (var field of response.result.lkp_indicator_data_list) {

                            CHILD_HTML += '<tr><td>' + field.year + '</td><td>' + field.country_name + '</td><td>' + field.county_name + '</td><td>' + field.	actual_value + '</td>';
                            if(field.status=="2"){
                                CHILD_HTML += '<td>Submitted</td>';
                                // before remove rejected
                                // CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '/' + field.form_id + '" target="_blank">Edit data</a>|<button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Approve</button>|<button type="button" class="btn btn-sm btn-danger reject_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Reject</button>';
                                if(field.query_status==1){
                                    CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/verify_data/' + field.id + '/' + field.form_id + '" target="_blank">View Query</a>';
                                }else{
                                    CHILD_HTML += '<td>N/A</td>';
                                }
                            }else if(field.status=="3"){
                                CHILD_HTML += '<td>Approved</td>';
                                if(field.query_status==1){
                                    CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/verify_data/' + field.id + '/' + field.form_id + '" target="_blank">View Query</a>';
                                }else{
                                    CHILD_HTML += '<td>N/A</td>';
                                }
                            }else if(field.status=="4"){
                                CHILD_HTML += '<td>Rejected</td>';
                                if(field.query_status==1){
                                    CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/verify_data/' + field.id + '/' + field.form_id + '" target="_blank">View Query</a>';
                                }else{
                                    CHILD_HTML += '<td>N/A</td>';
                                }
                            }else{
                                // before remove rejected
                                // CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '/' + field.form_id + '" target="_blank">Edit data</a>|<button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Approve</button>|<button type="button" class="btn btn-sm btn-danger reject_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Reject</button>';
                                CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/verify_data/' + field.id + '/' + field.form_id + '" target="_blank">Verify data</a>';
                            }
                            CHILD_HTML += '</tr>';
                        };
                        CHILD_HTML += '</tbody>\
                        </table>';
                        $('#datadiv').html(CHILD_HTML);
                    }else{
                        var CHILD_HTML = '';
                        CHILD_HTML += '<table class="table datatable">\
                            <tbody>';                            
                        CHILD_HTML += '<tr><td ><span style="color:red;">No data for this Indicator</span></td></tr>';
                        CHILD_HTML += '</tbody>\
                        </table>';
                        $('#datadiv').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    
    $('body').on('click', '.approve_data', function(){
		$elem = $(this);

		var recordid = $elem.data('recordid');

		swal({
			title: "Are you sure?",
			text: "you want to approve current record!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, approve it!",
			cancelButtonText: "No, cancel please!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
			   	$.ajax({
					url: "<?php echo base_url(); ?>reporting/approve_data",
					type: "POST",
					dataType: "json",
					data : {
						// recordid : recordid,
						record_id : recordid
					},
					error : function(){						
						$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
					},
					success : function(response){
						if(response.status == 0){
							$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800" style="font-weight:bold;">'+response.msg+'</p>');

							swal({
	                            title: response.msg,
	                            icon: "warning",
	                            dangerMode : true,
	                            closeOnConfirm: true
	                        });

						}else{
							$elem.closest('.row').find('.ajax_response').html('<p align="center" style="color:green; font-weight:bold;">'+response.msg+'</p>');

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
                            $('[name="indicators"]').trigger('change');
						}
					}
				});
			} else {
				swal("Cancelled", "Data is not yet approved", "error");
			}
		});
	});

    $('body').on('click', '.reject_data', function(){
		$elem = $(this);

		var recordid = $elem.data('recordid');

		swal({
			title: "Are you sure?",
			text: "you want to reject current record!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, reject it!",
			cancelButtonText: "No, cancel please!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
			   	$.ajax({
					url: "<?php echo base_url(); ?>reporting/reject_data",
					type: "POST",
					dataType: "json",
					data : {
						// recordid : recordid,
						record_id : recordid
					},
					error : function(){						
						$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
					},
					success : function(response){
						if(response.status == 0){
							$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800" style="font-weight:bold;">'+response.msg+'</p>');

							swal({
	                            title: response.msg,
	                            icon: "warning",
	                            dangerMode : true,
	                            closeOnConfirm: true
	                        });

						}else{
							$elem.closest('.row').find('.ajax_response').html('<p align="center" style="color:green; font-weight:bold;">'+response.msg+'</p>');

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
                            $('[name="indicators"]').trigger('change');
						}
					}
				});
			} else {
				swal("Cancelled", "Data is not yet Rejected", "error");
			}
		});
	});

</script>