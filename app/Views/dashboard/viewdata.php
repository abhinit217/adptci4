
 <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="<?php echo base_url(); ?>include/includenew/xlsx/dist/xlsx.full.min.js"></script>
<style type="text/css">
	.badge-approved{
		background-color:#4454c3 ;
	}
	.badge-rejected{
		background-color:#fa2428 ;
	}
	.form-control button {
		border: none !important;
	}
	.stricky{
		position: fixed;
		top: 63px;
		width: 100%;
		z-index: 111;
	}
	.app-content.page-body {
		margin-top: 5rem!important;
	}
	.filter-multi>button.ms-choice {
		display: block;
			width: 100%;
			height: 26px;
			padding: 0px;
			overflow: hidden;
			cursor: pointer;
			border: 0px solid #aaa;
			text-align: left;
			white-space: nowrap;
			line-height: 38px;
			color: #fff;
			text-decoration: none;
			border-radius: 4px;
			background-color: #004b03!important;
	}
	.filter-multi.bg_drop {
		display: block;
		width: 100%;
		padding: 0.375rem 0.75rem;
		font-size: 0.9375rem;
		line-height: 1.6;
		background-color: #004b03;
		background-clip: padding-box;
		border: 1px solid #d3dfea;
		transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
		border-radius: 5px;
		outline: 0;
		color: #4454c3;
		opacity: 1;
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
	.table td, .table th {
		padding: 0.75rem;
		vertical-align: middle;
		border-top: 0px solid #dee2e6;
		/* text-align: center; */
	}
</style>

<div class="app-content page-body mb-5">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<!-- Reporting/Approval/Review Tab -->
				
				
				<!-- <h4 class="mt-5">Reporting Dashboard</h4> -->
				<h4 class="mt-5">View Data Dashboard</h4>
				<!-- Year Country Crop -->
				<div class="card">
					<div class="card-body" style="padding: 20px;">
						<div class="row">
							<div class="col-xs-4 col-md-3 col-lg-3 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Year</label>
									<select name="year" placeholder="Select Year(s)" class="form-control">
										<!-- <?php foreach ($year_list as $key => $year) {
											$selected = ($key == 0) ? 'selected' : ''; ?>
											<option value="<?php echo $year['year_id']; ?>" <?php echo $selected; ?>>
												<?php echo $year['year']; ?>
											</option>
										<?php } ?> -->
										<option value="1" >2021</option>
										<option value="2" selected="">2022</option>
										<!-- <option value="3">2023</option> -->
									</select>
								</div>
							</div>
							<div class="col-xs-4 col-md-3 col-lg-3 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Program</label>
									<select name="program" placeholder="Select Program" class="form-control"></select>
								</div>
							</div>
							<div class="col-xs-4 col-md-6 col-lg-6 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Cluster</label>
									<select name="cluster" placeholder="Select Cluster" class="form-control"></select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-primary table_list"></div>

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
			getProgram();
		}).multipleSelect({
			filter: true
		});

		$('[name="program"]').on('change', function(event) {
			getClusters();
		}).multipleSelect({
			filter: true
		});

		$('[name="cluster"]').on('change', function(event) {
			getProgramDetails();
		}).multipleSelect({
			filter: true
		});

		$('[name="year"]').trigger('change');
	});

	$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
		var id = $(e.target).data('id');
		getPoDetails(id);
	});

	$('body').on('click', '.reporting', function() {
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country"]').val();
		var program_id = $('[name="program"]').val();
		var crop_id = $('[name="crop"]').val();

		var form_id = $(this).data('formid');

		var url = "<?php echo base_url(); ?>reporting/reporting/" + form_id + "/" + year_id + "/" + program_id + "";
		window.open(url, '_blank');
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

	function getProgram() {
		$('[name="program"]').html('');

		// AJAX to get programs
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_program',
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
				response.pos.forEach(function(program, index) {
					programs += '<option value="' + program.prog_id + '" >' + program.prog_name + '</option>';
				});
				$('[name="program"]').html(programs);

				// Refresh options
				$('[name="program"]').trigger('change');
				$('[name="program"]').multipleSelect('refresh');
			}
		});
	}

	function getClusters(argument) {
		$('[name="cluster"]').html('');

		// AJAX to get programs
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_clusters',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				program: $('[name="program"]').val()
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
				var clusters = '';
				var counter = 0;
				var selected = "" + response.selected;
				var selArr = selected.split(',');
				response.clusters.forEach(function(cluster, index) {
					clusters += '<option value="' + cluster.cluster_id + '" >' + cluster.cluster_name + '</option>';
				});
				$('[name="cluster"]').html(clusters);

				// Refresh options
				$('[name="cluster"]').trigger('change');
				$('[name="cluster"]').multipleSelect('refresh');
			}
		});
	}

	function getProgramDetails() {
		$('.table_list').html('');

		// AJAX to get po details
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_viewdata_details',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
				program: $('[name="program"]').val(),
				cluster: $('[name="cluster"]').val(),
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

				// <div class="plus-minus-toggle collapsed" data-toggle="collapse" data-target="#indicator${$indicator['id']}"></div>
				var user_role = <?php echo $this->session->userdata('role'); ?>;
				var $po = response.po_list[0];
				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">
							
							<div class="card-body mb-5">`;
								$po['cluster_list'].forEach(function($output, $key) {
									if ($output['indicator_list'].length > 0) {
										HTML += `<div class="table-responsive">
											<table class="table table-bordered table_th m-0">
												<thead>
													<tr>
														<td style="width:35%;"></td>
														<td></td>
														<td></td>
													</tr>
												</thead>`;
												$output['indicator_list'].forEach(function($indicator, $key) {
													HTML += `<tbody>
														<tr class="bg-white" style="cursor: auto">`;
															/*if ($indicator['subindicator_list'].length > 0) {
																HTML += `<td style="width: 3.1%;">
																	<i class="fa fa-chevron-right collapsed" data-toggle="collapse" data-target="#indicator${$indicator['id']}"></i>
																</td>`;
															} else {
																HTML += `<td style="width: 3.1%;"></td>`;
															}*/
															HTML += `<td class="output_text" style="width:1200px;">${$indicator['title']}</td>
															 `;
															// 	if ($indicator['subindicator_list'].length == 0 && $indicator['field_count'] > 0) {
															// 		HTML += `<a class="btn btn-sm btn-dark reporting" data-formid="${$indicator['id']}" href="javascript:void(0);">
															// 		Add new report</a>`;
															// 	}
															// HTML += `</td>
															HTML += `
															<td style="text-align: center" ><b><a href="#"  onclick="download_data(${$indicator['id']});" class="text-primary" >Download</a></b></td>
															<td data-type="indicator" data-id="${$indicator['id']}"></td>
															
														</tr>
													</tbody>`;

													if ($indicator['subindicator_list'].length > 0) {
														HTML += `<tbody class="collapse" id="indicator${$indicator['id']}">`;
														$indicator['subindicator_list'].forEach(function($subindicator, $key) {
															HTML += `<tr style="cursor: auto">
															<td></td>
															<td>${$subindicator['title']}</td>
															<td>`;
															if ($subindicator['field_count'] > 0) {
																HTML += `<a class="btn btn-sm btn-dark reporting" data-formid="${$subindicator['id']}" href="javascript:void(0);">
																Add new report
																</a>`;
															}
															HTML += `</td>
															<td data-type="subindicator" data-id="${$subindicator['id']}"></td>
															</tr>`;
														});
														HTML += `</tbody>`;
													}
												});
											HTML += `</table>
										</div>`;
									};
								});
							HTML += `</div>
						</div>
					</div>
				</div>`;

				$('.table_list').html(HTML);

				getPoDetailsCounters();
			}
		});
	}

	function getPoDetailsCounters() {
		var poid = $('[name="program"]').val();
		var HTML = `<a href="javascript:void(0);">
			<span class="badge badge-saved">
				Saved <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a> |

		<a href="javascript:void(0);">
			<span class="badge badge-submit">
				Submitted <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a> |
		
		<a href="javascript:void(0);">
			<span class="badge badge-approved">
			Approved <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a> | 
		<a href="javascript:void(0);">
			<span class="badge badge-rejected">
				Rejected <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a>`;
		/*var HTML = `<a href="javascript:void(0);">
			<span class="badge badge-saved">
				Saved <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a> |

		<a href="javascript:void(0);">
			<span class="badge badge-submit">
				Submitted <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a> |
		<a href="javascript:void(0);">
			<span class="badge badge-approved">
			Approved <span class="bg-white code-style">
					<span class="loading"></span>
				</span>
			</span>
		</a>`;*/
		$('body').find('[data-type="indicator"], [data-type="subindicator"]').html(HTML);

		// AJAX to get po details counter values
		$.ajax({
			url: '<?php echo base_url(); ?>helper/get_viewdata_details_counter',
			type: 'POST',
			dataType: 'JSON',
			data: {
				// po: poid,
				po: $('[name="program"]').val(),
				year: $('[name="year"]').val()
			},
			error: function() {
				// $.toast({
				// 	stack: false,
				// 	icon: 'error',
				// 	position: 'bottom-right',
				// 	showHideTransition: 'slide',
				// 	heading: 'Network Error!',
				// 	text: 'Please check your internet connection.'
				// });
				var HTML = `<a href="javascript:void(0);">
					<span class="badge badge-saved">
						Saved <span class="bg-white code-style">N/A</span>
					</span>
				</a> |

				<a href="javascript:void(0);">
					<span class="badge badge-submit">
						Submitted <span class="bg-white code-style">N/A</span>
					</span>
				</a> |
				<a href="javascript:void(0);">
					<span class="badge badge-approved">
					Approved <span class="bg-white code-style">
						</span>
					</span>
				</a> | 
				<a href="javascript:void(0);">
					<span class="badge badge-rejected">
						Rejected <span class="bg-white code-style">
						</span>
					</span>
				</a> `;
				$('body').find('[data-type="indicator"], [data-type="subindicator"]').html(HTML);
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

				var year_id = $('[name="year"]').val();
				var HTML = `<a href="javascript:void(0);">
					<span class="badge badge-saved">
						Saved <span class="bg-white code-style">0</span>
					</span>
				</a> |

				<a href="javascript:void(0);">
					<span class="badge badge-submit">
						Submitted <span class="bg-white code-style">0</span>
					</span>
				</a> |
				<a href="javascript:void(0);">
					<span class="badge badge-approved">
					Approved <span class="bg-white code-style">0
						</span>
					</span>
				</a> | 
				<a href="javascript:void(0);">
					<span class="badge badge-rejected">
						Rejected <span class="bg-white code-style">0
						</span>
					</span>
				</a>`;
				$('body').find('[data-type="indicator"], [data-type="subindicator"]').html(HTML);

				var user_id = <?php echo $this->session->userdata('login_id'); ?>;

				response.subindicators.forEach(function(indi, index) {
					var links = {
						saved: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/1/` + user_id + `/` + poid,
						submitted: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/2/` + user_id + `/` + poid,
						pending: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/pending_approval/` + user_id + `/` + poid,
						approved: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/3/` + user_id + `/` + poid,
						rejected: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/4/` + user_id + `/` + poid,
						query_pen: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + indi.id + `/1/` + user_id + `/` + poid,
						query_res: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + indi.id + `/2/` + user_id + `/` + poid
					};

					var HTML = `<a href="${((indi.saved == 0) ? 'javascript:void(0);' : links.saved)}" target="${((indi.saved == 0) ? '' : '_blank')}">
						<span class="badge badge-saved">
							Saved <span class="bg-white code-style">${indi.saved}</span>
						</span>
					</a> |

					<a href="${((indi.submitted == 0) ? 'javascript:void(0);' : links.submitted)}" target="${((indi.submitted == 0) ? '' : '_blank')}">
						<span class="badge badge-submit">
							Submitted <span class="bg-white code-style">${indi.submitted}</span>
						</span>
					</a> | 
					<a href="${((indi.approved == 0) ? 'javascript:void(0);' : links.approved)}" target="${((indi.approved == 0) ? '' : '_blank')}">
						<span class="badge badge-submit">
							Approved <span class="bg-white code-style">${indi.approved}</span>
						</span>
					</a> |
					<a href="${((indi.rejected == 0) ? 'javascript:void(0);' : links.rejected)}" target="${((indi.rejected == 0) ? '' : '_blank')}">
						<span class="badge badge-submit">
							Rejected <span class="bg-white code-style">${indi.rejected}</span>
						</span>
					</a>
					`;
					$('body').find('[data-type="subindicator"][data-id="' + indi.id + '"]').html(HTML);
				});

				response.indicators.forEach(function(indi, index) {
					// Get sub indicator container
					var subContainer = $('body').find('[data-type="indicator"][data-id="' + indi.id + '"]');
					subContainer = subContainer.closest('tbody').next('tbody#indicator' + indi.id);
					var target = '_blank',
						links = {
							saved: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/1/` + user_id + `/` + poid,
							submitted: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/2/` + user_id + `/` + poid,
							pending: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/pending_approval/` + user_id + `/` + poid,
							approved: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/3/` + user_id + `/` + poid,
							rejected: `<?php echo base_url(); ?>dashboard/view_form_data/` + year_id + `/` + indi.id + `/4/` + user_id + `/` + poid,
							query_pen: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + indi.id + `/1/` + user_id + `/` + poid,
							query_res: `<?php echo base_url(); ?>dashboard/query_data/` + year_id + `/` + indi.id + `/2/` + user_id + `/` + poid
						};

					if (indi.saved == 0) {
						target = '';
						links.saved = 'javascript:void(0);';
						subContainer.find('span.badge-saved').each(function(index) {
							indi.saved = parseInt(indi.saved) + parseInt($(this).find('span').html());
						});
					}
					var HTML = `<a href="${links.saved}" target="${target}">
						<span class="badge badge-saved">
							Saved <span class="bg-white code-style">${indi.saved}</span>
						</span>
					</a> |`;

					target = '_blank';
					if (indi.submitted == 0) {
						target = '';
						links.submitted = 'javascript:void(0);';
						subContainer.find('.badge-submit').each(function(index) {
							indi.submitted = parseInt(indi.submitted) + parseInt($(this).find('span').html());
						});
					}
					HTML += `<a href="${links.submitted}" target="${target}">
						<span class="badge badge-submit">
							Submitted <span class="bg-white code-style">${indi.submitted}</span>
						</span>
					</a> |  `;

					target = '_blank';
					if (indi.approved == 0) {
						target = '';
						links.approved = 'javascript:void(0);';
						subContainer.find('.badge-approved').each(function(index) {
							indi.approved = parseInt(indi.approved) + parseInt($(this).find('span').html());
						});
					}
					HTML += `<a href="${links.approved}" target="${target}">
						<span class="badge badge-approved">
							Approved <span class="bg-white code-style">${indi.approved}</span>
						</span>
					</a> | `;
					target = '_blank';
					if (indi.rejected == 0) {
						target = '';
						links.rejected = 'javascript:void(0);';
						subContainer.find('.badge-rejected').each(function(index) {
							indi.rejected = parseInt(indi.rejected) + parseInt($(this).find('span').html());
						});
					}
					HTML += `<a href="${links.rejected}" target="${target}">
						<span class="badge badge-rejected">
							Rejected <span class="bg-white code-style">${indi.rejected}</span>
						</span>
					</a>`;
					
					$('body').find('[data-type="indicator"][data-id="' + indi.id + '"]').html(HTML);
				});
			}
		});
	}

	function download_data(form_id){
		// var form_id1 ="";
		// var form_id1 =<?php echo $this->uri->segment(4); ?>;
		$.ajax({
                url: '<?php echo base_url(); ?>dashboard/download_data',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    form_id: form_id
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
                    }else{
						var exceldata =response.json_data;
						// var excelgdata =response.g_json_data;
						// var filename="Export_data_"+response.form_id+".xlsx";
						var fields ={};
						response.form_fields.forEach(d=>fields[`field_${d.field_id}`]=d.label);
						var exceldata =response.json_data.map(d=> {
							const list ={};
							Object.keys(d).forEach(k=>list[fields[k] || k]=d[k]);
							return list;
						});
						var name="";
						var hname="";
						name= response.form_title.replace(':', "");
						hname=name.substring(0, 17);
						hname= hname.replace('#', "_");
						hname= hname.replace(' ', "");
						var filename=""+hname+".xlsx";
						const wb = XLSX.utils.book_new();
						const ws1 = XLSX.utils.json_to_sheet(exceldata);
						XLSX.utils.book_append_sheet(wb, ws1, 'Primary');
						var grouparray = response.group_ids;
						if (response.group_status == "Yes") {
							const groupcount=1;
							grouparray.forEach(function($groupId, $key) {
								groupcount+1;
								// const sheetname = 'Sheet_'+groupcount;
								// sheetname = XLSX.utils.json_to_sheet(excelgdata);
								// XLSX.utils.book_append_sheet(wb, sheetname, 'Sheet_'+groupcount);
								switch ($key) {
									case 0:
										const ws2 = XLSX.utils.json_to_sheet(response.g_json_data[$key]);
										XLSX.utils.book_append_sheet(wb, ws2, 'Group_1');
										break;
									case 1:
										const ws3 = XLSX.utils.json_to_sheet(response.g_json_data[$key]);
										XLSX.utils.book_append_sheet(wb, ws3, 'Group_2');
										break;
									case 2:
										const ws4 = XLSX.utils.json_to_sheet(response.g_json_data[$key]);
										XLSX.utils.book_append_sheet(wb, ws4, 'Group_3');
										break;
									case 3:
										const ws5 = XLSX.utils.json_to_sheet(response.g_json_data[$key]);
										XLSX.utils.book_append_sheet(wb, ws5, 'Group_4');
										break;
								
									default:
										break;
								}
							});
						}
						
						XLSX.writeFile(wb, filename);
					}
					
				}
			});
		}
</script>