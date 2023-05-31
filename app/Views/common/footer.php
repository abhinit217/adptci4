<!--Footer-->
<style type="text/css">
    .logo-img-height {
        height: 200px;
    }
</style>
            <!-- <footer class="footer fixed-bottom">
                <div class="containerfluid">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-right">
                            Co-developed by : <a href="#"><img src="<?php echo base_url(); ?>include/assets/images/mpro-images/icrisat-logo.png" height="40"></a>
                        </div>
                    </div>
                </div>
            </footer> -->
            <!-- <section class="mt-2 bg-white">
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
                    </div>
                </div>
            </section> -->
            <!-- End Footer-->
        </div>
        <!-- Back to top -->
        <a href="#top" id="back-to-top">
            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" /></svg>
        </a>
        
        <!-- Bootstrap4 js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/bootstrap/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!--Othercharts js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/othercharts/jquery.sparkline.min.js"></script>
        <!-- Circle-progress js-->
        <script src="<?php echo base_url(); ?>include/assets/js/vendors/circle-progress.min.js"></script>
        <!-- Jquery-rating js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/rating/jquery.rating-stars.js"></script>
        <!--Horizontal js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/horizontal-menu/horizontal.js"></script>
        <!--Select2 js -->
        <script src="<?php echo base_url(); ?>include/assets/plugins/select2/select2.full.min.js"></script>
        <!-- <script src="<?php echo base_url(); ?>include/assets/js/select2.js"></script> -->
        <!-- Timepicker js -->
        <script src="<?php echo base_url(); ?>include/assets/plugins/time-picker/jquery.timepicker.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/time-picker/toggles.min.js"></script>
        <!-- Datepicker js -->
        <script src="<?php echo base_url(); ?>include/assets/plugins/date-picker/date-picker.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/date-picker/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/input-mask/jquery.maskedinput.js"></script>
        <!--File-Uploads Js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/fancyuploder/jquery.fileupload.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/fancyuploder/fancy-uploader.js"></script>
        <!-- File uploads js -->
        <script src="<?php echo base_url(); ?>include/assets/plugins/fileupload/js/dropify.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/filupload.js"></script>
        <!-- Multiple select js -->
        <script src="<?php echo base_url(); ?>include/assets/plugins/multipleselect/multiple-select.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/multipleselect/multi-select.js"></script>
        <!--Sumoselect js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/sumoselect/jquery.sumoselect.js"></script>
        <!--intlTelInput js-->
        <!-- <script src="<?php echo base_url(); ?>include/assets/plugins/intl-tel-input-master/intlTelInput.js"></script> -->
        <!-- <script src="<?php echo base_url(); ?>include/assets/plugins/intl-tel-input-master/country-select.js"></script> -->
        <script src="<?php echo base_url(); ?>include/assets/plugins/intl-tel-input-master/utils.js"></script>
        <!--jquery transfer js-->
        <script src="<?php echo base_url(); ?>include/assets/plugins/jQuerytransfer/jquery.transfer.js"></script>
        <!--multi js-->
        <!-- <script src="<?php echo base_url(); ?>include/assets/plugins/multi/multi.min.js"></script> -->
        <!-- Form Advanced Element -->
        <!-- <script src="<?php echo base_url(); ?>include/assets/js/formelementadvnced.js"></script> -->
        <script src="<?php echo base_url(); ?>include/assets/js/form-elements.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/file-upload.js"></script>
        <!-- Custom js-->
        <script src="<?php echo base_url(); ?>include/assets/js/multiselect.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>include/assets/plugins/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('.plus-minus-toggle').on('click', function() {
                    $(this).toggleClass('collapsed');
                });
            });
        </script>
        <script>
            $('.accordian-body').on('show.bs.collapse', function() {
                $(this).closest("table")
                    .find(".collapse.in")
                    .not(this)
                //.collapse('toggle')
            });
        </script>
    </body>

</html>
