<style type="text/css">
	.form-control button { border: none !important; }
	.form-control span { margin: 5px; }
	.ms-drop.bottom { left: 0; }

	span.badge > span {
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

<div class="app-content page-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h3>Approval Dashboard</h3>
				
				<!-- Year Country Crop -->
				<div class="card">
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
								<li><a href="javascript:void(0)" class="text-black active">APPROVAL</a></li>
								<!-- <li><a href="<?php echo base_url() . 'dashboard/review'; ?>" class="text-black">REVIEW</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/user_uploadinfo'; ?>" class="text-black">USER UPLOAD INFO</a></li>
								<li><a href="<?php echo base_url() . 'dashboard/monitoring_evaluation'; ?>" class="text-black">M & E</a></li> -->
								<?php } ?>
								
								<?php if ($this->session->userdata('role') == 4) { ?>
								<li><a href="javascript:void(0)" class="text-black active">APPROVAL</a></li>
								<?php } else if ($this->session->userdata('role') == 5) { ?>
								<li><a href="javascript:void(0)" class="text-black active">APPROVAL</a></li>
								<!-- <li><a href="<?php echo base_url() . 'dashboard/review'; ?>" class="text-black">REVIEW</a></li> -->
								<?php } ?>

								<!-- <?php if($this->session->userdata('role') == 6 || $this->session->userdata('role') == 5 || $this->session->userdata('role') == 4){ ?>
								<li><a href="<?php echo base_url() . 'dashboard/result_tracker'; ?>" class="text-black">RESULTS TRACKER</a></li>
								<?php } ?> -->
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
			</div><!-- end app-content-->
		</div>
	</div>
</div>
</div>

<!-- Page Script -->
<script type="text/javascript">
	$(function() {
		$('[name="year"]').on('change', function (event) {
		        getProgram();
		}).multipleSelect({
			filter: true
		});
		
		$('[name="year"]').trigger('change');
	});

	$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
		var id = $(e.target).data('id');
		getProgramDetails(id);
	});

	// Handle collapse icon change
	$('body').on('click', '[data-toggle="collapse"]', function(event) {
		var elem = $(this);
		if(elem.hasClass('fa-chevron-right')) {
			elem.removeClass('fa-chevron-right');
			elem.addClass('fa-chevron-down');
		} else {
			elem.removeClass('fa-chevron-down');
			elem.addClass('fa-chevron-right');
		}
	});

	function getProgram() {
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
			url: '<?php echo base_url(); ?>helper/get_program',
			type: 'POST',
			dataType:'JSON',
			data: { 
				purpose: 'approval',
				year: $('[name="year"]').val(),
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
				
				var poLis = '', poDivs = '';
				response.pos.forEach(function(po, index) {
					var active = (index == 0) ? 'active' : '';
					poLis += '<li><a href="#po'+po.prog_id+'" class="text-black '+active+'" data-toggle="tab" data-id="'+po.prog_id+'">'+po.prog_name+'</a></li>'
					poDivs += '<div class="tab-pane '+active+'" id="po'+po.prog_id+'">\
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
				if(response.pos.length === 0) {
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

				if(response.pos.length > 0) {
					$('.tab-content.po').html(poDivs);
					getProgramDetails(response.pos[0].prog_id);
				}
			}
		});
	}

	function getProgramDetails(id) {
		$('#po'+id).html('<div class="row">\
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
			url: '<?php echo base_url(); ?>helper/get_program_details',
			type: 'POST',
			dataType:'JSON',
			data: {
				program: id,
				purpose: 'approval',
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

				// <div class="plus-minus-toggle collapsed" data-toggle="collapse" data-target="#indicator${$indicator['id']}"></div>
				var user_role = <?php echo $this->session->userdata('role'); ?>;
				var $po = response.po_list[0];
				var year_id = $('[name="year"]').val();
				var HTML = `<div class="row">
					<div class="col-md-12 col-lg-12">
						<div class="card card-block">
							
							<div class="card-body mb-5">
								<div class="table-responsive">
									<table class="table table-bordered table_th">`;
									$po['cluster_list'].forEach(function($output, $key) {
										HTML += `<thead>
											<tr>
												<th style="text-align:justify;padding:15px;line-height:2;background:#EAF3EF;">`+$output.cluster_name
													/*if(user_role == 4 || user_role == 5 || user_role == 6) {*/
														if($output['report']) {
															var pending = 0, responded = 0;
															if($output['query_status']) {
																if($output['query_status'] == 1) { pending = 1;responded = 0; }
																if($output['query_status'] == 2) { pending = 0;responded = 1; }
															}
															
															HTML += ` - <strong class="text-success">Report submitted</strong> |
															<a href="javascript:void(0);" class="reporting" data-formid="${$output['id']}">
																<span class="badge badge-danger badge-query-pen" data-formid="${$output['id']}">
																	Query Pending <span class="bg-white code-style">${pending}</span>
																</span>
															</a> |
															<a href="javascript:void(0);" class="reporting" data-formid="${$output['id']}">
																<span class="badge badge-danger badge-query-res">
																	Query Responded <span class="bg-white code-style">${responded}</span>
																</span>
															</a>`;
														} else {
															HTML += ` - <strong class="text-danger">Report not submitted</strong>`;
														}
														
														HTML += `<a class="text-primary reporting pull-right" data-formid="${$output['id']}" href="javascript:void(0);">
															<i class="fa fa-plus"></i>
														</a>`;
													/*}*/
												HTML += `</th>
											</tr>
										</thead>`;
										if($output['indicator_list'].length > 0) {
										HTML += `<tbody><tr>
											<td colspan="6">
												<div class="table-responsive">
													<table class="table table-bordered table_th m-0">
														<thead>
															<tr>
																<td></td>
																<td style="width:45%;"></td>
																<td></td>
															</tr>
														</thead>`;
														$output['indicator_list'].forEach(function($indicator, $key) {
														HTML += `<tbody>
															<tr class="bg-white" style="cursor: auto">`;
																if($indicator['subindicator_list'].length > 0) {
																	HTML += `<td>
																		<i class="fa fa-chevron-right collapsed" data-toggle="collapse" data-target="#indicator${$indicator['id']}"></i>
																	</td>`;
																} else {
																	HTML += `<td style="width: 3.1%;"></td>`;
																}
																HTML += `<td class="output_text">${$indicator['title']}</td>
																<td data-type="indicator" data-id="${$indicator['id']}"></td>
															</tr>
														</tbody>`;
														
														if($indicator['subindicator_list'].length > 0) {
														HTML += `<tbody class="collapse" id="indicator${$indicator['id']}">`;
															$indicator['subindicator_list'].forEach(function($subindicator, $key) {
															HTML += `<tr style="cursor: auto">
																<td></td>
																<td>${$subindicator['title']}</td>
																<td data-type="subindicator" data-id="${$subindicator['id']}"></td>
															</tr>`;
															});
														HTML += `</tbody>`;
														}
														});
													HTML += `</table>
												</div>
											</td>
										</tr></tbody>`
										};
									});
									HTML += `</table>
								</div>
							</div>
						</div>
					</div>
				</div>`;
				$('#po'+id).html(HTML);
				getPoDetailsCounters();
			}
		});
	}


	$('body').on('click', '.reporting', function(){
		var year_id = $('[name="year"]').val();
		var country_id = $('[name="country"]').val();
		var crop_id = $('[name="crop"]').val();

		var form_id = $(this).data('formid');
		var url = "<?php echo base_url(); ?>reporting/reporting/"+form_id+"/"+year_id+"/"+country_id+"/"+crop_id+"";
		window.open(url, '_blank');
	});
</script>