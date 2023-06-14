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
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>include/assets/plugins/jquery-toast-plugin/jquery.toast.min.css">

    <!-- Bootstrap css -->
    <link href="<?php echo base_url(); ?>include/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <!-- Style css -->
    <link href="<?php echo base_url(); ?>include/assets/css/style.css" rel="stylesheet" />
    <!-- Dark css -->
    <link href="<?php echo base_url(); ?>include/assets/css/dark.css" rel="stylesheet" />
    <!-- Skins css -->
    <link href="<?php echo base_url(); ?>include/assets/css/skins.css" rel="stylesheet" />
    <!-- Animate css -->
    <link href="<?php echo base_url(); ?>include/assets/css/animated.css" rel="stylesheet" />
    <!---Icons css-->
    <link href="<?php echo base_url(); ?>include/assets/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>include/assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>include/assets/plugins/web-fonts/plugin.css" rel="stylesheet" />
 
    <style>
        .content-body {
            padding: 0px;
            margin: 0px 16px;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .text-center {
            text-align: center !important;
        }

        #loginCard {
            border-top: none !important;
        }

        .font-italic {
            font-style: italic !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .small,
        small {
            font-size: 80%;
            font-weight: 400;
        }

        .left img {
            width: 100%;
            height: 100vh;
            filter: brightness(.6);
            margin-left: -4px;
        }
        .shadow {
            background: #FFFFFF;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
            border-radius: 8px;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #495057;
            font-size: 14px;
            font-weight: 600;
            background-color: #f2efe9;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        .nav-link {
            display: block!important; 
            padding: 0.2rem 0.9rem;
        }
    </style>

    
   <!-- Jquery js-->
   <script src="<?php echo base_url(); ?>include/assets/js/vendors/jquery-3.5.1.min.js"></script>
     <!-- Bootstrap4 js-->
    <script src="<?php echo base_url(); ?>include/assets/plugins/bootstrap/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>include/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--Othercharts js-->
    <script src="<?php echo base_url(); ?>include/assets/plugins/othercharts/jquery.sparkline.min.js"></script>
    <!-- Circle-progress js-->
    <script src="<?php echo base_url(); ?>include/assets/js/vendors/circle-progress.min.js"></script>
    <!-- Jquery-rating js-->
    <script src="<?php echo base_url(); ?>include/assets/plugins/rating/jquery.rating-stars.js"></script>
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" ></script>
    <style>
        .scrollDownClick {
            width: 2rem;
            height: 2rem;
            background-color: green;
            color: white;
            position: absolute;
            border-radius: 50%;
            bottom: 0px;
            right: -24px;
            z-index: 6000;
            margin-right: 2em;
            margin-bottom: 2em;
            box-shadow: 0 0 12px rgb(0 0 0 / 50%);
            transition: margin-bottom 0.2s;
        }

        .scrollDownClick:hover {
            background-color: green;
        }

        .scrollDownClick:active {
            margin-bottom: 1.5rem;
        }

        #downArrowScroll {
            position: relative;
            left: 36%;
            top: 4px;
            vertical-align: bottom;
        }
        .form-horizontal .form-group .form-control {
            width: 98%!important;
        }
        #scroll_style::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        #scroll_style::-webkit-scrollbar {
            width: 15px;
            background-color: #F5F5F5;
        }

        #scroll_style::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #28a745;
        }
    </style>
</head>


