<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TruckManagment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">   
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <?php

$themes = array(
    "redmond",
    "smoothness",
    "humanity",
    "cupertino",
    "sunny"
    
    );
$i = rand(0, 4);

#echo $i;


?>
    	
    <?php

echo css('bootstrap/css/bootstrap.min.css');

?>


   <?php

echo css('bootstrap/css/bootstrap-responsive.min.css');

?>
    <?php
    
    

echo css('wooicon.css');

?>
    <?php

echo css('docs.css');

?>
    
    <?php

#echo css("jqgrid/js/themes/{$themes[$i]}/jquery-ui.custom.css", 'screen');
echo css("jqgrid/js/themes/hot-sneaks/jquery-ui.custom.css", 'screen');

?>	
    <?php

echo css('jqgrid/js/jqgrid/css/ui.jqgrid.css', 'screen');

?>
    <?php

echo css('jqgrid/js/jqgrid/css/ui.bootstrap.jqgrid.css', 'screen');

echo css('monthpicker21.css',"all");

/*Datetimepicker*/
echo css('jquery.datetimepicker.css');
?>


    
	<?php

#echo js("jquery.1.8.3.min.js");

?>
    <?php

echo js('jquery.min.js');

?>
    <?php

echo js("jqgrid/js/jqgrid/js/jquery.jqGrid.min.js");

?>
    <?php

#echo js("jqgrid/js/themes/jquery-ui.custom.min.js");

?>
    <?php

echo js('jqgrid/js/jquery-ui.custom.min.js');


?>

    <?php

echo js("jqgrid/js/jqgrid/js/i18n/grid.locale-th.js");

echo js('datepicker-th.js');


?>






<!-- -->
<?php echo js('jquery.maskedinput.min.js');
       echo js('jquery.mtz.monthpicker.js');
?>

<!-- Select 2 -->
<?php
echo css('select2.css');
echo js('select2.min.js');
?>

<!-- End of Select2 -->
<!-- Multi Select Fillter -->
<?php

echo css('jquery.multiselect.css');
echo css('jquery.multiselect.filter.css');
echo js('jquery.multiselect.js');
echo js('jquery.multiselect.filter.js');
echo  js('jquery.handsontable.full.js');
echo css('jquery.handsontable.full.css','screen');


?>

<!-- End-->  
    
    <!-- Import Excel-->
    <?php

echo js('csv_manager.js');

?>

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .mtz-monthpicker select{
       color: red; 
      }
      
      .h2_title{
        font-size: 30px;
        font-weight: bold;
        padding-bottom: 2px;
      }
    </style>

    <style>
.ui-jqgrid tr.jqgrow td 
{
    vertical-align: top;
    white-space: normal !important;
    padding:2px 5px;
}
</style>

<style>
#form-bg{
    border:2px solid #a1a1a1;
padding:10px 40px; 
background:#dddddd;

border-radius:5px;

    background: #BFB6AA;
    padding-bottom: 10px;
    padding-left: 2px;
}
#form-bg legend{
    color: #688E25;
    font-weight: bold;
}

#leftmenu-bg{
    border:2px solid #a1a1a1;
padding:10px 40px; 
border-radius:5px;

    background: #FDC026;
    padding-bottom: 10px;
    padding-left: 2px;

}

</style>
<style>
    .myAltRowClass { background-color: #E0B2DB; background-image: none; }
</style> 
    
    <style>
    #thumbnail {
    display: block;

    width: 32px;
    height: 32px;
}

#thumbnail:hover + #title {
    display: block;
}

#title {
    display: none;

    color: #ffffff;
    background-color: orange;
    text-align: center;

    width: auto;
    padding: 5px;

    </style>

  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
            <a href="<?php echo site_url();?>login/logout" class="navbar-link"><b>ออกจากระบบ</b></a>            
            </p>
            
            <ul class="nav">              
              <li><a id="thumbnail" title="หน้าหลัก" href="<?php echo site_url();?>"><i class="iwoo-home_32"></i></a><div id="title"><?php echo $this->lang->line('home');?></div></li>
              <li><a id="thumbnail" title="รายการเดินรถ" href="<?php echo site_url();?>truckorder"><i class="iwoo-truck_32"></i></a><div id="title"><?php echo $this->lang->line('order_car_truck'); ?></div></li>
              <li><a id="thumbnail" href="<?php echo site_url();?>customer"><i class="iwoo-users_business_32"></i></a><div id="title"><?php echo $this->lang->line('customer'); ?></div></li>
                           
            </ul>
            
            <ul class="nav">
           
             <?php

