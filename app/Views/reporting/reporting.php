				<div class="app-content page-body">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="card bg-light" style="box-shadow: none">
									<div class="card-body">
										<div class="p-4  border border-bottom-0">
											<div class="modal d-block pos-static">
												<div class="modal-dialog modal-dialog-center" role="document">
													<div class="modal-content modal-content-demo one ">
														<div class="modal-body text-center">
															<h4 class="text-center" style="text-align: center"><strong>Select Type Of Reporting</strong></h4>
															<hr>
															<a href="<?php echo base_url(); ?>reporting/offline_data_export" type="button" class="btn btn-export btn-sm mr-2 mb-2"><strong> Offline Reporting</strong>
															</a>
															<a href="<?php echo base_url(); ?>reporting/online_data_submission" type="button" class="btn btn-primary btn-sm mr-2 mb-2"><strong>Online Reporting</strong></a>
														</div>
													</div>
												</div>
											</div>
										</div><!-- pd-y-50 -->										
									</div>
								</div>
								<!--/div-->
							</div>
						</div>
					</div>
				</div><!-- end app-content-->
			</div>

		
	
		<script>
			$('.accordian-body').on('show.bs.collapse', function () {
			    $(this).closest("table")
			        .find(".collapse.in")
			        .not(this)
			        //.collapse('toggle')
			})
		</script>
		
		<script>
			// Alert Redirect to Another Link
			$(document).on('click', '#submit_form', function(e) {
			    swal({
					title: "Successfully Submitted", 
					text: "You Redirect to Home click Cancel", 
					type: "success",
					confirmButtonText: "Ok",
					showCancelButton: true
			    })
		    	.then((result) => {
					if (result.value) {
					} else if (result.dismiss === 'cancel') {
						window.location = 'index.html';
						//swal("Data Submitted Successfully!", "You clicked the button!", "success");
					    // swal(
					    //   'Cancelled',
					    //   'You goto  Home :)',
					    //   'error'
					    // )
					}
				})
			});
		</script>