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
    .tcolorg{
        color:green !important;
    }
    .tcolorb{
        color:blue !important;
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
                                            <h3 class="title mb-0">Verify Data</h3>
                                        </div>
                                        <!-- <div class="">
                                            <a href="index.html" class="btn btn-light1 btn-sm"><img src="./assets/images/icon-left-arrow.svg"> Back</a>
                                        </div> -->
                                    </div>
                                    <!-- <button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Refresh data</button> -->
                                </div>
                                <div class="card-body p-3">
                                    <form id="queryForm" data-id="<?php echo $data_id;?>" data-user="<?php echo $this->session->get('login_id');?>">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <div class="form">
                                            <div class="row">
                                                <?php foreach($data_list as $key =>$value){
                                                    // $user_id = $value['user_id'];
                                                    $user_id = $this->session->get('login_id');
                                                    $record_status=$value['status'];
                                                }

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
                                                } ?>
                                               
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Dimension </label> : <?php echo $lkp_dimensions_name;?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">Sub-Dimension </label> : <?php echo $lkp_sub_dimensions_name;?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">Category </label> : <?php echo $lkp_categories_name;?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">Year </label> : <?php echo $lkp_year_name;?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">Country </label> : <?php echo $lkp_country_name;?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">County </label> : <?php echo $lkp_county_name;?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">Actual Value </label> : 
                                                            <?php if($role_id==5 && $record_status==2){
                                                                ?>
                                                                <input type="text" class="form-control" name="actual_value" id="actual_value" value="<?php echo $lkp_acutal_value;?>"/>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <?php echo $lkp_acutal_value;?>
                                                                <?php
                                                            } ?>
                                                            
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for="">Indicator </label> : <?php echo $lkp_indicator_name;?>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="col-sm-12 form-group">
                                                        <div class="borderMsg" style="border-bottom:none !important;border: 4px solid black !important;">
                                                            <?php if($queries){
                                                                foreach($queries as $qkey =>$qvalue){
                                                                    if($qvalue['sent_by'] == $user_id){ ?>
                                                                        <div class="media d-block d-sm-flex text-right">
                                                                            <div class="media-body pt-3 pt-sm-0 m-3 tcolorg">
                                                                                <h5 class="mg-b-5 tx-inverse tx-15">
                                                                                    <i class="fa fa-calendar"></i> Posted On : <?php echo $qvalue['query_datetime']?>
                                                                                    <span class="mx-1">|</span>
                                                                                    <i class="fa fa-user"></i> By : <?php echo $qvalue['first_name']?> <?php echo $qvalue['last_name']?> 
                                                                                </h5>
                                                                                <p><?php echo $qvalue['query']?> </p>
                                                                                <hr class="my-4">
                                                                            </div>
                                                                        </div>
                                                                    <?php }else{ ?>
                                                                        <div class="media d-block d-sm-flex">
                                                                            <div class="media-body pt-3 pt-sm-0 m-3 tcolorb">
                                                                                <h5 class="mg-b-5 tx-inverse tx-15">
                                                                                    <i class="fa fa-user"></i> By : <?php echo $qvalue['first_name']?> <?php echo $qvalue['last_name']?>
                                                                                    <span class="mx-1">|</span>
                                                                                    <i class="fa fa-calendar"></i> Posted On : <?php echo $qvalue['query_datetime']?>
                                                                                </h5>
                                                                                <p><?php echo $qvalue['query']?> </p>
                                                                                <hr class="my-4">
                                                                            </div>
                                                                        </div>
                                                                    <?php } 
                                                                }
                                                                if($role_id==5){
                                                                    $c_text="Respond to the query...";
                                                                } else if($role_id==6){
                                                                    $c_text="Comment...";
                                                                }else{
                                                                    $c_text="Comment...";
                                                                }
                                                            }else{
                                                                $c_text="Comment...";
                                                            } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <?php if(isset($record_status) && $record_status==2){ ?>
                                                            <textarea class="form-control" name="query" placeholder="<?php echo $c_text;?>"></textarea>
                                                            <span class="query error text-danger"></span>
                                                        <?php } ?>
                                                    </div>
                                                    
                                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <?php if(isset($record_status) && $record_status==2){ ?>
                                                            <button class="btn btn-success btn-sm" type="submit">Send Back</button>
                                                            <?php if($role_id==6){ ?>
                                                                <button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="<?php echo $record_id;?>" style="margin-right:10px;">Approve</button>
                                                                
                                                            <?php }
                                                        }else{
                                                            echo "This data has been approved and cannot be further verified or sent back";
                                                        } ?>  
                                                    </div>
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

    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    $('body').on('submit', '#queryForm', function(event) {
        event.preventDefault();
        var form = $(this),
        formData = new FormData(form[0]);
        formData.append('id', form.data('id'));
        var roleID = <?php echo $role_id?>;
        var path= "";
        if(roleID == 6 || roleID == 1){
            // Country Admin
            path= "<?php echo base_url(); ?>reporting/send_back";
        }else if(roleID == 5){
            //county Admin
            path= "<?php echo base_url(); ?>reporting/respond_query";
        }
		form.find('button').prop('disabled', true);
		$.ajax({
			url: path,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			error: function() {
                $.toast({
                    heading: 'Error!',
                    text: 'Please check your internet connection and try again.',
                    icon: 'error'
                });
                form.find('button').prop('disabled', false);
            },
            complete: function(data) {
                var csrfData = JSON.parse(data.responseText);
                csrfName = csrfData.csrfName;
                csrfHash = csrfData.csrfHash;
                if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                    $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                }
            },
            success: function(response){
                if(response.status == 0) {
                    if(response.errors && response.errors.length > 0) {
                        for(var key in response.errors) {
                            var errorContainer = form.find(`.${key}.error`);
                            if(errorContainer.length !== 0) {
                                errorContainer.html(response.errors[key]);
                            }
                        }
                    } else {
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error',
                            afterHidden: function () {
                                form.find('button').prop('disabled', false);
                            }
                        });
                    }
                    return false;
                }

                var HTML = ``;
                if(response.query.sent_by == form.data('user')) {
                    HTML = `<div class="media d-block d-sm-flex text-right">
                        <div class="media-body pt-3 pt-sm-0 m-3">
                            <h5 class="mg-b-5 tx-inverse tx-15">
                                <i class="fa fa-calendar"></i> Posted On : ${response.query.query_datetime}
                                <span class="mx-1">|</span>
                                <i class="fa fa-user"></i> By : ${response.query.first_name} ${response.query.last_name}
                            </h5>
                            <p>${response.query.query}</p>
                            <hr class="my-4">
                        </div>
                    </div>`;
                } else {
                    HTML = `<div class="media d-block d-sm-flex">
                        <div class="media-body pt-3 pt-sm-0 m-3">
                            <h5 class="mg-b-5 tx-inverse tx-15">
                                <i class="fa fa-user"></i> By : ${response.query.first_name} ${response.query.last_name}
                                <span class="mx-1">|</span>
                                <i class="fa fa-calendar"></i> Posted On : ${response.query.query_datetime}
                            </h5>
                            <p>${response.query.query}</p>
                            <hr class="my-4">
                        </div>
                    </div>`;
                }
                $('.borderMsg').append(HTML);
                
                $.toast({
                    heading: 'Success!',
                    text: response.msg,
                    icon: 'success',
                    afterHidden: function () {
                        $('#queryForm').each(function() {
                            this.reset();
                        });
                        form.find('button').prop('disabled', false);
                    }
                });
            }
		});
	});

    $('body').on('change', '.indicators', function() {
        $elem = $(this);
        indicator_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicator_data",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id,
                user_country: <?php echo $country_id;?>,
                csrf_test_name: csrfHash
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            complete: function(data) {
                var csrfData = JSON.parse(data.responseText);
                csrfName = csrfData.csrfName;
                csrfHash = csrfData.csrfHash;
                if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                    $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                }
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
                                <th>Actions</th>\
                            </thead>\
                            <tbody>';
                            
                        for (var field of response.result.lkp_indicator_data_list) {
                            CHILD_HTML += '<tr><td>' + field.year + '</td><td>' + field.country_name + '</td><td>' + field.county_name + '</td><td>' + field.	actual_value + '</td>';
                            if(field.status=="2"){
                                CHILD_HTML += '<td>Submitted</td>';
                                // before remove rejected
                                // CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '/' + field.form_id + '" target="_blank">Edit data</a>|<button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Approve</button>|<button type="button" class="btn btn-sm btn-danger reject_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Reject</button>';
                                CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/verify_data/' + field.id + '/' + field.form_id + '" target="_blank">Verify data</a>|<button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Approve</button>';
                            }else if(field.status=="3"){
                                CHILD_HTML += '<td>Approved</td><td>N/A</td>';
                            }else if(field.status=="4"){
                                CHILD_HTML += '<td>Rejected</td><td>N/A</td>';
                            }else{
                                // before remove rejected
                                // CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '/' + field.form_id + '" target="_blank">Edit data</a>|<button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Approve</button>|<button type="button" class="btn btn-sm btn-danger reject_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Reject</button>';
                                CHILD_HTML += '<td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/verify_data/' + field.id + '/' + field.form_id + '" target="_blank">Verify data</a>|<button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="'+ field.id +'" style="margin-right:10px;">Approve</button>';
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
			text: "You want to approve current record! (Once approved you cannot comment on this data point anymore)",
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
						record_id : recordid,
                        csrf_test_name: csrfHash
					},
					error : function(){						
						$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
					},
                    complete: function(data) {
                        var csrfData = JSON.parse(data.responseText);
                        csrfName = csrfData.csrfName;
                        csrfHash = csrfData.csrfHash;
                        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                            $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                        }
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
						record_id : recordid,
                        csrf_test_name: csrfHash
					},
					error : function(){						
						$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
					},
                    complete: function(data) {
                        var csrfData = JSON.parse(data.responseText);
                        csrfName = csrfData.csrfName;
                        csrfHash = csrfData.csrfHash;
                        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                            $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                        }
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