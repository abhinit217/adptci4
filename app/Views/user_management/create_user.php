<div class="app-content page-body">
		<div class="container-fluid">

			<!-- Row -->
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo base_url(); ?>reporting/user_management/" class="btn btn-sm btn-success pull-right">User list</span></a>
					<h3 class="font-22px">Create User</h3>
					<div class="card">
						<div class="card-body">
							<div class="row">

								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">First Name <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="first_name">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Last Name <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="last_name">
										<p class="error red-800"></p>
									</div>
								</div>
								<?php 
									$county_id = $lkp_user_list['country_id'];
										switch ($county_id) {
											case '1':
												# code...
												$county_name="County";
												break;

											case '2':
												# code...
												$county_name="District";
												break;

											case '3':
												# code...
												$county_name="Zone";
												break;
											
											default:
												# code...
												$county_name="County / Zone / District";
												break;
										}
								?>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Select Role <sup class="text-danger"><strong>*</strong></sup></label>
										<select class="form-control role" name="role">
											<option value="">Select Role</option>
											<!-- <?php foreach ($role_list as $key => $role) { ?>
												<option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
											<?php } ?> -->
											<option value="6">Country Admin</option>
                                            <option value="5"><?php echo $county_name;?> Admin</option>
										</select>
										<p class="error red-800"></p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Email Address <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="emailid">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">User Name <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="user_name">
										<p class="error red-800"></p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Password <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="Password" name="password">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Confirm Password <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="Password" name="cpassword">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group form-upload country_div" id="country_div">
										<label for=""> Select Country <sup class="text-danger"><strong>*</strong></sup></label>
										<select class="form-control country" name="country" >
											<option value="">Select Country</option>
											<?php foreach ($lkp_country_list as $key => $option) { 
													if($lkp_user_list['role_id']==6 || $lkp_user_list['role_id']==5){
														$selected="selected";
														if($lkp_user_list['country_id'] == $option['country_id']){
															?>
															<option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
															<?php
														}
													}else{
														$selected="";
														?>
													<option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
													<?php
													}
												} ?>
										</select>
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group form-upload county_div" id="county_div">
										<label for=""> Select <?php echo $county_name;?> <sup class="text-danger"><strong>*</strong></sup></label>
										<select class="form-control county" name="county">
											<option selected value="">Select <?php echo $county_name;?></option>
										</select>
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-4">
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Mobile No <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="mobile_number">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Organization <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="organization">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Role in the organization <sup class="text-danger"><strong>*</strong></sup></label>
										<input class="form-control" placeholder="" type="text" name="organization_role">
										<p class="error red-800"></p>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Reason for dashboard request <sup class="text-danger"><strong>*</strong></sup></label>
										<textarea class="form-control" placeholder="" type="text" name="reason" id="reason"></textarea>
										<p class="error red-800"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 mb-9">
					<button class="btn btn-success pull-right add_user" type="button">Add User</button>
				</div>
			</div>

			<!-- <div class="row">
				<div class="col-sm-12 pt-3 pl-3">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12" style="background-color: #f5f5f5">
									<div class="span06 p-3">
										<ul class="tree-list">
											<li><a href="#"><strong><input type="checkbox"> Objective 1</strong></a>
												<ul>
													<li><a class="active" href="#"><strong><input type="checkbox"> Output 1</strong></a>
														<ul>
															<li><a class="active" href="#" ><strong><input type="checkbox"> Indicator 1</strong></a></li>
															<li><a class="active" href="#" ><strong><input type="checkbox"> Indicator 2</strong></a></li>
															<li><a class="active" href="#" ><strong><input type="checkbox"> Indicator 3</strong></a></li>
															<li><a class="active" href="#" ><strong><input type="checkbox"> Indicator 4</strong></a>
																<ul>
																	<li><a href="#"><input type="checkbox"> Indicators 1</a>
																	</li>
																	<li><a href="#"><input type="checkbox"> Indicators 2</a></li>
																	<li><a href="#"><input type="checkbox"> Indicators 3</a></li>
																</ul>			
															</li>
														</ul>			
													</li>
													<li><a href="#"><strong><input type="checkbox"> Output 2</strong></a>
														<ul>
															<li><a href="#"><input type="checkbox"> Indicator 1</a></li>
															<li><a href="#"><input type="checkbox"> Indicator 2</a></li>
															<li><a href="#"><input type="checkbox"> Indicator 3</a></li>
															<li><a href="#"><input type="checkbox"> Indicator 4</a></li>
															<li><a href="#"><input type="checkbox"> Indicator 5</a></li>
														</ul>
													</li>	
												</ul>
											</li>
											<li><a href="#"><strong><input type="checkbox"> Objective 2</strong></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	<!-- /Row -->
</div>

