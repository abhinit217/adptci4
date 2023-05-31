<style type="text/css">
	/*.h4_heading{
		color: #f44336 !important;
	    font-size: 18px !important;
	    font-weight: bold;
	}*/
	/*th{
		color: #FFFFFF;
	}*/
	.p-10{
		padding: 10px;
	}

	label {
        font-weight: bold;
    }
</style>

<script type="text/javascript">
    function getchild_field(data, $elem) {
        var classname = 'childof' + data.field_id;
        var fieldtype = data.fieldtype;

        $.ajax({
            url: "<?php echo base_url(); ?>reporting/check_childfields",
            type: "POST",
            dataType: "json",
            data: {
                field_id: data.field_id,
                field_value: data.field_value,
                calltype: data.calltype,
                form_id: <?php echo $this->uri->segment('3'); ?>
            },
            error: function() {
                if (fieldtype == 'groupfield') {
                    $elem.closest('.row').find('.' + classname).html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
                } else {
                    $('.' + classname).html('<p align="center" class="red-800">Please check your internet connection and try again</p>');
                }

                setTimeout(function() {
                    $('.' + classname).empty();
                }, 5000);
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.child_field.length > 0) {
                        var CHILD_HTML = '';
                        for (var field of response.child_field) {
                            switch (field.type) {
                                case 'radio-group':
                                    CHILD_HTML += '<div class="col-md-4">\
                                        <div class="form-group">\
                                            <label>' + field.label;
		                                    if (field.required == 1) {
		                                        CHILD_HTML += '<font color="red">*</font>';
		                                    }
		                                    CHILD_HTML += '</label>';
		                                    if (field.description != null) {
		                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
		                                    }
		                                    CHILD_HTML += '<div class="form-check">\
		                                                    <div class="row">';
		                                    field.options.forEach(function(option, optionindex) {
		                                        CHILD_HTML += '<div class="col-md-4">';
		                                        if (field.inline == "true" || field.inline == "TRUE") {
		                                            var radioclass = 'radio-inline';
		                                        } else {
		                                            var radioclass = '';
		                                        }
		                                        var inputradioclass = (field.className != '') ? field.className : "";
		                                        if (typeof field.value !== 'undefined') {
		                                            var columnfield = "field_" + field.field_id;
		                                            if (field.value == option.value) {
		                                                var selectedvalue = "checked";
		                                            } else {
		                                                var selectedvalue = '';
		                                            }
		                                        } else {
		                                            if (option.selected == 'true' || option.selected == 'TRUE') {
		                                                var selectedvalue = "checked";
		                                            } else {
		                                                var selectedvalue = '';
		                                            }
		                                        }
		                                        if (fieldtype == 'groupfield') {
		                                            var radioname = "field_" + field.field_id + "[" + data.groupfieldcount + "]";
		                                        } else {
		                                            var radioname = "field_" + field.field_id + "";
		                                        }
		                                        var requiredval = (field.required == 1) ? "required" : "notrequired";
		                                        CHILD_HTML += '<label class="' + radioclass + '" >\
		                                                                    <input type="radio" name="' + radioname + '"  class="' + inputradioclass + '" value = "' + option.value + '" ' + selectedvalue + ' style="margin-right: 5px;" data-field_id = "' + field.field_id + '" data-field_value = "' + option.value + '" data-required = "' + requiredval + '" data-fieldtype="' + data.fieldtype + '" data-groupfieldcount="' + data.groupfieldcount + '" data-indicatorid="' + data.indicatorid + '" data-subindicatorid="' + data.subindicatorid + '">' + option.label + '\
		                                                                </label>\
		                                                            </div>';
		                                    });
		                                    CHILD_HTML += '</div>\
		                                                </div>';
		                                    CHILD_HTML += '<p class="error red-800"></p>\
                                        </div>\
                                    </div>';
	                                if (field.child_count > 0) {
	                                    CHILD_HTML += '<div class="col-md-12">\
	                                    	<div class="row childfields childof' + field.field_id + '"></div>\
	                                    </div>';
	                                }
                                	break;

                                case 'checkbox-group':
                                    CHILD_HTML += '<div class="col-md-4">\
                                        <div class="form-group">\
                                            <label>' + field.label;
		                                    if (field.required == 1) {
		                                        CHILD_HTML += '<font color="red">*</font>';
		                                    }
		                                    CHILD_HTML += '</label>';
		                                    if (field.description != null) {
		                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
		                                    }
                                    		CHILD_HTML += '<div class="form-check">\
                                            	<div class="row">';
				                                    field.options.forEach(function(option, optionindex) {
				                                        CHILD_HTML += '<div class="col-md-4">';
					                                        if (field.inline == "true" || field.inline == "TRUE") {
					                                            var radioclass = 'radio-inline';
					                                        } else {
					                                            var radioclass = '';
					                                        }
					                                        var inputcheckboxclass = (field.className != '') ? field.className : "";
					                                        if (typeof field.value !== 'undefined') {
					                                            var columnfield = "field_" + field.field_id;
					                                            if (field.value == option.value) {
					                                                var selectedvalue = "checked";
					                                            } else {
					                                                var selectedvalue = '';
					                                            }
					                                        } else {
					                                            if (option.selected == 'true' || option.selected == 'TRUE') {
					                                                var selectedvalue = "checked";
					                                            } else {
					                                                var selectedvalue = '';
					                                            }
					                                        }
					                                        if (fieldtype == 'groupfield') {
					                                            var checkbox_name = "field_" + field.field_id + "[" + data.groupfieldcount + "][]";
					                                        } else {
					                                            var checkbox_name = "field_" + field.field_id + "[]";
					                                        }
					                                        var requiredval = (field.required == 1) ? "required" : "notrequired";
					                                        CHILD_HTML += '<label class="' + radioclass + '" >\
					                                            <input type="checkbox" name="' + checkbox_name + '"  class="' + inputcheckboxclass + '" value = "' + option.value + '" ' + selectedvalue + ' style="margin-right: 5px;" data-field_id = "' + field.field_id + '" data-field_value = "' + option.value + '" data-required = "' + requiredval + '" data-fieldtype="' + data.fieldtype + '" data-groupfieldcount="' + data.groupfieldcount + '" data-indicatorid="' + data.indicatorid + '" data-subindicatorid="' + data.subindicatorid + '">' + option.label + '\
					                                        </label>\
					                                    </div>';
				                                    });
                                    			CHILD_HTML += '</div>\
                                            </div>';
                                    		CHILD_HTML += '<p class="error red-800"></p>\
                                        </div>\
                                    </div>';
                                    if (field.child_count > 0) {
                                        CHILD_HTML += '<div class="col-md-12">\
                                            <div class="row childfields childof' + field.field_id + '"></div>\
                                        </div>';
                                    }
                                    break;

                                case 'select':
                                    CHILD_HTML += '<div class="col-md-4">\
                                        <div class="form-group">\
                                            <label>' + field.label;
		                                    if (field.required == 1) {
		                                        CHILD_HTML += '<font color="red">*</font>';
		                                    }
		                                    CHILD_HTML += '</label>';
		                                    if (field.description != null) {
		                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
		                                    }
		                                    var requiredval = (field.required == 1) ? "required" : "notrequired";
		                                    if (fieldtype == 'groupfield') {
		                                        if (field.multiple == 'true' || field.multiple == 'TRUE') {
		                                            var select_name = "field_" + field.field_id + "[" + data.groupfieldcount + "][]";
		                                            var selectmultiple = "multiple";
		                                        } else {
		                                            var select_name = "field_" + field.field_id + "[" + data.groupfieldcount + "]";
		                                        }

		                                    } else {
		                                        if (field.multiple == 'true' || field.multiple == 'TRUE') {
		                                            var select_name = "field_" + field.field_id + "[]";
		                                            var selectmultiple = "multiple";
		                                        } else {
		                                            var select_name = "field_" + field.field_id + "";
		                                        }
		                                    }
		                                    CHILD_HTML += '<select name="' + select_name + '" ' + selectmultiple + ' class="form-control selectbox" data-required = "' + requiredval + '" data-field_id = "' + field.field_id + '" data-indicatorid="' + data.indicatorid + '" data-subindicatorid="' + data.subindicatorid + '" data-fieldtype="' + data.fieldtype + '" data-groupfieldcount="' + data.groupfieldcount + '" data-maxlength ="' + field.maxlength + '">';
		                                    if (field.multiple == 'true' || field.multiple == 'TRUE') {} else {
		                                        CHILD_HTML += '<option value="">Select an option</option>';
		                                    }

			                                    field.options.forEach(function(option, optionindex) {
			                                        if (typeof field.value !== 'undefined') {
			                                            if (field.value == option.value) {
			                                                var optionselected = "selected";
			                                            } else {
			                                                var optionselected = '';
			                                            }
			                                        } else {
			                                            if (option.selected == "true" || option.selected == "TRUE") {
			                                                var optionselected = "selected";
			                                            } else {
			                                                var optionselected = "";
			                                            }
			                                        }

			                                        CHILD_HTML += '<option value = "' + option.value + '" ' + optionselected + '>' + option.label + '</option>';
			                                    });
                                    		CHILD_HTML += '</select>\
                                            <p class="error red-800"></p>\
                                        </div>\
                                    </div>';
                                    if (field.child_count > 0) {
                                        CHILD_HTML += '<div class="col-md-12">\
                                            <div class="row childfields childof' + field.field_id + '"></div>\
                                        </div>';
                                    }
                                    break;

                                case 'number':
                                    CHILD_HTML += '<div class="col-md-4">\
                                        <div class="form-group">\
                                            <label>' + field.label;
		                                    if (field.required == 1) {
		                                        CHILD_HTML += '<font color="red">*</font>';
		                                    }
		                                    CHILD_HTML += '</label>';
		                                    if (field.description != null) {
		                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
		                                    }
		                                    var inputclass = (field.className != '') ? field.className : "";
		                                    var requiredval = (field.required == 1) ? "required" : "notrequired";
		                                    if (typeof field.value !== 'undefined' && field.value != null) {
		                                        var columnfield = "field_" + field.field_id;
		                                        if (field.value == null) {
		                                            var numberfield_value = '';
		                                        } else {
		                                            var numberfield_value = field.value;
		                                        }
		                                    } else {
		                                        var numberfield_value = '';
		                                    }
		                                    if (fieldtype == 'groupfield') {
		                                        var number_name = "field_" + field.field_id + "[" + data.groupfieldcount + "]";
		                                    } else {
		                                        var number_name = "field_" + field.field_id + "";
		                                    }
		                                    switch (field.subtype) {
		                                        case 'desimal':
		                                            CHILD_HTML += '<input type="text" name="' + number_name + '" class=" ' + inputclass + ' decimal" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" data-maxvalue = "' + field.max_val + '"  value="' + numberfield_value + '" >';
		                                            break;

		                                        case 'number':
		                                            CHILD_HTML += '<input type="text" name="' + number_name + '" class=" ' + inputclass + ' number" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" data-maxvalue = "' + field.max_val + '" value="' + numberfield_value + '" >';
		                                            break;

		                                        case 'latitude':
		                                            CHILD_HTML += '<input type="text" name="' + number_name + '" class=" ' + inputclass + ' latlong" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" value="' + numberfield_value + '" >';
		                                            break;

		                                        case 'longitude':
		                                            CHILD_HTML += '<input type="text" name="' + number_name + '" class=" ' + inputclass + ' latlong" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" value="' + numberfield_value + '" >';
		                                            break;

		                                        default:
		                                            CHILD_HTML += '<input type="text" name="' + number_name + '" class=" ' + inputclass + ' numberfield" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" value="' + numberfield_value + '" >';
		                                            break;
		                                    }
                                    		CHILD_HTML += '<p class="error red-800"></p>\
                                            <p class="maxlengtherror red-800"></p>\
                                        </div>\
                                    </div>';
                                    break;

                                case 'text':
                                    CHILD_HTML += '<div class="col-md-4">\
                                            <div class="form-group">\
                                                <label>' + field.label;
                                    if (field.required == 1) {
                                        CHILD_HTML += '<font color="red">*</font>';
                                    }
                                    CHILD_HTML += '</label>';
                                    if (field.description != null) {
                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
                                    }
                                    var inputclass = (field.className != '') ? field.className : "";
                                    var requiredval = (field.required == 1) ? "required" : "notrequired";
                                    if (typeof field.value !== 'undefined' && field.value != null) {
                                        var columnfield = "field_" + field.field_id;
                                        var textfield_value = field.value;
                                    } else {
                                        var textfield_value = '';
                                    }
                                    if (fieldtype == 'groupfield') {
                                        var text_name = "field_" + field.field_id + "[" + data.groupfieldcount + "]";
                                    } else {
                                        var text_name = "field_" + field.field_id + "";
                                    }
                                    CHILD_HTML += '<input type="text" name="' + text_name + '" class="' + inputclass + '" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" value="' + textfield_value + '" >';
                                    CHILD_HTML += '<p class="error red-800"></p>\
                                                <p class="maxlengtherror red-800"></p>\
                                            </div>\
                                        </div>';
                                    break;

                                case 'header':
                                    CHILD_HTML += '<div class="col-md-12">\
                                            <' + field.subtype + ' style="margin-top: 0px; margin-bottom: 20px;">' + field.label + '</' + field.subtype + '>\
                                        </div>';
                                    break;

                                case 'date':
                                    CHILD_HTML += '<div class="col-md-4">\
                                            <div class="form-group">\
                                                <label>' + field.label;
                                    if (field.required == 1) {
                                        CHILD_HTML += '<font color="red">*</font>';
                                    }
                                    CHILD_HTML += '</label>';
                                    if (field.description != null) {
                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
                                    }
                                    var inputclass = (field.className != '') ? field.className : "";
                                    var requiredval = (field.required == 1) ? "required" : "notrequired";
                                    if (typeof field.value !== 'undefined' && field.value != null) {
                                        var columnfield = "field_" + field.field_id;
                                        var textfield_value = field.value;
                                    } else {
                                        var textfield_value = '';
                                    }
                                    if (fieldtype == 'groupfield') {
                                        var date_name = "field_" + field.field_id + "[" + data.groupfieldcount + "]";
                                    } else {
                                        var date_name = "field_" + field.field_id + "";
                                    }
                                    CHILD_HTML += '<input type="text" name="' + date_name + '" class="' + inputclass + ' picker" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" value="' + textfield_value + '" autocomplete="off" onkeydown="return false">';
                                    CHILD_HTML += '<p class="error red-800"></p>\
                                                <p class="maxlengtherror red-800"></p>\
                                            </div>\
                                        </div>';
                                    break;

                                case 'month':
                                    CHILD_HTML += '<div class="col-md-4">\
                                            <div class="form-group">\
                                                <label>' + field.label;
                                    if (field.required == 1) {
                                        CHILD_HTML += '<font color="red">*</font>';
                                    }
                                    CHILD_HTML += '</label>';
                                    if (field.description != null) {
                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
                                    }
                                    var inputclass = (field.className != '') ? field.className : "";
                                    var requiredval = (field.required == 1) ? "required" : "notrequired";
                                    if (typeof field.value !== 'undefined' && field.value != null) {
                                        var columnfield = "field_" + field.field_id;
                                        var textfield_value = field.value;
                                    } else {
                                        var textfield_value = '';
                                    }
                                    if (fieldtype == 'groupfield') {
                                        var month_name = "field_" + field.field_id + "[" + data.groupfieldcount + "]";
                                    } else {
                                        var month_name = "field_" + field.field_id + "";
                                    }
                                    CHILD_HTML += '<input type="text" name="' + month_name + '" class="' + inputclass + ' monthpicker" data-subtype = "' + field.subtype + '" data-maxlength ="' + field.maxlength + '" data-required = "' + requiredval + '" value="' + textfield_value + '" autocomplete="off" onkeydown="return false">';
                                    CHILD_HTML += '<p class="error red-800"></p>\
                                                <p class="maxlengtherror red-800"></p>\
                                            </div>\
                                        </div>';
                                    break;

                                case 'uploadfile':
                                    CHILD_HTML += '<div class="col-md-12">';
                                   		if (field.subtype == 'excel') {
                                        	CHILD_HTML += '<div class="form-group">\
                                            	<label>' + field.label;
		                                        if (field.required == 1) {
		                                            CHILD_HTML += '<font color="red">*</font>';
		                                        }
		                                        CHILD_HTML += '</label>';
		                                        if (field.description != null) {
		                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
		                                        }
		                                        var requiredval = (field.required == 1) ? "required" : "notrequired";
		                                        (field.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>': '';
		                                        CHILD_HTML += '<div class="row">\
		                                            <div class="col-md-6">\
		                                                <p style="font-size: 10px; font-style: italic; color: gray;">Note: only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>\
		                                                Use this Excel template to upload the data:<a href="<?php echo base_url(); ?>includeout/avisareporting_excelformats/' + field.description + '" download=""><img src="<?php echo base_url(); ?>includeout/images/excel.png" style="width: 30px;">' + field.description + '</a>\
		                                                <input type="file" class="uploadfile" data-fieldtype = "' + field.type + '" data-fieldsubtype = "' + field.subtype + '"  data-required = "' + requiredval + '" name="field_' + field.field_id + '">\
		                                                <p style="font-size: 10px; font-style: italic; color: gray;">\
		                                                    File size must be less than 500KB<br/>\
		                                                    Only .xlsx, .xls file type are allowed\
		                                                </p>\
		                                                <p class="error" style="color: red"></p>\
		                                            </div>\
		                                        </div>\
		                                    </div>';
                                    	} else if (field.subtype == 'document') {
                                        	CHILD_HTML += '<div class="form-group">\
                                                <label>' + field.label;
		                                        if (field.required == 1) {
		                                            CHILD_HTML += '<font color="red">*</font>';
		                                        }
		                                        CHILD_HTML += '</label>';
		                                        if (field.description != null) {
		                                            CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
		                                        }
                                        		var requiredval = (field.required == 1) ? "required" : "notrequired";
                                        		(field.description != null) ? '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>': '';
                                        		CHILD_HTML += '<div class="row">\
                                                    <div class="col-md-6">\
                                                        <input type="file" class="uploaddocument" data-fieldtype = "' + field.type + '" data-fieldsubtype = "' + field.subtype + '"  data-required = "' + requiredval + '" name="field_' + field.field_id + '">\
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


                                case 'textarea':
                                    CHILD_HTML += '<div class="col-md-4">\
                                            <div class="form-group">\
                                                <label>' + field.label;
                                    if (field.required == 1) {
                                        CHILD_HTML += '<font color="red">*</font>';
                                    }
                                    CHILD_HTML += '</label>';
                                    if (field.description != null) {
                                        CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + field.description + '</p>';
                                    }
                                    var inputclass = (field.className != '') ? field.className : "";
                                    var requiredval = (field.required == 1) ? "required" : "notrequired";

                                    if (typeof field.value !== 'undefined' && field.value != null) {
                                        var columnfield = "field_" + field.field_id;
                                        var textfield_value = field.value;
                                    } else {
                                        var textfield_value = '';
                                    }
                                    CHILD_HTML += '<textarea name="field_' + field.field_id + '" rows="8" class="' + inputclass + '" data-subtype="' + field.subtype + '" data-maxlength = "' + field.maxlength + '" data-required="' + requiredval + '">' + textfield_value + '</textarea>';
                                    CHILD_HTML += '<p class="error red-800"></p>\
                                                <p class="maxlengtherror red-800"></p>\
                                            </div>\
                                        </div>';
                                    break;

                                case 'uploadgroupdata_excel':
                                    CHILD_HTML += '<div class="col-md-12" style="margin-bottom: 15px;">\
                                            <a href="javascript:void(0);" class="btn-success btn-sm uploadgroupdata_excel" style="color: #FFFFFF !important;">Upload data using excel</a>\
                                        </div>';
                                    break;

                                case 'group':
                                    CHILD_HTML += '<div class="col-md-12 addmoremaindiv">\
                                            <div class="row addmore addmore_div">';
                                    var indicator_groupfieldscount = field.groupfields.length;
                                    var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
                                    CHILD_HTML += '<div class="col-md-' + i_divmainclass + '">\
                                                    <div class="row">';
                                    field.groupfields.forEach(function(indicatorgroupfield, g_index) {
                                        if (indicator_groupfieldscount == 1) {
                                            var i_divclass = 12
                                        } else if (indicator_groupfieldscount == 2) {
                                            var i_divclass = 6;
                                        } else if (indicator_groupfieldscount == 3) {
                                            var i_divclass = 4;
                                        } else {
                                            var i_divclass = 3;
                                        }
                                        switch (indicatorgroupfield.type) {
                                            case 'text':
                                                CHILD_HTML += '<div class="col-md-' + i_divclass + '">\
                                                                        <div class="form-group">';
                                                CHILD_HTML += '<label>' + (g_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                if (indicatorgroupfield.description != null) {
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                }
                                                CHILD_HTML += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[0]" class="' + indicatorgroupfield.className + '" data-required="' + (indicatorgroupfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" value="" data-subtype="' + indicatorgroupfield.subtype + '">\
                                                                            <p class="error red-800"></p>\
                                                                            <p class="maxlengtherror red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                break;

                                            case 'textarea':
                                                CHILD_HTML += '<div class="col-md-' + i_divclass + '">\
                                                                        <div class="form-group">';
                                                CHILD_HTML += '<label>' + (g_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                if (indicatorgroupfield.description != null) {
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                }
                                                var inputclass = (indicatorgroupfield.className != '') ? indicatorgroupfield.className : "";
                                                var requiredval = (indicatorgroupfield.required == 1) ? "required" : "notrequired";

                                                if (typeof indicatorgroupfield.value !== 'undefined' && indicatorgroupfield.value != null) {
                                                    var columnfield = "field_" + indicatorgroupfield.field_id;
                                                    var textfield_value = indicatorgroupfield.value;
                                                } else {
                                                    var textfield_value = '';
                                                }
                                                CHILD_HTML += '<textarea name="field_' + indicatorgroupfield.field_id + '[0]" rows="8" class="' + inputclass + '" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required="' + requiredval + '">' + textfield_value + '</textarea>';
                                                CHILD_HTML += '<p class="error red-800"></p>\
                                                                            <p class="maxlengtherror red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                break;

                                            case 'select':
                                                CHILD_HTML += '<div class="col-md-' + i_divclass + '">\
                                                                        <div class="form-group">';
                                                CHILD_HTML += '<label>' + (g_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                if (indicatorgroupfield.description != null) {
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                }
                                                if (indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE') {
                                                    var selectname = "field_" + indicatorgroupfield.field_id + "[0][]";
                                                    var selectmultiple = "multiple";
                                                } else {
                                                    var selectname = "field_" + indicatorgroupfield.field_id + "[0]";
                                                    var selectmultiple = "";
                                                }
                                                CHILD_HTML += '<select name="' + selectname + '" ' + selectmultiple + ' class="form-control selectbox" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" data-field_id = "' + indicatorgroupfield.field_id + '"   data-fieldtype="groupfield" data-groupfieldcount = "0" data-maxlength ="' + indicatorgroupfield.maxlength + '">';
                                                if (indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE') {} else {
                                                    CHILD_HTML += '<option value="">Select an option</option>';
                                                }
                                                indicatorgroupfield.options.forEach(function(option, index) {
                                                    if (option.selected == 'true' || option.selected == 'TRUE') {
                                                        var select_value = "selected";
                                                    } else {
                                                        var select_value = '';
                                                    }
                                                    CHILD_HTML += '<option value="' + option.value + '" ' + select_value + '>' + option.label + '</option>';
                                                });
                                                CHILD_HTML += '</select>\
                                                                            <p class="error red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                if (indicatorgroupfield.child_count > 0) {
                                                    CHILD_HTML += '<div class="col-md-12">\
                                                                            <div class="row childfields childof' + indicatorgroupfield.field_id + '"></div>\
                                                                        </div>';
                                                }
                                                break;

                                            case 'radio-group':
                                                CHILD_HTML += '<div class="col-md-' + i_divclass + '">\
                                                                        <div class="form-group">';
                                                CHILD_HTML += '<label>' + (g_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                if (indicatorgroupfield.description != null) {
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                }
                                                CHILD_HTML += '<div class="form-check">\
                                                                                <div class="row">';
                                                indicatorgroupfield.options.forEach(function(option, index) {
                                                    var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                    if (option.selected == 'true' || option.selected == 'TRUE') {
                                                        var radio_value = "checked";
                                                    } else {
                                                        var radio_value = '';
                                                    }
                                                    CHILD_HTML += '<div class="col-md-6">\
                                                        <label><input type="radio" name="field_' + indicatorgroupfield.field_id + '[0]" value = "' + option.value + '" style="margin-right: 5px;" data-field_id = "' + indicatorgroupfield.field_id + '" data-field_value = "' + option.value + '" data-required="' + requiredval + '"   ' + radio_value + ' data-fieldtype="groupfield" data-groupfieldcount = "0">' + option.label + '</label>\
                                                    </div>';
                                                });
                                                CHILD_HTML += '</div>\
                                                </div>\
                                                <p class="error red-800"></p>\
                                            </div>\
                                        </div>';
                                        if (indicatorgroupfield.child_count > 0) {
                                            CHILD_HTML += '<div class="col-md-12">\
                                                <div class="row childfields childof' + indicatorgroupfield.field_id + '"></div>\
                                            </div>';
                                        }
                                        break;

                                            case 'checkbox-group':
                                                CHILD_HTML += '<div class="col-md-' + i_divclass + '">\
                                                                        <div class="form-group">';
                                                CHILD_HTML += '<label>' + (g_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                if (indicatorgroupfield.description != null) {
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                }
                                                CHILD_HTML += '<div class="form-check row">\
                                                                                <div class="col-md-12">';
                                                indicatorgroupfield.options.forEach(function(option, index) {
                                                    var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                    if (option.selected == 'true' || option.selected == 'TRUE') {
                                                        var radio_value = "checked";
                                                    } else {
                                                        var radio_value = '';
                                                    }
                                                    CHILD_HTML += '<label><input type="checkbox" name="field_' + indicatorgroupfield.field_id + '[0][]" value = "' + option.value + '" style="margin-right: 5px;" data-field_id = "' + indicatorgroupfield.field_id + '" data-field_value = "' + option.value + '" data-required="' + requiredval + '"   ' + radio_value + ' data-fieldtype="groupfield" data-groupfieldcount = "0">' + option.label + '</label>';
                                                });
                                                CHILD_HTML += '</div>\
                                                                            </div>\
                                                                            <p class="error red-800"></p>\
                                                                        </div>\
                                                                    </div>';
                                                if (indicatorgroupfield.child_count > 0) {
                                                    CHILD_HTML += '<div class="col-md-12">\
                                                                            <div class="row childfields childof' + indicatorgroupfield.field_id + '"></div>\
                                                                        </div>';
                                                }
                                                break;

                                            case 'number':
                                                CHILD_HTML += '<div class="col-md-' + i_divclass + '">\
                                                                        <div class="form-group">';
                                                CHILD_HTML += '<label>' + (g_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                if (indicatorgroupfield.description != null) {
                                                    CHILD_HTML += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                }
                                                switch (indicatorgroupfield.subtype) {
                                                    case 'desimal':
                                                        CHILD_HTML += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[0]" class="' + indicatorgroupfield.className + ' decimal" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-maxvalue = "' + indicatorgroupfield.max_val + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="" >';
                                                        break;

                                                    case 'number':
                                                        CHILD_HTML += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[0]" class="' + indicatorgroupfield.className + ' number" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-maxvalue = "' + indicatorgroupfield.max_val + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="" >';
                                                        break;

                                                    case 'latitude':
                                                        CHILD_HTML += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[0]" class="' + indicatorgroupfield.className + ' latlong" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="" >';
                                                        break;

                                                    case 'longitude':
                                                        CHILD_HTML += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[0]" class="' + indicatorgroupfield.className + ' latlong" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="" >';
                                                        break;

                                                    default:
                                                        CHILD_HTML += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[0]" class="' + indicatorgroupfield.className + ' numberfield" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="" >';
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

                        if (fieldtype == 'groupfield') {
                            $elem.closest('.row').find('.' + classname).html(CHILD_HTML);
                        } else {
                            $('.' + classname).html(CHILD_HTML);
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
                } else {
                    if (fieldtype == 'groupfield') {
                        $elem.closest('.row').find('.' + classname).html('<p align="center" class="red-800">' + response.msg + '</p>');

                        $('html,body').animate({
                            scrollTop: $elem.closest('.row').find('.' + classname).offset().top - 300
                        }, 500);

                        setTimeout(function() {
                            $elem.closest('.row').find('.' + classname).empty();
                        }, 5000);
                    } else {
                        $('.' + classname).html('<p align="center" class="red-800">' + response.msg + '</p>');

                        $('html,body').animate({
                            scrollTop: $('.' + classname).offset().top - 300
                        }, 500);

                        setTimeout(function() {
                            $('.' + classname).empty();
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
			<div class="col-md-12">
				<a href="" onclick="window.close()" class="btn btn-sm btn-success pull-right">Back</a>
				<h4 class="h4_heading"><?php echo $indicator_name['indicator_name']; ?></h4>
			</div>

			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-1">
		                <h5 class="mb-5 mt-2 text-dark lh-25px">Year: <?php echo $year_name; ?></h5>
		            </div>
		            <!-- <div class="col-sm-2">
		                <h5 class="mb-5 mt-2 text-dark lh-25px">Country: <?php echo $country_name; ?></h5>
		            </div>
		            <div class="col-sm-2">
		                <h5 class="mb-5 mt-2 text-dark lh-25px">Crop: <?php echo $crop_name; ?></h5>
		            </div> -->
		        </div>
		    </div>

			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="english">1. Reporting Year<font color="red">*</font></label>
									<select name="year_id" class="form-control" data-required = "required">
										<?php foreach ($lkp_year_list as $key => $option) { ?>
											<option value = "<?php echo $option['year_id']; ?>"><?php echo $option['year']; ?></option> <?php
										} ?>
									</select>
									<p class="error red-800"></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="english">2. Reporting Period<font color="red">*</font></label>
									<select name="rperiod_id" class="form-control" data-required="required">
										<?php foreach ($lkp_rperiod_list as $key => $option1) { ?>
											<option value = "<?php echo $option1['rperiod_id']; ?>"><?php echo $option1['rperiod_name']; ?></option> <?php
										} ?>
									</select>
									<p class="error red-800"></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="english">3. Country/ Region<font color="red">*</font></label>
									<select name="country_id" class="form-control" data-required="required">
										<?php foreach ($lkp_country_list as $key => $option) { ?>
											<option value = "<?php echo $option['country_id']; ?>"><?php echo $option['country_name']; ?></option> <?php
										} ?>
									</select>
									<p class="error red-800"></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="english">4. Crop<font color="red">*</font></label>
									<select name="crop_id" class="form-control" data-required="required">
										<?php foreach ($lkp_crop_list as $key => $option) { ?>
											<option value = "<?php echo $option['crop_id']; ?>"><?php echo $option['crop_name']; ?></option> <?php
										} ?>
									</select>
									<p class="error red-800"></p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>5. Do you have data to report<font color="red">*</font></label>
									<div class="form-check">
										<div class="row">
											<div class="col-md-6">
												<label><input type="radio" name="field_5" value="Yes" style="margin-right: 5px;" data-field_id="5" data-field_value="Yes" data-required="required" data-fieldtype="normalfield">Yes</label>
											</div>
											<div class="col-md-6">
												<label><input type="radio" name="field_5" value="Nothing to report" style="margin-right: 5px;" data-field_id="5" data-field_value="Nothing to report" data-required="required" data-fieldtype="normalfield">Nothing to report</label>
											</div>
										</div>
										<p class="error red-800"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 mt-2">
				<?php $form_id_var = "excel_indicatordata_".$this->uri->segment(3).""; ?>				
				<form id="<?php echo $form_id_var; ?>">
					<div class="card p-10">
						<?php $i = 1; 
						foreach ($non_group_fields as $key => $indicatorfield) {
							switch ($indicatorfield['type']) {
								//display of text box field
	    						case 'text': ?>
									<div class="col-md-4">
				                      	<div class="form-group">
					                        <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
					                        if($indicatorfield['field_count']){
							            		$label = $textquestion.". ".$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
							            	<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php } ?>
											<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1) ? 'required' : '' ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorfield['subtype']; ?>" >
			                            	<p class="error red-800"></p>
			                            	<p class="maxlengtherror red-800"></p>
				                      	</div>
				                    </div>
									<?php break;

								//display of text box field
	    						case 'month': ?>
									<div class="col-md-4">
				                      	<div class="form-group">
					                        <?php $textquestion = ($indicatorfield['field_count']) ? $i++ : $i;
					                        if($indicatorfield['field_count']){
							            		$label = $textquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
							            	<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php } ?>
											<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> monthpicker" data-required = "<?php echo ($indicatorfield['required'] == 1) ? 'required' : '' ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
			                            	<p class="error red-800"></p>
			                            	<p class="maxlengtherror red-800"></p>
				                      	</div>
				                    </div>
									<?php break;

								//date picker
								case 'date': ?>
									<div class="col-md-4">
				                      	<div class="form-group">
					                        <?php $textquestion = ($indicatorfield['field_count']) ? $i++ : $i;
					                        if($indicatorfield['field_count']){
							            		$label = $textquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
							            	<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php } ?>
											<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> picker" data-required = "<?php echo ($indicatorfield['required'] == 1) ? 'required' : '' ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
			                            	<p class="error red-800"></p>
			                            	<p class="maxlengtherror red-800"></p>
				                      	</div>
				                    </div>
									<?php break;

								//display number field
	    						case 'number': ?>
	    							<div class="col-md-4">
			                        	<div class="form-group">
			                          		<?php $numberquestion = ($indicatorfield['field_count']) ? $i++ : $i;
											if($indicatorfield['field_count']){
							            		$label = $numberquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
											<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php }
	                             			switch ($indicatorfield['subtype']) {
				                                case 'desimal': ?>
				                                	<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> decimal" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" data-maxvalue = "<?php echo $indicatorfield['max_val']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1 ? 'required' : '') ?>" value="" >
				                                	<?php break;

				                                case 'number': ?>
				                                	<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> number" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" data-maxvalue = "<?php echo $indicatorfield['max_val']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1 ? 'required' : '') ?>" value="" >
				                                	<?php break;

				                                case 'latitude': ?>
				                                	<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> latlong" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1 ? 'required' : '') ?>" value="" >
				                                  	<?php break;

				                                case 'longitude': ?>
				                                	<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> latlong" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1 ? 'required' : '') ?>" value="" >
				                                  	<?php break;
				                                
				                                default: ?>
				                                	<input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> numberfield" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1 ? 'required' : '') ?>" value="" >
				                                  	<?php break;
	                              			} ?>
	                              			<p class="error red-800"></p>
	                              			<p class="maxlengtherror red-800"></p>
			                        	</div>
			                      	</div>
	    							<?php break;

	    						//display radio button
	    						case 'radio-group': ?>
				                    <div class="col-md-4">
										<div class="form-group">
											<?php $radioquestion = ($indicatorfield['field_count']) ? $i++ : $i;
											if($indicatorfield['field_count']){
							            		$label = $radioquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
											<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php } ?>
											<div class="form-check">
										    	<div class="row">
										    		<?php foreach ($indicatorfield['options'] as $key => $option) { 
										    			$requiredval = ($indicatorfield['required'] == 1) ? 'required' : ''; 
										    			if($option['selected'] == 'true' || $option['selected'] == 'TRUE'){ 
				                                			$radio_value = "checked"; 
				                                		}else{
				                                			$radio_value = '';
				                                		} ?>
				                                		<div class="col-md-6">
										    				<label><input type="radio" name="field_<?php echo $indicatorfield['field_id']; ?>" value = "<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id = "<?php echo $indicatorfield['field_id']; ?>" data-field_value = "<?php echo $option['value']; ?>" data-required="<?php echo $requiredval; ?>"  <?php echo $radio_value; ?> data-fieldtype="normalfield"><?php echo $option['label']; ?></label>
										    			</div>
										    			
										    		<?php } ?>
										    	</div>
										  	</div>
											<p class="error red-800"></p>
										</div>
				                    </div>
				                    <?php if($indicatorfield['child_count'] > 0){ ?>
			                    		<div class="col-md-12">
			                    			<div class="row childfields childof<?php echo $indicatorfield['field_id']; ?>"></div>
			                    		</div>
			                    	<?php }
	    							break;

	    						case 'checkbox-group': ?>
				                    <div class="col-md-4">
										<div class="form-group">
											<?php $radioquestion = ($indicatorfield['field_count']) ? $i++ : $i;
											if($indicatorfield['field_count']){
							            		$label = $radioquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
											<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php } ?>
											<div class="form-check">
												<div class="row">
													<?php foreach ($indicatorfield['options'] as $key => $option) { 
										    			$requiredval = ($indicatorfield['required'] == 1) ? 'required' : ''; 
										    			if($option['selected'] == 'true' || $option['selected'] == 'TRUE'){ 
				                                			$radio_value = "checked"; 
				                                		}else{
				                                			$radio_value = '';
				                                		} ?>
				                                		<div class="col-md-6">
										    				<label><input type="checkbox" name="field_<?php echo $indicatorfield['field_id']; ?>[]" value = "<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id = "<?php echo $indicatorfield['field_id']; ?>" data-field_value = "<?php echo $option['value']; ?>" data-required="<?php echo $requiredval; ?>"  <?php echo $radio_value; ?> data-fieldtype="normalfield"><?php echo $option['label']; ?></label>
										    			</div>											    			
										    		<?php } ?>
												</div>
											</div>
											<p class="error red-800"></p>
										</div>
				                    </div>
				                    <?php if($indicatorfield['child_count'] > 0){ ?>
			                    		<div class="col-md-12">
			                    			<div class="row childfields childof<?php echo $indicatorfield['field_id']; ?>"></div>
			                    		</div>
			                    	<?php }
	    							break;

	    						//display of textarea
	    						case 'textarea': ?>
				                    <div class="col-md-4">
										<div class="form-group">
											<?php $textareaquestion = ($indicatorfield['field_count']) ? $i++ : $i;
											if($indicatorfield['field_count']){
							            		$label = $textareaquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
											<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php } ?>
								    		<textarea name="field_<?php echo $indicatorfield['field_id']; ?>" rows="8" class="<?php echo $indicatorfield['className']; ?>" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength = "<?php echo $indicatorfield['maxlength']; ?>" data-required = "<?php echo ($indicatorfield['required'] == 1) ? 'required' : '' ?>"></textarea>
								    		<p class="error red-800"></p>
								    		<p class="maxlengtherror red-800"></p>
										</div>
				                    </div>
	    							<?php break;

	    						//display of select box
	    						case 'select': ?>
				                    <div class="col-md-4">
										<div class="form-group">
											<?php $selectquestion = ($indicatorfield['field_count']) ? $i++ : $i;
											if($indicatorfield['field_count']){
							            		$label = $selectquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
											<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<?php if($indicatorfield['description'] != NULL){ ?>
												<p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
											<?php }
											if($indicatorfield['multiple'] == 'true' || $indicatorfield['multiple'] == 'TRUE'){
								  				$selectname = "field_".$indicatorfield['field_id']."[]";
								  				$selectmultiple = "multiple";
								  			}else{
								  				$selectname = "field_".$indicatorfield['field_id']."";
								  				$selectmultiple = "";
								  			} ?>
								  			<select name="<?php echo $selectname; ?>" <?php echo $selectmultiple; ?> class="form-control selectbox" data-required = "<?php echo ($indicatorfield['required'] == 1) ? 'required' : '' ?>" data-field_id = "<?php echo $indicatorfield['field_id']; ?>"  data-fieldtype="normalfield" data-maxlength ="<?php echo $indicatorfield['maxlength']; ?>">
								   			<?php if($indicatorfield['multiple'] == 'true' || $indicatorfield['multiple'] == 'TRUE'){
								      		}else{ ?>
								        		<option value="">Select an option</option>
								        	<?php }
								        	foreach ($indicatorfield['options'] as $key => $option) { ?>
			                          			<option value="<?php echo $option['value']; ?>"><?php echo $option['label']; ?></option>
			                          		<?php } ?>
								    		</select>
								    		<p class="error red-800"></p>
										</div>
				                    </div>
				                    <?php if($indicatorfield['child_count'] > 0){ ?>
			                    		<div class="col-md-12">
			                    			<div class="row childfields childof<?php echo $indicatorfield['field_id']; ?>"></div>
			                    		</div>
			                    	<?php }
	    							break;

	    						case 'header': ?>
				                    <div class="col-md-12">
				                    	<?php if($indicatorfield['description'] != NULL){ 
				                    		echo $indicatorfield['description'];
				                    	} ?>
				                    	<<?php echo $indicatorfield['subtype']; ?> class="title" style="margin-top: 0px; margin-bottom: 20px;"><?php  ?>'+$indicatorfield['label']+'</<?php echo $indicatorfield['subtype']; ?>>
				                    </div>
				                	<?php break;

				                case 'uploadgroupdata_excel': ?>
				                	<div class="col-md-12">
					                	<div class="form-group">
					                		<?php $selectquestion = ($indicatorfield['field_count']) ? $i++ : $i;
											if($indicatorfield['field_count']){
							            		$label = $selectquestion.'. '.$indicatorfield['label'];
							            	}else{
							            		$label = $indicatorfield['label'];
							            	} ?>
											<label ><?php echo $label; ?> <?php echo ($indicatorfield['required'] == 1 ? "<font color='red'>*</font>" : ""); ?></label>
											<p style="font-size: 14px; font-style: italic; margin-bottom:20px; font-weight: 700;">Note: Only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>
											Use this Excel template to upload data:<a href="<?php echo base_url(); ?>include/excelformat/<?php echo $indicator_data['description']; ?>" download style="color: #000000;"><img src="<?php echo base_url(); ?>include/includeout/excel.png" style="width: 30px;"><?php echo $indicator_data['description']; ?></a>
											<div class="mt-20">
												<input type="file" class="uploadfile" name="uploadexcel_data" data-fieldtype="uploadfile" data-fieldsubtype="excel" data-required="required">
												<p style="font-size: 12px; font-style: italic; color: gray;">
													File size must be less than 2MB<br>
													Only .xlsx, .xls file type are allowed
												</p>
												<p class="error" style="color: red"></p>
											</div>
										</div>
									</div>
				                	<?php break;
							}
						} ?>
					
									

						<div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-success pull-right submit_indicator_exceldata"   style="margin-left:5px;">Preview data</button>
							</div>
						</div>
					</div>						
				</form>
			</div>

			<div class="col-md-12 datapreview"></div>
			<br/><br/><br/><br/>
		</div>
	</div><br/><br/><br/><br/>
</div>
</div>

<script type="text/javascript">
	$(function(){
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

		$('body').on('click', '.submit_indicator_exceldata', function(){
			$('.datapreview').html('');
			$elem = $(this);
            $elem.prop('disabled', true);

            $('.error').html('');

            var indicatorid = $(this).data("indicatorid");
            var subindicatorid = $(this).data("subindicatorid");
            var form_id = "excel_indicatordata_<?php echo $this->uri->segment(3); ?>";
            var surveycount = 0;

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

            $elem.closest('form').find('input[type=file]', form_id).each(function() {
				var fieldtype = $(this).data("fieldtype");
				var fieldsubtype = $(this).data("fieldsubtype");
				var requiredvalue = $(this).data("required");

				if(fieldsubtype == 'excel'){
					if(fieldtype == 'uploadfile' && typeof fieldtype !== 'undefined'){
						if(requiredvalue == 'required'){
							if($.trim($(this).val()).length === 0){
			                  	$(this).closest('.form-group').find('.error').html('This field is required');
			                  	surveycount = surveycount + 1;
			                }
						}

						if($(this).val() != ''){
		                  	var fileUpload = $(this)[0].files[0];
		                  	var fileTypes = ['xlsx', 'xls'];
		                  	var extension = fileUpload.name.split('.').pop().toLowerCase();
		                  	var error = [];

		                  	if(fileTypes.indexOf(extension) == '-1') {
		                    	error.push('Please upload a valid excel file.');
		                    	surveycount = surveycount + 1;
		                  	}
		                  	if(fileUpload.size > 512000) {
		                    	error.push('Upload file size should be less than 2MB');
		                    	surveycount = surveycount + 1;
		                  	}
		                  	$(this).closest('.form-group').find('.error').html(error.join('<br/>'));
		                }
		            }
		        }
			});

            if(surveycount == 0){
            	var indicatorform = new FormData($('#'+form_id)[0]);
              	indicatorform.append('form_id', <?php echo $this->uri->segment('3'); ?>);
                // indicatorform.append('year_id', <?php echo $this->uri->segment('4'); ?>);  
				indicatorform.append('year_val', $('select[name="year_id"]').val());
				indicatorform.append('country_val', $('select[name="country_id"]').val());
				indicatorform.append('rperiod_val', $('select[name="rperiod_id"]').val());
				indicatorform.append('crop_val', $('select[name="crop_id"]').val());          
                $.ajax({
                    url: '<?php echo base_url(); ?>reporting/insert_indicatordata_excel',
                    type: 'POST',
                    dataType : 'json',
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
                    success: function(response){
                        if(response.status == 0){
                            $.toast({
	                            heading: 'Error!',
	                            text: response.msg,
	                            icon: 'error',
	                            afterHidden: function() {
	                                $elem.prop('disabled', false);
	                            }
	                        });
                        }else{
                        	$('#'+form_id+' input[type="file"]').val('');
                        	$('#'+form_id+' input[type="tel"]').val('');
							$('#'+form_id+' input[type="text"]').val('');
							$('#'+form_id+' input[type="email"]').val('');
							$('#'+form_id+' input[type="file"]').val('');
							$('#'+form_id+' textarea').val('');
							$('#'+form_id+' select').val('');

                        	var HTML = '<div class="card p-10">\
								<div class="table-responsive">\
				    				<table class="table table-bordered mt-10" id="datatable">\
										<thead>\
											<tr style="background-color:#1e9ff2;">\
												<th style="color:#FFFFFF;">Sl.no</th>';
												response.get_groupfields.forEach(function(field, index){
													HTML += '<th style="color:#FFFFFF;">'+field.label+'</th>';
												});
												HTML += '<th style="color:#FFFFFF;">Action</th>\
											</tr>\
										</thead>\
										<tbody>';
											response.get_groupdata.forEach(function(data, dataindex){
												var jsondata = jQuery.parseJSON(data.formgroup_data);
												HTML += '<tr>\
													<td>'+(dataindex+1)+'</td>';
													response.get_groupfields.forEach(function(fielddata, fieldindex){
														var field_id = "field_"+fielddata.field_id;
														HTML += '<td>'+jsondata[field_id]+'</td>';
													});
													HTML += '<td>\
														<a class="delete_groupdata" style="color: red;" data-group_recordid = "'+data.group_id+'" data-recordid = "'+response.record_id+'"><i class="fa fa-trash" style="font-size:18px;"></i> Delete</a>\
													</td>\
												</tr>';
											});
										HTML += '</tbody>\
									</table>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<button type="button" class="btn btn-sm btn-success pull-right approve_data" data-recordid="'+response.record_id+'" style="margin-left:5px;">Submit data</button>\
									</div>\
								</div>\
							</div>';

							$('.datapreview').html(HTML);

							$.toast({
	                            heading: 'Success!',
	                            text: response.msg,
	                            icon: 'success',
	                        });
                        }
                    }
                });
            }else{
            	$elem.prop('disabled', false);
            }            
		});

		$('body').on('click', '.approve_data', function(){
			$elem = $(this);
            $elem.prop('disabled', true);

			var recordid = $elem.data("recordid");
			var form_id = "excel_indicatordata_<?php echo $this->uri->segment(3); ?>";
			
			$.ajax({
                url: '<?php echo base_url(); ?>reporting/approve_excel_previewdata',
                type: 'POST',
                dataType : 'json',
                data :{
                	recordid : recordid
                },
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
                success: function(response){
                    if(response.status == 0){
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error',
                        });
                    }else{
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
                    	$('.submit_indicator_exceldata').prop('disabled', false);
                        $('.datapreview').html('');
                    }
                }
            });
		});

		$('body').on('click', '.delete_groupdata', function(){
			$elem = $(this);
            $elem.prop('disabled', true);

			var recordid = $elem.data("recordid");
			var group_recordid = $elem.data("group_recordid");
			var group_table = $elem.data("group_table");

			$.ajax({
                url: '<?php echo base_url(); ?>reporting/delete_groupdata',
                type: 'POST',
                dataType : 'json',
                data :{
                	recordid : recordid,
                	group_recordid : group_recordid,
                	group_table : group_table
                },
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
                success: function(response){
                    if(response.status == 0){
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error',
                            afterHidden: function() {
                                $elem.prop('disabled', false);
                            }
                        });
                    }else{
                    	$.toast({
                            heading: 'Success!',
                            text: response.msg,
                            icon: 'success',
                            afterHidden: function() {
                                $elem.closest('tr').remove();
                                $elem.prop('disabled', false);
                            }
                        });
                    }
                    
                }
            });
		});

		$('body').on('change', 'input[type=radio]', function() {
	        $elem = $(this);

	        var field_id = $(this).attr("data-field_id");
	        var field_value = $(this).attr("data-field_value");
	        var fieldtype = $(this).attr("data-fieldtype");
	        if (fieldtype == 'groupfield') {
	            var groupfieldcount = $(this).attr("data-groupfieldcount");
	        } else {
	            var groupfieldcount = "";
	        }

	        var classname = 'childof' + field_id;
	        if (fieldtype == 'groupfield') {
	            $elem.closest('.row').find('.' + classname).html('');
	        } else {
	            $('.' + classname).html('');
	        }

	        var calltype = 'onchange';

	        var data = {
	            field_id: field_id,
	            field_value: field_value,
	            calltype: calltype,
	            fieldtype: fieldtype,
	            groupfieldcount: groupfieldcount
	        }

	        getchild_field(data, $elem);
	    });

	    $('body').on('change', 'input[type=checkbox]', function() {
	        $elem = $(this);

	        $elem.closest('.form-group').find('.error').html('');
	        var field_id = $(this).attr("data-field_id");
	        var fieldtype = $(this).attr("data-fieldtype");
	        var maxlength = $(this).attr("data-maxlength");

	        if (fieldtype == 'groupfield') {
	            var groupfieldcount = $(this).attr("data-groupfieldcount");
	        } else {
	            var groupfieldcount = "";
	        }

	        var name = $(this).attr("name");
	        var calltype = 'onchange';

	        var classname = 'childof' + field_id;
	        if (fieldtype == 'groupfield') {
	            $elem.closest('.row').find('.' + classname).html('');
	        } else {
	            $('.' + classname).html('');
	        }

	        var checkedvalues = [];
	        $.each($("input[name='" + name + "']:checked"), function() {
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
	    });

	    $('body').on('change', '.selectbox', function() {
	        $elem = $(this);

	        $elem.closest('.form-group').find('.error').empty();

	        var field_id = $(this).attr("data-field_id");
	        var fieldtype = $(this).attr("data-fieldtype");
	        var maxlength = $(this).attr("data-maxlength");

	        if (fieldtype == 'groupfield') {
	            var groupfieldcount = $(this).attr("data-groupfieldcount");
	        } else {
	            var groupfieldcount = "";
	        }

	        var name = $(this).attr("name");
	        var calltype = 'onchange';

	        var classname = 'childof' + field_id;
	        if (fieldtype == 'groupfield') {
	            $elem.closest('.row').find('.' + classname).html('');
	        } else {
	            $('.' + classname).html('');
	        }

	        var checkedvalues = [];
	        $.each($("select[name='" + name + "'] option:selected"), function() {
	            if ($(this).val() != '') {
	                checkedvalues.push($(this).val());
	            }
	        });

	        var field_value = checkedvalues;
	        if (maxlength != 'null') {
	            if (parseInt(maxlength) < parseInt(checkedvalues.length)) {
	                $elem.closest('.form-group').find('.error').html('Please select only ' + maxlength + ' option.');

	                $elem.val('');
	            } else {
	                if (field_value != '') {
	                    var data = {
	                        field_id: field_id,
	                        field_value: field_value,
	                        calltype: calltype,
	                        fieldtype: fieldtype,
	                        groupfieldcount: groupfieldcount
	                    }

	                    getchild_field(data, $elem);
	                }
	            }
	        } else {
	            if (field_value != '') {
	                var data = {
	                    field_id: field_id,
	                    field_value: field_value,
	                    calltype: calltype,
	                    fieldtype: fieldtype,
	                    groupfieldcount: groupfieldcount
	                }

	                getchild_field(data, $elem);
	            }
	        }
	    });
	});
</script>