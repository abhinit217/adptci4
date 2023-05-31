<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/plugins/checkbox-tree-plugin/js/checktree.js"></script>
<style type="text/css">
	ul {
		list-style-type: none;
		margin: 40px;
		margin-top: 15px;
	}
	.accordion .form-control button { border: none !important; }
	.accordion .form-control span { margin: 5px; }
	.accordion > .card { overflow: unset !important; }
	.ms-drop.bottom { left: 0; }
	.accordion .card-header > h3 {
		line-height: 2;
		cursor: pointer;
		margin-bottom: 0;
		text-decoration: underline;
	}
</style>
<div class="app-content page-body">
	<div class="container-fluid">
		<!-- Row -->
		<div class="row" style="margin-bottom: 70px;">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<a href="<?php echo base_url() ?>user_management/reporting_user" style="color: black;" class="btn btn-sm btn-success pull-right">Reporting users</a>
								<h3 class="font-22px">Manage  Users</h3>
							</div>
							<div class="col-sm-12 col-md-12 mb-4">
								<label class="">Search User to Manage Assignments</label>
								<select  class="form-control" id="search_user">
									<option value="">Select User</option>
								</select>
								<p class="error red-800"></p>
							</div>
						</div>
					</div>
				</div>

				<!-- Accordian of Assignments -->
				<div class="accordion" id="accordionAssignment">
					<div class="card reportingSection d-none" data-action="reporting">
						<div class="card-header" id="headingReporting">
							<h3 data-toggle="collapse" data-target="#bodyReporting" aria-expanded="true" aria-controls="bodyReporting">
								Assignment For Reporting Data
							</h3>
						</div>
						<div class="card-body collapse show" id="bodyReporting" aria-labelledby="headingReporting" data-parent="#accordionAssignment">
							<div class="row" data-action="reporting">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Years <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select class="form-control" name="year">
											<?php foreach ($year_list as $key => $year) { ?>
												<option value="<?php echo $year['year_id']; ?>">
													<?php echo $year['year']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row mt-10">
								<div class="col-sm-12">
									<div class="po_data form-group" style="background-color: #f5f5f5"></div>
								</div>
							</div>

							<button class="btn btn-sm btn-success mapUser pull-right">Map User</button>
						</div>
					</div>

					<div class="card approvalSection d-none" data-action="approval">
						<div class="card-header" id="headingApproval">
							<h3 class="collapsed" data-toggle="collapse" data-target="#bodyApproval" aria-expanded="false" aria-controls="bodyApproval">
								Assignment For Approval of Data
							</h3>
						</div>
						<div class="card-body collapse" id="bodyApproval" aria-labelledby="headingApproval" data-parent="#accordionAssignment">
							<div class="row" data-action="approval">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Years <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select class="form-control" name="year">
											<?php foreach ($year_list as $key => $year) { ?>
												<option value="<?php echo $year['year_id']; ?>">
													<?php echo $year['year']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row mt-10">
								<div class="col-sm-12">
									<div class="po_data form-group" style="background-color: #f5f5f5"></div>
								</div>
							</div>

							<button class="btn btn-sm btn-success mapUser pull-right">Map User</button>
						</div>
					</div>

					<!-- <div class="card reviewSection d-none" data-action="review">
						<div class="card-header" id="headingReview">
							<h3 class="collapsed" data-toggle="collapse" data-target="#bodyReview" aria-expanded="false" aria-controls="bodyReview">
								Assignment For Review of Data
							</h3>
						</div>
						<div class="card-body collapse" id="bodyReview" aria-labelledby="headingReview" data-parent="#accordionAssignment">
							<div class="row" data-action="review">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Years <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select class="form-control" name="year">
											<?php foreach ($year_list as $key => $year) { ?>
												<option value="<?php echo $year['year_id']; ?>">
													<?php echo $year['year']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<button class="btn btn-sm btn-success mapUser pull-right">Map User</button>
						</div>
					</div>

					<div class="card resultTrackerSection d-none" data-action="resultTracker">
						<div class="card-header" id="headingResultTracker">
							<h3 class="collapsed" data-toggle="collapse" data-target="#bodyResultTracker" aria-expanded="false" aria-controls="bodyResultTracker">
								Assignment For Result Tracker
							</h3>
						</div>
						<div class="card-body collapse" id="bodyResultTracker" aria-labelledby="headingResultTracker" data-parent="#accordionAssignment">
							<div class="row" data-action="resultTracker">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Years <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select class="form-control" name="year">
											<?php foreach ($year_list as $key => $year) { ?>
												<option value="<?php echo $year['year_id']; ?>">
													<?php echo $year['year']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Country <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select multiple="multiple" class="form-control country" name="country">
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Crops <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select multiple="multiple" class="form-control crop" name="crop">
										</select>
									</div>
								</div>
							</div>

							<div class="row mt-10">
								<div class="col-sm-12">
									<div class="po_data form-group" style="background-color: #f5f5f5"></div>
								</div>
							</div>

							<button class="btn btn-sm btn-success mapUser pull-right">Map User</button>
						</div>
					</div>

					<div class="card planningSection d-none" data-action="planning">
						<div class="card-header" id="headingPlanning">
							<h3 class="collapsed" data-toggle="collapse" data-target="#bodyPlanning" aria-expanded="false" aria-controls="bodyPlanning">
								Assignment For Planning of Data
							</h3>
						</div>
						<div class="card-body collapse" id="bodyPlanning" aria-labelledby="headingPlanning" data-parent="#accordionAssignment">
							<div class="row" data-action="planning">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">
											Select Years <sup class="text-success"><strong>*</strong></sup>
										</label>
										<select class="form-control" name="year">
											<?php foreach ($year_list as $key => $year) { ?>
												<option value="<?php echo $year['year_id']; ?>">
													<?php echo $year['year']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row mt-10">
								<div class="col-sm-12">
									<div class="po_data form-group" style="background-color: #f5f5f5"></div>
								</div>
							</div>

							<button class="btn btn-sm btn-success mapUser pull-right">Map User</button>
						</div>
					</div> -->
				</div>
			</div>
		</div>
		<!-- /Row -->
	</div>
</div>
</div>

<script>
	$(function(){
		// User on change and Select2 initialized
		$("#search_user").select2({
			ajax: {
				url: "<?php echo base_url(); ?>user_management/search_user_info",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				}
			},
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
		}).on('change', function(event) {
			var elem = $(this);
			role = elem.val().split(' - ')[1];
			$('.accordion').find('.card').addClass('d-none');

			switch(role) {
				case '3':
					/*$('.accordion').find('.card.planningSection').removeClass('d-none');*/
					$('.accordion').find('.card.reportingSection').removeClass('d-none');
				break;

				case '4':
					/*$('.accordion').find('.card.planningSection').removeClass('d-none');*/
					$('.accordion').find('.card.reportingSection').removeClass('d-none');
					$('.accordion').find('.card.approvalSection').removeClass('d-none');
					/*$('.accordion').find('.card.resultTrackerSection').removeClass('d-none');*/
				break;

				case '5':
					$('.accordion').find('.card.reportingSection').removeClass('d-none');
					$('.accordion').find('.card.approvalSection').removeClass('d-none');
					/*$('.accordion').find('.card.planningSection').removeClass('d-none');
					$('.accordion').find('.card.reviewSection').removeClass('d-none');
					$('.accordion').find('.card.resultTrackerSection').removeClass('d-none');*/
				break;
				
				case '6':
					$('.accordion').find('.card.reportingSection').removeClass('d-none');
					$('.accordion').find('.card.approvalSection').removeClass('d-none');
					/*$('.accordion').find('.card.planningSection').removeClass('d-none');
					$('.accordion').find('.card.reviewSection').removeClass('d-none');*/
				break;
			}

			$('[name="year"]').trigger('change');
		});

		// Year on change and multiselect initialized
		$('[name="year"]').on('change', function (event) {
			var elem = $(this),
			parentClass = elem.closest('.row').data('action');
			var search_user = $('#search_user').val().split(' - ');
			
			switch(parentClass) {
				case 'reporting':
					getPoDetails(elem, search_user[0]);
				break;

				case 'approval':
					getPO(elem, search_user[0]);
				break;

				case 'planning':
					getPoForPlanning(elem, search_user[0]);
				break;
			}
			// getCountry(elem, search_user[0], parentClass);
		}).multipleSelect({
			filter: true
		});
	});

	$('body').on('change', 'ul :checkbox', function(event) {
		var checked = $(this).prop('checked')
		$(this).next().find(':checkbox').prop('checked',checked)
	});

	function formatRepo (repo) {
		if (repo.loading) return repo.text;

		var name = repo.first_name.length == 0 ? '' : repo.first_name+' ';
		name += repo.last_name.length == 0 ? '' : repo.last_name;

		return markup = $(`<div class='p-10'>
			${name}<br/>
			<small>${repo.role_name}</small>
		</div>`);
	}

	function formatRepoSelection (repo) {
		if(!repo.id) return repo.text;

		var name = repo.first_name.length == 0 ? '' : repo.first_name+' ';
		name += repo.last_name.length == 0 ? '' : repo.last_name;

		return name + ' - ' + repo.role_name;
	}

	function getPoDetails(elem, search_user) {
		elem.closest('.card').find('.po_data').html('<h4>Please Wait. Getting Data<span class="loading"></span></h4>');
		
		$.ajax({
			url : '<?php echo base_url(); ?>user_management/get_program_list_byyear',
			type: 'POST',
			dataType : 'json',
			data : {
				year_val : elem.val(),
				search_user : search_user,
				type : 'reporting'
			},
			error : function() {
				$.toast({
					stack: false,
					icon: 'error',
					position: 'bottom-right',
					showHideTransition: 'slide',
					heading: 'Network Error!',
					text: 'Please check your internet connection.'
				});
			},
			success : function(response){
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
				
				var user_programs = response.user_programs;
				var user_clusters = response.user_clusters;
				var user_indicators = response.user_indicators;
				var user_subindicators = response.user_subindicators;

				var HTML = `<ul class="tree-list">`;
				response.program_list.forEach(function(pos, index){
					HTML += `<li><a href="javascript:void(0);"><strong><input type="checkbox" name="program_val" value="`+pos.prog_id+`" `+(jQuery.inArray(pos.prog_id, user_programs) !== -1 ? 'checked' : '')+`> `+pos.prog_name+` </strong></a>
					<ul>`;
					pos.cluster_list.forEach(function(cluster, index){
						HTML += `<li><a class="active" href="javascript:void(0);"><strong><input type="checkbox" name="cluster_val" value="`+cluster.cluster_id+`" data-po="`+pos.prog_id+`" `+(jQuery.inArray(cluster.cluster_id, user_clusters) !== -1 ? 'checked' : '')+`> `+cluster.cluster_name+`</strong></a>
						<ul>`;
						cluster.indicator_list.forEach(function(indicator, index){
							HTML += `<li><a class="active" href="javascript:void(0);" ><strong><input type="checkbox" name="indicator_val" value="`+indicator.id+`" data-output="`+cluster.id+`" `+(jQuery.inArray(indicator.id, user_indicators) !== -1 ? 'checked' : '')+`> `+indicator.title+`</strong></a>
							<ul>`;
							indicator.subindicator_list.forEach(function(subindicator, index){
								HTML += `<li><a href="javascript:void(0);"><input type="checkbox" name="subindicator_val" value="`+subindicator.id+`" data-indicator="`+indicator.id+`" `+(jQuery.inArray(subindicator.id, user_subindicators) !== -1 ? 'checked' : '')+`> `+subindicator.title+`</a></li>`;
							});
							HTML += `</ul>
							</li>`;
						});
						HTML += `</ul>
						</li>`;
					});
					HTML += `</ul>
					</li>`;
				});
				HTML += `</ul>`;

				elem.closest('.card').find('.po_data').html(HTML);
				elem.closest('.card').find(".po_data ul.checktree").checktree();
			}
		});
	}

	function getPO(elem, search_user) {
		elem.closest('.card').find('.po_data').html('<h4>Please Wait. Getting Data<span class="loading"></span></h4>');

		// AJAX to get po
		$.ajax({
			url: '<?php echo base_url(); ?>user_management/get_program_list_byyear',
			type: 'POST',
			dataType:'JSON',
			data: {
				year_val: elem.val(),
				search_user : search_user,
				type : 'approval'
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
				//console.log(response);
				/*var HTML = `<ul class="tree-list">`;
				response.po_list.forEach(function(pos, index){
					HTML += `<li><a href="javascript:void(0);"><strong>
						<input type="checkbox" name="po_val" value="`+pos.prog_id+`"> `+pos.po_name+` </strong></a>
					</li>`;
				});
				HTML += `</ul>`;*/

				var user_programs = response.user_programs;
				var user_clusters = response.user_clusters;
				var user_indicators = response.user_indicators;
				var user_subindicators = response.user_subindicators;

				var HTML2 = `<ul class="tree-list">`;
					response.program_list.forEach(function(pos, index){
						HTML2 += `<li><a href="javascript:void(0);"><strong><input type="checkbox" name="program_val" value="`+pos.prog_id+`" `+(jQuery.inArray(pos.prog_id, user_programs) !== -1 ? 'checked' : '')+`> `+pos.prog_name+` </strong></a>
						<ul>`;
						pos.cluster_list.forEach(function(cluster, index){
							HTML2 += `<li><a class="active" href="javascript:void(0);"><strong><input type="checkbox" name="cluster_val" value="`+cluster.cluster_id+`" data-po="`+pos.prog_id+`" `+(jQuery.inArray(cluster.cluster_id, user_clusters) !== -1 ? 'checked' : '')+`> `+cluster.cluster_name+`</strong></a>
							<ul>`;
							cluster.indicator_list.forEach(function(indicator, index){
								HTML2 += `<li><a class="active" href="javascript:void(0);" ><strong><input type="checkbox" name="indicator_val" value="`+indicator.id+`" data-output="`+cluster.id+`" `+(jQuery.inArray(indicator.id, user_indicators) !== -1 ? 'checked' : '')+`> `+indicator.title+`</strong></a>
								<ul>`;
								indicator.subindicator_list.forEach(function(subindicator, index){
									HTML2 += `<li><a href="javascript:void(0);"><input type="checkbox" name="subindicator_val" value="`+subindicator.id+`" data-indicator="`+indicator.id+`" `+(jQuery.inArray(subindicator.id, user_subindicators) !== -1 ? 'checked' : '')+`> `+subindicator.title+`</a></li>`;
								});
								HTML2 += `</ul>
								</li>`;
							});
							HTML2 += `</ul>
							</li>`;
						});
						HTML2 += `</ul>
						</li>`;
					});
				HTML2 += `</ul>`;
				elem.closest('.card').find('.po_data').html(HTML2);
				elem.closest('.card').find(".po_data ul.checktree").checktree();
			}
		});
	}

	function getPoForPlanning(elem, search_user) {
		elem.closest('.card').find('.po_data').html('<h4>Please Wait. Getting Data<span class="loading"></span></h4>');
		var year_val = elem.closest('.card').find('[name="year"]').val(),
		crop_val = elem.closest('.card').find('[name="crop"]').val(),
		country_val = elem.closest('.card').find('[name="country"]').val();

		// AJAX to get po
		$.ajax({
			url: '<?php echo base_url(); ?>planning_helper/get_po',
			type: 'POST',
			dataType:'JSON',
			data: {
				year: year_val,
				crop: crop_val,
				country: country_val,
				search_user : search_user,
				type : 'planning'
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
				//console.log(response);
				var HTML = `<ul class="tree-list">`;
				response.pos.forEach(function(pos, index){
					let checked = ``;
					if(pos.assigned != 0) checked = `checked`;
					HTML += `<li><lable for="`+pos.prog_id+`"><a href="javascript:void(0);"><strong>
						<input type="checkbox" name="po_val" value="`+pos.prog_id+`" ${checked}> `+pos.po_name+` </strong></a>
					</label></li>`;
				});
				HTML += `</ul>`;
				elem.closest('.card').find('.po_data').html(HTML);
				elem.closest('.card').find(".po_data ul.checktree").checktree();
			}
		});
	}

	$('body').on('click', '.mapUser', function(){
		$elem = $(this);

		var search_user = $('#search_user').val().split(' - '),
		year_val = $elem.closest('.card').find('[name="year"]').val(),
		crop_val = $elem.closest('.card').find('[name="crop"]').val(),
		country_val = $elem.closest('.card').find('[name="country"]').val();

		var program_val = [];
		$elem.closest('.card').find("input:checkbox[name='program_val']:checked").each(function(){
			program_val.push($(this).val());
		});

		var cluster_val = [];
		$elem.closest('.card').find("input:checkbox[name='cluster_val']:checked").each(function(){
			cluster_val.push($(this).val());

			// Check PO and remove
			var index = program_val.indexOf($(this).data('po'));
			if(index != '-1') program_val.splice(index, 1);
		});

		var indicator_val = [];
		$elem.closest('.card').find("input:checkbox[name='indicator_val']:checked").each(function(){
			indicator_val.push($(this).val());

			// Check Output and remove
			var index = cluster_val.indexOf($(this).data('output'));
			if(index != '-1') cluster_val.splice(index, 1);
		});

		var subindicator_val = [];
		$elem.closest('.card').find("input:checkbox[name='subindicator_val']:checked").each(function(){
			subindicator_val.push($(this).val());

			// Check Indicator and remove
			var index = indicator_val.indexOf($(this).data('indicator'));
			if(index != '-1') indicator_val.splice(index, 1);
		});

		$elem.prop('disabled', true);
		$elem.html('Please wait...');

		$.ajax({
			url : '<?php echo base_url(); ?>user_management/map_user',
			type: 'POST',
			dataType : 'json',
			data: {
				action: $elem.closest('.card').data('action'),
				search_user : search_user[0],
				year_val : year_val,
				country_val : country_val,
				crop_val : crop_val,
				program_val : program_val,
				cluster_val : cluster_val,
				indicator_val : indicator_val,
				subindicator_val : subindicator_val
			},
			error : function(){
				$elem.prop('disabled', false);
				$elem.html('Map User');
				
				$.toast({
					stack: false,
					icon: 'error',
					position: 'bottom-right',
					showHideTransition: 'slide',
					heading: 'Network Error!',
					text: 'Please check your internet connection.'
				});
			},
			success : function(response){
				if(response.status == 0) {
					$.toast({
						stack: false,
						icon: 'error',
						position: 'bottom-right',
						showHideTransition: 'slide',
						heading: 'Error!',
						text: response.msg
					});
					$elem.prop('disabled', false);
					$elem.html('Map User');
					return false;
				}

				$.toast({
					stack: false,
					icon: 'success',
					position: 'bottom-right',
					showHideTransition: 'slide',
					heading: 'Success!',
					text: response.msg,
					afterHidden: function () {
						location.reload(true);
					}
				});
			}
		});
	});
</script>