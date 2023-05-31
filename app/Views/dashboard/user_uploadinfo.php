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

<div class="app-content page-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h3>Reporting Dashboard</h3>
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

				<!-- Reporting/Approval/Review Tab -->
				<div class="panel panel-primary">
					<div class="tab-menu-heading p-0 bg-light">
						<div class="tabs-menu1">
							<!-- Tabs -->
							<ul class="nav panel-tabs">
								<li><a href="<?php echo base_url() . 'dashboard'; ?>" class="text-black">REPORTING</a></li>

								<?php if($this->session->userdata('role') == 6){ ?>
								<li><a href="<?php echo base_url() . 'dashboard/approval'; ?>" class="text-black">APPROVAL</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/review'; ?>" class="text-black">REVIEW</a></li>
								<li><a href="javascript:void(0)'; ?>" class="text-black active">USER UPLOAD INFO</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/monitoring_evaluation'; ?>" class="text-black">M & E</a></li>
								<?php } ?>

								<?php if ($this->session->userdata('role') == 4) { ?>
								<li><a href="<?php echo base_url() . 'dashboard/approval'; ?>" class="text-black">APPROVAL</a></li>
								<?php } else if ($this->session->userdata('role') == 5) { ?>
								<li><a href="<?php echo base_url() . 'dashboard/approval'; ?>" class="text-black">APPROVAL</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/review'; ?>" class="text-black">REVIEW</a></li>
								<?php } ?>

								<?php if($this->session->userdata('role') == 6 || $this->session->userdata('role') == 5 || $this->session->userdata('role') == 4){ ?>
								<li><a href="<?php echo base_url() . 'dashboard/result_tracker'; ?>" class="text-black">RESULTS TRACKER</a></li>
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
			getPO();
		}).multipleSelect({
			filter: true
		});
		$('[name="year"]').trigger('change');
	});

	$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
		var id = $(e.target).data('id');
		get_useruploadinfo(id);
	});

	function getCountry() {
		$('[name="country"]').html('');
		var urole = $('[name="country"]').data('urole');

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

				var countries = '<option value="all">All countries</option>';
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
			url: '<?php echo base_url(); ?>helper/get_crop',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val(),
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
				var crops = '<option value="all">All Crops</option>';
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
			url: '<?php echo base_url(); ?>helper/get_po',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val(),
				crop: $('[name="crop"]').val(),
				purpose : 'user_uploadinfo'
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
					get_useruploadinfo(response.pos[0].po_id);
				}
			}
		});
	}

	function get_useruploadinfo(po_id) {
		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/get_useruploadinfo',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val(),
				crop: $('[name="crop"]').val(),
				po_id : po_id
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

				var user_role = <?php echo $this->session->userdata('role'); ?>;
				var $po = po_id;
				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">
							<div class="card-body mb-5">
								<button id="btnExport" onclick="javascript:xport.toCSV('user_infotable', 'User upload info');" class="btn btn-success btn-sm pull-right" style="margin-bottom: 10px; "> Export to CSV</button>
								<div class="table-responsive">
									<table class="table table-bordered table_th" id="user_infotable">
										<thead>
											<tr>
												<th>Sl.no</th>
												<th>name</th>
												<th>Indicators assigned</th>
												<th>Indicators Reported</th>`;
												/*<th>Sub indicators assigned</th>
												<th>Total assigned</th>*/
												HTML += `<th>Saved Records</th>
												<th>Submitted Records</th>
												<th>Approved Records</th>`;
												/*<th>Total Records</th>*/
											HTML += `</tr>
										</thead>
										<tbody>`;
											if(response.user_list.length > 0){
												response.user_list.forEach(function($user, $key){
													HTML += `<tr>
														<td>${$key+1}</td>`;
														if($user['user_uploadcount'] > 0){
															HTML += `<td><a href="javascript:void(0);" class="get_indicatorwisecount" data-userid="${$user['user_id']}" data-po_id="${po_id}">${$user['first_name']} ${$user['last_name']}</a></td>`;
														}else{
															HTML += `<td>${$user['first_name']} ${$user['last_name']} </td>`;
														}
														HTML += `<td>${$user['user_assignedindicators']}</td>
														<td>${$user['unique_indicatorsreported']}</td>`;
														/*<td>${$user['user_assignedsubindicators']}</td>
														<td>${$user['user_assignedindicators_count']}</td>*/
														HTML += `<td>${$user['user_savecount']}</td>
														<td>${$user['user_submittedcount']}</td>
														<td>${$user['user_approvedcount']}</td>`;
														/*if($user['user_uploadcount'] > 0){
															HTML += `<td><a href="javascript:void(0);" class="get_indicatorwisecount" data-userid="${$user['user_id']}" data-po_id="${po_id}">${$user['user_uploadcount']}</a></td>`;
														}else{
															HTML += `<td>${$user['user_uploadcount']}</td>`;
														}*/
													HTML += `</tr>`;
												});
											}else{
												HTML += `<tr>
													<td colspan="6">No users found for the selected country and crop</td>
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
			}
		});
	}

	$('body').on('click', '.get_indicatorwisecount', function(){
		$elem = $(this);
		$('.user_indicatorinfo').html('');
		
		var user_id = $elem.data('userid');
		var po_id = $elem.data('po_id');

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/get_indicatorwisecount',
			type: 'POST',
			dataType: 'JSON',
			data: {
				user_id : user_id,
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val(),
				crop: $('[name="crop"]').val(),
				po_id : po_id
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
				var country_id = $('[name="country"]').val();
				var crop_id = $('[name="crop"]').val();

				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">
							
							<div class="card-body mb-5">
								<div class="table-responsive">
									<table class="table table-bordered table_th">`;
										response.outputs.forEach(function($output, $key) {
											HTML += `<thead>
											<tr>
												<th>`+$output.title+`</th>
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
																			<td></td>
																			<td style="width:45%;">Indicator</td>
																			<td></td>
																		</tr>
																	</thead>`;
																	$output['indicator_list'].forEach(function($indicator, $key) {
																		var links = {
																			saved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/1/`+user_id,
																			submitted: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/2/`+user_id,
																			pending: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/pending_approval/`+user_id,
																			approved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/3/`+user_id,
																			query_pen: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/1/`+user_id,
																			query_res: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/2/`+user_id
																		};
																		HTML += `<tbody>
																			<tr class="bg-white" style="cursor: auto">`;
																				if ($indicator['subindicator_list'].length > 0) {
																					HTML += `<td style="width: 3.1%;">
																						<i class="fa fa-chevron-right collapsed" data-toggle="collapse" data-target="#indicator${$indicator['id']}"></i>
																					</td>`;
																				} else {
																					HTML += `<td style="width: 3.1%;"></td>`;
																				}
																				HTML += `<td class="output_text">${$indicator['title']}</td>
																				<td>
																					<a href="${(($indicator['saved_count'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.saved)}"" target="${(($indicator['saved_count'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-saved">
																							Saved <span class="bg-white code-style">${$indicator['saved_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($indicator['submitted_count'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.submitted)}"" target="${(($indicator['submitted_count'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-submit">
																							Submitted <span class="bg-white code-style">${$indicator['submitted_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($indicator['pendingapproval_count'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.pending)}"" target="${(($indicator['pendingapproval_count'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-approve-pen">
																							Pending Approval <span class="bg-white code-style">${$indicator['pendingapproval_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($indicator['approved_count'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.approved)}"" target="${(($indicator['approved_count'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-approve">
																							Approved <span class="bg-white code-style">${$indicator['approved_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($indicator['query_pen'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.query_pen)}"" target="${(($indicator['query_pen'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-pen">
																							Query Pending <span class="bg-white code-style">${$indicator['query_pen']}</span>
																						</span>
																					</a> |
																					<a href="${(($indicator['query_res'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.query_res)}"" target="${(($indicator['query_res'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-res">
																							Query Responded <span class="bg-white code-style">${$indicator['query_res']}</span>
																						</span>
																					</a>
																				</td>`;
																				/*<td>${$indicator['saved_count']}</td>
																				<td>${$indicator['submitted_count']}</td>
																				<td>${$indicator['approved_count']}</td>
																				<td>`;
																					if ($indicator['subindicator_list'].length == 0 && $indicator['field_count'] > 0) {
																						HTML += `<a data-formid="${$indicator['id']}" href="javascript:void(0);">${$indicator['upload_count']}</a>`;
																						HTML += `<p>${$indicator['saved_count'] + $indicator['submitted_count'] + $indicator['approved_count']}</p>`;
																					}
																				HTML += `</td>`;*/
																			HTML += `</tr>
																		</tbody>`;

																		if ($indicator['subindicator_list'].length > 0) {
																			HTML += `<tbody class="collapse" id="indicator${$indicator['id']}">`;
																			$indicator['subindicator_list'].forEach(function($subindicator, $key) {
																				var links = {
																					saved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/1/`+user_id,
																					submitted: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/2/`+user_id,
																					pending: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/pending_approval/`+user_id,
																					approved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/3/`+user_id,
																					query_pen: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/1/`+user_id,
																					query_res: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/2/`+user_id
																				};
																				HTML += `<tr style="cursor: auto">
																				<td></td>
																				<td>${$subindicator['title']}</td>
																				<td>
																					<a href="${(($subindicator['saved_count'] == 0) ? 'javascript:void(0);' : links.saved)}"" target="${(($subindicator['saved_count'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-saved">
																							Saved <span class="bg-white code-style">${$subindicator['saved_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($subindicator['submitted_count'] == 0) ? 'javascript:void(0);' : links.submitted)}"" target="${(($subindicator['submitted_count'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-submit">
																							Submitted <span class="bg-white code-style">${$subindicator['submitted_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($subindicator['pendingapproval_count'] == 0) ? 'javascript:void(0);' : links.pending)}"" target="${(($subindicator['pendingapproval_count'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-approve-pen">
																							Pending Approval <span class="bg-white code-style">${$subindicator['pendingapproval_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($subindicator['approved_count'] == 0) ? 'javascript:void(0);' : links.approved)}"" target="${(($subindicator['approved_count'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-approve">
																							Approved <span class="bg-white code-style">${$subindicator['approved_count']}</span>
																						</span>
																					</a> |

																					<a href="${(($subindicator['query_pen'] == 0) ? 'javascript:void(0);' : links.query_pen)}"" target="${(($subindicator['query_pen'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-pen">
																							Query Pending <span class="bg-white code-style">${$subindicator['query_pen']}</span>
																						</span>
																					</a> |
																					<a href="${(($subindicator['query_res'] == 0) ? 'javascript:void(0);' : links.query_res)}"" target="${(($subindicator['query_res'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-res">
																							Query Responded <span class="bg-white code-style">${$subindicator['query_res']}</span>
																						</span>
																					</a>
																				</td>
																				</tr>`;
																			});
																			HTML += `</tbody>`;
																		}
																	});
																HTML += `</table>
															</div>
														</td>
													</tr>
												</tbody>`
											};
										});
									HTML += `</table>
								</div>
							</div>
						</div>
					</div>
				</div>`;
				$('.user_indicatorinfo').html(HTML);
				$('html, body').animate({
			        scrollTop: $(".user_indicatorinfo").offset().top
			    }, 2000);
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