<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/leaflet.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/MarkerCluster.Default.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/leaflet.fullscreen.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/leaflet.easybutton.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/main.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/dashboard.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>include/dashboard/styles/bootstrap-select.min.css" />
	<style>
		.app-content.page-body {
			margin-top: 4rem !important;
		}
		.ifdiv{
			border: 0;
		}
	</style>

	<style>
        .title_small {
            font-size: 15px;
        }

        .bootstrap-select>.dropdown-toggle {
            padding: 7px;
        }

        .text-primary-main {
            color: #0056b3;
        }

        .logo-img-height {
            height: 90px;
        }

        .table td,
        .table th {
            padding: 10px;
            font-size: 14px;
            white-space: nowrap;
            vertical-align: middle;
            border-top: 0px solid #dee2e6;
        }

        table>tbody {
            border-top: 1px solid #dee2e6;
        }

        svg.legend-svg {
            width: 90px;
        }

        .table-legend th {
            padding: 5px !important;
        }

        b,
        strong {
            font-weight: bolder;
            font-size: 16px;
        }

        .text-li {
            font-size: 15px;
        }

        .h4,
        h4 {
            font-size: 14px;
        }

        .btn-sm.btn-light {
            font-size: 12px;

        }

        .dropdown-menu.show {
            display: block;
            height: 300px;
            overflow-y: scroll;
        }

        .mt-33px {
            margin-top: 33px;
        }

        @media only screen and (max-width: 1920px) {

            .h4,
            h4 {
                font-size: 18px;
            }
            .btn-light1 {
                background-color: transparent;
                border-color: #A4C7B3;
                padding: 6px 9px;
                border-radius: 0px;
            }

            .heading_text {
                font-size: 16px;
                color: #695965;
                letter-spacing: -0.07px;
                text-align: left;
                margin: 24px auto;
                font-weight: 600;
                position: relative;
                font-style: normal;
            }

            .table td,
            .table th {
                padding: 5px;
                font-size: 15px;
                white-space: nowrap;
                vertical-align: middle;
                border-top: 0px solid #dee2e6;
            }

            .d-next img {
                height: 23px;
                margin-top: 8px;
            }

            .btn-sm.btn-light {
                font-size: 15px;
                margin-top: 0px !important;
            }
        }

        @media only screen and (max-width: 1538px) {
            .text-li {
                font-size: 12px;
                white-space: nowrap;
            }

            .title {
                font-size: 14px;
                color: #333333;
                font-weight: bold;
            }

            .title_small {
                font-size: 13px;
            }

            .table td,
            .table th {
                padding: 4px;
                font-size: 12px;
                white-space: nowrap;
                vertical-align: middle;
                border-top: 0px solid #dee2e6;
            }

            .btn-sm.btn-light {
                font-size: 12px;
                margin-top: 5px !important;
            }

            .d-next img {
                height: 20px;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 7px 7px;
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, .125);
            }
        }

        @media only screen and (max-width: 1280px) {
            .text-li {
                font-size: 9px;
                white-space: nowrap;
            }

            .title_small {
                font-size: 9px;
            }

            b,
            strong {
                font-weight: bolder;
                font-size: 12px;
            }

            .table td,
            .table th {
                padding: 4px;
                font-size: 9px;
                white-space: nowrap;
                vertical-align: middle;
                border-top: 0px solid #dee2e6;
            }

            .btn-sm.btn-light {
                font-size: 8px;
                margin-top: 1px !important;
            }

            .d-next img {
                height: 17px;
                margin-top: 0px;
            }

            .btn-light1 {
                background-color: transparent;
                border-color: #A4C7B3;
                padding: 2.7px;
                font-size: 15.5px;
                border-radius: 0px;
                margin-top: 31px;
            }

            .bootstrap-select>.dropdown-toggle {
                padding: 2px 10px;
            }

            .bootstrap-select>.dropdown-toggle {
                position: relative;
                width: 100%;
                border-radius: 0px;
                height: auto!important;
                padding: 2px 10px;
                font-weight: 600;
                text-align: right;
                white-space: nowrap;
                display: -webkit-inline-box;
                display: -webkit-inline-flex;
                display: -ms-inline-flexbox;
                display: inline-flex;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: justify;
                -webkit-justify-content: space-between;
                -ms-flex-pack: justify;
                justify-content: space-between;
            }
        }

        @media only screen and (max-width: 1229px) {
            .text-li {
                font-size: 9px;
                white-space: nowrap;
            }

            .heading_text {
                font-size: 14px;
                color: #695965;
                letter-spacing: -0.07px;
                text-align: left;
                margin: 24px auto;
                font-weight: 600;
                position: relative;
                font-style: normal;
            }

            .h4,
            h4 {
                font-size: 14px;
            }


            .title_small {
                font-size: 9px;
            }

            b,
            strong {
                font-weight: bolder;
                font-size: 14px;
            }

            .table td,
            .table th {
                padding: 4px;
                font-size: 9px;
                white-space: nowrap;
                vertical-align: middle;
                border-top: 0px solid #dee2e6;
            }

            .btn-sm.btn-light {
                font-size: 7px;
                margin-top: 1px !important;
            }



            .d-next img {
                height: 14px;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 7px 7px;
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, .125);
            }
        }

        @media only screen and (max-width: 1097px) {
            .text-li {
                font-size: 9px;
            }

            .title_small {
                font-size: 10px;
            }

            b,
            strong {
                font-weight: bolder;
                font-size: 12px;
            }

            .table td,
            .table th {
                padding: 4px;
                font-size: 8px;
                white-space: nowrap;
                vertical-align: middle;
                border-top: 0px solid #dee2e6;
            }
        }

        @media only screen and (max-width: 1024px) {
            .text-li {
                font-size: 8px;
            }

            .d-next img {
                height: 15px;
            }

            .title_small {
                font-size: 8px;
            }

            b,
            strong {
                font-weight: bolder;
                font-size: 10px;
            }

            .table td,
            .table th {
                padding: 6px;
                font-size: 8px;
                white-space: nowrap;
                vertical-align: middle;
                border-top: 0px solid #dee2e6;
            }

            .h4,
            h4 {
                font-size: 14px;
            }

            .table-legend th {
                padding: 3px !important;
            }

            .heading_text {
                font-size: 13px;
                color: #695965;
                letter-spacing: -0.07px;
                text-align: left;
                margin: 24px auto;
                font-weight: 600;
                position: relative;
                font-style: normal;
            }

            .title {
                font-size: 12px;
                color: #333333;
                font-weight: bold;
            }

            a.d-breadcrumb {
                color: black;
                text-decoration: none;
                font-size: 12px;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 7px 7px;
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, .125);
            }
        }
    </style>

	<!-- JS -->
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/leaflet.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/leaflet.markercluster.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/leaflet.easybutton.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/leaflet.fullscreen.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/topojson.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/d3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/d3SvgOverlay.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/xlsx.bundle.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/lib/xlsx.full.min.js"></script>
    <!-- Charts JS-->
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/series-label.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/export-data.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript" src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script type="text/javascript" src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script type="text/javascript" src="https://cdn.amcharts.com/lib/4/maps.js"></script>
    <script type="text/javascript" src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

	<input type="hidden" id="base" value="<?php echo base_url(); ?>">
	<input type="text" id="countrySegmentVal" value="<?php echo $country_id; ?>">
    <!-- Main body -->
    <div class="app-content page-body">
    	<div class="container-fluid">
    		<div class="row">
				<div class="col-md-12">
		    		<div class="card p-0">
						<div class="card-body">     	
				            <div class="row">
				                <div class="col-sm-12 col-md-5 col-lg-5">
				                    <div class="card bg_filters">
				                        <div class="card-body p-1">
				                            <div class="row">
				                                <div class="col-sm-12 col-md-9 col-lg-9">
				                                    <div class="form-group" style="display: none;">
				                                        <label class="text-white">Select <span id="label-sn">Sub-national
				                                                level</span></label>
				                                        <select class="form-select" id="filter-sn" multiple
				                                            data-actions-box="true" data-live-search="true" data-size="8"
				                                            data-selected-text-format="count>0">
				                                        </select>
				                                    </div>
				                                    <div class="form-group">
				                                        <label class="text-white">Select Production System</label>
				                                        <select class="selectpicker" id="filter-ps">
				                                            <option value="0" selected>All</option>
				                                            <option value="1">Grazing</option>
				                                            <option value="2">Mixed</option>
				                                        </select>
				                                    </div>
				                                </div>
				                                <div class="col-sm-12 col-md-3 col-lg-3">
				                                    <button class="btn btn-light1 text-white text-center mt-33px"
				                                        id="submit">Submit</button>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                    <div class=" mt-2" id="dashboard-map" style="height:75vh;width:100%;">
				                        <div>
				                            <label for="dashboard-map-view" class="btn-dis">
				                                <input type="radio" class="map-checkbox" value="country"
				                                    name="dashboard-map-view" checked />
				                                <span class="expand-countries" id="map-option-country"></span>
				                            </label>
				                            <label for="dashboard-map-view" class="btn-dis1">
				                                <input type="radio" class="map-checkbox" value="sn" name="dashboard-map-view" />
				                                <span class="expand-countries" id="map-option-sn"></span>
				                            </label>
				                            <!-- <div id="map-legend" style="display: none;">
				                                <div><span class="dot" style="background-color: orange; opacity: 0.8;"></span>&nbsp;<span> Mixed</span></div>
				                                <div><span class="dot" style="background-color: green; opacity: 0.8;"></span>&nbsp;<span> Grazing</span></div>
				                            </div> -->
				                            <div id="map-legend" style="display: none;"></div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-sm-12 col-md-7 col-lg-7">
				                    <div class="row align-items-center">
				                        <div class="col-sm-6 col-md-3 col-lg-3">
				                            <div class="title mb-2" id="dashboard-level-title"></div>
				                        </div>
				                        <div class="col-sm-6 col-md-9 col-lg-9">
				                            <div class="d-flex title mb-2 pull-right">
				                                <ul class="mb-0 d-flex justify-content-between align-items-center flex-wrap mt-2 pl-0"
				                                    style="display: d-flex;list-style-type: none;margin-top: -10px;">
				                                    <li style="margin-right: 10px; margin-top: 15px;">
				                                        <table class="table table-sm table-bordered table-legend w-100 mr-3">
				                                            <tbody>
				                                                <tr class="text-center">
				                                                    <th>Positive <i class="fa fa-arrow-up text-success"></i>
				                                                    </th>
				                                                    <th>Negative <i class="fa fa-arrow-down text-danger"></i>
				                                                    </th>
				                                                    <th>No Change <i class="fa fa-arrows-h text-muted"></i>
				                                                    </th>
				                                                </tr>
				                                            </tbody>
				                                        </table>
				                                    </li>
				                                    <!-- <li>
				                                            <div>
				                                                <span class="dot" style="background-color: #008000; opacity: 1"></span>&nbsp;
				                                                <span class="pos-text">Upward Desired Trend</span>
				                                            </div>
				                                        </li>
				                                        <li>
				                                            <div>
				                                                <span class="dot" style="background-color: #ff0000; opacity: 1;"></span>&nbsp;
				                                                <span class="nag-text">Downward Desired Trend</span>
				                                            </div>
				                                        </li> -->
				                                    <li>
				                                        <div class="flex dropdown show">
				                                            <b id="dashboard-sn-count"></b> <span class="title_small"  id="dashboard-sn-plural"></span>&nbsp;
				                                            <a role="button" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="false" id="dropdown-sn-list-dd">
				                                                <i class="fa fa-info-circle"></i>
				                                            </a>
				                                            <span class="dropdown-menu dropdown-menu-right title_small"
				                                                aria-labelledby="#dropdown-sn-list-dd">
				                                                <ul style="display: d-flex;list-style-type: none;padding-top: 10px; height: auto;"
				                                                    id="dashboard-sn-list">
				                                                </ul>
				                                            </span>
				                                        </div>
				                                    </li>
				                                    <li>
				                                        <span><b class="title_small pl-2" id="dashboard-ps-type"></b></span>
				                                    </li>
				                                </ul>
				                            </div>
				                        </div>
				                    </div>
				                    <div class="mb-2" id="dashboard-breadcrumb"></div>
				                    <div class="card border-0 mt-2">
				                        <div class="px-1" id="dashboard-parent"></div>
				                        <div class="px-1" id="dashboard-children"></div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
		        </div>

		        <!-- <section class="mt-2 bg-white footer-fixed">
		            <div class="container-fluid">
		                <div class="row text-center">
		                    <div class="col-sm-12 col-md-4 col-lg-4">
		                        <img src="./assets/images/Germancooperation.jpg" class="logo-img-height">
		                    </div>
		                    <div class="col-sm-12 col-md-4 col-lg-4">
		                        <img src="./assets/images/GIZ.jpg" class="logo-img-height">
		                    </div>
		                    <div class="col-sm-12 col-md-4 col-lg-4">
		                        <img src="./assets/images/ILRI.jfif" class="logo-img-height">
		                    </div>
		                    <div class="col-md-12 col-sm-12 bottom">
		                        <ul class="legal centered text-dark mb-0" style="list-style-type: none;">
		                            <li><a href="javascript:void(0);" class="text-dark font-14px">Copyright and permissions | ©
		                                    2022 International Livestock Research Institute |
		                                    <i class="fa fa-cc"></i> | <i class="fa fa-user-circle-o"></i></a></li>
		                        </ul>
		                    </div>
		                </div>

		            </div>
		        </section> -->
		    </div>
		</div>
	</div>


    <div class="modal" id="national-chart-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content m-3">
                <div class="modal-header text-dark" id="national-chart-name"></div>
                <div class="modal-body">
                    <div id="national-chart-modal-container" class="p-4" style="background: #ffffff; height: 35vh; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- loading spinner -->
    <div class="modal" id="loading-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 text-white" style="background: transparent; border: none !important;">
                <div id="loading-modal-container"></div>
            </div>
        </div>
    </div>



    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/dashboardScripts/utils.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>include/dashboard/dashboardScripts/dashboard.js"></script>
</body>

