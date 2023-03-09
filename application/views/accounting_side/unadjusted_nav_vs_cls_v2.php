<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
  <meta charset="utf-8">
  <title>CS LIQUIDATION</title>

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
  <link href="<?php echo base_url();?>assets/admin.css" rel="stylesheet" type="text/css">
  <!-- Fonts END -->

  <!-- Global styles START -->          
  <link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Global styles END --> 
   
  <!-- Page level plugin styles START -->
  <link href="<?php echo base_url();?>assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
  <!-- Page level plugin styles END -->

  <!-- BEGIN PAGE LEVEL STYLES -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/select2/select2.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
  <!-- END PAGE LEVEL STYLES -->

  <link href="<?php echo base_url()?>assets/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">

  <!-- Theme styles START -->
  <link href="<?php echo base_url();?>assets/global/css/components.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/frontend/layout/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/frontend/pages/css/portfolio.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/frontend/layout/css/style-responsive.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/frontend/layout/css/themes/red.css" rel="stylesheet" id="style-color">
  <link href="<?php echo base_url();?>assets/frontend/layout/css/custom.css" rel="stylesheet">
  <!-- Theme styles END -->

  <!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/clockface/css/clockface.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<!-- END PAGE LEVEL STYLES -->

  <link href="<?php echo base_url();?>assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url();?>assets/global/css/plugins-md.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url();?>assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url();?>assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
  <link href="<?php echo base_url();?>assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet">


<!-- ==============================================DATATABLE BUTTONS PLUGINS ========================================================== -->
    <!-- <link href="<?php echo base_url();?>datatables_buttons_plugins/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>datatables_buttons_plugins/jquery.dataTables.min.css" rel="stylesheet"> -->

    <!-- <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url();?>datatables_buttons_plugins/buttons.dataTables.min.css" rel="stylesheet">
<!-- ================================================================================================================================== -->


<style type="text/css">

.content 
{
    overflow-y: auto;
}

table.table-bordered.dataTable {
	border-collapse: collapse !important;
}

@media print {
    table.table tfoot {
        display: table-row-group;
    }
}

@media print {
  .content:after {
    display: block;
    content: "";
    margin-bottom: 600mm; 
  }
}

</style>
</head>

<body class="corporate">

    <?php
      $this->load->view('accounting_side/header');
      $this->load->view('accounting_side/accounting_js');
    ?>

<div class="page-container">

  
<!-- =========================================================DATATABLE BUTTONS PLUGINS============================================================== -->
     <!-- <script src="<?php echo base_url();?>datatables_buttons_plugins/jquery-3.5.1.js" type="text/javascript"></script> -->
     <script src="<?php echo base_url();?>datatables_buttons_plugins/jquery.dataTables.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/dataTables.buttons.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/jszip.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/pdfmake.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/vfs_fonts.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/buttons.html5.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/buttons.print.min.js" type="text/javascript"></script>
<!-- ================================================================================================================================================ -->
  <!-- END PAGE HEAD -->
  <!-- BEGIN PAGE CONTENT --> 
  <div class="page-content" style="background: #ffffff;">
    <div class="container">
    
        <div class="row">
            <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject uppercase">unadjusted navision vs cls table</span>
                        </div>              
                    </div>
                    <div id="loader">
                    </div>
                    <form class="form-inline">
                      <center>
                          <input type="file" class="btn btn-default" name="files[]" id="txt_file" multiple="multiple" / style="display: inline-block;">
                          <button type="button" class="btn btn-primary" id="view-btn" onclick="upload_file_js()"><i class="glyphicon glyphicon-upload"></i> upload</button><br><br>
                          <label style="font-weight: bold; font-size: medium;">SELECT SALES DATE:</label>
                          <select class="input-sm data" id="sales_date_dropdown" style="height: 35px; width: 20%; padding-top: 0px;">
                          </select>
                          <button type="button" class="btn" style="background-color: brown; color: white;" onclick="view_variance_navcls_js_v2()" id="variance_btn">👁️ VIEW VARIANCE</button><br><br>
                          <label style="font-weight: bold; font-size: medium;">SELECT MODE OF PAYMENT:</label>
                          <select class="input-sm data" id="mop_dropdown" style="height: 35px; width: 19%; padding-top: 0px;">
                          </select>
                          <button type="button" class="btn" style="background-color: midnightblue; color: white;" onclick="print_unadjusted_navcls_js()" id="print_btn">🖨️ PRINT</button>
                          <br><br>
                          <label style="font-weight: bold; font-size: medium;">B.U/DEPT:&nbsp;</label>
                          <label id="bu_dept_lbl" style="font-weight: bold; font-size: medium; color: red;"></label>
                          <label style="font-weight: bold; font-size: medium; color: lime;">&nbsp;&nbsp;/&nbsp;&nbsp;</label>
                          <label style="font-weight: bold; font-size: medium;">SALES DATE:&nbsp;</label>
                          <label id="sales_date_lbl" style="font-weight: bold; font-size: medium; color: red;"></label>
                      </center>
                    </form>
                    <input hidden id="print_data">
                    <div class="portlet-body" id="divbody_navcls_table">
                       
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
    
<!-- =========================================================DATATABLE BUTTONS PLUGINS============================================================== -->
     <!-- <script src="<?php echo base_url();?>datatables_buttons_plugins/jquery-3.5.1.js" type="text/javascript"></script> -->
     <script src="<?php echo base_url();?>datatables_buttons_plugins/jquery.dataTables.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/dataTables.buttons.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/jszip.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/pdfmake.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/vfs_fonts.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/buttons.html5.min.js" type="text/javascript"></script>
     <script src="<?php echo base_url();?>datatables_buttons_plugins/buttons.print.min.js" type="text/javascript"></script>
<!-- ================================================================================================================================================ -->

    <script type="text/javascript">

    display_sales_date_uploaded_js_v2();

    /*======================================auto comma in number=================================================================*/
    $(".transfer_amount").maskMoney({thousands:',', decimal:'.', allowZero: true, suffix: ' '});
    /*=============================================================================================================================*/

    </script>


    <script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

    <script src="<?php echo base_url();?>assets/toggle/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/clockface/js/clockface.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="<?php echo base_url();?>assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-mixitup/jquery.mixitup.min.js" type="text/javascript"></script>
    
    <script src="<?php echo base_url();?>assets/frontend/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/frontend/pages/scripts/portfolio.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/datepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>assets/admin/pages/scripts/components-pickers.js"></script>
    <script src="<?php echo base_url();?>assets/overlay/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url();?>assets/overlay/extras/loadingoverlay_progress/loadingoverlay_progress.min.js"></script>


    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();
            Layout.initTwitter();
            Portfolio.init();
            ComponentsPickers.init();
        });
    </script>

    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>









