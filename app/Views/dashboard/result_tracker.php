<style type="text/css">
	.form-control button {
		border: none !important;
	}

	.form-control span {
		margin: 5px;
	}

	.ms-drop.bottom {
		left: 0;
	}

	span.badge>span {
		width: 100%;
		min-width: 40px;
		text-align: center;
		display: grid;
		margin: 0 auto;
		margin-top: 5px;
	}

	/* loading dots */
	.loading:after {
		content: ' .';
		padding-right: 5px;
		animation: dots 1s steps(5, end) infinite;
	}

	/*table, td, th {
		text-align:center
    }*/

    table a{
    	color: blue;
    }

	@keyframes dots {

		0%,
		20% {
			color: rgba(255, 255, 255, 0);
			text-shadow:
				.25em 0 0 rgba(255, 255, 255, 0),
				.5em 0 0 rgba(255, 255, 255, 0);
		}

		40% {
			color: black;
			text-shadow:
				.25em 0 0 rgba(255, 255, 255, 0),
				.5em 0 0 rgba(255, 255, 255, 0);
		}

		60% {
			text-shadow:
				.25em 0 0 black,
				.5em 0 0 rgba(255, 255, 255, 0);
		}

		80%,
		100% {
			text-shadow:
				.25em 0 0 black,
				.5em 0 0 black;
		}
	}
</style>

<link href="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />

<!-- Sendback Modal -->
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
				<h3>Reporting Dashboard</h3>
				<!-- Year Country Crop -->
				<div class="card">
					<div class="card-body">
						<form action="<?php echo base_url(); ?>dashboard/downloadall_pos_resulttracker/1" target="_blank" method="post">
							<div class="row">
								<!-- <?php $multiple = '';
								if ($this->session->userdata('role') == 6) {
									$multiple = 'multiple';
								} ?> -->
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
										<select data-urole="<?php echo $this->session->userdata('role'); ?>" name="country[]" placeholder="Select Country" class="form-control" multiple></select>

									</div>
								</div>
								<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
									<div class="form-group">
										<label class="form-label">Select Crop</label>
										<select data-urole="<?php echo $this->session->userdata('role'); ?>" name="crop[]" placeholder="Select Crop" class="form-control" multiple></select>
									</div>
								</div>

								<div class="col-md-12">
									<button type="submit" class="btn btn-success btn-sm pull-right mr-2 all_posbutton hidden"> Download all POs</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="panel hidden resulttracker_reportdiv">
					
				</div>

				<!-- Reporting/Approval/Review Tab -->
				<div class="panel panel-primary mt-8">
					<div class="tab-menu-heading p-0 bg-light">
						<div class="tabs-menu1">
							 <!-- Tabs  -->
							<ul class="nav panel-tabs">
								<li><a href="<?php echo base_url() . 'dashboard'; ?>" class="text-black">REPORTING</a></li>

								<?php if($this->session->userdata('role') == 6){ ?>
								<li><a href="<?php echo base_url() . 'dashboard/approval'; ?>" class="text-black">APPROVAL</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/review'; ?>" class="text-black">REVIEW</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/user_uploadinfo'; ?>" class="text-black">USER UPLOAD INFO</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/monitoring_evaluation'; ?>" class="text-black">M & E</a></li>
								<?php } ?>
								
								<?php if ($this->session->userdata('role') == 4) { ?>
								<li><a href="<?php echo base_url() . 'dashboard/approval'; ?>" class="text-black">APPROVAL</a></li>
								<?php } else if ($this->session->userdata('role') == 5) { ?>
								<li><a href="<?php echo base_url() . 'dashboard/approval'; ?>" class="text-black">APPROVAL</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/review'; ?>" class="text-black">REVIEW</a></li>
								<?php } ?> 

								<?php if($this->session->userdata('role') == 6 || $this->session->userdata('role') == 5 || $this->session->userdata('role') == 4){ ?>
								<li><a href="javascript:void(0)'; ?>" class="text-black active">RESULTS TRACKER</a></li>
								<?php } ?>							
							</ul>
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

				<div class="panel panel-primary user_indicatorinfo">
					
				</div>

			</div><!-- end app-content-->
		</div>
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/jquery.richtext.js"></script>

