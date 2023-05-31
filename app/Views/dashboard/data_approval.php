<style type="text/css">
	.form-control button { border: none !important; }
	.form-control span { margin: 5px; }
	.ms-drop.bottom { left: 0; }

	/* loading dots */
	.loading:after {
		content: ' .';
		padding-right: 5px;
		animation: dots 1s steps(5, end) infinite;
	}
	.btn-back{
		position: absolute;
		right: 20px;
		top: 0;
	}
	@keyframes dots {
		0%, 20% {
			color: rgba(255,255,255,0);
			text-shadow:
			.25em 0 0 rgba(255,255,255,0),
			.5em 0 0 rgba(255,255,255,0);
		}
		40% {
			color: black;
			text-shadow:
			.25em 0 0 rgba(255,255,255,0),
			.5em 0 0 rgba(255,255,255,0);
		}
		60% {
			text-shadow:
			.25em 0 0 black,
			.5em 0 0 rgba(255,255,255,0);
		}
		80%, 100% {
			text-shadow:
			.25em 0 0 black,
			.5em 0 0 black;
		}
	}
</style>

<!-- Edit Data Modal -->
<div class="modal fade" id="sendBackModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Send back query</h3>
			</div>
			
			<?php echo form_open('', array('id'=>'sendBackForm')); ?>
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
			<div class="col-sm-12">
				<h3>Approval Dashboard</h3>
				<a href="<?php echo base_url(); ?>dashboard/approval" class="btn btn-sm btn-primary btn-back">Back</a>
				<!-- Year Country Crop -->
				<!-- <div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Year</label>
									<select name="year" placeholder="Select Year" class="form-control">
										<?php foreach ($year_list as $key => $year) {
											$selected = ($key == 0) ? 'selected' : ''; ?>
											<option value="<?php echo $year['year_id']; ?>" <?php echo $selected; ?>>
												<?php echo $year['year']; ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Country</label>
									<select name="country" placeholder="Select Country" class="form-control"></select>
								</div>
							</div>
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Crop</label>
									<select name="crop" placeholder="Select Crop" class="form-control"></select>
								</div>
							</div>
						</div>
					</div>
				</div> -->
				<h4 class="h4_heading formtitle"></h4>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 usersindicator_list"></div>
						</div>
					</div>
				</div>

				<!-- PO Tab -->
				<div class="panel panel-primary">
					<div class="tab-menu-heading p-0 bg-light">
						<div class="tabs-menu1">
							<!-- Tabs -->
							<ul class="nav panel-tabs po"></ul>
						</div>
					</div>

					<div class="tabs-menu-body p-0">
						<!-- Tabs Content -->
						<div class="tab-content po"></div>
					</div>
				</div>
			</div><!-- end app-content-->
		</div>
	</div>
</div>
</div>

<!-- Page Script -->
<script type="text/javascript">
	$(function() {
		// $('[name="year"]').on('change', function (event) {
		// 	getCountry();
		// }).multipleSelect({
		// 	filter: true
		// });

		// $('[name="country"]').on('change', function (event) {
		// 	getCrops();
		// }).multipleSelect({
		// 	filter: true
		// });

		// $('[name="crop"]').on('change', function (event) {
		// 	get_IndicatorData();
		// }).multipleSelect({
		// 	filter: true
		// });
		
		// $('[name="year"]').trigger('change');
		// getCountry(true);
		get_IndicatorData(true)
	});

	/*function getCountry(firstTime = false) {
		$('[name="country"]').html('');
		
		// AJAX to get country and crop
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_country',
			type: 'POST',
			dataType:'JSON',
			data: { purpose: 'approval', year: $('[name="year"]').val() },
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
				if(response.status == 0) {
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
				
				var countries = '';
				response.countries.forEach(function(country, index) {
					var selected = '';
					if(firstTime) {
						var selectedCountry = <?php echo $this->uri->segment('5'); ?>;
						if(country.country_id == selectedCountry) selected = 'selected';
					} else {
						if(index == 0) selected = 'selected';
					}
					countries += '<option value="'+country.country_id+'" '+selected+'>'+country.country_name+'</option>'
				});
				$('[name="country"]').html(countries);

				// Refresh options
				if(!firstTime) {
					$('[name="country"]').trigger('change');
					$('[name="country"]').multipleSelect('refresh');
				} else {
					getCrops(firstTime);
					$('[name="country"]').multipleSelect('refresh');
				}
			}
		});
	}

	function getCrops(firstTime = false) {
		$('[name="crop"]').html('');

		// AJAX to get crop
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_crop',
			type: 'POST',
			dataType:'JSON',
			data: {
				purpose: 'approval',
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val()
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
				if(response.status == 0) {
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
				
				var crops = '';
				response.crops.forEach(function(crop, index) {
					var selected = '';
					if(firstTime) {
						var selectedCrop = <?php echo $this->uri->segment('6'); ?>;
						if(crop.crop_id == selectedCrop) selected = 'selected';
					} else {
						if(index == 0) selected = 'selected';
					}
					crops += '<option value="'+crop.crop_id+'" '+selected+'>'+crop.crop_name+'</option>'
				});
				$('[name="crop"]').html(crops);

				// Refresh options
				$('[name="crop"]').trigger('change');
				$('[name="crop"]').multipleSelect('refresh');
			}
		});
	}*/

	function get_IndicatorData() {
		var ajax_data = {
			year_val : <?php echo $this->uri->segment(3); ?>,
			form_id : <?php echo $this->uri->segment(4); ?>
		}
		var cl_count=0;
		var user_role = <?php echo $this->session->userdata('role'); ?>;
		if(ajax_data.country != '' && ajax_data.crop != ''){
			$.ajax({
				url: "<?php echo base_url(); ?>dashboard/get_indicatorsdata_toapprove",
				type: "POST",
				dataType: "json",
				data : ajax_data,
				error : function(){
					$('.loading').parent().addClass('hidden');
					$('.usersindicator_list').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
				},
				success : function(response){
					if(response.status == 0){
						$('.usersindicator_list').html('<p align="center" class="red-800">'+response.msg+'</p>');
					}else{
						$('.formtitle').html(response.title['title']);
						var indicator_fields = '';

						indicator_fields += `<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">`;
									if(typeof response.indicator_field_data !== 'undefined' && response.indicator_field_data.length > 0){
										response.indicator_field_data.forEach(function(f_indicator, f_index){
											if (typeof response.group_array !== 'undefined' && response.group_array.length > 0) {
												var grouptable = 'yes';
											}else{
												var grouptable = 'no';
											}

											indicator_fields += `<div class="row main_div">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-4">
															<label style="background-color: #ff0000; width: 30px; text-align: center; color: #FFFFFF !important; margin-bottom: 0px; margin-top:10px;">`+(f_index+1)+`</label>
														</div>
														<div class="col-md-4">
															<h4 class="title">Submitted by: `+f_indicator.username+`</h4>
														</div>
														<div class="col-md-4">
															<p class="pull-right"> Submitted on: `+f_indicator.reg_date_time+` (UTC)</p>
														</div>
													</div>
													<hr style="margin-top: 0px; border: none; height: 1px; background-color: #030195;">
												</div>
												<div class="col-md-12">
													<div class="table-responsive">
									    				<table class="table table-bordered table_th m-0">
															<thead>
																<tr>
																	<th>Country</th>
																	<th>Crop</th>
																	<th>Comment</th>`;
																	response.indicator_fields.forEach(function(field, index){
																		indicator_fields += '<th>'+field.label+'</th>';
																	});
																indicator_fields += `</tr>
															</thead>
															<tbody>
																<tr>
																	<td>`+f_indicator.country_name+`</td>
																	<td>`+f_indicator.crop_name+`</td>
																	<td>`+(f_indicator.comment == null ? "N/A" : f_indicator.comment)+`</td>`;
																	if(f_indicator.form_data == null){
																		var jsondata = [];
																	}else{
																		var jsondata = jQuery.parseJSON(f_indicator.form_data);
																	}																	
																	response.indicator_fields.forEach(function(field, index){
																		var field_key = "field_"+field.field_id;

																		switch(field.type){
																			case 'header':
																				indicator_fields += '<td></td>';
																				break;

																			case 'lkp_cluster':
																					cl_count=0;
																					response.lkp_cluster.forEach(function(cluster, cindex){
																						if(cluster.cluster_id == jsondata[field_key]){
																							indicator_fields += '<td>'+cluster.cluster_name+'</td>';
																							cl_count=cl_count+1;
																						}
																					});
																					if(cl_count==0){
																						indicator_fields += '<td>N/A</td>';
																					}
																				break;

																			default:
																				if(jsondata[field_key] == null || jsondata[field_key] == ''){
																					indicator_fields += '<td>N/A</td>';
																				}else{
																					if(field.type != 'uploadfile'){
																						indicator_fields += '<td>'+jsondata[field_key]+'</td>';
																					}else{
																						indicator_fields += '<td>\
																							<a href="<?php echo base_url(); ?>upload/survey/'+jsondata[field_key]+'" download>Download file</a>\
																						</td>';
																					}	
																				}
																				break;
																		}		
																	});
																indicator_fields += '</tr>\
															</tbody>\
														</table>\
													</div>\
												</div>\
												<div class="col-md-12" style="margin-top:10px;">';
													if (typeof response.group_array !== 'undefined' && response.group_array.length > 0) {
														response.group_array.forEach(function(group, index){
															indicator_fields += '<h4 class="title">'+group.group_lable.label+'</h4>\
															<div class="table-responsive">\
										        				<table class="table table-bordered mt-10" id="datatable">\
																	<thead>\
																		<tr>\
																			<th>Sl.no</th>';
																			group.group_fields.forEach(function(g_field, index){
																				indicator_fields += '<th>'+g_field.label+'</th>';
																			});
																			// if(user_role == 6){
																			// 	indicator_fields += '<th>Action</th>';
																			// }
																		indicator_fields += '</tr>\
																	</thead>\
																	<tbody>';
																		f_indicator.groupdata.forEach(function(g_data, g_index){
																			var group_table = "ic_form_group_data";
																			if(g_data.groupfield_id == group.group_lable.field_id){
																				var jsondata_group = jQuery.parseJSON(g_data.formgroup_data);
																				indicator_fields += '<tr>\
																					<td>'+(g_index+1)+'</td>';
																					group.group_fields.forEach(function(g_field, index){
																						var field_key = "field_"+g_field.field_id;
																						indicator_fields += '<td>'+(jsondata_group[field_key] == null ? "N/A" : jsondata_group[field_key])+'</td>';
																					});
																					// if(user_role == 6){
																					// 	indicator_fields += '<td>\
																					// 		<a class="delete_groupdata" style="color: red;" data-group_recordid = "'+g_data.group_id+'" data-recordid = "'+f_indicator.data_id+'" data-group_table = "'+group_table+'"><i class="fa fa-trash" style="font-size:18px;"></i> Delete</a>\
																					// 	</td>';
																					// }
																				indicator_fields += '</tr>';
																			}
																		});
																	indicator_fields += '</tbody>\
																</table>\
															</div>';
														});
													}
												indicator_fields += `</div>
												<div class="col-md-12 indicator_details"></div>
												<div class=" col-md-12 ajax_response"></div>
												<div class="col-md-12 actionbutton_divs" id="buttondiv" style="margin-bottom:40px;">`;
													var tablename = "ic_form_data";
													var group_table = "ic_form_group_data";

													var indicator_button = '';
													if(user_role == 6){	
														indicator_button += '<button type="button" class="btn btn-sm btn-danger pull-right delete_data" data-recordid="'+f_indicator.data_id+'">Delete</button>';
													}

													if(user_role == 4 || user_role == 5 || user_role == 6){														
														indicator_button += '<button type="button" class="btn btn-sm btn-success pull-right approve_data"  data-recordid="'+f_indicator.data_id+'" style="margin-right:10px;">Approve</button>';

														// indicator_button += '<button type="button" class="btn btn-sm btn-success pull-right edit_andapprovedata" data-recordid="'+f_indicator.data_id+'" style="margin-right:10px;">Edit & approve</button>';
														indicator_button += '<button type="button" class="btn btn-sm btn-danger pull-right reject_data" data-recordid="'+f_indicator.data_id+'" style="margin-right:10px;">Reject</button>';

														/*indicator_button += '<button type="button" class="btn btn-sm btn-warning pull-right send_back" data-recordid="'+f_indicator.data_id+'" data-by="'+f_indicator.username+'" style="margin-right:10px;">Send Back</button>';*/
													}													
													indicator_fields += indicator_button;

													if(f_indicator.nothingto_report == 1){
														indicator_fields += '<p class="text-danger" style="font-weight:bold;">"User has selected Nothing to Report"</p>';
													}
													
												indicator_fields += '</div>';
											indicator_fields += '</div>';
										});
									}else{
										indicator_fields += '<div class="row">\
											<div class="col-md-12">\
												<h5 class="title text-center">No data found</h5>\
											</div>\
										</div>';
									}
								indicator_fields += '</div>\
							</div>\
						</div>';
						$('.usersindicator_list').html(indicator_fields);
						$('.loading').parent().addClass('hidden');
					}
				}
			});
		}else{
			if(country == ''){
				$('.country_error').html('Country is mandatory');				
			}

			if(crop == ''){
				$('.crop_error').html('Crop is mandatory');				
			}

			if(po_val == ''){
				$('.po_error').html('PO is mandatory');
			}

			if(user == ''){
				$('.user_error').html('User is mandatory');
			}

			$('.loading').parent().addClass('hidden');
			$('.usersindicator_list').html('<div class="col-md-12"><div class="card p-10">Select any one PO</div></div>');
		}
	}

	$('body').on('click', '.cancel', function(){
		$elem = $(this);

		$elem.closest('.main_div').find('.actionbutton_divs').removeClass('hidden');
		$elem.closest('.main_div').find('.indicator_details').html('');
	});

	$('body').on('click', '.delete_groupdata', function(){
		$elem = $(this);
		var recordid = $elem.data("recordid");
		var group_recordid = $elem.data("group_recordid");
		var group_table = $elem.data("group_table");

		swal({
			title: "Are you sure?",
			text: "Please enter the reason for deleting of this record!",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Reason"
		}, function (inputValue) {
			if (inputValue === false) return false;
			if (inputValue === "") {
				swal.showInputError("You need to write something!");
				return false
			}

			$.ajax({
				url: "<?php echo base_url(); ?>dashboard/delete_groupdata",
				type: "POST",
				dataType: "json",
				data : {
					recordid : recordid,
        			group_recordid : group_recordid,
        			group_table : group_table,
        			reason : inputValue
				},
				error : function(){
					swal({
                        title: 'Some thing went wrong please try after sometime.',
                        icon: "warning",
                        dangerMode : true,
                        closeOnConfirm: true
                    });
				},
				success : function(response){
					if(response.status == 0){
						swal({
                            title: response.msg,
                            icon: "warning",
                            dangerMode : true,
                            closeOnConfirm: true
                        });

					}else{
						$elem.closest('tr').remove('');

						swal({
                            title: response.msg,
                            icon: "success",
                            closeOnConfirm: true
                        });
					}
				}
			});
		});
	});

	$('body').on('click', '.delete_data', function(){
		$elem = $(this);

		var recordid = $elem.data('recordid');

		swal({
			title: "Are you sure?",
			text: "Please enter the reason for deleting of this record!",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Reason"
		}, function (inputValue) {
			if (inputValue === false) return false;
			if (inputValue === "") {
				swal.showInputError("You need to write something!");
				return false
			}
			$.ajax({
				url: "<?php echo base_url(); ?>dashboard/delete_data",
				type: "POST",
				dataType: "json",
				data : {
					recordid : recordid,
				   	reason : inputValue
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
						$elem.closest('.row').find('.delete_groupdata').html('');
						$elem.closest('.actionbutton_divs').html('');						

						swal({
                            title: response.msg,
                            icon: "success",
                            closeOnConfirm: true
                        });
					}
				}
			});
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
					url: "<?php echo base_url(); ?>dashboard/approve_data",
					type: "POST",
					dataType: "json",
					data : {
						recordid : recordid,
						form_id : <?php echo $this->uri->segment(4); ?>
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

							$elem.closest('.row').find('.delete_groupdata').html('');

							$elem.closest('.actionbutton_divs').html('');						

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
						}
					}
				});
			} else {
				swal("Cancelled", "Data is not yet approved", "error");
			}
		});
	});

	$('body').on('click', '.edit_andapprovedata', function(){
		$elem = $(this);
        $elem.prop('disabled', true);
        $elem.closest('.row').find('.indicator_details').html('');

        var loading = '<div class="col-md-12 text-center">\
			<img class="loading" src="<?php echo base_url(); ?>include/app-assets/images/loading.gif" style="height: 70px;">\
			<p>Please wait...</p>\
        </div>';

        $elem.closest('.row').find('.indicator_details').html(loading);

        $('html,body').animate({
          	scrollTop: $elem.closest('.row').find('.indicator_details').offset().top - 300
        }, 500);

		var recordid = $elem.data("recordid");

		$.ajax({
            url: '<?php echo base_url(); ?>dashboard/edit_andapprovedata',
            type: 'POST',
            dataType : 'json',
            data :{
            	recordid : recordid,
            	form_id : <?php echo $this->uri->segment(4); ?>
            },
            error: function() {
            	$elem.prop('disabled', false);
                swal({
                    title: 'Please check your internet connection and try again.',
                    icon: "warning",
                    dangerMode : true,
                    closeOnConfirm: true
                });
            },
            success: function(response){
                if(response.status == 0){
                    swal({
                        title: response.msg,
                        icon: "warning",
                        dangerMode : true,
                        closeOnConfirm: true
                    });
                }else{
                	var indicator_fields = '<form id="submit_data">';
                		indicator_fields += '<div class="row">';
                			var i = 1;
                			if(response.get_tabledata != null){
                				var json_formdata = jQuery.parseJSON(response.get_tabledata.form_data);
                			}else{
                				var json_formdata = [];
                			}
                			
							response.indicator_fields.forEach(function(indicatorfield, ifindex){
								if(indicatorfield.parent_id == null){
									switch(indicatorfield.type){
										case 'group':
											response.get_grouptabledata.forEach(function(groupdata, groupdata_index){
												var jsondata = jQuery.parseJSON(groupdata.formgroup_data);
												if(groupdata.groupfield_id == indicatorfield.field_id){
													indicator_fields += '<div class="col-md-12">\
														<input type="text" class="form-control hidden" name="id['+groupdata_index+']" value="'+groupdata.group_id+'">\
													</div>';
													indicator_fields += '<div class="col-md-12 addmoremaindiv">\
														<div class="row addmore addmore_div">';
															var indicator_groupfieldscount = indicatorfield.groupfields.length;
															var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
												        	indicator_fields += '<div class="col-md-'+i_divmainclass+'">\
												        		<div class="row">';
												        			indicatorfield.groupfields.forEach(function(indicatorgroupfield, ig_index){
												        				if(indicator_groupfieldscount == 1){
												        					var i_divclass = 12
												        				}else if(indicator_groupfieldscount == 2){
												        					var i_divclass = 6;
												        				}else if(indicator_groupfieldscount == 3){
												        					var i_divclass = 4;
												        				}else{
												        					var i_divclass = 3;
												        				}
												        				var group_fieldname = "field_"+indicatorgroupfield.field_id+"";
												        				switch(indicatorgroupfield.type){
												        					case 'text':
												        						indicator_fields += '<div class="col-md-'+i_divclass+'">\
														        					<div class="form-group">';
															        					indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																						indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" >\
														                            	<p class="error red-800"></p>\
														                            	<p class="maxlengtherror red-800"></p>\
														        					</div>\
														        				</div>';
												        						break;

												        					case 'textarea':
															                    indicator_fields += '<div class="col-md-'+i_divclass+'">\
																					<div class="form-group">';
																						indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																			    		indicator_fields += '<textarea name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" rows="8" class="'+indicatorgroupfield.className+'" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'">'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'</textarea>\
																			    		<p class="error red-800"></p>\
																			    		<p class="maxlengtherror red-800"></p>\
																					</div>\
															                    </div>';
											        							break;

												        					case 'select':
														                    	indicator_fields += '<div class="col-md-'+i_divclass+'">\
																					<div class="form-group">';
																						indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																						if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
																			  				var selectname = "field_"+indicatorgroupfield.field_id+"["+groupdata_index+"][]";
																			  				var selectmultiple = "multiple";
																			  			}else{
																			  				var selectname = "field_"+indicatorgroupfield.field_id+"["+groupdata_index+"]";
																			  				var selectmultiple = "";
																			  			} 
																			  			indicator_fields +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorgroupfield.field_id+'"  data-fieldtype="groupfield" data-groupfieldcount = "'+groupdata_index+'">';
																			   			if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
																			      		}else{
																			        		indicator_fields += '<option value="">Select an option</option>';
																			        	}
																			        	indicatorgroupfield.options.forEach(function(option, index){
																			        		if(option.value == jsondata[group_fieldname]){ 
														                          				var select_value = "selected"; 
														                          			}else{
														                          				var select_value = '';
														                          			}
														                          			indicator_fields += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
																			        	});
																		    			indicator_fields += '</select>\
																		    			<p class="error red-800"></p>\
																					</div>\
																					<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
														                    	</div>';
											        							break;

											        						case 'radio-group':
															                    indicator_fields += '<div class="col-md-'+i_divclass+'">\
																					<div class="form-group">';
																						indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																						indicator_fields += '<div class="form-check">\
																					    	<div class="row">';
																					    		indicatorgroupfield.options.forEach(function(option, index){
																					    			var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
																					    			if(option.value == jsondata[group_fieldname]){
															                                			var radio_value = "checked";
															                                		}else{
															                                			var radio_value = '';
															                                		}
																					    			indicator_fields += '<div class="col-md-4">\
																					          			<label><input type="radio" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"  '+radio_value+' >'+option.label+'</label>\
																					        		</div>';
																					    		});
																					    	indicator_fields += '</div>\
																					  	</div>\
																						<p class="error red-800"></p>\
																					</div>\
																					<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
															                    </div>';
											        							break;

											        						case 'checkbox-group':
															                    indicator_fields += '<div class="col-md-'+i_divclass+'">\
																					<div class="form-group">';
																						indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																						indicator_fields += '<div class="form-check">\
																					    	<div class="row">';
																					    		indicatorgroupfield.options.forEach(function(option, index){
																					    			var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
																					    			if(option.value == jsondata[group_fieldname]){
															                                			var radio_value = "checked"; 
															                                		}else{
															                                			var radio_value = '';
															                                		}
																					    			indicator_fields += '<div class="col-md-4">\
																					          			<label><input type="checkbox" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+'][]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"  '+radio_value+' >'+option.label+'</label>\
																					        		</div>';
																					    		});
																					    	indicator_fields += '</div>\
																					  	</div>\
																						<p class="error red-800"></p>\
																					</div>\
																					<div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
															                    </div>';
											        							break;

											        						case 'number':
											        							indicator_fields += '<div class="col-md-'+i_divclass+'">\
														                        	<div class="form-group">';
														                          		indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
												                             			switch (indicatorgroupfield.subtype) {
															                                case 'desimal':
															                                	indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' decimal" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
															                                	break;

															                                case 'number':
															                                	indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' number" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
															                                	break;

															                                case 'latitude':
															                                	indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
															                                  	break;

															                                case 'longitude':
															                                	indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
															                                  	break;
															                                
															                                default:
															                                	indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' numberfield" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" >';
															                                  	break;
												                              			}
												                              			indicator_fields += '<p class="error red-800"></p>\
												                              			<p class="maxlengtherror red-800"></p>\
														                        	</div>\
														                      	</div>';
											        							break;

											        						case 'date':
										        								indicator_fields += '<div class="col-md-'+i_divclass+'">\
															                      	<div class="form-group">';
																                        indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																						indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' picker" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" onkeydown="return false" autocomplete="off">\
														                            	<p class="error red-800"></p>\
														                            	<p class="maxlengtherror red-800"></p>\
															                      	</div>\
															                    </div>';
										        								break;

										        							case 'month':
										        								indicator_fields += '<div class="col-md-'+i_divclass+'">\
															                      	<div class="form-group">';
																                        indicator_fields += '<label>'+(ig_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
																						if(indicatorgroupfield.description != null){
																							indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
																						}
																						indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'['+groupdata_index+']" class="'+indicatorgroupfield.className+' monthpicker" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="'+(jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "")+'" data-subtype="'+indicatorgroupfield.subtype+'" onkeydown="return false" autocomplete="off">\
														                            	<p class="error red-800"></p>\
														                            	<p class="maxlengtherror red-800"></p>\
															                      	</div>\
															                    </div>';
										        								break;

												        				}		
												        			});
												        		indicator_fields += '</div>\
												        	</div>';
												        	indicator_fields += '<div class="col-md-12">\
												        		<hr style="margin-top: 0px; height: 1px; background-color: #8e8ec0;">\
												        	</div>\
												        </div>\
													</div>';
												}
											});
		        							break;

		        						//display of text box field
		        						case 'text':
	        								indicator_fields += '<div class="col-md-4">\
						                      	<div class="form-group">';
							                        var textquestion = (indicatorfield.field_count == 1) ? i++ : i;
							                        if(indicatorfield.field_count == 1){
									            		var label = textquestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
									            	indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													var text_fieldname = "field_"+indicatorfield.field_id+"";
													indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+'" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" data-subtype="'+indicatorfield.subtype+'" value="'+(json_formdata[text_fieldname] != null ? json_formdata[text_fieldname] : "")+'">\
					                            	<p class="error red-800"></p>\
					                            	<p class="maxlengtherror red-800"></p>\
						                      	</div>\
						                    </div>';
	        								break;

	        							case 'date':
	        								indicator_fields += '<div class="col-md-4">\
						                      	<div class="form-group">';
							                        var datequestion = (indicatorfield.field_count == 1) ? i++ : i;
							                        if(indicatorfield.field_count == 1){
									            		var label = datequestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
									            	indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													var date_fieldname = "field_"+indicatorfield.field_id+"";
													indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' picker" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="'+(json_formdata[date_fieldname] != null ? json_formdata[date_fieldname] : "")+'" data-subtype="'+indicatorfield.subtype+'" onkeydown="return false" autocomplete="off">\
					                            	<p class="error red-800"></p>\
					                            	<p class="maxlengtherror red-800"></p>\
						                      	</div>\
						                    </div>';
	        								break;

	        							case 'month':
	        								indicator_fields += '<div class="col-md-4	">\
						                      	<div class="form-group">';
							                        var datequestion = (indicatorfield.field_count == 1) ? i++ : i;
							                        if(indicatorfield.field_count == 1){
									            		var label = datequestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
									            	indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													var month_fieldname = "field_"+indicatorfield.field_id+"";
													indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' monthpicker" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="'+(json_formdata[month_fieldname] != null ? json_formdata[month_fieldname] : "")+'" data-subtype="'+indicatorfield.subtype+'" onkeydown="return false" autocomplete="off">\
					                            	<p class="error red-800"></p>\
					                            	<p class="maxlengtherror red-800"></p>\
						                      	</div>\
						                    </div>';
	        								break;

	        							//display number field
		        						case 'number':
		        							indicator_fields += '<div class="col-md-4">\
					                        	<div class="form-group">';
					                          		var numberquestion = (indicatorfield.field_count == 1) ? i++ : i;
													if(indicatorfield.field_count == 1){
									            		var label = numberquestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
													indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													var number_fieldname = "field_"+indicatorfield.field_id+"";
			                             			switch (indicatorfield.subtype) {
						                                case 'desimal':
						                                	indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' decimal" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-maxvalue = "'+indicatorfield.max_val+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
						                                	break;

						                                case 'number':
						                                	indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' number" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-maxvalue = "'+indicatorfield.max_val+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
						                                	break;

						                                case 'latitude':
						                                	indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' latlong" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
						                                  	break;

						                                case 'longitude':
						                                	indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' latlong" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
						                                  	break;
						                                
						                                default:
						                                	indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' numberfield" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="'+(json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "")+'" >';
						                                  	break;
			                              			}
			                              			indicator_fields += '<p class="error red-800"></p>\
			                              			<p class="maxlengtherror red-800"></p>\
					                        	</div>\
					                      	</div>';
		        							break;

		        						//display radio button
		        						case 'radio-group':
		        							var radio_fieldname = "field_"+indicatorfield.field_id+"";
						                    indicator_fields += '<div class="col-md-12">\
												<div class="form-group">';
													var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
													if(indicatorfield.field_count == 1){
									            		var label = radioquestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
									            	if(indicatorfield.required == 1){
									            		var hastrick = "<font color='red'>*</font>";
									            	}else{
									            		var hastrick = "";
									            	}
													indicator_fields += '<label class="english">'+label+''+hastrick+'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													indicator_fields += '<div class="form-check">\
												    	<div class="row">';
												    		indicatorfield.options.forEach(function(option, index){
												    			var requiredval = (indicatorfield.required == 1) ? "required" : "";
												    			if((option.value == json_formdata[radio_fieldname]) && (json_formdata[radio_fieldname] != null)){ 
						                                			var radio_value = "checked"; 
						                                		}else{
						                                			var radio_value = '';
						                                		}
												    			indicator_fields += '<div class="col-md-4">\
												          			<label><input type="radio" name="field_'+indicatorfield.field_id+'" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"  '+radio_value+' >'+option.label+'</label>\
												        		</div>';
												    		});
												    	indicator_fields += '</div>\
												  	</div>\
													<p class="error red-800"></p>\
												</div>\
						                    </div>\
						                    <div class="col-md-12">\
						                    	<div class="row childfields childof'+indicatorfield.field_id+'">\
						                    	</div>\
						                    </div>';
		        							break;

		        						//display checkbox button
		        						case 'checkbox-group':
		        							var radio_fieldname = "field_"+indicatorfield.field_id+"";
						                    indicator_fields += '<div class="col-md-12">\
												<div class="form-group">';
													var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
													if(indicatorfield.field_count == 1){
									            		var label = radioquestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
									            	if(indicatorfield.required == 1){
									            		var hastrick = "<font color='red'>*</font>";
									            	}else{
									            		var hastrick = "";
									            	}
													indicator_fields += '<label class="english">'+label+''+hastrick+'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													indicator_fields += '<div class="form-check">\
												    	<div class="row">';
												    		indicatorfield.options.forEach(function(option, index){
												    			var requiredval = (indicatorfield.required == 1) ? "required" : "";
						                                		if(response.get_tabledata[radio_fieldname] != null){
												        			var checkbox_val = json_formdata[radio_fieldname].split("&#44;");
												        			
												        			if(jQuery.inArray(option.value, checkbox_val) !== -1){
												        				var radio_value = 'checked';
												        			}else{
												        				var radio_value = '';
												        			}
												        		}else{
												        			var radio_value = '';
												        		}
												    			indicator_fields += '<div class="col-md-4">\
												          			<label><input type="checkbox" name="field_'+indicatorfield.field_id+'[]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"  '+radio_value+' >'+option.label+'</label>\
												        		</div>';
												    		});
												    	indicator_fields += '</div>\
												  	</div>\
													<p class="error red-800"></p>\
												</div>\
						                    </div>\
						                    <div class="col-md-12">\
						                    	<div class="row childfields childof'+indicatorfield.field_id+'">\
						                    	</div>\
						                    </div>';
		        							break;

		        						//display of textarea
		        						case 'textarea':
		        							var textarea_fieldname = "field_"+indicatorfield.field_id+"";
						                    indicator_fields += '<div class="col-md-4">\
												<div class="form-group">';
													var textareaquestion = (indicatorfield.field_count == 1) ? i++ : i;
													if(indicatorfield.field_count == 1){
									            		var label = textareaquestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
													indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
										    		indicator_fields += '<textarea name="field_'+indicatorfield.field_id+'" rows="8" class="'+indicatorfield.className+'" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'">'+(json_formdata[textarea_fieldname] != null ? json_formdata[textarea_fieldname] : "")+'</textarea>\
										    		<p class="error red-800"></p>\
										    		<p class="maxlengtherror red-800"></p>\
												</div>\
						                    </div>';
		        							break;

		        						//display of select box
		        						case 'select':
		        							var select_fieldname = "field_"+indicatorfield.field_id+"";
						                    indicator_fields += '<div class="col-md-4">\
												<div class="form-group">';
													var selectquestion = (indicatorfield.field_count == 1) ? i++ : i;
													if(indicatorfield.field_count == 1){
									            		var label = selectquestion+'. '+indicatorfield.label;
									            	}else{
									            		var label = indicatorfield.label;
									            	}
													indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
													if(indicatorfield.description != null){
														indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
													}
													if(indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE'){
										  				var selectname = "field_"+indicatorfield.field_id+"[]";
										  				var selectmultiple = "multiple";
										  			}else{
										  				var selectname = "field_"+indicatorfield.field_id+"";
										  				var selectmultiple = "";
										  			}
										  			indicator_fields +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorfield.field_id+'"  data-fieldtype="normalfield">';
										   			if(indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE'){
										      		}else{
										        		indicator_fields += '<option value="">Select an option</option>';
										        	}
										        	indicatorfield.options.forEach(function(option, index){
										        		if(response.get_tabledata[select_fieldname] != null){
										        			var selectbox_val = json_formdata[select_fieldname].split("&#44;");
										        			
										        			if(jQuery.inArray(option.value, selectbox_val) !== -1){
										        				var select_value = 'selected';
										        			}else{
										        				var select_value = '';
										        			}
										        		}else{
										        			var select_value = '';
										        		}
					                          			indicator_fields += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
										        	});
										    		indicator_fields += '</select>\
										    		<p class="error red-800"></p>\
												</div>\
						                    </div>\
						                    <div class="col-md-12">\
						                    	<div class="row childfields childof'+indicatorfield.field_id+'"></div>\
						                    </div>';
		        							break;

		        						case 'header':
						                    indicator_fields += '<div class="col-md-12">';
						                    	if(indicatorfield.description != null){
						                    		indicator_fields += indicatorfield.description;
						                    	}
						                    	indicator_fields += '<'+indicatorfield.subtype+' class="title" style="margin-top: 0px; margin-bottom: 20px;">'+indicatorfield.label+'</'+indicatorfield.subtype+'>';
						                    indicator_fields += '</div>';
						                	break;

									}
								}
							});						
						
							indicator_fields += '<div class="col-md-12">\
								<button type="button" class="btn btn-sm btn-success pull-right submitindicator_data" data-recordid = "'+recordid+'">Edit & approve</button>\
								<button type="button" class="btn btn-sm btn-default pull-right cancel" style="margin-right:10px;">Cancel</button>\
							</div>';
						indicator_fields += '</div>\
					</form>';
					$elem.closest('.row').find('.indicator_details').html(indicator_fields);
					$elem.closest('.actionbutton_divs').addClass('hidden');					

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
                }

                $elem.prop('disabled', false);
            }
        });
	});

	$('body').on('click', '.submitindicator_data', function(){
		$elem = $(this);
        $elem.prop('disabled', true);

        $('.error').html('');

        var recordid = $elem.data("recordid");
        var form_id = 'submit_data';
        var surveycount = 0;

        $elem.closest('.card').find('input[type=text]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if(requiredvalue == 'required'){
                if($.trim($(this).val()).length === 0){
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }

            if(subtypevalue == 'number' || subtypevalue == 'desimal'){
                switch (subtypevalue){
                    case 'number':
                        if($(this).val().length > 0){
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
                        if($(this).val().length > 0){
                            if(!/^(\d*\.?\d*)$/.test($(this).val())){
                                $(this).next('.error').html('Please! Enter only number');
                                surveycount++;
                            }else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                $(this).next('.error').html('Field can contain only proper decimal number.');
                                surveycount++;
                            }
                        }
                    break;
                }
            }

            if($.trim($(this).val()).length > maxvalue){
      			$(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
      			surveycount++;
    		}
        });

        $elem.closest('.card').find('textarea', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if(requiredvalue == 'required'){
                if($.trim($(this).val()).length === 0){
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }

            if($.trim($(this).val()).length > maxvalue){
      			$(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
      			surveycount++;
    		}
        });

        $elem.closest('.card').find('input[type=radio]', form_id).each(function() {
	        var requiredvalue = $(this).data("required");
	        var subtypevalue = $(this).data("subtype");
	        if(requiredvalue == 'required'){
	          	var name = $(this).attr("name");
	          	if($("input:radio[name='"+name+"']:checked").length == 0){
	            	$(this).closest('.form-group').find('.error').html('This field is required');
	            	surveycount++;
	          	}
	        }
	   	});

	   	$elem.closest('.card').find('input[type=checkbox]', form_id).each(function() {
			var requiredvalue = $(this).data("required");
			var subtypevalue = $(this).data("subtype");
			var maxvalue = $(this).data("maxlength");

			if(requiredvalue == 'required'){
				var name = $(this).attr("name");
				if($("input:checkbox[name='"+name+"']:checked").length == 0){
                  	$(this).closest('.form-group').find('.error').html('This field is required');
                  	surveycount++;
                }
			}
		});

	   	$elem.closest('.card').find('select', form_id).each(function() {
    		var requiredvalue = $(this).data("required");
    		var subtypevalue = $(this).data("subtype");
    		if(requiredvalue == 'required'){
    			var name = $(this).attr("name");
      			if($.trim($(this).val()).length == 0){
        			$(this).next('.error').html('This field is required');
        			surveycount++;
      			}
    		}
  		});

        if(surveycount == 0){
        	var indicatorform = new FormData($('#'+form_id)[0]);
            indicatorform.append('recordid', recordid);
            indicatorform.append('formtype', 'edit_and_approve');
            indicatorform.append('form_id', <?php echo $this->uri->segment(4); ?>);

            $.ajax({
                url: '<?php echo base_url(); ?>dashboard/edit_formdata',
                type: 'POST',
                dataType : 'json',
                data: indicatorform,
                processData: false,
                contentType: false,
                error: function() {
                	$elem.prop('disabled', false);
                    swal({
                        title: 'Please check your internet connection and try again.',
                        icon: "warning",
                        dangerMode : true,
                        closeOnConfirm: true
                    });
                },
                success: function(response){
                    if(response.status == 0){
                        swal({
                            title: response.msg,
                            icon: "warning",
                            dangerMode : true,
                            closeOnConfirm: true
                        });

                        $elem.prop('disabled', false);
                    }else{
                    	$elem.closest('.main_div').html('');

                        swal({
                            title: response.msg,
                            icon: "success",
                            closeOnConfirm: true
                        });
                    }
                }
            });
        }else{
        	$elem.prop('disabled', false);
        }
	});

	$('body').on('keyup', '.numberfield', function(){
 		$(this).closest('.form-group').find('.error').html('');
  		if($(this).val().length > 0){
    		if (!/^(\+|-)?(\d*\.?\d*)$/.test(this.value)) { // a non–digit was entered
      			$(this).closest('.form-group').find('.error').html('This field contains only numbers and perfect decimals.');
    		}else{
      			$(this).closest('.form-group').find('.error').empty();
    		}
  		}
	});

	$('body').on('keyup', '.decimal', function(){
  		$(this).closest('.form-group').find('.error').html('');

  		var maxvalue = $(this).attr("data-maxvalue");
  		if($(this).val().length > 0){
    		if(!/^(\d*\.?\d*)$/.test($(this).val())){
      			$(this).closest('.form-group').find('.error').html('Please! Enter only number');
    		}else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
      			$(this).closest('.form-group').find('.error').html('Field can contain only proper decimal number.');
    		}

    		if(parseFloat($(this).val()) >  parseFloat(maxvalue)){
    			$(this).closest('.form-group').find('.error').html('Enter value cannot be greater than '+maxvalue+'');
    			$(this).val('');
    		}
  		}
	});

	$('body').on('keyup', '.number', function(){
  		$(this).closest('.form-group').find('.error').html('');

  		var maxvalue = $(this).attr("data-maxvalue");
  		if($(this).val().length > 0){
    		if (/^\d+$/.test($(this).val())) {
      			$(this).closest('.form-group').find('.error').empty();
    		} else {
      			$(this).closest('.form-group').find('.error').html('Please provide a valid number.');
    		}

    		if(parseInt($(this).val()) >  parseInt(maxvalue)){
    			$(this).closest('.form-group').find('.error').html('Enter value cannot be greater than '+maxvalue+'');
    			$(this).val('');
    		}
  		}
	});

	$('body').on('keyup', '.latlong', function(){
  		$(this).closest('.form-group').find('.error').html('');
  		if($(this).val().length > 0){
   			if (/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/.test($(this).val())) {
      			$(this).closest('.form-group').find('.error').empty();
    		} else {
      			$(this).closest('.form-group').find('.error').html('Please provide a proper value.');
    		}
  		}
	});

	$('body').on('click', '.send_back', function(event) {
		var elem = $(this),
		modal = $('#sendBackModal'),
		backTo = elem.data('by'),
		recordId = elem.data('recordid');

		// Set values in modal
		modal.modal('show');
		modal.find('form')[0].reset();
		modal.find('#backTo').html(backTo);
		modal.find('form').data('id', recordId);
	}).on('submit', '#sendBackForm', function(event) {
		event.preventDefault();
		var form = $(this),
		formData = new FormData(form[0]);
		formData.append('id', form.data('id'));
		
		form.find('button').prop('disabled', true);
		form.find('button[type="submit"]').html('Please wait...');
		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/send_back',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			error: function() {
				form.find('button').prop('disabled', false);
				form.find('button[type="submit"]').html('Send Back');
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success: function(data) {
				var data = JSON.parse(data);

				if(data.status == 0) {
					if(data.errors && data.errors.length > 0) {
						for(var key in data.errors) {
							var errorContainer = form.find(`.${key}.error`);
							if(errorContainer.length !== 0) {
								errorContainer.html(data.errors[key]);
							}
						}
					} else {
						$.toast({
							heading: 'Error!',
							text: data.msg,
							icon: 'error',
							afterHidden: function () {
								form.find('button').prop('disabled', false);
								form.find('button[type="submit"]').html('Send Back');
							}
						});
					}
					return false;
				}

				$.toast({
					heading: 'Success!',
					text: data.msg,
					icon: 'success',
					afterHidden: function () {
						$('#sendBackModal').modal('hide');
						form.find('button').prop('disabled', false);
						form.find('button[type="submit"]').html('Send Back');
					}
				});
			}
		});
	});

	//rejected code start
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
					url: "<?php echo base_url(); ?>dashboard/reject_data",
					type: "POST",
					dataType: "json",
					data : {
						recordid : recordid,
						form_id : <?php echo $this->uri->segment(4); ?>
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

							$elem.closest('.row').find('.delete_groupdata').html('');

							$elem.closest('.actionbutton_divs').html('');						

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
						}
					}
				});
			} else {
				swal("Cancelled", "Data is not yet rejected", "error");
			}
		});
	});
	//rejected code end
</script>