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

.card_indicator {
    width: 100%;
    height: 1200px;
    overflow-y: scroll;
    overflow-x: hidden;
}
    .title-center{
        margin: 0 auto;
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
    .font-14px {
        font-size: 14px;
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
            <div class="col-sm-12 col-md-8 col-lg-8">
                <a role="button"  id="details-sdg">
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
                </a>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card shadow border-0 mt-4 card_indicator">
                        <div class="card-body p-2">
                            <div class="accordion" id="accordionExample">
                            <table class="table table-bordered" >
                            <tbody>
                                <tr>
                                    <td class="text-center p-0" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-01.png" style="width:150px;"></td>
                                    <td class="font-weight-bold"> Goal 1. End poverty in all its forms everywhere</td>
                                </tr>
                                <tr id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 1.1 By 2030, eradicate extreme poverty for all people everywhere, currently measured as people living on less than $1.25 a day </p>
                                       
                                        <p class="font-14px"> 1.2 By 2030, reduce at least by half the proportion of men, women and children of all ages living in poverty in all its dimensions 
                                        according to national definitions </p>
                                        <p class="font-14px"> 1.3 Implement nationally appropriate social protection systems and measures for all, including floors, and by 2030 achieve substantial 
                                        coverage of the poor and the vulnerable </p>
                                        <p class="font-14px"> 1.4 By 2030, ensure that all men and women, in particular the poor and the vulnerable, have equal rights to economic resources, 
                                        as well as access to basic services, ownership and control over land and other forms of property, inheritance, natural resources, appropriate new technology and financial services,
                                         including microfinance </p>

                                         <p class="font-14px"> 1.5 By 2030, build the resilience of the poor and those in vulnerable situations and reduce their exposure and vulnerability to climate-related extreme events and other economic, social and environmental shocks and disasters </p>
                                         <p class="font-14px"> 1.a Ensure significant mobilization of resources from a variety of sources, including through enhanced development cooperation, in order to provide adequate and predictable means for developing countries, in particular least developed countries, to implement programmes and policies to end poverty in all its dimensions</p>
                                         <p class="font-14px"> 1.b Create sound policy frameworks at the national, regional and international levels, based on pro-poor and gender-sensitive development strategies, to support accelerated investment in poverty eradication actions</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-02.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 2. End hunger, achieve food security and improved nutrition and promote sustainable agriculture</td>
                                </tr>

                                <tr id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 2.1 By 2030, end hunger and ensure access by all people, in particular the poor and people in vulnerable situations, including infants, to safe, nutritious and sufficient food all year round</p>
                                       
                                        <p class="font-14px"> 2.2 By 2030, end all forms of malnutrition, including achieving, by 2025, the internationally agreed targets on stunting and wasting in children under 5 years of age, and address the nutritional needs of adolescent girls, pregnant and lactating women and older persons</p>
                                        <p class="font-14px"> 2.3 By 2030, double the agricultural productivity and incomes of small-scale food producers, in particular women, indigenous peoples, family farmers, pastoralists and fishers, including through secure and equal access to land, other productive resources and inputs, knowledge, financial services, markets and opportunities for value addition and non-farm employment </p>
                                        <p class="font-14px"> 2.4 By 2030, ensure sustainable food production systems and implement resilient agricultural practices that increase productivity and production, that help maintain ecosystems, that strengthen capacity for adaptation to climate change, extreme weather, drought, flooding and other disasters and that progressively improve land and soil quality </p>
                                        <p class="font-14px"> 2.5 By 2020, maintain the genetic diversity of seeds, cultivated plants and farmed and domesticated animals and their related wild species, including through soundly managed and diversified seed and plant banks at the national, regional and international levels, and promote access to and fair and equitable sharing of benefits arising from the utilization of genetic resources and associated traditional knowledge, as internationally agreed</p>
                                        <p class="font-14px"> 2.a Increase investment, including through enhanced international cooperation, in rural infrastructure, agricultural research and extension services, technology development and plant and livestock gene banks in order to enhance agricultural productive capacity in developing countries, in particular least developed countries</p>
                                        <p class="font-14px"> 2.b Correct and prevent trade restrictions and distortions in world agricultural markets, including through the parallel elimination of all forms of agricultural export subsidies and all export measures with equivalent effect, in accordance with the mandate of the Doha Development Round</p>
                                        <p class="font-14px"> 2.c Adopt measures to ensure the proper functioning of food commodity markets and their derivatives and facilitate timely access to market information, including on food reserves, in order to help limit extreme food price volatility</p>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-03.png" style="width:150px;"></td>
                                        <td class="font-weight-bold">  Goal 3: Ensure healthy lives and promote well-being for all at all ages </td>
                                </tr>

                                <tr id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 3.4 By 2030, reduce by one third premature mortality from non-communicable diseases through prevention and treatment and promote mental health and well-being.</p>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-04.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 4. Ensure inclusive and equitable quality education and promote lifelong learning opportunities for all</td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-05.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 5. Achieve gender equality and empower all women and girls</td>
                                </tr>

                                <tr id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 5.a Undertake reforms to give women equal rights to economic resources, as well as access to ownership and control over land and other forms of property, financial services, inheritance and natural resources, in accordance with national laws</p>
                                        <p class="font-14px"> 5.b Enhance the use of enabling technology, in particular information and communications technology, to promote the empowerment of women </p>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-06.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 6. Ensure availability and sustainable management of water and sanitation for all</td>
                                </tr>

                                <tr id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 6.5 By 2030, implement integrated water resources management at all levels, including through transboundary cooperation as appropriate</p>
                                        <p class="font-14px"> 6.6 By 2020, protect and restore water-related ecosystems, including mountains, forests, wetlands, rivers, aquifers and lakes</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingSeven" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-07.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 7. Ensure access to affordable, reliable, sustainable and modern energy for all </td>
                                </tr>

                               

                                <tr>
                                    <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-08.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 8. Promote sustained, inclusive and sustainable economic growth, full and productive employment and decent work for all</td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingNine" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-09.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 9. Build resilient infrastructure, promote inclusive and sustainable industrialization and foster innovation</td>
                                </tr>

                                <tr  id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 9.5 Enhance scientific research, upgrade the technological capabilities of industrial sectors in all countries, in particular developing countries, including, by 2030, encouraging innovation and substantially increasing the number of research and development workers per 1 million people and public and private research and development spending</p>
                                        <p class="font-14px"> </p>
                                        <p class="font-14px"> </p>
                                    </td>
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
                                    <td class="text-center p-0" id="headingTwovel" data-toggle="collapse" data-target="#collapseTwovel" aria-expanded="false" aria-controls="collapseTwovel"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-12.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 12. Ensure sustainable consumption and production patterns</td>
                                </tr>

                                <tr id="collapseTwovel" class="collapse" aria-labelledby="headingTwovel" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 12.3 By 2030, halve per capita global food waste at the retail and consumer levels and reduce food losses along production and supply chains, including post-harvest losses</p>
                                       </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingThirteen" data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-13.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 13. Take urgent action to combat climate change and its impacts</td>
                                </tr>

                                <tr id="collapseThirteen" class="collapse" aria-labelledby="headingThirteen" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                         <p class="font-14px">13.1 Strengthen resilience and adaptive capacity to climate-related hazards and natural disasters in all countries </p>
                                        <p class="font-14px">13.2 Integrate climate change measures into national policies, strategies and planning </p>
                                        <p class="font-14px"> 13.3 Improve education, awareness-raising and human and institutional capacity on climate change mitigation, adaptation, impact reduction and early warning</p>
                                        <p class="font-14px"> 13.a Implement the commitment undertaken by developed-country parties to the United Nations Framework Convention on Climate Change to a goal of mobilizing jointly $100 billion annually by 2020 from all sources to address the needs of developing countries in the context of meaningful mitigation actions and transparency on implementation and fully operationalize the Green Climate Fund through its capitalization as soon as possible</p>
                                        <p class="font-14px"> 13.b Promote mechanisms for raising capacity for effective climate change-related planning and management in least developed countries and small island developing States, including focusing on women, youth and local and marginalized communities</p>
                                       
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-14.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 14. Conserve and sustainably use the oceans, seas and marine resources for sustainable development</td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingFifteen" data-toggle="collapse" data-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-15.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 15. Protect, restore and promote sustainable use of terrestrial ecosystems, sustainably manage forests, combat desertification, and halt and reverse land degradation and halt biodiversity loss</td>
                                </tr>

                                <tr id="collapseFifteen" class="collapse" aria-labelledby="headingFifteen" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 15.3 By 2030, combat desertification, restore degraded land and soil, including land affected by desertification, drought and floods, and strive to achieve a land degradation-neutral world</p>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-16.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 16. Promote peaceful and inclusive societies for sustainable development, provide access to justice for all and build effective, accountable and inclusive institutions at all levels</td>
                                </tr>

                                <tr>
                                    <td class="text-center p-0" id="headingSeventeen" data-toggle="collapse" data-target="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen"><img src="<?php echo base_url(); ?>include/assets/images/sdgs/E-WEB-Goal-17.png" style="width:150px;"></td>
                                        <td class="font-weight-bold"> Goal 17. Strengthen the means of implementation and revitalize the Global Partnership for Sustainable Development</td>
                                </tr>

                                <tr id="collapseSeventeen" class="collapse" aria-labelledby="headingSeventeen" data-parent="#accordionExample">
                                    <td></td>
                                    <td>
                                        <p class="font-14px"> 17.6 Enhance North-South, South-South and triangular regional and international cooperation on and access to science, technology and innovation and enhance knowledge-sharing on mutually agreed terms, including through improved coordination among existing mechanisms, in particular at the United Nations level, and through a global technology facilitation mechanism</p>
                                        <p class="font-14px">17.8 Fully operationalize the technology bank and science, technology and innovation capacity-building mechanism for least developed countries by 2017 and enhance the use of enabling technology, in particular information and communications technology </p>
                                        <p class="font-14px"> 17.18 By 2020, enhance capacity-building support to developing countries, including for least developed countries and small island developing States, to increase significantly the availability of high-quality, timely and reliable data disaggregated by income, gender, age, race, ethnicity, migratory status, disability, geographic location and other characteristics relevant in national contexts</p>
                                        </td>
                                </tr>

                                </tbody>
                            </table>
                       
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

    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/dashboard_sdg.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>include/assets/api_calls/sdg_details.js"></script>



<style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 100%;
            margin: 1.75rem auto;
        }
    }
</style>