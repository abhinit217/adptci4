	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
	<div class="app-content page-body">
		<div class="container-fluid">
			<!-- Row -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<h3 class="font-22px">Manage  Users</h3>
								</div>
								<div class="col-sm-12  col-md-12 mb-4">
									<label class="">Search Users</label>
									<select  class="form-control" id="search_user">
									<!-- <select name="user" class="form-control" id="search_user"> -->
										<option value="">Select User</option>
									</select>
									<p class="error red-800"></p>
								</div>
								<!-- <div class="col-sm-3">
									<div class="form-group">
										<label class="form-label">Select User Level <sup class="text-success"><strong>*</strong></sup></label>
										<select class="form-control">
											<option value="0">Select User Level</option>
											<option value="1" selected>Level 1</option>
											<option value="2">Level 2</option>
											<option value="3">Level 3</option>
											<option value="4">Level 4</option>
										</select>
									</div>
								</div> -->
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Select Country <sup class="text-success"><strong>*</strong></sup></label>
										<select multiple="multiple" class="filter-multi">
											<?php foreach ($country_list as $key => $country) { ?>
												<option value="<?php echo $country['country_id']; ?>" selected><?php echo $country['country_name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Select Crops <sup class="text-success"><strong>*</strong></sup></label>
										<select multiple="multiple" class="filter-multi">
											<?php foreach ($crop_list as $key => $crop) { ?>
												<option value="<?php echo $crop['crop_id']; ?>" selected><?php echo $crop['crop_name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-label">Select Years <sup class="text-success"><strong>*</strong></sup></label>
										<select class="form-control year" name="year">
											<?php foreach ($year_list as $key => $year) { ?>
												<option value="<?php echo $year['year_id']; ?>"><?php echo $year['year']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 po_data" style="background-color: #f5f5f5">
									<div class="span06 p-3">
										<ul class="tree-list">
											<?php foreach ($po_list as $key => $pos) { ?>
												<li><a href="#"><strong><input type="checkbox" name="po_val"> <?php echo $pos['po_name'] ?></strong></a>
													<ul>
														<?php foreach ($pos['output_list'] as $key => $output) { ?>
															<li><a class="active" href="#"><strong><input type="checkbox" name="output_val"> <?php echo $output['title']; ?></strong></a>
																<ul>
																	<?php foreach ($output['indicator_list'] as $key => $indicator) { ?>
																		<li><a class="active" href="#" ><strong><input type="checkbox" name="indicator_val"> <?php echo $indicator['title']; ?></strong></a>
																			<ul>
																				<?php foreach ($indicator['subindicator_list'] as $key => $subindicator) { ?>
																					<li><a href="#"><input type="checkbox" name="subindicator_val"> <?php echo $subindicator['title']; ?></a></li>
																				<?php } ?>
																			</ul>
																		</li>
																	<?php } ?>
																</ul>			
															</li>
														<?php } ?>
													</ul>
												</li>
											<?php } ?>
										</ul>
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

<script>
	// In your Javascript (external .js resource or <script> tag)
	$(document).ready(function() {
		$("#search_user").select2({
			ajax: {
				url: "<?php echo base_url(); ?>user_management/get_searchuser_info",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
              			searchTerm: params.term // search term
              		};
              	},
              	processResults: function (response) {
              		return {
              			results: response
              		};
              	},
              	cache: true
            }
        });
	});

	$(function(){
		$('ul :checkbox').change(function(){
			var checked=$(this).prop('checked')
			$(this).next().find(':checkbox').prop('checked',checked)
		})
	})

	$('.year').on('change', function(){
		$.ajax({
      		url : '<?php echo base_url(); ?>user_management/get_po_list_byyear',
      		type: 'POST',
      		dataType : 'json',
      		data : {
      			year_val : $(this).val()
      		},
      		error : function(){
      			
      		},
      		success : function(response){
      			console.log(response.status);
      			if(response.status == 1){
      				var HTML = `<div class="span06 p-3">
						<ul class="tree-list">`;
							response.po_list.forEach(function(pos, index){
								HTML += `<li><a href="#"><strong><input type="checkbox"> `+pos.po_name+` </strong></a>
									<ul>`;
										pos.output_list.forEach(function(output, index){
											HTML += `<li><a class="active" href="#"><strong><input type="checkbox"> `+output.title+`</strong></a>
												<ul>`;
													output.indicator_list.forEach(function(indicator, index){
														HTML += `<li><a class="active" href="#" ><strong><input type="checkbox"> `+indicator.title+`</strong></a>
															<ul>`;
																indicator.subindicator_list.forEach(function(subindicator, index){
																	HTML += `<li><a href="#"><input type="checkbox"> `+subindicator.title+`</a></li>`;
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
						HTML += `</ul>
					</div>`;
					
					$('.po_data').html(HTML);
      			}
      		}
		});
	})
</script>