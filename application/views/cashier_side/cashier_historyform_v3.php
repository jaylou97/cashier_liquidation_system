<html lang="en">
<!--<![endif]-->
<!-- Head BEGIN -->

<head>
    <meta charset="utf-8">
    <title>CS CASHIER</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="Metronic Shop UI description" name="description">
    <meta content="Metronic Shop UI keywords" name="keywords">
    <meta content="keenthemes" name="author">

    <meta property="og:site_name" content="-CUSTOMER VALUE-">
    <meta property="og:title" content="-CUSTOMER VALUE-">
    <meta property="og:description" content="-CUSTOMER VALUE-">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
    <meta property="og:url" content="-CUSTOMER VALUE-">

    <link rel="shortcut icon" href="favicon.ico">


    <!-- Fonts START -->
    <link href="<?php echo base_url(); ?>assets/admin.css" rel="stylesheet" type="text/css">
    <!-- Fonts END -->

    <!-- Global styles START -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    <!-- Page level plugin styles END -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/global/plugins/select2/select2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
    <!-- END PAGE LEVEL STYLES -->

    <!-- Theme styles START -->
    <link href="<?php echo base_url(); ?>assets/global/css/components.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/layout/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/pages/css/portfolio.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/layout/css/style-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/layout/css/themes/red.css" rel="stylesheet" id="style-color">
    <link href="<?php echo base_url(); ?>assets/frontend/layout/css/custom.css" rel="stylesheet">
    <!-- Theme styles END -->

    <link href="<?php echo base_url(); ?>assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/css/plugins-md.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
    <link href="<?php echo base_url(); ?>assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet">
</head>
<!-- Head END -->

<!-- Body BEGIN -->

<style type="text/css">
    input[type='number'] {
        font-size: 22px;
        text-align: center;
        height: 50px;
        width: 100%;
    }

    input[type='text'] {
        font-size: 22px;
        text-align: center;
        height: 50px;
        width: 100%;
    }
</style>

