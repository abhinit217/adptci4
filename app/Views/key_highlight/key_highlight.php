<style type="text/css">
    .h4-40px {
        min-height: 56px;
        margin-top: 15px;
    }
    .h4-15px {
        padding-top: 10px;
    }

    .back_button {
        position: absolute;
        left: 28px;
        cursor: pointer;
    }

    .app-content {
        margin-bottom: 50px;
    }

    .form-control button {
        border: none !important;
    }

    .form-control span {
        margin: 5px;
    }

    .ms-drop.bottom {
        left: 0;
    }

    span.badge>span {
        width: 100%;
        min-width: 40px;
        text-align: center;
        display: grid;
        margin: 0 auto;
        margin-top: 5px;
    }

    /* loading dots */
    .loading:after {
        content: ' .';
        padding-right: 5px;
        animation: dots 1s steps(5, end) infinite;
    }

    .table tr {
        cursor: default;
    }
    .cross{
        text-align: left;
        position: absolute;
        right: 10px;
        top: 6px;
        cursor: pointer;
        line-height: 10px
    }

    @keyframes dots {

        0%,
        20% {
            color: rgba(255, 255, 255, 0);
            text-shadow:
                .25em 0 0 rgba(255, 255, 255, 0),
                .5em 0 0 rgba(255, 255, 255, 0);
        }

        40% {
            color: black;
            text-shadow:
                .25em 0 0 rgba(255, 255, 255, 0),
                .5em 0 0 rgba(255, 255, 255, 0);
        }

        60% {
            text-shadow:
                .25em 0 0 black,
                .5em 0 0 rgba(255, 255, 255, 0);
        }

        80%,
        100% {
            text-shadow:
                .25em 0 0 black,
                .5em 0 0 black;
        }
    }

    .p-15px {
        padding: 15px;
    }

    .tbl_bg {
        background-color: #deebff;
    }

    .tbl_bg>td {
        border: 2px solid #fff;
    }

    .fixed_tabs {
        position: fixed;
        top: 135px;
        left: 0;
        z-index: 9;
        margin-bottom: 16px;
    }

    .fixed_tabs_2 {
        position: fixed;
        top: 190px;
        left: 0;
        z-index: 1;
    }

    .mt-30px {
        margin-top: 30px;
    }

    .tbl_head {
        font-size: 22px;
        font-weight: 400;
    }

    .mt-34px {
        margin-top: 25px
    }

    .table-responsive {
        max-height: 450px;
    }

    .filter_btn {
        padding: 8px 21px;
        border: none;
        border-radius: 20px;
    }

    .filter_btn:hover {
        background-color: #257EC9;
        color: #fff;
    }

    .pb-19px {
        padding-bottom: 19px;
    }

    .p-13px {
        padding: 13px !important;
    }

    .app-content {
        margin-bottom: 50px;
    }

    .form-control button {
        border: none !important;
    }

    .form-control span {
        margin: 5px;
    }

    .ms-drop.bottom {
        left: 0;
    }

    span.badge>span {
        width: 100%;
        min-width: 40px;
        text-align: center;
        display: grid;
        margin: 0 auto;
        margin-top: 5px;
    }

    /* loading dots */
    .loading:after {
        content: ' .';
        padding-right: 5px;
        animation: dots 1s steps(5, end) infinite;
    }

    @keyframes dots {

        0%,
        20% {
            color: rgba(255, 255, 255, 0);
            text-shadow:
                .25em 0 0 rgba(255, 255, 255, 0),
                .5em 0 0 rgba(255, 255, 255, 0);
        }

        40% {
            color: black;
            text-shadow:
                .25em 0 0 rgba(255, 255, 255, 0),
                .5em 0 0 rgba(255, 255, 255, 0);
        }

        60% {
            text-shadow:
                .25em 0 0 black,
                .5em 0 0 rgba(255, 255, 255, 0);
        }

        80%,
        100% {
            text-shadow:
                .25em 0 0 black,
                .5em 0 0 black;
        }
    }

    .p-15px {
        padding: 15px;
    }
    .h4-20px{
        min-height: 20px;
        padding-top: 15px;
    }
    .tbl_bg {
        background-color: #deebff;
    }

    .fixed_tabs {
        position: fixed;
        top: 135px;
        left: 0;
        z-index: 9;
        margin-bottom: 16px;
    }

    .fixed_tabs_2 {
        position: fixed;
        top: 190px;
        left: 0;
        z-index: 1;
    }

    .mt-30px {
        margin-top: 30px;
    }

    .tbl_head {
        font-size: 22px;
        font-weight: 400;
    }

    /* .mt-34px {
        margin-top: 34px
    } */

    .table-responsive {
        max-height: 400px;
    }

    .filter_btn {
        padding: 8px 21px;
        border: none;
        border-radius: 20px;
    }

    .filter_btn:hover {
        background-color: #257EC9;
        color: #fff;
    }

    .pb-19px {
        padding-bottom: 19px;
    }

    .p-13px {
        padding: 13px !important;
    }

    .p-21px {
        padding: 15px !important;
    }

    .p-30px {
        padding: 30px;
    }

    

    .ms-choice {
        display: block;
        width: 100%;
        height: calc(2.25rem + 2px);
        padding: .375rem 0.75rem;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d3dfea;
        color: #4454c3;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        font-size: 14px;
        line-height: 13px;
    }

    .ms-parent {
        display: inline-block;
        position: relative;
        vertical-align: middle;
        width: 100% !important;
    }

 

 .dropdown-menu.one.show {
    display: block;
    margin: 0;
    width: 400px;
    position: absolute!important;
    margin-left: -186px!important;
    margin-top: -69px!important;
}
.dropdown-menu.two.show {
    display: block;
    margin: 0;
    width: 400px;
    position: absolute!important;
    margin-left: -186px!important;
    margin-top: -119px!important;
}
.dropdown-menu.three.show {
    display: block;
    margin: 0;
    width: 400px;
    position: absolute!important;
    margin-left: -74px!important;
    margin-top: -103px!important;
}
.dropdown-menu.four.show {
    display: block;
    margin: 0;
    width: 400px;
    position: absolute!important;
    margin-left: -186px!important;
    margin-top: -119px!important;
}
.dropdown-menu.five.show {
    display: block;
    margin: 0;
    width: 400px;
    position: absolute!important;
    margin-left: -186px!important;
    margin-top: -139px!important;
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
    }

    .ms-choice span {
        top: 13px;
    }

  

    .p-30px {
        padding: 30px;
    }

 

    .ms-choice {
        display: block;
        width: 100%;
        height: calc(2.25rem + 2px);
        padding: .375rem 0.75rem;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d3dfea;
        color: #4454c3;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        font-size: 14px;
        line-height: 13px;
    }

    .ms-parent {
        display: inline-block;
        position: relative;
        vertical-align: middle;
        width: 100% !important;
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
    }

    .ms-choice span {
        top: 13px;
    }

    .danger {
        color: #fa2428;
    }

    .height-570px {
    min-height: 670px;
}
        .height-717px {
            height: 668px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        #map {
            width: 100%;
            min-height: 618px;
            z-index: 1;
        }

        .map, .chart {
            position: relative;
            padding-top: 0px;
        }

    .mts-34px {
        margin-top: 34px !important;
        /* text-align: right; */
        padding-right: 20px;
    }

    .square {
        height: 25px;
        width: 25px;
        border: 1px solid #2b82cb;
        background-color: #2b82cb;
        border-radius: 3px;
    }

    .square1 {
        height: 25px;
        width: 25px;
        background-color: #2ec774;
        padding: 4px 13px;
        border-radius: 3px;
    }

    .color-prog {
        color: #2b82cb;
    }

    .color-rcih {
        color: #2ec774;
    }

    /* div.relative {
position: relative;
width: 155px;
top: -88px;
height: auto;
background: #fff;
z-index: 999;
} */

    div.absolute {
        position: absolute;
        top: 0;
        right: 0;
        /* background: #ffffff59; */
        background: #ffffff;
        left: 10px;
        padding: 13px;
        opacity: 0.9;
    }

    div.relative {
        position: absolute;
        width: 155px;
        top: 36px;
        right: 36px;
        height: auto;
        background: #e9dbdb;
        z-index: 1;
    }

    div.absolute {
        position: absolute;
        top: 0;
        right: 0;
        /* background: #ffffff59; */
        background: #ffffff;
        left: 10px;
        padding: 13px;
        opacity: 0.9;
    }

    div.relative {
        position: absolute;
        width: 155px;
        top: 36px;
        right: 36px;
        height: auto;
        background: #e9dbdb;
        z-index: 1;
    }

    .fa-download {
        cursor: pointer;
    }
</style>

