<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/sankey.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/worldIndiaLow.js"></script>

<script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<style>
    .count_value{
        font-size: 16px;
        font-weight: 800;
    }
        .btn-primary-white {
            color: #fff;
            background-color: transparent;
            border-color: #fff;
        }

        .bg_filters {
            background: #004B03;
        }

        .btn_apply {
            border: 1px solid #A4C7B3;
            border-radius: 4px;
            font-size: 14px;
            color: #C5E2D2;
        }

        .dropdown-menu.filter-country.show {
            position: absolute;
            display: block;
            width: 94%;
            overflow-y: scroll;
            height: 300px;
            overflow-x: hidden;
        }

        .filter-multi>button.ms-choice {
            display: block;
            width: 100%;
            height: 26px;
            padding: 0px;
            overflow: hidden;
            cursor: pointer;
            border: 0px solid #aaa;
            text-align: left;
            white-space: nowrap;
            line-height: 38px;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            background-color: #004b03 !important;
        }

        .dropdown-item>label {
            margin-bottom: 0px !important;
        }

        .font-weight {
            font-weight: bold;
            color: #000;
        }

        .btn.hov:hover {
            color: #fff;
            text-decoration: none;
        }
        .hide {
            display: none;
        }
        .dropdown-toggle>span{
            position: static;
            top: 0px;
            left: 0px;
            padding-left: 0px;
            float: left;
            height: 100%;
            width: 100%;
            text-align: left;
            overflow: hidden;
            -webkit-box-flex: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
        }
    </style>
