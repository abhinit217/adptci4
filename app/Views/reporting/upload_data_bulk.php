<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" />


    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
        .navbar-brand img {
            height: 55px;
        }

        .border-right {
            border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
            height: 50px;
        }

       
        .bg-dark {
            background: #FFFFFF !important;
            box-shadow: 0 2px 4px 0 rgb(0 0 0 / 20%);
        }
        .navbar-dark .navbar-nav .active>.nav-link, .navbar-dark .navbar-nav .nav-link.active, .navbar-dark .navbar-nav .nav-link.show, .navbar-dark .navbar-nav .show>.nav-link {
            color: #0B9444 !important;
            border-bottom: 3px solid #0B9444;
            font-weight: 600;
        }
        .navbar-dark .navbar-nav .nav-link {
            font-size: 14px;
            color: #0B9444;
            line-height: 50px;
            padding: 0px 20px;
            font-weight: 400;
            text-transform: uppercase;
        }
        .navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link:hover {
            color: #0B9444;
        }

        a {
            text-decoration: none !important;
        }

        /* sagar upto */

        .tree li {
            list-style-type: none;
            margin: 0;
            padding: 10px 5px 0 5px;
            position: relative
        }

        .tree li::before,
        .tree li::after {
            content: '';
            left: -20px;
            position: absolute;
            right: auto
        }

        .tree li::before {
            border-left: 1px solid #0003;
            bottom: 50px;
            height: 100%;
            top: 0;
            width: 1px
        }

        .tree li::after {
            border-top: 1px solid #0003;
            height: 20px;
            top: 25px;
            width: 25px
        }

        .tree li span {
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            border: 0px solid #0003;
            border-radius: 3px;
            display: inline-block;
            padding: 3px 8px;
            text-decoration: none;
            /* cursor: pointer; */
        }

        .tree>ul>li::before,
        .tree>ul>li::after {
            border: 0
        }

        .tree li:last-child::before {
            height: 27px
        }

        .w-115px {
            width: 115px;

        }

        /* .tree li span:hover {
    background: hotpink;
    border:2px solid #94a0b4;
    } */

        [aria-expanded="false"]>.expanded,
        [aria-expanded="true"]>.collapsed {
            display: none;
        }

        .text-data {
            color: #004b03;
        }
    </style>
</head>

