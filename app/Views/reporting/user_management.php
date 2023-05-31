<style type="text/css">
    label {
        font-weight: bold;
    }

    th {
        color: #FFFFFF;
    }
    .app-content.page-body {
        margin-top: 6rem !important;
    }
    #datadiv{
        width: 100%;
    }
    .modal-dialog{
        width:80%;
    }
</style>

  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="app-content page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 pl-0 pr-0 mb-5">
                <div class="p-3 pl-0 bg-light border border-bottom-0">
                   
                    <div class="wrapper mt-3">
                        <div class="container-fluid">                            
                            <div class="card border-0 shadow">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <h3 class="title mb-0">User Management</h3>
                                        </div>
                                        <!-- <div class="">
                                            <a href="index.html" class="btn btn-light1 btn-sm"><img src="./assets/images/icon-left-arrow.svg"> Back</a>
                                        </div> -->
                                        <div class="">
                                        <a href="<?php echo base_url(); ?>user_management/create_user/" class="btn btn-sm btn-success" target="_blank">Register</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <form id="submit_data">
                                        <div class="form">
                                            <div class="row">
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
                                            <div id="datadiv">
                                                <table class="table datatable">
                                                    <thead>
                                                        <th>Slno</th>
                                                        <th>User Name</th>
                                                        <th>User Type</th>
                                                        <th>Approve Status</th>
                                                        <th>Country</th>
                                                        <th><?php echo $county_name;?></th>
                                                        <th>view details</th>
                                                        <th>Actions</th>
                                                    </thead>
                                                    <tbody>
                                                            <?php 
                                                            $loopno=0;
                                                            if(count($tbl_users_list) >0){
                                                                foreach ($tbl_users_list as $key => $user) {
                                                                    $role_name="N/A"; 
                                                                    $username=$user['first_name'].' '.$user['last_name']; 
                                                                    foreach ($tbl_role_list as $rkey => $role) { 
                                                                        if($user['role_id']==$role['role_id']){
                                                                            $role_name=$role['role_description'];
                                                                        }
                                                                    }
                                                                    $approve_status="Not Approved";
                                                                    if($user['approve_status']==1){
                                                                        $approve_status="Approved";
                                                                    }
                                                                    $loopno++;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $loopno; ?></td>
                                                                        <td><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></td>
                                                                        <td><?php echo $role_name; ?></td>
                                                                        <td><?php echo $approve_status; ?></td>
                                                                        <td><?php echo $user['country_name']; ?></td>
                                                                        <?php if($user['role_id']==5){ ?>
                                                                        <td><?php echo $user['county_name']; ?></td>
                                                                        <?php }else{?><td>N/A</td>
                                                                            <?php }?>
                                                                        <!-- <td><button data-id='<?php echo $user['user_id']; ?>' id="myBtn" class='btn btn-info btn-sm '>Details</button></td> -->
                                                                        <td><button type="button" class="btn btn-primary"  data-target="#exampleModal" data-recordid="<?php echo $user['user_id']; ?>" id="userdetails">user details</button></td>
                                                                        <td>
                                                                                <?php 
                                                                                    if($user['approve_status']!=1){
                                                                                    ?><div class=" col-md-12 ajax_response"></div>
                                                                                    <button type="button" class="btn btn-sm btn-success approve_data"  data-recordid="<?php echo $user['user_id']; ?>" data-username="<?php echo $username; ?>" style="margin-right:10px;">Approve</button> | 
                                                                                    <?php }?>
                                                                                    <a class="btn btn-sm btn-info"  href="<?php echo base_url(); ?>reporting/user_mapping/<?php echo $user['user_id']; ?>/<?php echo $user['role_id']; ?>" >Assign</a>
                                                                            
                                                                        </td></tr>
                                                                    <?php
                                                                } 
                                                            }else{
                                                                ?>
                                                                <td colspan="7" style="text-align:center;color:red">No records to display</td>
                                                                <?php 
                                                            }
                                                            ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end app-content-->
</div>

<script type="text/javascript">
    
    $('body').on('click', '#userdetails', function(){
        $elem = $(this);
        var recordid = $elem.data('recordid');
        $.ajax({
            url: '<?php echo base_url(); ?>reporting/get_user_data_popup_modal',
            type: 'POST',
            dataType: 'json',
            data: { 
                user_id: recordid
             },
            error: function() {
                $.toast({
                    heading: 'Warning!',
                    text: 'Please check your internet connection and try again.',
                    icon: 'error',
                    afterHidden: function() {
                        $elem.prop('disabled', false);
                    }
                });
            },
            success: function (response) {
                if (response.status == 1) {
                    if (response.result.user_data_list.length > 0) {
                        var CHILD_HTML = '';
                        CHILD_HTML += '<table>';
                        for (var field of response.result.user_data_list) {
                            CHILD_HTML += '<tr><td width="20%"><b>First Name : </b></td><td width="30%">' + field.first_name + '</td><td width="20%"><b>Last Name : </b></td><td width="30%">' + field.last_name + '</td></tr>';
                            CHILD_HTML += '<tr><td><b>User Name :</b></td><td>' + field.username + '</td><td><b>Email : </b></td><td>' + field.email_id + '</td></tr>';
                            CHILD_HTML += '<tr><td><b>Country Name :</b></td><td>' + field.country_name + '</td><td><b>County</br>Name : </b></td><td>' + field.county_name + '</td></tr>';
                            CHILD_HTML += '<tr><td><b>Mobile No :</b></td><td>' + field.mobile_no + '</td><td><b>Organization : </b></td><td>' + field.organization + '</td></tr>';
                            CHILD_HTML += '<tr><td><b>Role in the organization :</b></td><td>' + field.organization_role + '</td><td><b>Reason for dashboard request : </b></td><td>' + field.reason_for_dashboard + '</td></tr>';
                        };
                        CHILD_HTML += '</table>';
                        $('.modal-body').html(CHILD_HTML);
                        $('#custModal').modal('show');
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
                // $('.modal-body').html(response);
            }
        });
        $('#exampleModal').modal('toggle');
        
    });
    $('body').on('click', '.approve_data', function(){
		$elem = $(this);

		var recordid = $elem.data('recordid');
		var username = $elem.data('username');

		swal({
			title: "Are you sure?",
			text: "you want to approve this User!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, approve it!",
			cancelButtonText: "No, cancel please!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
			   	$.ajax({
					url: "<?php echo base_url(); ?>user_management/approve_user",
					type: "POST",
					dataType: "json",
					data : {
						user_id : recordid
					},
					error : function(){						
						$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
					},
					success : function(response){
						if(response.status == 0){
							$elem.closest('.row').find('.ajax_response').html('<p align="center" class="red-800" style="font-weight:bold;">'+response.msg+'</p>');

							swal({
	                            title: response.msg,
	                            icon: "warning",
	                            dangerMode : true,
	                            closeOnConfirm: true
	                        });

						}else{
							$elem.closest('.row').find('.ajax_response').html('<p align="center" style="color:green; font-weight:bold;">'+response.msg+'</p>');

							$elem.closest('.row').find('.delete_groupdata').html('');

							$elem.closest('.actionbutton_divs').html('');						

							swal({
	                            title: response.msg,
	                            icon: "success",
	                            closeOnConfirm: true
	                        });
                            setTimeout(function() {
                                location.reload(true);
                            }, 500);
						}
					}
				});
			} else {
				swal("Cancelled", "User is not yet approved", "error");
			}
		});
	});

    

</script>