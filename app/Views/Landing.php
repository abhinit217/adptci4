<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="keywords" content="">
    <!-- Title -->
    <title>LOGIN :: Adaptation</title>
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/style.css" > -->


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
 
<style>

        .navbar-brand img {
            height: 55px;
        }

        .border-right {
            border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
            height: 50px;
        }

       
        .bg-dark {
            background: #FFFFFF !important;
            box-shadow: 0 2px 4px 0 rgb(0 0 0 / 20%);
        }
        .navbar-dark .navbar-nav .active>.nav-link, .navbar-dark .navbar-nav .nav-link.active, .navbar-dark .navbar-nav .nav-link.show, .navbar-dark .navbar-nav .show>.nav-link {
            color: #0B9444 !important;
            border-bottom: 3px solid #0B9444;
            font-weight: 600;
        }
        .navbar-dark .navbar-nav .nav-link {
            font-size: 14px;
            color: #0B9444;
            line-height: 50px;
            padding: 0px 20px;
            font-weight: 400;
            text-transform: uppercase;
        }
        .navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link:hover {
            color: #0B9444;
        }

        /* sagar upto */

        .carousel-caption {
            position: absolute;
            right: 5%;
            bottom: 50px;
            left: 5%;
            z-index: 10;
            padding-top: 20px;
            padding-bottom: 20px;
            color: #fff;
            text-align: center;
        }

        .carousel-caption h5 {
            font-size: 25px;
            color: #F7F7F7;
            letter-spacing: 0;
            text-transform: capitalize;
            font-weight: 600;
        }

        .slider-img {
            filter: brightness(0.7);
            height: 620px;
        }

        .logo-img-height {
            height: 90px;
        }

        .font-14px {
            font-size: 16px;
        }

        .navbar-brand img {
            height: 45px;
        }

        .img-height {
            height: 148px;
        }

        .card-footer {
            padding: 27px 9px;
            border-top: 0px solid rgba(0, 0, 0, .125);
        }

        .title-about {
            font-size: 20px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }

        .title {
            font-size: 16px;
            color: #333333;
            font-weight: bold;
        }

        .border-right {
            border-right: 1px solid rgba(0, 0, 0, 0.20) !important;
            height: 30px;
        }

        .navbar-brand {
            margin-right: 1rem;
            font-size: 15px !important;
            font-weight: 600 !important;
            line-height: inherit;
            white-space: nowrap;
            padding: 0px 10px 0px 18px !important;
        }

        .logo-title {
            color: #000;
            font-size: 14px;
        }

        @media (max-width: 1538px) {
            .img-height {
                height: 130px;
            }
            .font-14px {
                font-size: 14px;
            }
        }

        @media (max-width: 1280px) {
            .img-height {
               height: 127px;
            }
            .font-14px {
                font-size: 12.5px;
            }
        }

        @media (max-width: 1040px) {
            .img-height {
               height: 127px;
            }
            .font-14px {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .img-height {
                height: 220px;
            }
        }
/*
        @media only screen and (max-width: 1920px) {
            .font-14px {
                font-size: 16px;
            }
            .slider-img {
                filter: brightness(0.5);
                height: 400px;
            }
            .mar-60{
                margin-top: 20px;
            }
        }
        @media only screen and (max-width: 1538px) {
            .slider-img {
                filter: brightness(0.5);
                height: 300px;
            }
            .font-14px {
                font-size: 14px;
            }
            .footer-fixed {
            position: fixed;
            width: 100%;
            bottom: 0px;
        }
        }

        @media only screen and (max-width: 1332px) {
            .slider-img {
                filter: brightness(0.5);
                height: 300px;
            }
            .font-14px {
                font-size: 14px;
            }
            .footer-fixed {
            position: fixed;
            width: 100%;
            bottom: 0px;
        }
        }

        @media only screen and (max-width: 1467px) {
            .slider-img {
                filter: brightness(0.5);
                height: 250px;
            }
            .font-14px {
                font-size: 13px;
            }
            .footer-fixed {
            position: fixed;
            width: 100%;
            bottom: 0px;
        }
        }
        
        @media only screen and (max-width: 1440px) {
            .slider-img {
                filter: brightness(0.5);
                height: 358px;
            }
            .font-14px {
                font-size: 15px;
            }
        }

        @media only screen and (max-width: 1409px) {
            .slider-img {
                filter: brightness(0.5);
                height: 220px;
            }
            .font-14px {
                font-size: 13px;
            }
            .footer-fixed {
            position: fixed;
            width: 100%;
            bottom: 0px;
        }
        }
        @media only screen and (max-width: 1175px) {
            .slider-img {
                filter: brightness(0.5);
                height: 358px;
            }
            .font-14px {
                font-size: 13px;
            }
        }
        @media only screen and (max-width: 845px) {
            .slider-img {
                filter: brightness(0.5);
                height: 300px;
            }
            .font-14px {
                font-size: 13px;
            }
            .footer-fixed {
            position: relative;
            width: 100%;
            bottom: 0px;
        }
        }
       */
    </style>
</head>


<body>
    <header>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-xl bg-dark navbar-dark">
            <a class="navbar-brand text-success d-flex align-items-center" href="<?php echo base_url(); ?>">
                <!-- Adaptation Tracking Protocol Development -->
                <p class="mb-0 logo-title">Tracking Adaptation in <br> Livestock System (TAiLS)</p>
                <!-- <img src="<?php echo base_url(); ?>include/assets/images/tails-logo.png" >  -->
                <!-- <span class="border-right"></span> -->
                <!-- <img src="<?php echo base_url(); ?>include/assets/images/german.png">
                <span class="border-right pl-3"></span> <img src="<?php echo base_url(); ?>include/assets/images/gizlogo.png" class="pl-2"> <span
                    class="border-right pl-3"></span> <img src="<?php echo base_url(); ?>include/assets/images/ilri.jpg"> -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url(); ?>">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">About Us</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>login">Login</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <!-- carousel -->
    <div class="wrapper mt-0 flex">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/banner-three.png" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/banner-four.png" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5>
                    </div>
                </div>
                 <div class="carousel-item">
                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/banner-five.jpg" alt="Thrid slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5>
                    </div>
                </div>
            </div>
            <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a> -->
        </div>


        <section class="mt-4 mb-5" id="AboutUs">
            <div class="container-fluid">
                <div class="row mar-60">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="title-about mt-2 mb-4">About TAiLS</h4>
                        <!-- <p class="font-14px mb-2 text-justify">Taking stock of climate change adaptation in livestock
                            systems requires effective tracking
                            and
                            reporting.</p> -->
                        <p class="font-14px mb-2 text-justify">Taking stock of climate change adaptation in livestock
                            systems requires effective tracking and reporting. The Paris Agreement establishes a Global
                            Goal on Adaptation (GGA) and encourages countries to report on their vulnerabilities,
                            adaptation efforts, and outcomes. However, adaptation tracking in livestock systems is
                            hindered by several challenges, including the lack of validated indicators and tools to
                            support the assessment and comparison of adaptation progress across temporal and spatial
                            scales.</p>

                        <p class="font-14px mb-2 text-justify">The Tracking Adaptation in Livestock Systems (TAiLS) tool
                            is designed to enable governments to track and report on climate change adaptation in the
                            livestock sector. The TAiLS tool covers three dimensions that are fundamental to adaptation
                            tracking: climatic hazards, climate change impacts, and adaptive capacity and actions.
                            Through this tool, governments can analyze the changes in the three dimensions and their
                            associated indicators and be able to develop statements about progress on climate change
                            adaptation.</p>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="title-about mt-2 mb-4">For which country are you reporting?</h4>
                        <div class="row mt-4">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="card border card-hover">
                                    <div class="card-body p-1">
                                        <img src="<?php echo base_url(); ?>include/assets/images/Flag_of_Ethiopia.svg" class="w-100 img-height">
                                    </div>
                                    <div class="card-footer bg-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="title mb-0">Ethiopia</h4>
                                            </div>
                                            <div>
                                                <a href="<?php echo base_url(); ?>Login/" class="goDim cursor"> <img
                                                        src="<?php echo base_url(); ?>include/assets/images/Arrow_Right.svg"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="card border card-hover">
                                    <div class="card-body p-1">
                                        <img src="<?php echo base_url(); ?>include/assets/images/Flag_of_Kenya.svg" class="w-100 img-height">
                                    </div>
                                    <div class="card-footer bg-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="title mb-0">Kenya </h4>
                                            </div>
                                            <div>
                                                <a href="<?php echo base_url(); ?>Login/" class="goDim cursor"> <img
                                                        src="<?php echo base_url(); ?>include/assets/images/Arrow_Right.svg"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="card border card-hover">
                                    <div class="card-body p-1">
                                        <img src="<?php echo base_url(); ?>include/assets/images/Flag_of_Uganda.svg" class="w-100 img-height">
                                    </div>
                                    <div class="card-footer bg-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="title mb-0">Uganda</h4>
                                            </div>
                                            <div>
                                                <a href="<?php echo base_url(); ?>Login/" class="goDim cursor"> <img
                                                        src="<?php echo base_url(); ?>include/assets/images/Arrow_Right.svg"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="mt-2 bg-white footer-fixed">
            <div class="container-fluid">
                <div class="row text-center">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <img src="<?php echo base_url(); ?>include/assets/images/Germancooperation.jpg" class="logo-img-height">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <img src="<?php echo base_url(); ?>include/assets/images/GIZ.jpg" class="logo-img-height">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <img src="<?php echo base_url(); ?>include/assets/images/ILRI.jfif" class="logo-img-height">
                    </div>
                    <div class="col-md-12 col-sm-12 bottom">
                        <ul class="legal centered text-dark mb-0" style="list-style-type: none;">
                            <li><a href="javascript:void(0);" class="text-dark font-14px">Copyright and permissions | ©
                                    2022 International Livestock Research Institute |
                                    <i class="fa fa-cc"></i> | <i class="fa fa-user-circle-o"></i></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </section>

        <!--  -->
    </div>
    
    <!-- Javascript -->
    <script type="text/javascript" src="./assets/scripts/index.js"></script>
    <script type="text/javascript" src="./assets/scripts/utils.js"></script>
</body>
</html>