<body class="corporate">

    <?php
    $this->load->view('cashier_side/header');
    $this->load->view('cashier_side/cashier_js');
    ?>

    <div class="page-container">

        <div class="page-content" style="background: #ffffff;">
            <div class="container">
              
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject uppercase">PENDING CASH SALES REMITTANCE FORM</span>
                                </div>

                              <form style="margin-left: 35%;">
                                <label class="checkbox-inline" id="cashremit_type" style="font-size: 16px; margin-top: 2%; font-weight:bold;"></label>

                                <label class="checkbox-inline" style="font-size: 17px; margin-top: 2%; margin-left: 45px; font-weight: bold;">
                                  <input type="checkbox" id="cash_borrow_checkbox" onclick="history_checked_borrow()" style="width: 20px; height: 20px; margin-top: -1px; margin-left: -24px;" value="">BORROW
                                </label>
                              </form>

                              <form hidden id="cash_section_form">
                                <center>
                                    <select style="font-size: 17px; font-weight: bold;" name="cash_section" id="cash_section" onchange="get_sub_section_js()">
                                        <option id="" style="text-align: center;" disabled selected value="">SELECT SECTION</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;
                                    <select style="font-size: 17px; font-weight: bold;" name="cash_subsection" id="cash_subsection">
                                        <option id="" style="text-align: center;" disabled selected value="">SELECT SUB SECTION</option>
                                    </select>
                                </center>
                              </form>

                              <form hidden id="cash_section_form2">
                                <center><label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                SECTION<input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="cash_section2">
                                </label>
                                <label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                SUB SECTION<input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="cash_subsection2">
                                </label></center>
                              </form>

                              <form hidden id="cash_pos_form">
                                <center>
                                    <select id="pos_name" style="font-size: 17px; font-weight: bold;" onchange="get_counter_no_js()"></select>
                                    &nbsp;&nbsp;&nbsp;
                                    <span id="counter_no" style="font-size: 17px; font-weight: bold;"></span>
                                </center>
                              </form>

                              <form id="cash_pos_form2">
                                <center><label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                    <input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="pos_name2">
                                </label>
                                <label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                    <input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="counter_no2">
                                </label></center>
                              </form>

                              <form hidden id="remittance_type">
                                <center>
                                    <label class="checkbox-inline" style="font-size: 15px; font-weight: bold;">
                                        <input type="checkbox" id="partial_checkbox" style="width: 20px; height: 20px; margin-top: -1px; margin-left: -24px;" value="">PARTIAL REMITTANCE
                                    </label>
                                    <label class="checkbox-inline" style="font-size: 15px; font-weight: bold;">
                                        <input type="checkbox" id="final_checkbox" style="width: 20px; height: 20px; margin-top: -1px; margin-left: -24px;" value="">FINAL REMITTANCE
                                    </label>
                                    <label class="checkbox-inline" style="font-size: 15px; font-weight: bold;">
                                        <input type="button" id="update_remittance_btn" onclick="update_remit_type_js()" style="background-color: limegreen; color: white; border: 0px;" value="UPDATE">
                                    </label>
                                </center>
                              </form>

                            </div>
                            <div class="portlet-body">
                                <div class="form-body" id="form_body">
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-bordered table-hover display" style="color: black; font-size: 12px;">
                                            <thead>
                                                <tr>

                                                    <th width="40%">
                                                        <center>DENOMINATION
                                                        </th>
                                                        <th width="30%">
                                                            <center>QUANTITY
                                                            </th>
                                                            <th width="30%">
                                                                <center>AMOUNT
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                        <form name="history_form" id="history_form">
                                                            <tbody id="history_cashform_tbody">
                                                              
                                                            </tbody>
                                                        </form>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT -->
                </div>


                <!-- ==================================================OTHER MODE OF PAYMENT FORM=========================================================================== -->

                <div class="page-container">


                    <div class="page-content" style="background: #ffffff;">
                        <div class="container">


                            <div class="row">
                                <div class="col-md-12">

                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject uppercase">PENDING NONCASH SALES REMITTANCE FORM</span>
                                            </div>

                                            <form style="margin-left: 35%;">
                                                <label class="checkbox-inline" id="noncashremit_type" style="font-size: 16px; margin-top: 2%; font-weight:bold;"></label>
                                                <label hidden="" id="hncash_bid"></label>
                                                <label hidden="" id="hncash_data"></label>

                                                <label class="checkbox-inline" style="font-size: 17px; margin-top: 2%; margin-left: 45px; font-weight: bold;">
                                                    <input type="checkbox" id="noncash_borrow_checkbox" onclick="history_noncash_checked_borrow()" style="width: 20px; height: 20px; margin-top: -1px; margin-left: -24px;" value="">BORROW
                                                </label>
                                            </form>

                                            <form hidden id="noncash_section_form">
                                                <center>
                                                    <select style="font-size: 17px; font-weight: bold;" name="noncash_section" id="noncash_section" onchange="history_noncash_get_sub_section_js()">
                                                        <option id="" style="text-align: center;" disabled selected value="">SELECT SECTION</option>
                                                    </select>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <select style="font-size: 17px; font-weight: bold;" name="noncash_subsection" id="noncash_subsection">
                                                        <option id="" style="text-align: center;" disabled selected value="">SELECT SUB SECTION</option>
                                                    </select>
                                                    <input id="update_noncash_borrowed_btn" type="button" style="font-size: 17px; color: white; text-align: center; background-color: limegreen; border: 0px;" value="UPDATE" onclick="update_noncash_borrowed_js()">
                                                </center>
                                            </form>

                                            <form hidden id="noncash_section_form2">
                                                <center><label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                                SECTION<input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="noncash_section2">
                                                </label>
                                                <label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                                SUB SECTION<input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="noncash_subsection2">
                                                </label></center>
                                            </form>

                                            <form hidden id="noncash_pos_form">
                                                <center>
                                                    <select id="noncash_pos_name" style="font-size: 17px; font-weight: bold;" onchange="get_noncash_counter_no_js()"></select>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span id="noncash_counter_no" style="font-size: 17px; font-weight: bold;"></span>
                                                    <input id="update_noncash_pos_btn" type="button" style="font-size: 17px; color: white; text-align: center; background-color: limegreen; border: 0px;" value="UPDATE" onclick="update_noncash_pos_js()">
                                                </center>
                                            </form>

                                            <form id="noncash_pos_form2">
                                                <center><label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                                    <input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="noncash_pos_name2">
                                                </label>
                                                <label class="checkbox-inline" style="font-size: 17px; font-weight: bold;">
                                                    <input type="text" disabled style="height: 40px; font-size: 17px; text-align: center;" id="noncash_counter_no2">
                                                </label></center>
                                            </form>

                                            <form>
                                            <center>
                                                    <select disabled id="history_mop_name" style="font-size: 17px; font-weight: bold;"></select>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span id="" style="font-size: 17px; font-weight: bold;">Quantity:</span>
                                                    <input disabled id="history_nc_quantity" min="1" type="number" class="history_nc_quantity" style="font-size: 17px; height: 29px; font-weight: bold; text-align: center; width: 80px;"></input>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span id="" style="font-size: 17px; font-weight: bold;">Amount:</span>
                                                    <input disabled id="history_nc_amount" class="history_nc_amount" style="font-size: 17px; font-weight: bold; text-align: center; width: 150px;"></input>
                                                    <input disabled id="history_plus_btn" type="button" style="font-size: 17px; font-weight: bold; text-align: center; background-color: limegreen;" value="???" onclick="history_add_mop_js()"></input>
                                            </center>
                                            </form>

                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-body" id="form_body">
                                                <div class="table-scrollable" id="history_noncashdiv_mop">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT -->
                </div>
                            

