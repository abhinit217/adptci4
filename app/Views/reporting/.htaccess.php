    <style type="text/css">
        label{
            font-weight: bold;
        }
    </style>
    <script type="text/javascript">
        function getchild_field(data, $elem) {
            var classname = 'childof'+data.field_id;
            var fieldtype = data.fieldtype;

            $.ajax({
                url: "<?php echo base_url(); ?>reporting/check_childfields",
                type: "POST",
                dataType: "json",
                data : {
                   field_id : data.field_id,
                   field_value : data.field_value,
                   calltype : data.calltype,
                   year_val : data.year_val,
                   form_id : <?php echo $this->uri->segment('3'); ?>
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
                                        CHILD_HTML += '<div class="col-md-4">\
                                            <div class="form-group">\
                                                <label class="english">'+field.label;
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
                                                            CHILD_HTML += '<div class="col-md-4">';
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
                                                                CHILD_HTML += '<label class="'+radioclass+'" >\
                                                                    <input type="radio" name="'+radioname+'"  class="'+inputradioclass+'" value = "'+option.value+'" '+selectedvalue+' style="margin-right: 5px;" data-field_id = "'+field.field_id+'" data-field_value = "'+option.value+'" data-required = "'+requiredval+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" data-indicatorid="'+data.indicatorid+'" data-subindicatorid="'+data.subindicatorid+'">'+option.label+'\
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
                                        CHILD_HTML += '<div class="col-md-4">\
                                            <div class="form-group">\
                                                <label class="english">'+field.label;
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
                                                            CHILD_HTML += '<div class="col-md-4">';
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
                                                                CHILD_HTML += '<label class="'+radioclass+'" >\
                                                                    <input type="checkbox" name="'+checkbox_name+'"  class="'+inputcheckboxclass+'" value = "'+option.value+'" '+selectedvalue+' style="margin-right: 5px;" data-field_id = "'+field.field_id+'" data-field_value = "'+option.value+'" data-required = "'+requiredval+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" data-indicatorid="'+data.indicatorid+'" data-subindicatorid="'+data.subindicatorid+'">'+option.label+'\
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

                                    case 'select':
                                        CHILD_HTML += '<div class="col-md-4">\
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
                                                CHILD_HTML += '<select name="'+select_name+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+requiredval+'" data-field_id = "'+field.field_id+'" data-indicatorid="'+data.indicatorid+'" data-subindicatorid="'+data.subindicatorid+'" data-fieldtype="'+data.fieldtype+'" data-groupfieldcount="'+data.groupfieldcount+'" data-maxlength ="'+field.maxlength+'">';
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
                                        if(field.child_count > 0){
                                            CHILD_HTML += '<div class="col-md-12">\
                                                <div class="row childfields childof'+field.field_id+'"></div>\
                                            </div>';
                                        }
                                        break;

                                    case 'number':
                                        CHILD_HTML += '<div class="col-md-4">\
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
                                        CHILD_HTML += '<div class="col-md-4">\
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
                                        CHILD_HTML += '<div class="col-md-4">\
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
                                        CHILD_HTML += '<div class="col-md-4">\
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
                                        CHILD_HTML += '<div class="col-md-4">\
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

                                    case 'uploadgroupdata_excel':
                                        CHILD_HTML += '<div class="col-md-12" style="margin-bottom: 15px;">\
                                            <a class="btn-success btn-sm uploadgroupdata_excel" style="color: #FFFFFF !important;" data-subindicatorid="'+field.subindicator_id+'" data-indicatorid="'+field.indicator_id+'" target="_blank">Upload data using excel</a>\
                                        </div>';
                                        break;

                                    case 'group': 
                                        CHILD_HTML += '<div class="col-md-12 addmoremaindiv">\
                                            <div class="row addmore addmore_div">';
                                                var indicator_groupfieldscount = field.groupfields.length;
                                                var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
                                                CHILD_HTML += '<div class="col-md-'+i_divmainclass+'">\
                                                    <div class="row">';
                                                        field.groupfields.forEach(function(indicatorgroupfield, g_index){
                                                            if(indicator_groupfieldscount == 1){
                                                                var i_divclass = 12
                                                            }else if(indicator_groupfieldscount == 2){
                                                                var i_divclass = 6;
                                                            }else if(indicator_groupfieldscount == 3){
                                                                var i_divclass = 4;
                                                            }else{
                                                                var i_divclass = 3;
                                                            }
                                                            switch(indicatorgroupfield.type){
                                                                case 'text':
                                                                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                        <div class="form-group">';
                                                                            CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                            if(indicatorgroupfield.description != null){
                                                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                            }
                                                                            CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="" data-subtype="'+indicatorgroupfield.subtype+'">\
                                                                            <p class="error red-800"></p>\
                                                                            <p class="maxlengtherror red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                                    break;

                                                                case 'textarea' :
                                                                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                        <div class="form-group">';
                                                                            CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                            if(indicatorgroupfield.description != null){
                                                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                            }
                                                                            var inputclass = (indicatorgroupfield.className != '') ? indicatorgroupfield.className : "";
                                                                            var requiredval = (indicatorgroupfield.required == 1) ? "required" : "notrequired";

                                                                            if(typeof indicatorgroupfield.value !== 'undefined' && indicatorgroupfield.value != null){
                                                                                var columnfield = "field_"+indicatorgroupfield.field_id;
                                                                                var textfield_value = indicatorgroupfield.value;
                                                                            }else{
                                                                                var textfield_value = '';
                                                                            }
                                                                            CHILD_HTML += '<textarea name="field_'+indicatorgroupfield.field_id+'[0]" rows="8" class="'+inputclass+'" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required="'+requiredval+'">'+textfield_value+'</textarea>';
                                                                            CHILD_HTML += '<p class="error red-800"></p>\
                                                                            <p class="maxlengtherror red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                                    break;

                                                                case 'select':
                                                                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                        <div class="form-group">';
                                                                            CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                            if(indicatorgroupfield.description != null){
                                                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                            }
                                                                            if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
                                                                                var selectname = "field_"+indicatorgroupfield.field_id+"[0][]";
                                                                                var selectmultiple = "multiple";
                                                                            }else{
                                                                                var selectname = "field_"+indicatorgroupfield.field_id+"[0]";
                                                                                var selectmultiple = "";
                                                                            } 
                                                                            CHILD_HTML +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorgroupfield.field_id+'"   data-fieldtype="groupfield" data-groupfieldcount = "0" data-maxlength ="'+indicatorgroupfield.maxlength+'">';
                                                                            if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
                                                                            }else{
                                                                                CHILD_HTML += '<option value="">Select an option</option>';
                                                                            }
                                                                            indicatorgroupfield.options.forEach(function(option, index){
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
                                                                    if(indicatorgroupfield.child_count > 0){
                                                                        CHILD_HTML += '<div class="col-md-12">\
                                                                            <div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
                                                                        </div>';
                                                                    }
                                                                    break;

                                                                case 'radio-group':
                                                                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                        <div class="form-group">';
                                                                            CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                            if(indicatorgroupfield.description != null){
                                                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                            }
                                                                            CHILD_HTML += '<div class="form-check">\
                                                                                <div class="row">';
                                                                                    indicatorgroupfield.options.forEach(function(option, index){
                                                                                        var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                                                        if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                            var radio_value = "checked"; 
                                                                                        }else{
                                                                                            var radio_value = '';
                                                                                        }
                                                                                        CHILD_HTML += '<div class="col-md-6">\
                                                                                            <label><input type="radio" name="field_'+indicatorgroupfield.field_id+'[0]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>\
                                                                                        </div>';
                                                                                    });
                                                                                CHILD_HTML += '</div>\
                                                                            </div>\
                                                                            <p class="error red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                                    if(indicatorgroupfield.child_count > 0){
                                                                        CHILD_HTML += '<div class="col-md-12">\
                                                                            <div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
                                                                        </div>';
                                                                    }
                                                                    break;

                                                                case 'checkbox-group':
                                                                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                        <div class="form-group">';
                                                                            CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                            if(indicatorgroupfield.description != null){
                                                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                            }
                                                                            CHILD_HTML += '<div class="form-check row">\
                                                                                <div class="col-md-12">';
                                                                                    indicatorgroupfield.options.forEach(function(option, index){
                                                                                        var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                                                        if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                            var radio_value = "checked"; 
                                                                                        }else{
                                                                                            var radio_value = '';
                                                                                        }
                                                                                        CHILD_HTML += '<label><input type="checkbox" name="field_'+indicatorgroupfield.field_id+'[0][]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>';
                                                                                    });
                                                                                CHILD_HTML += '</div>\
                                                                            </div>\
                                                                            <p class="error red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                                    if(indicatorgroupfield.child_count > 0){
                                                                        CHILD_HTML += '<div class="col-md-12">\
                                                                            <div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
                                                                        </div>';
                                                                    }
                                                                    break;

                                                                case 'number':
                                                                    CHILD_HTML += '<div class="col-md-'+i_divclass+'">\
                                                                        <div class="form-group">';
                                                                            CHILD_HTML += '<label>'+(g_index+1)+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                            if(indicatorgroupfield.description != null){
                                                                                CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                            }
                                                                            switch (indicatorgroupfield.subtype) {
                                                                                case 'desimal':
                                                                                    CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' decimal" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                    break;

                                                                                case 'number':
                                                                                    CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' number" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                    break;

                                                                                case 'latitude':
                                                                                    CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                    break;

                                                                                case 'longitude':
                                                                                    CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                                    break;
                                                                                
                                                                                default:
                                                                                    CHILD_HTML += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' numberfield" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
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

                            console.log(CHILD_HTML);
                            

                            if(fieldtype == 'groupfield'){
                                $elem.closest('.row').find('.'+classname).html(CHILD_HTML);
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
                                format: 'yyyy-mm',
                                autoclose: true,
                                viewMode: "months", 
                                minViewMode: "months"
                            });

                        }
                    }else{
                        if(fieldtype == 'groupfield'){
                            $elem.closest('.row').find('.'+classname).html('<p align="center" class="red-800">'+response.msg+'</p>');

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
    <div class="app-content page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 pl-0 pr-0 mb-5">
                    <div class="p-3 pl-0 bg-light border border-bottom-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="<?php echo base_url(); ?>dashboard" class="btn btn-sm btn-warning mb-2 pull-right"><i class="fa fa-arrow-left"></i> Back</a>
                                <h5 class="mb-5 mt-2 text-dark lh-25px"> <?php echo $form_details['title']; ?></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body p-15px indicatorfields">
                                        
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

<script type="text/javascript">
    $(function(){

        var form_fields = <?php echo json_encode($indicator_fields); ?>;
        var form_id = <?php echo $this->uri->segment(3); ?>;
        var i = 1;
        var indicator_fields = `<form id="submit_data">
            <div class="row">`;        
                form_fields.forEach(function(indicatorfield, ifindex){
                    console.log(indicatorfield);
                    if(indicatorfield.parent_id == null){
                        switch(indicatorfield.type){
                            case 'group': 
                                indicator_fields += '<div class="col-md-12 addmoremaindiv">';
                                    var grouplabel = (indicatorfield.field_count == 1) ? i++ : i;
                                    if(indicatorfield.field_count == 1){
                                        var label = grouplabel+'. '+indicatorfield.label;
                                    }else{
                                        var label = indicatorfield.label;
                                    }
                                    indicator_fields += '<label>'+label+'</label>\
                                    <div class="row addmore addmore_div">';
                                        var indicator_groupfieldscount = indicatorfield.groupfields.length;
                                        var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
                                        indicator_fields += '<div class="col-md-'+i_divmainclass+'">\
                                            <div class="row">';
                                                indicatorfield.groupfields.forEach(function(indicatorgroupfield, ig_index){
                                                    if(indicator_groupfieldscount == 1){
                                                        var i_divclass = 12
                                                    }else if(indicator_groupfieldscount == 2){
                                                        var i_divclass = 6;
                                                    }else if(indicator_groupfieldscount == 3){
                                                        var i_divclass = 4;
                                                    }else{
                                                        var i_divclass = 3;
                                                    }
                                                    switch(indicatorgroupfield.type){
                                                        case 'text':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="" data-subtype="'+indicatorgroupfield.subtype+'">\
                                                                    <p class="error red-800"></p>\
                                                                    <p class="maxlengtherror red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            break;

                                                        case 'textarea':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    indicator_fields += '<textarea name="field_'+indicatorgroupfield.field_id+'[0]" rows="8" class="'+indicatorgroupfield.className+'" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'"></textarea>\
                                                                    <p class="error red-800"></p>\
                                                                    <p class="maxlengtherror red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            break;

                                                        case 'select':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
                                                                        var selectname = "field_"+indicatorgroupfield.field_id+"[0][]";
                                                                        var selectmultiple = "multiple";
                                                                    }else{
                                                                        var selectname = "field_"+indicatorgroupfield.field_id+"[0]";
                                                                        var selectmultiple = "";
                                                                    } 
                                                                    indicator_fields +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorgroupfield.field_id+'"   data-fieldtype="groupfield" data-groupfieldcount = "0" data-maxlength ="'+indicatorgroupfield.maxlength+'">';
                                                                    if(indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE'){
                                                                    }else{
                                                                        indicator_fields += '<option value="">Select an option</option>';
                                                                    }
                                                                    indicatorgroupfield.options.forEach(function(option, index){
                                                                        if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                            var select_value = "selected"; 
                                                                        }else{
                                                                            var select_value = '';
                                                                        }
                                                                        indicator_fields += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
                                                                    });
                                                                    indicator_fields += '</select>\
                                                                    <p class="error red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            if(indicatorgroupfield.child_count > 0){
                                                                indicator_fields += '<div class="col-md-12">\
                                                                    <div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
                                                                </div>';
                                                            }
                                                            break;

                                                        case 'radio-group':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    indicator_fields += '<div class="form-check">\
                                                                        <div class="row">';
                                                                            indicatorgroupfield.options.forEach(function(option, index){
                                                                                var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                                                if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                    var radio_value = "checked"; 
                                                                                }else{
                                                                                    var radio_value = '';
                                                                                }
                                                                                indicator_fields += '<div class="col-md-6">\
                                                                                    <label><input type="radio" name="field_'+indicatorgroupfield.field_id+'[0]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>\
                                                                                </div>';
                                                                            });
                                                                        indicator_fields += '</div>\
                                                                    </div>\
                                                                    <p class="error red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            if(indicatorgroupfield.child_count > 0){
                                                                indicator_fields += '<div class="col-md-12">\
                                                                    <div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
                                                                </div>';
                                                            }
                                                            break;

                                                        case 'checkbox-group':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    indicator_fields += '<div class="form-check row">\
                                                                        <div class="col-md-12">';
                                                                            indicatorgroupfield.options.forEach(function(option, index){
                                                                                var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                                                if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                                                    var radio_value = "checked"; 
                                                                                }else{
                                                                                    var radio_value = '';
                                                                                }
                                                                                indicator_fields += '<label><input type="checkbox" name="field_'+indicatorgroupfield.field_id+'[0][]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorgroupfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="groupfield" data-groupfieldcount = "0">'+option.label+'</label>';
                                                                            });
                                                                        indicator_fields += '</div>\
                                                                    </div>\
                                                                    <p class="error red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            if(indicatorgroupfield.child_count > 0){
                                                                indicator_fields += '<div class="col-md-12">\
                                                                    <div class="row childfields childof'+indicatorgroupfield.field_id+'"></div>\
                                                                </div>';
                                                            }
                                                            break;

                                                        case 'number':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    switch (indicatorgroupfield.subtype) {
                                                                        case 'desimal':
                                                                            indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' decimal" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                            break;

                                                                        case 'number':
                                                                            indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' number" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-maxvalue = "'+indicatorgroupfield.max_val+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                            break;

                                                                        case 'latitude':
                                                                            indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                            break;

                                                                        case 'longitude':
                                                                            indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' latlong" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                            break;
                                                                        
                                                                        default:
                                                                            indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' numberfield" data-subtype="'+indicatorgroupfield.subtype+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" data-required = "'+(indicatorgroupfield.required == 1 ? "required" : "")+'" value="" >';
                                                                            break;
                                                                    }
                                                                    indicator_fields += '<p class="error red-800"></p>\
                                                                    <p class="maxlengtherror red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            break;

                                                        case 'date':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' picker" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="" data-subtype="'+indicatorgroupfield.subtype+'" onkeydown="return false" autocomplete="off">\
                                                                    <p class="error red-800"></p>\
                                                                    <p class="maxlengtherror red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            break;

                                                        case 'month':
                                                            indicator_fields += '<div class="col-md-'+i_divclass+'">\
                                                                <div class="form-group">';
                                                                    var questionno = convertToNumerals(ig_index+1);
                                                                    indicator_fields += '<label>'+questionno.toLowerCase()+'. '+indicatorgroupfield.label+''+(indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                                                    if(indicatorgroupfield.description != null){
                                                                        indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorgroupfield.description+'</p>';
                                                                    }
                                                                    indicator_fields += '<input type="text" name="field_'+indicatorgroupfield.field_id+'[0]" class="'+indicatorgroupfield.className+' monthpicker" data-required="'+(indicatorgroupfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorgroupfield.maxlength+'" value="" data-subtype="'+indicatorgroupfield.subtype+'" onkeydown="return false" autocomplete="off">\
                                                                    <p class="error red-800"></p>\
                                                                    <p class="maxlengtherror red-800"></p>\
                                                                </div>\
                                                            </div>';
                                                            break;

                                                    }       
                                                });
                                            indicator_fields += '</div>\
                                        </div>\
                                        <div class="col-md-1 mt-20 add_remove_button">\
                                            <button type="button" class="btn btn-success btn-sm addmorefields pull-left"  style="margin-bottom: 15px; margin-top:10px;"><span class="glyphicon glyphicon-plus"></span> Add\
                                            </button>\
                                        </div>\
                                    </div>\
                                </div>';
                                break;

                            //display of text box field
                            case 'text':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var textquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = textquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+'" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="" data-subtype="'+indicatorfield.subtype+'" >\
                                        <p class="error red-800"></p>\
                                        <p class="maxlengtherror red-800"></p>\
                                    </div>\
                                </div>';
                                break;

                            //display of text box field
                            case 'month':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var textquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = textquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' monthpicker" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="" data-subtype="'+indicatorfield.subtype+'" onkeydown="return false" autocomplete="off">\
                                        <p class="error red-800"></p>\
                                        <p class="maxlengtherror red-800"></p>\
                                    </div>\
                                </div>';
                                break;

                            //date picker
                            case 'date':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var textquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = textquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' picker" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'" data-maxlength = "'+indicatorfield.maxlength+'" value="" data-subtype="'+indicatorfield.subtype+'" onkeydown="return false" autocomplete="off">\
                                        <p class="error red-800"></p>\
                                        <p class="maxlengtherror red-800"></p>\
                                    </div>\
                                </div>';
                                break;

                            //display number field
                            case 'number':
                                var numb_col = (form_id == 89) ? 3 : 4;
                                indicator_fields += '<div class="col-md-'+numb_col+'">\
                                    <div class="form-group">';
                                        var numberquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = numberquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        switch (indicatorfield.subtype) {
                                            case 'desimal':
                                                indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' decimal" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-maxvalue = "'+indicatorfield.max_val+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="" >';
                                                break;

                                            case 'number':
                                                indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' number" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-maxvalue = "'+indicatorfield.max_val+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="" >';
                                                break;

                                            case 'latitude':
                                                indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' latlong" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="" >';
                                                break;

                                            case 'longitude':
                                                indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' latlong" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="" >';
                                                break;
                                            
                                            default:
                                                indicator_fields += '<input type="text" name="field_'+indicatorfield.field_id+'" class="'+indicatorfield.className+' numberfield" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" value="" >';
                                                break;
                                        }
                                        indicator_fields += '<p class="error red-800"></p>\
                                        <p class="maxlengtherror red-800"></p>\
                                    </div>\
                                </div>';
                                break;

                            //display radio button
                            case 'radio-group':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = radioquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        if(indicatorfield.required == 1){
                                            var hastrick = "<font color='red'>*</font>";
                                        }else{
                                            var hastrick = "";
                                        }
                                        indicator_fields += '<label class="english">'+label+''+hastrick+'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        indicator_fields += '<div class="form-check">\
                                            <div class="row">';
                                                indicatorfield.options.forEach(function(option, index){
                                                    var requiredval = (indicatorfield.required == 1) ? "required" : "";
                                                    if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                        var radio_value = "checked"; 
                                                    }else{
                                                        var radio_value = '';
                                                    }
                                                    indicator_fields += '<div class="col-md-6">\
                                                        <label><input type="radio" name="field_'+indicatorfield.field_id+'" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="normalfield">'+option.label+'</label>\
                                                    </div>';
                                                });
                                            indicator_fields += '</div>\
                                        </div>\
                                        <p class="error red-800"></p>\
                                    </div>\
                                </div>';
                                if(indicatorfield.child_count > 0){
                                    indicator_fields += '<div class="col-md-12">\
                                        <div class="row childfields childof'+indicatorfield.field_id+'"></div>\
                                    </div>';
                                }
                                break;

                            case 'checkbox-group':
                                var numb_col = (form_id == 89) ? 3 : 4;
                                indicator_fields += '<div class="col-md-'+numb_col+'">\
                                    <div class="form-group">';
                                        var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = radioquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        if(indicatorfield.required == 1){
                                            var hastrick = "<font color='red'>*</font>";
                                        }else{
                                            var hastrick = "";
                                        }
                                        indicator_fields += '<label class="english">'+label+''+hastrick+'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        indicator_fields += '<div class="form-check">\
                                            <div class="row">';
                                                indicatorfield.options.forEach(function(option, index){
                                                    indicator_fields += '<div class="col-md-6">';
                                                        var requiredval = (indicatorfield.required == 1) ? "required" : "";
                                                        if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                            var radio_value = "checked"; 
                                                        }else{
                                                            var radio_value = '';
                                                        }
                                                        indicator_fields += '<label><input type="checkbox" name="field_'+indicatorfield.field_id+'[]" value = "'+option.value+'" style="margin-right: 5px;" data-field_id = "'+indicatorfield.field_id+'" data-field_value = "'+option.value+'" data-required="'+requiredval+'"   '+radio_value+' data-fieldtype="normalfield">'+option.label+'</label>';
                                                    indicator_fields += '</div>';
                                                });
                                            indicator_fields += '</div>\
                                        </div>\
                                        <p class="error red-800"></p>\
                                    </div>\
                                </div>';
                                if(indicatorfield.child_count > 0){
                                    indicator_fields += '<div class="col-md-12">\
                                        <div class="row childfields childof'+indicatorfield.field_id+'"></div>\
                                    </div>';
                                }
                                break;

                            //display of textarea
                            case 'textarea':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var textareaquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = textareaquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        indicator_fields += '<textarea name="field_'+indicatorfield.field_id+'" rows="8" class="'+indicatorfield.className+'" data-subtype="'+indicatorfield.subtype+'" data-maxlength = "'+indicatorfield.maxlength+'" data-required="'+(indicatorfield.required == 1 ? "required" : "")+'"></textarea>\
                                        <p class="error red-800"></p>\
                                        <p class="maxlengtherror red-800"></p>\
                                    </div>\
                                </div>';
                                break;

                            //display of select box
                            case 'select':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var selectquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = selectquestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        if(indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE'){
                                            var selectname = "field_"+indicatorfield.field_id+"[]";
                                            var selectmultiple = "multiple";
                                        }else{
                                            var selectname = "field_"+indicatorfield.field_id+"";
                                            var selectmultiple = "";
                                        } 
                                        indicator_fields +='<select name="'+selectname+'" '+selectmultiple+' class="form-control selectbox" data-required = "'+(indicatorfield.required == 1 ? "required" : "")+'" data-field_id = "'+indicatorfield.field_id+'"   data-fieldtype="normalfield" data-maxlength ="'+indicatorfield.maxlength+'">';
                                        if(indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE'){
                                        }else{
                                            indicator_fields += '<option value="">Select an option</option>';
                                        }
                                        indicatorfield.options.forEach(function(option, index){
                                            if(option.selected == 'true' || option.selected == 'TRUE'){ 
                                                var select_value = "selected"; 
                                            }else{
                                                var select_value = '';
                                            }
                                            indicator_fields += '<option value="'+option.value+'" '+select_value+'>'+option.label+'</option>';
                                        });
                                        indicator_fields += '</select>\
                                        <p class="error red-800"></p>\
                                    </div>\
                                </div>';
                                if(indicatorfield.child_count > 0){
                                    indicator_fields += '<div class="col-md-12">\
                                        <div class="row childfields childof'+indicatorfield.field_id+'"></div>\
                                    </div>';
                                }
                                break;

                            case 'header':
                                indicator_fields += '<div class="col-md-12">';
                                    if(indicatorfield.description != null){
                                        indicator_fields += indicatorfield.description;
                                    }
                                    indicator_fields += '<'+indicatorfield.subtype+' class="title" style="margin-top: 0px; margin-bottom: 20px;">'+indicatorfield.label+'</'+indicatorfield.subtype+'>';
                                indicator_fields += '</div>';
                                break;

                            case 'uploadfile':
                                indicator_fields += '<div class="col-md-4">\
                                    <div class="form-group">';
                                        var filequestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if(indicatorfield.field_count == 1){
                                            var label = filequestion+'. '+indicatorfield.label;
                                        }else{
                                            var label = indicatorfield.label;
                                        }
                                        indicator_fields += '<label class="english">'+label+''+(indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") +'</label>';
                                        if(indicatorfield.description != null){
                                            indicator_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>';
                                        }
                                        var requiredval = (indicatorfield.required == 1) ? "required" : "notrequired";
                                        (indicatorfield.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+indicatorfield.description+'</p>' : '';
                                        if(indicatorfield.subtype == 'excel'){
                                            indicator_fields += '<div class="row">\
                                                <div class="col-md-6">\
                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>\
                                                    Use this Excel template to upload the data:<a href="<?php echo base_url(); ?>includeout/avisareporting_excelformats/'+indicatorfield.description+'" download=""><img src="<?php echo base_url(); ?>includeout/images/excel.png" style="width: 30px;">'+indicatorfield.description+'</a>\
                                                    <input type="file" class="uploadfile" data-fieldtype = "'+indicatorfield.type+'" data-fieldsubtype = "'+indicatorfield.subtype+'"  data-required = "'+requiredval+'" name="field_'+indicatorfield.field_id+'">\
                                                    <p style="font-size: 10px; font-style: italic; color: gray;">\
                                                        File size must be less than 500KB<br/>\
                                                        Only .xlsx, .xls file type are allowed\
                                                    </p>\
                                                    <p class="error" style="color: red"></p>\
                                                </div>\
                                            </div>';
                                        }else if(indicatorfield.subtype == 'document'){
                                            (indicatorfield.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: '+field.description+'</p>' : '';
                                            indicator_fields += '<div class="row">\
                                                <div class="col-md-6">\
                                                    <input type="file" class="uploaddocument" data-fieldtype = "'+indicatorfield.type+'" data-fieldsubtype = "'+indicatorfield.subtype+'"  data-required = "'+requiredval+'" name="field_'+indicatorfield.field_id+'">\
                                                    <p style="font-size: 10px; font-style: italic; color: gray;">\
                                                        File size must be less than 500KB<br/>\
                                                        Only .pdf file type are allowed\
                                                    </p>\
                                                    <p class="error" style="color: red"></p>\
                                                </div>\
                                            </div>';
                                        }
                                    indicator_fields += '</div>\
                                </div>';
                                break;

                            case 'uploadgroupdata_excel':
                                indicator_fields += '<div class="col-md-12" style="margin-bottom: 15px;">\
                                    <a class="btn-success btn-sm uploadgroupdata_excel" style="color: #FFFFFF !important;"   target="_blank">Upload data using excel</a>\
                                </div>';
                                break;
                        }
                    }
                });
                indicator_fields += '<div class="col-md-12">\
                    <div class="row">\
                        <div class="col-md-4">\
                            <label style="color:#c51205 !important"><input type="checkbox" class="nothingto_report"> Nothing to report</label>\
                        </div>\
                        <div class="col-md-4">\
                            <label><input type="checkbox" class="default_indicatorcomment" name=""> Add comment</label>\
                            <div class="row">\
                                <div class="col-md-10 indicator_comment">\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                </div>';
                indicator_fields += '<div class="col-md-12">\
                    <button type="button" class="btn btn-sm btn-success pull-right submitindicator_data">Submit data</button>\
                    <button type="button" class="btn btn-sm btn-success pull-right saveindicator_data" style="margin-right:10px;">Save data</button>\
                </div>\
            </div>';
        indicator_fields += `</form>`;

        $('.indicatorfields').html(indicator_fields);
    });

    $('body')
    .on('click', '.addmorefields', function(){
        $('.error').html('');
        $elem = $(this);
        $elem.closest('.addmoremaindiv').find('.removeaddmore').parent().html('');

        var addmore_count = $elem.closest('.addmoremaindiv').find('.addmore').length;
        var $template = $elem.closest('.addmoremaindiv').find('.addmore_div'),
        $clone = $template
                .clone()
                .removeClass('addmore_div')
                .addClass('dulicate_addmore_div')
                /*.attr('style', 'border-top:1px solid #8e8ec0; margin:0px;')*/;


        $clone.find('input[type="text"]').val('');
        $clone.find('textarea').val('');
        $clone.find('select').val('');
        $clone.find('input[type="radio"]').prop("checked", false);
        $clone.find('input[type="checkbox"]').prop("checked", false);
        $clone.find('input[type="radio"]').prop("checked", false);

        $clone.find('.childfields').html('');
        

        $clone.find('input[type="text"]').each(function() {
            var name = $(this).attr("name");
            name = name.replace("[0]", "["+addmore_count+"]");
            $(this).attr('name', name);
            $(this).attr('data-groupfieldcount', addmore_count);
        });

        $clone.find('textarea').each(function() {
            var name = $(this).attr("name");
            name = name.replace("[0]", "["+addmore_count+"]");
            $(this).attr('name', name);
            $(this).attr('data-groupfieldcount', addmore_count);
        });

        $clone.find('input[type="radio"]').each(function() {
            var name = $(this).attr("name");
            name = name.replace("[0]", "["+addmore_count+"]");
            $(this).attr('name', name);
            $(this).attr('data-groupfieldcount', addmore_count);
        });

        $clone.find('input[type="checkbox"]').each(function() {
            var name = $(this).attr("name");
            name = name.replace("[0]", "["+addmore_count+"]");
            $(this).attr('name', name);
            $(this).attr('data-groupfieldcount', addmore_count);
        });

        $clone.find('select').each(function() {
            var name = $(this).attr("name");
            name = name.replace("[0]", "["+addmore_count+"]");
            $(this).attr('name', name);
            $(this).attr('data-groupfieldcount', addmore_count);
        });
        
        $clone.find('.addmorefields').parent().html('<button type="button" class="btn btn-danger btn-sm removeaddmore pull-left" style="margin-top:10px;">\
            <span class="glyphicon glyphicon-minus"></span> Remove\
        </button>');
        $(this).closest('.addmoremaindiv').append($clone);

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
    })
    .on('click', '.removeaddmore', function() {
        var elem = $(this);

        var addmore_count = elem.closest('.addmoremaindiv').find('.addmore').length;
        var fields = elem.closest('.addmoremaindiv').find('.addmore');
        $.each(fields, function(index) {
            if(index == (addmore_count-2) && index != 0){
                $(this).find('.add_remove_button').html('<button type="button" class="btn btn-danger btn-sm removeaddmore pull-left" style="margin-top:10px;">\
                    <span class="glyphicon glyphicon-minus"></span> Remove\
                </button>');
            }
        });
        elem.closest('.row').remove();
    });

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

        var year_val = $('.year').val();

        var classname = 'childof'+field_id;
        if(fieldtype == 'groupfield'){
            $elem.closest('.row').find('.'+classname).html('');
        }else{
            $('.'+classname).html('');
        }

        var calltype = 'onchange';

        var data = {
            year_val : year_val,
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

        var year_val = $('.year').val();

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

        if(field_value != ''){
            var data = {
                year_val : year_val,
                field_id : field_id,
                field_value : field_value,
                calltype : calltype,
                fieldtype : fieldtype,
                groupfieldcount : groupfieldcount
            }

            getchild_field(data, $elem);
        }
    });

    $('body').on('change', '.selectbox', function() {
        $elem = $(this);

        $elem.closest('.form-group').find('.error').empty();

        var field_id = $(this).attr("data-field_id");
        var fieldtype = $(this).attr("data-fieldtype");
        var maxlength = $(this).attr("data-maxlength");

        var year_val = $('.year').val();

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
                        year_val : year_val,
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
                    year_val : year_val,
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

    $('body').on('change', '.default_indicatorcomment', function() {
        if(this.checked) {
            var HTML = '<div class="form-group">\
                <textarea class="form-control" name="indicator_comment" rows="8" data-required="required" data-maxlength="6000"></textarea>\
                <p class="error red-800"></p>\
                <p class="maxlengtherror red-800"></p>\
            </div>';
            $(this).closest('.row').find('.indicator_comment').html(HTML);
        }else{
            $(this).closest('.row').find('.indicator_comment').html('');
        }
    });

    $('body').on('click', '.submitindicator_data', function(){
        $elem = $(this);
        $elem.prop('disabled', true);

        $('.error').html('');

        var year_val = $('select[name="year"]').val();
        var country_val = 1;
        var crop_val = 1;

        var form_id = "submit_data";
        var surveycount = 0;

        if(country_val == ''){
            $('select[name="country"]').next('.error').html('This field is required');
            surveycount++;
        }

        if(crop_val == ''){
            $('select[name="crop"]').next('.error').html('This field is required');
            surveycount++;
        }

        $elem.closest('.card').find('input[type=text]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if(requiredvalue == 'required'){
                if($.trim($(this).val()).length === 0){
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }

            if(subtypevalue == 'number' || subtypevalue == 'desimal'){
                switch (subtypevalue){
                    case 'number':
                        if($(this).val().length > 0){
                            if (/^\d+$/.test($(this).val())) {
                                $(this).next('.error').empty();
                            } else {
                                $(this).val('');
                                $(this).next('.error').html('Please provide a valid number.');
                                surveycount++;
                            }
                        }
                    break;

                    case 'desimal':
                        if($(this).val().length > 0){
                            if(!/^(\d*\.?\d*)$/.test($(this).val())){
                                $(this).next('.error').html('Please! Enter only number');
                                surveycount++;
                            }else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                $(this).next('.error').html('Field can contain only proper decimal number.');
                                surveycount++;
                            }
                        }
                    break;
                }
            }

            if($.trim($(this).val()).length > maxvalue){
                $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
                surveycount++;
            }
        });

        $elem.closest('.card').find('textarea', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if(requiredvalue == 'required'){
                if($.trim($(this).val()).length === 0){
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }

            if($.trim($(this).val()).length > maxvalue){
                $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto '+maxvalue+' character/number');
                surveycount++;
            }
        });

        $elem.closest('.card').find('input[type=radio]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            if(requiredvalue == 'required'){
                var name = $(this).attr("name");
                if($("input:radio[name='"+name+"']:checked").length == 0){
                    $(this).closest('.form-group').find('.error').html('This field is required');
                    surveycount++;
                }
            }
        });

        $elem.closest('.card').find('input[type=checkbox]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if(requiredvalue == 'required'){
                var name = $(this).attr("name");
                if($("input:checkbox[name='"+name+"']:checked").length == 0){
                    $(this).closest('.form-group').find('.error').html('This field is required');
                    surveycount++;
                }
            }
        });

        $elem.closest('.card').find('select', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            if(requiredvalue == 'required'){
                var name = $(this).attr("name");
                if($.trim($(this).val()).length == 0){
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }
        });

        if(surveycount == 0){
            var indicatorform = new FormData($('#'+form_id)[0]);
            indicatorform.append('form_id', <?php echo $this->uri->segment('3'); ?>);
            indicatorform.append('country_val', country_val);
            indicatorform.append('crop_val', crop_val);
            indicatorform.append('submit_type', 'submit');
            indicatorform.append('year_val', year_val);
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/insert_indicatordata',
                type: 'POST',
                dataType : 'json',
                data: indicatorform,
                processData: false,
                contentType: false,
                error: function() {
                    $elem.prop('disabled', false);
                    swal({
                        title: 'Please check your internet connection and try again.',
                        icon: "warning",
                        dangerMode : true,
                        closeOnConfirm: true
                    });
                },
                success: function(response){
                    if(response.status == 0){
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error'
                        });
                    }else{
                        $.toast({
                            heading: 'Success!',
                            text: response.msg,
                            icon: 'success',
                            afterHidden: function () {
                                location.reload(true);
                            }
                        });
                    }
                    $elem.prop('disabled', false);
                }
            });
        }else{
            $elem.prop('disabled', false);
        }            
    });

    function convertToNumerals(num) {
        // Catch decimals
        num = Math.floor(num);
  
        var numeralVals = {
            M: 1000,
            D: 500,
            C: 100,
            L: 50,
            X: 10,
            V: 5,
            I: 1
        };
        var numerals = Object.keys(numeralVals); // Keys in an array for easy iteration
        var result = ""; // Final roman numerals

        // For subtractive rules
        var powersOfTen = [];
        for (var exponent = 0; exponent < 6; exponent++) {
            var pow = Math.pow(10, exponent);
            powersOfTen.push(pow);
        }

        var remainder = num;

        while (remainder > 0) {
            for (var i = 0; i < numerals.length; i++) {
                var currentNumeralVal = numeralVals[numerals[i]];
                var mod = remainder % currentNumeralVal;
                var modBack = currentNumeralVal % remainder;
                var divide = remainder / currentNumeralVal;

                if (remainder - currentNumeralVal >= 0) {
                    remainder -= currentNumeralVal;
                    result += numerals[i];
                    break;
                }

                // Subtractive rules
                // Looping from lowest to highest value to get correct subtrahend
                for (var j = (numerals.length - 1); j > i; j--) {
                    var minuend = currentNumeralVal;
                    var subtrahend = numeralVals[numerals[j]];

                    // Only to a numeral (the subtrahend) that is a power of ten (I, X or C).
                    // For example, "VL" is not a valid representation of 45 (XLV is correct).
                    if (powersOfTen.indexOf(subtrahend) === -1) {
                        continue;
                    }
                    // Only when the subtrahend precedes a minuend no more than ten times larger. 
                    // For example, "IL" is not a valid representation of 49 (XLIX is correct).
                    if (subtrahend * 10 < minuend) {
                        continue;
                    }

                    var minused = minuend - subtrahend;

                    if (remainder - minused >= 0) {
                        remainder -= minused;
                        result += numerals[j] + numerals[i];
                        break;
                    }
                }

                // Stop loop early if we have no remainder
                if (remainder === 0) {
                    break;
                }
            }
        }
        return result;
    }
</script>