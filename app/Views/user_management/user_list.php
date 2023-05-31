	<div class="app-content page-body">
		<div class="container-fluid">
			<!-- Row -->
			<div class="row">
				<div class="col-sm-12">
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
													<th>Username</th>
													<th>Email id</th>
													<th>Role</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($user_list as $key => $user) { ?>
													<tr>
														<td><?php echo $key+1; ?></td>
														<td><?php echo $user['first_name'] ?></td>
														<td><?php echo $user['last_name'] ?></td>
														<td><?php echo $user['username'] ?></td>
														<td><?php echo $user['email_id'] ?></td>
														<td><?php echo $user['role_name'] ?></td>
														<td>
															<a href="<?php echo base_url(); ?>user_management/user_mapping_details/<?php echo $user['user_id']; ?>" class="btn btn-sm btn-success">
																Mapping details
															</a>
															<!-- <a href="#" class="btn btn-sm btn-success">
																Mapping details
															</a> -->
															<?php if($this->session->userdata('role') == 1) { ?>
															<a href="javascript:void(0)" class="btn btn-sm btn-primary resetPass" title="Password will be reset to Avisa@123" data-id="<?php echo $user['user_id']; ?>">
																Reset Password
															</a><br/><br/>
															<a href="javascript:void(0)" class="btn btn-sm btn-warning changeRole" data-id="<?php echo $user['user_id']; ?>" data-role="3">Level 1</a>
															<a href="javascript:void(0)" class="btn btn-sm btn-warning changeRole" data-id="<?php echo $user['user_id']; ?>" data-role="4">Level 2</a>
															<a href="javascript:void(0)" class="btn btn-sm btn-warning changeRole" data-id="<?php echo $user['user_id']; ?>" data-role="5">Level 3</a>
															<a href="javascript:void(0)" class="btn btn-sm btn-warning changeRole" data-id="<?php echo $user['user_id']; ?>" data-role="6">Level 4</a>
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
	$('body').on('click', '.resetPass', function(event) {
		var elem = $(this);
		elem.prop('disabled', true);
		$.ajax({
			url : '<?php echo base_url(); ?>user_management/reset_pass',
			type: 'POST',
			dataType : 'json',
			data : {
				user_id : elem.data('id')
			},
			error : function() {
				elem.prop('disabled', false);
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success : function(response) {
				elem.prop('disabled', false);

				var icon = (response.status == 0) ? 'error' : 'success',
				heading = (response.status == 0) ? 'Error!' : 'Success!';
				$.toast({
					heading: heading,
					text: response.msg,
					icon: icon
				});
			}
		});
	});

	$('body').on('click', '.changeRole', function(event) {
		var elem = $(this);
		elem.prop('disabled', true);
		$.ajax({
			url : '<?php echo base_url(); ?>user_management/change_role',
			type: 'POST',
			dataType : 'json',
			data : {
				role : elem.data('role'),
				user_id : elem.data('id')
			},
			error : function() {
				elem.prop('disabled', false);
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success : function(response) {
				elem.prop('disabled', false);

				var icon = (response.status == 0) ? 'error' : 'success',
				heading = (response.status == 0) ? 'Error!' : 'Success!';
				$.toast({
					heading: heading,
					text: response.msg,
					icon: icon
				});
			}
		});
	});
</script>