<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="keywords" content="" />
    <!-- Title -->
    <title>DASHBOARD::Adaptation</title>
    <!-- Bootstrap css -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>include/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <!-- Style css -->
    <link href="<?php echo base_url(); ?>include/assets/css/style.css" rel="stylesheet" />
    <!-- Dark css -->
    <link href="<?php echo base_url(); ?>include/assets/css/dark.css" rel="stylesheet" />
    <!-- Skins css -->
    <link href="<?php echo base_url(); ?>include/assets/css/skins.css" rel="stylesheet" />
    <!-- Animate css -->
    <link href="<?php echo base_url(); ?>include/assets/css/animated.css" rel="stylesheet" />
    <!-- P-scroll bar css-->
    <link href="<?php echo base_url(); ?>include/assets/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />
    <!---Icons css-->
    <link href="<?php echo base_url(); ?>include/assets/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>include/assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>include/assets/plugins/web-fonts/plugin.css" rel="stylesheet" />
    <!-- Select2 css -->
    <link href="<?php echo base_url(); ?>include/assets/plugins/select2/select2.min.css" rel="stylesheet" />
    <!-- File Uploads css -->
    <link href="<?php echo base_url(); ?>include/assets/plugins/fancyuploder/fancy_fileupload.css" rel="stylesheet" />
    <!-- Time picker css -->
    <link href="<?php echo base_url(); ?>include/assets/plugins/time-picker/jquery.timepicker.css" rel="stylesheet" />
    <!-- Date Picker css -->
    <link href="<?php echo base_url(); ?>include/assets/plugins/date-picker/date-picker.css" rel="stylesheet" />
    <!-- File Uploads css-->
    <link href="<?php echo base_url(); ?>include/assets/plugins/fileupload/css/fileupload.css" rel="stylesheet" type="text/css" />
    <!--Mutipleselect css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/multipleselect/multiple-select.css">
    <!--Sumoselect css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/sumoselect/sumoselect.css">
    <!--intlTelInput css-->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/intl-tel-input-master/intlTelInput.css"> -->
    <!--Jquerytransfer css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/jQuerytransfer/jquery.transfer.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/jQuerytransfer/icon_font/icon_font.css">
    <!--multi css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/multi/multi.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/jquery-toast-plugin/jquery.toast.min.css">
    <script src="<?php echo base_url(); ?>include/assets/plugins/sweet-alert/sweetalert.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/sweet-alert/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Jquery js-->
    <script src="<?php echo base_url(); ?>include/assets/js/vendors/jquery-3.5.1.min.js"></script>
 <style>
        .content-height {
            background-color: #082531;
            height: 100vh;
        }
        .box:hover {
            background: #bfd816;
            box-shadow: 0px 1px 2px 2px rgb(0 0 0 / 15%);
            border-radius: 4px;
        }

        .modal.main {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: block;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }

        .box {
            background: #004B03;
            /* background: #688654; */
            box-shadow: 0px 1px 2px 2px rgb(0 0 0 / 15%);
            border-radius: 4px;
            position: absolute;
            width: 95%;
            text-align: center;
            left: 16px;
            bottom: 250px;
        }

        a.text_launch {
            text-decoration: none;
            font-size: 40px;
        }

        .title_text {
            font-family: Open Sans;
            font-style: normal;
            font-weight: bold;
            font-size: 30px;
            line-height: 41px;
            text-transform: uppercase;
            color: #00009F;
            text-align: center;
        }
        .btn_launch {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            background: #004B03;
            border: none;
            white-space: break-spaces;
            background: #004B03;
        }
        .btn_launch:hover{
            background: #bfd816;
            box-shadow: 0px 1px 2px 2px rgb(0 0 0 / 15%);
            border-radius: 4px;
        }
    </style>
    </head>
    <body>

<section class="content-height">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-1 col-lg-1"></div>
                <div class="col-sm-12 col-md-5 col-lg-5">
                <img src="<?php echo base_url(); ?>include/assets/images/launch.jpg" style="width: 100%;height: 100vh;">
                </div>
                <div class="col-sm-12 col-md-1 col-lg-1"></div>
                <div class="col-sm-12 col-md-5 col-lg-4">
                <a href="<?php echo base_url(); ?>" id="launchLink" class=" btn btn_launch text_launch text-white btn-2 p-4">Launch of Reporting Platform & Reporting Cycle 2021 </a>
                </div>
                <div class="col-sm-12 col-md-1 col-lg-1"></div>
            </div>
        </div>
    </section>
    <script>
        $('#launchLink').click (function (e) {
            e.preventDefault(); //will stop the link href to call the blog page

            setTimeout(function () {
                window.location.href = "<?php echo base_url(); ?>"; //will redirect to your blog page (an ex: blog.html)
                }, 1000); //will call the function after 2 secs.

            });
        </script>
    </body>
    </html>