<style>
    /*download icon css*/
    .amcharts-amexport-menu-level-0.amcharts-amexport-top {
    top: -15px !important;
    }
    .amcharts-amexport-menu-level-0.amcharts-amexport-top:hover {
        cursor: pointer;
    }
    .download_btn{
        padding: 7px 12px;
        background-color: rgb(217, 217, 217);
        border-radius: 4px;
    }
    .download_btn>.fa{
       font-size: 8px;
    }
    .download_btn:hover{
        background-color: #ACACAC;
        cursor: pointer;
    }
    .scrollspy-example {
        position: relative;
        height: 720px;
        overflow: scroll;
        margin-top: 5px;
        transition: width 2s;
    }

    .closebtn {
        padding: 10px !important;
        border-radius: 50px !important;
        height: 30px;
        line-height: 10px;
    }

    .column_left a:hover {
        border: 0px solid #ff4647;
        border-radius: 0px;
        background: #f3f4f7;
        text-align: justify !important;
        color: #000 !important;
    }

    .card_height {
        height: auto;
        margin-top: 40px;
        position: relative;
        top: 70px;
    }

    .card_height2 {
        height: auto;
        margin-top: 40px;
        position: relative;
        /* top: 70px; */
    }

    /* .card_height3 {
        height: auto;
        margin-top: 40px;
        position: relative;
        top: 200px;
    } */

    .card_height3 {
        height: auto;
        margin-top: 43px;
        position: relative;
        top: 20px;
    }

    .min_height {
        top: 0px !important;
        margin-top: 0px;
    }

    .nav-pills .nav-link {
        border-radius: 4px;
        background: #f3f4f7;
        color: #000;
        text-align: justify !important;
    }

    .column_left a {
        border: 1px solid transparent;
        border-radius: 0;
        transition: none;
        background-color: #050c43;
    }

    /* .column_left.active:hover {
            color: #fff !important;
            background-color: #f3f4f7;
        } */

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff !important;
        border-radius: 4px;
        text-align: justify !important;
        background-color: #050c43;
    }

    .column_left>.card {
        height: 700px !important;
        overflow-y: scroll;
        margin-top: 15px;
    }

    .top_tab_fixed {
        position: fixed;
        top: 136px;
        right: 0;
        border-radius: 0px;
        left: 0px;
        z-index: 9999;
    }

    .card-header {
        background: transparent;
        display: -ms-flexbox;
        display: block;
        min-height: auto !important;
        -ms-flex-align: center;
        align-items: center;
        padding: 0.5rem 0.5rem !important;
        margin-bottom: 0;
        /* border-bottom: 1px solid #eff0f6; */
    }

    .card_expand {
        position: fixed;
        top: 200px;
        z-index: 9;
    }

    .icondiv {
        background: #424E77;
        color: #fff !important;
        position: fixed;
        top: 235px;
        left: 12px;
        text-align: center;
        z-index: 10000;
        border-radius: 4px;
        height: 35px;
        width: 35px;
        line-height: 40px;
        background-repeat: no-repeat;
        background-position: center;
        transition: background-color 0.1s linear;
        -moz-transition: background-color 0.1s linear;
        -webkit-transition: background-color 0.1s linear;
        -o-transition: background-color 0.1s linear;
    }

    .m-img {
        /* margin: 0px 0px 5px 4px; */
    }
    .strip_row{
            margin-top: 30px;
        }
    
</style>
<?php if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
?>
    <style type="text/css">
        .strip_row{
            margin-top: -18px !important;
        }
        .mt-34px {
            margin-top: 15px !important;
        }

        .fixed_tabs {
            top: 81px !important;
        }
        
       

        /* .height-570px {
            min-height: 600px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        .height-717px {
            height: 600px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        #map {
            width: 100%;
            height: 500px;
            z-index: 1;
        } */
    </style>
<?php } ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/worldIndiaLow.js"></script>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/kelly.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

<input id="rootUrl" type="hidden" value="<?php echo base_url(); ?>api">
<input id="imgUrl" type="hidden" value="<?php echo base_url(); ?>include/key_highlight/assets/images">