if ($this->cizacl->check_isAllowed($this->session->userdata('user_cizacl_role_id'),
    'cizacl'))
{

?>
             
              <li><a id="thumbnail" href="<?php

echo site_url();

?>income"><i class="iwoo-activity_monitor_add"></i></a><div id="title"><?php

echo $this->lang->line('income');

?></div></li>

<?php

}

?>

<?php

if ($this->cizacl->check_isAllowed($this->session->userdata('user_cizacl_role_id'),
    'cizacl'))
{

?>

              <li><a id="thumbnail" href="<?php

echo site_url();

?>expense"><i class="iwoo-activity_monitor_close"></i></a><div id="title"><?php

echo $this->lang->line('expense_menu');

?></div></li>

<?php

}

?>


              <li><a id="thumbnail" href="<?php

echo site_url();

?>saletax"><i class="iwoo-page_table_add_32"></i></a><div id="title"><?php

echo $this->lang->line('saletax');

?></div></li>
              <li><a id="thumbnail" href="<?php

echo site_url();

?>buytax"><i class="iwoo-page_table_close_32"></i></a><div id="title"><?php

echo $this->lang->line('buytax');

?></div></li>
              <li><a id="thumbnail" href="<?php

echo site_url();

?>carservice"><i class="iwoo-tools_32"></i></a><div id="title"><?php

echo $this->lang->line('maintenance');

?></div></li>
             
              
            </ul>
            <ul class="nav">
            <!--ss -->
         <!--
             <li><a id="thumbnail" href="<?php

echo site_url();

?>cardetail"><i class="iwoo-truck_32"></i></a><div id="title"><?php

echo $this->lang->line('cars');

?></div></li>

              <li><a id="thumbnail" href="<?php

echo site_url();

?>pricelist"><i class="iwoo-comment_user_add_32"></i></a><div id="title"><?php

echo $this->lang->line('driver');

?></div></li>
-->
               <li><a id="thumbnail" href="<?php

echo site_url();

?>oil"><i class="iwoo-oil_32"></i></a><div id="title"><?php

echo $this->lang->line('oils');

?></div></li> 

<li><a id="thumbnail" href="<?php

echo site_url();

?>customeroil2"><i class="iwoo-comment_user_add_32"></i></a><div id="title"><?php

echo $this->lang->line('customeroils');

?></div></li>            
            </ul>
            
            <ul class="nav">
            <!--ss -->
              
             <!-- <li><a id="thumbnail" href="<?php

echo site_url();

?>"><i class="iwoo-oil_32"></i></a><div id="title"><?php

echo $this->lang->line('oils');

?></div></li>-->
              <li><a id="thumbnail" href="<?php

echo site_url();

?>pricelist3"><i class="iwoo-Income_32"></i></a><div id="title"><?php

echo $this->lang->line('pricelist_setting');

?></div></li>
              
            </ul>
                <!--Report -->
            <ul class="nav">
            <li><a id="thumbnail" href="<?php

echo site_url();

?>cardetail"><i class="iwoo-comment_user_chart_32"></i></a><div id="title"><?php

echo $this->lang->line('summary_per_car');

?></div></li>
            <!--
            <li><a id="thumbnail" href="<?php

echo site_url();

?>"><i class="iwoo-comment_user_chart_32"></i></a><div id="title"><?php

echo $this->lang->line('summary_driver');

?></div></li>
-->
            <li><a id="thumbnail" href="<?php

echo site_url();

?>ireport"><i class="iwoo-chart_flipped_32"></i></a><div id="title"><?php

echo $this->lang->line('all_report');

?></div></li>
            
          </ul>
            
              </ul>
                <!--Report -->
            <ul class="nav">
            <li><a id="thumbnail" href="<?php

echo site_url();

?>setting"><i class="iwoo-lock_open_32"></i></a><div id="title"><?php

echo $this->lang->line('setting');

?></div></li>
            <?php

if ($this->cizacl->check_isAllowed($this->session->userdata('user_cizacl_role_id'),
    'cizacl'))
{

?>
           
           <li><a id="thumbnail" href="<?php

    echo site_url();

?>cizacl"><i class="iwoo-comment_user_chart_32"></i></a><div id="title"><?php

    echo $this->lang->line('admin_zacl');

?></div></li>
           <?php

}

?>
                
            
            </ul>
            
            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <!-- end --/head-->
    <style>
.ui-jqgrid .ui-jqgrid-htable th div 
{
    height: 35px;
    padding: 5px;
}
</style>
    <!-- Grid Enter -->
   
    
