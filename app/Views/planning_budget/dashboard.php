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

<div class="app-content page-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h3>Planning & Budgeting</h3>
				<!-- Year Country Crop -->
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Year</label>
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
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<?php
									$multiple = '';
									if ($this->session->userdata('role') != 3) {
										$multiple = 'multiple="multiple"';
									}
									?>
									<label class="form-label">Select Country</label>
									<select data-urole="<?php echo $this->session->userdata('role'); ?>" name="country" placeholder="Select Country" class="form-control"></select>

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
		$('[name="year"]').on('change', function(event) {			
			getCountry();
		}).multipleSelect({
			filter: true
		});

		$('[name="country"]').on('change', function(event) {
			getCrops();
		}).multipleSelect({
			filter: true
		});

		$('[name="crop"]').on('change', function(event) {
			//getPoDetailsCounters();
			getPO();
		}).multipleSelect({
			filter: true
		});
		$('[name="year"]').trigger('change');
	});

	$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
		var id = $(e.target).data('id');
		getPoDetails(id);
	});

	// Handle collapse icon change
	$('body').on('click', '[data-toggle="collapse"]', function(event) {
		var elem = $(this);
		if (elem.hasClass('fa-chevron-right')) {
			elem.removeClass('fa-chevron-right');
			elem.addClass('fa-chevron-down');
		} else {
			elem.removeClass('fa-chevron-down');
			elem.addClass('fa-chevron-right');
		}
	});

	function getCountry() {
		$('[name="country"]').html('');
		var urole = $('[name="country"]').data('urole');

		// AJAX to get country and crop
		$.ajax({
			url: '<?php echo base_url(); ?>planning_helper/get_country',
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

				var countries = '';
				var counter = 0;
				var selected = "" + response.selected;
				var selArr = selected.split(',');
				response.countries.forEach(function(country, index) {
					if (selArr.length > counter && selArr[counter] == country.country_id) {
						counter++;
						countries += '<option value="' + country.country_id + '" selected >' + country.country_name + '</option>';
					} else {
						countries += '<option value="' + country.country_id + '" >' + country.country_name + '</option>';
					}
				});
				$('[name="country"]').html(countries);
				// Refresh options
				$('[name="country"]').trigger('change');
				$('[name="country"]').multipleSelect('refresh');
			}
		});
	}

	function getCrops() {
		$('[name="crop"]').html('');

		// AJAX to get crop
		$.ajax({
			url: '<?php echo base_url(); ?>planning_helper/get_crop',
			type: 'POST',
			dataType: 'JSON',
			data: {
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
				var crops = '';
				var counter = 0;
				var selected = "" + response.selected;
				var selArr = selected.split(',');
				response.crops.forEach(function(crop, index) {
					if (selArr.length > counter && selArr[counter] == crop.crop_id) {
						counter++
						crops += '<option value="' + crop.crop_id + '" selected >' + crop.crop_name + '</option>';
					} else {
						crops += '<option value="' + crop.crop_id + '" >' + crop.crop_name + '</option>';
					}
				});
				$('[name="crop"]').html(crops);

				// Refresh options
				$('[name="crop"]').trigger('change');
				$('[name="crop"]').multipleSelect('refresh');
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
							<h3 class="card-title mr-5">Please Wait... Getting Data.</h3>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>');

		// AJAX to get po
		$.ajax({
			url: '<?php echo base_url(); ?>planning_helper/getUserAssignedPos',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val(),
				crop: $('[name="crop"]').val()
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

	function getPoDetails(id) {
		$('#po' + id).html('<div class="row">\
			<div class="col-md-12 col-lg-12">\
				<div class="card card-block">\
					<div class="card-header d-sm-flex d-block">\
						<h3 class="card-title mr-5">Please Wait... Getting Data.</h3>\
					</div>\
				</div>\
			</div>\
		</div>');
		// AJAX to get po details
		$.ajax({
			url: '<?php echo base_url(); ?>planning_helper/get_po_details',
			type: 'POST',
			dataType: 'JSON',
			data: {
				po: id,
				year: $('[name="year"]').val(),
				country: $('select[name="country"]').val(),
				crop: $('select[name="crop"]').val()
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

				var user_role = <?php echo $this->session->userdata('role'); ?>;
				var $po = response.po_list[0];
				var year = $('[name="year"]').val();
				var country = $('[name="country"]').val();
				var crop = $('[name="crop"]').val();
				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">							
							<div class="card-body mb-5">
								<div class="table-responsive">
									<table class="table table-bordered table_th">`;
										$po['output_list'].forEach(function($output, $key) {
											HTML += `<thead>
											<tr>
												<th style="text-align:justify; padding:15px; background:#EAF3EF; font-size: 17px;">` + $output.title +` <p class="pull-right text-info" style="font-weight:bold;">Output Budget: ` + $output.output_budget +`</p></th>
											</tr>
										</thead>`;
											if ($output['indicator_list'].length > 0) {
												HTML += `<tbody>
													<tr>
														<td colspan="6">
															<div class="table-responsive">
																<table class="table table-bordered table_th m-0">
																	<thead>
																		<tr>
																			<td style="width:60%;"></td>
																			<td style="width:12%;"></td>
																			<td style="width:8%;"></td>
																			<td>Person responsible for reporting</td>
																		</tr>
																	</thead>`;
																	$output['indicator_list'].forEach(function($indicator, $key) {
																		HTML += `<tbody>
																			<tr class="bg-white" style="cursor: auto">`;
																				HTML += `<td class="output_text">${$indicator['title']}</td>
																				<td>`;
																					if($indicator['planning_uploadcount'] == null){
																						HTML += `<a class="btn btn-sm btn-dark upload_targetdata" data-formid="${$indicator['id']}" href="javascript:void(0);">
																						Add target</a>`;
																					}else{
																						HTML += `<a class="btn btn-sm btn-success upload_targetdata" data-formid="${$indicator['id']}" href="javascript:void(0);">
																						Edit target</a>`;
																					}
																				HTML += `</td>
																				<td>`;
																					if($indicator['planning_uploadcount'] != null){
																						HTML += `<span class="badge badge-submit ml-5">
																							Target <span class="bg-white code-style">${$indicator['planning_uploadcount']['target_val']}</span>
																						</span>`;
																					}
																				HTML +=`</td>
																				<td>`;
																					if($indicator['planning_uploadcount'] != null){
																						HTML += `<p>${$indicator['planning_uploadcount']['name']}</p>`;
																					}
																				HTML +=`</td>
																			</tr>
																		</tbody>`;
																	});
																HTML += `</table>

																<table class="table table-bordered table_th mt-5">
																	<thead>
																		<tr>
																			<td style="width:60%;"></td>
																			<td style="width:12%;"></td>
																			<td style="width:8%;"></td>
																			<td>Person responsible for reporting</td>
																		</tr>
																	</thead>`;
																	$output['activities_list'].forEach(function($activity, $key) {
																		HTML += `<tbody>
																			<tr class="bg-white" style="cursor: auto">`;
																				HTML += `<td class="output_text" style="color: #13721f !important;">${$activity['title']}</td>
																				<td>`;
																					if($activity['subacticity_uploadcount'] > 0){
																						HTML += `<a class="btn btn-sm btn-success upload_activitydata" data-formid="${$activity['id']}" href="javascript:void(0);">
																						Edit activity</a>`;
																					}else{
																						HTML += `<a class="btn btn-sm btn-dark upload_activitydata" data-formid="${$activity['id']}" href="javascript:void(0);">
																						Add activity</a>`;
																					}
																				HTML += `</td>
																				<td>`;
																					if($activity['subacticity_uploadcount'] > 0){
																						HTML += `<span class="badge badge-submit ml-5">
																							Budget <span class="bg-white code-style">${$activity['subactivity_budet']}</span>
																						</span>`;
																					}
																				HTML +=`</td>
																				<td>`;
																					if($activity['subacticity_uploadcount'] > 0){
																						HTML += `<p>${$activity['subactivity_personname']}</p>`;
																					}
																				HTML +=`</td>
																			</tr>
																		</tbody>`;
																	});
																HTML += `</table>
															</div>
														</td>
													</tr>
												</tbody>`;
											};
										});
									HTML += `</table>
								</div>
							</div>
						</div>
					</div>
				</div>`;
				$('#po' + id).html(HTML);
			}
		});
	}

	$('body').on('click', '.upload_targetdata', function() {
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country"]').val();
		var crop_id = $('[name="crop"]').val();

		var form_id = $(this).data('formid');

		var url = "<?php echo base_url(); ?>planning_budget/upload_targetdata/" + form_id + "/" + year_id + "/" + country_id + "/" + crop_id + "";
		window.open(url, '_blank');
	});

	$('body').on('click', '.upload_activitydata', function() {
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country"]').val();
		var crop_id = $('[name="crop"]').val();

		var form_id = $(this).data('formid');

		var url = "<?php echo base_url(); ?>planning_budget/upload_activitydata/" + form_id + "/" + year_id + "/" + country_id + "/" + crop_id + "";
		window.open(url, '_blank');
	});
</script>

