<style type="text/css">
    label {
        font-weight: bold;
    }

    th {
        color: #FFFFFF;
    }

    label {
        font-weight: bold;
        min-height: 42px;
    }
</style>

<!-- Update ngo Modal -->
<div class="modal fade" id="updateSurveyData" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update data</h4>
            </div>

            <div class="modal-body">
                
            </div>

            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="app-content page-body">
	<div class="container-fluid mb-9">
		<div class="row">
			<div class="col-md-12">
                <a href="javascript:close_window();" class="btn btn-sm btn-warning pull-right">Back</a>
				<h3 class="float-left"><?php echo $form_details['title']; ?></h3>
			</div>

            <div class="col-sm-1">
                <h5 class="mb-5 mt-2 text-dark lh-25px">Year: <?php echo $year_name; ?></h5>
            </div>
            <div class="col-sm-2">
                <h5 class="mb-5 mt-2 text-dark lh-25px">Country: <?php echo $country_name; ?></h5>
            </div>
            <div class="col-sm-2">
                <h5 class="mb-5 mt-2 text-dark lh-25px">Crop: <?php echo $crop_name; ?></h5>
            </div>

            <div class="col-sm-2">
                <h5 class="mb-5 mt-2 text-dark lh-25px">Target (2020): <?php echo $target_2020; ?></h5>
            </div>

            <div class="col-sm-2">
                <h5 class="mb-5 mt-2 text-dark lh-25px">Actual (2020): <?php echo $actual_2020; ?></h5>
            </div>            
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<form id="submit_data">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-3">
											<label>Target <span class="text-danger">*</span></label>
											<input type="text" class="form-control desimal ytwo"  name="target" data-subtype="desimal" value="<?php echo ($get_indicator_data != NULL) ? $get_indicator_data['target_val'] : ''; ?>" data-required="required">
                                            <p class="red-800 error"></p>
										</div>
                                        <div class="col-md-3">
                                            <label>Name of the person responsible for reporting indicator <span class="text-danger">*</span></label>
                                            <input type="text" name="personname" class="form-control" data-subtype="text" value="<?php echo ($get_indicator_data != NULL) ? $get_indicator_data['name'] : ''; ?>" data-required="required">
                                            <p class="red-800 error"></p>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Designation of the person responsible for reporting indicator </label>
                                            <input type="text" name="persondesignation" class="form-control" data-subtype="text" value="<?php echo ($get_indicator_data != NULL) ? $get_indicator_data['designation'] : ''; ?>">
                                            <p class="red-800 error"></p>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Email ID of the person responsible for reporting indicator </label>
                                            <input type="text" name="personemailid" class="form-control email" data-subtype="email" value="<?php echo ($get_indicator_data != NULL) ? $get_indicator_data['email_id'] : ''; ?>">
                                            <p class="red-800 error"></p>
                                        </div>
									
										<div class="col-md-12"><label>Remarks </label>
											<textarea name="remarks" class="form-control" rows="6" style="resize:none;"><?php echo ($get_indicator_data != NULL) ? $get_indicator_data['remarks'] : ''; ?></textarea>
											<p class="red-800 error"></p>
										</div>
									</div>
								</div>

                                <div class="col-md-12">
                                    <label style="color:#c51205 !important"><input type="checkbox" class="nothingto_report" <?php echo ($nothingto_report == 0) ? '' : 'checked' ?>> Nothing planned for this year</label>
                                </div>

								<div class="col-md-12">
									<button type="button" class="btn btn-sm btn-success pull-right submit_data <?php echo ($nothingto_report == 0) ? '' : 'hidden'; ?>"><?php echo ($get_indicator_data != NULL) ? 'Update data' : 'Submit data'; ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div><!-- end app-content-->
</div>

<script type="text/javascript">
    $(function() {
        <?php if ($nothingto_report > 0) { ?>
            swal({
                title: 'You have selected Nothing planned for this year. Please uncheck it to continue to form submission.',
                icon: "warning",
                type: "warning",
                closeOnConfirm: true
            });
        <?php } ?>
    });

    $('body').on('click', '.nothingto_report', function() {
        $elem = $(this);

        if ($(this).prop("checked") == true) {
            swal({
                title: "Are you sure?",
                //text: "You are not reporting for current year?",
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
                        url: "<?php echo base_url(); ?>planning_budget/nothingto_report_target",
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
                url: "<?php echo base_url(); ?>planning_budget/removenothingto_report_target",
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
                        swal.close();
                    }
                }
            });
        }
    });

    function close_window() {
        close();
    }
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
                                $(this).next('.error').html('Please Enter only number');
                                surveycount++;
                            } else if (!/^\s*(?=.*[0-9])\d*(?:\.\d{1,2})?\s*$/.test($(this).val())) {
                                $(this).next('.error').html('Field can contain only proper decimal number.');
                                surveycount++;
                            }
                        }
                        break;

                    case 'percentage':
                        if ($(this).val().length > 0) {
                            if (!/^(\d*\.?\d*)$/.test($(this).val())) {
                                $(this).next('.error').html('Please Enter only number');
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
                $(this).closest('.form-group').find('.maxlengtherror').html('Please Enter upto ' + maxvalue + ' character/number');
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
                $(this).closest('.form-group').find('.maxlengtherror').html('Please Enter upto ' + maxvalue + ' character/number');
                surveycount++;
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
                url: '<?php echo base_url(); ?>planning_budget/submit_targetdata',
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
</script>