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

	.table_th thead th { background-color: #050C43; padding: 8px 12px; }
	.table th, .text-wrap table th { color: #FFFFFF; font-weight: bold; }
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

<div class="app-content page-body" style="min-height:75vh;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<a href="javascript:window.close();" class="btn btn-sm btn-success pull-right">Back</a>
				<h3>View Variance Report</h3>
				
				<!-- Year Country Crop -->
				<div class="card hidden">
					<div class="card-body">
						<div class="row">
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Year</label>
									<select name="year" placeholder="Select Year" class="form-control">
										<option value="<?php echo $year; ?>" selected>
											<?php echo $year; ?>
										</option>
									</select>
								</div>
							</div>
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Country</label>
									<select name="country[]" placeholder="Select Country" class="form-control" multiple>
										<option value="<?php echo $country; ?>" selected>
											<?php echo $country; ?>
										</option>
									</select>

								</div>
							</div>
							<div class="col-xs-4 col-md-4 col-lg-4 col-sm-12">
								<div class="form-group">
									<label class="form-label">Select Crop</label>
									<select name="crop[]" placeholder="Select Crop" class="form-control" multiple>
										<option value="<?php echo $crop; ?>" selected>
											<?php echo $crop; ?>
										</option>
									</select>
								</div>
							</div>

							<div class="col-sm-12">
								<a class="btn btn-sm btn-info view_resulttracker_report" data-formid="<?php echo $form_id; ?>">
									<i class="fa fa-eye"></i> View Result Tracker
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="panel hidden resulttracker_reportdiv"></div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/jquery.richtext.js"></script>

<!-- Page Script -->
<script type="text/javascript">
	$(function() {
		$('body').find(`.view_resulttracker_report`).trigger('click');
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
		var country_id = $('[name="country[]"]').val();
		var crop_id = $('[name="crop[]"]').val();
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

		$.ajax({
			url: '<?php echo base_url(); ?>dashboard/view_resulttracker_report',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year: $('[name="year"]').val(),
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
				var HTML = `<h3 class="modal-title">`+response.get_form_details.title+`</h3>`;

				HTML += `<div class="card p-10">
					<div class="table-responsive">
						<table class="table table-bordered table_th">
							<thead>
								<tr>
									<th style="width:10%;">Submitted By</th>
									<th style="width:10%;">Country</th>
									<th style="width:10%;">Crop</th>
									<th style="width:45%;">Variance Report</th>									
									<th style="width:20%;" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>`;
								if(response.get_resulttracker_report.length > 0){
									response.get_resulttracker_report.forEach(function(data, index){
										var target = '_blank',
										links = {
											query_pen: `<?php echo base_url(); ?>dashboard/query_data_result_tracker/`+data.year_id+`/`+data.country_id+`/`+data.crop_id+`/`+data.id+`/1`,
											query_res: `<?php echo base_url(); ?>dashboard/query_data_result_tracker/`+data.year_id+`/`+data.country_id+`/`+data.crop_id+`/`+data.id+`/2`
										};
										
										HTML += `<tr>
											<td>`+data.username+`</td>
											<td>`+data.country_name+`</td>
											<td>`+data.crop_name+`</td>
											<td>`+data.report+`</td>											
											<td class="text-center">`;
												HTML += `<a href="javascript:void(0)" class="editReport" data-recordid="${data.data_id}" data-formid="${form_id}">
													<span class="badge badge-primary">
														Edit Report
													</span>
												</a>`;
												
												if((userId != data.user_id) && (data.query_status == null)) {
												HTML += `<a href="javascript:void(0)" class="btn btn-sm btn-warning send_back" data-recordid="${data.data_id}" data-formid="${form_id}" data-by="${data.username}">
													Send Back
												</a>`;
												}
												
												if(data.query_status == 1) {
												if(userId != data.user_id) HTML += ` | `;
												HTML += `<a href="javascript:void(0)" class="showQuery" data-recordid="${data.data_id}" data-formid="${form_id}">
													<span class="badge badge-warning badge-query-pen">
														View Query
													</span>
												</a>`;
												} else if(data.query_status == 2) {
												HTML += `<a href="javascript:void(0)" class="showQuery" data-recordid="${data.data_id}" data-formid="${form_id}">
													<span class="badge badge-warning badge-query-res">
														View Query
													</span>
												</a>`;
												}

												if((userId == data.user_id) && (data.query_status == null)) {
												HTML += `N/A`;
												}
											HTML += `</td>
										</tr>
										<tr><td colspan="5">
											<div class="data_list"></div>
											<div class="query_list mt-2"></div>
										</td></tr>`;
									});
								}else{
									HTML += `<tr><td colspan="5">No data found</td></tr>`;
								}
							HTML += `</tbody>
						</table>
					</div>
				</div>`;
					
				$('.resulttracker_reportdiv').removeClass('hidden');
				$('.resulttracker_reportdiv').html(HTML);
				$('html,body').animate({
					scrollTop: $('.resulttracker_reportdiv').offset().top - 300
				}, 500);
			}
		});
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

	$('body').on('click', '.editReport, .showQuery', function(event) {
		var elem = $(this);
		if(elem.hasClass('showQuery')) elem.closest('.table').find('.query_list').empty();
		if(elem.hasClass('editReport')) elem.closest('.table').find('.data_list').empty();
		
		if(!elem.hasClass('active')) {
			elem.addClass('active');
		} else {
			elem.removeClass('active');
			return false;
		}
		$('.showQuery').not(this).each(function(index) {
			if($(this).hasClass('active')) $(this).trigger('click');
		});
		$('.editReport').not(this).each(function(index) {
			if($(this).hasClass('active')) $(this).trigger('click');
		});

		var recorId = elem.data('recordid');
		if(elem.hasClass('showQuery')) elem.closest('.table').find('.query_list').html(`
			<h4 class="text-center">Please Wait... Getting Data.</h4>
		`);
		if(elem.hasClass('editReport')) elem.closest('.table').find('.data_list').html(`
			<h4 class="text-center">Please Wait... Getting Data.</h4>
		`);
		$.ajax({
			url: "<?php echo base_url(); ?>dashboard/get_result_tracker_query_list",
			type: "POST",
			dataType: "json",
			data : { data_id : recorId },
			error : function(){
				if(elem.hasClass('showQuery')) elem.closest('.table').find('.query_list').empty();
				if(elem.hasClass('editReport')) elem.closest('.table').find('.data_list').empty();
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
					if(elem.hasClass('showQuery')) elem.closest('.table').find('.query_list').empty();
					if(elem.hasClass('editReport')) elem.closest('.table').find('.data_list').empty();
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

				var HTML = ``;

				// Prepare edit report HTML
				if(elem.hasClass('editReport')) {
					HTML = `<div form-group">
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
						HTML += `</div>
					</div>`;
					elem.closest('.table').find('.data_list').html(HTML);
					$('#textarea_1').richText();
				}

				// <img alt="Avatar" class="avatar avatar-xl mx-2" src="<?php echo base_url(); ?>upload/user/default.png" style="background-color:none;">
				// Preapare queries HTML
				if(elem.hasClass('showQuery')) {
					HTML = `<div class="row bg-white">
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
				}
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