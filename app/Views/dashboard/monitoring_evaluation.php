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
								<li><a href="<?php echo base_url() . 'dashboard/user_uploadinfo'; ?>" class="text-black">USER UPLOAD INFO</a></li>
								<li><a href="javascript:void(0)'; ?>" class="text-black active">M & E</a></li>
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
		getPoDetails(id);
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
					getPoDetails(response.pos[0].po_id);
				}
			}
		});
	}

	function getPoDetails(po_id) {
		$elem = $(this);
		$('#po' + po_id).html('');

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/get_indicatorwisecount',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				country: $('[name="country"]').val(),
				crop: $('[name="crop"]').val(),
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
				var country_id = $('[name="country"]').val();
				var crop_id = $('[name="crop"]').val();
				var user_id = '<?php echo $this->session->userdata('login_id'); ?>'

				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">
							
							<div class="card-body mb-5">
								<div class="table-responsive">
									<table class="table table-bordered table_th">`;
										response.outputs.forEach(function($output, $key) {
											HTML += `<thead>
											<tr>
												<th style="text-align:justify;padding:15px;line-height:2;background:#EAF3EF;">`+$output.title;
													if($output['upload_count'] && $output['upload_count'] > 0) {
														HTML += ` - <strong class="text-success">
															Report submitted -
															<a href="javascript:void(0)" class="reporting" data-formid="${$output['id']}">View Details</a>
														</strong>`;
													} else {
														HTML += ` - <strong class="text-danger">Report not submitted</strong>`;
													}
												HTML += `</th>
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
																			<td style="width:30%;">Indicator</td>
																			<td></td>
																		</tr>
																	</thead>`;
																	$output['indicator_list'].forEach(function($indicator, $key) {
																		var links = {
																			saved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/1`,
																			submitted: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/2`,
																			pending: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/pending_approval`,
																			approved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/3`,
																			query_pen: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/1`,
																			query_res: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/2`,
																			my_query_pen: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/1/`+user_id,
																			my_query_res: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $indicator['id'] + `/2/`+user_id
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

																					<a href="${(($indicator['my_query_pen'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.my_query_pen)}"" target="${(($indicator['my_query_pen'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-pen">
																							My Queries Pending <span class="bg-white code-style">${$indicator['my_query_pen']}</span>
																						</span>
																					</a> |
																					
																					<a href="${(($indicator['my_query_res'] == 0 || $indicator['subindicator_list'].length > 0) ? 'javascript:void(0);' : links.my_query_res)}"" target="${(($indicator['my_query_res'] == 0 || $indicator['subindicator_list'].length > 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-res">
																							My Queries Responded <span class="bg-white code-style">${$indicator['my_query_res']}</span>
																						</span>
																					</a>
																				</td>
																			</tr>
																		</tbody>`;

																		if ($indicator['subindicator_list'].length > 0) {
																			HTML += `<tbody class="collapse" id="indicator${$indicator['id']}">`;
																			$indicator['subindicator_list'].forEach(function($subindicator, $key) {
																				var links = {
																					saved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/1`,
																					submitted: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/2`,
																					pending: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/pending_approval`,
																					approved: `<?php echo base_url(); ?>dashboard/display_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/3`,
																					query_pen: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/1`,
																					query_res: `<?php echo base_url(); ?>dashboard/displayquery_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/2`,
																					my_query_pen: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/1/`+user_id,
																					my_query_res: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + country_id + `/` + crop_id + `/` + $subindicator['id'] + `/2/`+user_id
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

																					<a href="${(($subindicator['my_query_pen'] == 0) ? 'javascript:void(0);' : links.my_query_pen)}"" target="${(($subindicator['my_query_pen'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-pen">
																							My Queries Pending <span class="bg-white code-style">${$subindicator['my_query_pen']}</span>
																						</span>
																					</a> |
																					
																					<a href="${(($subindicator['my_query_res'] == 0) ? 'javascript:void(0);' : links.my_query_res)}"" target="${(($subindicator['my_query_res'] == 0) ? '' : '_blank')}">
																						<span class="badge badge-danger badge-query-res">
																							My Queries Responded <span class="bg-white code-style">${$subindicator['my_query_res']}</span>
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
				$('#po' + po_id).html(HTML);
			}
		});
	}

	$('body').on('click', '.reporting', function(){
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country"]').val();
		var crop_id = $('[name="crop"]').val();
		var form_id = $(this).data('formid');
		/*
		var url = "<?php echo base_url(); ?>reporting/reporting/"+form_id+"/"+year_id+"/"+country_id+"/"+crop_id+"";
		window.open(url, '_blank');*/

		if(country_id != 'all' && crop_id != 'all'){
			var url = "<?php echo base_url(); ?>reporting/review_data/"+form_id+"/"+year_id+"/"+country_id+"/"+crop_id+"";
			window.open(url, '_blank');
		}else{
			if(country_id == 'all' && crop_id == 'all'){
				var msg = 'Please select only one country and crop for reporting data.';
			}else if(country_id == 'all'){
				var msg = 'Please select only one country for reporting data.';
			}else if(crop_id == 'all'){
				var msg = 'Please select only one crop for reporting data.';
			}else if(country_id == '' && crop_id == ''){
				var msg = 'Please select one country and crop for reporting data.';
			}

			$.toast({
				stack: false,
				icon: 'warning',
				position: 'bottom-right',
				showHideTransition: 'slide',
				heading: 'Warning!',
				text: msg
			});
		}
	});
</script>