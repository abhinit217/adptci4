<style type="text/css">
    label {
        font-weight: bold;
    }

    th {
        color: #FFFFFF;
    }
    .app-content.page-body {
        margin-top: 6rem !important;
    }
    .img-height {
        height: 300px !important;
    }
</style>
<link href="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />


<!-- Edit Data Modal -->
<div class="modal fade" id="sendBackModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Send back query</h3>
            </div>

            <?php echo form_open('', array('id' => 'sendBackForm')); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Send Back To User - <span style="font-weight:500;" id="backTo"></span></label>
                </div>
                <div class="form-group">
                    <label for="reason">Query</label> <span class="text-danger">*</span>
                    <textarea id="query" placeholder="Provide query to send back..." class="form-control" name="query" rows="5" style="resize:vertical;"></textarea>
                    <span class="query error text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Send Back</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="app-content page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 pl-0 pr-0 mb-5">
                <div class="p-3 pl-0 bg-light border border-bottom-0">
                   
                    <div class="wrapper mt-3">
                        <div class="container-fluid">                            
                            <div class="card border-0 shadow">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <h3 class="title mb-0">Comparisons</h3>
                                        </div>
                                        <!-- <div class="">
                                            <a href="index.html" class="btn btn-light1 btn-sm"><img src="./assets/images/icon-left-arrow.svg"> Back</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <form id="submit_data">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                                    <div class="card border card-hover">
                                                        <div class="card-body p-1">
                                                            <img src="<?php echo base_url(); ?>/include/assets/images/Flag_of_Kenya.svg" class="w-100 img-height">
                                                        </div>
                                                        <div class="card-footer bg-white">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h4 class="title">Kenya Comparisons</h4>
                                                                </div>
                                                                <div>
                                                                    <!-- <a href="http://3.16.201.127/atpd/dashboard.html?countryId=1" class="goDim cursor"> <img src="<?php echo base_url(); ?>/include/assets/images/Arrow_Right.svg"></a> -->
                                                                    <a href="<?php echo base_url(); ?>reporting/comparisons/1" class="goDim cursor"> <img src="<?php echo base_url(); ?>/include/assets/images/Arrow_Right.svg"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                                    <div class="card border card-hover">
                                                        <div class="card-body p-1">
                                                            <img src="<?php echo base_url(); ?>/include/assets/images/Flag_of_Ethiopia.svg" class="w-100 img-height">
                                                        </div>
                                                        <div class="card-footer bg-white">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h4 class="title">Ethiopia Comparisons</h4>
                                                                    </div>
                                                                <div>
                                                                    <!-- <a href="http://3.16.201.127/atpd/dashboard.html?countryId=2" class="goDim cursor"> <img src="<?php echo base_url(); ?>/include/assets/images/Arrow_Right.svg"></a> -->
                                                                    <a href="<?php echo base_url(); ?>reporting/comparisons/3" class="goDim cursor"> <img src="<?php echo base_url(); ?>/include/assets/images/Arrow_Right.svg"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                                    <div class="card border card-hover">
                                                        <div class="card-body p-1">
                                                            <img src="<?php echo base_url(); ?>/include/assets/images/Flag_of_Uganda.svg" class="w-100 img-height">
                                                        </div>
                                                        <div class="card-footer bg-white">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h4 class="title">Uganda Comparisons</h4>
                                                                    </div>
                                                                <div>
                                                                    <!-- <a href="http://3.16.201.127/atpd/dashboard.html?countryId=3" class="goDim cursor"> <img src="<?php echo base_url(); ?>/include/assets/images/Arrow_Right.svg"></a> -->
                                                                    <a href="<?php echo base_url(); ?>reporting/comparisons/2" class="goDim cursor"> <img src="<?php echo base_url(); ?>/include/assets/images/Arrow_Right.svg"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end app-content-->
</div>

<script src="<?php echo base_url(); ?>include/assets/plugins/sisyphus/sisyphus.min.js"></script>
<script src="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/jquery.richtext.js"></script>
<script type="text/javascript">
    
    $(function() {
        // Initialize Sisyphus
        // $("#submit_data").sisyphus();
        // $('.default_indicatorcomment').trigger('change');

        //Date picker
        $('.picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        //month picker
        $('.monthpicker').datepicker({
            format: 'yyyy-mm',
            autoclose: true,
            viewMode: "months",
            minViewMode: "months"
        });

        $('#textarea_1').richText();

    });

    $('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_countys",
            type: "POST",
            dataType: "json",
            data: {
                country_id: country_id
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
    });
    
    $('body').on('change', '.dimension', function() {
        $elem = $(this);
        dimensions_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_subdimensions",
            type: "POST",
            dataType: "json",
            data: {
                dimensions_id: dimensions_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_sub_dimensions_list.length > 0) {
                        var CHILD_HTML = '';
                        CHILD_HTML += '<option value = "">Select Sub-Dimension</option>';
                        for (var field of response.result.lkp_sub_dimensions_list) {
                            CHILD_HTML += '<option value = "' + field.sub_dimensions_id + '">' + field.sub_dimensions_name + '</option>';
                        };
                        $('.subdimension').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    $('body').on('change', '.subdimension', function() {
        $elem = $(this);
        sub_dimensions_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_category",
            type: "POST",
            dataType: "json",
            data: {
                sub_dimensions_id: sub_dimensions_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_categories_list.length > 0) {
                        var CHILD_HTML = '';
                        
                        for (var field of response.result.lkp_categories_list) {
                            CHILD_HTML += '<option value = "' + field.categories_id + '">' + field.categories_name + '</option>';
                        };
                        $('.category').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });

    $('body').on('change', '.category', function() {
        $elem = $(this);
        category_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicators",
            type: "POST",
            dataType: "json",
            data: {
                category_id: category_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicators_list.length > 0) {
                        var CHILD_HTML = '';
                        
                        for (var field of response.result.lkp_indicators_list) {
                            CHILD_HTML += '<option value = "' + field.indicator_id + '">' + field.indicator_name + '</option>';
                        };
                        $('.indicators').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });

    $('body').on('change', '.indicators', function() {
        $elem = $(this);
        indicator_id= this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_indicator_data",
            type: "POST",
            dataType: "json",
            data: {
                indicator_id: indicator_id
            },
            error: function() {
                // setTimeout(function() {
                //     $('.' + classname).empty();
                // }, 500);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.result.lkp_indicator_data_list.length > 0) {
                        var CHILD_HTML = '';
                        CHILD_HTML += '<table class="table datatable">\
                            <thead>\
                                <th>Year</th>\
                                <th>Country</th>\
                                <th>County</th>\
                                <th>Actual Value</th>\
                                <th>Actions</th>\
                            </thead>\
                            <tbody>';
                            
                        for (var field of response.result.lkp_indicator_data_list) {
                            CHILD_HTML += '<tr><td>' + field.year + '</td><td>' + field.country_name + '</td><td>' + field.county_name + '</td><td>' + field.	actual_value + '</td><td><a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '" target="_blank">Edit data</a>|<a href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '" class="btn btn-sm btn-success" target="_blank">Approve</span></a>|<a href="<?php echo base_url(); ?>reporting/edit_data/' + field.id + '" target="" class="btn btn-sm btn-danger">Rejecte</a></td></tr>';
                        };
                        CHILD_HTML += '</tbody>\
                        </table>';
                        $('#datadiv').html(CHILD_HTML);
                    }
                } else {
                        // setTimeout(function() {
                        //     $('.' + classname).empty();
                        // }, 500);
                }
            }
        });
    });
    
    

</script>