<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Reset Password :: AVISA</title>
    <link rel="apple-touch-icon" href="<?php echo base_url('uploads/fav.png'); ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('include/include/app-assets/css/vendors.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/includeout/jquery-toast-plugin/src/jquery.toast.css"/>
    <!-- END VENDOR CSS-->
    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('include/include/app-assets/css/app.css'); ?>">
    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('include/include/app-assets/css/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('include/include/app-assets/css/core/colors/palette-gradient.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('include/include/app-assets/vendors/css/cryptocoins/cryptocoins.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url();?>include/include/vendors/datepicker/css/datepicker.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('include/assets/css/style.css'); ?>">
    <!-- END Custom CSS-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url('include/include/app-assets/vendors/js/vendors.min.js'); ?>"></script>
    <script src="<?php echo base_url(); ?>include/includeout/jquery-toast-plugin/src/jquery.toast.js"></script>
    <!-- BEGIN VENDOR JS-->
  </head>
  <body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow" style="border-bottom: 2px solid #050C43; background: #FFF !important;">
      <div class="navbar-wrapper">
        <div class="navbar-header" style="width: auto;">
          <ul class="nav navbar-nav flex-row" style="height: 100%;">
            <li class="nav-item mobile-menu d-md-none mr-auto">
              <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a>
            </li>
            <li class="nav-item" style="height: 100%;">
              <a class="navbar-brand" href="<?php echo base_url(); ?>" style="height: 100%; padding:0;">
                <img class="brand-logo" src="<?php echo base_url(); ?>include/assets/images/mpro-images/logo.png" style="height: 65px; width: auto;">
              </a>
            </li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content"></div>
      </div>
    </nav>

    <!-- Page -->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-body">
          <section class="flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
              <div class="col-md-4 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 m-0">                   
                  <div class="card-content">
                    <div class="card-body">
                      <h2 class="text-center" style="font-weight:bold;">Reset Your Password</h2>
                      <p class="text-center">Please enter new password and confirm password.</p>
                      
                      <?php echo form_open('', array('class' => 'form-horizontal form-simple', 'id' => 'resetPassword')); ?>
                        <div class="col-md-12">
                          <input type="password" name="password" id="password" class="form-control" placeholder="New password">
                          <span class="error password text-danger"></span>
                          <?php echo form_error('password'); ?>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px;">
                          <input type="password" class="form-control" placeholder="Confirm password" id="cpassword" name="cpassword">
                          <span class="error cpassword text-danger"></span>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px;">
                          <button type="submit" class="btn btn-primary btn-block">Set New Password</button>
                        </div>
                      <?php echo form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <!-- End Page -->

    <!-- Page Script -->
    <script type="text/javascript">
      // Handle resetPassword form submit
      $('#resetPassword').on('submit', function(event) {
        event.preventDefault();
        var form = $(this);
        $('.error').empty();
        $('button').prop('disabled', true);
        $('button[type="submit"]').html('Please wait...');
        $('.card-body').find('.alert').remove();

        var formData = new FormData($(this)[0]);
        formData.append('forgot_pass', '<?php echo $this->uri->segment(3); ?>')
        $.ajax({
          url: '<?php echo base_url(); ?>password/changepass',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          complete: function(data) {
            var csrfData = JSON.parse(data.responseText);
            if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
              $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
            }
          },
          error: function() {
            $('button').prop('disabled', false);
            $('button[type="submit"]').html('Set New Password');
            $.toast({
              heading: 'Network Error!',
              text: 'Could not establish connection to server. Please refresh the page and try again.',
              icon: 'error'
            });
          },
          success: function(data) {
            var data = JSON.parse(data);
            $('button').prop('disabled', false);
            $('button[type="submit"]').html('Set New Password');
            
            // If validation error exists
            if(data.status > 0) {
              for(var key in data) {
                var errorContainer = form.find(`.${key}.error`);
                if(errorContainer.length !== 0) {
                  errorContainer.html(data[key]);
                }
              }
            }

            if(data.updatestatus == 1) {
              // If update completed
              form.trigger('reset');
              $('.card-body').prepend('<div class="alert alert-success">'+data.msg+'</div>');
            } else if(data.updatestatus == 0) {
              $('.card-body').prepend('<div class="alert alert-danger">'+data.msg+'</div>');
            }
          }
        });
      });
    </script>