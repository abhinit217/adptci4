<div class="wrapper mt-8">
    <div class="container-fluid">
        <div class="card border-0 shadow">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h3 class="title mb-0">Bulk Upload</h3>
                    </div>
                    <div class="">
                        <a href="<?php echo base_url();?>/reporting/bulk_preview"  class="btn btn-sm btn-success"> Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <form id="submit_form_data" >
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group form-upload">
                                                <label for=""> Select Measurement level </label>
                                                <select class="form-control measure_level" name="measure_level" id="measure_level">
                                                    <option value="0">Select Measurement level </option>
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
                                        <select class="form-control year" name="year" id="year">
                                            <option value="0">Select Year</option>
                                            <?php foreach ($lkp_year_list as $key => $option) { ?>
                                                <option value="<?php echo $option['year_id']; ?>" <?php if($year ==$option['year_id']){ echo "selected";}?>><?php echo $option['year']; ?></option> <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group form-upload">
                                        <label for=""> Select Country </label>
                                        <select class="form-control country" name="country" >
                                            <option value="">Select Country</option>
                                            <?php foreach ($lkp_country_list as $key => $option) { 
                                                if($lkp_user_list['role_id']==6 || $lkp_user_list['role_id']==5){
                                                    $selected="selected";
                                                    if($lkp_user_list['country_id'] == $option['country_id']){
                                                        ?>
                                                        <option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
                                                        <?php
                                                    }
                                                }else{
                                                    $selected="";
                                                    if($country == $option['country_id'] or $key == 0){
                                                        $selected="selected";
                                                    } ?>
                                                    <option value = "<?php echo $option['country_id']; ?>" <?php echo $selected;?>><?php echo $option['country_name']; ?></option> 
                                                <?php }
                                            } ?>
                                        </select>
                                        <span class="error" style="color:red"></span>
                                    </div>
                                </div>
                                <?php if($measure_level_id !=1){ ?>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <?php 
                                        $county_id = $lkp_user_list['country_id'];
                                        switch ($county_id) {
                                            case '1':
                                                $county_name="County";
                                                break;

                                            case '2':
                                                $county_name="District";
                                                break;

                                            case '3':
                                                $county_name="Zone";
                                                break;

                                            default:
                                                $county_name="County / Zone / District";
                                                break;
                                        } ?>
                                        <div class="form-group form-upload sub_national" id="sub_national">
                                            <label for=""> Select <?php echo $county_name;?> </label>
                                            <select class="form-control county" name="county">
                                                <option value="" selected>Select <?php echo $county_name;?></option>
                                            </select>
                                            <span class="error" style="color:red"></span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive">
                                <?php 
                                if($measure_level_id == 0 && $year == 0 && $country == 0 ){
                                    ?>
                                    <div>Please select Measurement level, Year , Country </div>                                
                                    <?php                                     
                                }else if($year ==0 || $country ==0){
                                    ?>
                                    <div>Please select Year , Country </div>                                
                                    <?php
                                }else if($country ==0){
                                    ?>
                                    <div>Please select Country</div>                                
                                    <?php
                                }else{
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-header bg-light">
                                                <th width="180px">Dimension </th>
                                                <th width="180px">Sub Dimension </th>
                                                <th width="180px">Category </th>
                                                <th width="180px">Indicator </th>
                                                <th nowrap width="160px">Enter Value</th>
                                                <th nowrap width="160px">Data sources</th>
                                                <th nowrap width="240px">Data set</th>
                                                <th nowrap>Remarks</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-bordered">
                                        <?php 
                                        foreach ($lkp_dimensions_list as $key1 => $dimension) {
                                            //search for indicator this dimensionid exists or not if not hide
                                            $item='relation_id';
                                            $match = array('lkp_dimension_id' => $dimension['dimensions_id']);
                                            $key = array_keys($match);
                                            $key = $key[0];
                                            $nextrow=0;
                                            foreach ($lkp_indicators_list as $row)
                                            {		
                                                // print_r($row['lkp_dimension_id']);exit();
                                                if(trim($row['lkp_dimension_id']) == trim($match[$key]))
                                                {
                                                    $nextrow=1;
                                                }

                                            }
                                            if($nextrow==1){?>
                                                <tr>

                                                    <td class="tbl_font " width="160px"><?php echo $dimension['dimensions_name']; ?> </td>
                                                    <td class="tbl_font">
                                                        <?php foreach ($lkp_sub_dimensions_list as $key => $subdimension) {
                                                        //search for indicator this category exists or not if not hide
                                                            $item='relation_id';
                                                            $match = array('lkp_subdimension_id' => $subdimension['sub_dimensions_id']);
                                                            $key = array_keys($match);
                                                            $key = $key[0];
                                                            $nextrow1=0;
                                                            foreach ($lkp_indicators_list as $row)
                                                            {	
                                                                if(trim($row['lkp_subdimension_id']) == trim($match[$key]))
                                                                {
                                                                    $nextrow1=1;
                                                                }
                                                                
                                                            }
                                                            if($nextrow1==1){
                                                                if ($subdimension['dimensions_id'] == $dimension['dimensions_id']) { ?>
                                                                    <table class="">
                                                                        <tr>
                                                                            <td class="tbl_font" width="160px"><?php echo $subdimension['sub_dimensions_name']; ?></td>
                                                                            <td class="tbl_font">   
                                                                                <?php foreach ($lkp_categories_list as $key => $category) {
                                                                            //search for indicator this category exists or not if not hide
                                                                                    $item='relation_id';
                                                                                    $match = array('lkp_category_id' => $category['categories_id']);
                                                                                    $key = array_keys($match);
                                                                                    $key = $key[0];
                                                                                    $nextrow2=0;
                                                                                    foreach ($lkp_indicators_list as $row)
                                                                                    {	
                                                                                        if(trim($row['lkp_category_id']) == trim($match[$key]))
                                                                                        {
                                                                                            $nextrow2=1;
                                                                                        }

                                                                                    }
                                                                                    if($nextrow2==1){
                                                                                        if ($subdimension['sub_dimensions_id'] == $category['sub_dimensions_id']) { ?>
                                                                                            <table class="">
                                                                                                <tr>
                                                                                                    <td class="tbl_font" width="160px"><?php echo $category['categories_name']; ?></td>
                                                                                                    <td class="tbl_font">
                                                                                                        <?php foreach ($lkp_indicators_list as $key => $indicator) {
                                                                                                            if ($category['categories_id'] == $indicator['lkp_category_id']) { 
                                                                                                                if(isset($form_id_data_array[$indicator['indicator_id']][0])){
                                                                                                                    $actual_value=$form_id_data_array[$indicator['indicator_id']][0];
                                                                                                                }else{
                                                                                                                    $actual_value="";
                                                                                                                }

                                                                                                                if(isset($form_id_data_array[$indicator['indicator_id']][1])){
                                                                                                                    $data_source=$form_id_data_array[$indicator['indicator_id']][1];
                                                                                                                }else{
                                                                                                                    $data_source="";
                                                                                                                }

                                                                                                                if(isset($form_id_data_array[$indicator['indicator_id']][2])){
                                                                                                                    $remarks=$form_id_data_array[$indicator['indicator_id']][2];
                                                                                                                }else{
                                                                                                                    $remarks="";
                                                                                                                }
                                                                                                                if(isset($form_id_data_array[$indicator['indicator_id']][3])){
                                                                                                                    $file_url=$form_id_data_array[$indicator['indicator_id']][3];
                                                                                                                }else{
                                                                                                                    $file_url="";
                                                                                                                }
                                                                                                                ?>
                                                                                                                <table class="">
                                                                                                                    <input type="hidden" name="<?php echo $indicator['indicator_id']; ?>_dimensions_id" value="<?php echo $dimension['dimensions_id'];?>"/>
                                                                                                                    <input type="hidden" name="<?php echo $indicator['indicator_id']; ?>_subdimensions_id" value="<?php echo $subdimension['sub_dimensions_id'];?>"/>
                                                                                                                    <input type="hidden" name="<?php echo $indicator['indicator_id']; ?>_category_id" value="<?php echo $category['categories_id'];?>"/>
                                                                                                                    <tr>
                                                                                                                        <td class="tbl_font" width="200px"><?php echo $indicator['indicator_name']; ?> <i class="fa fa-info-circle text-dark" data-toggle="popover" title="Indicator Info" data-content=" <b>About Indicator</b> - <?php echo preg_replace('/\s+/', ' ', $indicator['description'])?> </br> <b>Unit of measurement</b> - <?php echo $indicator['m_unit_name']?>" data-html="true"></i></td>
                                                                                                                        <td class="tbl_font evalue" width="148px">
                                                                                                                            <div class="form-group">
                                                                                                                                <span class="w-115px">Enter Value: </span>
                                                                                                                                <?php 
                                                                                                                                switch ($indicator['lkp_value_type']) {
                                                                                                                                    case '1':
                                                                                                                                        $sel_value0="";
                                                                                                                                        $sel_value1="";
                                                                                                                                        if($actual_value ==0){
                                                                                                                                            $sel_value0="selected";
                                                                                                                                        }
                                                                                                                                        if($actual_value ==1){
                                                                                                                                            $sel_value1="selected";
                                                                                                                                        }
                                                                                                                                        $field_value = '<select name="'.$indicator['indicator_id'].'_actual" class="form-control" value="'.$actual_value.'">
                                                                                                                                        <option value="">select value</option>
                                                                                                                                        <option value="0" '.$sel_value0.'>0</option>
                                                                                                                                        <option value="1" '.$sel_value1.'>1</option>
                                                                                                                                        </select>
                                                                                                                                        ';
                                                                                                                                        break;

                                                                                                                                    case '2':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-maxlength="100" data-minlength="1" data-subtype="desimal">';
                                                                                                                                        break;

                                                                                                                                    case '3':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-minlength="1" data-maxlength="365" data-subtype="number">';
                                                                                                                                        break;

                                                                                                                                    case '4':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-minlength="1" data-maxlength="70" data-subtype="desimal">';
                                                                                                                                        break;

                                                                                                                                    case '5':
                                                                                                                                        $sel_value0="";
                                                                                                                                        $sel_value1="";
                                                                                                                                        if($actual_value ==0){
                                                                                                                                            $sel_value0="selected";
                                                                                                                                        }
                                                                                                                                        if($actual_value ==1){
                                                                                                                                            $sel_value1="selected";
                                                                                                                                        }
                                                                                                                                        $field_value = '<select name="'.$indicator['indicator_id'].'_actual" class="form-control" value="'.$actual_value.'">
                                                                                                                                        <option value="">select value</option>
                                                                                                                                        <option value="1">1</option>
                                                                                                                                        <option value="2">2</option>
                                                                                                                                        <option value="3">3</option>
                                                                                                                                        <option value="4">4</option>
                                                                                                                                        <option value="5">5</option>
                                                                                                                                        </select>
                                                                                                                                        ';
                                                                                                                                        break;

                                                                                                                                    case '6':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-minlength="0" data-subtype="number">';
                                                                                                                                        break;

                                                                                                                                    case '7':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-minlength="1" data-subtype="number">';
                                                                                                                                        break;

                                                                                                                                    case '8':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-minlength="1000" data-subtype="number">';
                                                                                                                                        break;

                                                                                                                                    case '9':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'" data-maxlength="3000" data-subtype="desimal">';
                                                                                                                                        break;

                                                                                                                                    case '10':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'"  data-subtype="number">';
                                                                                                                                        break;

                                                                                                                                    case '11':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'"  data-subtype="number">';
                                                                                                                                        break;

                                                                                                                                    case '12':
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'"  data-subtype="desimal">';
                                                                                                                                        break;

                                                                                                                                    case '13':
                                                                                                                                        $sel_value0="";
                                                                                                                                        $sel_value1="";
                                                                                                                                        if($actual_value ==0 && $actual_value!=""){
                                                                                                                                            $sel_value0="checked";
                                                                                                                                        }
                                                                                                                                        if($actual_value ==1){
                                                                                                                                            $sel_value1="checked";
                                                                                                                                        }
                                                                                                                                        $field_value = '<br/><div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label class="" ><input type="radio" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="1" '.$sel_value1.' data-subtype="desimal">Yes</label></div>
                                                                                                                                        <div class="col-sm-12 col-md-6 col-lg-6"><label class="" ><input type="radio" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="0" '.$sel_value0.' data-subtype="desimal">No</label></div></div>';
                                                                                                                                        break;

                                                                                                                                    default:
                                                                                                                                        $field_value = '<input type="number" class="form-control" name="'.$indicator['indicator_id'].'_actual" value="'.$actual_value.'">';
                                                                                                                                        break;
                                                                                                                                } ?>
                                                                                                                                <span class="w-100">
                                                                                                                                    <?php echo $field_value ?>
                                                                                                                                </span>
                                                                                                                                <p class="error red-800"></p>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td class="tbl_font" >
                                                                                                                            <span class="w-130px">Data sources: <i class="fa fa-info-circle text-dark" data-toggle="popover" title="Data source Info" data-content="Info coming Soon"></i></span>
                                                                                                                            <span class="w-100">
                                                                                                                                <textarea class="form-control" name="<?php echo $indicator['indicator_id']; ?>_d_source" row="4"><?php echo $data_source?></textarea>

                                                                                                                            </span>
                                                                                                                        </td>
                                                                                                                        <td class="tbl_font" width="250px">
                                                                                                                            <span class="w-115px">Data sets: </span>
                                                                                                                            <span class="w-100">
                                                                                                                                <!-- <textarea class="form-control" name="<?php echo $indicator['indicator_id']; ?>_d_sets" row="4"></textarea> -->
                                                                                                                                <input type="file" class=" mt-3" name="<?php echo $indicator['indicator_id']; ?>_d_sets" id="d_sets" onchange="pressed()" value=""/>
                                                                                                                                <?php if($file_url==""){
                                                                                                                // skip if empty
                                                                                                                                }else{
                                                                                                                                    ?>
                                                                                                                                    <div class="file_link" id="file_link"><a class="form-control" href="<?php echo base_url();?>upload/survey/<?php echo $file_url; ?>"><?php echo $file_url; ?></a></div>
                                                                                                                                    <?php 
                                                                                                                                }?>

                                                                                                                            </span>
                                                                                                                        </td>
                                                                                                                        <td class="tbl_font">
                                                                                                                            <span class="w-115px">Remarks: </span>
                                                                                                                            <span class="w-100">
                                                                                                                                <textarea class="form-control" name="<?php echo $indicator['indicator_id']; ?>_remarks" row="4"><?php echo $remarks?></textarea>
                                                                                                                            </span>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </table>  
                                                                                                                <?php
                                                                                                            }
                                                                                                        } ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table> 
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                } ?>
                                                                            </td>   
                                                                        </tr>
                                                                    </table>
                                                                    <?php
                                                                }
                                                            }
                                                        } ?>
                                                    </td>   
                                                </tr>
                                                <?php 
                                            }
                                        } ?>
                                        
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-5">

                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-7">
                                        <a  href="<?php echo base_url();?>/include/excelformat/2017_Dummy_trial.xlsx" class="btn btn-sm btn-success ">Download</a>
                                        <!-- <a  href="<?php echo base_url();?>/reporting/bulk_preview" class="btn btn-sm btn-success submit_data">Submit data</a> -->
                                        <button type="button" class="btn btn-sm btn-success submit_data">Submit data</button>
                                    </div>
                                </div>
                                <div class="row"><br/>
                                </div>
                                <?php
                            }?>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
</div>

<script>

    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    $(document).ready(function(){
        $('[name="country"]').trigger('change');
        $('[data-toggle="popover"]').popover();        
    });

    $('body').on('change', '.country', function() {
        $elem = $(this);
        country_id= this.value;
        measure_level= $('select[name="measure_level"]').val();
        if(measure_level != 1){
            role_id= <?php echo $lkp_user_list['role_id']; ?>;
            $.ajax({
                url: "<?php echo base_url(); ?>reporting/get_countys",
                type: "POST",
                dataType: "json",
                data: {
                    country_id: country_id,
                    role_id: role_id,
                    csrf_test_name: csrfHash
                },
                error: function() {
                    // setTimeout(function() {
                    //     $('.' + classname).empty();
                    // }, 500);
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
                    if (response.status == 1) {
                        if (response.result.lkp_county_list.length > 0) {
                            var CHILD_HTML = '';
                            var countyval=<?php echo $county;?>;
                            var selstatus="";
                            for (var field of response.result.lkp_county_list) {
                                if(countyval==field.county_id){
                                    selstatus="selected";
                                }else{
                                    selstatus="";
                                }
                                CHILD_HTML += '<option value = "' + field.county_id + '" ' + selstatus + '>' + field.county_name + '</option>';
                            };
                            $('.county').html(CHILD_HTML);
                        }
                    }
                }
            });
        }
    });

    $('body').on('change', '.measure_level', function() {
        $elem = $(this);
        measure_level= this.value;
        year= $('select[name="year"]').val();
        country= $('select[name="country"]').val();
        county= $('select[name="county"]').val();
        window.location = "<?php echo base_url(); ?>reporting/bulk_preview/"+measure_level+"/"+year+"/"+country+"/"+county;
    });

    $('body').on('change', '.year', function() {
        $elem = $(this);
        measure_level= $('select[name="measure_level"]').val();
        year= this.value;
        country= $('select[name="country"]').val();
        county= $('select[name="county"]').val();
        window.location = "<?php echo base_url(); ?>reporting/bulk_preview/"+measure_level+"/"+year+"/"+country+"/"+county;
    });

    $('body').on('change', '.county', function() {
        $elem = $(this);
        measure_level= $('select[name="measure_level"]').val();
        year= $('select[name="year"]').val();
        country= $('select[name="country"]').val();
        county= this.value;
        window.location = "<?php echo base_url(); ?>reporting/bulk_preview/"+measure_level+"/"+year+"/"+country+"/"+county;
    });

    $('body').on('click', '.submit_data', function() {
        $elem = $(this);
        $elem.prop('disabled', true);
        

        $('.error').html('');
        var surveycount = 0;
        
        if ($('select[name="measure_level"]').val().length == 0) {
            $('select[name="measure_level"]').next('.error').html('This field is required');
            surveycount++;
        }else{
            $('select[name="measure_level"]').next('.error').html('');
        }
        if ($('select[name="year"]').val().length == 0) {
            $('select[name="year"]').next('.error').html('This field is required');
            surveycount++;
        }else{
            $('select[name="year"]').next('.error').html('');
        }
        if ($('select[name="country"]').val().length == 0) {
            $('select[name="country"]').next('.error').html('This field is required');
            surveycount++;
        }else{
            $('select[name="country"]').next('.error').html('');
        }
        if($(".county")[0]){
            if ($('select[name="county"]').val().length == 0) {
                $('select[name="county"]').next('.error').html('This field is required');
                surveycount++;
            }else{
                $('select[name="county"]').next('.error').html('');
            }
        }
        var form_id = "submit_form_data";

        $('input[type=number]', '#submit_form_data').each(function() {

            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");
            var minvalue = $(this).data("minlength");
            if(requiredvalue == 'required'){
                if($.trim($(this).val()).length === 0){
                    $(this).closest('.form-group').find('.error').html('This field is required');
                    surveycount++;
                }
            }
            if(subtypevalue == 'number' || subtypevalue == 'desimal' ){
                switch (subtypevalue){

                case 'number':
                    if($.trim($(this).val()).length > 0){
                        if (/^\d+$/.test($(this).val())) {
                            //skip if its number
                            $(this).closest('.form-group').find('.error').empty();
                        } else{
                            $(this).closest('.form-group').find('.error').html('Please provide a valid number decimal not allowed.');
                            surveycount++;
                            
                        }
                        if($.trim($(this).val()) > maxvalue){
                            $(this).closest('.form-group').find('.error').html('Please! Enter below '+maxvalue+' value');
                            surveycount++;
                        }
                        if($.trim($(this).val()) < minvalue){
                            $(this).closest('.form-group').find('.error').html('Please! Enter above '+minvalue+' value');
                            surveycount++;
                        }
                    }
                    break;

                case 'desimal':                        
                    if($.trim($(this).val()).length > 0){
                        if(!/^(\d*\.?\d*)$/.test($(this).val())){
                            $(this).closest('.form-group').find('.error').html('Please! Enter only number');
                            surveycount++;
                        }else if (!/^[0-9]+(\.\d{1,2})?$/.test($(this).val())) {
                            $(this).closest('.form-group').find('.error').html('Field can contain only proper decimal number.');
                            surveycount++;
                        }
                        if($.trim($(this).val()) > maxvalue){
                            $(this).closest('.form-group').find('.error').html('Please! Enter below '+maxvalue+' value');
                            surveycount++;
                        }
                        if($.trim($(this).val()) < minvalue){
                            $(this).closest('.form-group').find('.error').html('Please! Enter above '+minvalue+' value');
                            surveycount++;
                        }
                    }
                    break;
                }
            }
        });
        
        
        if (surveycount == 0) {
            var form_id1 = "submit_form_data";
            var indicatorform = new FormData($('#' + form_id1)[0]);
            // indicatorform.append('measure_level', $('select[name="measure_level"]').val());
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/insert_bulk_indicatordata',
                type: 'POST',
                dataType: 'json',
                data: indicatorform,
                // data: $("#submit_data").serialize(),
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
                                location.reload(true);
                            }
                        });
                    }
                }
            });
        }else {
            $elem.prop('disabled', false);
        }
    });
</script>