<div class="app-content page-body">
    <div class="container-fluid" id="main-body">
        <div class="row sidebar-container">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card_expand">
                    <div class="icondiv">
                        <!-- <a href="javascript:void(0)" class="float-left"><img src="<?php echo base_url(); ?>include/key_highlight/assets/images/svgs/arrow-right.svg" class="m-img"></a> -->
                        <a href="javascript:void(0)" class="float-left"><img src="<?php echo base_url(); ?>include/key_highlight/assets/images/svgs/left-arrow.png" class="m-img"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card fixed_tabs">
                    <div class="card-body1">
                        <div class=" tab-menu-heading p-0">
                            <div class="tabs-menu1">
                                <ul class="nav panel-tabs">
                                    <li class=""><a class="PO-tab active" data-tabid="0" href="#overview" data-toggle="tab">OVERVIEW 2020-21</a></li>
                                    <li class=""><a class="PO-tab " data-tabid="1" href="#Breeding_modernization" data-toggle="tab"> Breeding modernization, operation & tools</a></li>
                                    <li><a class="PO-tab" data-tabid="2" href="#Communications" data-toggle="tab">Communications</a></li>
                                    <li><a class="PO-tab" data-tabid="3" href="#Client_oriented_seed_systems" data-toggle="tab">Client oriented seed systems</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview">
                        <div class="row strip_row" >
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="card" style="margin-bottom: 0;">
                                    <div class="card-body" style="padding: 12px;">
                                        <h4 >Overview 2020-21 </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-8">
                                <div class="card mt-34px height-570px">
                                    <div class="card-body">
                                        <div class="map" id="map"></div>
                                        <div class="relative">
                                            <div class="absolute">
                                                <div class="d-flex mb-2">
                                                    <div class="square"></div>
                                                    <div class="pl-2 mt-1 color-prog">Program</div>
                                                </div>

                                                <div class="d-flex">
                                                    <div class="square1 pr-2"></div>
                                                    <div class="pl-2 mt-1 color-rcih">RCIHs</div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4">
                                <div class="card mt-34px height-717px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:center;">
                                                <a id="back_button" class="back_button" style="display:none;"><i class='fa fa-arrow-left' aria-hidden='true'></i></a>
                                                <h5 class="ml-10"><strong>Overview</strong></h5>
                                            </div>
                                        </div>
                                        <div class="row" id="program_wise_data_back" style="display: none;">
                                            <div class="col-md-12">
                                                <table class="table table-bordered" style="margin:10px;">
                                                    <tbody>
                                                        <tr>
                                                            <td>Crops:</td>
                                                            <td id="">Common bean, Cowpea, Finger millet, Groundnut, Pearl millet, Sorghum</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Partners:</td>
                                                            <td id=""><b>NARS</b>: Council for Scientific and Industrial Research (CSIR),
                                                                Environmental Institute for Agricultural Research (INERA),
                                                                Ethiopian Institute of Agricultural Research (EIAR),
                                                                Institute for Agricultural Research (IAR),
                                                                Institute of Rural Economy (IER),
                                                                National Agricultural Research Organisation (NARO),
                                                                Tanzania Agricultural Research Institute (TARI) <br><b>CGIAR</b>: CIAT, ICRISAT, IITA <br>SFSA
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" id="rcih_wise_data_back" style="display: none;">
                                            <div class="col-md-12">
                                                <table class="table table-bordered" style="margin:10px;">
                                                    <tbody>
                                                        <tr>
                                                            <td>RCIH(s):</td>
                                                            <td id="">Bamako-Mali, Bulawayo-Zimbabwe, Kano-Nigeria, Kawanda-Uganda</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Organizations:</td>
                                                            <td id="">CIAT, ICRISAT, IITA</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" id="program_wise_data">
                                            <div class="col-md-12">
                                                <!-- <h5 class="mt-20 ml-10">
                                                    <strong>map_partners</strong></h5>
                                                <h6 class="ml-10" id="map_crops"></h6>
                                                <hr class="new4">
                                                <h5 class="ml-10"><strong>Partners</strong>
                                                </h5>
                                                <h6 class="ml-10" id="map_partners"></h6> -->
                                                <table class="table table-bordered" style="margin:10px;">
                                                    <tbody>
                                                        <!-- <tr>
                                                            <td colspan="2">
                                                                <h3 class="text-center tbl_head">
                                                                    Program(s) </h3>
                                                            </td>
                                                        </tr> -->
                                                        <tr>
                                                            <td>Crops:</td>
                                                            <!-- <td id="map_crops">Cowpea, Groundnut, Non-crop Specific, Pearl millet, Sorghum, Common bean, Finger millet</td> -->
                                                            <td id="map_crops">Common bean, Cowpea, Finger millet, Groundnut, Pearl millet, Sorghum</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Partners:</td>
                                                            <!-- <td id="map_partners">NARS: Institute of Rural Economy (IER), Environmental Institute for Agricultural Research (INERA), Council for Scientific and Industrial Research (CSIR), Institute for Agricultural Research (IAR), Ethiopian Institute of Agricultural Research (EIAR), National Agricultural Research Organisation (NARO), Tanzania Agricultural Research Institute (TARI)<br>CGIAR: CIAT, ICRISAT <br>SFSA</td> -->
                                                            <td id="map_partners"><b>NARS</b>: Council for Scientific and Industrial Research (CSIR),
                                                                Environmental Institute for Agricultural Research (INERA),
                                                                Ethiopian Institute of Agricultural Research (EIAR),
                                                                Institute for Agricultural Research (IAR),
                                                                Institute of Rural Economy (IER),
                                                                National Agricultural Research Organisation (NARO),
                                                                Tanzania Agricultural Research Institute (TARI) <br><b>CGIAR</b>: CIAT, ICRISAT, IITA <br>SFSA</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="program_indicaters"></div>
                                        </div>
                                        <div class="row" id="rcih_wise_data">
                                            <div class="col-md-12">
                                                <table class="table table-bordered" style="margin:10px;">
                                                    <tbody>
                                                        <!-- <tr>
                                                            <td colspan="2">
                                                                <h3 class="text-center tbl_head">
                                                                    RCIH(s) <span id="rcih_name"></span>
                                                                </h3>
                                                            </td>
                                                        </tr> -->
                                                        <tr>
                                                            <td>RCIH(s):</td>
                                                            <td id="rcih_location">Bamako-Mali, Bulawayo-Zimbabwe, Kano-Nigeria, Kawanda-Uganda</td>
                                                            <!-- <td id="rcih_location">Bamako, Bulawayo, Kano, Kwanda</td> -->
                                                        </tr>
                                                        <tr>
                                                            <td>Organizations:</td>
                                                            <!-- <td id="rcih_organization">ICRISAT, IITA, CIAT</td> -->
                                                            <td id="rcih_organization">CIAT, ICRISAT, IITA</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="rcih_indicaters"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="Breeding_modernization">
                        <div class="row strip_row" >
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="card" style="margin-bottom: 0;">
                                    <div class="card-body" style="padding: 12px;">
                                        <h4 >Breeding modernization, operation & tools </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                <div class="column_left" id="spy">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0)" class="closebtn float-right p-1 bg-light text-danger">&times;</a>
                                        </div>
                                        <div class="card-body p-2">
                                            <ul class="nav nav-pills flex-column">
                                                <!-- <li class="nav-item mb-2"><a class="nav-link opnavlink active" data-containerid="#scroll0" data-containerclass=".bmot_card" href="#scroll0">
                                                        <strong><i class="fa fa-caret-right"></i> Output
                                                            1.1.1:
                                                            High throughput platforms developed for
                                                            efficient
                                                            phenotyping for grain quality and for
                                                            resistance
                                                            to
                                                            biotic and resilience to abiotic
                                                            stresses</strong>
                                                    </a></li> -->
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink active" data-containerid="#scroll1" data-containerclass=".bmot_card" href="#scroll1">
                                                        <strong><i class="fa fa-caret-right"></i> Output
                                                            1.1.2:
                                                            High throughput platforms developed for
                                                            efficient
                                                            phenotyping for grain quality and for
                                                            resistance
                                                            to
                                                            biotic and resilience to abiotic
                                                            stresses</strong>
                                                    </a></li>
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll2" data-containerclass=".bmot_card" href="#scroll2">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output
                                                            1.1.3: Rapid cycle breeding methods and
                                                            technologies implemented at the RCIHs to
                                                            significantly shorten breeding
                                                            cycles</strong>
                                                    </a></li>
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll3" data-containerclass=".bmot_card" href="#scroll3">
                                                        <strong><i class="fa fa-caret-right"></i> Output
                                                            1.2.1: Multi-location yield trial networks
                                                            built with common checks and market traits
                                                            relevant
                                                            to the predefined PPs, including
                                                            environmental
                                                            data
                                                            to provide context</strong>
                                                    </a></li>
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll4" data-containerclass=".bmot_card" href="#scroll4">
                                                        <strong><i class="fa fa-caret-right"></i>
                                                            Output 2.1.1: Breeding operations at CGIAR
                                                            research
                                                            stations and NARS partners digitized to
                                                            improve
                                                            breeding efficiency
                                                        </strong>
                                                    </a></li>

                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll5" data-containerclass=".bmot_card" href="#scroll5">
                                                        <strong><i class="fa fa-caret-right"></i>
                                                            Output 2.1.4 Streamlined digital seed
                                                            inventory
                                                            system and breeding program established and
                                                            used
                                                            in
                                                            real-time
                                                        </strong>
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9 scrollspy-example" data-spy="scroll" data-target="#spy">
                                <!-- <div id="scroll0" class="mt-3 bmot_card">
                                    <div class="item">
                                        <div class="card card_height2 min_height">
                                            <div class="card-body">
                                                <h4> Output 1.1.1: Spill Over Map</h4>
                                                <hr>

												<div class="row">
												<div class="col-sm-12 col-md-12 col-lg-12">
													<div id="spill_map" style="width: 100%; height:500px">
													</div>
												</div>
												</div>
                                               
                                                <!-- <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-40px">Indicator #1.4: Number of high throughput platforms developed for efficient phenotyping : <font style="color: green;" id="phenotypingCount">
                                                            </font>
                                                        </h4>
                                                        <div class="card" style="height: 500px;">
                                                            <div class="d-flex justify-content-end mt-4 mr-4">
                                                                <div class="mr-4">
                                                                    <a id="dwn-csv-12"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="example table-responsive p-0">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div id="scroll1" class="mt-3 bmot_card">
                                    <div class="item">
                                        <div class="card card_height2 min_height">
                                            <div class="card-body">
                                                <h4> Output 1.1.2: High throughput platforms developed
                                                    for efficient phenotyping for grain quality and for
                                                    resistance to biotic and resilience to abiotic
                                                    stresses</h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-15px">Indicator #1.4: Number of high throughput platforms developed for efficient phenotyping : <font style="color: green;" id="phenotypingCount">
                                                            </font>
                                                        </h4>
                                                        <div class="card" style="height: 500px;">
                                                            <div class="d-flex justify-content-end mt-4 mr-4">
                                                                <div class="mr-4">
                                                                    <!-- <a id="dwn-csv-12"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a> -->
                                                                    <a id="dwn-csv-12" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="example table-responsive p-0">
                                                                    <table class="table table-bordered" id="resultpo12">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">
                                                                                Country
                                                                                </th>
                                                                                <th class="text-center">
                                                                                    Crop
                                                                                </th>
                                                                                <th class="text-center">
                                                                                    Name of the platform
                                                                                </th>
                                                                                <th class="text-center">
                                                                                    Location of deployment </th>
                                                                                <th class="text-center">
                                                                                    Location of development</th>
                                                                                <th class="text-center">
                                                                                    Number of samples processed <br> before the facility was established
                                                                                </th>
                                                                                <th>
                                                                                    Number of samples after the facility was established
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-40px">Indicator #1.8: Number of diagnostic markers for target traits developed in this year (country-wise) : <font style="color: green;" id="country_wise_diagnostic_graph_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="country_wise_diagnostic_graph" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-40px">Indicator #1.9: Number of marker assays available to breeding programs and seed companies (country-wise) : <font style="color: green;" id="marker_assey_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="marker_assey_graph" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-40px">Indicator #1.10: Number of QTLs validated and converted into usable markers (country-wise) : <font style="color: green;" id="marker_qtl_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="marker_qtl_graph" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="scroll2" class="mt-3 bmot_card">
                                    <div class="item">
                                        <div class="card card_height3">
                                            <div class="card-body">
                                                <h4>
                                                    Output 1.1.3: Rapid cycle breeding methods and
                                                    technologies implemented at the RCIHs to
                                                    significantly shorten breeding cycles
                                                </h4>
                                                <hr>
                                                <!-- <h4>Indicators</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Indicator #1.5: Number
                                                        of protocols developed for rapid cycle breeding
                                                    </li>
                                                    <li class="list-group-item">Indicator #1.6: Number
                                                        of generations achieved this year</li>
                                                    <li class="list-group-item">Indicator #1.7: Number
                                                        of fixed lines developed this year</li>
                                                    <li class="list-group-item">Indicator #1.11: Number
                                                        of breeding lines exchanged between breeding
                                                        programs</li>
                                                    <li class="list-group-item">Indicator #1.12: Number
                                                        of lines/hybrids submitted to NPT/DUS</li>
                                                    <li class="list-group-item">Indicator #1.13: Number
                                                        of hybrid/ OPV/ SPV varieties released</li>
                                                </ul> -->
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Indicator #1.5: Number of protocols developed (country-wise) : <font style="color: green;" id="protocols_developed_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="program_wise_graph_one" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="d-inline-block h4-20px">Indicator #1.6: Number of generations achieved this year (country-wise) : <font style="color: green;" id="generationsachieved_count">
                                                            </font>
                                                            <span class="toogle-tooltip">
                                                                <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                                <div class="dropdown-menu one bg-info">
                                                                    <div class="tooltip-header">
                                                                        <div class="tooltip-header-title">
                                                                            <span class="text-light">
                                                                                <ul class="p-2 mb-0">
                                                                                <li class="cross">×</li>
                                                                                <li>25 programs were able to achieve their targets.</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="program_wise_graph_two" style="width: 100%; height: 450px;">
                                                                </div>
                                                                <p><b>Line</b> - Target value / <span><b>Bar</b> - Actual value</span></p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Indicator #1.7: Number of fixed lines
                                                            developed (country-wise) : <font style="color: green;" id="fixedlines_developed_count">
                                                            </font>

                                                            <span class="toogle-tooltip">
                                                                <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                                <div class="dropdown-menu three bg-info">
                                                                    <div class="tooltip-header">
                                                                        <div class="tooltip-header-title">
                                                                            <span class="text-light">
                                                                                <ul class="p-2 mb-0">
                                                                                    <li class="cross">×</li>
                                                                                    <li>Highest number of fixed lines were developed by IITA (for Cowpea) followed by ICRISAT (for Groundnut) and CIAT (for Common bean).</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>

                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="program_wise_graph_three" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <!-- <h4 class="h4-40px">Indicator #1.7: Number of fixed lines
                                                            developed (crop-wise) : <font style="color: green;" id="crop_wise_developed_count">
                                                            </font>
                                                        </h4> -->
                                                        <h4 class="h4-20px">Indicator #1.7: Number of fixed lines
                                                            developed (crop-wise)
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="crop_wise_graph_three" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-40px">Indicator #1.8: Number of diagnostic markers for target traits developed in this year (country-wise) : <font style="color: green;" id="country_wise_diagnostic_graph_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="country_wise_diagnostic_graph" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-40px">Indicator #1.9: Number of marker assays available to breeding programs and seed companies (country-wise) : <font style="color: green;" id="marker_assey_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="marker_assey_graph" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Indicator #1.10: Number of QTLs validated and converted into usable markers (country-wise) : <font style="color: green;" id="marker_qtl_count">
                                                            </font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="marker_qtl_graph" style="width: 100%; height: 550px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12 col-lg-12">

                                                        <h4 class="h4-20px">Indicator #1.11: Number of breeding lines exchanged between breeding programs (country-wise) : <font style="color: green;" id="breedinglines_exchanged_count"></font>

                                                            <span class="toogle-tooltip">
                                                                <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                                <div class="dropdown-menu two bg-info">
                                                                    <div class="tooltip-header">
                                                                        <div class="tooltip-header-title">
                                                                            <span class="text-light">
                                                                                <ul class="p-2 mb-0">
                                                                                     <li class="cross">×</li>
                                                                                    <li>2298 breeding lines were exchanged by Mali (for Groundnut) followed by ICRISAT (for Pearl millet) and ICRISAT (for Sorghum).</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="program_wise_graph_four" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <!-- <h4 class="h4-20px">Indicator #1.11: Number of breeding lines exchanged between breeding programs (crop-wise) -->
                                                        <h4 class="h4-20px">Number of breeding lines exchanged between breeding programs (crop-wise)
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="crop_wise_graph_four" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <h4 class="h4-20px">Spatial distribution depicting exchange of breeding lines across countries</h4>
                                                        <p class="nt_style"><i>Note: The direction of the arrow is outwards or inwards represents whether the country has given or received the breeding lines respectively</i></p>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <!-- <div class="row">
                                                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                                                        <select class="form-control" id="map-country-crop-selector"></select>
                                                                    </div>
                                                                </div> -->
                                                                <div id="spill_map" style="width: 100%; height: 450px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 >Indicator #1.12: Number of lines/hybrids submitted to NPT/DUS : <font style="color: green;" id="npd_data_sum">
                                                            </font>
                                                            <span class="toogle-tooltip">
                                                                <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                                <div class="dropdown-menu two bg-info">
                                                                    <div class="tooltip-header">
                                                                        <div class="tooltip-header-title">
                                                                            <span class="text-light">
                                                                                <ul class="p-2 mb-0">
                                                                                    <li class="cross">×</li>
                                                                                    <li>IITA (for Cowpea) submitted the most number of lines to NPT/DUS followed very closely by Nigeria (for Groundnut) and Burkina Faso (for Pearl millet).</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="card p-10">
                                                                    <div class="card-body p-21px">
                                                                        <h5>Total Number of lines/ hybrids
                                                                            submitted to
                                                                            NPT : <font style="color: green;" id="npd_data_count">
                                                                            </font>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card p-10">
                                                                    <div class="card-body p-21px">
                                                                        <h5>Total Number of lines/ hybrids
                                                                            submitted to
                                                                            DUS : <font style="color: green;" id="dus_total"></font>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <h4 class="h4-20px">Number of lines/hybrids submitted to NPT/DUS (Country-wise)</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="npt_dus_country" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <h4 class="h4-20px">Number of lines/hybrids submitted to NPT/DUS (Crop-wise)</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="npt_dus_crop" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                                        <h4>Indicator #1.13: Number of hybrid/ OPV/ SPV varieties released : <font style="color: green;" id="total_1">
                                                            </font>
                                                            <span class="toogle-tooltip">
                                                                <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                                <div class="dropdown-menu two bg-info">
                                                                    <div class="tooltip-header">
                                                                        <div class="tooltip-header-title">
                                                                            <span class="text-light">
                                                                                <ul class="p-2 mb-0">
                                                                                    <li class="cross">×</li>
                                                                                    <li>a. A total of 12 varieties were released, out of which 6 were OPV and 6 were SPV.
                                                                                    </li>
                                                                                    <li>b. None of the released varieties was a hybrid.</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>


                                                        </h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="card p-10">
                                                                    <div class="card-body p-15px">
                                                                        <h5>Hybrid : <font style="color: green;" id="hybrid"></font>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="card p-10">
                                                                    <div class="card-body p-15px">
                                                                        <h5>OPV : <font style="color: green;" id="opv"></font>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="card p-10">
                                                                    <div class="card-body p-15px">
                                                                        <h5>SPV : <font style="color: green;" id="spv"></font>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-lg-6 col-sm-12">
                                                                                <h4 class="h4-20px">Number of varieties released (country-wise)</h4>
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <div id="program_varietyreleased" style="width: 100%; height: 450px;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-6 col-sm-12">
                                                                                <h4 class="h4-20px">Program X Varieties - Hybrid/ OPV/ SPV released</h4>
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <div id="program_traits_hybrid_opv_spv" style="width: 100%; height: 450px;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                                                <h4 class="h4-20px">Program-wise mapping of variety name with the
                                                                                    variety
                                                                                    targeted to be replaced</h4>
                                                                                <div class="card" style="height: 500px;">
                                                                                    <div class="d-flex justify-content-end mt-4 mr-4">
                                                                                        <div class="mr-4">
                                                                                            <a id="dwn-csv-1" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div class="example table-responsive p-0">
                                                                                            <table class="table table-bordered" id="result">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th class="text-center" data-field="countryname">
                                                                                                            Country
                                                                                                        </th>
                                                                                                        <th class="text-center" data-field="cropname">
                                                                                                            Crop</th>
                                                                                                        <th class="text-center" data-field="varietyname">
                                                                                                            Name of
                                                                                                            the variety</th>
                                                                                                        <th class="text-center" data-field="targetvariety">
                                                                                                            Name
                                                                                                            of variety targeted
                                                                                                            <br>for
                                                                                                            replacement
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                                                        <h4 class="h4-20px">Comparative representation of yield for the variety released</h4>
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div id="programwise_onstation_onfarm_yield" style="width: 100%; height: 450px;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="scroll3" class="mt-3 bmot_card">
                                    <div class="item">
                                        <div class="card card_height3">
                                            <div class="card-body">
                                                <h4>
                                                    Output 1.2.1: Multi-location yield trial networks
                                                    built with common checks and market traits relevant
                                                    to the predefined PPs, including environmental data
                                                    to provide context
                                                </h4>
                                                <hr>
                                                <!-- <h4>Indicators</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Indicator #1.20: Number
                                                        of trials conducted under multi-locational yield
                                                        trialing networks</li>
                                                </ul> -->
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Indicator #1.20: Number of multi- locational trials conducted (country-wise) : <font style="color: green;" id="program_wise_multi_locational_trials_count"></font>
                                                            <span class="toogle-tooltip">
                                                                <a href="javascript:void(0);" data-toggle="dropdown" data-placement="top" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                                <div class="dropdown-menu two bg-info">
                                                                    <div class="tooltip-header">
                                                                        <div class="tooltip-header-title">
                                                                            <span class="text-light">
                                                                                <ul class="p-2 mb-0">
                                                                                    <li class="cross">×</li>
                                                                                    <li>a. Tanzania (for Common bean) conducted the most number of multi-locational trials whereas many of the programs conducted just 1 or 2 trials.</li>
                                                                                    <li>b. Over 93% trials were conducted by researchers.</li>
                                                                                </ul>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="program_wise_multi_locational_trials" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Trials categorized by who managed them</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="managed_by_multi_locational_trials" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Number of trials conducted geographical scope-wise
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="geographical_scope_wise_graph" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <h4 class="h4-20px">Comparing the CV% value of the yields for the trials conducted
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="cv_graph" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <h4 class="h4-20px">Comparing the heritability value of the yields for the trials conducted
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="heritability_graph" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Number of locations where the multi-locational trials were conducted (country-wise)
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="location_radial_graph" style="width: 100%; height: 1000px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-40px">Number of locations where the multi-locational trials were conducted (country-wise)
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="location_radar_graph" style="width: 100%; height: 750px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll4" class="mt-3 bmot_card">
                                    <div class="item">
                                        <div class="card card_height3">
                                            <div class="card-body">
                                                <h4>
                                                    Output 2.1.1: Breeding operations at CGIAR research
                                                    stations and NARS partners digitized to improve
                                                    breeding efficiency
                                                </h4>
                                                <hr>
                                                <!-- <h4>Indicators</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Indicator #2.1: Progress
                                                        made towards digitization of the breeding
                                                        program (%) </li>

                                                    <li class="list-group-item">Indicator #2.2: Progress
                                                        made in completing SOPs (%)</li>
                                                </ul> -->
                                                <div class="row">
                                                    <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="text-primary">Breeding operations </h4>
                                                        <hr>
                                                    </div> -->
                                                    <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4></h4>
                                                    </div> -->
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Indicator #2.1: Nurseries established in the field and greenhouse (country-wise)</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="programwise_bmsinfo" style="height: 450px;width: 100%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Trials established in the field and greenhouse (country-wise)</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="programwise_trials_greenhouse" style="height: 450px;width: 100%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <!-- <h4 class="h4-40px">Indicator #2.2: Progress made in completing SOPs (PYT/AYT/MLT/PVS/Nurseries) : <font style="color: green;" id="programwise_sop_count"></font></h4> -->
                                                        <h4 class="h4-20px">Indicator #2.2: Progress made in completing SOPs (%): <font style="color: green;" id="programwise_sop_count"></font>
                                                        </h4>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <!-- <h4>Program-wise- PYT</h4> -->
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="programwise_sop_pyt" style="height: 450px;width: 100%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll5" class="mt-3 bmot_card">
                                    <div class="item">
                                        <div class="card card_height2">
                                            <div class="card-body">
                                                <h4>
                                                    Output 2.1.4 Streamlined digital seed inventory
                                                    system and breeding program established and used in
                                                    real-time
                                                </h4>
                                                <hr>
                                                <!-- <h4>Indicators</h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Indicator #2.5: Number
                                                        of trials in BMS", "value</li>
                                                </ul> -->
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Indicator #2.5: Number of trials in BMS (country-wise): <font style="color: green;" id="programwise_bms_count"></font>
                                                        </h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div id="programwise_bms" style="height: 450px;width: 100%">
                                                                </div>
                                                                <!-- <p>Line - Target value <span>Bar - Actual value</span></p> -->
                                                                <p><b>Line</b> - Target value / <span><b>Bar</b> - Actual value</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="Communications">
                        <div class="row strip_row" >
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="card" style="margin-bottom: 0;">
                                    <div class="card-body" style="padding: 12px;">
                                        <h4 >Communications </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="column_left" id="spy1">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0)" class="closebtn float-right p-1 bg-light text-danger" onclick="closeNav()">&times;</a>
                                        </div>
                                        <div class="card-body p-2">
                                            <ul class="nav nav-pills flex-column">
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink active" data-containerid="#scroll6" data-containerclass=".comm_card" href="#scroll6">
                                                        <strong><i class="fa fa-caret-right"></i> Output
                                                            1.1.6:
                                                            Adoption of new tools and approaches
                                                            increased
                                                            through a concerted multi-pronged
                                                            communication
                                                            approach</strong>
                                                    </a></li>
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll7" data-containerclass=".comm_card" href="#scroll7">
                                                        <strong><i class="fa fa-caret-right"></i>
                                                            Output 2.1.6: Project partners and other
                                                            stakeholders engaged through effective
                                                            advocacy
                                                            and
                                                            innovative communication approaches
                                                        </strong>
                                                    </a>
                                                </li>

                                                 <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll8" data-containerclass=".comm_card" href="#scroll8">
                                                        <strong><i class="fa fa-caret-right"></i>
                                                            Output 4.2.2: Client-oriented channels leveraged to create awareness and generate demand for good quality seed 
                                                        </strong>
                                                </a></li>

                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll9" data-containerclass=".comm_card" href="#scroll9">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output 5.1.2. Effective Communication of
                                                            Project
                                                            Progress, Achievements and Impact
                                                        </strong>
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9  scrollspy-example" data-spy="scroll" data-target="#spy1">
                                <div id="scroll6" class="mt-3 comm_card">
                                    <div class="card card_height min_height">
                                        <div class="card-body">
                                            <h4> Output 1.1.6: Adoption of new tools and approaches
                                                increased through a concerted multi-pronged
                                                communication approach</h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-6">
                                                    <h4 class="h4-40px">Indicator #1.17: New tools and approaches adopted as a result of innovative communication
                                                        approaches (country-wise): <font style="color: green;" id="program_wise_new_tools_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="program_wise_new_tools" style="width: 100%; height: 450px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12 col-lg-6 col-sm-12">
                                                    <h4 class="h4-40px">Indicator #1.18: Number of communication approaches developed and used to popularize the new
                                                        tools among NARS and CGIAR, as well as other stakeholders (country-wise) : <font style="color: green;" id="program_wise_no_of_communication_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="program_wise_no_of_communication" style="width: 100%; height: 450px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="scroll7" class="mt-3 comm_card">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 2.1.6: Project partners and other
                                                stakeholders engaged through effective advocacy and
                                                innovative communication approaches
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4> -->
                                            <!-- <ul class="list-group">
                                                <li class="list-group-item">Indicator #2.9: Number
                                                    of advocacy tools developed and shared with
                                                    policy makers, NARS & CGIAR stakeholders</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <h4 class="h4-40px">Indicator #2.9: Number of advocacy tools developed and shared with policy makers, NARS & CGIAR stakeholders (country-wise): <font style="color: green;" id="advocacy_tools_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="programwise_advocacy_tools" style="height: 400px;width: 100%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <!-- <h4 class="h4-40px">Indicator #2.9: List of advocacy tools developed and shared</h4> -->
                                                    <h4 class="h4-40px">List of advocacy tools developed and shared</h4>
                                                    <div class="card" style="width: 100%; height: auto;">
                                                        <div class="d-flex justify-content-end mt-4 mr-4">
                                                            <div class="mr-4">
                                                                <a id="dwn-csv-22" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="example table-responsive p-0" style="width: 100%; height: 355px;">
                                                                <table class="table table-bordered" id="resultpo2">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" data-field="countryname">
                                                                                Country
                                                                            </th>
                                                                            <th class="text-center" data-field="cropname">
                                                                                Crop</th>
                                                                            <th class="text-center" data-field="varietyname">
                                                                                Name of the advocacy tools</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll8" class="mt-3 comm_card">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.2.2: Client-oriented channels leveraged to create awareness and generate demand for good quality seed 
                                            </h4>
                                            <hr>

                                            <!-- <h3>Indicators</h3> -->
                                            <!-- <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.19: Percent of farmers aware of the prioritized and commercialized varieties and promoted technologies</li>
                                                <li class="list-group-item">Indicator #4.20: Number of lobbying/communication tools developed to create awareness and generate demand for good quality seed</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <h4 class="h4-40px">Indicator #4.20: Number of lobbying/communication tools developed to create awareness and generate demand for good quality seed (country-wise) : <font style="color: green;" id="Program_wise_no_of_lobbying_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="Program_wise_no_of_lobbying" style="width: 100%; height: 450px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <!-- <h4 class="h4-40px">Communication tools</h4> -->
                                                    <h4 class="h4-40px">List of the lobbying/communication tools developed</h4>
                                                    <div class="card">
                                                        <div class="d-flex justify-content-end mt-4 mr-4">
                                                            <div class="mr-4">
                                                                <a id="dwn-csv-9" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <!-- <div id="rcih_wise_no_of_lobbying"
                                                                style="width: 100%; height: 450px;"></div> -->
                                                            <div class="example table-responsive p-0" style="width: 100%; height: 450px;">
                                                                <table class="table table-bordered" id="resultpo4">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" data-field="countryname">
                                                                                Country
                                                                            </th>
                                                                            <th class="text-center">
                                                                                Crop</th>
                                                                            <th class="text-center">
                                                                                Name of lobbying/communication tools</th>
                                                                            <!-- <th class="text-center" >
                                                                                Type of lobbying/communication tools</th> -->
                                                                            <th class="text-center">Links</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>


                                <div id="scroll9" class="mt-3 comm_card">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 5.1.2. Effective Communication of Project
                                                Progress, Achievements and Impact
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4> -->
                                            <!-- <ul class="list-group">
                                                <li class="list-group-item">Indicator #5.7: Number
                                                    
                                                    effective communication approaches</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <h4 class="h4-40px">Indicator #5.7: Number of success and impact stories disseminated using effective communication approaches (country-wise) : <font style="color: green;" id="program_wise_number_of_success_and_impact_stories_count"></font> </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="program_wise_number_of_success_and_impact_stories" style="width: 100%; height: 450px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <h4 class="h4-40px">List of the success and impact stories disseminated</h4>
                                                    <div class="card">
                                                        <div class="d-flex justify-content-end mt-4 mr-4">
                                                            <div class="mr-4">
                                                                <a id="dwn-csv-10" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="example table-responsive p-0" style="width: 100%; height: 450px;">
                                                                <table class="table table-bordered" id="resultpo5">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" data-field="country">
                                                                                Country
                                                                            </th>
                                                                            <th class="text-center" data-field="crop">
                                                                                Crop</th>
                                                                            <th class="text-center" data-field="name">
                                                                                Name of success and impact stories</th>
                                                                            <th class="text-center" data-field="name">
                                                                                Type of communication approache used</th>
                                                                            <th class="text-center" data-field="name">
                                                                                Links</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="Client_oriented_seed_systems">
                        <div class="row strip_row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="card" style="margin-bottom: 0;">
                                    <div class="card-body" style="padding: 12px;">
                                        <h4 >Client oriented seed systems </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="column_left" id="spy2">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0)" class="closebtn float-right p-1 bg-light text-danger" onclick="closeNav()">&times;</a>
                                        </div>
                                        <div class="card-body p-2">
                                            <ul class="nav nav-pills flex-column">
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink active" data-containerid="#scroll10" data-containerclass=".coss_card" href="#scroll10">
                                                        <strong><i class="fa fa-caret-right"></i> Output
                                                            3.1.6:
                                                            Behavior change interventions designed to
                                                            incentivize choice of improved varieties and
                                                            quality
                                                            seed of cereals and legumes in place of
                                                            ‘informal
                                                            sources’ among rural women users</strong>
                                                    </a></li>
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll11" data-containerclass=".coss_card" href="#scroll11">
                                                        <strong><i class="fa fa-caret-right"></i> Output
                                                            4.1.1:
                                                            Product advancement criteria and process to
                                                            prioritize varieties for commercialization
                                                            established and standardized based on
                                                            extensive
                                                            on-farm testing systems, demonstrations and
                                                            exhibitions
                                                        </strong>
                                                    </a></li>
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll112" data-containerclass=".coss_card" href="#scroll12">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output 4.1.2: Innovative and transformative
                                                            models
                                                            for accessing, multiplying and disseminating
                                                            public-bred varieties developed and promoted
                                                            by
                                                            scaling up seed enterprises
                                                        </strong>
                                                    </a>
                                                </li>
                                               
                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerclass=".coss_card" data-containerid="#scroll13" href="#scroll13">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output 4.1.3 New models of EGS (breeder and
                                                            foundation) and certified/QDS seed
                                                            production
                                                            leveraged through demand-led public and
                                                            private
                                                            partnerships
                                                        </strong>
                                                    </a></li>

                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerclass=".coss_card" data-containerid="#scroll14" href="#scroll14">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output 4.2.1: Quality seed of improved
                                                            varieties
                                                            bundled with complementary technologies and
                                                            services
                                                            (seed dressing, finance, insurance,
                                                            agro-inputs)
                                                            to
                                                            enhance commercialization and uptake of
                                                            improved
                                                            varieties and profitability of seed
                                                            entrepreneurs
                                                        </strong>
                                                    </a></li>

                                                    <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerid="#scroll15" data-containerclass=".coss_card" href="#scroll15">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                        Output 4.2.2: Client-oriented channels leveraged to create awareness and generate demand for good quality seed 
                                                        </strong>
                                                    </a>
                                                </li>

                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerclass=".coss_card" data-containerid="#scroll16" href="#scroll16">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output 4.3.2 User-friendly tools on
                                                            profitability of
                                                            different classes of seed and varieties and
                                                            complementary technologies developed and
                                                            shared
                                                            with
                                                            key value chain actors
                                                        </strong>
                                                    </a></li>

                                                <li class="nav-item mb-2"><a class="nav-link opnavlink" data-containerclass=".coss_card" data-containerid="#scroll17" href="#scroll17">
                                                        <strong> <i class="fa fa-caret-right"></i>
                                                            Output 4.3.3 Partnerships to
                                                            institutionalize
                                                            and
                                                            operationalize digital seed roadmaps
                                                            responsive
                                                            to
                                                            commodity market developed
                                                        </strong>
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 scrollspy-example" data-spy="scroll" data-target="#spy2">
                                <div id="scroll10" class="mt-3">
                                    <div class="card card_height min_height">
                                        <div class="card-body">
                                            <h4> Output 3.1.6: Behavior change interventions
                                                designed to incentivize choice of improved varieties
                                                and quality seed of cereals and legumes in place of
                                                ‘informal sources’ among rural women users</h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #3.9: Percent
                                                    women and youth buying high quality seed of
                                                    improved varieties from different sources</li>

                                                <li class="list-group-item">Indicator #3.10: Average
                                                    number of seasons that women and youth farmers
                                                    recycle their seed before replacing it</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <h4 class="h4-40px">Indicator #3.9: Percent women and youth buying high quality seed of improved varieties from different sources (country-wise) : <font style="color: green;" id="percent_of_women_and_youth_quantity_seed_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="" id="percent_of_women_and_youth_quantity_seed" style="width: 100%;height: 500px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <h4 class="h4-40px">List of the various sources from where the high quality seed of improved varieties are bought</h4>
                                                    <div class="card" style="width: 100%; height: 544px;">
                                                        <div class="d-flex justify-content-end mt-4 mr-4">
                                                            <div class="mr-4">
                                                                <a id="dwn-csv-32" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="example table-responsive p-0" style="width: 100%; height: 500px;">
                                                                <table class="table table-bordered" id="resultpo32">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" data-field="countryname">
                                                                                Country
                                                                            </th>
                                                                            <th class="text-center" data-field="cropname">
                                                                                Crop</th>
                                                                            <th class="text-center" data-field="varietyname">
                                                                                Name of the source</th>
                                                                            <th class="text-center" data-field="varietyname">
                                                                                Type of the source</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #3.10: Average number of seasons that women and youth farmers recycle their seed before replacing it (country-wise) : <font style="color: green;" id="percent_of_women_and_youth_farmer_recycle_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="" id="percent_of_women_and_youth_farmer_recycle" style="width: 100%;height: 500px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll11" class="mt-3">
                                    <div class="card card_height2 ">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.1.1: Product advancement criteria and
                                                process to prioritize varieties for
                                                commercialization established and standardized based
                                                on extensive on-farm testing systems, demonstrations
                                                and exhibitions
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.3: Number
                                                    of demonstrations conducted</li>
                                                <li class="list-group-item">Indicator #4.4: Number
                                                    of field days conducted</li>
                                                <li class="list-group-item">Indicator #4.5: Number
                                                    of seed fairs/agriculture shows conducted</li>
                                                <li class="list-group-item">Indicator #4.6:Number of
                                                    radio/ TV shows facilitated/conducted</li>
                                                <li class="list-group-item">Indicator #4.7: Number
                                                    of small seed packs distributed/sold</li>
                                                <li class="list-group-item">Indicator #4.9: Number
                                                    of farmers reached through technology awareness
                                                    creation models</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.3: Number of demonstrations conducted (country-wise):
                                                        <font style="color: green;" id="demos_conducted_count">
                                                        </font>
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu four bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                                <li class="cross">×</li>
                                                                                <li>a. Highest number of demonstrations were held in Tanzania (for Common beans) and IITA (for Cowpea).</li>
                                                                                <li>b. Of the 941 demos, 67% were hosted by farmers, followed by farmer groups and Seed companies.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>

                                                    </h4>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <!-- <h4 class="h4-20px">Number of demonstrations conducted (country-wise) </h4> -->
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_demonstrationsconducted" style="width: 100%;height: 410px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <!-- <h4 class="h4-20px">Number of demonstrations conducted (crop-wise) </h4> -->
                                                            <div class="card">
                                                                <div class="card-body p-5">
                                                                    <div class="" id="crop_wise_demonstrationsconducted" style="width: 100%;height: 410px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <!-- <h4 class="h4-40px">Program-wise Demos conducted by different hosts </h4> -->
                                                            <h4 class="h4-20px">Demos conducted by different hosts </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="hostedby_array" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <h4 class="h4-20px">Demos conducted by farmers gender disaggregated (country-wise)</h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="demonstrationsconducted_country" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.4: Number of field days conducted (country-wise): <font style="color: green;" id="fielddays_conducted_count"></font>
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu two bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                                <li class="cross">×</li>
                                                                                <li>Nigeria- Cowpea program has conducted the most number of field days. All the other programs have conducted almost the same number of field days.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <!-- <h4 class="h4-20px">Number of field days conducted (country-wise) </h4> -->
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_fielddaysconducted" style="width: 100%;height: 410px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            <!-- <h4 class="h4-20px">Number of field days conducted (crop-wise) </h4> -->
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="rcih_wise_fielddaysconducted" style="width: 100%;height: 410px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Farmers participated in field days disaggregated by gender (country-wise) : <font style="color: green;" id="fielddays_total_count">
                                                                </font>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Male: <font style="color: green;" id="fielddays_male_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Female: <font style="color: green;" id="fielddays_female_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="programwise_total_fielddays_malefemale" style="width: 100%;height: 750px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.5: Number of seed fairs/agriculture shows
                                                        conducted (country-wise) : <font style="color: green;" id="seed_conducted_count"></font>
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu two bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                                <li class="cross">×</li>
                                                                                <li>1,23,477 participants attended the seed fairs/ agriculture shows conducted by 9 programs.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_seedfairs" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Category-wise segregation of participants in seed fairs/ agriculture shows</h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="seedfairs_participanttype_array" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Stakeholders participated in seed fairs/ agriculture shows disaggregated by gender (country-wise) : <font style="color: green;" id="stakeholders_total_count">
                                                                </font>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Male: <font style="color: green;" id="stakeholders_male_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Female: <font style="color: green;" id="stakeholders_female_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="programwise_seedfairs_malefemale" style="width: 100%;height: 600px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.6 : Number of radio/ TV shows facilitated/conducted (country-wise) : <font style="color: green;" id="program_wise_no_of_radio_tvd_count"></font>
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu two bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                            <li class="cross">×</li>
                                                                                <li>19 programs conducted radio/TV outreach shows, and they estimated to reach around 93,64,047 farmers.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_wise_no_of_radio_tv" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="">Farmers reached through radio shows disaggregated by gender (country-wise) : <font style="color: green;" id="radio_total_count">
                                                                </font>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Male: <font style="color: green;" id="radio_male_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Female: <font style="color: green;" id="radio_female_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_wise_segregation_of_farmers" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Farmers reached through TV shows disaggregated by gender (country-wise) : <font style="color: green;" id="tv_total_count"></font>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Male: <font style="color: green;" id="tv_male_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Female: <font style="color: green;" id="tv_female_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_wise_segregation_of_farmers_tv" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.7: Number of small seed packs distributed/sold (country-wise): <font style="color: green;" id="program_wise_no_of_small_seed_packs_count"></font>
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu five bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                            <li class="cross">×</li>
                                                                                <li>a. A total of 35 tonnes of seeds were distributed at no cost as small seed packs benefitting over 71218 farmers.</li>
                                                                                <li>b. About 76 tonnes of seeds were directly purchased by farmers.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>

                                                    </h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <!-- <h4 class="h4-20px">Number of small seed packs distributed/sold (country-wise)</h4> -->
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_wise_no_of_small_seed_packs" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <!-- <h4 class="h4-20px">Percentage of seed packs distributed/ sold (crop-wise)</h4> -->
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="crop_wise_no_of_small_seed_packs" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Category-wise seed packs distribution at no cost</h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="distributed_by_no_cost" style="width: 100%;height: 377px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Category-wise seed packs sold</h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="sold_by_category" style="width: 100%;height: 377px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Quantity of seed distributed/ sold as small seed packs (country-wise) : <font style="color: green;" id="distributed_total_count">
                                                                </font>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Distributed at no cost: <font style="color: green;" id="distributed_val_inkg">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Sold: <font style="color: green;" id="sold_val_inkg">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="quantity_dist_sold_no_of_small_seed_packs" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Crop-wise mapping of year of release and quantity of seed distributed/ sold as small seed packs</h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-4 col-xl-4">
                                                                            <select id="seedcrop_year" class="form-control"></select>
                                                                        </div>
                                                                    </div>
                                                                    <div id="seed_year" style="width: 100%; height: 450px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <h4 class="h4-20px">Beneficiaries reached through seed packs distribution/ sales disaggregated by gender (country-wise) : <font style="color: green;" id="seedpack_total_count">
                                                                </font>
                                                            </h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Male: <font style="color: green;" id="seedpack_male_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card p-10">
                                                                        <div class="card-body p-21px">
                                                                            <h5>Female: <font style="color: green;" id="seedpack_female_count">
                                                                                </font>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_wise_segregation_of_beneficiaries" style="width: 100%;height: 550px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.9: Number of farmers reached through technology awareness creation models disaggregated by gender (country-wise): <font style="color: green;" id="technology_total_count">
                                                        </font></h4>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <!-- <h4 class="h4-20px">Number of farmers reached through technology awareness creation models disaggregated by gender (country-wise): <font style="color: green;" id="technology_total_count">
                                                        </font>
                                                    </h4> -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card p-10">
                                                                <div class="card-body p-21px">
                                                                    <h5>Male: <font style="color: green;" id="technology_male_count">
                                                                        </font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card p-10">
                                                                <div class="card-body p-21px">
                                                                    <h5>Female: <font style="color: green;" id="technology_female_count">
                                                                        </font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="" id="program_wise_no_of_farmers_reached_technology" style="width: 100%;height: 550px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="scroll12" class="mt-3">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.1.2: Innovative and transformative models
                                                for accessing, multiplying and disseminating
                                                public-bred varieties developed and promoted by
                                                scaling up seed enterprises
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.11: Number
                                                    of varieties registered in the regional variety
                                                    catalogue</li>
                                                <li class="list-group-item">Indicator #4.13: Number
                                                    of stakeholders trained in crop management and
                                                    seed production</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12 col-sm-12">
                                                    <h4>Indicator #4.11: Number of varieties registered in the regional variety catalogue : <font style="color: green;" id="total_411">
                                                        </font>
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu two bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                            <li class="cross">×</li>
                                                                                <li>A total of 14 varieties were added to the regional variety catalogue, out of which 13 were OPV and 1 was hybrid.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="card p-10">
                                                                <div class="card-body p-15px">
                                                                    <h5>Hybrid : <font style="color: green;" id="hybrid_4"></font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="card p-10">
                                                                <div class="card-body p-15px">
                                                                    <h5>OPV : <font style="color: green;" id="opv_4"></font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="card p-10">
                                                                <div class="card-body p-15px">
                                                                    <h5>SPV : <font style="color: green;" id="spv_4"></font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Number of varieties registered in the regional variety catalogue </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_varietyreleased_4" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Program X Varieties- Hybrid/ OPV/ SPV registered </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="program_traits_hybrid_opv_spv_4" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6 col-lg-12">
                                                    <h4 class="h4-20px">Program-wise mapping of variety name with the variety targeted to be replaced </h4>
                                                    <div class="card" style="height: 500px;">
                                                        <div class="d-flex justify-content-end mt-4 mr-4">
                                                            <div class="mr-4">
                                                                <a id="dwn-csv-411" class="download_btn"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="example table-responsive p-0">
                                                                <table class="table table-bordered" id="resultpo411">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center" data-field="countryname">
                                                                                Country
                                                                            </th>
                                                                            <th class="text-center" data-field="cropname">
                                                                                Crop</th>
                                                                            <th class="text-center" data-field="varietyname">
                                                                                Name of
                                                                                the variety</th>
                                                                            <th class="text-center" data-field="targetvariety">
                                                                                Name
                                                                                of variety targeted
                                                                                <br>for
                                                                                replacement
                                                                            </th>
                                                                    <tbody></tbody>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md-12 col-lg-12 col-sm-12">
                                                    <h4 class="h4-20px">Variety-wise comparison of on-farm mean yield </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="verity_onfarm_yield" style="width: 100%; height: 450px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4>Indicator #4.13:</h4>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Number of stakeholders trained in crop management and seed production
                                                        <span class="toogle-tooltip">
                                                            <a href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>include/assets/images/info3.png" height="20px"></a>
                                                            <div class="dropdown-menu five bg-info">
                                                                <div class="tooltip-header">
                                                                    <div class="tooltip-header-title">
                                                                        <span class="text-light">
                                                                            <ul class="p-2 mb-0">
                                                                            <li class="cross">×</li>
                                                                                <li>a. 78 events were conducted which benefitted around 11338 stakeholders.</li>
                                                                                <li>b. More than 50% of the events were categorized as trainings followed by training the trainers and demonstrations.</li>
                                                                            </ul>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </h4>
                                                    <div class="row h4-40px">
                                                        <div class="col-md-3">
                                                            <div class="card p-10">
                                                                <div class="card-body p-5">
                                                                    <h5>Total number of events: <font style="color: green;" id="traing_events">
                                                                        </font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card p-10">
                                                                <div class="card-body p-21px">
                                                                    <h5>Total number of stakeholders: <font style="color: green;" id="training_stackholder_count">
                                                                        </font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card p-10">
                                                                <div class="card-body p-21px">
                                                                    <h5>Total number of male stakeholders: <font style="color: green;" id="training_male_count">
                                                                        </font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="card p-10">
                                                                <div class="card-body p-21px">
                                                                    <h5>Total number of female stakeholders: <font style="color: green;" id="training_female_count">
                                                                        </font>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row h4-40px">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Number of events (country-wise) : <font style="color: green;" id="events_count"></font>
                                                            </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="country_wise_events" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Number of stakeholders trained (country-wise) : <font style="color: green;" id="total_stockholder_count"></font>
                                                            </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="country_wise_stackholders" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row h4-40px">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Course/training category-wise events : <font style="color: green;" id="category_count"></font>
                                                            </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="category_wise_events" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <h4 class="h4-20px">Course/training category-wise stakeholders trained : <font style="color: green;" id="category_stockholder_count"></font>
                                                            </h4>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="" id="category_wise_stackholders" style="width: 100%;height: 450px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll13" class="mt-3">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.1.3 New models of EGS (breeder and
                                                foundation) and certified/QDS seed production
                                                leveraged through demand-led public and private
                                                partnerships
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.14: Volume
                                                    of breeder seed produced (tons) </li>
                                                <li class="list-group-item">Indicator #4.15: Volume
                                                    of foundation seed produced (tons)</li>
                                                <li class="list-group-item">Indicator #4.16: Volume
                                                    of certified and QDS seed produced (tons)</li>
                                            </ul> -->
                                            <!-- <div class="row"> -->
                                                <div class="row">
                                                    <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="text-primary">Seed production</h4>
                                                        <hr>
                                                    </div> -->
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4>Indicator #4.14: Volume of Breeder seed produced (tons)
                                                        </h4>
                                                        <h4>Indicator #4.15: Volume of Foundation seed produced
                                                            (tons)</h4>
                                                        <h4>Indicator #4.16: Volume of Certified and QDS seed
                                                            produced (tons)</h4>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body p-15px">
                                                                <h5>Breeder seed: <font style="color: green;" id="breederseed">
                                                                    </font>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body p-15px">
                                                                <h5>Foundation seed: <font style="color: green;" id="foundationseed"></font>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <div class="card">
                                                            <div class="card-body p-15px">
                                                                <h5>Certified and QDS seed: <font style="color: green;" id="certifiedqdsseed">
                                                                    </font>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-20px">Crop-wise seed produced</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                                                        <select id="seedcountryselect" class="form-control"></select>
                                                                    </div>
                                                                </div>
                                                                <div id="seedclass_crop" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                                        <h4 class="h4-20px">Country-wise seed produced</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                                                        <select id="seedcropselect" class="form-control"></select>
                                                                    </div>
                                                                </div>
                                                                <div id="seedclass_country" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Crop-wise mapping of year of release and seed production</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                                                        <select id="seedcropselect_year" class="form-control"></select>
                                                                    </div>
                                                                </div>
                                                                <div id="seedclass_country_year" style="width: 100%; height: 450px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <h4 class="h4-20px">Key producer-wise seed production (Category-wise)</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                                                        <select class="form-control" id="key_producer-selector"></select>
                                                                    </div>
                                                                </div>
                                                                <div id="key_producer_vsseedclassdata" style="width: 100%; height: 450px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12">
                                                        <h4 class="h4-20px">Geo spatial mapping of seed production by crop and country</h4>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                                                        <select class="form-control" id="map-crop-selector"></select>
                                                                    </div>
                                                                </div>
                                                                <div id="bubble_map1" style="width: 100%; height: 450px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <!-- </div> -->





                                        </div>
                                    </div>
                                </div>

                                <div id="scroll14" class="mt-3">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.2.1: Quality seed of improved varieties
                                                bundled with complementary technologies and services
                                                (seed dressing, finance, insurance, agro-inputs) to
                                                enhance commercialization and uptake of improved
                                                varieties and profitability of seed entrepreneurs
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.18: Volume
                                                    of certified/Quality Declared Seed delivered with input and
                                                    service bundles (tons)</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.18: Volume of certified/Quality Declared Seed delivered with input and service bundles (country-wise) : <font style="color: green;" id="cqdc_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="Program_wise_volume_of_certified" style="width: 100%; height: 450px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll15" class="mt-3">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                            Output 4.2.2: Client-oriented channels leveraged to create awareness and generate demand for good quality seed 
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4> -->
                                            <!-- <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.19: Percent of farmers aware of the prioritized and commercialized varieties and promoted technologies</li>

                                                <li class="list-group-item">Indicator #4.20: Number of lobbying/communication tools developed to create awareness and generate demand for good quality seed</li>
                                            </ul> -->
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <h4 class="h4-20px">Indicator #4.19: Percent of farmers aware of the prioritized and commercialized varieties and promoted technologies (country-wise) : <font style="color: green;" id="promoted_tech_count"></font>
                                                </h4>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div id="Program_wise_percent_of_farmers" style="width: 100%; height: 450px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="scroll16" class="mt-3">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.3.2 User-friendly tools on profitability of
                                                different classes of seed and varieties and
                                                complementary technologies developed and shared with
                                                key value chain actors
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.23: Number
                                                    of SME /companies using profitability/analysis
                                                    tools</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.23: SMEs/ seed companies using profitability/analysis tools (crop-wise) <font style="color: green;" id="analysis_tools_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="analysis_tools_graph" style="width: 100%; height: 450px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               

                                <div id="scroll17" class="mt-3">
                                    <div class="card card_height2">
                                        <div class="card-body">
                                            <h4>
                                                Output 4.3.3 Partnerships to institutionalize and
                                                operationalize digital seed roadmaps responsive to
                                                commodity market developed
                                            </h4>
                                            <hr>
                                            <!-- <h4>Indicators</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">Indicator #4.24: Number
                                                    of public/private partners adopting and
                                                    operationalizing variety based digital seed
                                                    catalogue and road maps</li>
                                            </ul> -->
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <h4 class="h4-20px">Indicator #4.24: Number of public/private partners adopting and operationalizing variety based digital seed catalogue and road maps (country-wise) : <font style="color: green;" id="digital_seed_cataloge_count"></font>
                                                    </h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="digital_seed_cataloge_graph" style="width: 100%; height: 450px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- end app-content-->
    <div id="loader-body">
        <div class="d-flex flex-column align-items-center justify-content-center loader-height">
            <img src="<?php echo base_url(); ?>include/key_highlight/assets/images/svgs/loader.svg" alt="loader">
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>include/key_highlight/js/api-call.js"></script>
<script src="<?php echo base_url(); ?>include/key_highlight/js/overview.js"></script>
<script src="<?php echo base_url(); ?>include/key_highlight/js/communication.js"></script>
<script src="<?php echo base_url(); ?>include/key_highlight/js/breeding-modernization.js"></script>
<script src="<?php echo base_url(); ?>include/key_highlight/js/client-seed-system.js"></script>

<script src="<?php echo base_url(); ?>include/key_highlight/js/table2csv.js"></script>
<script src="<?php echo base_url(); ?>include/key_highlight/js/index.js"></script>
