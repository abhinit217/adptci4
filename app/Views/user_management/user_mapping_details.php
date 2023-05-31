	<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/plugins/checkbox-tree-plugin/js/checktree.js"></script>
	<style type="text/css">
		ul {
			list-style-type: none;
			margin: 40px;
			margin-top: 15px;
		}
	</style>
	<div class="app-content page-body">
		<div class="container-fluid">
			<!-- Row -->
			<div class="row" style="margin-bottom: 30px;">
				<div class="col-md-12">
					<a href="<?php echo base_url(); ?>user_management/user_list" class="btn btn-sm btn-success pull-right">Back to user list</a>
					<h4><?php echo $user_details['first_name']." ".$user_details['last_name']; ?></h4>
					<div class="card mt-5">
						<div class="card-body">
							<!-- <div class="table-responsive">
								<table class="table table-bordered table_th text-center" style="border-collapse:collapse;">
									<thead>
										<tr>
											<th>#</th>
											<th>Country</th>
											<th>Crop</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($user_countrycrop_mapdetails as $key => $user) { ?>
											<tr>
												<td><?php echo $key+1; ?></td>
												<td><?php echo $user['country_name'] ?></td>
												<td><?php echo $user['crop_name'] ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div> -->

							<div class="row">
								<div class="col-sm-12 po_data" style="background-color: #f5f5f5">
									<div class="span06 p-3">
										<ul class="checktree tree-list">
											<?php foreach ($po_list as $key => $pos) { ?>
												<li><a href="javascript:void(0);">
														<strong>
															<input type="checkbox" name="po_val" value="<?php echo $pos['prog_id']; ?>" <?php echo (in_array($pos['prog_id'], $user_pos)) ? 'checked' : ''; ?> disabled > <?php echo $pos['prog_name'] ?>
														</strong>
													</a>
													<ul>
														<?php foreach ($pos['cluster_list'] as $key => $output) { ?>
															<li>
																<a class="active" href="javascript:void(0);">
																	<strong>
																		<input type="checkbox" name="output_val" value="<?php echo $output['cluster_id'] ?>" <?php echo (in_array($output['cluster_id'], $user_outputs)) ? 'checked' : ''; ?> disabled> <?php echo $output['cluster_name']; ?>
																	</strong>
																</a>
																<ul>
																	<?php foreach ($output['indicator_list'] as $key => $indicator) { ?>
																		<li>
																			<a class="active" href="javascript:void(0);">
																				<strong>
																					<input type="checkbox" name="indicator_val" value="<?php echo $indicator['id'] ?>" <?php echo (in_array($indicator['id'], $user_indicators)) ? 'checked' : ''; ?> disabled> <?php echo $indicator['title']; ?>
																				</strong>
																			</a>
																			<ul>
																				<?php foreach ($indicator['subindicator_list'] as $key => $subindicator) { ?>
																					<li>
																						<a class="active" href="javascript:void(0);">
																							<strong>
																								<input type="checkbox" name="subindicator_val" value="<?php echo $subindicator['id'] ?>" <?php echo (in_array($subindicator['id'], $user_subindicators)) ? 'checked' : ''; ?> disabled> <?php echo $subindicator['title']; ?>
																							</strong>
																						</a>
																					</li>
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
	$(function(){
		$("ul.checktree").checktree();
	});
</script>
<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-36251023-1']);
	_gaq.push(['_setDomainName', 'jqueryscript.net']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>