<!-- Page Script -->
<script type="text/javascript">
	$(function() {
		$('[name="year"]').on('change', function(event) {
			getCountry();
			$('.all_posbutton').addClass('hidden');
		}).multipleSelect({
			filter: true
		});

		$('[name="country[]"]').on('change', function(event) {
			$('.resulttracker_reportdiv').addClass('hidden');
			getCrops();
			$('.all_posbutton').addClass('hidden');
		}).multipleSelect({
			filter: true
		});

		$('[name="crop[]"]').on('change', function(event) {
			$('.resulttracker_reportdiv').addClass('hidden');
			getPO();
			$('.all_posbutton').addClass('hidden');
		}).multipleSelect({
			filter: true
		});
		$('[name="year"]').trigger('change');
	});

	// This will encode your HTML input
	function removeTags(str) {
	    if ((str===null) || (str===''))
	        return false;
	    else
	        str = str.toString();
	          
	    // Regular expression to identify HTML tags in
	    // the input string. Replacing the identified
	    // HTML tag with a null string.
	    str = str.replace( /(<([^>]+)>)/ig, '');
	    return str.replace(/\&nbsp;/g, '');
	}

	$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
		var id = $(e.target).data('id');
		getPoDetails(id);
		$('.all_posbutton').addClass('hidden');
	});

	function getCountry() {
		$('[name="country[]"]').html('');
		var urole = $('[name="country[]"]').data('urole');

		// AJAX to get country and crop
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_country',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				purpose : 'monitoring_evaluation'
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

				//var countries = '<option value="all">All countries</option>';
				var user_role = <?php echo $this->session->userdata('role'); ?>;

				// if(user_role == 4 || user_role == 5){
				// 	var countries = '<option value="">Select Country</option>';
				// }else{
				// 	var countries = '';
				// }
				var countries = '';
				var counter = 0;
				var selected = "" + response.selected;
				var selArr = selected.split(',');
				response.countries.forEach(function(country, index) {
					if (selArr.length > counter && selArr[counter] == country.country_id) {
						counter++;
						countries += '<option value="' + country.country_id + '" >' + country.country_name + '</option>';
					} else {
						countries += '<option value="' + country.country_id + '" >' + country.country_name + '</option>';
					}
				});
				$('[name="country[]"]').html(countries);
				// Refresh options
				$('[name="country[]"]').trigger('change');
				$('[name="country[]"]').multipleSelect('refresh');
			}
		});
	}

	function getCrops() {
		$('[name="crop[]"]').html('');

		// AJAX to get crop
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_crop',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country[]"]').val(),
				purpose : 'monitoring_evaluation'
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
				//var crops = '<option value="all">All Crops</option>';
				var user_role = <?php echo $this->session->userdata('role'); ?>;

				// if(user_role == 4 || user_role == 5){
				// 	var crops = '<option value="">Select Crop</option>';
				// }else{
				// 	var crops = '';
				// }
				var crops = '';
				var counter = 0;
				var selected = "" + response.selected;
				var selArr = selected.split(',');
				response.crops.forEach(function(crop, index) {
					if (selArr.length > counter && selArr[counter] == crop.crop_id) {
						counter++
						crops += '<option value="' + crop.crop_id + '"  >' + crop.crop_name + ' ('+crop.country_name+')</option>';
					} else {
						crops += '<option value="' + crop.crop_id + '" >' + crop.crop_name + ' ('+crop.country_name+')</option>';
					}
				});
				$('[name="crop[]"]').html(crops);

				// Refresh options
				$('[name="crop[]"]').trigger('change');
				$('[name="crop[]"]').multipleSelect('refresh');
			}
		});
	}

	function getPO() {
		$('.panel-tabs.po').html('<li><a href="#po" class="text-black active" data-toggle="tab">PO</a></li>');
		$('.tab-content.po').html('<div class="tab-pane active" id="po">\
			<div class="row">\
				<div class="col-md-12 col-lg-12">\
					<div class="card card-block">\
						<div class="card-header d-sm-flex d-block">\
							<h3 class="card-title mr-5">Please select country and crop</h3>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>');

		if($('[name="country[]"]').val() == '' || $('[name="crop[]"]').val() == ''){
			$.toast({
				stack: false,
				icon: 'warning',
				position: 'bottom-right',
				showHideTransition: 'slide',
				heading: 'Warning!',
				text: 'Please select country and crop.'
			});
			return false;
		}

		// AJAX to get po
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_po',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country[]"]').val(),
				crop: $('[name="crop[]"]').val(),
				purpose : 'result_tracker'
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

				var poLis = '',
					poDivs = '';
				response.pos.forEach(function(po, index) {
					var active = (index == 0) ? 'active' : '';
					poLis += '<li><a href="#po' + po.po_id + '" class="text-black ' + active + '" data-toggle="tab" data-id="' + po.po_id + '">' + po.po_name + '</a></li>'
					poDivs += '<div class="tab-pane ' + active + '" id="po' + po.po_id + '">\
						<div class="row">\
							<div class="col-md-12 col-lg-12">\
								<div class="card card-block">\
									<div class="card-header d-sm-flex d-block">\
										<h3 class="card-title mr-5">Please Wait... Getting Data.</h3>\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>'
				});
				if (response.pos.length === 0) {
					poLis = '<li><a href="#po" class="text-black active" data-toggle="tab">PO</a></li>';
					$('.tab-content.po').html('<div class="tab-pane active" id="po">\
						<div class="row">\
							<div class="col-md-12 col-lg-12">\
								<div class="card card-block">\
									<div class="card-header d-sm-flex d-block">\
										<h3 class="card-title mr-5">No PO Assigned to User.</h3>\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>');
				}
				$('.panel-tabs.po').html(poLis);

				if (response.pos.length > 0) {
					$('.tab-content.po').html(poDivs);
					getPoDetails(response.pos[0].po_id);
				}
			}
		});
	}

	function getPoDetails(po_id) {
		$elem = $(this);
		$('#po' + po_id).html('');

		if($('[name="country[]"]').val() == '' || $('[name="crop[]"]').val() == ''){
			return false;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/calculate_result_tracker',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country[]"]').val(),
				crop: $('[name="crop[]"]').val(),
				po_id : po_id,
				page_type : 'monitoring_evaluation'
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

				var year_id = $('[name="year"]').val();
				var country_id = $('[name="country[]"]').val();
				var crop_id = $('[name="crop[]"]').val();
				var user_id = '<?php echo $this->session->userdata('login_id'); ?>';
				var user_role = <?php echo $this->session->userdata('role'); ?>;

				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">
							
							<div class="card-body mb-5">
								<button id="btnExport" onclick="javascript:xport.toCSV('resulttracker_`+po_id+`', 'RESULTS TRACKER');" class="btn btn-success btn-sm pull-right" style="margin-bottom: 10px; "> Export to CSV</button>
								<div class="table-responsive">
									<table class="table table-bordered table_th" id="resulttracker_`+po_id+`">
										<thead>
											<tr>
												<th style="width:45%;">Indicator</th>`;
												/*HTML += `<th class="hidden">Progress (%)</th>`;*/
												HTML += `<th>Target</th>
												<th>Actual</th>
												<th>Variance</th>
												<th>Review/Report</th>
											</tr>
										</thead>
										<tbody>`;
											if(response.outputs.length > 0){
												response.outputs.forEach(function($output, $key) {
													HTML += `<tr>
														<td colspan="5" class="output_text" style="text-align:justify; padding:15px; line-height:2; background:#EAF3EF;">`+$output.title+`</td>
													</tr>`;
													if ($output['indicator_list'].length > 0) {												
														$output['indicator_list'].forEach(function($indicator, $key) {
															HTML += `<tr class="bg-white" style="cursor: auto">`;
																HTML += `<td class="output_text">${$indicator['title']}</td>`;
																/*HTML += `<td>`;
																	var variance_pre = 0;
																	if($indicator['target_val'] == 0){
						                    							variance_pre = ($indicator['actual_val']/1)*100; 
						                    						}else{
						                    							variance_pre = ($indicator['actual_val']/$indicator['target_val'])*100;
						                    						}	

							                    					if(variance_pre == 0){
							                    						HTML += `<p class="text-center" style="font-weight:bold;">`+variance_pre.toFixed()+` %</p>`;
							                    						HTML += `<div class="progress text-center" style="height:20px">
								                    						<div class="progress-bar bg-danger progress-bar-striped  progress-bar-animated text-center" style="width:0%">
								                    						</div>
								                    					</div>`;
							                    					}else{
							                    						HTML += `<p class="text-center" style="font-weight:bold; color:green;"> `+variance_pre.toFixed()+` %</p> `;
							                    						HTML += ` <div class="progress text-center" style="height:20px">
								                    						<div class="progress-bar bg-success progress-bar-striped  progress-bar-animated text-center" style="width:`+variance_pre+`%">
								                    						</div>
								                    					</div>`;
							                    					}
	                    										HTML += `</td>`;*/
																HTML += `<td>${($indicator['target_val'] == 0 ? 'NULL' : $indicator['target_val'])}</td>
																<td>${$indicator['actual_val']}</td>
																<td>`;
																	var variance = 0;
							                    					variance = $indicator['actual_val'] - $indicator['target_val'];

							                    					if($indicator['actual_val'] == 0 && $indicator['target_val'] == 0){
							                    						HTML += `<p style="font-weight:bold;"> N/A</p> `;
							                    					}

							                    					if(variance == 0 && ($indicator['actual_val'] != 0 || $indicator['target_val'] != 0)){
							                    						HTML += `<p style="font-weight:bold;"><img src="<?php echo base_url(); ?>include/assets/images/yellowdot.png" style="width:20px; height:20px;"> `+variance.toFixed()+`</p> `;
																	}

																	if(variance > 0){
																		HTML += `<p style="font-weight:bold; color:#056839	;"> <img src="<?php echo base_url(); ?>include/assets/images/greendot.png" style="width:20px; height:20px;">  `+variance.toFixed()+`</p> `;
							                    					}

							                    					if(variance < 0){
																		HTML += `<p style="font-weight:bold; color:#9d0000;"> <img src="<?php echo base_url(); ?>include/assets/images/reddot.png" style="width:20px; height:20px;">  `+variance.toFixed()+`</p> `;
																	}
							                    				HTML += `</td>
							                    				<td>`;
							                    					if(user_role == 4 || user_role == 5){						                    						
							                    						if(jQuery.inArray($indicator['id'], response.userindicator_list) !== -1){
							                    							if(country_id.length > 1 || crop_id.length > 1){
							                    								HTML += `<a class="btn btn-sm btn-info add_resulttracker_report mr-2" data-formid="${$indicator['id']}"> <i class="fa fa-plus"></i></a>`;
							                    							}else{
							                    								if($indicator['user_resulttracker_report'] == 0){
							                    									// HTML += `<a class="btn btn-sm btn-success add_resulttracker_report mr-2" data-formid="${$indicator['id']}"> <i class="fa fa-plus"></i></a>`;

							                    									HTML += `<a class="btn btn-sm btn-info add_resulttracker_report mr-2" data-formid="${$indicator['id']}"> <i class="fa fa-plus"></i></a>`;
							                    								}
							                    							}
							                    						}
							                    					}

							                    					if(country_id.length > 1 || crop_id.length > 1){
							                    						HTML += `<a class="btn btn-sm btn-info view_resulttracker_report" data-formid="${$indicator['id']}"> <i class="fa fa-eye"></i></a>`;
							                    					}else{
							                    						if($indicator['resulttracker_report'] > 0){
							                    							if($indicator['resulttracker_report_query'] > 0) {
					                    										HTML += `<a class="btn btn-sm btn-warning view_resulttracker_report" data-formid="${$indicator['id']}"> <i class="fa fa-eye"></i></a>`;
							                    							} else {
							                    								HTML += `<a class="btn btn-sm btn-success view_resulttracker_report" data-formid="${$indicator['id']}"> <i class="fa fa-eye"></i></a>`;
							                    							}
					                    								}else{
					                    									HTML += `<a class="btn btn-sm btn-danger view_resulttracker_report" data-formid="${$indicator['id']}"> <i class="fa fa-eye"></i></a>`;
					                    								}
							                    					}
							                    				HTML += `</td>
															</tr>`;
														});
													};
												});
											}else{
												HTML += `<tr>
													<td colspan="5">No data found</td>
												</tr>`;
											}
										HTML += `</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>`;
				$('#po' + po_id).html(HTML);
				$('.all_posbutton').removeClass('hidden');
			}
		});
	}

	$('body').on('click', '.add_resulttracker_report', function(){
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country[]"]').val();
		var crop_id = $('[name="crop[]"]').val();
		var form_id = $(this).data('formid');

		if(country_id.length > 1 || crop_id.length > 1){
			$.toast({
				stack: false,
				icon: 'warning',
				position: 'bottom-right',
				showHideTransition: 'slide',
				heading: 'Warning!',
				text: 'Please select only one country and crop.'
			});
			return false;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/add_resulttracker_report',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: year_id,
				country: country_id[0],
				crop: crop_id[0],
				form_id : form_id
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
				if(response.status == 0){
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
				var HTML = `<h3 class="modal-title">`+response.get_form_details.title+`</h3>
					
				<textarea name="report" rows="6" class="form-control" id="textarea_1">`+(response.get_resulttracker_report != null ? response.get_resulttracker_report.report : '')+`</textarea>
				<p class="error red-800"></p>
				<p class="maxlengtherror red-800"></p>`;
				
				if(response.get_resulttracker_report == null
				|| response.get_resulttracker_report.query_status == null) {
					HTML += `<button type="button" class="btn btn-success pull-right ml-2 submit_report" data-formid="`+form_id+`">Submit Report</button>`;
				} else {
					HTML += `<button type="button" class="btn btn-success pull-right ml-2 update_report" data-formid="`+form_id+`" data-recordid="`+response.get_resulttracker_report.data_id+`">Update Report</button>`;
				}
				HTML += `<button type="button" class="btn btn-danger pull-right cancel_report" data-dismiss="modal">
					Close
				</button>`;

				$('.resulttracker_reportdiv').removeClass('hidden');
				$('.resulttracker_reportdiv').html(HTML);
				$('#textarea_1').richText();
				$('html,body').animate({
	                scrollTop: $('.resulttracker_reportdiv').offset().top - 300
	            }, 500);
			}
		});
	});

	$('body').on('click', '.cancel_report', function(){
		$('.resulttracker_reportdiv').addClass('hidden');
	});

	$('body').on('click', '.submit_report', function(){
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country[]"]').val();
		var crop_id = $('[name="crop[]"]').val();
		var form_id = $(this).data('formid');

		var value = removeTags($('#textarea_1').val());
		if ($.trim(value).length === 0) {
            $(this).parent().find('.error').html('This field is required');
            return false;
        }

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/submit_resulttracker_report',
			type: 'POST',
			dataType:'JSON',
			data: {
				year_id: year_id, 
				country_id: country_id[0], 
				crop_id: crop_id[0], 
				form_id : form_id,
				comment: $('#textarea_1').val(), 
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
				}else{
					$.toast({
						stack: false,
						icon: 'success',
						position: 'bottom-right',
						showHideTransition: 'slide',
						heading: 'Success',
						text: response.msg
					});
					$('.resulttracker_reportdiv').addClass('hidden');
					$('body').find(`.view_resulttracker_report[data-formid="${form_id}"]`).trigger('click');
				}
			}
		});
	});
	$('body').on('click', '.update_report', function(){
		var elem = $(this);
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country"]').val();
		var crop_id = $('[name="crop"]').val();
		var form_id = $(this).data('formid');

		var value = removeTags($('#textarea_1').val());
		if ($.trim(value).length === 0) {
            $(this).parent().find('.error').html('This field is required');
            return false;
        }

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/update_resulttracker_report',
			type: 'POST',
			dataType:'JSON',
			data: {
				year_id: year_id,
				country_id: country_id[0],
				crop_id: crop_id[0],
				form_id : form_id,
				comment: $('#textarea_1').val(),
				data_id: elem.data('recordid')
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
				}else{
					$.toast({
						stack: false,
						icon: 'success',
						position: 'bottom-right',
						showHideTransition: 'slide',
						heading: 'Success',
						text: response.msg
					});
				}
			}
		});
	});

	//view result tracker report
	$('body').on('click', '.view_resulttracker_report', function(){
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country[]"]').val();
		var crop_id = $('[name="crop[]"]').val();
		var form_id = $(this).data('formid');
		var userId = '<?php echo $this->session->userdata('login_id'); ?>';

		if(country_id.length > 1 || crop_id.length > 1){
			$.toast({
				stack: false,
				icon: 'warning',
				position: 'bottom-right',
				showHideTransition: 'slide',
				heading: 'Warning!',
				text: 'Please select only one country and crop.'
			});
			return false;
		}

		window.open("<?php echo base_url(); ?>dashboard/view_resulttracker_report_page/"+form_id+"/"+year_id+"/"+country_id+"/"+crop_id);

		// $.ajax({
		// 	url: '<?php echo base_url(); ?>dashboard/view_resulttracker_report',
		// 	type: 'POST',
		// 	dataType: 'JSON',
		// 	data: {
		// 		year: $('[name="year"]').val(),
		// 		country: country_id[0],
		// 		crop: crop_id[0],
		// 		form_id : form_id
		// 	},
		// 	error: function() {
		// 		$.toast({
		// 			stack: false,
		// 			icon: 'error',
		// 			position: 'bottom-right',
		// 			showHideTransition: 'slide',
		// 			heading: 'Network Error!',
		// 			text: 'Please check your internet connection.'
		// 		});
		// 	},
		// 	success: function(response) {
		// 		if(response.status == 0){
		// 			$.toast({
		// 				stack: false,
		// 				icon: 'error',
		// 				position: 'bottom-right',
		// 				showHideTransition: 'slide',
		// 				heading: 'Error!',
		// 				text: response.msg
		// 			});
		// 			return false;
		// 		}
		// 		var HTML = `<h3 class="modal-title">`+response.get_form_details.title+`</h3>`;

		// 		HTML += `<div class="card p-10">
		// 			<div class="table-responsive">
		// 				<table class="table table-bordered table_th">
		// 					<thead>
		// 						<tr>
		// 							<th style="width:10%;">Submitted By</th>
		// 							<th style="width:10%;">Country</th>
		// 							<th style="width:10%;">Crop</th>
		// 							<th style="width:45%;">Variance Report</th>									
		// 							<th style="width:20%;" class="text-center">Action</th>
		// 						</tr>
		// 					</thead>
		// 					<tbody>`;
		// 						if(response.get_resulttracker_report.length > 0){
		// 							response.get_resulttracker_report.forEach(function(data, index){
		// 								var target = '_blank',
		// 								links = {
		// 									query_pen: `<?php echo base_url(); ?>dashboard/query_data_result_tracker/`+data.year_id+`/`+data.country_id+`/`+data.crop_id+`/`+data.id+`/1`,
		// 									query_res: `<?php echo base_url(); ?>dashboard/query_data_result_tracker/`+data.year_id+`/`+data.country_id+`/`+data.crop_id+`/`+data.id+`/2`
		// 								};
										
		// 								HTML += `<tr>
		// 									<td>`+data.username+`</td>
		// 									<td>`+data.country_name+`</td>
		// 									<td>`+data.crop_name+`</td>
		// 									<td>`+data.report+`</td>											
		// 									<td class="text-center">`;
		// 										if((userId != data.user_id) && (data.query_status == null)) {
		// 										HTML += `<a href="javascript:void(0)" class="btn btn-sm btn-warning send_back" data-recordid="${data.data_id}" data-formid="${form_id}" data-by="${data.username}">
		// 											Send Back
		// 										</a>`;
		// 										}
												
		// 										if(data.query_status == 1) {
		// 										if(userId != data.user_id) HTML += ` | `;
		// 										HTML += `<a href="javascript:void(0)" class="showQuery" data-recordid="${data.data_id}" data-formid="${form_id}">
		// 											<span class="badge badge-danger badge-query-pen">
		// 												View Query & Edit
		// 											</span>
		// 										</a>`;
		// 										} else if(data.query_status == 2) {
		// 										HTML += `<a href="javascript:void(0)" class="showQuery" data-recordid="${data.data_id}" data-formid="${form_id}">
		// 											<span class="badge badge-danger badge-query-res">
		// 												View Query & Edit
		// 											</span>
		// 										</a>`;
		// 										}

		// 										if((userId == data.user_id) && (data.query_status == null)) {
		// 										HTML += `N/A`;
		// 										}
		// 									HTML += `</td>
		// 								</tr>
		// 								<tr><td colspan="3" class="query_list"></td></tr>`;
		// 							});
		// 						}else{
		// 							HTML += `<tr><td colspan="2">No data found</td></tr>`;
		// 						}
		// 					HTML += `</tbody>
		// 				</table>
		// 			</div>
		// 		</div>`;
					
		// 		$('.resulttracker_reportdiv').removeClass('hidden');
		// 		$('.resulttracker_reportdiv').html(HTML);
		// 		$('html,body').animate({
		// 			scrollTop: $('.resulttracker_reportdiv').offset().top - 300
		// 		}, 500);
		// 	}
		// });
	});

	$('body').on('click', '.send_back', function(event) {
		var elem = $(this),
		modal = $('#sendBackModal'),
		backTo = elem.data('by'),
		formId = elem.data('formid'),
		recordId = elem.data('recordid');

		// Set values in modal
		modal.modal('show');
		modal.find('form')[0].reset();
		modal.find('#backTo').html(backTo);
		modal.find('form').data('id', recordId);
		modal.find('form').data('formid', formId);
	}).on('submit', '#sendBackForm', function(event) {
		event.preventDefault();
		var form = $(this),
		formData = new FormData(form[0]);
		formData.append('id', form.data('id'));
		
		form.find('button').prop('disabled', true);
		form.find('button[type="submit"]').html('Please wait...');
		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/send_back_result_tracker',
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
						$('body').find(`.view_resulttracker_report[data-formid="${form.data('formid')}"]`).trigger('click');
					}
				});
			}
		});
	});

	$('body').on('click', '.showQuery', function(event) {
		var elem = $(this);
		elem.closest('.table').find('.query_list').empty();
		
		if(!elem.hasClass('active')) {
			elem.addClass('active');
		} else {
			elem.removeClass('active');
			return false;
		}
		$('.showQuery').not(this).each(function(index) {
			if($(this).hasClass('active')) $(this).trigger('click');
		});

		var recorId = elem.data('recordid');
		elem.closest('.table').find('.query_list').html('<h4 class="text-center">Please Wait... Getting Data.</h4>');
		$.ajax({
			url: "<?php echo base_url(); ?>dashboard/get_result_tracker_query_list",
			type: "POST",
			dataType: "json",
			data : { data_id : recorId },
			error : function(){
				elem.closest('.card').find('.query_list').empty();
				$.toast({
					stack: false,
					icon: 'error',
					position: 'bottom-right',
					showHideTransition: 'slide',
					heading: 'Network Error!',
					text: 'Please check your internet connection.'
				});
			},
			success : function (response) {
				if(response.status === 0) {
					elem.closest('.card').find('.query_list').empty();
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

				// Prepare edit report HTML
				var HTML = `<div form-group">
					<textarea name="report" rows="6" class="form-control" id="textarea_1">`+(response.details != null ? response.details.report : '')+`</textarea>
					<p class="error red-800"></p>
					<p class="maxlengtherror red-800"></p>

					<div class="text-right form-group">`;
						if(response.details == null
						|| response.details.query_status == null) {
							HTML += `<button type="button" class="btn btn-success ml-2 submit_report" data-formid="`+response.details.form_id+`">Submit Report</button>`;
						} else {
							HTML += `<button type="button" class="btn btn-success ml-2 update_report" data-formid="`+response.details.form_id+`" data-recordid="`+response.details.data_id+`">Update Report</button>`;
						}
						HTML += `<button type="button" class="btn btn-danger ml-2 cancel_report" data-dismiss="modal">
							Close
						</button>
					</div>
				</div>`;

				// <img alt="Avatar" class="avatar avatar-xl mx-2" src="<?php echo base_url(); ?>upload/user/default.png" style="background-color:none;">
				// Preapare queries HTML
				HTML += `<div class="row bg-white">
					<div class="col-sm-12 form-group">
						<div class="border" style="border-bottom:none !important;">`;
						response.queries.forEach(function(query, index) {
							if(query.sent_by == response.details.user_id) {
							HTML += `<div class="media d-block d-sm-flex text-right">
								<div class="media-body pt-3 pt-sm-0 m-3">
									<h5 class="mg-b-5 tx-inverse tx-15">
										<i class="fa fa-calendar"></i> Posted On : ${query.query_datetime}
										<span class="mx-1">|</span>
										<i class="fa fa-user"></i> By : ${query.first_name} ${query.last_name}
									</h5>
									<p>${query.query}</p>
									<hr class="my-4">
								</div>
							</div>`;
							} else {
							HTML += `<div class="media d-block d-sm-flex">
								<div class="media-body pt-3 pt-sm-0 m-3">
									<h5 class="mg-b-5 tx-inverse tx-15">
										<i class="fa fa-user"></i> By : ${query.first_name} ${query.last_name}
										<span class="mx-1">|</span>
										<i class="fa fa-calendar"></i> Posted On : ${query.query_datetime}
									</h5>
									<p>${query.query}</p>
									<hr class="my-4">
								</div>
							</div>`;
							}
						});
						HTML += `</div>
					</div>

					<form id="queryForm" class="col-sm-12" data-id="${recorId}" data-user="${response.details.user_id}">
						<div class="form-group">
							<textarea rows="5" style="resize:vertical;" class="form-control" name="query" placeholder="Respond to the query..."></textarea>
							<span class="query error text-danger"></span>
						</div>

						<button class="btn btn-dark btn-sm float-right" type="submit">Respond</button>
					</form>
				</div>`;

				elem.closest('.table').find('.query_list').html(HTML);
				$('#textarea_1').richText();
			}
		});
	});
	$('body').on('submit', '#queryForm', function(event) {
		event.preventDefault();
		var form = $(this),
		formData = new FormData(form[0]);
		formData.append('id', form.data('id'));

		form.find('button').prop('disabled', true);
		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/respond_result_tracker_query',
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
			success: function(response){
				var response = JSON.parse(response);

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
				form.prev().find('.border').append(HTML);
				
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
</script>

<script type="text/javascript">
  var xport = {
    _fallbacktoCSV: true,  
    toXLS: function(tableId, filename) {   
    this._filename = (typeof filename == 'undefined') ? tableId : filename;

    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls'); 
    },
    toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
    },
    _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
    },
    _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }

    return 0;
    },
    _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it
      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
    },
    _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
    }
  };
</script>