<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/src/jquery.maskMoney.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
<script src="<?php echo base_url();?>assets/frontend/layout/scripts/back-to-top.js" type="text/javascript"></script>

<div id="load_js"></div>


<script type="text/javascript">
    
    displayhistory_cashform_js();
    history_disabled_saveresetbtn_js();

    $(function(){
        document.getElementById("cash_borrow_checkbox").disabled = true;
        document.getElementById("noncash_borrow_checkbox").disabled = true;
        validate_cash_borrowed_js_v2();
        displayhistory_noncashform_js();
        setTimeout(function() {
            validate_edit_cash_js();
        }, 1000);
    });
    
    /*======================================auto comma in number=================================================================*/
    $(".d_amount").maskMoney({thousands:',', decimal:'.', allowZero: true, suffix: ' '});
    $(".hd_amount").maskMoney({thousands:',', decimal:'.', allowZero: true, suffix: ' '});
    // $(".history_nc_amount").maskMoney({thousands:',', decimal:'.', allowZero: true, suffix: ' '});
    /*=============================================================================================================================*/

</script>
<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/global/plugins/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/frontend/layout/scripts/back-to-top.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="<?php echo base_url(); ?>assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
<script src="<?php echo base_url(); ?>assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->

<!-- BEGIN RevolutionSlider -->
<script src="<?php echo base_url(); ?>assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/slider-revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/frontend/pages/scripts/revo-slider-init.js" type="text/javascript"></script>
<!-- END RevolutionSlider -->

<script src="<?php echo base_url(); ?>assets/frontend/layout/scripts/layout.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
        Layout.initOWL();
        RevosliderInit.initRevoSlider();
        Layout.initTwitter();
            //Layout.initFixHeaderWithPreHeader(); /* Switch On Header Fixing (only if you have pre-header) */
            //Layout.initNavScrolling(); 
        });

    $("#dashboard").addClass("active");



    /*=============================================disabled input===========================================================*/
        /*  $("[type='number']").keypress(function (evt) {
               evt.preventDefault();
           });*/
           /*=======================================================================================================================*/
       </script>
       <!-- END PAGE LEVEL JAVASCRIPTS -->
   </body>

   </html>