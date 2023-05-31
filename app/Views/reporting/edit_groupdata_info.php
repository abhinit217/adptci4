<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style type="text/css">
	td .form-group{
		margin-bottom: 10px;
	}
	.fa {
		color: #4454c3!important;
	}
	.app-content.page-body {
		margin-top: 4rem !important;
	}
</style>
<script type="text/javascript">
    function getchild_field(data, $elem) {
        var classname = 'childof'+data.field_id;
        var fieldtype = data.fieldtype;

        $.ajax({
            url: "<?php echo base_url(); ?>reports/check_childfields",
            type: "POST",
            dataType: "json",
            data : {
               field_id : data.field_id,
               field_value : data.field_value,
               calltype : data.calltype,
               survey_id : <?php echo $this->uri->segment(3); ?>
            },
            error : function(){
                if(fieldtype == 'groupfield'){
                    $elem.closest('.row').find('.'+classname).html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
                }else{
                    $('.'+classname).html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
                }           

                setTimeout(function(){
                    $('.'+classname).empty();
                }, 5000);
            },
            success : function (response) {
                if(response.status == 1){
                    if(response.child_field.length > 0){
                        var CHILD_HTML = '';
                        for(var field of response.child_field) {
                            switch (field.type){
                                case 'radio-group' :
                                    CHILD_HTML += '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){ 
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            CHILD_HTML += '<div class="form-check">\
                                                <div class="row">';
                                                    field.options.forEach(function(option, optionindex ){
                                                        CHILD_HTML += '<div class="col-md-12">';
                                                            if(field.inline == "true" || field.inline == "TRUE"){ 
                                                                var radioclass = 'radio-inline'; 
                                                            }else{
                                                                var radioclass = '';
                                                            }
                                                            var inputradioclass = (field.className != '') ? field.className : "";
                                                            if(typeof field.value !== 'undefined'){
                                                                var columnfield = "field_"+field.field_id;
                                                                if(field.value == option.value){
                                                                    var selectedvalue = "checked";
                                                                }else{
                                                                    var selectedvalue = '';
                                                                }
                                                            }else{
                                                                if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                    var selectedvalue = "checked"; 
                                                                }else{
                                                                    var selectedvalue = '';
                                                                }
                                                            }
                                                            if(fieldtype == 'groupfield'){
                                                                var radioname = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                                            }else{
                                                                var radioname = "field_"+field.field_id+"";
                                                            }
                                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                                            CHILD_HTML += '<label class="'+radioclass+' option_label" >\
                                                                <input type="radio" name="'+radioname+'"  class="'+inputradioclass+'" value = "'+option.value+'" '+selectedvalue+' style="margin-right: 5px;" data-field_id = "'+field.field_id+'" data-field_value = "'+option.value+'" data-required = "'+requiredval+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'">'+option.label+'\
                                                            </label>\
                                                        </div>';
                                                    });
                                                CHILD_HTML += '</div>\
                                            </div>';
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                        </div>\
                                    </div>';
                                    if(field.child_count > 0){
                                        CHILD_HTML += '<div class="col-md-12">\
                                            <div class="row childfields childof'+field.field_id+'"></div>\
                                        </div>';
                                    }
                                    break;

                                case 'checkbox-group' :
                                    CHILD_HTML += '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){ 
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            CHILD_HTML += '<div class="form-check">\
                                                <div class="row">';
                                                    field.options.forEach(function(option, optionindex ){
                                                        CHILD_HTML += '<div class="col-md-12">';
                                                            if(field.inline == "true" || field.inline == "TRUE"){ 
                                                                var radioclass = 'radio-inline'; 
                                                            }else{
                                                                var radioclass = '';
                                                            }
                                                            var inputcheckboxclass = (field.className != '') ? field.className : "";
                                                            if(typeof field.value !== 'undefined'){
                                                                var columnfield = "field_"+field.field_id;
                                                                if(field.value == option.value){
                                                                    var selectedvalue = "checked";
                                                                }else{
                                                                    var selectedvalue = '';
                                                                }
                                                            }else{
                                                                if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                    var selectedvalue = "checked"; 
                                                                }else{
                                                                    var selectedvalue = '';
                                                                }
                                                            }
                                                            if(fieldtype == 'groupfield'){
                                                                var checkbox_name = "field_"+field.field_id+"["+data.groupfieldcount+"][]";
                                                            }else{
                                                                var checkbox_name = "field_"+field.field_id+"[]";
                                                            }
                                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                                            CHILD_HTML += '<label class="'+radioclass+' option_label" >\
                                                                <input type="checkbox" name="'+checkbox_name+'"  class="'+inputcheckboxclass+'" value = "'+option.value+'" '+selectedvalue+' style="margin-right: 5px;" data-field_id = "'+field.field_id+'" data-field_value = "'+option.value+'" data-required = "'+requiredval+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'">'+option.label+'\
                                                            </label>\
                                                        </div>';
                                                    });
                                                CHILD_HTML += '</div>\
                                            </div>';
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                        </div>\
                                    </div>';
                                    if(field.check_child_fields > 0){
                                        CHILD_HTML += '<div class="col-md-12">\
                                            <div class="row childfields childof'+field.field_id+'"></div>\
                                        </div>';
                                    }
                                    break;

                                case 'select':
                                    CHILD_HTML += '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                            if(fieldtype == 'groupfield'){
                                                if(field.multiple == 'true' || field.multiple == 'TRUE'){
                                                    var select_name = "field_"+field.field_id+"["+data.groupfieldcount+"][]";
                                                    var selectmultiple = "multiple";
                                                }else{
                                                    var select_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                                }
                                                
                                            }else{
                                                if(field.multiple == 'true' || field.multiple == 'TRUE'){
                                                    var select_name = "field_"+field.field_id+"[]";
                                                    var selectmultiple = "multiple";
                                                }else{
                                                    var select_name = "field_"+field.field_id+"";
                                                }                                               
                                            }
                                            CHILD_HTML += '<select name="'+select_name+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+requiredval+'" data-field_id = "'+field.field_id+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" data-maxlength ="'+field.maxlength+'">';
                                            if(field.multiple == 'true' || field.multiple == 'TRUE'){
                                            }else{
                                                CHILD_HTML += '<option value="">Select an option</option>';
                                            }
                                            
                                            field.options.forEach(function(option, optionindex){
                                                if(typeof field.value !== 'undefined'){
                                                    if(field.value == option.value){
                                                        var optionselected = "selected";
                                                    }else{
                                                        var optionselected = '';
                                                    }
                                                }else{
                                                    if(option.selected == "true" || option.selected == "TRUE"){
                                                        var optionselected = "selected";
                                                    }else{
                                                        var optionselected = "";
                                                    }
                                                }

                                                CHILD_HTML +='<option value = "'+option.value+'" '+optionselected+'>'+option.label+'</option>';
                                            });
                                            CHILD_HTML += '</select>\
                                            <p class="error red-800"></p>\
                                        </div>\
                                    </div>';
                                    if(field.check_child_fields > 0){
                                        CHILD_HTML += '<div class="col-md-12">\
                                            <div class="row childfields childof'+field.field_id+'"></div>\
                                        </div>';
                                    }
                                    break;

                                case 'number':
                                    CHILD_HTML += '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var inputclass = (field.className != '') ? field.className : "";
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                            if(typeof field.value !== 'undefined' && field.value != null){
                                                var columnfield = "field_"+field.field_id;
                                                if(field.value == null){
                                                    var numberfield_value = '';
                                                }else{
                                                    var numberfield_value = field.value;
                                                }
                                            }else{
                                                var numberfield_value = '';
                                            }
                                            if(fieldtype == 'groupfield'){
                                                var number_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                            }else{
                                                var number_name = "field_"+field.field_id+"";
                                            }
                                            switch (field.subtype) {
                                                case 'desimal': 
                                                    CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' decimal" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" data-maxvalue = "'+field.max_val+'"  value="'+numberfield_value+'" >';
                                                break;

                                                case 'number':
                                                    CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' number" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" data-maxvalue = "'+field.max_val+'" value="'+numberfield_value+'" >';
                                                break;

                                                case 'latitude':
                                                    CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' latlong" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+numberfield_value+'" >';
                                                break;

                                                case 'longitude':
                                                    CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' latlong" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+numberfield_value+'" >';
                                                break;
                                                
                                                default:
                                                    CHILD_HTML += '<input type="text" name="'+number_name+'" class=" '+inputclass+' numberfield" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+numberfield_value+'" >';
                                                break;
                                            }
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                            <p class="maxlengtherror red-800"></p>\
                                        </div>\
                                    </div>';
                                    break;

                                case 'text' :
                                    CHILD_HTML += '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var inputclass = (field.className != '') ? field.className : "";
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                            if(typeof field.value !== 'undefined' && field.value != null){
                                                var columnfield = "field_"+field.field_id;
                                                var textfield_value = field.value;
                                            }else{
                                                var textfield_value = '';
                                            }
                                            if(fieldtype == 'groupfield'){
                                                var text_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                            }else{
                                                var text_name = "field_"+field.field_id+"";
                                            }
                                            CHILD_HTML += '<input type="text" name="'+text_name+'" class="'+inputclass+'" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+textfield_value+'" >';
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                            <p class="maxlengtherror red-800"></p>\
                                        </div>\
                                    </div>';
                                    break;

                                case 'header':
                                    CHILD_HTML += '<div class="col-md-12">\
                                        <'+field.subtype+' style="margin-top: 0px; margin-bottom: 20px;">'+field.label+'</'+field.subtype+'>\
                                    </div>';
                                    break;

                                case 'date':
                                    CHILD_HTML += '<div class="col-md-12">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var inputclass = (field.className != '') ? field.className : "";
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                            if(typeof field.value !== 'undefined' && field.value != null){
                                                var columnfield = "field_"+field.field_id;
                                                var textfield_value = field.value;
                                            }else{
                                                var textfield_value = '';
                                            }
                                            if(fieldtype == 'groupfield'){
                                                var date_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                            }else{
                                                var date_name = "field_"+field.field_id+"";
                                            }
                                            CHILD_HTML += '<input type="text" name="'+date_name+'" class="'+inputclass+' picker" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+textfield_value+'" autocomplete="off" onkeydown="return false">';
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                            <p class="maxlengtherror red-800"></p>\
                                        </div>\
                                    </div>';
                                    break;

                                case 'month':
                                    CHILD_HTML += '<div class="col-md-12">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var inputclass = (field.className != '') ? field.className : "";
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                            if(typeof field.value !== 'undefined' && field.value != null){
                                                var columnfield = "field_"+field.field_id;
                                                var textfield_value = field.value;
                                            }else{
                                                var textfield_value = '';
                                            }
                                            if(fieldtype == 'groupfield'){
                                                var month_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                            }else{
                                                var month_name = "field_"+field.field_id+"";
                                            }
                                            CHILD_HTML += '<input type="text" name="'+month_name+'" class="'+inputclass+' monthpicker" data-subtype = "'+field.subtype+'" data-maxlength ="'+field.maxlength+'" data-required = "'+requiredval+'" value="'+textfield_value+'" autocomplete="off" onkeydown="return false">';
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                            <p class="maxlengtherror red-800"></p>\
                                        </div>\
                                    </div>';
                                    break;

                                case 'uploadfile':
                                    CHILD_HTML += '<div class="col-md-12">';
                                        if(field.subtype == 'excel'){
                                            CHILD_HTML += '<div class="form-group">\
                                                <label>'+field.label;
                                                    if(field.required == 1){ 
                                                        CHILD_HTML += '<font color="red">*</font>';
                                                    }
                                                CHILD_HTML += '</label>';
                                                if(field.description != null){
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                                }
                                                var requiredval = (field.required == 1) ? "required" : "notrequired";
                                                (field.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>' : '';
                                                CHILD_HTML += '<div class="row">\
                                                    <div class="col-md-6">\
                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>\
                                                        Use this Excel template to upload the data:<a href="<?php echo base_url(); ?>includeout/avisareporting_excelformats/'+field.description+'" download=""><img src="<?php echo base_url(); ?>includeout/images/excel.png" style="width: 30px;">'+field.description+'</a>\
                                                        <input type="file" class="uploadfile" data-fieldtype = "'+field.type+'" data-fieldsubtype = "'+field.subtype+'"  data-required = "'+requiredval+'" name="field_'+field.field_id+'">\
                                                        <p style="font-size: 10px; font-style: italic; color: gray;">\
                                                            File size must be less than 500KB<br/>\
                                                            Only .xlsx, .xls file type are allowed\
                                                        </p>\
                                                        <p class="error" style="color: red"></p>\
                                                    </div>\
                                                </div>\
                                            </div>';
                                        }else if(field.subtype == 'document'){
                                            CHILD_HTML += '<div class="form-group">\
                                                <label>'+field.label;
                                                    if(field.required == 1){ 
                                                        CHILD_HTML += '<font color="red">*</font>';
                                                    }
                                                CHILD_HTML += '</label>';
                                                if(field.description != null){
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                                }
                                                var requiredval = (field.required == 1) ? "required" : "notrequired";
                                                (field.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>' : '';
                                                CHILD_HTML += '<div class="row">\
                                                    <div class="col-md-6">\
                                                        <input type="file" class="uploaddocument" data-fieldtype = "'+field.type+'" data-fieldsubtype = "'+field.subtype+'"  data-required = "'+requiredval+'" name="field_'+field.field_id+'">\
                                                        <p style="font-size: 10px; font-style: italic; color: gray;">\
                                                            File size must be less than 500KB<br/>\
                                                            Only .pdf file type are allowed\
                                                        </p>\
                                                        <p class="error" style="color: red"></p>\
                                                    </div>\
                                                </div>\
                                            </div>';
                                        }
                                    CHILD_HTML += '</div>';
                                    break;

                                case 'textarea' :
                                    CHILD_HTML += '<div class="col-md-12">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var inputclass = (field.className != '') ? field.className : "";
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";

                                            if(typeof field.value !== 'undefined' && field.value != null){
                                                var columnfield = "field_"+field.field_id;
                                                var textfield_value = field.value;
                                            }else{
                                                var textfield_value = '';
                                            }
                                            CHILD_HTML += '<textarea name="field_'+field.field_id+'" rows="8" class="'+inputclass+'" data-subtype="'+field.subtype+'" data-maxlength = "'+field.maxlength+'" data-required="'+requiredval+'">'+textfield_value+'</textarea>';
                                            CHILD_HTML += '<p class="error red-800"></p>\
                                            <p class="maxlengtherror red-800"></p>\
                                        </div>\
                                    </div>';
                                    break;

                                case 'lkp_country':
                                    CHILD_HTML += '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label>'+field.label;
                                                if(field.required == 1){ 
                                                    CHILD_HTML += '<font color="red">*</font>';
                                                }
                                            CHILD_HTML += '</label>';
                                            if(field.description != null){
                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>';
                                            }
                                            var requiredval = (field.required == 1) ? "required" : "notrequired";
                                            if(fieldtype == 'groupfield'){
                                                if(field.multiple == 'true' || field.multiple == 'TRUE'){
                                                    var select_name = "field_"+field.field_id+"["+data.groupfieldcount+"][]";
                                                    var selectmultiple = "multiple";
                                                }else{
                                                    var select_name = "field_"+field.field_id+"["+data.groupfieldcount+"]";
                                                }
                                                
                                            }else{
                                                if(field.multiple == 'true' || field.multiple == 'TRUE'){
                                                    var select_name = "field_"+field.field_id+"[]";
                                                    var selectmultiple = "multiple";
                                                }else{
                                                    var select_name = "field_"+field.field_id+"";
                                                }                                               
                                            }
                                            CHILD_HTML += '<select name="'+select_name+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+requiredval+'" data-field_id = "'+field.field_id+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" data-maxlength ="'+field.maxlength+'">';
                                            if(field.multiple == 'true' || field.multiple == 'TRUE'){
                                            }else{
                                                CHILD_HTML += '<option value="">Select an option</option>';
                                            }
                                            
                                            field.options.forEach(function(option, optionindex){
                                                if(typeof field.value !== 'undefined'){
                                                    if(field.value == option.value){
                                                        var optionselected = "selected";
                                                    }else{
                                                        var optionselected = '';
                                                    }
                                                }else{
                                                    if(option.selected == "true" || option.selected == "TRUE"){
                                                        var optionselected = "selected";
                                                    }else{
                                                        var optionselected = "";
                                                    }
                                                }

                                                CHILD_HTML +='<option value = "'+option.country_id+'" '+optionselected+'>'+option.name+'</option>';
                                            });
                                            CHILD_HTML += '</select>\
                                            <p class="error red-800"></p>\
                                        </div>\
                                    </div>';
                                    if(field.child_count > 0){
                                        CHILD_HTML += '<div class="col-md-12">\
                                            <div class="row childfields childof'+field.field_id+'"></div>\
                                        </div>';
                                    }
                                    break;

                                case 'group': 
                                    CHILD_HTML += '<div class="col-md-12 addmoremaindiv">\
                                        <div class="row addmore addmore_div">';
                                            var groupfieldscount = field.groupfields.length;
                                            var i_divmainclass = (groupfieldscount == 1 ? 6 : 11);
                                            CHILD_HTML += '<div class="col-md-'+i_divmainclass+'">\
                                                <div class="row">';
                                                    field.groupfields.forEach(function(groupfield, g_index){
                                                        if(groupfieldscount == 1){
                                                            var i_divclass = 12
                                                        }else if(groupfieldscount == 2){
                                                            var i_divclass = 6;
                                                        }else if(groupfieldscount == 3){
                                                            var i_divclass = 4;
                                                        }else{
                                                            var i_divclass = 3;
                                                        }
                                                        switch(groupfield.type){
                                                            case 'text':
                                                                CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                    <div class="form-group">';
                                                                        CHILD_HTML += '<label>'+(g_index+1)+'. '+groupfield.label+''+(groupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                        if(groupfield.description != null){
                                                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+groupfield.description+'</p>';
                                                                        }
                                                                        CHILD_HTML += '<input type="text" name="field_'+groupfield.field_id+'[0]" class="'+groupfield.className+'" data-required="'+(groupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+groupfield.maxlength+'" value="" data-subtype="'+groupfield.subtype+'">\
                                                                        <p class="error red-800"></p>\
                                                                        <p class="maxlengtherror red-800"></p>\
                                                                    </div>\
                                                                </div>';
                                                                break;

                                                            case 'textarea' :
                                                                CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                    <div class="form-group">'
                                                                        CHILD_HTML += '<label>'+(g_index+1)+'. '+groupfield.label+''+(groupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                        if(groupfield.description != null){
                                                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+groupfield.description+'</p>';
                                                                        }
                                                                        var inputclass = (groupfield.className != '') ? groupfield.className : "";
                                                                        var requiredval = (groupfield.required == 1) ? "required" : "notrequired";

                                                                        if(typeof groupfield.value !== 'undefined' && groupfield.value != null){
                                                                            var columnfield = "field_"+groupfield.field_id;
                                                                            var textfield_value = groupfield.value;
                                                                        }else{
                                                                            var textfield_value = '';
                                                                        }
                                                                        CHILD_HTML += '<textarea name="field_'+groupfield.field_id+'[0]" rows="8" class="'+inputclass+'" data-subtype="'+groupfield.subtype+'" data-maxlength = "'+groupfield.maxlength+'" data-required="'+requiredval+'">'+textfield_value+'</textarea>';
                                                                        CHILD_HTML += '<p class="error red-800"></p>\
                                                                        <p class="maxlengtherror red-800"></p>\
                                                                    </div>\
                                                                </div>';
                                                                break;

                                                            case 'select':
                                                                CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                    <div class="form-group">';
                                                                        CHILD_HTML += '<label>'+(g_index+1)+'. '+groupfield.label+''+(groupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                        if(groupfield.description != null){
                                                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+groupfield.description+'</p>';
                                                                        }
                                                                        if(groupfield.multiple == 'true' || groupfield.multiple == 'TRUE'){
                                                                            var selectname = "field_"+groupfield.field_id+"[0][]";
                                                                            var selectmultiple = "multiple";
                                                                        }else{
                                                                            var selectname = "field_"+groupfield.field_id+"[0]";
                                                                            var selectmultiple = "";
                                                                        } 
                                                                        CHILD_HTML +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(groupfield.required == 1 ? "required" : "")+'" data-field_id = "'+groupfield.field_id+'"   data-fieldtype="groupfield" data-groupfieldcount = "0" data-maxlength ="'+groupfield.maxlength+'">';
                                                                        if(groupfield.multiple == 'true' || groupfield.multiple == 'TRUE'){
                                                                        }else{
                                                                            CHILD_HTML += '<option value="">Select an option</option>';
                                                                        }
                                                                        groupfield.options.forEach(function(option, index){
                                                                            if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                var select_value = "selected"; 
                                                                            }else{
                                                                                var select_value = '';
                                                                            }
                                                                            CHILD_HTML += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
                                                                        });
                                                                        CHILD_HTML += '</select>\
                                                                        <p class="error red-800"></p>\
                                                                    </div>\
                                                                </div>';
                                                                if(groupfield.child_count > 0){
                                                                    CHILD_HTML += '<div class="col-md-12">\
                                                                        <div class="row childfields childof'+groupfield.field_id+'"></div>\
                                                                    </div>';
                                                                }
                                                                break;

                                                            case 'radio-group':
                                                                CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                    <div class="form-group">';
                                                                        CHILD_HTML += '<label>'+(g_index+1)+'. '+groupfield.label+''+(groupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                        if(groupfield.description != null){
                                                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+groupfield.description+'</p>';
                                                                        }
                                                                        CHILD_HTML += '<div class="form-check">\
                                                                            <div class="row">';
                                                                                groupfield.options.forEach(function(option, index){
                                                                                    var requiredval = (groupfield.required == 1) ? "required" : "";
                                                                                    if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                        var radio_value = "checked"; 
                                                                                    }else{
                                                                                        var radio_value = '';
                                                                                    }
                                                                                    CHILD_HTML += '<div class="col-md-6">\
                                                                                        <label><input type="radio" name="field_'+groupfield.field_id+'[0]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+groupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>\
                                                                                    </div>';
                                                                                });
                                                                            CHILD_HTML += '</div>\
                                                                        </div>\
                                                                        <p class="error red-800"></p>\
                                                                    </div>\
                                                                </div>';
                                                                if(groupfield.child_count > 0){
                                                                    CHILD_HTML += '<div class="col-md-12">\
                                                                        <div class="row childfields childof'+groupfield.field_id+'"></div>\
                                                                    </div>';
                                                                }
                                                                break;

                                                            case 'checkbox-group':
                                                                CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                    <div class="form-group">';
                                                                        CHILD_HTML += '<label>'+(g_index+1)+'. '+groupfield.label+''+(groupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                        if(groupfield.description != null){
                                                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+groupfield.description+'</p>';
                                                                        }
                                                                        CHILD_HTML += '<div class="form-check row">\
                                                                            <div class="col-md-12">';
                                                                                groupfield.options.forEach(function(option, index){
                                                                                    var requiredval = (groupfield.required == 1) ? "required" : "";
                                                                                    if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                        var radio_value = "checked"; 
                                                                                    }else{
                                                                                        var radio_value = '';
                                                                                    }
                                                                                    CHILD_HTML += '<label><input type="checkbox" name="field_'+groupfield.field_id+'[0][]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+groupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>';
                                                                                });
                                                                            CHILD_HTML += '</div>\
                                                                        </div>\
                                                                        <p class="error red-800"></p>\
                                                                    </div>\
                                                                </div>';
                                                                if(groupfield.child_count > 0){
                                                                    CHILD_HTML += '<div class="col-md-12">\
                                                                        <div class="row childfields childof'+groupfield.field_id+'"></div>\
                                                                    </div>';
                                                                }
                                                                break;

                                                            case 'number':
                                                                CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                    <div class="form-group">';
                                                                        CHILD_HTML += '<label>'+(g_index+1)+'. '+groupfield.label+''+(groupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                        if(groupfield.description != null){
                                                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+groupfield.description+'</p>';
                                                                        }
                                                                        switch (groupfield.subtype) {
                                                                            case 'desimal':
                                                                                CHILD_HTML += '<input type="text" name="field_'+groupfield.field_id+'[0]" class="'+groupfield.className+' decimal" data-subtype="'+groupfield.subtype+'" data-maxlength = "'+groupfield.maxlength+'" data-maxvalue = "'+groupfield.max_val+'" data-required = "'+(groupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                break;

                                                                            case 'number':
                                                                                CHILD_HTML += '<input type="text" name="field_'+groupfield.field_id+'[0]" class="'+groupfield.className+' number" data-subtype="'+groupfield.subtype+'" data-maxlength = "'+groupfield.maxlength+'" data-maxvalue = "'+groupfield.max_val+'" data-required = "'+(groupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                break;

                                                                            case 'latitude':
                                                                                CHILD_HTML += '<input type="text" name="field_'+groupfield.field_id+'[0]" class="'+groupfield.className+' latlong" data-subtype="'+groupfield.subtype+'" data-maxlength = "'+groupfield.maxlength+'" data-required = "'+(groupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                break;

                                                                            case 'longitude':
                                                                                CHILD_HTML += '<input type="text" name="field_'+groupfield.field_id+'[0]" class="'+groupfield.className+' latlong" data-subtype="'+groupfield.subtype+'" data-maxlength = "'+groupfield.maxlength+'" data-required = "'+(groupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                break;
                                                                            
                                                                            default:
                                                                                CHILD_HTML += '<input type="text" name="field_'+groupfield.field_id+'[0]" class="'+groupfield.className+' numberfield" data-subtype="'+groupfield.subtype+'" data-maxlength = "'+groupfield.maxlength+'" data-required = "'+(groupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                break;
                                                                        }
                                                                        CHILD_HTML += '<p class="error red-800"></p>\
                                                                        <p class="maxlengtherror red-800"></p>\
                                                                    </div>\
                                                                </div>';
                                                                break;
                                                        }       
                                                    });
                                                CHILD_HTML += '</div>\
                                            </div>\
                                            <div class="col-md-1 mt-20 add_remove_button">\
                                                <button type="button" class="btn btn-success btn-sm addmorefields pull-left" style="margin-bottom: 15px; margin-top:10px;"><span class="glyphicon glyphicon-plus"></span> Add\
                                                </button>\
                                            </div>\
                                            <div class="col-md-12">\
                                                <hr style="margin-top: 0px; border: 1px; height: 1px; background-color: #8e8ec0;">\
                                            </div>\
                                        </div>\
                                    </div>';
                                    break;
                            }
                        };                            

                        if(fieldtype == 'groupfield'){
                            // $elem.closest('.row').find('.'+classname).html(CHILD_HTML);
							$elem.closest('.addmore').find('.' + classname).html(CHILD_HTML);
							// const mydivclass = $elem.closest('.addmore').find('.' + classname);
							// if(mydivclass.classList.contains('form-group')) {
							// 	alert("i am called");
							// }else{
								// $elem.closest('.addmore').find('.' + classname).html(CHILD_HTML);
							// }
                        }else{
                            $('.'+classname).html(CHILD_HTML);
                        }

                        //Date picker
                        $('.picker').datepicker({
                           format: 'yyyy-mm-dd',
                           autoclose: true
                        });

                        //month picker
                        $('.monthpicker').datepicker({
                            format: "yyyy-mm",
                            startView: 1,
                            minViewMode: 1,
                            maxViewMode: 2,
                            autoclose: true,
                            todayHighlight: true
                        });
                    }else{
						// alert("I am here");
						$elem.closest('.row').find('.'+classname).html('<p align="center" class="red-800">'+response.msg+'</p>');
						$elem.closest('.addmore').find('.' + classname).empty();
                        $('html,body').animate({
                            scrollTop: $elem.closest('.row').find('.'+classname).offset().top - 300
                        }, 500);

                        setTimeout(function(){
                            $elem.closest('.row').find('.'+classname).empty();
                        }, 5000);
					}
                }else{
                    if(fieldtype == 'groupfield'){
                        $elem.closest('.row').find('.'+classname).html('<p align="center" class="red-800">'+response.msg+'</p>');
						$elem.closest('.addmore').find('.' + classname).html("");
                        $('html,body').animate({
                            scrollTop: $elem.closest('.row').find('.'+classname).offset().top - 300
                        }, 500);

                        setTimeout(function(){
                            $elem.closest('.row').find('.'+classname).empty();
                        }, 5000);
                    }else{
                        $('.'+classname).html('<p align="center" class="red-800">'+response.msg+'</p>');

                        $('html,body').animate({
                            scrollTop: $('.'+classname).offset().top - 300
                        }, 500);

                        setTimeout(function(){
                            $('.'+classname).empty();
                        }, 5000);
                    }
					
                }
				
            }
        });
    }
</script>

<!-- Edit Data Modal -->
<?php function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return strtolower($returnValue);
} ?>
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>

            <!-- <?php echo form_open('', array('id' => 'addForm')); ?> -->
            <form id="addForm">
				<div class="row">
					<div class="col-md-12">
						<div class="card p-10 pr-3 pl-3 pt-3">
							<div class="row">
								<?php $i = 1;
								$k = 0;
								$l = 0;
								foreach ($fields as $key => $value) {
									switch ($value['type']) {
											//commented as
										case 'group': ?>
											<div class="col-md-12 addmoremaindiv">
												<?php $grouplabel = ($value['field_count'] == 1) ? $i++ : $i;
												if ($value['field_count'] == 1) {
													$label = $grouplabel . ". " . $value['label'];
												} else {
													$label = $value['label'];
												} ?>
												<label><?php echo $label; ?></label>
												<div class="row addmore addmore_div">
													<?php $groupfieldscount = count($value['groupfields']);
													$i_divmainclass = ($groupfieldscount == 1) ? 6 : 11; ?>
													<div class="col-md-<?php echo $i_divmainclass; ?>">
														<div class="row">
															<?php foreach ($value['groupfields'] as $ig_index => $surveygroupfield) {
																if ($groupfieldscount == 1) {
																	$i_divclass = 12;
																} else if ($groupfieldscount == 2) {
																	$i_divclass = 6;
																} else {
																	$i_divclass = 4;
																}
																switch ($surveygroupfield['type']) {
																	case 'header': ?>
																		<div class="col-md-12">
																			<?php switch ($surveygroupfield['subtype']) {
																				case 'h1': ?>
																					<h1 style="margin-top: 0px; margin-bottom: 20px;"><?php echo $surveygroupfield['label']; ?></h1>
																				<?php break;

																				case 'h2': ?>
																					<h2 style="margin-top: 0px; margin-bottom: 20px;"><?php echo $surveygroupfield['label']; ?></h2>
																				<?php break;

																				case 'h3': ?>
																					<h3 style="margin-top: 0px; margin-bottom: 20px;"><?php echo $surveygroupfield['label']; ?></h3>
																				<?php break;

																				case 'h4': ?>
																					<h4 style="margin-top: 0px; margin-bottom: 20px;"><?php echo $surveygroupfield['label']; ?></h4>
																				<?php break;

																				case 'h5': ?>
																					<h5 style="margin-top: 0px; margin-bottom: 20px;"><?php echo $surveygroupfield['label']; ?></h5>
																			<?php break;
																			} ?>
																		</div>
																	<?php break;

																	case 'text': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" value="" data-subtype="<?php echo $surveygroupfield['subtype']; ?>">
																				<p class="error red-800"></p>
																				<p class="maxlengtherror red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'textarea': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<textarea name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" rows="8" class="<?php echo $surveygroupfield['className']; ?>" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>"></textarea>
																				<p class="error red-800"></p>
																				<p class="maxlengtherror red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'select': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<?php if ($surveygroupfield['multiple'] == 'true' || $surveygroupfield['multiple'] == 'TRUE') {
																					$selectname = "field_" . $surveygroupfield['field_id'] . "[0][]";
																					$selectmultiple = "multiple";
																				} else {
																					$selectname = "field_" . $surveygroupfield['field_id'] . "[0]";
																					$selectmultiple = "";
																				} ?>
																				<select name="<?php echo $selectname; ?>" <?php echo $selectmultiple; ?> class="form-control selectbox" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>">
																					<?php if ($surveygroupfield['multiple'] == 'true' || $surveygroupfield['multiple'] == 'TRUE') { ?>
																					<?php } else { ?>
																						<option value="">Select an option</option>
																					<?php } ?>
																					<?php foreach ($surveygroupfield['options'] as $key => $option) {
																						if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
																							$select_value = "selected";
																						} else {
																							$select_value = '';
																						} ?>
																						<option value="<?php echo $option['value']; ?>" <?php echo $select_value; ?>><?php echo $option['label']; ?></option>
																					<?php } ?>
																				</select>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																		<?php if ($surveygroupfield['child_count'] > 0) { ?>
																			<div class="col-md-12">
																				<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																			</div>
																		<?php } ?>
																	<?php break;

																	case 'radio-group': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<div class="form-check">
																					<div class="row">
																						<?php foreach ($surveygroupfield['options'] as $key => $option) {
																							$requiredval = ($surveygroupfield['required'] == 1) ? "required" : "";
																							if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
																								$radio_value = "checked";
																							} else {
																								$radio_value = '';
																							} ?>
																							<div class="col-md-6">
																								<label class="option_label">
																									<input type="radio" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" value="<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-field_value="<?php echo $option['value']; ?>" data-required="<?php echo $requiredval ?>" <?php echo $radio_value; ?> data-fieldtype="groupfield" data-groupfieldcount="0"><?php echo $option['label']; ?></label>
																							</div>
																						<?php } ?>
																					</div>
																				</div>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																		<?php if ($surveygroupfield['child_count'] > 0) { ?>
																			<div class="col-md-12">
																				<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																			</div>
																		<?php } ?>
																	<?php break;

																	case 'checkbox-group': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<div class="form-check">
																					<div class="row">
																						<?php foreach ($surveygroupfield['options'] as $key => $option) {
																							$requiredval = ($surveygroupfield['required'] == 1) ? "required" : "";
																							if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
																								$radio_value = "checked";
																							} else {
																								$radio_value = '';
																							} ?>
																							<div class="col-md-6">
																								<label class="option_label"><input type="checkbox" name="field_<?php echo $surveygroupfield['field_id']; ?>[0][]" value="<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-field_value="<?php echo $option['value'] ?>" data-required="<?php echo $requiredval ?>" <?php echo $radio_value; ?> data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>"><?php echo $option['label']; ?></label>
																							</div>
																						<?php } ?>
																					</div>
																				</div>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																		<?php if ($surveygroupfield['child_count'] > 0) { ?>
																			<div class="col-md-12">
																				<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																			</div>
																		<?php } ?>
																	<?php break;

																	case 'number': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<?php switch ($surveygroupfield['subtype']) {
																					case 'desimal': ?>
																						<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> desimal" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" data-maxvalue="<?php echo $surveygroupfield['max_val']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" value="">
																					<?php break;

																					case 'number': ?>
																						<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> number" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" data-maxvalue="<?php echo $surveygroupfield['max_val']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" value="">
																					<?php break;

																					case 'latitude': ?>
																						<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> latlong" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" value="">
																					<?php break;

																					case 'longitude': ?>
																						<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> latlong" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" value="">
																					<?php break;

																					default: ?>
																						<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> numberfield" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" value="">
																				<?php break;
																				} ?>
																				<p class="error red-800"></p>
																				<p class="maxlengtherror red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'date': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> picker" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" value="" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
																				<p class="error red-800"></p>
																				<p class="maxlengtherror red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'month': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<input type="text" name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="<?php echo $surveygroupfield['className']; ?> monthpicker" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>" value="" data-subtype="<?php echo $surveygroupfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
																				<p class="error red-800"></p>
																				<p class="maxlengtherror red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'lkp_state': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>

																				<select name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="form-control group_state" data-required="<?php echo ($surveygroupfield['required'] == 1) ? 'required' : ''; ?>">
																					<?php foreach ($surveygroupfield['options'] as $key => $option) { ?>
																						<option value="<?php echo $option['state_id']; ?>"><?php echo $option['state_name']; ?></option>
																					<?php } ?>
																				</select>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'lkp_district': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>

																				<select name="field_<?php echo $surveygroupfield['field_id']; ?>[0]" class="form-control group_district" data-required="<?php echo ($surveygroupfield['required'] == 1) ? 'required' : ''; ?>">
																					<?php foreach ($surveygroupfield['options'] as $key => $option) { ?>
																						<option value="<?php echo $option['district_id']; ?>"><?php echo $option['district_name']; ?></option>
																					<?php } ?>
																				</select>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																	<?php break;

																	case 'lkp_country': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<?php if ($surveygroupfield['multiple'] == 'true' || $surveygroupfield['multiple'] == 'TRUE') {
																					$selectname = "field_" . $surveygroupfield['field_id'] . "[0][]";
																					$selectmultiple = "multiple";
																				} else {
																					$selectname = "field_" . $surveygroupfield['field_id'] . "[0]";
																					$selectmultiple = "";
																				} ?>
																				<select name="<?php echo $selectname; ?>" <?php echo $selectmultiple; ?> class="form-control selectbox" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>">
																					<?php if ($surveygroupfield['multiple'] == 'true' || $surveygroupfield['multiple'] == 'TRUE') { ?>
																					<?php } else { ?>
																						<option value="">Select an option</option>
																					<?php } ?>
																					<?php foreach ($surveygroupfield['options'] as $key => $option) {
																						// if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
																						//     $select_value = "selected";
																						// } else {
																						//     $select_value = '';
																						// } 
																						?>
																						<option value="<?php echo $option['country_id']; ?>" ><?php echo $option['country_name']; ?></option>
																					<?php } ?>
																				</select>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																		<?php if ($surveygroupfield['child_count'] > 0) { ?>
																			<div class="col-md-12">
																				<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																			</div>
																		<?php } ?>
																		<?php break;

																	case 'lkp_headquarter': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																			<div class="form-group">
																				<?php $questionno = $ig_index + 1; ?>
																				<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																				<?php if ($surveygroupfield['description'] != NULL) { ?>
																					<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																				<?php } ?>
																				<?php if ($surveygroupfield['multiple'] == 'true' || $surveygroupfield['multiple'] == 'TRUE') {
																					$selectname = "field_" . $surveygroupfield['field_id'] . "[0][]";
																					$selectmultiple = "multiple";
																				} else {
																					$selectname = "field_" . $surveygroupfield['field_id'] . "[0]";
																					$selectmultiple = "";
																				} ?>
																				<select name="<?php echo $selectname; ?>" <?php echo $selectmultiple; ?> class="form-control selectbox" data-required="<?php echo ($surveygroupfield['required'] == 1) ? "required" : ""; ?>" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>">
																					<?php if ($surveygroupfield['multiple'] == 'true' || $surveygroupfield['multiple'] == 'TRUE') { ?>
																					<?php } else { ?>
																						<option value="">Select an option</option>
																					<?php } ?>
																					<?php foreach ($surveygroupfield['options'] as $key => $option) {
																						// if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
																						//     $select_value = "selected";
																						// } else {
																						//     $select_value = '';
																						// } 
																						?>
																						<option value="<?php echo $option['headquarter_id']; ?>" ><?php echo $option['headquarter_name']; ?></option>
																					<?php } ?>
																				</select>
																				<p class="error red-800"></p>
																			</div>
																		</div>
																		<?php if ($surveygroupfield['child_count'] > 0) { ?>
																			<div class="col-md-12">
																				<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																			</div>
																		<?php } ?>
																		<?php break;

																	case 'lkp_trait': ?>
																		<div class="col-md-<?php echo $i_divclass; ?>">
																	<div class="form-group">
																		<?php $questionno = $ig_index + 1; ?>
																		<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																		<?php if ($surveygroupfield['description'] != NULL) {
																			if ('0') { ?>
																				<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																		<?php }
																		} ?>
																		<div class="form-check">
																			<div class="row">
																				<?php foreach ($surveygroupfield['options'] as $key => $option) {
																					$requiredval = ($surveygroupfield['required'] == 1) ? "required" : "";?>
																					<div class="col-md-6">
																						<label><input type="checkbox" name="field_<?php echo $surveygroupfield['field_id']; ?>[0][]" value="<?php echo $option['trait_description']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-field_value="<?php echo $option['trait_name'] ?>" data-required="<?php echo $requiredval ?>" data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>"><?php echo $option['trait_name']; ?></label>
																					</div>
																				<?php } ?>
																			</div>
																		</div>
																		<p class="error red-800"></p>
																	</div>
																</div>
																<?php if ($surveygroupfield['child_count'] > 0) { ?>
																	<div class="col-md-12">
																		<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																	</div>
																<?php } ?>
																<?php break;

															case 'lkp_trait2': ?>
																<div class="col-md-<?php echo $i_divclass; ?>">
																	<div class="form-group">
																		<?php $questionno = $ig_index + 1; ?>
																		<label><?php echo numberToRomanRepresentation($questionno); ?>. <?php echo $surveygroupfield['label']; ?><?php echo ($surveygroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
																		<?php if ($surveygroupfield['description'] != NULL) {
																			if ('0') { ?>
																				<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $surveygroupfield['description']; ?></p>
																		<?php }
																		} ?>
																		<div class="form-check">
																			<div class="row">
																				<?php foreach ($surveygroupfield['options'] as $key => $option) {
																					$requiredval = ($surveygroupfield['required'] == 1) ? "required" : "";?>
																					<div class="col-md-6">
																						<label><input type="checkbox" name="field_<?php echo $surveygroupfield['field_id']; ?>[0][]" value="<?php echo $option['trait2_description']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $surveygroupfield['field_id']; ?>" data-field_value="<?php echo $option['trait2_name'] ?>" data-required="<?php echo $requiredval ?>" data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $surveygroupfield['maxlength']; ?>"><?php echo $option['trait2_name']; ?></label>
																					</div>
																				<?php } ?>
																			</div>
																		</div>
																		<p class="error red-800"></p>
																	</div>
																</div>
																<?php if ($surveygroupfield['child_count'] > 0) { ?>
																	<div class="col-md-12">
																		<div class="row childfields childof<?php echo $surveygroupfield['field_id']; ?>"></div>
																	</div>
																<?php } ?>
																<?php break;

																}
															} ?>
														</div>
													</div>

												</div>
											</div>
								<?php break;
										default:
											# code...
											break;
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
						<!-- <?php if (count($fields) > 0) { ?>
							<button type="submit" class="btn btn-success add_record">Save Data</button>
						<?php } ?> -->
						<?php if(count($fields) > 0){ ?>
							<!-- <div class="col-md-12"> -->
								<button name="submit" class="btn btn-success add_record" ><i class="fa fa-upload" aria-hidden="true"></i> Submit Data</button>
							<!-- </div> -->
						<?php } ?>
					</div>
					
					<!-- <?php echo form_close(); ?> -->
				</div>
			</form>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadExcelModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>

            <!-- <?php echo form_open('', array('id' => 'addForm')); ?> -->
            <form id="excelForm">
				<div class="row">
					<div class="col-md-12">
						<div class="card p-10 pr-3 pl-3 pt-3">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Upload Excel file <font color="red">*</font></label>
										<p style="font-size: 14px; font-style: italic; margin-bottom:20px; font-weight: 700;">Note: Only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>
										Use this Excel template to upload data:<a href="<?php echo base_url();?>/include/excelformat/form_<?php echo $survey_id;?>.xlsx" download="" style="color: #000000;"><img src="<?php echo base_url();?>/include/includeout/excel.png" style="width: 30px;">form_<?php echo $survey_id;?>.xlsx</a>
										<div class="mt-20">
											<input type="file" class="uploadfilehidden" name="uploadexcel_data" data-fieldtype="uploadfile" data-fieldsubtype="excel" subclass="" data-required="required">
											<p style="font-size: 12px; font-style: italic; color: gray;" class="">
												File size must be less than 2MB<br>
												Only .xlsx, .xls file type are allowed
											</p>
											<p class="error" style="color: red"></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
						<!-- <?php if (count($fields) > 0) { ?>
							<button type="submit" class="btn btn-success add_record">Save Data</button>
						<?php } ?> -->
						<?php if(count($fields) > 0){ ?>
							<!-- <div class="col-md-12"> -->
								<button name="submit" class="btn btn-success upload_excel_record" ><i class="fa fa-upload" aria-hidden="true"></i> Submit Data</button>
							<!-- </div> -->
						<?php } ?>
					</div>
					
					<!-- <?php echo form_close(); ?> -->
				</div>
			</form>
        </div>
    </div>
</div>

<!-- <div class="app-content content" style="margin-left: 0px;"> -->
<div class="app-content page-body mb-5">
    <div class="container-fluid">
        <div class="row">
				<div class="col-md-9">
					<h4> Edit Group Data </h4>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-sd-4">
							<?php //if(count($group_info[0]['group_data'])>0){?>
							<h4 class="title">
								<button class="btn btn-sm btn-success saveAll pull-right m-3" data-toggle="modal" data-target="#addModal">Add</button>
							</h4>
							<?php //} ?>
						</div>
						<div class="col-sd-4">
							<?php 
							if((isset($excel_u_status)) && ($excel_u_status  == $group_field_id)){?>
							<h4 class="title">
								<button class="btn btn-sm btn-success uploadExcel pull-right m-3" data-toggle="modal" data-target="#uploadExcelModal">Excel upload</button>
							</h4>
							<?php } ?>
						</div>
						<div class="col-sd-4">
							<a href="" onclick="window.close()" class="btn btn-sm btn-primary pull-right m-3">Back</a>
						</div>
					</div>
				</div>
		</div>

				<?php 
				// $group_data = $group_info[0];
				// print_r();
				foreach ($group_info as $key => $group) { ?>
					<div class="col-md-12 mt-10">
						
						<div class="card p-10">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Sl.no</th>
											<?php foreach ($group['group_fields'] as $key => $field) { ?>
												<th><?php echo $field['label']; ?></th>
											<?php } ?>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(count($group['group_data']) > 0){
											foreach ($group['group_data'] as $dkey => $data) { 
												$data_array = json_decode($data['formgroup_data'], true); ?>
												<tr>
													<td><?php echo $dkey+1; ?></td>
													<?php foreach ($group['group_fields'] as $fkey => $field) { ?>
														<td>
															<div data-field='<?php echo $field['field_id']; ?>' data-group='<?php echo $data['group_id']; ?>'>
																<?php 
																if($field['type'] == 'text' || $field['type'] == 'textarea'
																|| $field['type'] == 'number' || $field['type'] == 'scanner'
																|| $field['type'] == 'select' || $field['type'] == 'radio-group'
																|| $field['type'] == 'checkbox-group' || $field['type'] == 'lkp_country' 
																|| $field['type'] == 'lkp_crop' || $field['type'] == 'lkp_headquarter'
																|| $field['type'] == 'lkp_trait' || $field['type'] == 'lkp_trait2' 
																|| $field['type'] == 'lkp_year') {
																	echo "<a href='javascript:void(0)' title='Edit Data' class='pl-1 float-right edit'>
																		<i class='fa fa-edit' style='line-height:1.5;'></i>
																	</a>";
																} 
																?>
																
																<span class="field_value">
																<?php $column = "field_".$field['field_id'];
																switch ($field['type']) {
																	case 'lkp_headquarter':
																		$hname ="N/A";
																		foreach ($headquarter_list as $hkey => $hfield) {
																			if($hfield['headquarter_id'] == $data_array[$column]){
																				$hname =$hfield['headquarter_name'];
																			}
																		} 
																			echo $hname;
																		break;

																	case 'lkp_country':
																		$hname ="N/A";
																		foreach ($country_list as $hkey => $hfield) {
																			if($hfield['country_id'] == $data_array[$column]){
																				$hname =$hfield['country_name'];
																			}
																		} 
																			echo $hname;
																		break;
																	
																	default:
																		if(isset($data_array[$column])){
																			if($data_array[$column] == 'null' || $data_array[$column] == ''){
																				echo "N/A";
																			}else{
																				if(is_array($data_array[$column])) {
																					echo $data_array[$column][0];
																				} else {
																					echo $data_array[$column];
																				}
																			}
																		}else{
																			echo "N/A";
																		} 
																		break;
																}
																
																?>
																</span>
															</div>
														</td>
													<?php } ?>
													<td><a href="<?=base_url()?>reports/groupdata_delete/<?php echo $this->uri->segment(3); ?>/<?php echo $data['data_id']; ?>/<?php echo $group_field_id; ?>/<?php echo $data['group_id']; ?>/<?php echo $data['status']; ?>" onclick="return confirm('Are you sure you want to delete record?')" class="btn btn-sm btn-danger">Remove</a></td>
												</tr>
											<?php }
										}else{ ?>
											<tr>
												<td colspan="<?php echo count($group['group_fields'])+1; ?>">No data found</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				<?php } ?>					
			</div>
		</div>
	</div>
<!-- </div> -->
<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
	// $('body').tooltip({
	// 	selector: '[data-toggle="tooltip"]'
	// });

	// Define global variable ajaxData
	var ajaxData = { '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' };

	//Handle edit click of every column
	$('body').on('click', '.edit', function(event) {
		var elem = $(this),
		div = elem.parent();
		
		div.addClass('hidden');

		//Call function to create form
		div.after('<form class="editForm" class="text-left" style="min-width:200px;">\
			<img src="<?php echo base_url(); ?>include/app-assets/images/measure_loader.svg" alt="Loading Data... Please Wait..." height="40" width="40">\
			<h6 class="text-center">Please Wait...</h6>\
		</form>');

		//Show/Hide save all button
		showHideSaveAll(div.closest('.table'));
		//Call function to fill the form
		fillEditForm(div);
	}).on('click', '.cancelEdit', function(event) {
		var elem = $(this),
		form = elem.closest('form');

		//Show/Hide save all button
		showHideSaveAll(form.closest('.table'), 'remove');

		form.prev().find('.field_value').html(form.data('field_value'));
		form.prev().removeClass('hidden');
		form.remove();
	});

	//Reset reason form
	$('#reasonModal').on('shown.bs.modal', function () {
		$('#reasonForm')[0].reset();
	});

	//Hamdle reasonForm submit
	$('body').on('submit', '#reasonForm', function(event) {
		event.preventDefault();
		var elem = $(this),
		reason = elem.find('[name="reason"]').val();
		elem.find('.error').empty();

		if(reason.length === 0) {
			elem.find('.error.reason').html('Reason for editing data is mandatory.');
			return false;
		}

		$('body').find('.editForm').each(function(index) {
			var individualReason = $(this).find('[name="reason"]');
			if(individualReason.val().length === 0) individualReason.val(reason);
		});
		$('#reasonModal').modal('hide');
		$('.saveAll').prop('disabled', true);
		$('body').find('.editForm').trigger('submit');
	});

	//Handle edit click of every column
	$('body').on('submit', '.editForm', function(event) {
		event.preventDefault();
		var elem = $(this),
		group = elem.data('group'),
		field = elem.data('field');
		survey_id = "<?php echo($this->uri->segment(3)); ?>";
		elem.find('.error').empty();

		//Validate fields
		var error = 0;
		if(elem.data('required') == 1) {
			switch(elem.data('type')) {
				case 'text':
				case 'number':
				case 'select':
				case 'scanner':
				case 'textarea':
					if(elem.find('.field_'+field).val().length === 0) {
						elem.find('.error.field_'+field).html('Field is mandatory.');
						error++;
					}
				break;

				case 'lkp_gender':
				case 'radio-group':
				case 'checkbox-group':
					if(elem.find('.field_'+field+':checked').length == 0) {
						elem.find('.error.field_'+field).html('Selection is mandatory.');
						error++;
					}
				break;
			}
		}
		if(error > 0) return false;

		var formData = new FormData(elem[0]);
		formData.append('group', group);
		formData.append('field_id', field);
		formData.append('survey_id', survey_id);

		elem.find('button').prop('disabled', true);
		elem.find('button[type="submit"]').html('Please wait...');
		$.ajax({
			url: '<?php echo base_url(); ?>reports/edit_groupdata/',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			complete: function(data) {
				var csrfData = JSON.parse(data.responseText);
				ajaxData[csrfData.csrfName] = csrfData.csrfHash;
				if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
					$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
				}
			},
			error: function() {
				elem.find('button').prop('disabled', false);
				elem.find('button[type="submit"]').html('Save');
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error'
				});
			},
			success: function(data) {
				var data = JSON.parse(data);

				// If session error exists
				if(data.session_err == 1) {
					$.toast({
						heading: 'Session Error!',
						text: data.msg,
						icon: 'error',
						afterHidden: function () {
							elem.find('button').prop('disabled', false);
							elem.find('button[type="submit"]').html('Save');
						}
					});
				}

				if(data.status == 1) {
					// If update completed
					$.toast({
						heading: 'Success!',
						text: data.msg,
						icon: 'success',
						afterHidden: function () {
							elem.find('button').prop('disabled', false);
							elem.find('button[type="submit"]').html('Save');
							
							elem.data('field_value', data.field_value);
							elem.find('.cancelEdit').trigger('click');
						}
					});
				} else if(data.status == 0) {
					$.toast({
						heading: 'Error!',
						text: data.msg,
						icon: 'error',
						afterHidden: function () {
							elem.find('button').prop('disabled', false);
							elem.find('button[type="submit"]').html('Save');
						}
					});
				}
			}
		});
	});

	//Function to show/hide save all button
	function showHideSaveAll(table, remove) {
		var totalForms = table.find('.editForm').length;
		if(remove) totalForms = totalForms - 1;

		table.closest('.card').parent().find('.saveAll').removeClass('active');
		if(totalForms > 1) {
			table.closest('.card').parent().find('.saveAll').prop('disabled', false);
			table.closest('.card').parent().find('.saveAll').removeClass('hidden');
		} else {
			table.closest('.card').parent().find('.saveAll').addClass('hidden');
		}
	}

	//Function to fill form
	function fillEditForm(elem) {
		form = elem.next('form');
		
		//AJAX to get submitted data
		ajaxData['group_id'] = elem.data('group');
		ajaxData['field_id'] = elem.data('field');
		ajaxData['survey_id'] = "<?php echo($this->uri->segment(3)); ?>";
		$.ajax({
			url: '<?php echo base_url(); ?>reports/get_group_details_for_edit/',
			data: ajaxData,
			type: 'POST',
			dataType: 'json',
			complete: function(data) {
				var csrfData = JSON.parse(data.responseText);
				ajaxData[csrfData.csrfName] = csrfData.csrfHash;
				if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
					$('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
				}
			},
			error: function() {
				$.toast({
					heading: 'Network Error!',
					text: 'Could not establish connection to server. Please refresh the page and try again.',
					icon: 'error',
					afterHidden: function () {
						form.remove();
						elem.removeClass('hidden');
					}
				});
			},
			success: function(data) {
				// If session error exists
				if(data.session_err == 1) {
					$.toast({
						heading: 'Session Error!',
						text: data.msg,
						icon: 'error',
						afterHidden: function () {
							form.remove();
							elem.removeClass('hidden');
						}
					});
					return false;
				}
				
				if(data.status == 0) {
					$.toast({
						heading: 'Error!',
						text: data.msg,
						icon: 'error',
						afterHidden: function () {
							form.remove();
							elem.removeClass('hidden');
						}
					});
					return false;
				}

				form.data('type', data.field_details.type);
				form.data('group', elem.data('group'));
				form.data('field', elem.data('field'));
				if(data.field_details.required == 1) {
					form.data('required', 1);
				} else {
					form.data('required', 0);
				}
				
				if(data.group_data == null){
					var fieldValue = '';
				}else{
					var groupData = JSON.parse(data.group_data.formgroup_data),
					fieldValue = groupData['field_'+data.field_details.field_id] == null ? '' : groupData['field_'+data.field_details.field_id];
				}				
				
				if(fieldValue.length === 0) form.data('field_value', 'N/A');
				else form.data('field_value', fieldValue);
				
				var formHTML = '<div class="form-group">\
					<label>'+data.field_details.label+'</label>';
					if(data.field_details.required == 1) {
						formHTML += '<font color="red">*</font>';
					}
					if(data.field_details.description) {
						formHTML += '<i data-toggle="tooltip" data-title="'+data.field_details.description+'" class="fa fa-question-circle ml-1" aria-hidden="true"></i>';
					}
					switch(data.field_details.type) {
						case 'text':
						case 'number':
						case 'scanner':
							formHTML += '<input type="'+data.field_details.subtype+'" name="field_'+data.field_details.field_id+'" class="'+data.field_details.className+' field_'+data.field_details.field_id+' input-sm" value="'+fieldValue+'">';
						break;

						case 'textarea':
							formHTML += '<textarea name="field_'+data.field_details.field_id+'" class="'+data.field_details.className+' field_'+data.field_details.field_id+' input-sm" >'+fieldValue+'</textarea>';
						break;

						case 'select':
							var fieldValueArray = fieldValue.split('&#44;');
							if(data.field_details.multiple == 'true') {
							formHTML += '<select name="field_'+data.field_details.field_id+'[]" multiple class="form-control field_'+data.field_details.field_id+' input-sm">';
							} else {
							formHTML += '<select name="field_'+data.field_details.field_id+'" class="form-control field_'+data.field_details.field_id+' input-sm">';
							}
							data.field_details.options.forEach(function(option, index) {
								var selected = fieldValueArray.includes(option['value']) ? 'selected' : '';
								formHTML += '<option value="'+option['value']+'" '+selected+'>'+option['label']+'</option>';
							});
							formHTML += '</select>';
						break;
						
						case 'radio-group':
							var fieldValueArray = fieldValue.split('&#44;');
							data.field_details.options.forEach(function(option, index) {
								var checked = fieldValueArray.includes(option['value']) ? 'checked' : '';
								formHTML += '<div class="custom-control custom-radio">\
									<input type="radio" class="custom-control-input field_'+data.field_details.field_id+'" name="field_'+data.field_details.field_id+'" id="'+data.field_details.field_id+'_'+option['value']+'" value="'+option['value']+'" '+checked+'>\
									<label class="custom-control-label" for="'+data.field_details.field_id+'_'+option['value']+'">'+option['label']+'</label>\
								</div>';
							});
							break;

						case 'checkbox-group':
							var fieldValueArray = fieldValue.split('&#44;');
							data.field_details.options.forEach(function(option, index) {
								var checked = fieldValueArray.includes(option['value']) ? 'checked' : '';
								formHTML += '<div class="custom-control custom-checkbox">\
									<input type="checkbox" class=" field_'+data.field_details.field_id+'" name="field_'+data.field_details.field_id+'[]" id="'+data.field_details.field_id+'_'+option['value']+'" value="'+option['value']+'" '+checked+'>\
									<label class="" for="'+data.field_details.field_id+'_'+option['value']+'">'+option['label']+'</label>\
								</div>';
							});
							break;

						case 'lkp_trait':
							var fieldValueArray = fieldValue.split('&#44;');
							data.field_details.options.forEach(function(option, index) {
								var checked = fieldValueArray.includes(option['trait_description']) ? 'checked' : '';
								formHTML += '<div class="custom-control custom-checkbox">\
								<label class="" for="'+data.field_details.field_id+'_'+option['trait_description']+'">\
									<input type="checkbox" class=" field_'+data.field_details.field_id+'" name="field_'+data.field_details.field_id+'[]" id="'+data.field_details.field_id+'_'+option['trait_description']+'" value="'+option['trait_description']+'" '+checked+'>'+option['trait_name']+'</label>\
								</div>';
							});
							break;

						case 'lkp_trait2':
							var fieldValueArray = fieldValue.split('&#44;');
							data.field_details.options.forEach(function(option, index) {
								var checked = fieldValueArray.includes(option['trait2_description']) ? 'checked' : '';
								formHTML += '<div class="custom-control custom-checkbox">\
									<input type="checkbox" class=" field_'+data.field_details.field_id+'" name="field_'+data.field_details.field_id+'[]" id="'+data.field_details.field_id+'_'+option['trait2_description']+'" value="'+option['trait2_description']+'" '+checked+'>\
									<label class="" for="'+data.field_details.field_id+'_'+option['trait2_description']+'">'+option['trait2_name']+'</label>\
								</div>';
							});
							break;

						case 'lkp_headquarter':
							var fieldValueArray = fieldValue.split('&#44;');
							if(data.field_details.multiple == 'true') {
							formHTML += '<select name="field_'+data.field_details.field_id+'[]" multiple class="form-control field_'+data.field_details.field_id+' input-sm">';
							} else {
							formHTML += '<select name="field_'+data.field_details.field_id+'" class="form-control field_'+data.field_details.field_id+' input-sm">';
							}
							data.field_details.options.forEach(function(option, index) {
								var selected = fieldValueArray.includes(option['headquarter_id']) ? 'selected' : '';
								formHTML += '<option value="'+option['headquarter_id']+'" '+selected+'>'+option['headquarter_name']+'</option>';
							});
							formHTML += '</select>';
							break;

						case 'lkp_country':
							var fieldValueArray = fieldValue.split('&#44;');
							if(data.field_details.multiple == 'true') {
							formHTML += '<select name="field_'+data.field_details.field_id+'[]" multiple class="form-control field_'+data.field_details.field_id+' input-sm">';
							} else {
							formHTML += '<select name="field_'+data.field_details.field_id+'" class="form-control field_'+data.field_details.field_id+' input-sm">';
							}
							data.field_details.options.forEach(function(option, index) {
								var selected = fieldValueArray.includes(option['country_id']) ? 'selected' : '';
								formHTML += '<option value="'+option['country_id']+'" '+selected+'>'+option['country_name']+'</option>';
							});
							formHTML += '</select>';
							break;
					}
					formHTML += '<p class="error red-800 m-0 field_'+data.field_details.field_id+'"></p>\
				</div>\
				<div class="mt-10">\
					<button type="submit" class="btn btn-sm btn-success">Save</button>\
					<button type="button" class="btn btn-sm btn-danger cancelEdit pull-right">Cancel</button>\
				</div>';
				
				form.html(formHTML);
				form.addClass('text-left');
			}
		});
	}

	$('body').on('change', 'input[type=radio]', function() {
		$elem = $(this);

		var field_id = $(this).attr("data-field_id");
		var field_value = $(this).attr("data-field_value");
		var fieldtype = $(this).attr("data-fieldtype");
		if(fieldtype == 'groupfield'){
			var groupfieldcount = $(this).attr("data-groupfieldcount");
		}else{
			var groupfieldcount = "";
		}

		var classname = 'childof'+field_id;
		if(fieldtype == 'groupfield'){
			$elem.closest('.row').find('.'+classname).html('');
		}else{
			$('.'+classname).html('');
		}

		var calltype = 'onchange';

		var data = {
			field_id : field_id,
			field_value : field_value,
			calltype : calltype,
			fieldtype : fieldtype,
			groupfieldcount : groupfieldcount
		}
		
		getchild_field(data, $elem);
	});

	$('body').on('change', 'input[type=checkbox]', function() {
		
		$elem = $(this);

		var field_id = $(this).attr("data-field_id");
		var fieldtype = $(this).attr("data-fieldtype");
		var maxlength = $(this).attr("data-maxlength");

		if(fieldtype == 'groupfield'){
			var groupfieldcount = $(this).attr("data-groupfieldcount");
		}else{
			var groupfieldcount = "";
		}

		var name = $(this).attr("name");
		var calltype = 'onchange';

		var classname = 'childof'+field_id;
		if(fieldtype == 'groupfield'){
			$elem.closest('.row').find('.'+classname).html('');
		}else{
			$('.'+classname).html('');
		}

		var checkedvalues = [];
		$.each($("input[name='"+name+"']:checked"), function(){
			checkedvalues.push($(this).val());
		});

		var field_value = checkedvalues;
		if (maxlength != 'null') {
			if (parseInt(maxlength) < parseInt(checkedvalues.length)) {
				$elem.closest('.form-group').find('.error').html('Please select only ' + maxlength + ' option.');
				$("input[name='"+name+"']").prop("checked", false);
			} else {
				if (field_value != '') {
					var data = {
						field_id : field_id,
						field_value : field_value,
						calltype : calltype,
						fieldtype : fieldtype,
						groupfieldcount : groupfieldcount
					}
					getchild_field(data, $elem);
				}
			}
		}else{
			if(field_value != ''){
				var data = {
					field_id : field_id,
					field_value : field_value,
					calltype : calltype,
					fieldtype : fieldtype,
					groupfieldcount : groupfieldcount
				}
				getchild_field(data, $elem);
			}
			
			
		}
		if(field_value == ''){
			var classname = 'childof'+field_id;
			$elem.closest('.addmore').find('.' + classname).empty();
		}
	});

	$('body').on('change', '.selectbox', function() {
		$elem = $(this);

		$elem.closest('.form-group').find('.error').empty();

		var field_id = $(this).attr("data-field_id");
		var fieldtype = $(this).attr("data-fieldtype");
		var maxlength = $(this).attr("data-maxlength");

		if(fieldtype == 'groupfield'){
			var groupfieldcount = $(this).attr("data-groupfieldcount");
		}else{
			var groupfieldcount = "";
		}

		var name = $(this).attr("name");
		var calltype = 'onchange';

		var classname = 'childof'+field_id;
		if(fieldtype == 'groupfield'){
			$elem.closest('.row').find('.'+classname).html('');
		}else{
			$('.'+classname).html('');
		}

		var checkedvalues = [];
		$.each($("select[name='"+name+"'] option:selected"), function(){
			if($(this).val() != ''){
				checkedvalues.push($(this).val());
			}
		});

		var field_value = checkedvalues;
		if(maxlength != 'null'){
			if(parseInt(maxlength) < parseInt(checkedvalues.length)){
				$elem.closest('.form-group').find('.error').html('Please select only '+maxlength+' option.');

				$elem.val('');
			}else{
				if(field_value != ''){
					var data = {
						field_id : field_id,
						field_value : field_value,
						calltype : calltype,
						fieldtype : fieldtype,
						groupfieldcount : groupfieldcount                           
					}

					getchild_field(data, $elem);
				}
			}
		}else{
			if(field_value != ''){
				var data = {
					field_id : field_id,
					field_value : field_value,
					calltype : calltype,
					fieldtype : fieldtype,
					groupfieldcount : groupfieldcount                       
				}

				getchild_field(data, $elem);
			}
		}            
	});
	$('body').on('submit', '#addForm', function(event) {
        //    alert("hello");
		event.preventDefault();
		 $('button[name="submit"]').prop('disabled', true);
		 $('button[name="submit"]').html('Please wait...');
		 $('.error').html('');
		 var surveycount = 0;
		 if(surveycount == 0){
			var metaForm = new FormData($('#addForm')[0]);

			$.ajax({
				url: '<?php echo base_url(); ?>reports/groupdata_upload/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(6); ?>',
				type: 'POST',
				dataType : 'json',
				data: metaForm,
				processData: false,
				contentType: false,
				error: function(e) {
					console.log(e);
					$('.loading').parent().addClass('hidden');
					$('button[name="submit"]').prop('disabled', false);
					$('button[name="submit"]').html('Error');
				},
				success: function(response) {
					//alert("on empty");
					// If insert completed
					if(response.status == 1){
						$.toast({
							heading: 'Success!',
							text: response.msg,
							icon: 'success',
							afterHidden: function () {
								$('#addForm input[type="tel"]').val('');
								$('#addForm input[type="text"]').val('');
								$('#addForm input[type="email"]').val('');
								$('#addForm input[type="file"]').val('');
								$('#addForm select').val('');
								$('#addForm textarea').val('');
								$('.phonenumber').html('');
								$('.groupfields').html('');
								$('#addForm input[type="checkbox"]').each(function() {
									this.checked = false;
								});
								$('#addForm input[type="radio"]').each(function() {
									this.checked = false;
								});
								$('#holder').html('');

								$('.childfields').html('');

								$('button[name="submit"]').prop('disabled', false);
								$('button[name="submit"]').html('Submit Data');

								location.reload();
							}
						});
					}else{
						$.toast({
							heading: 'Network Error!',
							text: 'Something wrong please try after some time.',
							icon: 'error',
							afterHidden: function () {
								$('button[name="submit"]').prop('disabled', false);
								$('button[name="submit"]').html('Submit Data');
							}
						});	
					}
					$('.loading').parent().addClass('hidden');
				}
			});
		 }else{
			 $('html,body').animate({
				 scrollTop: $("$addForm").offset().top - 300
			 }, 500);
			 $('button[name="submit"]').html('<i class="fa fa-upload" aria-hidden="true"></i> Submit Data');
			 $('button[name="submit"]').prop('disabled', false);
		 }
	});

	$('body').on('submit', '#excelForm', function(event) {
        //    alert("hello");
		event.preventDefault();
		 $('button[name="submit"]').prop('disabled', true);
		 $('button[name="submit"]').html('Please wait...');
		 $('.error').html('');
		 var surveycount = 0;
		 if(surveycount == 0){
			var metaForm = new FormData($('#excelForm')[0]);

			$.ajax({
				url: '<?php echo base_url(); ?>reports/groupdata_excel_upload/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $group_field_id; ?>/<?php echo $this->uri->segment(6); ?>',
				type: 'POST',
				dataType : 'json',
				data: metaForm,
				processData: false,
				contentType: false,
				error: function(e) {
					console.log(e);
					$('.loading').parent().addClass('hidden');
					$('button[name="submit"]').prop('disabled', false);
					$('button[name="submit"]').html('Error');
				},
				success: function(response) {
					//alert("on empty");
					// If insert completed
					if(response.status == 1){
						$.toast({
							heading: 'Success!',
							text: response.msg,
							icon: 'success',
							afterHidden: function () {
								$('#excelForm input[type="tel"]').val('');
								$('#excelForm input[type="text"]').val('');
								$('#excelForm input[type="email"]').val('');
								$('#excelForm input[type="file"]').val('');
								$('#excelForm select').val('');
								$('#excelForm textarea').val('');
								$('.phonenumber').html('');
								$('.groupfields').html('');
								$('#excelForm input[type="checkbox"]').each(function() {
									this.checked = false;
								});
								$('#excelForm input[type="radio"]').each(function() {
									this.checked = false;
								});
								$('#holder').html('');

								$('.childfields').html('');

								$('button[name="submit"]').prop('disabled', false);
								$('button[name="submit"]').html('Submit Data');

								location.reload();
							}
						});
					}else{
						$.toast({
							heading: 'Network Error!',
							text: 'Something wrong please try after some time.',
							icon: 'error',
							afterHidden: function () {
								$('button[name="submit"]').prop('disabled', false);
								$('button[name="submit"]').html('Submit Data');
							}
						});	
					}
					$('.loading').parent().addClass('hidden');
				}
			});
		 }else{
			 $('html,body').animate({
				 scrollTop: $("$excelForm").offset().top - 300
			 }, 500);
			 $('button[name="submit"]').html('<i class="fa fa-upload" aria-hidden="true"></i> Submit Data');
			 $('button[name="submit"]').prop('disabled', false);
		 }
	});
</script>