<script type="text/javascript">
	var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

	$(function() {		
		$('[name="country"]').trigger('change');		
    });	

	$('body').on('change', '.role', function() {
		role= this.value;
		var logged_user_role=<?php echo $lkp_user_list['role_id'];?>;
		if(role==6){
			$('.county_div').hide();
			if(logged_user_role==6){
				$('.country_div').hide();
			}
		}else{
			$('.county_div').show();
			if(logged_user_role==6){
				$('.country_div').show();
			}
		}
	});

	$('.add_user').on('click', function(){
		$('.error').html('');

		var error = 0;

		var first_name = $('input[name="first_name"]').val();
		if(first_name.trim().length == 0){
     		$('input[name="first_name"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	var last_name = $('input[name="last_name"]').val();
		if(last_name.trim().length == 0){
     		$('input[name="last_name"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	var role = $('select[name="role"]').val();
		if(role == ''){
     		$('select[name="role"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	var emailid = $('input[name="emailid"]').val();
		if(emailid.trim().length == 0){
     		$('input[name="emailid"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}else{
	 		if(!isValidEmailAddress(emailid)) { 
	 			$('input[name="emailid"]').closest('.form-group').find('.error').html('<p class="red-800">In valid email id</p>');
	 			error++;
	 		}
	 	}

     	var user_name = $('input[name="user_name"]').val();
		if(user_name.trim().length == 0){
     		$('input[name="user_name"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	var password = $('input[name="password"]').val();
		if(password.trim().length == 0){
     		$('input[name="password"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	var cpassword = $('input[name="cpassword"]').val();
		if(cpassword.trim().length == 0){
     		$('input[name="cpassword"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	if(cpassword != password){
     		$('input[name="cpassword"]').closest('.form-group').find('.error').html('<p class="red-800">Both password and confrrm password should be same.</p>');
     		error++;
     	}
		var country = $('select[name="country"]').val();
		if(country.trim().length == 0){
     		$('select[name="country"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}
		if(  $("#county_div").is(":visible") == true ){
			var county = $('select[name="county"]').val();
			if(county.trim().length == 0){
				$('select[name="county"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
				error++;
			}
		}
		var organization = $('input[name="organization"]').val();
		if(organization.trim().length == 0){
     		$('input[name="organization"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}
		var organization_role = $('input[name="organization_role"]').val();
		if(organization_role.trim().length == 0){
     		$('input[name="organization_role"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}
		var mobile_number = $('input[name="mobile_number"]').val();
		if(mobile_number.trim().length == 0){
     		$('input[name="mobile_number"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}else{
			if(!/^[0-9]+$/.test(mobile_number)){
				$('input[name="mobile_number"]').closest('.form-group').find('.error').html('<p class="red-800">Please Enter only Numbers</p>');
				error++;
			}
		}
		var reason = $('#reason').val();
		if(reason.trim().length == 0){
     		$('textarea[name="reason"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
     		error++;
     	}

     	if(error == 0){
     		$('button[type="button"]').prop('disabled', true);
     		$('button[type="button"]').html('Please wait...');

            $.ajax({
                url: '<?php echo base_url(); ?>user_management/insert_user',
                type: 'POST',
                dataType : 'json',
                data: {
                    first_name : first_name,
                    last_name : last_name,
                    user_type : role,
                    country : country,
                    county : county,
                    organization : organization,
                    organization_role : organization_role,
                    mobile_number : mobile_number,
                    reason : reason,
                    emailid : emailid,
                    user_name : user_name,
                    password : password,
                    cpassword : cpassword,
                    csrf_test_name: csrfHash
                },                
                error: function() {
                    $('button[type="button"]').prop('disabled', false);
                    $('button[type="button"]').html('Register Now');
                    $.toast({
                        heading: 'Network Error!',
                        text: 'Could not establish connection to server. Please refresh the page and try again.',
                        icon: 'error'
                    });
                },
                complete: function(data) {
	                var csrfData = JSON.parse(data.responseText);
	                csrfName = csrfData.csrfName;
	                csrfHash = csrfData.csrfHash;
	                if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
	                    $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
	                }
	            },
                success: function(response) {
                    if(response.status == 1) {
                        $.toast({
                            heading: 'Success!',
                            text: response.msg,
                            icon: 'success',
                            afterHidden: function () {
                                location.reload(true);
                            }
                        });
                    } else if(response.status == 0) {
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error'
                        });
                        $('button[type="button"]').prop('disabled', false);
                        $('button[type="button"]').html('Register Now');
                    }
                }
            });
        }else{
            $('button[type="button"]').prop('disabled', false);
            $('button[type="button"]').html('Register Now');
        }
	});

	function isValidEmailAddress(emailAddress) {
		var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return pattern.test(emailAddress);
	}

	$('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        role_id= 0;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_countys",
            type: "POST",
            dataType: "json",
            data: {
                country_id: country_id,
                role_id: role_id,
                csrf_test_name: csrfHash
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            complete: function(data) {
                var csrfData = JSON.parse(data.responseText);
                csrfName = csrfData.csrfName;
                csrfHash = csrfData.csrfHash;
                if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                    $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                }
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_county_list.length > 0) {
                        var CHILD_HTML = '';
                        for (var field of response.result.lkp_county_list) {
                            CHILD_HTML += '<option value = "' + field.county_id + '">' + field.county_name + '</option>';
                        };
                        $('.county').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
</script>