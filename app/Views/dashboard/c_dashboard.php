




<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<style>
		.app-content.page-body {
			margin-top: 4rem !important;
		}
		.ifdiv{
			border: 0;
		}
		</style>
</head>
<body>
	<div class="app-content page-body">
		<!-- <div class="container-fluid">
			<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
			<a href="<?php echo base_url(); ?>reporting/comparisons/<?php echo $country_id;?>" class="btn btn-sm mt-3 mb-3 btn-success pull-right"   style="margin-right:10px;">Comparisons</a>
			</div>
		</div> -->
		<div class="row">
			<?php if(isset($county_id)){ ?>
				<!-- <iframe src="http://3.16.201.127/atpd/country-admin-atpd/dashboard.html?countryId=<?php echo $country_id;?>&snId=<?php echo $county_id;?>" class="ifdiv" width="100%" height=750px"></iframe> -->
					<!-- <iframe src="http://3.16.201.127/atpd/country-admin-atpd/dashboard.html?countryId=<?php echo $country_id;?>" class="ifdiv" width="100%" height="750px"></iframe> -->
					<iframe src="http://65.0.242.164/tails_dashboard/dashboard.html?countryId=<?php echo $country_id;?>" class="ifdiv" width="100%" height="750px"></iframe>
			<?php } else{?>
				<!-- <iframe src="http://3.16.201.127/atpd/country-admin-atpd/dashboard.html?countryId=<?php echo $country_id;?>" class="ifdiv" width="100%" height="750px"></iframe> -->
				<iframe src="http://65.0.242.164/tails_dashboard/dashboard.html?countryId=<?php echo $country_id;?>" class="ifdiv" width="100%" height="750px"></iframe>
			<?php }?>
			</div>
		</div>
	</div><!-- end app-content-->
	</div>

</body>

