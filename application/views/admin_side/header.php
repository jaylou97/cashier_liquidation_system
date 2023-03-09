    

     
    <style>
      .dropbtn {
        /*background-color: #04AA6D;*/
        background-color: #fff;
        color: black;
        padding: 10px;
        /*font-size: 16px;*/
        border: none;
        margin-top: 18%;
      }

      .dropbtn1 {
        /*background-color: #04AA6D;*/
        background-color: #fff;
        color: black;
        padding: 10px;
        /*font-size: 16px;*/
        border: none;
        margin-top: 21%;
      }

      .dropbtn2 {
        /*background-color: #04AA6D;*/
        background-color: #fff;
        color: black;
        padding: 10px;
        /*font-size: 16px;*/
        border: none;
        margin-top: 23%;
      }

      .dropbtn3 {
        /*background-color: #04AA6D;*/
        background-color: #fff;
        color: black;
        padding: 10px;
        /*font-size: 16px;*/
        border: none;
        margin-top: 12%;
      }

      .dropbtn4 {
        /*background-color: #04AA6D;*/
        background-color: #fff;
        color: black;
        padding: 10px;
        /*font-size: 16px;*/
        border: none;
        margin-top: 32%;
      }

      .dropdown {
        position: relative;
        display: inline-block;
      }

      .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fcfcfc;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
      }

      .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
      }

      .dropdown-content a:hover {background-color: #eaeaea; color: #e02222;}

      .dropdown:hover .dropdown-content {display: block;}

      .dropdown:hover .dropbtn {background-color: #fcfcfc; color: #e02222;}
      .dropdown:hover .dropbtn1 {background-color: #fcfcfc; color: #e02222;}
      .dropdown:hover .dropbtn2 {background-color: #fcfcfc; color: #e02222;}
      .dropdown:hover .dropbtn3 {background-color: #fcfcfc; color: #e02222;}
      .dropdown:hover .dropbtn4 {background-color: #fcfcfc; color: #e02222;}

      #adjustment_link:hover {
        color: #e02222;
      }

      #masterfile_link:hover {
        color: #e02222;
      }
    </style>
    
    <!-- BEGIN TOP BAR -->
    <div class="pre-header" id="treasury_preheader">
        <div class="container">
            <div class="row">
                <!-- BEGIN TOP BAR LEFT PART -->
                <div class="col-md-6 col-sm-6 additional-shop-info">
                    <ul class="list-unstyled list-inline">
                        <li>Contact Us : <i class="fa fa-phone"></i><span>+ 1821</span></li>
                        <li>Look for : Ma'am Lanie / Ma'am April</span></li>
                    </ul>
                </div>
                <!-- END TOP BAR LEFT PART -->
                <!-- BEGIN TOP BAR MENU -->
               
                <div class="col-md-6 col-sm-6 additional-nav">
                    <ul class="list-unstyled list-inline pull-right">                        
                        <li><img alt="" class="img-square" src="http://<?php echo $photo_url;?>" style="width: 25px;">&nbsp;&nbsp;<?php echo $username?> [ <?php echo $emp_id?> ]</li>
                               <?php
                if($emp_id == '15815-2013' || $emp_id == '06025-2015' || $emp_id == '06025-2015' || $emp_id == '20426-2013')
                {
                  ?>
                    
                    <li><a href="<?php echo site_url('main_controller/old_system')?>">ADJUSTMENT</a></li>
                   
                  <?php
                }
                ?>
                        <!-- <li><a href="<?php echo site_url('main_controller/old_system')?>">OLD SYSTEM</a></li> -->
                        <li><a href="<?php echo site_url('main_controller/log_out')?>">Log Out</a></li>
                    </ul>
                </div>
                <!-- END TOP BAR MENU -->
            </div>
        </div>        
    </div>
    <!-- END TOP BAR -->
    <!-- BEGIN HEADER -->
    <div class="header">
      <div class="container">
        <a class="site-logo" href="<?php echo site_url()?>"><img src="<?php echo base_url();?>assets/agc_logo/liquidation_logo.png" alt="Metronic FrontEnd"></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <!-- Mifaña, April Bunayog(43251-2013) | Abrio, Sharlyn Bautista(02930-2017) | Tuyor, Emily Bayron(19043-2018) | Montederamos, Ma. Re Ann Daguplo(07483-2015)-->
        <!-- Lebot, Jonalyn Sarat(10494-2013) | Sausa, Novelyn Lumansoc(26869-2013)-->
        <?php if($emp_id == '43251-2013' || $emp_id == '02930-2017' || $emp_id == '19043-2018' || $emp_id == '07483-2015' ||
                 $emp_id == '10494-2013' || $emp_id == '26869-2013')
        {
            ?>
                <div class="header-navigation pull-right font-transform-inherit">
                  <ul>
                    <li id="dashboard">
                      <a href="<?php echo site_url()?>">
                        Home                 
                      </a>
                    </li> 
                    <li id="den_form">
                      <a href="<?php echo site_url('main_controller/bu_denomination_form')?>">
                            Denomination Form             
                      </a>
                    </li>               
                     <li class="" id="demo_id">
                      <a href="<?php echo site_url('main_controller/demo_con')?>">
                            [ SYSTEM DEMO ]      
                      </a>
                    </li> 
                  <!--   <li class="" id="report_id">
                      <a href="<?php echo site_url('main_controller/report_con')?>">
                            Report     
                      </a>
                    </li>  -->         
                  
                  </ul>
                </div>
            <?php
        }
        else
        {
          ?>
              <div class="header-navigation pull-right font-transform-inherit">
              <ul>

                <li class="" id="dashboard_header">
                  <a href="<?php echo base_url() ?>admin_dashboard_route">
                    HOME      
                  </a>
                </li>
                <li class="" id="add_access">
                  <div class="dropdown">
                    <button class="dropbtn">ADD ACCESS</button>
                    <div class="dropdown-content">
                      <a href="<?php echo base_url() ?>adduser_access_route">Add User Access</a>
                      <a href="<?php echo base_url() ?>admin_add_mop_route">Add Mode Of Payment</a>
                      <!-- <a href="<?php echo base_url() ?>sup_pending_denomination_route">Pending Cash Denomination</a>
                      <a href="<?php echo base_url() ?>sup_cashier_denomination_route">Posted Denomination</a>
                      <a href="<?php echo base_url() ?>sup_deleted_pending_denomination_route">Deleted Pending Cash Denomination</a>
                      <a href="<?php echo base_url() ?>sup_cashier_deleted_denomination_route">Deleted Posted Denomination</a> -->
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          <?php
        }

        ?>

        <!-- END NAVIGATION -->
      </div>
    </div>
    <!-- Header END -->