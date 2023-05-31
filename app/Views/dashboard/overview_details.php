<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
<style type="text/css">
	.form-control button {
		border: none !important;
	}
	.stricky{
		position: fixed;
		top: 63px;
		width: 100%;
		z-index: 111;
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

    .mt-145px {
            margin-top: 160px!important;
        }
    .minh-210{
        min-height: 210px;
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
    .mt-100px{
        margin-top: 100px;
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
    .bordered, .text-wrap table, .table-bordered th, .text-wrap table th, .table-bordered td, .text-wrap table td {
    border: 2px solid #fff;
}
    .table>tbody>tr>th {
    font-weight: 700;
    -webkit-transition: all .3s ease;
    font-size: 17px;
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
                                        <div class="col-sm-12 col-md-11 col-lg-11">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Clusters</label>
                                                    <select multiple="multiple" title="Clusters" id="filter-clusters" ></select>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Crops</label>
                                                    <select multiple="multiple" title="Crops" id="filter-crops"></select>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Countries</label>
													<select multiple="multiple" title="Countries" id="filter-countries"></select>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <label class="text-white">Years</label>
													<select multiple="multiple" title="Years" id="filter-years"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1 col-lg-1 mt-5">
                                            <button class="btn btn_apply mt-2" id="overview-submit">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          

            <div class="row mt-145px mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card shadow border-0 mt-3">
                        <div class="card-body">
                            <h3 class="text_title mb-2">Farmers reached through ICRISAT interventions and technologies</h3>

                            <div class="row">
                                <div class="col-sm-12 col-md-7 col-lg-7">
                                   <div class="row">
                                       <div class="col--sm-12 col-md-8 col-lg-8">
                                           <h4 class="text_title mb-2">Country-wise</h4>
                                           <div class="" id="country_region" style="width:100%;height: 300px;"></div>
                                       </div>
                                       <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="mt-100px">
                                                <h3 class="text_title">Farmers</h3>
                                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="align-items-start">
                                                        <h2 class="font-24px">9.1 M</h2>
                                                        <p class="mb-0 text_small">Total Farmer</p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text_pos1">________ <span>28%</span></p>
                                                        <p class="mb-0"><img src="<?php echo base_url(); ?>include/assets/images/female.png"></p>
                                                        <p class="mb-0 text_small">Female</p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text_pos2"> <span>72%</span>________</p>
                                                        <p class="mb-0"><img src="<?php echo base_url(); ?>include/assets/images/male.png"></p>
                                                        <p class="mb-0 text_small">MALE</p>
                                                    </div>
                                                    <div class="pr-4">
                                                        <p class="mb-0 text_pos text-center"> <span>42%</span></p>
                                                        <p class="mb-0"><img src="<?php echo base_url(); ?>include/assets/images/youth.svg"></p>
                                                        <p class="mb-0 text_small">Youth</p>
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                </div>
        
                                <div class="col-sm-12 col-md-5 col-lg-5">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                                <tr>
                                                    <td class="light_bg">RFSS 1.3.2 : Number of communities involved in pilots of climet-smart innovations and approaches</td>
                                                    <th class="dark_bg">35,000</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">Region-wise</h4>
                                           <div class="" id="region_wise" style="width:100%;height: 300px;"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                <h4 class="text_title mb-2">Program-wise</h4>
                                           <div class="" id="program_wise" style="width:100%;height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


	
    </div>
</div>



<script>
        Highcharts.chart('country_region', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Country 1', 'Country 2', 'Country 3', 'Country 4', 'Country 5']
            },
            yAxis: {
                min: 0,
                title: {
                text: ''
                }
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Compare 1',
                data: [5, 3, 4, 7, 2],
                color: '#fda94f',
            }, {
                name: 'Compare 2',
                data: [2, 2, 3, 2, 1],
                color: '#ee948b',
            }]
            });
    </script>

<script>
        Highcharts.chart('region_wise', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Region 1', 'Region 2', 'Region 3', 'Region 4', 'Region 5']
            },
            credits: {
                enabled: false
            },
            yAxis: {
                min: 0,
                title: {
                text: ''
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Compare 1',
                data: [5, 3, 4, 7, 2],
                color: '#fda94f',
            }, {
                name: 'Compare 2',
                data: [2, 2, 3, 2, 1],
                color: '#ee948b',
            }]
            });
    </script>

<script>
        Highcharts.chart('program_wise', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Program 1', 'Program 2', 'Program 3', 'Program 4', 'Program 5']
            },
            yAxis: {
                min: 0,
                title: {
                text: ''
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled:false
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Compare 1',
                data: [5, 3, 4, 7, 2],
                color: '#fda94f',
            }, {
                name: 'Compare 2',
                data: [2, 2, 3, 2, 1],
                color: '#ee948b',
            }]
            });
    </script>