<body class="bg-white">



    <section class="main-body p-0">
        <div class="content-body content-body-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 pl-0 pr-0">
                    <div class="left">
                        <!-- <img src="<?php echo base_url(); ?>/include/assets/images/banner1.jpg" alt="Login"> -->
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                                </li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>/include/assets/images/login-banner-1.jpg" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5> -->
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/login-banner-2.jpg" alt="Second slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5> -->
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/login-banner-3.jpg" alt="Third slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5> -->
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/login-banner-4.jpg" alt="Fourth slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5> -->
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100 slider-img" src="<?php echo base_url(); ?>include/assets/images/login-banner-5.jpg" alt="Fifth slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Tracking Adaptation in Livestock Systems (TAiLS)</h5> -->
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
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="row my-5">
                        <div class="col-sm-12 col-md-2 col-lg-2"></div>
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <h1 class="text-center mt-5 font-weight-bold">Welcome!</h1>
                            <div class="row mt-5">
                                <div class="col-md-12 mr-auto">
                                    <div class="card pl-3 pr-3 pt-0  shadow border-0" id="loginCard">
                                        <nav class="nav-justified">
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <!-- <a class="nav-item nav-link active p-3 text-dark" id="nav-profile-tab"
                                                    data-toggle="tab" href="#nav-profile" role="tab"
                                                    aria-controls="nav-profile" aria-selected="false"> Sign in</a> -->
                                                    <a class="nav-item nav-link p-3 text-dark active"  href="<?php echo base_url(); ?>login">Sign in</a>

                                                <!-- <a class="nav-item nav-link p-3 text-dark" id="nav-home-tab"
                                                    data-toggle="tab" href="#nav-home" role="tab"
                                                    aria-controls="nav-home" aria-selected="true">Register</a> -->

                                                    <a class="nav-item nav-link p-3 text-dark"  href="<?php echo base_url(); ?>login/register" >Register</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content mt-4" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                                                aria-labelledby="nav-profile-tab">
                                                <form action="#" class="form-horizontal form-simple" method="post" accept-charset="utf-8">
                                                    <?= csrf_field() ?>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address / Username</label>
                                                        <input type="text" class="form-control" id="user-name"
                                                            placeholder="Email / Username" name="email"
                                                            autocomplete="off">
                                                        <span class="text-danger email error" style="color: red;"
                                                            id="email-error"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Password</label>
                                                        <input type="password" class="form-control" id="user-password"
                                                            placeholder="Password" name="password" autocomplete="off">
                                                        <span class="text-danger password error" style="color: red;"
                                                            id="password-error"></span>
                                                    </div>
                                                    <div class="form-check d-inline">
                                                        <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1">
														<small class="form-check-label font-css" for="exampleCheck1">Remember
															Me</small> -->
                                                        <a class="float-right text-dark"
                                                            href="<?php echo base_url(); ?>password/lostpassword/"><small
                                                                class="form-check-label font-css float-right"
                                                                for="exampleCheck2">Forgot
                                                                Password?</small></a>
                                                    </div>
                                                    <div class="my-3">
                                                        <button type="submit" id="simple"
                                                            class="btn btn-size btn-success py-2 px-4">Sign In</button>
                                                    </div>
                                                    <span class="text-danger form error" id="form-error"></span>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade mob_res" id="nav-home" role="tabpanel"
                                                aria-labelledby="nav-home-tab">

                                                <form action="#" id="scroll_style"
                                                    class="form-horizontal form-simple mt-3" method="post"
                                                    accept-charset="utf-8"
                                                    style="height: 400px; overflow-y: scroll; overflow-x: hidden;">
                                                    <div class="form-group">
                                                        <label for="">First Name <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id=first_name"
                                                            placeholder="First Name" name="first_name" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Last Name <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id="last_name"
                                                            placeholder="Last Name" name="last_name" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Select Role <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <select type="text" class="form-control " id="role"
                                                            placeholder="Email" name="role" value="">
                                                            <option value="">Select Role</option>
                                                            <option value="6">Country Admin</option>
                                                            <option value="5">County / Zone / District Admin</option>
                                                        </select>
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email Address <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id="emailid"
                                                            placeholder="Email" name="emailid" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">User Name <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id="user_name"
                                                            placeholder="User Name" name="user_name" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Password <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="Password" class="form-control" id="password1"
                                                            placeholder="Password" name="password1" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Confirm Password <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="Password" class="form-control" id="cpassword"
                                                            placeholder="Confirm Password" name="cpassword" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group country_div" id="country_div">
                                                        <label for="">Country <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <select class="form-control country" name="country">
                                                            <option value="">Select Country</option>
                                                            <option value="1">Kenya</option>
                                                            <option value="2">Uganda</option>
                                                            <option value="3">Ethiopia</option>
                                                        </select>
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group county_div" id="county_div">
                                                        <label for="">County / Zone / District <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <select class="form-control county" name="county">
                                                            <option selected value="">Select County / Zone / District
                                                            </option>
                                                        </select>
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Mobile No <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id="mobile_number"
                                                            placeholder="Mobile Number" name="mobile_number" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Organization <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id="organization"
                                                            placeholder="Organization" name="organization" value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Role in the organization <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <input type="text" class="form-control" id="organization_role"
                                                            placeholder="organization Role" name="organization_role"
                                                            value="">
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Reason for dashboard request <sup
                                                                class="text-danger"><strong>*</strong></sup></label>
                                                        <textarea class="form-control" rows="5" id="reason"
                                                            name="reason"></textarea>
                                                        <p class="error red-800"></p>
                                                    </div>
                                                    <div class="my-3">
                                                        <!-- <button type="submit" id="ldap" class="btn btn-size btn-success py-2 px-4 btn-block add_user">Register</button> -->
                                                        <button class="btn btn-success pull-right add_user"
                                                            type="button">Register</button>
                                                    </div>
                                                </form>
                                                <div class="scrollDownClick">
                                                    <i class="fa fa-angle-double-down" id="downArrowScroll"></i>
                                                </div>
                                            </div>

                                        </div>

                                        <small class="font-italic p-3" for="exampleCheck2"
                                            style="padding-top:0 !important;text-align:justify;font-weight:500;color:#797979;">
                                            Note: For complete experience of the platform please use one of the
                                            following browsers: Google Chrome,
                                            Firefox, Microsoft Edge, Opera.
                                        </small>
                                    </div>
                                </div>

                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12 mt-3">
                                    <a href="<?php echo base_url(); ?>" class="text-dark py-2 px-4">Back to Home</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-3"> </div>
                    </div>

                </div>
            </div>
            
        </div>
    </section>

    <script type="text/javascript">

        $(function(){
            $(".scrollDownClick").click(function (event) {
                $(".form-horizontal").animate({ scrollTop: "+=750px" }, 400);
            });

            $('.county_div').hide();

            var clickedBtn = '';
            $('form').on('click', 'button', function(event) {
                var elem = $(this);
                clickedBtn = elem.attr('id');
            });

            $('form').on('submit', function(event) {
                event.preventDefault();
                $('.error').html('');
                $('button[type="submit"]').attr('disabled', 'disabled').html('Please Wait...');

                initLogin($(this), false);
            });
            

            function initLogin(form, email) {
                var url = '';
                if(email.length) url = '<?php echo base_url(); ?>auth/backdoor_login/';
                else url = '<?php echo base_url(); ?>auth/login/';
                
                fromData = new FormData(form[0]);
                fromData.append('logintype', clickedBtn);
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: fromData,
                    processData: false,
                    contentType: false,
                    complete: function(data) {
                        var csrfData = JSON.parse(data.responseText);
                        if(csrfData.csrfName && $('input[name="' + csrfData.csrfName + '"]').length > 0) {
                            $('input[name="' + csrfData.csrfName + '"]').val(csrfData.csrfHash);
                        }
                    },
                    error: function() {
                        form.find('.form.error').html('Could not establish connection to server. Please refresh the page and try again.');
                        $('button[type="submit"]').removeAttr('disabled').html('Sign In');
                    },
                    success: function(data) {
                        if(data.status == 0) {
                            $('button[type="submit"]').removeAttr('disabled').html('Sign In');
                            form.find('.email.error').html(data.email);
                            form.find('.password.error').html(data.password);
                            form.find('.form.error').html(data.form);
                        } else {
                            window.location.href = data.redirect;
                        }
                    }
                });
            }
        }); 

        $('#role').on('change', function() {
            role= this.value;
            if(role==6){
                $('.county_div').hide();
            }else{
                $('.county_div').show();
            }
        });  
        
        $('.country').on('change', function() {
            $elem = $(this);
            country_id= this.value;
            $.ajax({
                url: "<?php echo base_url(); ?>user_management/get_countys",
                type: "POST",
                dataType: "json",
                data: {
                    country_id: country_id
                },
                error: function() {
                    // setTimeout(function() {
                    //     $('.' + classname).empty();
                    // }, 500);
                },
                success: function(response) {
                    if (response.status == 1) {
                        if (response.result.lkp_county_list.length > 0) {
                            var CHILD_HTML = '';
                            for (var field of response.result.lkp_county_list) {
                                CHILD_HTML += '<option value = "' + field.county_id + '">' + field.county_name + '</option>';
                            };
                            $('.county').html(CHILD_HTML);
                        }
                    } else {
                            // setTimeout(function() {
                            //     $('.' + classname).empty();
                            // }, 500);
                    }
                }
            });
        });
        
        $('.add_user').on('click', function(){
            var error = 0;

            var first_name = $('input[name="first_name"]').val();
            if(first_name.trim().length == 0){
                $('input[name="first_name"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('input[name="first_name"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }

            var last_name = $('input[name="last_name"]').val();
            if(last_name.trim().length == 0){
                $('input[name="last_name"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('input[name="last_name"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }

            var role = $('select[name="role"]').val();
            if(role == ''){
                $('select[name="role"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('input[name="role"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }

            var emailid = $('input[name="emailid"]').val();
            if(emailid.trim().length == 0){
                $('input[name="emailid"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                if(!isValidEmailAddress(emailid)) { 
                    $('input[name="emailid"]').closest('.form-group').find('.error').html('<p class="red-800">In valid email id</p>');
                    error++;
                }else{
                    $('input[name="emailid"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }
            }

            var user_name = $('input[name="user_name"]').val();
            if(user_name.trim().length == 0){
                $('input[name="user_name"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('input[name="user_name"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }

            var password = $('input[name="password1"]').val();
            if(password.trim().length == 0){
                $('input[name="password1"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('input[name="password1"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }

            var cpassword = $('input[name="cpassword"]').val();
            if(cpassword.trim().length == 0){
                $('input[name="cpassword"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('input[name="cpassword"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }

            if(cpassword != password){
                $('input[name="cpassword"]').closest('.form-group').find('.error').html('<p class="red-800">Both password and confrrm password should be same.</p>');
                error++;
            }
            var country = $('select[name="country"]').val();
            if(country.trim().length == 0){
                $('select[name="country"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                error++;
            }else{
                    $('select[name="country"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }
            if(  $("#county_div").is(":visible") == true ){
                var county = $('select[name="county"]').val();
                if(county.trim().length == 0){
                    $('select[name="county"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                    error++;
                }else{
                    $('select[name="county"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }
            }
            var organization = $('input[name="organization"]').val();
            if(organization.trim().length == 0){
                $('input[name="organization"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                    error++;
            }
            var organization_role = $('input[name="organization_role"]').val();
            if(organization_role.trim().length == 0){
                $('input[name="organization_role"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                    error++;
            }
            var mobile_number = $('input[name="mobile_number"]').val();
            if(mobile_number.trim().length == 0){
                $('input[name="mobile_number"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                    error++;
            }else{
                if(!/^[0-9]+$/.test(mobile_number)){
                    $('input[name="mobile_number"]').closest('.form-group').find('.error').html('<p class="red-800">Please Enter only Numbers</p>');
                    error++;
                }else{
                    $('input[name="mobile_number"]').closest('.form-group').find('.error').html('<p class="red-800"></p>');
                }
            }
            var reason = $('#reason').val();
            if(reason.trim().length == 0){
                $('textarea[name="reason"]').closest('.form-group').find('.error').html('<p class="red-800">This field is required</p>');
                    error++;
            }

            if(error == 0){
                $('button[type="button"]').prop('disabled', true);
                $('button[type="button"]').html('Please wait...');

                $.ajax({
                    url: '<?php echo base_url(); ?>user_management/insert_user',
                    type: 'POST',
                    dataType : 'json',
                    data: {
                        first_name : first_name,
                        last_name : last_name,
                        user_type : role,
                        country : country,
                        county : county,
                        organization : organization,
                        organization_role : organization_role,
                        mobile_number : mobile_number,
                        reason : reason,
                        emailid : emailid,
                        user_name : user_name,
                        password : password,
                        cpassword : cpassword,
                    },                
                    error: function() {
                        $('button[type="button"]').prop('disabled', false);
                        $('button[type="button"]').html('Register Now');
                        $.toast({
                            heading: 'Network Error!',
                            text: 'Could not establish connection to server. Please refresh the page and try again.',
                            icon: 'error'
                        });
                    },
                    success: function(response) {
                        if(response.status == 1) {
                            $.toast({
                                heading: 'Success!',
                                text: response.msg,
                                icon: 'success',
                                afterHidden: function () {
                                    location.reload(true);
                                }
                            });
                        } else if(response.status == 0) {
                            $.toast({
                                heading: 'Error!',
                                text: response.msg,
                                icon: 'error'
                            });
                            $('button[type="button"]').prop('disabled', false);
                            $('button[type="button"]').html('Register Now');
                        } else if(response.status == 2) {
                            $.toast({
                                heading: 'Error!',
                                text: response.msg,
                                icon: 'error'
                            });
                            $('button[type="button"]').prop('disabled', false);
                            $('button[type="button"]').html('Register Now');
                        }
                    }
                });
            }else{
                $('button[type="button"]').prop('disabled', false);
                $('button[type="button"]').html('Register Now');
            }
        });

        function isValidEmailAddress(emailAddress) {
            var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(emailAddress);
        }

        
    </script>

	<style>

	    @media only screen and (max-width: 736px) {
			.align_card {
				position: absolute;
				top: 44%;
				display: contents;
				left: 50%;
				transform: translate(-50%, -50%);
			}
			.mtm-20px {
				margin-top: 20px!important;
			}
		}
		@media only screen and (max-width: 600px) {
			.mtm-20px {
			margin-top: 21px!important;
			}
			.align_card {
                position: absolute;
                top: 44%;
                display: contents;
                left: 50%;
                transform: translate(-50%, -50%);
            }
		}


	</style>
</body>

</html>