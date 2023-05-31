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
        .btn-primary-white {
            color: #fff;
            background-color: transparent;
            border-color: #fff;
        }
        .ms-drop {
            width: 100%;
        }
        .text_pos_female {
            font-size: 9px;
            color: #666666;
            letter-spacing: -0.04px;
            text-align: center;
            line-height: 12px;
            font-weight: bold;
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
            position: absolute!important;
            display: block;
            width: 100%;
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
        min-height: 210px;
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
            min-height: 230px;
        }
    }

    @media only screen and (max-width: 1650px) {
        .res_card_height{
            min-height: 300px;
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
            min-height: 400px;
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
            min-height: 450px;
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


<div class="container-fluid" style="margin-bottom: 70px;">
        <div class="row stricky">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card bg_filters">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10 col-lg-11">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <label class="text-white">Cluster</label>
                                                    <select multiple="multiple" title="Clusters" id="filter-clusters" ></select>
                                                </div>
                                                <!-- <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Crop</label>
                                                    <select multiple="multiple" title="Crops" id="filter-crops"></select>
                                                </div> -->
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <label class="text-white">Country</label>
                                                    <div id="countryDropDown"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <label class="text-white">Year</label>
													<select multiple="multiple" title="Years" id="filter-years"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-lg-1 mt-5">
                                        <div class="d-flex justify-content-around">
                                                <div>
                                                <button class="btn btn_apply mt-2 p_2" id="nonresearch-submit">Apply</button>
                                                </div>
                                                <div>
                                                <button class="btn btn_apply mt-2 ml-2 p_2" id="nonresearch-refresh"><i class="fa fa-refresh"></i></button>
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


            <div class="row" style="margin-top: 160px;">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card shadow border-0 mt-4">
                        <div class="card-body">
                            <a role="button" id="details-internal-communications">
                                <!-- <h3 class="text_title mb-2">Internal communication feedback, review and engagement </h3> -->
                                <h3 class="text_title mb-2">Number of internal communication feedback, review and engagements conducted</h3>
                                <!-- <div class="d-flex justify-content-around align-items-center  text-center">
                                    <div>
                                        <h2 class="font-24px mt-3" id="number-internal-communications"></h2>
                                        <p class="mb-0 small_text2">Number of submissions </p>
                                    </div>
                                </div> -->
                                <div class="" id="chart-internal-communications" style="width:100%;height: 400px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card shadow border-0 mt-4">
                        <div class="card-body mb-0 pb-3">
                            <h3 class="text_title">Internal Trainings and participants </h3>
                            <div class="d-flex justify-content-between align-items-center flex-wrap mt-2">
                                <div class="">
                                    <p class="mb-0 text_pos_female"><span>28%</span></p>
                                    <p class="mb-0"><img src="<?php echo base_url(); ?>include/assets/images/female.png" height="55px"></p>
                                    <p class="mb-0 text_small">Female</p>
                                </div>
                                <div class="">
                                    <p class="mb-0 text_pos_female"> <span>72%</span></p>
                                    <p class="mb-0"><img src="<?php echo base_url(); ?>include/assets/images/male.png" height="55px"></p>
                                    <p class="mb-0 text_small">MALE</p>
                                </div>
                                <div class="pr-4">
                                    <p class="mb-0 text_pos_female text-center"> <span>42%</span></p>
                                    <p class="mb-0"><img src="<?php echo base_url(); ?>include/assets/images/youth.svg" height="55px"></p>
                                    <p class="mb-0 text_small">Youth</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card shadow border-0 mt-4">
                        <div class="card-body">
                            <a role="button" id="details-corporate-support">
                                <!-- <h3 class="text_title mb-2">Rationalization, restructuring and re-energising corporate support functions and units </h3> -->
                                <h3 class="text_title mb-2">Number of activities conducted for rationalization, restructuring and re-engineering corporate support function</h3>
                                <!-- <div class="d-flex justify-content-around align-items-center text-center">
                                    <div>
                                        <h2 class="font-24px mt-3" id="number-corporate-support"></h2>
                                        <p class="mb-0 small_text2">Number of submissions </p>
                                    </div>
                                </div> -->
                                <div class="" id="chart-corporate-support" style="width:100%;height: 400px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card shadow border-0 mt-3">
                        <a role="button" id="details-strategies-policies">
                            <div class="card-body">
                                <!-- <h3 class="text_title mb-2">Strategies, Policies </h3> -->
                                <h3 class="text_title mb-2">Number of strategies and policies reviewed</h3>
                                <div class="" id="chart-strategies-policies" style="width:100%;height: 400px;"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-body">
                            <a role="button" id="details-process-workflow">
                                <!-- <h3 class="text_title mb-2">Process, workflows, and standard operating procedures </h3> -->
                                <h3 class="text_title mb-2">Number of processes workflows and SOPs created</h3>
                                <div class="" id="chart-process-workflow" style="width:100%;height: 400px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-body">
                            <a role="button" id="details-digital-workflow">
                                <!-- <h3 class="text_title mb-2">Digitized workflows and processes </h3> -->
                                <h3 class="text_title mb-2">Number of digitized workflows and processes completed</h3>
                                <div class="" id="chart-digital-workflow" style="width:100%;height: 400px;"></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-body">
                            <a role="button" id="details-knowledge-products">
                                <!-- <h3 class="text_title mb-2">Knowledge dissemination, communications outreach and stakeholder engagement</h3> -->
                                <h3 class="text_title mb-2">Number of products created for knowledge dissemination, communication outreach and stakeholder engagement</h3>
                                <div class="" id="chart-knowledge-products" style="width:100%;height: 400px;"></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-body">
                            <a role="button" id="details-participants">
                                <!-- <h3 class="text_title mb-2">Internal Trainings and participants </h3> -->
                                <h3 class="text_title mb-2">Number of internal trainings conducted</h3>
                                <div class="" id="chart-participants" style="width:100%;height: 400px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

    </div>


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


<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/dashboard_nonresearch.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_internal_communications.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_corporate_support_data.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_strategies_policies.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_digital_workflow.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_knowledge_products.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_process_workflows.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/nonresearch_participants.js"></script>


<style>
        @media (min-width: 576px) {
        .modal-dialog {
            max-width: 100%;
            margin: 1.75rem auto;
        }
        }
    </style>