<body>
    <div class="wrapper mt-3">
        <div class="container-fluid">
            <div class="card border-0 shadow">
                <div class="card-header bg-white mt-8">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <h3 class="title mb-0">Bulk Upload </h3>
                        </div>
                        <!-- <div class="">
                            <a href="javascript:void(0);" class="btn btn-light1 btn-sm"><img
                                    src="./assets/images/icon-left-arrow.svg"> Back</a>
                        </div> -->
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="form">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group form-upload">
                                            <label for=""> Select Measurement level </label>
                                            <select class="form-control measure_level" name="measure_level" id="measure_level">
                                                <option>Select Measurement level </option>
                                                <?php foreach ($lkp_level_measurement as $key => $option) { ?>
                                                    <option value="<?php echo $option['level_m_id']; ?>" <?php if($measure_level_id ==$option['level_m_id']){ echo "selected";}?> ><?php echo $option['level_m_name']; ?></option> 
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group form-upload">
                                    <label for=""> Select Year </label>
                                    <select class="form-control" name="year">
                                        <option>Select Year</option>
                                        <?php foreach ($lkp_year_list as $key => $option) { ?>
                                            <option value="<?php echo $option['year_id']; ?>"><?php echo $option['year']; ?></option> <?php
                                                                                                                                    } ?>
                                    </select>
                                </div>
                            </div>
                           <?php 
                            if($measure_level_id !=1){
                            ?>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group form-upload">
                                    <label for=""> Select Country </label>
                                    <select class="form-control country" name="country">
                                        <option>Select Country</option>
                                        <?php foreach ($lkp_country_list as $key => $option) { ?>
                                            <option value="<?php echo $option['country_id']; ?>"><?php echo $option['country_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php 
                                }
                            ?>

                            <div class="col-sm-12 col-md-4 col-lg-4 sub_national" id="sub_national">
                                <div class="form-group form-upload">
                                <?php 
                                    $county_id = $lkp_user_list['country_id'];
                                        switch ($county_id) {
                                            case '1':
                                                # code...
                                                $county_name="County";
                                                break;

                                            case '2':
                                                # code...
                                                $county_name="Zone";
                                                break;

                                            case '3':
                                                # code...
                                                $county_name="District";
                                                break;
                                            
                                            default:
                                                # code...
                                                $county_name="County / Zone / District";
                                                break;
                                        }
                                        ?>
                                    <label for=""> Select <?php echo $county_name;?> </label>
                                    <select class="form-control county" name="county">
                                        <option>Select <?php echo $county_name;?> </option>

                                    </select>
                                </div>
                            </div>
                        </div>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 pl-0">
                <div class="tree ml-8">
                    <ul>
                        <?php foreach ($lkp_dimensions_list as $key => $dimension) { ?>
                            <li>
                                <span>
                                    <a class="text-data" data-toggle="collapse" href="#d_<?php echo $dimension['dimensions_id']; ?>"> <?php echo $dimension['dimensions_name']; ?></a>
                                </span>
                                <div id="d_<?php echo $dimension['dimensions_id']; ?>" class="collapse show">
                                    <ul>
                                        <?php foreach ($lkp_sub_dimensions_list as $key => $subdimension) {
                                            if ($subdimension['dimensions_id'] == $dimension['dimensions_id']) { ?>
                                                <li>
                                                    <span>
                                                        <a class="text-data" data-toggle="collapse" href="#s_d_<?php echo $subdimension['sub_dimensions_id']; ?>" aria-expanded="false" aria-controls="s_d_<?php echo $subdimension['sub_dimensions_id']; ?>"><?php echo $subdimension['sub_dimensions_name']; ?></a>
                                                    </span>
                                                    <div id="s_d_<?php echo $subdimension['sub_dimensions_id']; ?>" class="collapse show">
                                                        <ul>
                                                            <?php foreach ($lkp_categories_list as $key => $category) {
                                                                if ($subdimension['sub_dimensions_id'] == $category['sub_dimensions_id']) { ?>
                                                                    <li>
                                                                        <span>
                                                                            <a class="text-data" data-toggle="collapse" href="#c_<?php echo $category['categories_id']; ?>" aria-expanded="false" aria-controls="c_<?php echo $category['categories_id']; ?>"> <?php echo $category['categories_name']; ?></a>
                                                                        </span>
                                                                        <div id="c_<?php echo $category['categories_id']; ?>" class="collapse show">
                                                                            <ul>
                                                                            <?php foreach ($lkp_indicators_list as $key => $indicator) {
                                                                                        if ($category['categories_id'] == $indicator['lkp_category_id']) { ?>
                                                                                <li>
                                                                                    <span>
                                                                                        <a class="text-data" data-toggle="collapse" href="#i_<?php echo $indicator['indicator_id']; ?>" aria-expanded="false" aria-controls="i_<?php echo $indicator['indicator_id']; ?>"> <strong><?php echo $indicator['indicator_name']; ?> </strong>  
                                                                                        <!-- <?php if(isset($indicator['description'])){
                                                                                            ?>
                                                                                            <i class="fa fa-info-circle text-dark" title=" "></i>
                                                                                        <?php 
                                                                                        }?> -->
                                                                                        </a><i class="fa fa-info-circle text-dark" data-toggle="popover" title="Indicator Info" data-content="( <b>About Indicator</b> - <?php echo preg_replace('/\s+/', ' ', $indicator['description'])?> , Unit of measurement - <?php echo $indicator['m_unit_name']?>)"></i>
                                                                                    </span>
                                                                                    <div id="i_<?php echo $indicator['indicator_id']; ?>" class="collapse show">
                                                                                        <ul>
                                                                                            <li>
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                                                                        <span class="w-115px">Actual Data:</span>
                                                                                                        <span class="w-100">
                                                                                                            <input type="text" class="form-control" name="<?php echo $indicator['indicator_id']; ?>_actual">
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                                                                        <span class="w-130px">Data sources: </span>
                                                                                                        <span class="w-100">
                                                                                                            <textarea class="form-control" name="<?php echo $indicator['indicator_id']; ?>_d_source" row="4"></textarea>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                                                                        <span class="w-115px">Data sets: </span>
                                                                                                        <span class="w-100">
                                                                                                            <textarea class="form-control" name="<?php echo $indicator['indicator_id']; ?>_d_sets" row="4"></textarea>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                                                                        <span class="w-115px">Remarks: </span>
                                                                                                        <span class="w-100">
                                                                                                            <textarea class="form-control" name="<?php echo $indicator['indicator_id']; ?>_remarks" row="4"></textarea>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </li>
                                                                                <?php
                                                                                    }
                                                                                } ?>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                            <?php
                                                                }
                                                            } ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-6">
                <a  href="<?php echo base_url();?>reporting/bulk_preview" class="btn btn-sm btn-success pull-right submit_data">Preview</a>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-6">
                <!-- <button type="button" href="<?php echo base_url();?>/" class="btn btn-sm btn-success center "> << Back</button> -->
                <a  href="<?php echo base_url();?>/reporting/upload_data_bulk" class="btn btn-sm btn-success submit_data">Submit</a>
            </div>
        </div>
        
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();   
    });
    $('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        measure_level= $('select[name="measure_level"]').val();
        if(measure_level!=1){
            role_id= <?php echo $lkp_user_list['role_id']; ?>;
            $.ajax({
                url: "<?php echo base_url(); ?>reporting/get_countys",
                type: "POST",
                dataType: "json",
                data: {
                    country_id: country_id,
                    role_id: role_id
                },
                error: function() {
                    // setTimeout(function() {
                    //     $('.' + classname).empty();
                    // }, 500);
                },
                success: function(response) {
                    if (response.status == 1) {
                        if (response.result.lkp_county_list.length > 0) {
                            var CHILD_HTML = '';
                            for (var field of response.result.lkp_county_list) {
                                CHILD_HTML += '<option value = "' + field.county_id + '">' + field.county_name + '</option>';
                            };
                            $('.county').html(CHILD_HTML);
                        }
                    } else {
                            // setTimeout(function() {
                            //     $('.' + classname).empty();
                            // }, 500);
                    }
                }
            });
        }
    });
    $('body').on('change', '.measure_level', function() {
        // $elem = $(this);
        // measure_level= this.value;
        // if(measure_level==1){
        //     $('.sub_national').hide();
        // }else{
        //     $('.sub_national').show();
        // }
        $elem = $(this);
        measure_level= this.value;
        window.location = "<?php echo base_url(); ?>/Reporting/upload_data_bulk/"+measure_level;

    });
</script>

</html>