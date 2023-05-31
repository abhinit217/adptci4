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
    <style type="text/css">

        .logo-title {
            color: #000;
            font-size: 14px;
        }
        .horizontalMenu>.horizontalMenu-list>li>ul.sub-menu {
            top: 53px;
        }

        .badge-query-res {
            background-color: #014233;
        }

        .profile-dropdown.show .dropdown-menu[x-placement^="bottom"] {
            left: 5px !important;
        }

        .border-right {
            border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
            height: 50px;
        }

        .nav-link:hover .dropdown-menu,
        .nav-item:hover .dropdown-menu,
        .nav-link:hover .dropdown-menu.show {
            display: inline;
        }

        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif !important;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #f4f4f4 !important;
        }

        .bg-dark {
            background: #FFFFFF !important;
            box-shadow: 0 2px 4px 0 rgb(0 0 0 / 20%);
        }

        .navbar-dark .navbar-nav .nav-link {
            font-size: 14px;
            color: #0B9444;
            line-height: 50px;
            padding: 0px 20px;
            font-weight: 400;
            text-transform: uppercase;
        }

        .text_title_head {
            font-size: 14px;
            color: #333333 !important;
            text-align: center;
            font-weight: bold !important;
        }

        .navbar-dark .navbar-nav .nav-link:focus,
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #0B9444;
        }

        .navbar-dark .navbar-nav .active>.nav-link,
        .navbar-dark .navbar-nav .nav-link.active,
        .navbar-dark .navbar-nav .nav-link.show,
        .navbar-dark .navbar-nav .show>.nav-link {
            color: #0B9444 !important;
            border-bottom: 3px solid #0B9444;
            font-weight: 600;
        }

        .dropdown-menu.profile {
            position: absolute;
            top: 100%;
            left: -92px;
            z-index: 1000;
            box-shadow: 0 2px 4px 0 rgb(0 0 0 / 20%);
            /* display: none; */
            float: left;
            min-width: 10rem;
            padding: .5rem 0;
            margin: .125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 0px solid rgba(0, 0, 0, .15);
            border-radius: .25rem;
        }

        .navbar-dark .navbar-nav .show>.nav-link.dropdown-toggle {
            color: #0B9444 !important;
            border-bottom: 0px solid #0B9444;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #0B9444;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }

        .border-right {
            border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
            height: 50px;
        }

        .navbar-dark .navbar-toggler-icon {
            background-image: url('<?php echo base_url(); ?>include/assets/images/menu-open.svg');
        }

        .title {
            font-size: 18px;
            color: #333333;
            font-weight: bold;
        }

        .search {
            position: absolute;
            right: 30px;
            top: 19px;
        }

        .tbl_bg_head {
            background: #004B03;
            color: #fff;
            font-size: 14px;
            font-weight: 300 !important;
        }

        .table thead th {
            vertical-align: bottom;
            border: 1px solid #dee2e6;
        }

        .table td,
        .table th {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 0px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 75, 3, 0.10);
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #333333;
        }

        .logo1 {
            height: 45px;
        }

        .logo2 {
            height: 40px;
            padding-left: 20px;
        }

        .progress {
            display: flex;
            height: 20px;
            width: 200px;
            overflow: hidden;
            line-height: 0;
            border: 1px solid #333333;
            font-size: .75rem;
            background-color: #fff;
            border-radius: 0;
        }

        .text-percent {
            font-size: 14px;
            color: #333333;
        }

        .progress-bar1 {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #ee533d;
            transition: width .6s ease;
        }

        .progress-bar2 {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #ea5735;
            transition: width .6s ease;
        }

        .progress-bar3 {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #3eaea2;
            transition: width .6s ease;
        }

        .bg_filters {
            background: #004B03;
        }

        .navbar {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 0px;
        }

        .btn_apply {
            border: 1px solid #A4C7B3;
            border-radius: 4px;
            font-size: 14px;
            color: #C5E2D2;
        }

        .btn.btn_apply:hover {
            color: #c5e2d2;
            text-decoration: none;
        }

        .btn-light {
            color: #A4C7B3 !important;
            background-color: #004b03;
            border-color: #A4C7B3;
        }

        .bootstrap-select>.dropdown-toggle.bs-placeholder,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
            font-size: 14px !important;
            color: #C5E2D2 !important;
        }

        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
            width: 100% !important;
        }

        .bs-select-all.btn.btn-light {
            background-color: #e2e6ea;
            border-color: #dae0e5;
            color: #000 !important;
            font-size: 12px;
        }

        .bs-deselect-all.btn.btn-light {
            background-color: #e2e6ea;
            border-color: #dae0e5;
            color: #000 !important;
            font-size: 12px;
        }

        .btn-light:not(:disabled):not(.disabled).active,
        .btn-light:not(:disabled):not(.disabled):active,
        .show>.btn-light.dropdown-toggle {
            color: #fff;
            background-color: transparent !important;
            border-color: #A4C7B3 !important;
        }

        .btn-light:hover {
            color: #212529;
            background-color: transparent !important;
            border-color: #A4C7B3 !important;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1.5rem;
            clear: both;
            font-weight: 400;
            font-size: 14px;
            color: #0B9444;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }

        /* .shadow{
            background: #FFFFFF;
            box-shadow: 0 0 4px 1px rgba(0,0,0,0.10);
            border-radius: 8px;
        } */

        .text_title {
            font-size: 12px;
            color: #333333;
            letter-spacing: -0.06px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        .navbar-dark .navbar-nav .active>.nav-link,
        .navbar-dark .navbar-nav .nav-link.nb.active,
        .navbar-dark .navbar-nav .nav-link.show,
        .navbar-dark .navbar-nav .show>.nav-link.nb {
            color: #0B9444 !important;
            border-bottom: 0px solid #0B9444;
            font-weight: 600;
        }

        .font-24px {
            font-size: 24px;
            color: #444444;
            letter-spacing: -0.12px;
            text-align: center;
            font-weight: bold;
        }

        .text_small {
            font-size: 10px;
            color: #666666;
            letter-spacing: -0.05px;
            line-height: 12px;
            text-transform: uppercase;
        }

        .text_pos1 {
            font-size: 9px;
            color: #666666;
            letter-spacing: -0.04px;
            line-height: 12px;
            font-weight: bold;
            position: relative;
            top: 35px;
            left: 4px;
        }

        .text_pos2 {
            font-size: 9px;
            color: #666666;
            letter-spacing: -0.04px;
            text-align: right;
            line-height: 12px;
            font-weight: bold;
            position: relative;
            right: 32px;
            top: 10px;
        }

        .text_pos {
            font-size: 9px;
            color: #666666;
            letter-spacing: -0.04px;
            text-align: center;
            line-height: 12px;
            font-weight: bold;
        }

        .small_text2 {
            font-size: 10px;
            color: #666666;
            letter-spacing: -0.05px;
            text-align: center;
            white-space: pre-line;
            line-height: 12px;
            text-transform: uppercase;
        }

        .list-view .row>[class*='col-'] {
            max-width: 100%;
            flex: 0 0 100%;
        }

        .list-view .card {
            flex-direction: row;
        }

        .list-view .card>.card-img-top {
            width: auto;
        }

        .app-content.page-body {
            margin-top: 8rem !important;
        }

        .list-view .card .card-body {
            display: inline-block;
        }

        .search1 {
            position: absolute;
            right: 130px;
            top: 3px;
        }

        .profile-dropdown.show .dropdown-menu {
            left: 0px !important;
            margin-top: 20px;
        }

        .form-control.form_height {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + -7px);
            padding: .375rem .75rem;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .pointer {
            cursor: pointer;
        }

        .dropdown-toggle.grid::after {
            display: inline-block;
            margin-left: .255em;
            display: none;
            vertical-align: .255em;
            content: "";
            border-top: .3em solid;
            border-right: .3em solid transparent;
            border-bottom: 0;
            border-left: .3em solid transparent;
        }

        .dropdown-menu.text_notification {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            /* display: none; */
            float: left;
            min-width: 300px;
            padding: 15px;
            margin: 0.125rem 0 0;
            font-size: 12px;
            color: #777777;
            text-align: left;
            list-style: none;
            font-weight: 400;
            background-clip: padding-box;
            background: #FFF9DC;
            box-shadow: 0 0 5px 3px rgba(0, 0, 0, 0.10);
            border-radius: 8px 8px 8px 8px 0 1px 0;
        }

        .font-12px {
            font-size: 12px;
            color: #555555;
        }

        .font-16px {
            font-size: 16px;
            color: #666666;
            text-align: center;
            line-height: 16px;
        }

        .font-12px {
            font-size: 12px;
            color: #666666;
            text-align: center;
        }

        .actual_text {
            font-size: 16px;
            color: #333333;
        }

        .actual_count {
            font-size: 18px;
            color: #151515;
            font-weight: 600;
            line-height: 22px;
        }

        .target_text {
            font-size: 16px;
            color: #333333;
        }

        .target_count {
            font-size: 18px;
            color: #151515;
            font-weight: 600;
            line-height: 22px;
        }

        .count_variance {
            font-size: 20px;
            color: #333333;
            text-align: center;
            font-weight: 600;
        }

        .text_variance {
            font-size: 14px;
            color: #333333;
            text-align: center;
        }

        .navbar-brand {
                display: inline-block;
                padding-top: 0.3125rem;
                padding-bottom: 0.3125rem;
                margin-right: 1rem;
                font-size: 15px !important;
                font-weight: 600 !important;
                line-height: inherit;
                white-space: nowrap;
                padding: 7px 12px 10px 20px !important;
        }

        .navbar-brand img {
            height: 50px;
        }
        .navbar-dark .navbar-nav .nav-link {
            font-size: 14px;
            color: #0B9444;
            line-height: 50px;
            padding: 0px 20px !important;
            font-weight: 400;
            text-transform: uppercase;
        }

        @media only screen and (max-width: 600px) {

            .stricky {
                position: relative;
                top: 4px;
                z-index: 111;
            }

            .logo1 {
                height: 25px;
                padding-left: 10px;
            }

            .logo2 {
                height: 20px !important;
                padding-left: 7px !important;
            }

            .dropdown-menu.profile {
                position: absolute;
                top: 100%;
                left: 3px;
                z-index: 1000;
                box-shadow: 0 2px 4px 0 rgb(0 0 0 / 20%);
                /* display: none; */
                float: left;
                min-width: 10rem;
                padding: .5rem 0;
                margin: .125rem 0 0;
                font-size: 1rem;
                color: #212529;
                text-align: left;
                list-style: none;
                background-color: #fff;
                background-clip: padding-box;
                border: 0px solid rgba(0, 0, 0, .15);
                border-radius: .25rem;
            }

            .border-right {
                border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
                height: 25px;
            }

            .navbar {
                position: fixed;
                width: 100%;
                z-index: 999;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -ms-flex-align: center;
                align-items: center;
                -ms-flex-pack: justify;
                justify-content: space-between;
                padding: 0px;
            }

            .app-content.page-body {
                margin-top: 3rem !important;
            }
        }

        /* @media only screen and (max-width: 1380px) {
            .navbar-expand-xl{
                flex-flow: row nowrap;
            }
            .navbar-dark .navbar-nav .nav-link {
            font-size: 9px;
            color: #0B9444;
            line-height: 50px;
            padding: 0px 20px;
            font-weight: 400;
            text-transform: uppercase;
        }
        } */
        @media only screen and (min-width: 1280px) {
            .navbar-expand-xl .navbar-nav .nav-link {
                padding-right: 0.5rem;
                padding-left: 0.5rem;
            }
            .logo1 {
                height: 35px;
            }

            .logo2 {
                height: 35px;
                padding-left: 20px;
            }
            .border-right {
                border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
                height: 40px;
            }
        
        }

        @media only screen and (max-width: 1380px) {
            .navbar-expand-xl{
                flex-flow: row wrap;
            }
            .navbar-dark .navbar-nav .nav-link {
                font-size: 9px;
                color: #0B9444;
                line-height: 50px;
                padding: 0px 20px;
                font-weight: 400;
                text-transform: uppercase;
            }
            .logo1 {
                height: 35px;
            }

            .logo2 {
                height: 35px;
                padding-left: 20px;
            }
            .border-right {
                border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
                height: 40px;
            }
        
        }

    </style>
    <!-- <style>
            @media (max-width: 575.98px) {
                .list-view .card {
                    flex-direction: column;
                }
            }
            @media only screen and (max-width: 600px) {
                .header-brand-img.mobile-logo {
                display: block;
                margin-left: -28px;
                }
                .header-brand-img {
                height: 38px;
                line-height: 2rem;
                vertical-align: middle;
                margin-right: 0;
                width: auto;
                margin-top: 7px;
                }
                .fixed_tabs {
                position: static;
                top: 135px;
                left: 0;
                z-index: 9;
                margin-bottom: 16px;
                }
                .header-brand-img.mobile-logo {
                display: none;
                margin-left: -44px;
                }
                .order-lg-2{
                margin-left: 0px!important;
                }
                .header-brand-img.desktop-lgo, .header-brand-img.dark-logo {
                display: block;
                height: 46px;
                line-height: 2rem;
                vertical-align: middle;
                width: 128px;
                margin-top: 0px;
                }
                .animated-arrow.hor-toggle {
                text-align: center;
                height: 2.5rem;
                width: 1.5rem;
                font-size: 1.2rem;
                position: relative;
                border: 0;
                border-radius: 3px;
                margin: 5px;
                top: 0;
                right: 23px;
                }
                .horizontalMenucontainer .app-header {
                background: #fff;
                padding-top: 8px !important;
                padding-bottom: 8px !important;
                height: 65px;
                }

            }
        </style> -->
</head>

<body class="light-mode">
    <div class="page">
        <div class="page-main">
            <nav class="navbar navbar-expand-xl bg-dark navbar-dark" style="position:fixed;width:100%;z-index:999">
                <!-- <a class="navbar-brand d-flex pl-4" href="<?php echo base_url(); ?>">
                    <img class="logo1" src="<?php echo base_url(); ?>include/assets/images/mpro-images/logo.png">
                    <span class="border-right pl-3"></span>
                    <img class="logo2" src="<?php echo base_url(); ?>include/assets/images/mpro-images/icrisat-logo.png">
                </a> -->
                <?php 
                    if ($this->session->userdata('role') ==  6 || $this->session->userdata('role') ==  5){
                        $dashboard_url= base_url().'reporting/c_dashboard';
                    }else{
                        $dashboard_url= base_url().'reporting/common_dashboard';
                    }
                    ?>
                <a class="navbar-brand text-success d-flex align-items-center" href="<?php echo $dashboard_url;?>">
                    <!-- Adaptation Tracking Protocol Development -->
                    
                        <p class="mb-0 logo-title">Tracking Adaptation in <br> Livestock System (TAiLS)</p>
                    <!-- <img src="<?php echo base_url(); ?>include/assets/images/tails-logo.png">  -->
                    <!-- <span class="border-right"></span> 
                    <img src="<?php echo base_url(); ?>include/assets/images/german.png"> <span class="border-right pl-3"></span> 
                    <img src="<?php echo base_url(); ?>include/assets/images/gizlogo.png" class="pl-2"> <span class="border-right pl-3"></span> 
                    <img src="<?php echo base_url(); ?>include/assets/images/ilri.jpg"> -->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <!-- <ul class="navbar-nav d-flex m-auto">
                        <li class="nav-item">
                            <a class="nav-link text_title_head" href="<?php echo base_url(); ?>">ICRISAT Medium Term Plan</a>
                        </li>
                    </ul> -->
                    <ul class="navbar-nav mr-auto ">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>reporting/common_dashboard"> Home</a>
                        </li> -->
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-item dropdown-toggle nav-link <?php echo ($this->uri->segment(2)== "common_dashboard" || $this->uri->segment(2)== "c_dashboard") ? 'active' : ''; ?>" href="#" data-toggle="dropdown">Dashboard</a>
                            <ul class="dropdown-menu">
                            <?php 
                            $this->db->select('*');
                            $this->db->where('status', 1);
                            $this->db->where('user_id', $this->session->userdata('login_id'));
                            $result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
                            if(isset($result['lkp_user_list']['country_id'])){
                                $country_id=$result['lkp_user_list']['country_id'];
                            }else{
                                $country_id=1;
                            }
                            if ($this->session->userdata('role') ==  6 || $this->session->userdata('role') ==  5){?>
                                <li class="nav-item">
                                    <a class="dropdown-item " href="<?php echo base_url(); ?>reporting/c_dashboard"> Dashboard</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reporting/comparisons/<?php echo $country_id;?>" >Comparisons</a></li>
                            <?php }else if ($this->session->userdata('role') ==  1){
                                ?>
                                <li class="nav-item">
                                <a class="dropdown-item " href="<?php echo base_url(); ?>reporting/common_dashboard"> Dashboard</a>
                                </li> 
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reporting/common_comparisons/<?php echo $country_id;?>" >Comparisons</a></li>                           
                                <?php
                            }
                            ?>
                                
                            </ul>
                        </li>
                        
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>reporting/upload_data"> Upload Data</a>
                        </li> -->
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-item dropdown-toggle nav-link <?php echo ($this->uri->segment(1)== "upload_data") ? 'active' : ''; ?>" href="#" data-toggle="dropdown">Upload Data </a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reporting/upload_data">Upload Single</a></li>
                                <!-- <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reporting/upload_data_bulk" >Upload Bulk</a></li> -->
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reporting/bulk_preview" >Upload Bulk</a></li>
                            </ul>
                        </li>
                        <?php if ($this->session->userdata('role') !=  5){?>                            
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>reporting/view_data">Validate Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>reporting/user_management"> User Management</a>
                        </li>
                        <?php
                        }
                        ?>
                        <?php if ($this->session->userdata('role') !=  6){?>                            
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>reporting/view_data_user">Validate Data</a>
                        </li>
                        <?php
                        }
                        ?>
                        <!-- <?php if ($this->session->userdata('role') ==  5 || $this->session->userdata('role') ==  6){?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>dashboard/approval">Approval</a>
                            </li>
                        <?php }?> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>dashboard/overview">Overview</a>
                        </li> -->
                        <!-- <?php if ($this->session->userdata('role') ==  6){?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>dashboard/viewdata">View Data</a>
                            </li>
                        <?php }?> -->
                       
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>dashboard/performance">PERFORMANCE</a>
                        </li> -->
                        <!-- <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-item dropdown-toggle nav-link " href="#" data-toggle="dropdown">Dashboard </a>
                            <ul class="dropdown-menu">
                                <li data-menu="">
                                    <a class="dropdown-item"  href="<?php echo base_url(); ?>dashboard/sdg">SDG</a>
                                </li>
                                <li data-menu="">
                                    <a class="dropdown-item"  href="<?php echo base_url(); ?>dashboard/overview">OVERVIEW - RESEARCH </a>
                                </li>
                                <li data-menu="">
                                    <a class="dropdown-item"  href="<?php echo base_url(); ?>dashboard/non_research">OVERVIEW- NON RESEARCH </a>
                                </li>
                                <li data-menu="">
                                    <a class="dropdown-item"  href="<?php echo base_url(); ?>dashboard/performance">PERFORMANCE</a>
                                </li>
                                <?php if ($this->session->userdata('role') ==  6){?>
                                    <li data-menu="">
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>dashboard/viewdata">VIEW DATA</a>
                                    </li>
                                <?php }?>
                            </ul>
                        </li> -->
                        <!-- <?php if ($this->session->userdata('role') ==  1 || $this->session->userdata('role') ==  6){?>
                            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-item dropdown-toggle nav-link <?php echo ($this->uri->segment(1)== "user_management") ? 'active' : ''; ?>" href="#" data-toggle="dropdown">Config </a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>user_management/create_user">CREATE USER</a></li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>user_management/user_list" >VIEW USER</a></li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>user_management/manage_user" >MANAGE USER</a></li>
                                </ul>
                            </li>
                        <?php }?> -->
                        
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>dashboard/projectmanagement">PROJECT MGMT</a>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        
                        <li class="nav-item">
                            <?php if ($this->session->userdata('login_id') != '' || $this->session->userdata('login_id') != NULL) {
                ?>
                            <div class="dropdown profile-dropdown">
                                <a href="#" class="nav-link nb pr-0 leading-none" data-toggle="dropdown">
                                    <!-- <span class="mr-2 text-secondary">Hello,</span> <span class="mr-2 text-primary"><strong> -->
                                    <span class="mr-2 text-secondary"></span> <span class="mr-2 text-primary"><strong>
                                            <?php echo $this->session->userdata('name'); ?></strong></span>
                                    <span class="avatar avatar-online bg-white">
                                        <img src="<?php echo base_url(); ?>upload/user/<?php echo $this->session->userdata('image');?>" alt="avatar" style="border-radius: 50px;"><i></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated  text-center">
                                    <div class="text-center">
                                        <a href="#" class="dropdown-item text-center user pb-0 font-weight-bold">
                                            <?php echo $this->session->userdata('name'); ?></a>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                    <a class="dropdown-item d-flex  text-center" href="<?php echo base_url(); ?>login/profile">
                                        <i class="fa fa-user mr-3 font-25px"></i>
                                        <div class="mt-1">Profile</div>
                                    </a>
                                    <!-- <a class="dropdown-item d-flex  text-center" href="<?php echo base_url(); ?>include/assets/images/Medium_Term_Plan.pdf" download>
                                        <i class="fa fa-book mr-3 font-25px"></i>
                                        <div class="mt-1"> About MTP</div>
                                    </a> -->
                                    <a class="dropdown-item d-flex text-center" href="<?php echo base_url(); ?>login/logout">
                                        <i class="fa fa-lock mr-3 font-25px"></i>
                                        <div class="mt-1">Sign Out</div>
                                    </a>
                                </div>
                            </div>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </nav>
            <script>
            $(`a.nav-link[href="${location.href}"]`).addClass('active');
            </script>