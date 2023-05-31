<style type="text/css">
	label {
		font-weight: bold;
	}

	th {
		color: #FFFFFF;
	}

	label {
        font-weight: bold;
        min-height: 42px;
    }
</style>

<div class="modal fade" id="updateActivityData" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update data</h4>
			</div>

			<div class="modal-body">
				
			</div>

			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>

<div class="app-content page-body">
	<div class="container-fluid" style="margin-bottom: 50px;">
		<div class="row">
			<div class="col-md-12">
                <a href="javascript:close_window();" class="btn btn-sm btn-warning pull-right">Back</a>
				<h3 class="float-left"><?php echo $form_details['title']; ?></h3>
			</div>
			<div class="col-sm-1">
				<h5 class="mb-5 mt-2 text-dark lh-25px">Year: <?php echo $year_name; ?></h5>
			</div>
			<div class="col-sm-2">
				<h5 class="mb-5 mt-2 text-dark lh-25px">Country: <?php echo $country_name; ?></h5>
			</div>
			<div class="col-sm-2">
				<h5 class="mb-5 mt-2 text-dark lh-25px">Crop: <?php echo $crop_name; ?></h5>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel-body tabs-menu-body p-0">
					<div class="card">
						<div class="card-body">
							<form id="submit_data">
								<div class="row">
									<!-- <div class="col-sm-12 col-md-12 col-lg-12">
										<h4 class="text-danger"><?php echo $form_details['title']; ?></h4>
										<hr style="margin-top: 0px; border: none; height: 3px; background-color: #8e8ec0;">
									</div> -->
									<div class="col-sm-12 col-md-12 col-lg-5">
										<div class="form-group">
											<label><strong>Sub Activity</strong> <span class="text-danger">*</span></label>
											<textarea type="text" class="form-control" name="sub_activityname" rows="5" data-required="required"></textarea>
											<p class="error text-danger"></p>
										</div>
									</div>
									<div class="col-md-6 mt-20">
										<div class="row output_maindiv">
											<div class="col-md-12 outputdiv output_div">
												<div class="row">
													<div class="col-md-8">
														<label>Sub Activity mapped to Output/Indicator</label>
														<textarea class="form-control subactivity_output_field" rows="5" style="resize: none;" name="subactivityouput[]" data-subtype="text"></textarea>
														<p class="red-800 error"></p>
													</div>
													<div class="col-md-2">
														<button type="button" class="btn btn-primary btn-sm add_output" style="border-radius: 10px; margin-top: 50px;">
															<span class="glyphicon glyphicon-plus"></span> Output/Indicator
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="row">
											<div class="col-md-1">
												<div class="form-group">
													<label><strong>Budget</strong> <span class="text-danger">*</span></label>
													<input type="text" class="form-control"  name="budget" data-required="required" data-subtype="number">
													<p class="error text-danger"></p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Name of the person responsible for reporting activity</strong> <span class="text-danger">*</span></label>
													<input type="text" class="form-control" name="personname" data-required="required">
													<p class="error text-danger"></p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Designation of the person responsible for reporting activity</strong></label>
													<input type="text" class="form-control" name="persondesignation">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Email ID of the person responsible for reporting activity</strong></label>
													<input type="text" class="form-control" name="personemail">
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label><strong>Partners</strong></label>
													<input type="text" class="form-control" name="partner" >
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-7 mt-20">
										<div class="row contribution_maindiv">
											<div class="col-md-12 contributiondiv  contribution_div">
												<div class="row">
													<div class="col-md-4">
														<label>% of other contribution</label>
														<input type="text" class="form-control contribution desimal contribution_output_field" name="subactivitycontribution[]" data-subtype="desimal">
														<p class="red-800 error"></p>
													</div>
													<div class="col-md-5">
														<label>Contributing source</label>
														<input type="text" class="form-control contributionsource_output_field" name="subactivitycontributionsource[]" data-subtype="text" value="">
														<p class="red-800 error"></p>
													</div>
													<div class="col-md-1">
														<button type="button" class="btn btn-primary btn-sm add_contribution" style="border-radius: 10px; margin-top: 50px;">
															<span class="glyphicon glyphicon-plus"></span> Contribution
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 mt-5">
										<div class="form-group">
											<label><strong>Remarks</strong></label>
											<textarea class="form-control" name="remarks" rows="5"></textarea>
										</div>
									</div>
								
									<div class="col-md-12">
                                    	<label style="color:#c51205 !important"><input type="checkbox" class="nothingto_report" <?php echo ($nothingto_report == 0) ? '' : 'checked' ?>> Nothing planned for this year</label>
                                	</div>

									<div class="col-md-12">
										<button type="button" class="btn btn-sm btn-success pull-right submit_data <?php echo ($nothingto_report == 0) ? '' : 'hidden'; ?>">Submit data</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php if(count($get_activity_data) > 0){ ?>
				<div class="col-sm-12">
					<?php foreach ($get_activity_data as $key => $value) { 
						if($value['user_id'] == $this->session->userdata('login_id')){ ?>
							<a href="javascript:void(0);" class="btn btn-sm btn-danger pull-right deleteUserActivityData" data-subactivityid="<?php echo $value['id']; ?>">Delete activty data</a>
						<?php } ?>
						<div class="card p-10">
							<div class="table-responsive">
								<table class="table table-bordered table_th">
									<thead>
										<tr>
											<th>Sub Activity</th>
											<th>Budget</th>
											<th>Partners</th>
											<th>Remarks</th>
											<th>Name of the person</th>
											<th>Designation of the person</th>
											<th>Email ID of the person</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<?php echo $value['sub_activity']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['sub_activity']; ?>" data-fieldtype="sub_activity" data-recordid="<?php echo $value['id']; ?>" data-field_label="Sub Activity" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
											<td>
												<?php echo $value['sub_activity_budget']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['sub_activity_budget']; ?>" data-fieldtype="sub_activity_budget" data-recordid="<?php echo $value['id']; ?>" data-field_label="Budget" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
											<td>
												<?php echo $value['partners']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['partners']; ?>" data-fieldtype="partners" data-recordid="<?php echo $value['id']; ?>" data-field_label="Partners" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
											<td>
												<?php echo $value['remarks']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['remarks']; ?>" data-fieldtype="remarks" data-recordid="<?php echo $value['id']; ?>" data-field_label="Remarks" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
											<td>
												<?php echo $value['personname']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['personname']; ?>" data-fieldtype="personname" data-recordid="<?php echo $value['id']; ?>" data-field_label="Name of the person" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
											<td>
												<?php echo $value['persondesignation']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['persondesignation']; ?>" data-fieldtype="persondesignation" data-recordid="<?php echo $value['id']; ?>" data-field_label="Designation of the person" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
											<td>
												<?php echo $value['personemailid']; ?>
												<a href="javascript:void(0);" class="updatedata" data-oldvalue="<?php echo $value['personemailid']; ?>" data-fieldtype="personemailid" data-recordid="<?php echo $value['id']; ?>" data-field_label="Email ID of the person" data-datatype="activity"><i style="color: blue;" class="fa fa-edit"></i></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="row">
								<div class="col-sm-6 text-center">
									<h5>Contribution data</h5>
									<div class="table-responsive">
										<table class="table table-bordered table_th">
											<thead>
												<tr>
													<th>% of other contribution</th>
													<th>Contributing source</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($value['countribution_data'] as $key => $c_data) { ?>
													<tr>
														<td>
															<?php echo $c_data['contribution']; ?>
															<a href="javascript:void(0);" class="updatedata" data-fieldtype="contribution" data-recordid="<?php echo $value['id']; ?>" data-contributionrecordid="<?php echo $c_data['id']; ?>" data-field_label="% of other contribution" data-oldvalue="<?php echo $c_data['contribution']; ?>" data-datatype="contribution"><i style="color: blue;" class="fa fa-edit"></i></a>
														</td>
														<td>
															<?php echo $c_data['contributionsource']; ?>
															<a href="javascript:void(0);" class="updatedata" data-fieldtype="contributionsource" data-recordid="<?php echo $value['id']; ?>" data-contributionrecordid="<?php echo $c_data['id']; ?>" data-field_label="Contributing source" data-oldvalue="<?php echo $c_data['contributionsource']; ?>" data-datatype="contribution"><i style="color: blue;" class="fa fa-edit"></i></a>
														</td>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-sm-6 text-center">
									<h5>Output data</h5>
									<table class="table table-bordered table_th">
										<thead>
											<tr>
												<th>Sub Activity mapped to Output/Indicator</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($value['output_data'] as $key => $c_data) { ?>
												<tr>
													<td>
														<?php echo $c_data['subactivity_output']; ?>
														<a href="javascript:void(0);" class="updatedata" data-fieldtype="subactivity_output" data-recordid="<?php echo $value['id']; ?>" data-outputrecordid="<?php echo $c_data['id']; ?>" data-field_label="Sub Activity mapped to Output/Indicator" data-oldvalue="<?php echo $c_data['subactivity_output']; ?>" data-datatype="output"><i style="color: blue;" class="fa fa-edit"></i></a>
													</td>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php } ?>					
				</div>
			<?php } ?>
		</div>
	</div><!-- end app-content-->
</div>

<script type="text/javascript">
	$(function() {
        <?php if ($nothingto_report > 0) { ?>
            swal({
                title: 'You have selected Nothing planned for this year. Please uncheck it to continue to form submission.',
                icon: "warning",
                type: "warning",
                closeOnConfirm: true
            });
        <?php } ?>
    });

    $('body').on('click', '.nothingto_report', function() {
        $elem = $(this);

        if ($(this).prop("checked") == true) {
            swal({
                title: "Are you sure?",
                //text: "You are not reporting for current year?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>planning_budget/nothingto_report_activity",
                        type: "POST",
                        dataType: "json",
                        data: {
                            form_id: <?php echo $this->uri->segment('3'); ?>,
                            year_val: <?php echo $this->uri->segment('4'); ?>,
                            country_val: <?php echo $this->uri->segment('5'); ?>,
                            crop_val: <?php echo $this->uri->segment('6'); ?>
                        },
                        error: function() {
                            $('.nothingto_report').prop("checked", false);
                            swal({
                                title: 'Please check your internet connection and try again',
                                icon: "warning",
                                dangerMode: true,
                                closeOnConfirm: true
                            });
                        },
                        success: function(response) {
                            if (response.status == 0) {
                                $('.nothingto_report').prop("checked", false);

                                swal({
                                    title: response.msg,
                                    icon: "warning",
                                    dangerMode: true,
                                    closeOnConfirm: true
                                });
                            } else {
                                $('.submit_data').addClass('hidden');
                                $('.save_data').addClass('hidden');
                                swal.close();
                            }
                        }
                    });
                } else {
                    $('.nothingto_report').prop("checked", false);
                    swal("Cancelled", "", "error");
                }
            });
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>planning_budget/removenothingto_report_activity",
                type: "POST",
                dataType: "json",
                data: {
                    form_id: <?php echo $this->uri->segment('3'); ?>,
                    year_val: <?php echo $this->uri->segment('4'); ?>,
                    country_val: <?php echo $this->uri->segment('5'); ?>,
                    crop_val: <?php echo $this->uri->segment('6'); ?>
                },
                error: function() {
                    $('.nothingto_report').prop("checked", true);
                    swal({
                        title: 'Please check your internet connection and try again',
                        icon: "warning",
                        dangerMode: true,
                        closeOnConfirm: true
                    });
                },
                success: function(response) {
                    if (response.status == 0) {
                        $('.nothingto_report').prop("checked", true);

                        swal({
                            title: response.msg,
                            icon: "warning",
                            dangerMode: true,
                            closeOnConfirm: true
                        });
                    } else {
                        $('.submit_data').removeClass('hidden');
                        $('.save_data').removeClass('hidden');
                        swal.close();
                    }
                }
            });
        }
    });

	function close_window() {
		close();
	}

	$('body').on('click', '.cancelchanges', function(){
		location.reload();
	});

	$('body').on('click', '.updatedata', function(){
		$elem = $(this);

		var datatype = $elem.data('datatype');
		var fieldtype = $elem.data('fieldtype');
		var field_label = $elem.data('field_label');
		var oldvalue = $elem.data('oldvalue');
		var recordid = $elem.data('recordid');
		var outputrecordid = '';
		if(datatype == 'output'){
			outputrecordid = $elem.data('outputrecordid');
		}
		var contributionrecordid = '';
		if(datatype == 'contribution'){
			contributionrecordid = $elem.data('contributionrecordid');
		}

		switch(fieldtype){
			case 'sub_activity':
			case 'subactivity_output':
				var HTML_BODY = `<form id="updating_userdata">
					<div class="form-group">
						<label>`+field_label+`</label>
						<textarea class="form-control" name="`+fieldtype+`">`+oldvalue+`</textarea>
						<span class="error text-danger"></span>
					</div>
				</form>`;
				$('.modal-body').html(HTML_BODY);
				$('.modal-footer').html('<button type="button" class="btn btn-default pull-left cancelchanges">Cancel</button>\
					<button type="button" class="btn btn-info insertUpdatedData" data-datatype="'+datatype+'" data-recordid="'+recordid+'" data-outputrecordid="'+outputrecordid+'" data-contributionrecordid="'+contributionrecordid+'">Update</button>');
				$('#updateActivityData').modal('show');
				break;

			case 'sub_activity_budget':
			case 'contribution':
				var HTML_BODY = `<form id="updating_userdata">
					<div class="form-group">
						<label>`+field_label+`</label>
						<input type = "text" value="`+oldvalue+`" name="`+fieldtype+`" data-subtype="number" class="form-control">
						<span class="error text-danger"></span>
					</div>
				</form>`;
				$('.modal-body').html(HTML_BODY);
				$('.modal-footer').html('<button type="button" class="btn btn-default pull-left cancelchanges">Cancel</button>\
					<button type="button" class="btn btn-info insertUpdatedData" data-datatype="'+datatype+'" data-recordid="'+recordid+'" data-outputrecordid="'+outputrecordid+'" data-contributionrecordid="'+contributionrecordid+'">Update</button>');
				$('#updateActivityData').modal('show');
				break;

			default:
				var HTML_BODY = `<form id="updating_userdata">
					<div class="form-group">
						<label>`+field_label+`</label>
						<input type = "text" value="`+oldvalue+`" name="`+fieldtype+`" data-subtype="text" class="form-control">
						<span class="error text-danger"></span>
					</div>
				</form>`;
				$('.modal-body').html(HTML_BODY);
				$('.modal-footer').html('<button type="button" class="btn btn-default pull-left cancelchanges">Cancel</button>\
					<button type="button" class="btn btn-info insertUpdatedData" data-datatype="'+datatype+'" data-recordid="'+recordid+'" data-outputrecordid="'+outputrecordid+'" data-contributionrecordid="'+contributionrecordid+'">Update</button>');
				$('#updateActivityData').modal('show');
				break;
		}
	});

	$('body').on('click', '.insertUpdatedData', function(){
		var form = $(this);
		form.prop('disabled', true);

		$('.error').html('');
		var error_count = 0;
		var form_id = 'updating_userdata';
		var datatype = form.data('datatype');
		var recordid = form.data('recordid');
		var grouprecordid = '';
		if(datatype == 'group_data'){
			var grouprecordid = form.data('grouprecordid');
		}
		var outputrecordid = '';
		if(datatype == 'output'){
			outputrecordid = form.data('outputrecordid');
		}
		var contributionrecordid = '';
		if(datatype == 'contribution'){
			contributionrecordid = form.data('contributionrecordid');
		}

		form.closest('.modal-content').find('input[type=checkbox]', form_id).each(function() {				
			var name = $(this).attr("name");
			if ($("input:checkbox[name='" + name + "']:checked").length == 0) {
				$(this).closest('.form-group').find('.error').html('This field is required');
				error_count++;
			}
		});

		form.closest('.modal-content').find('select', form_id).each(function() {
            var name = $(this).attr("name");
            if ($.trim($(this).val()).length == 0) {
                $(this).closest('.form-group').find('.error').html('This is mandatory field');
                error_count++;
            }
    	});
    	
    	form.closest('.modal-content').find('input[type=text]', form_id).each(function() {
    		if ($.trim($(this).val()).length === 0) {
                $(this).next('.error').html('This is mandatory field');
                error_count++;
            }

        	var subtypevalue = $(this).data("subtype");
        	switch (subtypevalue) {
                case 'text':
                	var maxvalue = 250; 
        			var minvalue = 2;                    	
	            	if ($.trim($(this).val()).length < minvalue) {
		                $(this).closest('.form-group').find('.error').html('Minimum ' + minvalue + ' characters required.');
		                error_count++;
		            }
		            else if ($.trim($(this).val()).length > maxvalue) {
		                $(this).closest('.form-group').find('.error').html('Maximum ' + maxvalue + ' characters required.');
		                error_count++;
		            }
                	break;

                case 'number':
                	var maxvalue = 10; 
	            	var minvalue = 1;
	            	if (!/^(\d*\.?\d*)$/.test($(this).val())) {
                        $(this).next('.error').html('Please Enter only number');
                        error_count++;
                    } else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                        $(this).next('.error').html('Field can contain only proper decimal number.');
                        error_count++;
                    }else{
		                if ($.trim($(this).val()).length < minvalue) {
			                $(this).closest('.form-group').find('.error').html('Minimum ' + minvalue + ' characters required.');
			                error_count++;
			            }else if ($.trim($(this).val()).length > maxvalue) {
			                $(this).closest('.form-group').find('.error').html('Maximum ' + maxvalue + ' characters required.');
			                error_count++;
			            }
			        }
                	break;
            }       
    	});
		
		if(error_count == 0){
		 	var formData = new FormData($('#updating_userdata')[0]);
		 	formData.append('form_id', '<?php echo $this->uri->segment(3); ?>');
		 	formData.append('datatype', datatype);
		 	formData.append('recordid', recordid);
			if(datatype == 'output'){
				formData.append('outputrecordid', outputrecordid);
			}
			if(datatype == 'contribution'){
				formData.append('contributionrecordid', contributionrecordid);
			}
			$.ajax({
				url: '<?php echo base_url(); ?>planning_budget/insertUpdatedData',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				error: function() {
					$('button').prop('disabled', false);
					$.toast({
						heading: 'Network Error!',
						text: 'Could not establish connection to server. Please refresh the page and try again.',
						icon: 'error'
					});
				},
				success: function(data){
					var data = JSON.parse(data);
					
					// If validation error exists
					if(data.status == 0) {
						$.toast({
							heading: 'Error!',
							text: data.msg,
							icon: 'error',
							afterHidden: function () {
								form.prop('disabled', false);
								location.reload(true);
							}
						});
					}
					
					// If insert completed
					if(data.status == 1) {
						$.toast({
							heading: 'Success!',
							text: data.msg,
							icon: 'success',
							afterHidden: function () {
								form.prop('disabled', false);
								location.reload(true);
							}
						});
					}
				}
			});
		} else {
			form.prop('disabled', false);
		}
	});


	$('body').on('click', '.add_contribution', function(){
		$('.error').html('');

		var $template = $(this).closest('.contribution_maindiv').find('.contribution_div'),
		$clone    = $template
					.clone()
					.removeClass('contribution_div')
					.addClass('dulicate_contribution_div');
		$clone.find('.row').addClass('mt-10');  
		$clone.find('.subactcontributionrecordid').remove();
		$clone.find('.contribution_output_field').val('');
		$clone.find('.contributionsource_output_field').val('');
		$clone.find('span').remove();
		$clone.find('.add_contribution').parent().html('<button type="button" class="btn btn-danger btn-sm removecontribution" style="border-radius: 10px; margin-top:30px;"><span class="glyphicon glyphicon-minus"></span> Contribution</button>');
		$(this).closest('.contribution_maindiv').append($clone);
	}).on('click', '.removecontribution', function() {
		$elem = $(this);
		$elem.prop('disabled', true);
		$output_section = $elem.closest('.output_section');

		if (typeof $elem.data('recordid') !== 'undefined') {

			var country_val = $('select[name="country"]').val();
			var crop_val = $('select[name="crop"]').val();
			
			$.ajax({
				url: 'http://measure.icrisat.org/enumerator/deletecontribution',
				type: 'POST',
				dataType : 'json',
				data: {
					recordid : $(this).data('recordid'),
					country_val : country_val,
					crop_val : crop_val
				},
				error: function() {
					$elem.closest('.row').html('<div class="col-md-6">\
						<div class="alert alert-danger">Please check your internet connection and try again</div>\
					</div>');
				},
				success : function(response){
					if(response.status == 0){
						$elem.closest('.row').html('<div class="col-md-6">\
							<div class="alert alert-danger">'+response.msg+'</div>\
						</div>');
					}
				}
			});
		}

		$elem.closest('.row').remove();   

		var contribution_fields = $output_section.find('.contribution');
		var cal_contribution = 0;
		var contributionfields_count = 0;
		contribution_fields.each(function() {
			if($(this).val() != ''){
				contributionfields_count++;
			}
			var current_val = ($(this).val() == '') ? 0 : $(this).val();
			cal_contribution = cal_contribution + parseFloat(current_val);
		});

		var final_contribution = cal_contribution/contributionfields_count;

		$output_section.find('.final_contribution').html(final_contribution.toFixed(2));
	});

	$('body').on('click', '.add_output', function(){
		$('.error').html('');
		var $template = $(this).closest('.output_maindiv').find('.output_div'),
		$clone    = $template
					.clone()
					.removeClass('output_div')
					.addClass('dulicate_output_div');
		$clone.find('.row').addClass('mt-10');  
		$clone.find('.subactivity_output_field').val('');
		$clone.find('.subactoutputrecordid').remove();
		$clone.find('span').remove();
		$clone.find('.add_output').parent().html('<button type="button" class="btn btn-danger btn-sm removeoutput" style="border-radius: 10px; margin-top:30px;"><span class="glyphicon glyphicon-minus"></span> Output/Indicator</button>');
		$(this).closest('.output_maindiv').append($clone);
	}).on('click', '.removeoutput', function() {
		$elem = $(this);
		$elem.prop('disabled', true);

		if (typeof $elem.data('recordid') !== 'undefined') {

			var country_val = $('select[name="country"]').val();
			var crop_val = $('select[name="crop"]').val();
			
			$.ajax({
				url: 'http://measure.icrisat.org/enumerator/deleteoutput',
				type: 'POST',
				dataType : 'json',
				data: {
					recordid : $(this).data('recordid'),
					country_val : country_val,
					crop_val : crop_val
				},
				error: function() {
					$elem.closest('.row').html('<div class="col-md-6">\
						<div class="alert alert-danger">Please check your internet connection and try again</div>\
					</div>');
				},
				success : function(response){
					if(response.status == 1){
						$elem.closest('.row').remove();
					}else{
						$elem.closest('.row').html('<div class="col-md-6">\
							<div class="alert alert-danger">'+response.msg+'</div>\
						</div>');
					}
				}
			});
		}else{
			$elem.closest('.row').remove();   
		}
	});

	$('body').on('click', '.submit_data', function() {
		$elem = $(this);
		$elem.prop('disabled', true);

		$('.error').html('');

		var form_id = "submit_data";
		var surveycount = 0;

		$elem.closest('.card').find('input[type=text]', form_id).each(function() {
			var requiredvalue = $(this).data("required");
			var subtypevalue = $(this).data("subtype");
			var maxvalue = $(this).data("maxlength");

			if (requiredvalue == 'required') {
				if ($.trim($(this).val()).length === 0) {
					$(this).next('.error').html('This field is required');
					surveycount++;
				}
			}

			if (subtypevalue == 'number' || subtypevalue == 'desimal') {
				switch (subtypevalue) {
					case 'number':
						if ($(this).val().length > 0) {
							if (/^\d+$/.test($(this).val())) {
								$(this).next('.error').empty();
							} else {
								$(this).val('');
								$(this).next('.error').html('Please provide a valid number.');
								surveycount++;
							}
						}
						break;

					case 'desimal':
						if ($(this).val().length > 0) {
							if (!/^(\d*\.?\d*)$/.test($(this).val())) {
								$(this).next('.error').html('Please Enter only number');
								surveycount++;
							} else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
								$(this).next('.error').html('Field can contain only proper decimal number.');
								surveycount++;
							}
						}
						break;

					case 'percentage':
						if ($(this).val().length > 0) {
							if (!/^(\d*\.?\d*)$/.test($(this).val())) {
								$(this).next('.error').html('Please Enter only number');
								surveycount++;
							} else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
								$(this).next('.error').html('Field can contain only proper decimal number.');
								surveycount++;
							}
						}
						break;
				}
			}

			if ($.trim($(this).val()).length > maxvalue) {
				$(this).closest('.form-group').find('.maxlengtherror').html('Please Enter upto ' + maxvalue + ' character/number');
				surveycount++;
			}
		});

		$elem.closest('.card').find('textarea', form_id).each(function() {
			var requiredvalue = $(this).data("required");
			var subtypevalue = $(this).data("subtype");
			var maxvalue = $(this).data("maxlength");

			if (requiredvalue == 'required') {
				if ($.trim($(this).val()).length === 0) {
					$(this).next('.error').html('This field is required');
					surveycount++;
				}
			}

			if ($.trim($(this).val()).length > maxvalue) {
				$(this).closest('.form-group').find('.maxlengtherror').html('Please Enter upto ' + maxvalue + ' character/number');
				surveycount++;
			}
		});

		if (surveycount == 0) {
			var indicatorform = new FormData($('#' + form_id)[0]);
			indicatorform.append('form_id', <?php echo $this->uri->segment('3'); ?>);
			indicatorform.append('year_val', <?php echo $this->uri->segment('4'); ?>);
			indicatorform.append('country_val', <?php echo $this->uri->segment('5'); ?>);
			indicatorform.append('crop_val', <?php echo $this->uri->segment('6'); ?>);
			indicatorform.append('submit_type', 'submit');
			$.ajax({
				url: '<?php echo base_url(); ?>planning_budget/submit_activitydata',
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

	$('body').on('click', '.deleteUserActivityData', function(){
		var elem = $(this);
		var subactivityid = elem.data('subactivityid');
		swal({
			title: "Are you sure?",
			//text: "Please enter the reason for deleting of this record!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: '<?php echo base_url(); ?>planning_budget/deleteUserActivityData/',
					data: {
						activity_id : <?php echo $this->uri->segment(3); ?>,
						subactivityid : subactivityid
					},
					type: 'POST',
					dataType: 'json',
					complete: function(data) {
						var csrfData = JSON.parse(data.responseText);
						ajaxData[csrfData.csrfName] = csrfData.csrfHash;
						if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
							$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
						}
					},
					error: function() {
						$.toast({
							heading: 'Network Error!',
							text: 'Could not establish connection to server. Please refresh the page and try again.',
							icon: 'error',
							afterHidden: function () {
								location.reload(true);
							}
						});
					},
					success: function(data) {                   
						if(data.status == 0){
							$.toast({
								heading: 'Error!',
								text: data.msg,
								icon: 'error',
								afterHidden: function () {
									location.reload(true);
								}
							});
						}else{
							$.toast({
								heading: 'Success!',
								text: data.msg,
								icon: 'success',
								afterHidden: function () {
									location.reload(true);
								}
							});
						}
					}
				});
			}else {
				swal("Cancelled", "Data is not deleted", "error");
			}
		});
	});
</script>