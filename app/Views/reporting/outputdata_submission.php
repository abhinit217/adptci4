<style type="text/css">
    label {
        font-weight: bold;
    }

    th {
        color: #FFFFFF;
    }
</style>
<link href="<?php echo base_url(); ?>include/assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />
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
                                            <a class="btn-success btn-sm uploadgroupdata_excel" style="color: #FFFFFF !important;" data-subindicatorid="' + field.subindicator_id + '" data-indicatorid="' + field.indicator_id + '" target="_blank">Upload data using excel</a>\
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
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- <a href="<?php echo base_url(); ?>dashboard" class="btn btn-sm btn-warning mb-2 pull-right"><i class="fa fa-arrow-left"></i> Back</a> -->
                            <!--<button type="button" class="btn btn-sm btn-warning mb-2 pull-right" onclick="window.history.back()">Back</button>-->
                            <a href="javascript:close_window();" class="btn btn-sm btn-warning mb-2 pull-right">Back</a>
                            <h5 class="mb-5 mt-2 text-dark lh-25px"> <?php echo $form_details['title']; ?></h5>
                        </div>
                    </div>
                    <div class="row" style="position:relative;">
                        <div class="col-sm-2">
                            <h5 class="mb-5 mt-2 text-dark lh-25px">Year: <?php echo $year_name; ?></h5>
                        </div>
                        <div class="col-sm-2">
                            <h5 class="mb-5 mt-2 text-dark lh-25px">Country: <?php echo $country_name; ?></h5>
                        </div>
                        <div class="col-sm-2">
                            <h5 class="mb-5 mt-2 text-dark lh-25px">Crop: <?php echo $crop_name; ?></h5>
                        </div>
                        <?php if(isset($level2_outputdata) && $level2_outputdata['query_status'] == 1) { ?>
                        <span class="pulse one pull-right mt-3 mr-3"></span>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body p-15px indicatorfields">
                                    <form id="submit_data">
                                        <div class="row">
                                            <?php $i = 1;
                                            foreach ($indicator_fields as $key => $indicatorfield) {
                                                if ($indicatorfield['parent_id'] == NULL) {
                                                    switch ($indicatorfield['type']) {
                                                        case 'group': ?>
                                                            <div class="col-md-12 addmoremaindiv">
                                                                <?php $grouplabel = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                if ($indicatorfield['field_count'] == 1) {
                                                                    $label = $grouplabel . ". " . $indicatorfield['label'];
                                                                } else {
                                                                    $label = $indicatorfield['label'];
                                                                } ?>
                                                                <label><?php echo $label; ?></label>
                                                                <div class="row addmore addmore_div">
                                                                    <?php $indicator_groupfieldscount = count($indicatorfield['groupfields']);
                                                                    $i_divmainclass = ($indicator_groupfieldscount == 1) ? 6 : 11; ?>
                                                                    <div class="col-md-<?php echo $i_divmainclass; ?>">
                                                                        <div class="row">
                                                                            <?php foreach ($indicatorfield['groupfields'] as $ig_index => $indicatorgroupfield) {
                                                                                if ($indicator_groupfieldscount == 1) {
                                                                                    $i_divclass = 12;
                                                                                } else if ($indicator_groupfieldscount == 2) {
                                                                                    $i_divclass = 6;
                                                                                } else if ($indicator_groupfieldscount == 3) {
                                                                                    $i_divclass = 4;
                                                                                } else {
                                                                                    $i_divclass = 3;
                                                                                }
                                                                                switch ($indicatorgroupfield['type']) {
                                                                                    case 'text': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?>" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>">
                                                                                                <p class="error red-800"></p>
                                                                                                <p class="maxlengtherror red-800"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php break;

                                                                                    case 'textarea': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <textarea name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" rows="8" class="<?php echo $indicatorgroupfield['className']; ?>" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>"></textarea>
                                                                                                <p class="error red-800"></p>
                                                                                                <p class="maxlengtherror red-800"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php break;

                                                                                    case 'select': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <?php if ($indicatorgroupfield['multiple'] == 'true' || $indicatorgroupfield['multiple'] == 'TRUE') {
                                                                                                    $selectname = "field_" . $indicatorgroupfield['field_id'] . "[0][]";
                                                                                                    $selectmultiple = "multiple";
                                                                                                } else {
                                                                                                    $selectname = "field_" . $indicatorgroupfield['field_id'] . "[0]";
                                                                                                    $selectmultiple = "";
                                                                                                } ?>
                                                                                                <select name="<?php echo $selectname; ?>" <?php echo $selectmultiple; ?> class="form-control selectbox" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" data-field_id="<?php echo $indicatorgroupfield['field_id']; ?>" data-fieldtype="groupfield" data-groupfieldcount="0" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>">
                                                                                                    <?php if ($indicatorgroupfield['multiple'] == 'true' || $indicatorgroupfield['multiple'] == 'TRUE') { ?>
                                                                                                    <?php } else { ?>
                                                                                                        <option value="">Select an option</option>
                                                                                                    <?php } ?>
                                                                                                    <?php foreach ($indicatorgroupfield['options'] as $key => $option) {
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
                                                                                        <?php if ($indicatorgroupfield['child_count'] > 0) { ?>
                                                                                            <div class="col-md-12">
                                                                                                <div class="row childfields childof<?php echo $indicatorgroupfield['field_id']; ?>"></div>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    <?php break;

                                                                                    case 'radio-group': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <div class="form-check">
                                                                                                    <div class="row">
                                                                                                        <?php foreach ($indicatorgroupfield['options'] as $key => $option) {
                                                                                                            $requiredval = ($indicatorgroupfield['required'] == 1) ? "required" : "";
                                                                                                            if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
                                                                                                                $radio_value = "checked";
                                                                                                            } else {
                                                                                                                $radio_value = '';
                                                                                                            } ?>
                                                                                                            <div class="col-md-6">
                                                                                                                <label>
                                                                                                                    <input type="radio" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" value="<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $indicatorgroupfield['field_id']; ?>" data-field_value="<?php echo $option['value']; ?>" data-required="<?php echo $requiredval ?>" <?php echo $radio_value; ?> data-fieldtype="groupfield" data-groupfieldcount="0"><?php echo $option['label']; ?></label>
                                                                                                            </div>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <p class="error red-800"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php if ($indicatorgroupfield['child_count'] > 0) { ?>
                                                                                            <div class="col-md-12">
                                                                                                <div class="row childfields childof<?php echo $indicatorgroupfield['field_id']; ?>"></div>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    <?php break;

                                                                                    case 'checkbox-group': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) {
                                                                                                    if ('0') { ?>
                                                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php }
                                                                                                } ?>
                                                                                                <div class="form-check">
                                                                                                    <div class="row">
                                                                                                        <?php foreach ($indicatorgroupfield['options'] as $key => $option) {
                                                                                                            $requiredval = ($indicatorgroupfield['required'] == 1) ? "required" : "";
                                                                                                            if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
                                                                                                                $radio_value = "checked";
                                                                                                            } else {
                                                                                                                $radio_value = '';
                                                                                                            } ?>
                                                                                                            <div class="col-md-6">
                                                                                                                <label><input type="checkbox" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0][]" value="<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $indicatorgroupfield['field_id']; ?>" data-field_value="<?php echo $option['value'] ?>" data-required="<?php echo $requiredval ?>" <?php echo $radio_value; ?> data-fieldtype="groupfield" data-groupfieldcount="0"><?php echo $option['label']; ?></label>
                                                                                                            </div>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <p class="error red-800"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php if ($indicatorgroupfield['child_count'] > 0) { ?>
                                                                                            <div class="col-md-12">
                                                                                                <div class="row childfields childof<?php echo $indicatorgroupfield['field_id']; ?>"></div>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    <?php break;

                                                                                    case 'number': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <?php switch ($indicatorgroupfield['subtype']) {
                                                                                                    case 'desimal': ?>
                                                                                                        <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> decimal" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" data-maxvalue="'+indicatorgroupfield.max_val+'" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" value="">
                                                                                                    <?php break;

                                                                                                    case 'number': ?>
                                                                                                        <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> number" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" data-maxvalue="'+indicatorgroupfield.max_val+'" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" value="">
                                                                                                    <?php break;

                                                                                                    case 'latitude': ?>
                                                                                                        <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> latlong" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" value="">
                                                                                                    <?php break;

                                                                                                    case 'longitude': ?>
                                                                                                        <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> latlong" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" value="">
                                                                                                    <?php break;

                                                                                                    default: ?>
                                                                                                        <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> numberfield" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" value="">
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
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> picker" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
                                                                                                <p class="error red-800"></p>
                                                                                                <p class="maxlengtherror red-800"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php break;

                                                                                    case 'month': ?>
                                                                                        <div class="col-md-<?php echo $i_divclass; ?>">
                                                                                            <div class="form-group">
                                                                                                <?php $questionno = $ig_index + 1; ?>
                                                                                                <label><?php echo $questionno; ?>. <?php echo $indicatorgroupfield['label']; ?><?php echo ($indicatorgroupfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                                                <?php if ($indicatorgroupfield['description'] != NULL) { ?>
                                                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorgroupfield['description']; ?></p>
                                                                                                <?php } ?>
                                                                                                <input type="text" name="field_<?php echo $indicatorgroupfield['field_id']; ?>[0]" class="<?php echo $indicatorgroupfield['className']; ?> monthpicker" data-required="<?php echo ($indicatorgroupfield['required'] == 1) ? "required" : ""; ?>" data-maxlength="<?php echo $indicatorgroupfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorgroupfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
                                                                                                <p class="error red-800"></p>
                                                                                                <p class="maxlengtherror red-800"></p>
                                                                                            </div>
                                                                                        </div>
                                                                            <?php break;
                                                                                }
                                                                            } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 mt-20 add_remove_button">
                                                                        <button type="button" class="btn btn-success btn-sm addmorefields pull-left" style="margin-bottom: 15px; margin-top:30px;"><span class="glyphicon glyphicon-plus"></span> Add
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                            //display of text box field
                                                        case 'text': ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorfield['subtype']; ?>">
                                                                    <p class="error red-800"></p>
                                                                    <p class="maxlengtherror red-800"></p>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                            //display of text box field
                                                        case 'month': ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> monthpicker" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
                                                                    <p class="error red-800"></p>
                                                                    <p class="maxlengtherror red-800"></p>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                            //date picker
                                                        case 'date': ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> picker" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" value="" data-subtype="<?php echo $indicatorfield['subtype']; ?>" onkeydown="return false" autocomplete="off">
                                                                    <p class="error red-800"></p>
                                                                    <p class="maxlengtherror red-800"></p>
                                                                </div>\
                                                            </div>
                                                        <?php break;

                                                            //display number field
                                                        case 'number':
                                                            $numb_col = ($this->uri->segment(3) == 89) ? 3 : 4; ?>
                                                            <div class="col-md-<?php echo $numb_col; ?>">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <?php switch ($indicatorfield['subtype']) {
                                                                        case 'desimal': ?>
                                                                            <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> decimal" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" data-maxvalue="<?php echo $indicatorfield['max_val']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" value="">
                                                                        <?php break;

                                                                        case 'number': ?>
                                                                            <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> number" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" data-maxvalue="<?php echo $indicatorfield['max_val']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" value="">
                                                                        <?php break;

                                                                        case 'latitude': ?>
                                                                            <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> latlong" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" value="">
                                                                        <?php break;

                                                                        case 'longitude': ?>
                                                                            <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> latlong" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" value="">
                                                                        <?php break;

                                                                        default: ?>
                                                                            <input type="text" name="field_<?php echo $indicatorfield['field_id']; ?>" class="<?php echo $indicatorfield['className']; ?> numberfield" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-subtype="<?php echo $indicatorfield['maxlength']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" value="">
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
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <div class="form-check">
                                                                        <div class="row">
                                                                            <?php foreach ($indicatorfield['options'] as $key => $option) {
                                                                                $requiredval = ($indicatorfield['required'] == 1) ? "required" : "";
                                                                                if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
                                                                                    $radio_value = "checked";
                                                                                } else {
                                                                                    $radio_value = '';
                                                                                } ?>
                                                                                <div class="col-md-6">
                                                                                    <label><input type="radio" name="field_<?php echo $indicatorfield['field_id']; ?>" value="<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $indicatorfield['field_id']; ?>" data-field_value="<?php echo $option['value']; ?>" data-required="<?php echo $requiredval; ?>" <?php echo $radio_value; ?> data-fieldtype="normalfield"><?php echo $option['label']; ?></label>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <p class="error red-800"></p>
                                                                </div>
                                                            </div>
                                                            <?php if ($indicatorfield['child_count'] > 0) { ?>
                                                                <div class="col-md-12">
                                                                    <div class="row childfields childof<?php echo $indicatorfield['field_id']; ?>"></div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php break;

                                                        case 'checkbox-group':
                                                            $numb_col = ($this->uri->segment(3) == 89) ? 3 : 4; ?>
                                                            <div class="col-md-<?php echo $numb_col; ?>">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <div class="form-check">
                                                                        <div class="row">
                                                                            <?php foreach ($indicatorfield['options'] as $key => $option) { ?>
                                                                                <div class="col-md-6">
                                                                                    <?php $requiredval = ($indicatorfield['required'] == 1) ? "required" : "";
                                                                                    if ($option['selected'] == 'true' || $option['selected'] == 'TRUE') {
                                                                                        $radio_value = "checked";
                                                                                    } else {
                                                                                        $radio_value = '';
                                                                                    } ?>
                                                                                    <label>
                                                                                        <input type="checkbox" name="field_<?php echo $indicatorfield['field_id']; ?>[]" value="<?php echo $option['value']; ?>" style="margin-right: 5px;" data-field_id="<?php echo $indicatorfield['field_id']; ?>" data-field_value="<?php echo $option['value']; ?>" data-required="<?php echo $requiredval; ?>" <?php echo $radio_value; ?> data-fieldtype="normalfield"><?php echo $option['label']; ?>
                                                                                    </label>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <p class="error red-800"></p>
                                                                </div>
                                                            </div>
                                                            <?php if ($indicatorfield['child_count'] > 0) { ?>
                                                                <div class="col-md-12">
                                                                    <div class="row childfields childof<?php echo $indicatorfield['field_id']; ?>"></div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php break;

                                                            //display of select box
                                                        case 'select': ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <?php if ($indicatorfield['multiple'] == 'true' || $indicatorfield['multiple'] == 'TRUE') {
                                                                        $selectname = "field_" . $indicatorfield['field_id'] . "[]";
                                                                        $selectmultiple = "multiple";
                                                                    } else {
                                                                        $selectname = "field_" . $indicatorfield['field_id'] . "";
                                                                        $selectmultiple = "";
                                                                    } ?>
                                                                    <select name="<?php echo $selectname; ?>" <?php echo $selectmultiple; ?> class="form-control selectbox" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" data-field_id="<?php echo $indicatorfield['field_id']; ?>" data-fieldtype="normalfield" data-maxlength="<?php echo $indicatorfield['maxlength']; ?>">
                                                                        <?php if ($indicatorfield['multiple'] == 'true' || $indicatorfield['multiple'] == 'TRUE') {
                                                                        } else { ?>
                                                                            <option value="">Select an option</option>
                                                                        <?php } ?>
                                                                        <?php foreach ($indicatorfield['options'] as $key => $option) {
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
                                                            <?php if ($indicatorfield['child_count'] > 0) { ?>
                                                                <div class="col-md-12">
                                                                    <div class="row childfields childof<?php echo $indicatorfield['field_id']; ?>"></div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php break;

                                                            //display of textarea
                                                        case 'textarea': ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <textarea name="field_<?php echo $indicatorfield['field_id']; ?>" rows="8" class="<?php echo $indicatorfield['className']; ?>" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength="<?php echo $indicatorfield['maxlength']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>"></textarea>
                                                                    <p class="error red-800"></p>
                                                                    <p class="maxlengtherror red-800"></p>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                            //textarea_editor
                                                        case 'textarea_editor':
                                                            $col_num = ($form_details['type'] == 1) ? 12 : 4; ?>
                                                            <div class="col-md-<?php echo $col_num; ?>">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <textarea name="field_<?php echo $indicatorfield['field_id']; ?>" rows="8" class="<?php echo $indicatorfield['className']; ?>" data-subtype="<?php echo $indicatorfield['subtype']; ?>" data-maxlength="<?php echo $indicatorfield['maxlength']; ?>" data-required="<?php echo ($indicatorfield['required'] == 1) ? 'required' : ''; ?>" id="textarea_1"><?php echo $output_fielddata; ?></textarea>
                                                                    <p class="error red-800"></p>
                                                                    <p class="maxlengtherror red-800"></p>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                        case 'header': ?>
                                                            <div class="col-md-12">
                                                                <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                    <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                <?php } ?>
                                                                <<?php echo $indicatorfield['subtype']; ?> class="title" style="margin-top: 0px; margin-bottom: 20px;"><?php echo $indicatorfield['label']; ?></<?php echo $indicatorfield['subtype']; ?>>
                                                            </div>
                                                        <?php break;

                                                        case 'uploadfile': ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php $textquestion = ($indicatorfield['field_count'] == 1) ? $i++ : $i;
                                                                    if ($indicatorfield['field_count'] == 1) {
                                                                        $label = $textquestion . '. ' . $indicatorfield['label'];
                                                                    } else {
                                                                        $label = $indicatorfield['label'];
                                                                    } ?>
                                                                    <label><?php echo $label; ?><?php echo ($indicatorfield['required'] == 1) ? "<font color='red'>*</font>" : ""; ?></label>
                                                                    <?php if ($indicatorfield['description'] != NULL) { ?>
                                                                        <p style="font-size: 10px; font-style: italic; color: gray;">Note: <?php echo $indicatorfield['description']; ?></p>
                                                                    <?php } ?>
                                                                    <?php $requiredval = ($indicatorfield['required'] == 1) ? "required" : "notrequired";
                                                                    if ($indicatorfield['subtype'] == 'excel') { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <p style="font-size: 10px; font-style: italic; color: gray;">Note: only data in the same excel format will be accepted. So please follow the template and do not modify/change.</p>
                                                                                Use this Excel template to upload the data:<a href="<?php echo base_url(); ?>includeout/avisareporting_excelformats/<?php echo $indicatorfield['description'] ?>" download=""><img src="<?php echo base_url(); ?>includeout/images/excel.png" style="width: 30px;"><?php echo $indicatorfield['description'] ?></a>
                                                                                <input type="file" class="uploadfile" data-fieldtype="<?php echo $indicatorfield['type']; ?>" data-fieldsubtype="<?php echo $indicatorfield['subtype']; ?>" data-required="<?php echo $requiredval ?>" name="field_<?php echo $indicatorfield['field_id']; ?>">
                                                                                <p style="font-size: 10px; font-style: italic; color: gray;">
                                                                                    File size must be less than 500KB<br />
                                                                                    Only .xlsx, .xls file type are allowed
                                                                                </p>
                                                                                <p class="error" style="color: red"></p>
                                                                            </div>
                                                                        </div>
                                                                    <?php } else if ($indicatorfield['subtype'] == 'document') { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <input type="file" class="uploaddocument" data-fieldtype="<?php echo $indicatorfield['type']; ?>" data-fieldsubtype="<?php echo $indicatorfield['subtype']; ?>" data-required="<?php echo $requiredval ?>" name="field_<?php echo $indicatorfield['field_id']; ?>">
                                                                                <p style="font-size: 10px; font-style: italic; color: gray;">
                                                                                    File size must be less than 500KB<br />
                                                                                    Only .pdf file type are allowed
                                                                                </p>
                                                                                <p class="error" style="color: red"></p>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php break;

                                                        /*case 'uploadgroupdata_excel': ?>
                                                            <div class="col-md-12" style="margin-bottom: 15px;">
                                                                <a class="btn-success btn-sm uploadgroupdata_excel" style="color: #FFFFFF !important;"   target="_blank">Upload data using excel</a>
                                                            </div>
                                                        <?php break;*/
                                                    }
                                                }
                                            } ?>
                                            <div class="col-md-12">
                                                <?php if (isset($formtype) && $formtype != 'output') { ?>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label style="color:#c51205 !important"><input type="checkbox" class="nothingto_report" <?php echo ($nothingto_report == 0) ? '' : 'checked' ?>> Nothing to report</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label><input type="checkbox" class="default_indicatorcomment" name=""> Add comment</label>
                                                            <div class="row">
                                                                <div class="col-md-10 indicator_comment">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-12">
                                                <?php if(isset($output_submissiontype)) {
                                                    if(is_null($output_querytype)) {
                                                        if($output_submissiontype == 2) {
                                                            echo '<h5 class="text-right text-success">Data Already Submitted.</h5>';
                                                        } else {
                                                            echo '<button type="button" class="btn btn-sm btn-success pull-right submit_data">
                                                                Submit data
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-success pull-right save_data" style="margin-right:10px;">
                                                                Save data
                                                            </button>';
                                                        }
                                                    } else { ?>
                                                        <button type="button" class="btn btn-sm btn-success pull-right submit_data">
                                                            Update data
                                                        </button>
                                                    <?php }
                                                } else { ?>
                                                    <button type="button" class="btn btn-sm btn-success pull-right submit_data">
                                                        Submit data
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success pull-right save_data" style="margin-right:10px;">
                                                        Save data
                                                    </button>
                                                <?php } ?>
                                            </div>

                                            <?php if(isset($level2_outputdata)) { ?>
                                            <div class="col-md-12 text-orange mt-5"><h4>
                                                Queries Related to Data
                                                <?php if(is_null($level2_outputdata['query_status'])) { ?>
                                                <span class="pull-right">N/A</span>
                                                <?php } else { ?>
                                                <a href="javascript:void(0)" class="showQuery pull-right" data-value="<?php echo $level2_outputdata['data_id']; ?>">
                                                    <i class="fa fa-plus" style="font-size:18px;"></i>
                                                </a>
                                                <?php } ?>
                                            </h4></div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>

                                <div class="query_list bg-white mt-2 p-3"></div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <?php if (isset($output_data) && count($output_data) > 0) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <?php foreach ($output_data as $key => $data) {
                                                    $data_array = json_decode($data['form_data'], true); ?>
                                                    <div class="row" id="data_<?php echo $key; ?>">
                                                        <div class="col-md-12 <?php echo ($key > 0) ? 'mt-5' : ''; ?>">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="background-color: #ff0000; width: 30px; text-align: center; color: #FFFFFF !important; margin-bottom: 10px;"><?php echo $key + 1; ?></label>
                                                                    <?php if($this->session->userdata('role') == 5 && $data['query_status'] == 2) { ?>
                                                                    <span class="pulse one mt-1 mr-3"></span>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <h4 class="title">Submitted by: <?php echo $data['username']; ?></h4>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p class="pull-right"> Submitted on: <?php echo $data['reg_date_time']; ?> (UTC)</p>
                                                                </div>
                                                            </div>
                                                            <hr style="margin-top: 0px; border: none; height: 1px; background-color: #030195;">
                                                        </div>

                                                        <?php if($this->session->userdata('role') == 5) { ?>
                                                        <div class="col-md-12 mb-2">
                                                            <button type="button" class="btn btn-sm btn-warning pull-right send_back" data-recordid="<?php echo $data['data_id']; ?>" data-by="<?php echo $data['username']; ?>">Send Back</button>
                                                        </div>
                                                        <?php } ?>

                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="datatable">
                                                                    <thead>
                                                                        <tr style="background-color:#050c43;">
                                                                            <th style="color: #FFFFFF; text-align: center;">Country</th>
                                                                            <th style="color: #FFFFFF; text-align: center;">Crop</th>
                                                                            <th style="color: #FFFFFF; text-align: center;">Comment</th>
                                                                            <?php foreach ($form_fields as $lkey => $value) { ?>
                                                                                <th style="color: #FFFFFF; text-align: center;"><?php echo $value['label']; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><?php echo $data['country_name']; ?></td>
                                                                            <td><?php echo $data['crop_name']; ?></td>
                                                                            <td><?php echo ($data['comment'] == NULL) ? "N/A" : $data['comment']; ?></td>
                                                                            <?php foreach ($form_fields as $f_key => $field) {
                                                                                $field_key = "field_" . $field['field_id'];

                                                                                switch ($field['type']) {
                                                                                    case 'header':
                                                                                        echo "<td></td>";
                                                                                        break;
                                                                                    
                                                                                    default:
                                                                                        if (!isset($data_array[$field_key]) || $data_array[$field_key] == '' || $data_array[$field_key] == NULL) {
                                                                                            echo "<td>N/A</td>";
                                                                                        } else {
                                                                                            if ($field['type'] != 'uploadfile') { ?>
                                                                                                <td><?php echo $data_array[$field_key];  ?></td>
                                                                                            <?php } else { ?>
                                                                                                <td>
                                                                                                    <a href="<?php echo base_url(); ?>upload/survey/<?php echo $data_array[$field_key]; ?>" download>Download file</a>
                                                                                                </td>
                                                                                            <?php }
                                                                                        }
                                                                                    break;
                                                                                }
                                                                            } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 text-orange mt-5"><h4>
                                                            Queries Related to Data
                                                            <?php if(is_null($data['query_status'])) { ?>
                                                            <span class="pull-right">N/A</span>
                                                            <?php } else { ?>
                                                            <a href="javascript:void(0)" class="showQuery pull-right" data-value="<?php echo $data['data_id']; ?>">
                                                                <i class="fa fa-plus" style="font-size:18px;"></i>
                                                            </a>
                                                            <?php } ?>
                                                        </h4></div>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="query_list bg-white mt-2 p-3"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-12">
                            <?php if (isset($indicator_data) && count($indicator_data) > 0) {
                                foreach ($indicator_data as $key => $indicator) { ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h4><?php echo $indicator['indicator_info']['form_details']['title']; ?></h4>

                                            <?php if (count($indicator['indicator_info']['form_data']) > 0) {
                                                foreach ($indicator['indicator_info']['form_data'] as $key => $data) {
                                                    $data_array = json_decode($data['form_data'], true); ?>
                                                    <div class="row">
                                                        <div class="col-md-12 <?php echo ($key > 0) ? 'mt-5' : ''; ?>">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="background-color: #ff0000; width: 30px; text-align: center; color: #FFFFFF !important; margin-bottom: 10px;"><?php echo $key + 1; ?></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <h4 class="title">Submitted by: <?php echo $data['username']; ?></h4>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p class="pull-right"> Submitted on: <?php echo $data['reg_date_time']; ?> (UTC)</p>
                                                                </div>
                                                            </div>
                                                            <hr style="margin-top: 0px; border: none; height: 1px; background-color: #030195;">
                                                        </div>

                                                        <?php if($this->session->userdata('role') == 5){ ?>
                                                        <div class="col-md-12">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-warning pull-right getfields_tosubmit_savedata" style="color: blue; margin-right: 15px;" data-recordid="<?php echo $data['data_id']; ?>" data-formid="<?php echo $indicator['indicator_info']['form_details']['id']; ?>" data-formtype="level3_edit"><i class="fa fa-pencil" style="font-size:14px;"></i> Edit data</a>

                                                            <button type="button" class="btn btn-sm btn-warning pull-right send_back" data-recordid="<?php echo $data['data_id']; ?>" data-by="<?php echo $data['username']; ?>" style="margin-right:10px;">Send Back</button>
                                                        </div>
                                                        <?php } ?>

                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="datatable">
                                                                    <thead>
                                                                        <tr style="background-color:#050c43;">
                                                                            <th style="color: #FFFFFF;">Country</th>
                                                                            <th style="color: #FFFFFF;">Crop</th>
                                                                            <th style="color: #FFFFFF;">Comment</th>
                                                                            <?php foreach ($indicator['indicator_info']['form_fields'] as $lkey => $value) { ?>
                                                                                <th style="color: #FFFFFF;"><?php echo $value['label']; ?></th>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><?php echo $data['country_name']; ?></td>
                                                                            <td><?php echo $data['crop_name']; ?></td>
                                                                            <td><?php echo ($data['comment'] == NULL) ? "N/A" : $data['comment']; ?></td>
                                                                            <?php foreach ($indicator['indicator_info']['form_fields'] as $f_key => $field) {
                                                                                $field_key = "field_" . $field['field_id'];

                                                                                switch ($field['type']) {
                                                                                    case 'header':
                                                                                        echo "<td></td>";
                                                                                        break;
                                                                                    
                                                                                    default:
                                                                                        if (!isset($data_array[$field_key]) || $data_array[$field_key] == '' || $data_array[$field_key] == NULL) {
                                                                                            echo "<td>N/A</td>";
                                                                                        } else {
                                                                                            if ($field['type'] != 'uploadfile') { ?>
                                                                                                <td><?php echo $data_array[$field_key];  ?></td>
                                                                                            <?php } else { ?>
                                                                                                <td>
                                                                                                    <a href="<?php echo base_url(); ?>upload/survey/<?php echo $data_array[$field_key]; ?>" download>Download file</a>
                                                                                                </td>
                                                                                        <?php }
                                                                                        }
                                                                                        break;
                                                                                }
                                                                            } ?>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mt-10">
                                                            <?php if (isset($indicator['indicator_info']['group_array']) && (count($data) > 0)) {
                                                                foreach ($indicator['indicator_info']['group_array'] as $key => $group) { ?>
                                                                    <h4 class="title"><?php echo $group['group_lable']['label']; ?></h4>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" id="datatable">
                                                                            <thead>
                                                                                <tr style="background-color:#050c43;">
                                                                                    <th style="color: #FFFFFF;">Sl.no</th>
                                                                                    <?php foreach ($group['group_fields'] as $key => $g_field) { ?>
                                                                                        <th style="color: #FFFFFF;"><?php echo $g_field['label']; ?></th>
                                                                                    <?php }
                                                                                    if (($data['status'] == 2 || $data['status'] == 1) && ($data['user_id'] == $this->session->userdata('login_id'))) { ?>
                                                                                        <th style="color: #FFFFFF;">Action</th>
                                                                                    <?php } ?>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($data['groupdata'] as $gkey => $g_data) {
                                                                                    $g_data_array = json_decode($g_data['formgroup_data'], true);
                                                                                    if ($group['group_lable']['field_id'] == $g_data['groupfield_id']) { ?>
                                                                                        <tr id="data_<?php echo $key; ?><?php echo $gkey; ?>">
                                                                                            <td><?php echo $gkey + 1; ?></td>
                                                                                            <?php foreach ($group['group_fields'] as $key => $g_field) {
                                                                                                $field_key = "field_" . $g_field['field_id']; ?>
                                                                                                <td><?php echo $g_data_array[$field_key];  ?></td>
                                                                                            <?php }
                                                                                            if (($data['status'] == 2 || $data['status'] == 1) && ($data['user_id'] == $this->session->userdata('login_id'))) { ?>
                                                                                                <td>
                                                                                                    <a class="delete_groupdata" style="color: red;" data-group_recordid="<?php echo $g_data['group_id']; ?>" data-recordid="<?php echo $data['id']; ?>"><i class="fa fa-trash" style="font-size:18px;"></i> Delete</a>
                                                                                                </td>
                                                                                            <?php } ?>
                                                                                        </tr>
                                                                                <?php }
                                                                                } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                        </div>

                                                        <div class="col-md-12 usersindicator_list mt-20"></div>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>


                                    <?php if ($indicator['sub_indicators_count'] > 0) {
                                        foreach ($indicator['sub_indicators_info'] as $key => $sub_indicator) { ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5><?php echo $sub_indicator['indicator_info']['form_details']['title']; ?></h5>
                                                    <?php if (count($sub_indicator['indicator_info']['form_data']) > 0) {
                                                        foreach ($sub_indicator['indicator_info']['form_data'] as $key => $sub_data) {
                                                            $sub_data_array = json_decode($sub_data['form_data'], true); ?>
                                                            <div class="row">
                                                                <div class="col-md-12 <?php echo ($key > 0) ? 'mt-5' : ''; ?>">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label style="background-color: #ff0000; width: 30px; text-align: center; color: #FFFFFF !important; margin-bottom: 10px;"><?php echo $key + 1; ?></label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <h4 class="title">Submitted by: <?php echo $sub_data['username']; ?></h4>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <p class="pull-right"> Submitted on: <?php echo $sub_data['reg_date_time']; ?> (UTC)</p>
                                                                        </div>
                                                                    </div>
                                                                    <hr style="margin-top: 0px; border: none; height: 1px; background-color: #030195;">
                                                                </div>

                                                                <?php if($this->session->userdata('role') == 5){ ?>
                                                                <div class="col-md-12">
                                                                    <a href="javascript:void(0);" class="btn btn-sm btn-warning pull-right getfields_tosubmit_savedata" style="color: blue; margin-right: 15px;" data-recordid="<?php echo $sub_data['data_id']; ?>" data-formid="<?php echo $sub_indicator['indicator_info']['form_details']['id']; ?>" data-formtype="level3_edit"><i class="fa fa-pencil" style="font-size:14px;"></i> Edit data</a>

                                                                    <button type="button" class="btn btn-sm btn-warning pull-right send_back" data-recordid="<?php echo $sub_data['data_id']; ?>" data-by="<?php echo $sub_data['username']; ?>" style="margin-right:10px;">Send Back</button>
                                                                </div>
                                                                <?php } ?>

                                                                <div class="col-md-12 mt-2">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" id="datatable">
                                                                            <thead>
                                                                                <tr style="background-color:#050c43;">
                                                                                    <th style="color: #FFFFFF;">Country</th>
                                                                                    <th style="color: #FFFFFF;">Crop</th>
                                                                                    <th style="color: #FFFFFF;">Comment</th>
                                                                                    <?php foreach ($sub_indicator['indicator_info']['form_fields'] as $lkey => $value) { ?>
                                                                                        <th style="color: #FFFFFF;"><?php echo $value['label']; ?></th>
                                                                                    <?php } ?>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><?php echo $sub_data['country_name']; ?></td>
                                                                                    <td><?php echo $sub_data['crop_name']; ?></td>
                                                                                    <td><?php echo ($sub_data['comment'] == NULL) ? "N/A" : $sub_data['comment']; ?></td>
                                                                                    <?php foreach ($sub_indicator['indicator_info']['form_fields'] as $f_key => $field) {
                                                                                        $field_key = "field_" . $field['field_id'];

                                                                                        switch ($field['type']) {
                                                                                            case 'header':
                                                                                                echo "<td></td>";
                                                                                                break;
                                                                                            
                                                                                            default:
                                                                                                if (!isset($sub_data_array[$field_key]) || $sub_data_array[$field_key] == '' || $sub_data_array[$field_key] == NULL) {
                                                                                                    echo "<td>N/A</td>";
                                                                                                } else {
                                                                                                    if ($field['type'] != 'uploadfile') { ?>
                                                                                                        <td><?php echo $sub_data_array[$field_key];  ?></td>
                                                                                                    <?php } else { ?>
                                                                                                        <td>
                                                                                                            <a href="<?php echo base_url(); ?>upload/survey/<?php echo $sub_data_array[$field_key]; ?>" download>Download file</a>
                                                                                                        </td>
                                                                                                <?php }
                                                                                                }
                                                                                                break;
                                                                                        }
                                                                                    } ?>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mt-10">
                                                                    <?php if (isset($sub_indicator['indicator_info']['group_array']) && (count($sub_data) > 0)) {
                                                                        foreach ($sub_indicator['indicator_info']['group_array'] as $key => $group) { ?>
                                                                            <h4 class="title"><?php echo $group['group_lable']['label']; ?></h4>
                                                                            <div class="table-responsive">
                                                                                <table class="table table-bordered" id="datatable">
                                                                                    <thead>
                                                                                        <tr style="background-color:#050c43;">
                                                                                            <th style="color: #FFFFFF;">Sl.no</th>
                                                                                            <?php foreach ($group['group_fields'] as $key => $g_field) { ?>
                                                                                                <th style="color: #FFFFFF;"><?php echo $g_field['label']; ?></th>
                                                                                            <?php } ?>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php foreach ($sub_data['groupdata'] as $gkey => $g_data) {
                                                                                            $g_data_array = json_decode($g_data['formgroup_data'], true);
                                                                                            if ($group['group_lable']['field_id'] == $g_data['groupfield_id']) { ?>
                                                                                                <tr id="data_<?php echo $key; ?><?php echo $gkey; ?>">
                                                                                                    <td><?php echo $gkey + 1; ?></td>
                                                                                                    <?php foreach ($group['group_fields'] as $key => $g_field) {
                                                                                                        $field_key = "field_" . $g_field['field_id']; ?>
                                                                                                        <td><?php echo $g_data_array[$field_key];  ?></td>
                                                                                                    <?php } ?>
                                                                                                </tr>
                                                                                        <?php }
                                                                                        } ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                    <?php }
                                                                    } ?>
                                                                </div>

                                                                <div class="col-md-12 usersindicator_list mt-20"></div>
                                                            </div>
                                                    <?php }
                                                    } else {
                                                        echo "<p class='pl-5'>No data found.</p>";
                                                    } ?>
                                                </div>
                                            </div>
                                        <?php }
                                    }
                                }
                            } ?>
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
    function close_window() {
        window.close();
    }
    $(function() {
        // Initialize Sisyphus
        $("#submit_data").sisyphus();
        $('.default_indicatorcomment').trigger('change');

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

        <?php if ($nothingto_report > 0) { ?>
            swal({
                title: 'You have selected Nothing to Report. Please uncheck it to continue to form submission.',
                icon: "warning",
                type: "warning",
                closeOnConfirm: true
            });
        <?php } ?>
    });

    // This will encode your HTML input
    function removeTags(str) {
        if ((str===null) || (str===''))
            return false;
        else
            str = str.toString();
              
        // Regular expression to identify HTML tags in
        // the input string. Replacing the identified
        // HTML tag with a null string.
        str = str.replace( /(<([^>]+)>)/ig, '');
        return str.replace(/\&nbsp;/g, '');
    }

    $('body').on('click', '.nothingto_report', function() {
        $elem = $(this);

        if ($(this).prop("checked") == true) {
            swal({
                    title: "Are you sure?",
                    text: "You are not reporting for current year?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "<?php echo base_url(); ?>reporting/nothingto_report",
                            type: "POST",
                            dataType: "json",
                            data: {
                                form_id: <?php echo $this->uri->segment('3'); ?>,
                                year_val: <?php echo $this->uri->segment('4'); ?>,
                                country_val: <?php echo $this->uri->segment('5'); ?>,
                                crop_val: <?php echo $this->uri->segment('6'); ?>
                            },
                            error: function() {
                                $('.nothingto_report').prop("checked", false);
                                swal({
                                    title: 'Please check your internet connection and try again',
                                    icon: "warning",
                                    dangerMode: true,
                                    closeOnConfirm: true
                                });
                            },
                            success: function(response) {
                                if (response.status == 0) {
                                    $('.nothingto_report').prop("checked", false);

                                    swal({
                                        title: response.msg,
                                        icon: "warning",
                                        dangerMode: true,
                                        closeOnConfirm: true
                                    });
                                } else {
                                    $('.submit_data').addClass('hidden');
                                    $('.save_data').addClass('hidden');
                                    // swal({
                                    //     title: response.msg,
                                    //     icon: "success",
                                    //     closeOnConfirm: true
                                    // });
                                    swal.close();
                                }
                            }
                        });
                    } else {
                        $('.nothingto_report').prop("checked", false);
                        swal("Cancelled", "", "error");
                    }
                });
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>reporting/removenothingto_report",
                type: "POST",
                dataType: "json",
                data: {
                    form_id: <?php echo $this->uri->segment('3'); ?>,
                    year_val: <?php echo $this->uri->segment('4'); ?>,
                    country_val: <?php echo $this->uri->segment('5'); ?>,
                    crop_val: <?php echo $this->uri->segment('6'); ?>
                },
                error: function() {
                    $('.nothingto_report').prop("checked", true);
                    swal({
                        title: 'Please check your internet connection and try again',
                        icon: "warning",
                        dangerMode: true,
                        closeOnConfirm: true
                    });
                },
                success: function(response) {
                    if (response.status == 0) {
                        $('.nothingto_report').prop("checked", true);

                        swal({
                            title: response.msg,
                            icon: "warning",
                            dangerMode: true,
                            closeOnConfirm: true
                        });
                    } else {
                        $('.submit_data').removeClass('hidden');
                        $('.save_data').removeClass('hidden');
                        // swal({
                        //     title: response.msg,
                        //     icon: "success",
                        //     closeOnConfirm: true
                        // });
                        swal.close();
                    }
                }
            });
        }
    });

    $('body')
        .on('click', '.addmorefields', function() {
            $('.error').html('');
            $elem = $(this);
            $elem.closest('.addmoremaindiv').find('.removeaddmore').parent().html('');

            var addmore_count = $elem.closest('.addmoremaindiv').find('.addmore').length;
            var $template = $elem.closest('.addmoremaindiv').find('.addmore_div'),
                $clone = $template
                .clone()
                .removeClass('addmore_div')
                .addClass('dulicate_addmore_div')
            /*.attr('style', 'border-top:1px solid #8e8ec0; margin:0px;')*/
            ;


            $clone.find('input[type="text"]').val('');
            $clone.find('textarea').val('');
            $clone.find('select').val('');
            $clone.find('input[type="radio"]').prop("checked", false);
            $clone.find('input[type="checkbox"]').prop("checked", false);
            $clone.find('input[type="radio"]').prop("checked", false);

            $clone.find('.childfields').html('');


            $clone.find('input[type="text"]').each(function() {
                var name = $(this).attr("name");
                name = name.replace("[0]", "[" + addmore_count + "]");
                $(this).attr('name', name);
                $(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('textarea').each(function() {
                var name = $(this).attr("name");
                name = name.replace("[0]", "[" + addmore_count + "]");
                $(this).attr('name', name);
                $(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('input[type="radio"]').each(function() {
                var name = $(this).attr("name");
                name = name.replace("[0]", "[" + addmore_count + "]");
                $(this).attr('name', name);
                $(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('input[type="checkbox"]').each(function() {
                var name = $(this).attr("name");
                name = name.replace("[0]", "[" + addmore_count + "]");
                $(this).attr('name', name);
                $(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('select').each(function() {
                var name = $(this).attr("name");
                name = name.replace("[0]", "[" + addmore_count + "]");
                $(this).attr('name', name);
                $(this).attr('data-groupfieldcount', addmore_count);
            });

            $clone.find('.addmorefields').parent().html('<button type="button" class="btn btn-danger btn-sm removeaddmore pull-left" style="margin-top:30px;">\
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
                if (index == (addmore_count - 2) && index != 0) {
                    $(this).find('.add_remove_button').html('<button type="button" class="btn btn-danger btn-sm removeaddmore pull-left" style="margin-top:30px;">\
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

        var field_id = $(this).attr("data-field_id");
        var fieldtype = $(this).attr("data-fieldtype");

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

    $('body').on('change', '.default_indicatorcomment', function() {
        if (this.checked) {
            var HTML = '<div class="form-group">\
                <textarea class="form-control" name="indicator_comment" rows="8" data-required="required" data-maxlength="6000"></textarea>\
                <p class="error red-800"></p>\
                <p class="maxlengtherror red-800"></p>\
            </div>';
            $(this).closest('.row').find('.indicator_comment').html(HTML);
        } else {
            $(this).closest('.row').find('.indicator_comment').html('');
        }
    });

    $('body').on('click', '.submit_data', function() {
        $elem = $(this);
        $elem.prop('disabled', true);

        $('.error').html('');

        var form_id = "submit_data";
        var surveycount = 0;

        $elem.closest('.card').find('input[type=text]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if (requiredvalue == 'required') {
                if ($.trim($(this).val()).length === 0) {
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }

            if (subtypevalue == 'number' || subtypevalue == 'desimal') {
                switch (subtypevalue) {
                    case 'number':
                        if ($(this).val().length > 0) {
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
                        if ($(this).val().length > 0) {
                            if (!/^(\d*\.?\d*)$/.test($(this).val())) {
                                $(this).next('.error').html('Please! Enter only number');
                                surveycount++;
                            } else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                $(this).next('.error').html('Field can contain only proper decimal number.');
                                surveycount++;
                            }
                        }
                        break;
                }
            }

            if ($.trim($(this).val()).length > maxvalue) {
                $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto ' + maxvalue + ' character/number');
                surveycount++;
            }
        });

        // $elem.closest('.card').find('textarea', form_id).each(function() {
        //     var requiredvalue = $(this).data("required");
        //     var subtypevalue = $(this).data("subtype");
        //     var maxvalue = $(this).data("maxlength");

        //     if (requiredvalue == 'required') {
        //         if ($.trim($(this).val()).length === 0) {
        //             $(this).next('.error').html('This field is required');
        //             surveycount++;
        //         }
        //     }

        //     if ($.trim($(this).val()).length > maxvalue) {
        //         $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto ' + maxvalue + ' character/number');
        //         surveycount++;
        //     }
        // });

        $elem.closest('.card').find('#textarea_1', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var maxvalue = $(this).data("maxlength");
            var value = removeTags($(this).val());

            if (requiredvalue == 'required') {
                if ($.trim(value).length === 0) {
                    $(this).closest('.form-group').find('.error').html('This field is required');
                    surveycount++;
                }
            }

            if ($.trim(value).length > 6000) {
                $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto 6000 character/number');
                surveycount++;
            }
        });

        $elem.closest('.card').find('input[type=radio]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            if (requiredvalue == 'required') {
                var name = $(this).attr("name");
                if ($("input:radio[name='" + name + "']:checked").length == 0) {
                    $(this).closest('.form-group').find('.error').html('This field is required');
                    surveycount++;
                }
            }
        });

        $elem.closest('.card').find('input[type=checkbox]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if (requiredvalue == 'required') {
                var name = $(this).attr("name");
                if ($("input:checkbox[name='" + name + "']:checked").length == 0) {
                    $(this).closest('.form-group').find('.error').html('This field is required');
                    surveycount++;
                }
            }
        });

        $elem.closest('.card').find('select', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            if (requiredvalue == 'required') {
                var name = $(this).attr("name");
                if ($.trim($(this).val()).length == 0) {
                    $(this).next('.error').html('This field is required');
                    surveycount++;
                }
            }
        });

        if (surveycount == 0) {
            var indicatorform = new FormData($('#' + form_id)[0]);
            indicatorform.append('form_id', <?php echo $this->uri->segment('3'); ?>);
            indicatorform.append('year_val', <?php echo $this->uri->segment('4'); ?>);
            indicatorform.append('country_val', <?php echo $this->uri->segment('5'); ?>);
            indicatorform.append('crop_val', <?php echo $this->uri->segment('6'); ?>);
            indicatorform.append('submit_type', 'submit');
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/insert_indicatordata',
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
        } else {
            $elem.prop('disabled', false);
        }
    });

    $('body').on('click', '.save_data', function() {
        $elem = $(this);
        $elem.prop('disabled', true);

        $('.error').html('');
        var form_id = "submit_data";

        var surveycount = 0;

        $elem.closest('.card').find('input[type=text]', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var subtypevalue = $(this).data("subtype");
            var maxvalue = $(this).data("maxlength");

            if (subtypevalue == 'number' || subtypevalue == 'desimal') {
                switch (subtypevalue) {
                    case 'number':
                        if ($(this).val().length > 0) {
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
                        if ($(this).val().length > 0) {
                            if (!/^(\d*\.?\d*)$/.test($(this).val())) {
                                $(this).next('.error').html('Please! Enter only number');
                                surveycount++;
                            } else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                $(this).next('.error').html('Field can contain only proper decimal number.');
                                surveycount++;
                            }
                        }
                        break;
                }
            }

            if ($.trim($(this).val()).length > maxvalue) {
                $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto ' + maxvalue + ' character/number');
                surveycount++;
            }
        });

        // $elem.closest('.card').find('textarea', form_id).each(function() {
        //     var requiredvalue = $(this).data("required");
        //     var subtypevalue = $(this).data("subtype");
        //     var maxvalue = $(this).data("maxlength");

        //     if ($.trim($(this).val()).length > maxvalue) {
        //         $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto ' + maxvalue + ' character/number');
        //         surveycount++;
        //     }
        // });

        $elem.closest('.card').find('#textarea_1', form_id).each(function() {
            var requiredvalue = $(this).data("required");
            var maxvalue = $(this).data("maxlength");
            var value = removeTags($(this).val());

            if ($.trim(value).length > 6000) {
                $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto 6000 character/number');
                surveycount++;
            }
        });

        if (surveycount == 0) {
            var indicatorform = new FormData($('#' + form_id)[0]);
            indicatorform.append('form_id', <?php echo $this->uri->segment('3'); ?>);
            indicatorform.append('year_val', <?php echo $this->uri->segment('4'); ?>);
            indicatorform.append('country_val', <?php echo $this->uri->segment('5'); ?>);
            indicatorform.append('crop_val', <?php echo $this->uri->segment('6'); ?>);
            indicatorform.append('submit_type', 'save');
            $.ajax({
                url: '<?php echo base_url(); ?>reporting/insert_indicatordata',
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
        } else {
            $elem.prop('disabled', false);
        }
    });

    $('body').on('keyup', '.numberfield', function() {
        $(this).closest('.form-group').find('.error').html('');
        if ($(this).val().length > 0) {
            if (!/^(\+|-)?(\d*\.?\d*)$/.test(this.value)) { // a non–digit was entered
                $(this).closest('.form-group').find('.error').html('This field contains only numbers and perfect decimals.');
            } else {
                $(this).closest('.form-group').find('.error').empty();
            }
        }
    });

    $('body').on('keyup', '.decimal', function() {
        $(this).closest('.form-group').find('.error').html('');

        var maxvalue = $(this).attr("data-maxvalue");
        if ($(this).val().length > 0) {
            if (!/^(\d*\.?\d*)$/.test($(this).val())) {
                $(this).closest('.form-group').find('.error').html('Please! Enter only number');
            } else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                $(this).closest('.form-group').find('.error').html('Field can contain only proper decimal number.');
            }

            if (parseFloat($(this).val()) > parseFloat(maxvalue)) {
                $(this).closest('.form-group').find('.error').html('Enter value cannot be greater than ' + maxvalue + '');
                $(this).val('');
            }
        }
    });

    $('body').on('keyup', '.number', function() {
        $(this).closest('.form-group').find('.error').html('');

        var maxvalue = $(this).attr("data-maxvalue");
        if ($(this).val().length > 0) {
            if (/^\d+$/.test($(this).val())) {
                $(this).closest('.form-group').find('.error').empty();
            } else {
                $(this).closest('.form-group').find('.error').html('Please provide a valid number.');
            }

            if (parseInt($(this).val()) > parseInt(maxvalue)) {
                $(this).closest('.form-group').find('.error').html('Enter value cannot be greater than ' + maxvalue + '');
                $(this).val('');
            }
        }
    });

    $('body').on('keyup', '.latlong', function() {
        $(this).closest('.form-group').find('.error').html('');
        if ($(this).val().length > 0) {
            if (/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/.test($(this).val())) {
                $(this).closest('.form-group').find('.error').empty();
            } else {
                $(this).closest('.form-group').find('.error').html('Please provide a proper value.');
            }
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

    $('body').on('click', '.showQuery', function(event) {
        var elem = $(this);
        elem.closest('.card').find('.query_list').empty();
        
        if(!elem.hasClass('active')) {
            elem.addClass('active');
            elem.find('i').removeClass('fa-plus').addClass('fa-minus');
        } else {
            elem.removeClass('active');
            elem.find('i').removeClass('fa-minus').addClass('fa-plus');
            return false;
        }
        $('.showQuery').not(this).each(function(index) {
            if($(this).hasClass('active')) $(this).trigger('click');
        });

        var recorId = elem.data('value');
        elem.closest('.card').find('.query_list').html('<h4 class="text-center">Please Wait... Getting Data.</h4>');
        $.ajax({
            url: "<?php echo base_url(); ?>dashboard/get_query_list",
            type: "POST",
            dataType: "json",
            data : { data_id : recorId },
            error : function(){
                elem.closest('.card').find('.query_list').empty();
                $.toast({
                    stack: false,
                    icon: 'error',
                    position: 'bottom-right',
                    showHideTransition: 'slide',
                    heading: 'Network Error!',
                    text: 'Please check your internet connection.'
                });
            },
            success : function (response) {
                if(response.status === 0) {
                    elem.closest('.card').find('.query_list').empty();
                    $.toast({
                        stack: false,
                        icon: 'error',
                        position: 'bottom-right',
                        showHideTransition: 'slide',
                        heading: 'Error!',
                        text: response.msg
                    });
                    return false;
                }

                // <img alt="Avatar" class="avatar avatar-xl mx-2" src="<?php echo base_url(); ?>upload/user/default.png" style="background-color:none;">
                var HTML = `<div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="border" style="border-bottom:none !important;">`;
                        response.queries.forEach(function(query, index) {
                            if(query.sent_by == response.details.user_id) {
                            HTML += `<div class="media d-block d-sm-flex text-right">
                                <div class="media-body pt-3 pt-sm-0 m-3">
                                    <h5 class="mg-b-5 tx-inverse tx-15">
                                        <i class="fa fa-calendar"></i> Posted On : ${query.query_datetime}
                                        <span class="mx-1">|</span>
                                        <i class="fa fa-user"></i> By : ${query.first_name} ${query.last_name}
                                    </h5>
                                    <p>${query.query}</p>
                                    <hr class="my-4">
                                </div>
                            </div>`;
                            } else {
                            HTML += `<div class="media d-block d-sm-flex">
                                <div class="media-body pt-3 pt-sm-0 m-3">
                                    <h5 class="mg-b-5 tx-inverse tx-15">
                                        <i class="fa fa-user"></i> By : ${query.first_name} ${query.last_name}
                                        <span class="mx-1">|</span>
                                        <i class="fa fa-calendar"></i> Posted On : ${query.query_datetime}
                                    </h5>
                                    <p>${query.query}</p>
                                    <hr class="my-4">
                                </div>
                            </div>`;
                            }
                        });
                        HTML += `</div>
                    </div>

                    <form id="queryForm" class="col-sm-12" data-id="${recorId}" data-user="${response.details.user_id}">
                        <div class="form-group">
                            <textarea rows="5" style="resize:vertical;" class="form-control" name="query" placeholder="Respond to the query..."></textarea>
                            <span class="query error text-danger"></span>
                        </div>

                        <button class="btn btn-dark btn-sm float-right" type="submit">Respond</button>
                    </form>
                </div>`;
                elem.closest('.card').find('.query_list').html(HTML);
            }
        });
    });
    $('body').on('submit', '#queryForm', function(event) {
        event.preventDefault();
        var form = $(this),
        formData = new FormData(form[0]);
        formData.append('id', form.data('id'));

        form.find('button').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url(); ?>dashboard/respond_query',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function() {
                $.toast({
                    heading: 'Error!',
                    text: 'Please check your internet connection and try again.',
                    icon: 'error'
                });
                form.find('button').prop('disabled', false);
            },
            success: function(response){
                var response = JSON.parse(response);

                if(response.status == 0) {
                    if(response.errors && response.errors.length > 0) {
                        for(var key in response.errors) {
                            var errorContainer = form.find(`.${key}.error`);
                            if(errorContainer.length !== 0) {
                                errorContainer.html(response.errors[key]);
                            }
                        }
                    } else {
                        $.toast({
                            heading: 'Error!',
                            text: response.msg,
                            icon: 'error',
                            afterHidden: function () {
                                form.find('button').prop('disabled', false);
                            }
                        });
                    }
                    return false;
                }

                var HTML = ``;
                if(response.query.sent_by == form.data('user')) {
                    HTML = `<div class="media d-block d-sm-flex text-right">
                        <div class="media-body pt-3 pt-sm-0 m-3">
                            <h5 class="mg-b-5 tx-inverse tx-15">
                                <i class="fa fa-calendar"></i> Posted On : ${response.query.query_datetime}
                                <span class="mx-1">|</span>
                                <i class="fa fa-user"></i> By : ${response.query.first_name} ${response.query.last_name}
                            </h5>
                            <p>${response.query.query}</p>
                            <hr class="my-4">
                        </div>
                    </div>`;
                } else {
                    HTML = `<div class="media d-block d-sm-flex">
                        <div class="media-body pt-3 pt-sm-0 m-3">
                            <h5 class="mg-b-5 tx-inverse tx-15">
                                <i class="fa fa-user"></i> By : ${response.query.first_name} ${response.query.last_name}
                                <span class="mx-1">|</span>
                                <i class="fa fa-calendar"></i> Posted On : ${response.query.query_datetime}
                            </h5>
                            <p>${response.query.query}</p>
                            <hr class="my-4">
                        </div>
                    </div>`;
                }
                form.prev().find('.border').append(HTML);
                
                $.toast({
                    heading: 'Success!',
                    text: response.msg,
                    icon: 'success',
                    afterHidden: function () {
                        form.find('button').prop('disabled', false);
                    }
                });
            }
        });
    });

    //edit data for level 3 user
    <?php if ($this->session->userdata('role') == 5 || $this->session->userdata('role') == 4) { ?>
        $('body').on('click', '.getfields_tosubmit_savedata', function() {
            $elem = $(this);
            $elem.prop('disabled', true);
            $elem.closest('.row').find('.usersindicator_list').html('');

            var loading = '<div class="col-md-12 text-center">\
                <img class="loading" src="<?php echo base_url(); ?>include/app-assets/images/loading.gif" style="height: 70px;">\
                <p>Please wait...</p>\
            </div>';

            $elem.closest('.row').find('.usersindicator_list').html(loading);

            $('html,body').animate({
                scrollTop: $elem.closest('.row').find('.usersindicator_list').offset().top - 300
            }, 500);

            var recordid = $elem.data("recordid");
            var formtype = $elem.data("formtype");

            $.ajax({
                url: '<?php echo base_url(); ?>dashboard/edit_andapprovedata',
                type: 'POST',
                dataType: 'json',
                data: {
                    recordid: recordid,
                    form_id: $elem.data("formid")
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
                success: function(response) {
                    if (response.status == 0) {
                        $.toast({
                            heading: 'Warning!',
                            text: response.msg,
                            icon: 'warning',
                            afterHidden: function() {
                                $elem.prop('disabled', false);
                            }
                        });
                    } else {
                        var form_fields = '<form id="submit_data_' + $elem.data("formid") + '">';
                        form_fields += '<div class="row">';
                        var i = 1;
                        if (response.get_tabledata != null) {
                            var json_formdata = jQuery.parseJSON(response.get_tabledata.form_data);
                        } else {
                            var json_formdata = [];
                        }
                        response.indicator_fields.forEach(function(indicatorfield, ifindex) {
                            if (indicatorfield.parent_id == null) {
                                switch (indicatorfield.type) {
                                    case 'group':
                                        response.get_grouptabledata.forEach(function(groupdata, groupdata_index) {
                                            var jsondata = jQuery.parseJSON(groupdata.formgroup_data);
                                            if (groupdata.groupfield_id == indicatorfield.field_id) {
                                                form_fields += '<div class="col-md-12">\
                                                            <input type="text" class="form-control hidden" name="id[' + groupdata_index + ']" value="' + groupdata.group_id + '">\
                                                        </div>';
                                                form_fields += '<div class="col-md-12 addmoremaindiv">\
                                                            <div class="row addmore addmore_div">';
                                                var indicator_groupfieldscount = indicatorfield.groupfields.length;
                                                var i_divmainclass = (indicator_groupfieldscount == 1 ? 6 : 11);
                                                form_fields += '<div class="col-md-' + i_divmainclass + '">\
                                                                    <div class="row">';
                                                indicatorfield.groupfields.forEach(function(indicatorgroupfield, ig_index) {
                                                    if (indicator_groupfieldscount == 1) {
                                                        var i_divclass = 12
                                                    } else if (indicator_groupfieldscount == 2) {
                                                        var i_divclass = 6;
                                                    } else if (indicator_groupfieldscount == 3) {
                                                        var i_divclass = 4;
                                                    } else {
                                                        var i_divclass = 3;
                                                    }
                                                    var group_fieldname = "field_" + indicatorgroupfield.field_id + "";
                                                    switch (indicatorgroupfield.type) {
                                                        case 'text':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + '" data-required="' + (indicatorgroupfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" data-subtype="' + indicatorgroupfield.subtype + '" >\
                                                                                            <p class="error red-800"></p>\
                                                                                            <p class="maxlengtherror red-800"></p>\
                                                                                        </div>\
                                                                                    </div>';
                                                            break;

                                                        case 'textarea':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            form_fields += '<textarea name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" rows="8" class="' + indicatorgroupfield.className + '" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required="' + (indicatorgroupfield.required == 1 ? "required" : "") + '">' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '</textarea>\
                                                                                            <p class="error red-800"></p>\
                                                                                            <p class="maxlengtherror red-800"></p>\
                                                                                        </div>\
                                                                                    </div>';
                                                            break;

                                                        case 'select':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            if (indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE') {
                                                                var selectname = "field_" + indicatorgroupfield.field_id + "[" + groupdata_index + "][]";
                                                                var selectmultiple = "multiple";
                                                            } else {
                                                                var selectname = "field_" + indicatorgroupfield.field_id + "[" + groupdata_index + "]";
                                                                var selectmultiple = "";
                                                            }
                                                            form_fields += '<select name="' + selectname + '" ' + selectmultiple + ' class="form-control selectbox" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" data-field_id = "' + indicatorgroupfield.field_id + '"  data-fieldtype="groupfield" data-groupfieldcount = "' + groupdata_index + '">';
                                                            if (indicatorgroupfield.multiple == 'true' || indicatorgroupfield.multiple == 'TRUE') {} else {
                                                                form_fields += '<option value="">Select an option</option>';
                                                            }
                                                            indicatorgroupfield.options.forEach(function(option, index) {
                                                                if (option.value == jsondata[group_fieldname]) {
                                                                    var select_value = "selected";
                                                                } else {
                                                                    var select_value = '';
                                                                }
                                                                form_fields += '<option value="' + option.value + '" ' + select_value + '>' + option.label + '</option>';
                                                            });
                                                            form_fields += '</select>\
                                                                                            <p class="error red-800"></p>\
                                                                                        </div>\
                                                                                        <div class="row childfields childof' + indicatorgroupfield.field_id + '"></div>\
                                                                                    </div>';
                                                            break;

                                                        case 'radio-group':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            form_fields += '<div class="form-check">\
                                                                                                <div class="row">';
                                                            indicatorgroupfield.options.forEach(function(option, index) {
                                                                var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                                if (option.value == jsondata[group_fieldname]) {
                                                                    var radio_value = "checked";
                                                                } else {
                                                                    var radio_value = '';
                                                                }
                                                                form_fields += '<div class="col-md-4">\
                                                                                                            <label><input type="radio" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" value = "' + option.value + '" style="margin-right: 5px;" data-field_id = "' + indicatorgroupfield.field_id + '" data-field_value = "' + option.value + '" data-required="' + requiredval + '" ' + radio_value + ' >' + option.label + '</label>\
                                                                                                        </div>';
                                                            });
                                                            form_fields += '</div>\
                                                                                            </div>\
                                                                                            <p class="error red-800"></p>\
                                                                                        </div>\
                                                                                        <div class="row childfields childof' + indicatorgroupfield.field_id + '"></div>\
                                                                                    </div>';
                                                            break;

                                                        case 'checkbox-group':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                <div class="form-group">';
                                                                    form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                                    if (indicatorgroupfield.description != null) {
                                                                        form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                                    }
                                                                    form_fields += '<div class="form-check">\
                                                                        <div class="row">';
                                                                            indicatorgroupfield.options.forEach(function(option, index) {
                                                                                var requiredval = (indicatorgroupfield.required == 1) ? "required" : "";
                                                                                var checkbox_array = jsondata[group_fieldname].split("&#44;");
                                                                                /*if (option.value == jsondata[group_fieldname]) {*/
                                                                                if(jQuery.inArray(option.value, checkbox_array) !== -1){
                                                                                    var radio_value = "checked";
                                                                                } else {
                                                                                    var radio_value = '';
                                                                                }
                                                                                form_fields += '<div class="col-md-4">\
                                                                                    <label><input type="checkbox" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + '][]" value = "' + option.value + '" style="margin-right: 5px;" data-field_id = "' + indicatorgroupfield.field_id + '" data-field_value = "' + option.value + '" data-required="' + requiredval + '" ' + radio_value + ' >' + option.label + '</label>\
                                                                                </div>';
                                                                            });
                                                                        form_fields += '</div>\
                                                                    </div>\
                                                                    <p class="error red-800"></p>\
                                                                </div>\
                                                                <div class="row childfields childof' + indicatorgroupfield.field_id + '"></div>\
                                                            </div>';
                                                            break;

                                                        case 'number':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            switch (indicatorgroupfield.subtype) {
                                                                case 'desimal':
                                                                    form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' decimal" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-maxvalue = "' + indicatorgroupfield.max_val + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" >';
                                                                    break;

                                                                case 'number':
                                                                    form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' number" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-maxvalue = "' + indicatorgroupfield.max_val + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" >';
                                                                    break;

                                                                case 'latitude':
                                                                    form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' latlong" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" >';
                                                                    break;

                                                                case 'longitude':
                                                                    form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' latlong" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" >';
                                                                    break;

                                                                default:
                                                                    form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' numberfield" data-subtype="' + indicatorgroupfield.subtype + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" data-required = "' + (indicatorgroupfield.required == 1 ? "required" : "") + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" >';
                                                                    break;
                                                            }
                                                            form_fields += '<p class="error red-800"></p>\
                                                                                            <p class="maxlengtherror red-800"></p>\
                                                                                        </div>\
                                                                                    </div>';
                                                            break;

                                                        case 'date':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' picker" data-required="' + (indicatorgroupfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" data-subtype="' + indicatorgroupfield.subtype + '" onkeydown="return false" autocomplete="off">\
                                                                                            <p class="error red-800"></p>\
                                                                                            <p class="maxlengtherror red-800"></p>\
                                                                                        </div>\
                                                                                    </div>';
                                                            break;

                                                        case 'month':
                                                            form_fields += '<div class="col-md-' + i_divclass + '">\
                                                                                        <div class="form-group">';
                                                            form_fields += '<label>' + (ig_index + 1) + '. ' + indicatorgroupfield.label + '' + (indicatorgroupfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                                            if (indicatorgroupfield.description != null) {
                                                                form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorgroupfield.description + '</p>';
                                                            }
                                                            form_fields += '<input type="text" name="field_' + indicatorgroupfield.field_id + '[' + groupdata_index + ']" class="' + indicatorgroupfield.className + ' monthpicker" data-required="' + (indicatorgroupfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorgroupfield.maxlength + '" value="' + (jsondata[group_fieldname] != null ? jsondata[group_fieldname] : "") + '" data-subtype="' + indicatorgroupfield.subtype + '" onkeydown="return false" autocomplete="off">\
                                                                                            <p class="error red-800"></p>\
                                                                                            <p class="maxlengtherror red-800"></p>\
                                                                                        </div>\
                                                                                    </div>';
                                                            break;

                                                    }
                                                });
                                                form_fields += '</div>\
                                                                </div>';
                                                form_fields += '<div class="col-md-12">\
                                                                    <hr style="margin-top: 0px; height: 1px; background-color: #8e8ec0;">\
                                                                </div>\
                                                            </div>\
                                                        </div>';
                                            }
                                        });
                                        break;

                                        //display of text box field
                                    case 'text':
                                        form_fields += '<div class="col-md-4">\
                                                    <div class="form-group">';
                                        var textquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = textquestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        form_fields += '<label>' + label + '' + (indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        var text_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + '" data-required="' + (indicatorfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorfield.maxlength + '" data-subtype="' + indicatorfield.subtype + '" value="' + (json_formdata[text_fieldname] != null ? json_formdata[text_fieldname] : "") + '">\
                                                        <p class="error red-800"></p>\
                                                        <p class="maxlengtherror red-800"></p>\
                                                    </div>\
                                                </div>';
                                        break;

                                    case 'date':
                                        form_fields += '<div class="col-md-4">\
                                                    <div class="form-group">';
                                        var datequestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = datequestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        form_fields += '<label>' + label + '' + (indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        var date_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' picker" data-required="' + (indicatorfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorfield.maxlength + '" value="' + (json_formdata[date_fieldname] != null ? json_formdata[date_fieldname] : "") + '" data-subtype="' + indicatorfield.subtype + '" onkeydown="return false" autocomplete="off">\
                                                        <p class="error red-800"></p>\
                                                        <p class="maxlengtherror red-800"></p>\
                                                    </div>\
                                                </div>';
                                        break;

                                    case 'month':
                                        form_fields += '<div class="col-md-4    ">\
                                                    <div class="form-group">';
                                        var datequestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = datequestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        form_fields += '<label>' + label + '' + (indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        var month_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' monthpicker" data-required="' + (indicatorfield.required == 1 ? "required" : "") + '" data-maxlength = "' + indicatorfield.maxlength + '" value="' + (json_formdata[month_fieldname] != null ? json_formdata[month_fieldname] : "") + '" data-subtype="' + indicatorfield.subtype + '" onkeydown="return false" autocomplete="off">\
                                                        <p class="error red-800"></p>\
                                                        <p class="maxlengtherror red-800"></p>\
                                                    </div>\
                                                </div>';
                                        break;

                                        //display number field
                                    case 'number':
                                        form_fields += '<div class="col-md-4">\
                                                    <div class="form-group">';
                                        var numberquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = numberquestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        form_fields += '<label>' + label + '' + (indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        var number_fieldname = "field_" + indicatorfield.field_id + "";
                                        switch (indicatorfield.subtype) {
                                            case 'desimal':
                                                form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' decimal" data-subtype="' + indicatorfield.subtype + '" data-maxlength = "' + indicatorfield.maxlength + '" data-maxvalue = "' + indicatorfield.max_val + '"  data-required = "' + (indicatorfield.required == 1 ? "required" : "") + '" value="' + (json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "") + '" >';
                                                break;

                                            case 'number':
                                                form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' number" data-subtype="' + indicatorfield.subtype + '" data-maxlength = "' + indicatorfield.maxlength + '" data-maxvalue = "' + indicatorfield.max_val + '" data-required = "' + (indicatorfield.required == 1 ? "required" : "") + '" value="' + (json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "") + '" >';
                                                break;

                                            case 'latitude':
                                                form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' latlong" data-subtype="' + indicatorfield.subtype + '" data-maxlength = "' + indicatorfield.maxlength + '" data-required = "' + (indicatorfield.required == 1 ? "required" : "") + '" value="' + (json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "") + '" >';
                                                break;

                                            case 'longitude':
                                                form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' latlong" data-subtype="' + indicatorfield.subtype + '" data-maxlength = "' + indicatorfield.maxlength + '" data-required = "' + (indicatorfield.required == 1 ? "required" : "") + '" value="' + (json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "") + '" >';
                                                break;

                                            default:
                                                form_fields += '<input type="text" name="field_' + indicatorfield.field_id + '" class="' + indicatorfield.className + ' numberfield" data-subtype="' + indicatorfield.subtype + '" data-maxlength = "' + indicatorfield.maxlength + '" data-required = "' + (indicatorfield.required == 1 ? "required" : "") + '" value="' + (json_formdata[number_fieldname] != null ? json_formdata[number_fieldname] : "") + '" >';
                                                break;
                                        }
                                        form_fields += '<p class="error red-800"></p>\
                                                        <p class="maxlengtherror red-800"></p>\
                                                    </div>\
                                                </div>';
                                        break;

                                        //display radio button
                                    case 'radio-group':
                                        var radio_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<div class="col-md-12">\
                                                    <div class="form-group">';
                                        var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = radioquestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        if (indicatorfield.required == 1) {
                                            var hastrick = "<font color='red'>*</font>";
                                        } else {
                                            var hastrick = "";
                                        }
                                        form_fields += '<label>' + label + '' + hastrick + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        form_fields += '<div class="form-check">\
                                                            <div class="row">';
                                        indicatorfield.options.forEach(function(option, index) {
                                            var requiredval = (indicatorfield.required == 1) ? "required" : "";
                                            if ((option.value == json_formdata[radio_fieldname]) && (json_formdata[radio_fieldname] != null)) {
                                                var radio_value = "checked";
                                            } else {
                                                var radio_value = '';
                                            }
                                            form_fields += '<div class="col-md-4">\
                                                                        <label><input type="radio" name="field_' + indicatorfield.field_id + '" value = "' + option.value + '" style="margin-right: 5px;" data-field_id = "' + indicatorfield.field_id + '" data-field_value = "' + option.value + '" data-required="' + requiredval + '" ' + radio_value + ' >' + option.label + '</label>\
                                                                    </div>';
                                        });
                                        form_fields += '</div>\
                                                        </div>\
                                                        <p class="error red-800"></p>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-12">\
                                                    <div class="row childfields childof' + indicatorfield.field_id + '">\
                                                    </div>\
                                                </div>';
                                        break;

                                        //display radio button
                                    case 'checkbox-group':
                                        var radio_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<div class="col-md-12">\
                                                    <div class="form-group">';
                                        var radioquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = radioquestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        if (indicatorfield.required == 1) {
                                            var hastrick = "<font color='red'>*</font>";
                                        } else {
                                            var hastrick = "";
                                        }
                                        form_fields += '<label>' + label + '' + hastrick + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        form_fields += '<div class="form-check">\
                                                            <div class="row">';
                                        indicatorfield.options.forEach(function(option, index) {
                                            var requiredval = (indicatorfield.required == 1) ? "required" : "";
                                            if (json_formdata[radio_fieldname] != null) {
                                                var checkbox_val = json_formdata[radio_fieldname].split("&#44;");

                                                if (jQuery.inArray(option.value, checkbox_val) !== -1) {
                                                    var radio_value = 'checked';
                                                } else {
                                                    var radio_value = '';
                                                }
                                            } else {
                                                var radio_value = '';
                                            }
                                            form_fields += '<div class="col-md-4">\
                                                                        <label><input type="checkbox" name="field_' + indicatorfield.field_id + '[]" value = "' + option.value + '" style="margin-right: 5px;" data-field_id = "' + indicatorfield.field_id + '" data-field_value = "' + option.value + '" data-required="' + requiredval + '" ' + radio_value + ' >' + option.label + '</label>\
                                                                    </div>';
                                        });
                                        form_fields += '</div>\
                                                        </div>\
                                                        <p class="error red-800"></p>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-12">\
                                                    <div class="row childfields childof' + indicatorfield.field_id + '">\
                                                    </div>\
                                                </div>';
                                        break;

                                        //display of textarea
                                    case 'textarea':
                                        var textarea_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<div class="col-md-4">\
                                                    <div class="form-group">';
                                        var textareaquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = textareaquestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        form_fields += '<label>' + label + '' + (indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        form_fields += '<textarea name="field_' + indicatorfield.field_id + '" rows="8" class="' + indicatorfield.className + '" data-subtype="' + indicatorfield.subtype + '" data-maxlength = "' + indicatorfield.maxlength + '" data-required="' + (indicatorfield.required == 1 ? "required" : "") + '">' + (json_formdata[textarea_fieldname] != null ? json_formdata[textarea_fieldname] : "") + '</textarea>\
                                                        <p class="error red-800"></p>\
                                                        <p class="maxlengtherror red-800"></p>\
                                                    </div>\
                                                </div>';
                                        break;

                                        //display of select box
                                    case 'select':
                                        var select_fieldname = "field_" + indicatorfield.field_id + "";
                                        form_fields += '<div class="col-md-4">\
                                                    <div class="form-group">';
                                        var selectquestion = (indicatorfield.field_count == 1) ? i++ : i;
                                        if (indicatorfield.field_count == 1) {
                                            var label = selectquestion + '. ' + indicatorfield.label;
                                        } else {
                                            var label = indicatorfield.label;
                                        }
                                        form_fields += '<label>' + label + '' + (indicatorfield.required == 1 ? "<font color='red'>*</font>" : "") + '</label>';
                                        if (indicatorfield.description != null) {
                                            form_fields += '<p style="font-size: 10px; font-style: italic; color: gray;">Note: ' + indicatorfield.description + '</p>';
                                        }
                                        if (indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE') {
                                            var selectname = "field_" + indicatorfield.field_id + "[]";
                                            var selectmultiple = "multiple";
                                        } else {
                                            var selectname = "field_" + indicatorfield.field_id + "";
                                            var selectmultiple = "";
                                        }
                                        form_fields += '<select name="' + selectname + '" ' + selectmultiple + ' class="form-control selectbox" data-required = "' + (indicatorfield.required == 1 ? "required" : "") + '" data-field_id = "' + indicatorfield.field_id + '" data-fieldtype="normalfield">';
                                        if (indicatorfield.multiple == 'true' || indicatorfield.multiple == 'TRUE') {} else {
                                            form_fields += '<option value="">Select an option</option>';
                                        }
                                        indicatorfield.options.forEach(function(option, index) {
                                            if (json_formdata[select_fieldname] != null) {
                                                var selectbox_val = json_formdata[select_fieldname].split("&#44;");

                                                if (jQuery.inArray(option.value, selectbox_val) !== -1) {
                                                    var select_value = 'selected';
                                                } else {
                                                    var select_value = '';
                                                }
                                            } else {
                                                var select_value = '';
                                            }
                                            form_fields += '<option value="' + option.value + '" ' + select_value + '>' + option.label + '</option>';
                                        });
                                        form_fields += '</select>\
                                                        <p class="error red-800"></p>\
                                                    </div>\
                                                </div>\
                                                <div class="col-md-12">\
                                                    <div class="row childfields childof' + indicatorfield.field_id + '"></div>\
                                                </div>';
                                        break;

                                    case 'header':
                                        form_fields += '<div class="col-md-12">';
                                        if (indicatorfield.description != null) {
                                            form_fields += indicatorfield.description;
                                        }
                                        form_fields += '<' + indicatorfield.subtype + ' class="title" style="margin-top: 0px; margin-bottom: 20px;">' + indicatorfield.label + '</' + indicatorfield.subtype + '>';
                                        form_fields += '</div>';
                                        break;

                                }
                            }
                        });

                        form_fields += '<div class="col-md-12">\
                                    <button type="button" class="btn btn-sm btn-success pull-right submitindicator_data" style="margin-top: 50px;" data-formtype = "' + formtype + '" data-recordid = "' + recordid + '" data-formid = "' + $elem.data("formid") + '">Submit data</button>\
                                    <button type="button" class="btn btn-sm btn-default pull-right cancel" style="margin-top: 50px; margin-right:10px;">Cancel</button>\
                                </div>';
                        form_fields += '</div>\
                        </form>';

                        $elem.closest('.row').find('.usersindicator_list').html(form_fields);

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

                    $elem.prop('disabled', false);
                }
            });
        });

        $('body').on('click', '.cancel', function() {
            $elem = $(this);

            $elem.closest('.usersindicator_list').html('');
        });

        $('body').on('click', '.submitindicator_data', function() {
            $elem = $(this);
            $elem.prop('disabled', true);

            $('.error').html('');

            var recordid = $elem.data("recordid");
            var formtype = $elem.data("formtype");
            var form_id = $elem.closest("form").attr('id');

            var surveycount = 0;

            $elem.closest('.card').find('input[type=text]', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if (requiredvalue == 'required') {
                    if ($.trim($(this).val()).length === 0) {
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }

                if (subtypevalue == 'number' || subtypevalue == 'desimal') {
                    switch (subtypevalue) {
                        case 'number':
                            if ($(this).val().length > 0) {
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
                            if ($(this).val().length > 0) {
                                if (!/^(\d*\.?\d*)$/.test($(this).val())) {
                                    $(this).next('.error').html('Please! Enter only number');
                                    surveycount++;
                                } else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                    $(this).next('.error').html('Field can contain only proper decimal number.');
                                    surveycount++;
                                }
                            }
                            break;
                    }
                }

                if ($.trim($(this).val()).length > maxvalue) {
                    $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto ' + maxvalue + ' character/number');
                    surveycount++;
                }
            });

            $elem.closest('.card').find('textarea', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if (requiredvalue == 'required') {
                    if ($.trim($(this).val()).length === 0) {
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }

                if ($.trim($(this).val()).length > maxvalue) {
                    $(this).closest('.form-group').find('.maxlengtherror').html('Please! Enter upto ' + maxvalue + ' character/number');
                    surveycount++;
                }
            });

            $elem.closest('.card').find('input[type=radio]', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                if (requiredvalue == 'required') {
                    var name = $(this).attr("name");
                    if ($("input:radio[name='" + name + "']:checked").length == 0) {
                        $(this).closest('.form-group').find('.error').html('This field is required');
                        surveycount++;
                    }
                }
            });

            $elem.closest('.card').find('input[type=checkbox]', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                var maxvalue = $(this).data("maxlength");

                if (requiredvalue == 'required') {
                    var name = $(this).attr("name");
                    if ($("input:checkbox[name='" + name + "']:checked").length == 0) {
                        $(this).closest('.form-group').find('.error').html('This field is required');
                        surveycount++;
                    }
                }
            });

            $elem.closest('.card').find('select', form_id).each(function() {
                var requiredvalue = $(this).data("required");
                var subtypevalue = $(this).data("subtype");
                if (requiredvalue == 'required') {
                    var name = $(this).attr("name");
                    if ($.trim($(this).val()).length == 0) {
                        $(this).next('.error').html('This field is required');
                        surveycount++;
                    }
                }
            });

            if (surveycount == 0) {
                var indicatorform = new FormData($('#' + form_id)[0]);
                indicatorform.append('recordid', recordid);
                indicatorform.append('formtype', formtype);
                indicatorform.append('form_id', $elem.data("formid"));
                $.ajax({
                    url: '<?php echo base_url(); ?>dashboard/edit_formdata',
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
                    success: function(response) {
                        if (response.status == 0) {
                            $.toast({
                                heading: 'Warning!',
                                text: response.msg,
                                icon: 'warning',
                                afterHidden: function() {
                                    $elem.prop('disabled', false);
                                }
                            });
                        } else {
                            $elem.closest('.row').html('');

                            $.toast({
                                heading: 'Success!',
                                text: response.msg,
                                icon: 'success',
                                afterHidden: function() {
                                    location.reload(true);
                                }
                            });
                        }
                    }
                });
            } else {
                $elem.prop('disabled', false);
            }
        });

        //send back option
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
        }).on('submit', '#sendBackForm', function(event) {
            event.preventDefault();
            var form = $(this),
                formData = new FormData(form[0]);
            formData.append('id', form.data('id'));

            form.find('button').prop('disabled', true);
            form.find('button[type="submit"]').html('Please wait...');
            $.ajax({
                url: '<?php echo base_url(); ?>dashboard/send_back',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                error: function() {
                    form.find('button').prop('disabled', false);
                    form.find('button[type="submit"]').html('Send Back');
                    $.toast({
                        heading: 'Network Error!',
                        text: 'Could not establish connection to server. Please refresh the page and try again.',
                        icon: 'error'
                    });
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    if (data.status == 0) {
                        if (data.errors && data.errors.length > 0) {
                            for (var key in data.errors) {
                                var errorContainer = form.find(`.${key}.error`);
                                if (errorContainer.length !== 0) {
                                    errorContainer.html(data.errors[key]);
                                }
                            }
                        } else {
                            $.toast({
                                heading: 'Error!',
                                text: data.msg,
                                icon: 'error',
                                afterHidden: function() {
                                    form.find('button').prop('disabled', false);
                                    form.find('button[type="submit"]').html('Send Back');
                                }
                            });
                        }
                        return false;
                    }

                    $.toast({
                        heading: 'Success!',
                        text: data.msg,
                        icon: 'success',
                        afterHidden: function() {
                            $('#sendBackModal').modal('hide');
                            form.find('button').prop('disabled', false);
                            form.find('button[type="submit"]').html('Send Back');
                        }
                    });
                }
            });
        });
    <?php } ?>
</script>