<style type="text/css">
    .data_middle{
        position: absolute;
        top: 50%;
        left: 45%;
    }
    .table td, .table th {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 0px solid #dee2e6;
        font-size: 15px;
    }
	.form-control button {
		border: none !important;
	}
	.stricky{
		position: fixed;
		top: 53px;
		width: 100%;
		z-index: 111;
	}
    .text_titles {
        text-transform: uppercase;
    }
    #details-modal::-webkit-scrollbar-track
        {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px!important;
        background-color: #F5F5F5;
        }

        #details-modal::-webkit-scrollbar
        {
        width: 12px!important;
        background-color: #F5F5F5!important;
        }

        #details-modal::-webkit-scrollbar-thumb
        {
        border-radius: 10px!important;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #004B03!important;
        }

        .scrollbar
        {
        height: auto;
        width: 100%;
        background: #F5F5F5;
        overflow-y: scroll;
        margin-bottom: 25px;
        }
    
    /* body *::-webkit-scrollbar {
    width: 15px!important;
    height: 5px;
    transition: .3s background;
        } */
        /* ::-webkit-scrollbar {
            width: 15px!important;
            background: gray!important;
        } */
       
	.filter-multi>button.ms-choice {
		display: block;
			width: 100%;
			height: 26px;
			padding: 0px;
			overflow: hidden;
			cursor: pointer;
			border: 0px solid #aaa;
			text-align: left;
			white-space: nowrap;
			line-height: 38px;
			color: #fff;
			text-decoration: none;
			border-radius: 4px;
			background-color: #004b03!important;
	}
    
	.filter-multi.bg_drop {
		display: block;
		width: 100%;
		padding: 0.375rem 0.75rem;
		font-size: 0.9375rem;
		line-height: 1.6;
		background-color: #004b03;
		background-clip: padding-box;
		border: 1px solid #d3dfea;
		transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
		border-radius: 5px;
		outline: 0;
		color: #4454c3;
		opacity: 1;
	}
	.form-control span {
		margin: 5px;
	}

	.ms-drop.bottom {
		left: 0;
	}

	span.badge>span {
		width: 100%;
		min-width: 40px;
		text-align: center;
		display: grid;
		margin: 0 auto;
		margin-top: 5px;
	}

	/* loading dots */
	.loading:after {
		content: ' .';
		padding-right: 5px;
		animation: dots 1s steps(5, end) infinite;
	}

    .mt-145px{
        margin-top: 145px;
    }

    .minh-210{
        min-height: 160px;
    }

    .modal-content{
        background: transparent; 
        border: none !important;
    }

    .modal-content-op{
        background: white; 
        border: none !important;
    }

    .dark_bg{
        font-weight: 700;
        font-size: 18px;
        background: #d2e8dc;
        color: #000;
    }

    .light_bg{
        background: #f4f8f7;
        color: #000;
    }
    

	@keyframes dots {

		0%,
		20% {
			color: rgba(255, 255, 255, 0);
			text-shadow:
				.25em 0 0 rgba(255, 255, 255, 0),
				.5em 0 0 rgba(255, 255, 255, 0);
		}

		40% {
			color: black;
			text-shadow:
				.25em 0 0 rgba(255, 255, 255, 0),
				.5em 0 0 rgba(255, 255, 255, 0);
		}

		60% {
			text-shadow:
				.25em 0 0 black,
				.5em 0 0 rgba(255, 255, 255, 0);
		}

		80%,
		100% {
			text-shadow:
				.25em 0 0 black,
				.5em 0 0 black;
		}
	}

    .card_indicator {
        width:100%;
        height:1200px;
    }
    .card_indicator1 {
        width:100%;
        height:1200px;
    }


    @media only screen and (max-width: 1750px) {
        .res_card_height{
            min-height: 170px;
        }
    }

    @media only screen and (max-width: 1650px) {
        .res_card_height{
            min-height: 195px;
        }

        .modal-xl {
            max-width: 1400px;
        }
        .card_indicator {
        width:100%;
        height:1200px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    }

    @media only screen and (max-width: 1280px) {
        .navbar-expand-xl .navbar-nav .nav-link {
            padding-right: 0.5rem;
            padding-left: 0.5rem;
        }
        .navbar-expand-xl{
            flex-flow: row wrap;
        }
        .p_2{
            padding: 5px!important;
        }
       
       
    }

    @media only screen and (max-width: 1200px) {
        .res_card_height{
            min-height: 270px;
        }

        .modal-xl {
            max-width: 1140px;
        }
    }

    /* @media (min-width: 1200px) {
        .modal-xl {
            max-width: 1140px;
        }
    } */

    @media only screen and (max-width: 991px) {
        .res_card_height{
            min-height: 270px;
        }
        .mt-145px {
            margin-top: 25px;
        }
        .btn_apply {
            border: 1px solid #A4C7B3;
            border-radius: 4px;
            font-size: 13px;
            color: #C5E2D2;
            margin-left: -15px;
        }
    }

    @media only screen and (max-width: 600px){
        .stricky {
                position: relative;
                top: 4px;
                width: auto;
                z-index: 111;
            }

            .mt-145px{
                margin-top: 0px;
            }
            .res_card_height{
            min-height: auto;
        }
        .btn_apply {
            border: 1px solid #A4C7B3;
            border-radius: 4px;
            font-size: 14px;
            color: #C5E2D2;
            margin-left: 0px;
        }
    }

 

    
</style>

<div class="app-content page-body mb-5">
<div class="container-fluid" style="margin-bottom: 50px;">
            <div class="row stricky">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card bg_filters">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10 col-lg-11">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Cluster</label>
                                                    <div id="clusterDropDown"></div>
                                                    <!-- <select multiple="multiple" title="Clusters" id="filter-clusters" ></select> -->
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Crop</label>
                                                    <select multiple="multiple" title="Crops" id="filter-crops"></select>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Country</label>
                                                    <div id="countryDropDown"></div>
													<!-- <select multiple="multiple" title="Countries" id="filter-countries"></select> -->
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Year</label>
													<select multiple="multiple" title="Years" id="filter-years"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-1 mt-5">
                                        <div class="d-flex justify-content-around">
                                                <div>
                                                <button class="btn btn_apply mt-2 p_2" id="overview-submit">Apply</button>
                                                </div>
                                                <div>
                                                <button class="btn btn_apply mt-2 ml-2 p_2" id="overview-refresh"><i class="fa fa-refresh"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-145px">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <a role="button"  id="details-farmers">
                        <div class="card shadow border-0 mt-5 minh-210 res_card_height">
                            <div class="card-body">
                                <!-- <a href="<?php echo base_url(); ?>/dashboard/overview_details"><div class="d-flex mb-3">
                                    <h3 class="text_title mb-0">Farmers and rural communities  reached through ICRISAT interventions and technologies</h3>                            
                                </div> -->

                                
                                    <div class="d-flex mb-3">
                                        <h3 class="text_title mb-0">Farmers and rural communities  reached through ICRISAT interventions and technologies</h3>                            
                                    </div>
                            
                                <div class="d-flex justify-content-between align-items-center flex-wrap" id="numbers-farmers"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- <div class="col-sm-12 col-md-5 col-lg-5">
                    <a role="button" id="details-communities">
                        <div class="card shadow border-0 mt-5 minh-210 res_card_height">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <h3 class="text_title mb-2">Number of communities/villages reached through ICRISAT interventions</h3>
                                    <span class="ml-auto" title="Disclaimer : Type of reach based on content type">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-wrap justify-content-around align-items-center text-center" id="numbers-communities"></div>
                            </div>
                        </div>
                    </a>
                </div> -->
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <a role="button" id="details-area">
                        <div class="card shadow border-0 mt-5 minh-210 res_card_height">
                            <div class="card-body">
                                <h3 class="text_title mb-3">Area covered through different interventions of ICRISAT </h3>
                                <div class="d-flex justify-content-around align-items-center text-center flex-wrap" id="numbers-areas"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                    <div class="card shadow border-0 mt-5 minh-210 res_card_height">
                        <div class="card-body">
                            <h3 class="text_title mt-2 ">Number of studies conducted (baseline, impact assessment, market, outcome)</h3>
                            <div class="d-flex justify-content-around align-items-center  text-center" id="numbers-studies"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card shadow border-0 mt-3">
                        <a role="button" id="details-seed-produced">
                            <div class="card-body">
                                <h3 class="text_title mb-2">Quantity of seed produced</h3>
                                <div class="" id="chart-seed-produced" style="width:100%;height: 400px;"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <a role="button" id="details-partnerships">
                        <div class="card shadow border-0 mt-3">
                            <div class="card-body">
                                <h3 class="text_title mb-2">Number of partnerships developed : <span class="count_value" id="number-partnership"></span></h3>
                                <div class="" id="chart-partnership" style="width:100%;height: 400px;"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <a role="button" id="details-outreach-events">
                        <div class="card shadow border-0 mt-3">
                            <div class="card-body">
                                <h3 class="text_title mb-2">Number of outreach events and campaigns conducted : <span class="count_value" id="number-outreach"></span></h3>
                                <div class="" id="chart-outreach-events" style="width:100%;height: 400px;"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="row">
                <!-- <div class="col-sm-12 col-md-5 col-lg-4">
                    <a role="button" id="details-activity">
                        <div class="card shadow border-0 mt-4">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="text_title mt-2 mb-4">Number of capacity development activities conducted</h3>
                                    <span class="ml-auto" title="Disclaimer : Participant Type in these activities">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-around align-items-center text-center" id="numbers-activities"></div>
                            </div>
                        </div>
                    </a>

                    <div class="card shadow border-0 mt-4">
                        <div class="card-body">
                            <h3 class="text_title mt-2 mb-4">Number of studies conducted (baseline, impact assessment, market, outcome)</h3>
                            <div class="d-flex justify-content-around align-items-center  text-center" id="numbers-studies"></div>
                        </div>
                    </div>
                </div> -->
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <a role="button" id="details-demonstrations">
                        <div class="card shadow border-0 mt-3">
                            <div class="card-body">
                                <h3 class="text_title mb-2">Number of demonstrations/benchmark sites established </h3>
                                <div class="count_strip" >Demonstrations : <span id="number-demonstrations" class="count_value"></span> &nbsp; Trails : <span class="count_value" id="number-trails"></span></div>
                                <div class="" id="chart-demonstrations" style="width:100%;height: 280px;"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <a role="button" id="details-policy-frameworks">
                        <div class="card shadow border-0 mt-3">
                            <div class="card-body">
                                <h3 class="text_title mb-6">Number of policy frameworks developed and influenced</h3>
                                <div class="" id="chart-policy-frameworks" style="width:100%;height: 280px;"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="pt-3 mt-4 container-fluid border border-1 border-dark shadow">
                <div class="text-center"><h2 class="text_title">Number of processing units established/supported : <span id="number-quantity-country" class="count_value"></span></h2></div>
                <div class="row">
                    
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a role="button" class="details-processing-units">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Capacity processed by country </h3>
                                    <div class="" id="chart-quantity-country" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a role="button" class="details-processing-units">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Capacity processed by crop <span id="number-quantity-crop"></span></h3>
                                    <div class="" id="chart-quantity-crop" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            

            <div class="pt-3 mt-4 container-fluid border border-1 border-dark shadow">
                <div class="text-center"><h2 class="text_title">Tools and technologies developed by ICRISAT </h2></div>
                <div class="row">                
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a role="button" id="details_genomic_tools">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2"> Number of Genomic tools and innovations developed : <span id="number_genomic"></span></h3>
                                    <div class="" id="chart_genomic_tools" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a role="button" id="details_innovation_system">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Number of innovation system tools and technologies developed : <span id="number_innovation"></span></h3>
                                    <div class="" id="chart_innovation_system" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">                
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <a role="button" id="details-digital-tools">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Number of digital tools and platforms developed : <span id="number-digital-tools" class="count_value"></span></h3>
                                    <div class="" id="chart-digital-tools" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <a role="button" id="details-technologies">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Number of ICRISAT technologies upscaled : <span id="number-technologies"></span></h3>
                                    <div class="" id="chart-technologies" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">                
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <a role="button" id="details-nrm-tools">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Number of NRM tools : <span id="number-nrm"></span></h3>
                                    <div class="" id="chart-nrm-tools" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <a role="button" id="details-climate_information">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Number of Climate Information service Tools</h3>
                                    <!-- <h3 class="text_title mb-2">Number of Climate Information service Tools <span id="number-climate_information"></span></h3> -->
                                    <div class="" id="chart-climate_information" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a role="button" class="details-varieties">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Varities released by country : <span id="number-variety-country" class="count_value"></span></h3>
                                    <div class="" id="chart-variety-country" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a role="button" class="details-varieties">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Varities released by crop <span id="number-variety-crop"></span></h3>
                                    <div class="" id="chart-variety-crop" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <a role="button" id="details-breeding-materials">
                            <div class="card shadow border-0 mt-4">
                                <div class="card-body">
                                    <h3 class="text_title mb-2">Number of new breeding materials developed and shared : <span id="number-breeding-materials" class="count_value"></span></h3>
                                    <div class="" id="chart-breeding-materials" style="width:100%;height: 250px;"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="card_indicator1" style="background: #fff;">
                    <div class="card shadow border-0 mt-4">
                        <div class="card-body">
                            <h3 class="text_title mb-2">ICRISAT's contribution towards SDGs -  Region & Country wise</h3>
                            <div class="" id="chart-sdg1" style="width:100%;height: 475px;"></div>
                            <div class="mt-3 text-center" id="chart-sdg1-help" ></div>
                        </div>
                    </div>
                    <div class="card shadow border-0 mt-4">
                        <div class="card-body">
                            <h3 class="text_title mb-2">ICRISAT's contribution towards SDGs -  Program & Cluster wise</h3>
                            <div class="" id="chart-sdg2" style="width:100%;height: 475px;"></div>
                            <div class="mt-3 text-center" id="chart-sdg2-help" ></div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card shadow border-0 mt-4 card_indicator">
                            <div class="card-body p-2">
                            <table class="table table-bordered" >
                                <tbody>
                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-01.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 1. End poverty in all its forms everywhere</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-02.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 2. End hunger, achieve food security and improved nutrition and promote sustainable agriculture</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-03.png" style="width:150px;"></td>
                                            <td class="font-weight-bold">  Goal 3: Ensure healthy lives and promote well-being for all at all ages </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-04.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 4. Ensure inclusive and equitable quality education and promote lifelong learning opportunities for all</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-05.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 5. Achieve gender equality and empower all women and girls</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-06.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 6. Ensure availability and sustainable management of water and sanitation for all</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-07.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 7. Ensure access to affordable, reliable, sustainable and modern energy for all </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-08.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 8. Promote sustained, inclusive and sustainable economic growth, full and productive employment and decent work for all</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-09.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 9. Build resilient infrastructure, promote inclusive and sustainable industrialization and foster innovation</td>
                                    </tr>


                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-10.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 10. Reduce inequality within and among countries</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-11.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 11. Make cities and human settlements inclusive, safe, resilient and sustainable</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-12.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 12. Ensure sustainable consumption and production patterns</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-13.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 13. Take urgent action to combat climate change and its impacts</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-14.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 14. Conserve and sustainably use the oceans, seas and marine resources for sustainable development</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-15.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 15. Protect, restore and promote sustainable use of terrestrial ecosystems, sustainably manage forests, combat desertification, and halt and reverse land degradation and halt biodiversity loss</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-16.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 16. Promote peaceful and inclusive societies for sustainable development, provide access to justice for all and build effective, accountable and inclusive institutions at all levels</td>
                                    </tr>

                                    <tr>
                                        <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-17.png" style="width:150px;"></td>
                                            <td class="font-weight-bold"> Goal 17. Strengthen the means of implementation and revitalize the Global Partnership for Sustainable Development</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->


        <!-- loading spinner -->
        <div class="modal" id="loading-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3 text-white">
                    <div id="loading-modal-container"></div>
                </div>
            </div>
        </div>



        <div class="modal scrollbar" id="details-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">

                    <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="card">
                                        <div class="card-body p-0">
                                            <div id="details-modal-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="modal" id="details-modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content p-3">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                   
                    <div id="details-modal-container"></div>
                </div>
            </div>
        </div> -->

</div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/dashboard_overview.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_farmers.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_communities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_area.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_partnerships.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_outreach_events.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_activities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_demonstrations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_policy_frameworks.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_processing_units.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_digital_tools.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_technologies.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_nrm_tools.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_genomic_tools.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_innovation_system.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_climateinformation.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_varieties.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_breeding_materials.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/overview_details_seedproduced.js"></script>


<style>
        @media (min-width: 576px) {
        .modal-dialog {
            max-width: 100%;
            margin: 1.75rem auto;
        }
        }
    </style>