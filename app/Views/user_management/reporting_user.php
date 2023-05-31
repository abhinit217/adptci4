<style type="text/css">
	.vertical-layout{ margin-top: 10px; }
	.switch {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
	}

	.switch input { 
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>

	<div class="app-content page-body">
		<div class="container-fluid">
			<!-- Row -->
			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo base_url(); ?>user_management/manage_user" class="btn btn-sm btn-success pull-right">Back</a>
					<h3 class="font-22px">Users list</h3>
				</div>
				<div class="col-sm-12 pt-3 pl-3">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="table-responsive">
										<table class="table table-bordered table_th text-center" style="border-collapse:collapse;">
											<thead>
												<tr>
													<th>#</th>
													<th>First Name</th>
													<th>Last Name</th>
													<th>Email id</th>
													<th>Role</th>
													<th>Mapping details</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($user_list as $key => $user) { ?>
													<tr>
														<td><?php echo $key+1; ?></td>
														<td><?php echo $user['first_name'] ?></td>
														<td><?php echo $user['last_name'] ?></td>
														<td><?php echo $user['email_id'] ?></td>
														<td><?php echo $user['role_name'] ?></td>
														<td>
															<table class="table table-bordered table_th text-center" style="border-collapse:collapse;">
																<thead>
																	<tr>
																		<th>#</th>
																		<th>Country</th>
																		<th>Crop</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach ($user['user_countrycrop_mapdetails'] as $ukey => $user_info) { ?>
																		<tr>
																			<td><?php echo $ukey+1; ?></td>
																			<td><?php echo $user_info['country_name'] ?></td>
																			<td><?php echo $user_info['crop_name'] ?></td>
																		</tr>
																	<?php } ?>
																</tbody>
															</table>
														</td>
														<td>
															<?php if($user['status'] == 1){ ?>
																<label class="switch"><input type="checkbox" class="updatepermission"   data-userid="<?php echo $user['user_id']; ?>" value="1" checked ><span class="slider round"></span></label>
															<?php }else{ ?>
																<label class="switch"><input type="checkbox" class="updatepermission" data-userid="<?php echo $user['user_id']; ?>" value="0"><span class="slider round"></span></label>
															<?php } ?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->
</div>

<!-- Page Script -->
<script type="text/javascript">
	$('body').on('click', '.updatepermission', function(){
		$elem = $(this);
		$elem.prop('disabled', true);
		
		var userid = $elem.data('userid');
		var assigingstatus = $elem.val();

		$.ajax({
			url: '<?php echo base_url("user_management/update_permissions"); ?>',
			type: 'POST',
			dataType : 'json',
			data: {
				assigingstatus : assigingstatus,
				userid : userid
			},
			error: function() {
				$elem.prop('disabled', false);
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success: function(response){
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
                            location.reload(true);
                        }
                    });
                }
			}
		});
	});
</script>