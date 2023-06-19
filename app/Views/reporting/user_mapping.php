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
    #datadiv{
        width: 100%;
    }
</style>
<link href="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />




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
                                            <h3 class="title mb-0">User Mapping - <?php echo $role_name;?></h3>
                                        </div>
                                        <!-- <div class="">
                                            <a href="index.html" class="btn btn-light1 btn-sm"><img src="./assets/images/icon-left-arrow.svg"> Back</a>
                                        </div> -->
                                        <div class="">
                                        <a href="<?php echo base_url(); ?>reporting/user_management" class="btn btn-sm btn-success">Back</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <form id="submit_data">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> User Name </label> :  <h4><b><?php echo $tbl_users_list['first_name'];?> <?php echo $tbl_users_list['last_name'];?></b></h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group form-upload">
                                                        <label for=""> Select Country </label>
                                                        <select class="form-control country" name="country" >
                                                            <option value="">Select Country</option> 
                                                            <?php 
                                                            if(isset($tbl_users_list['country_id'])){
                                                                $user_country_id=$tbl_users_list['country_id'];
                                                            }else{
                                                                $user_country_id=0;
                                                            }
                                                            if(isset($tbl_users_list['county_id'])){
                                                                $user_county_id=$tbl_users_list['county_id'];
                                                            }else{
                                                                $user_county_id=0;
                                                            }
                                                            foreach ($lkp_country_list as $key => $option) { 
                                                                if($tbl_login_user['role_id']==6 || $tbl_login_user['role_id']==5 ){
                                                                    $selected="selected";
                                                                    if($user_country_id == $option['country_id']){
                                                                        ?>
                                                                        <option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    $selected="";
                                                                    if($user_country_id == $option['country_id']){
                                                                        $selected="selected";
                                                                    }
                                                                    ?>
                                                                <option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
                                                                <?php
                                                                }
                                                                    
                                                            } ?>
                                                        </select>
                                                        <span class="error" style="color:red"></span>
                                                    </div>
                                                </div>
                                                <?php if($tbl_users_list['role_id'] == 5){?>
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <div class="form-group form-upload">
                                                            <label for=""> Select Sub-national </label>
                                                            <select class="form-control county" name="county">
                                                                <option selected>Select Sub-national</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                                    <button type="button" class="btn btn-sm btn-success pull-right submit_data">Submit data</button>
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

    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    
    $(function() {
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
        var role_id=<?php echo $tbl_users_list['role_id']; ?>;
        if(role_id==5){
            $('[name="country"]').trigger('change');
        }
    });

    $('body').on('click', '.send_back', function(event) {
        var elem = $(this),
        modal = $('#sendBackModal'),
        backTo = elem.data('by'),
        recordId = elem.data('recordid');

        // Set values in modal
        modal.modal('show');
        modal.find('form')[0].reset();
        modal.find('#backTo').html(backTo);
        modal.find('form').data('id', recordId);
    });

    $('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        role_id= <?php echo $tbl_users_list['role_id']; ?>;
        $.ajax({
            url: "<?php echo base_url(); ?>reporting/get_countys",
            type: "POST",
            dataType: "json",
            data: {
                country_id: country_id,
                role_id: role_id,
                csrf_test_name: csrfHash
            },
            complete: function(data) {
                var csrfData = JSON.parse(data.responseText);
                csrfName = csrfData.csrfName;
                csrfHash = csrfData.csrfHash;
                if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                    $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                }
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
                            var selc_value='';
                                if(field.county_id==<?php echo $user_county_id;?>){
                                    selc_value='selected';
                                }
                            CHILD_HTML += '<option value = "' + field.county_id + '" '+selc_value+'>' + field.county_name + '</option>';
                        };
                        console.log(CHILD_HTML);
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


    $('body').on('click', '.submit_data', function() {
        $elem = $(this);
        $elem.prop('disabled', true);

        $('.error').html('');

        var form_id = "submit_data";
        var surveycount = 0;        

        if (surveycount == 0) {
            var indicatorform = new FormData($('#' + form_id)[0]);
            indicatorform.append('user_id', <?php echo $user_id;?>);
            indicatorform.append('role_id', <?php echo $role_id;?>);
            indicatorform.append('country_id', $('select[name="country"]').val());
            indicatorform.append('county_id', $('select[name="county"]').val());
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/update_user_country',
                type: 'POST',
                dataType: 'json',
                data: indicatorform,
                processData: false,
                contentType: false,
                error: function() {
                    $.toast({
                        heading: 'Warning!',
                        text: 'Please check your internet connection and try again.',
                        icon: 'error',
                        afterHidden: function() {
                            $elem.prop('disabled', false);
                        }
                    });
                },
                complete: function(data) {
                    var csrfData = JSON.parse(data.responseText);
                    csrfName = csrfData.csrfName;
                    csrfHash = csrfData.csrfHash;
                    if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                        $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                    }
                },
                success: function(response) {
                    if (response.status == 0) {
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error',
                            afterHidden: function() {
                                $elem.prop('disabled', false);
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Success!',
                            text: response.msg,
                            icon: 'success',
                            afterHidden: function() {
                                $('#' + form_id).each(function() {
                                    this.reset();
                                });
                                // location.reload(true);
                                // location.reload("<?php echo base_url(); ?>reporting/user_management");
                                window.location.href = "<?php echo base_url(); ?>reporting/user_management";
                            }
                        });
                    }
                }
            });
        } else {
            $elem.prop('disabled', false);
        }
    });

</script>