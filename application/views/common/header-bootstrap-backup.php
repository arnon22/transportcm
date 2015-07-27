<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <meta charset="utf-8" />-->
    <meta charset="tis-620" />
    <meta charset="utf-8" />
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <!-- <link href="../assets/css/bootstrap.css" rel="stylesheet"> -->
    <?php echo css('bootstrap.css');?>
    <?php echo css('cus-icons.css');?>
     <?php echo css('igoo-icon.css');?>
    <?php echo css('bootstrap-responsive.css');?>
    
    <?php echo css('bootstrap-datetimepicker.min.css');?>
   
     <?php echo js('jquery-1.8.3.js');?>
     <?php echo js('jquery-ui-1.9.2.custom.js')?>
     <?php echo js('bootstrap-datetimepicker.min.js');?>
     <!-- Time -->
    
    
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
<!--     <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet"> -->

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
      <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
            
        
        
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          <a class="brand" href="javascript:void(0)">Truck Transport</a>
          <div class="nav-collapse collapse">
             <!-- top menu -->
              <div style="margin: 0;" class="btn-toolbar">
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn dropdown-toggle"><?php echo $this->lang->line('home');?><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo site_url()?>bootstrap/logout"><?php echo $this->lang->line('logout')?></a></li>                  
                  
                </ul>
              </div><!-- /btn-group -->
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><?php echo $this->lang->line('data_menu');?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo site_url()?>customer"><i class="icon-search"></i> <?php echo $this->lang->line('customer_agancy');?></a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo site_url()?>Auto_pricelist"><i class="cus-coins"></i> <?php echo $this->lang->line('auto_pricelist');?></a></li>
                </ul>
              </div><!-- /btn-group -->
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle"><?php echo $this->lang->line('Operation_menu');?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('Revenue_Expenditure');?></a></li>
                  <li><a href="<?php echo site_url()?>oil"><?php echo $this->lang->line('get_dis_oil');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('get_did_cement_pond');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('get_did_Steel_manhole');?></a></li>
                  
                </ul>
              </div><!-- /btn-group -->
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><?php echo $this->lang->line('Tax_menu');?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                   <li><a href="javascript:void(0)"><?php echo $this->lang->line('tax_menu_list');?></a></li>
                   <li class="divider"></li>
                   <li><a href="javascript:void(0)"><?php echo $this->lang->line('tax_reports');?></a></li>
                </ul>
              </div><!-- /btn-group -->
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-success dropdown-toggle"><?php echo $this->lang->line('Setting_menu');?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo site_url()?>Allsetting"><?php echo $this->lang->line('seting_menu');?></a></li>
                  <!--<li><a href="javascript:void(0)"><?php echo $this->lang->line('factory_setting');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('distance_setting');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('queue_setting');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('product_setting');?></a></li>
                  
                  <li class="divider"></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('carinfo_setting');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('driver_setting');?></a></li> -->
                </ul>
              </div><!-- /btn-group -->
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-info dropdown-toggle"><?php echo $this->lang->line('Reports_menu');?> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('Order_transport_report');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('Transport_price_summary_report');?></a></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('Revenue_Expenditure_report');?></a></li>
                  <li class="divider"></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('Driver_report');?></a></li>
                  <li class="divider"></li>
                  <li><a href="javascript:void(0)"><?php echo $this->lang->line('Oil_report');?></a></li>
                </ul>
              </div><!-- /btn-group -->
              
            </div>
                
                
                
                
                
                
                <ul class="dropdown-menu">
                <li><a></a></li>
    
            </ul>
             </div>
          
          
            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    
<!--content -->    

<div class="container">
<div class="row">
<div class="span3">Welcome <span style="color: orange; font-weight: bold;" ><?php echo $username;?></span> <span> (<?php echo anchor('bootstrap/logout',$this->lang->line('logout'))?>)</span>
<p id="Clock"></p>



 </div>
 <!-- show Sub menu-->
<div class="span9">

    <ul class="nav nav nav-pills">
    
    <li><a href="<?php echo site_url()?>orders"><i class="itruck-truck"></i></a></li>
    
    
    <!--
    <li><a href="javascript:void(0)"><i class="icon-barcode"></i> Home</a></li>
    <li><a href="javascript:void(0)"><i class="icon-user"></i>User</a></li>
    <li><a href="javascript:void(0)">Home</a></li>
    <li><a href="javascript:void(0)">Home</a></li>
    <li><a href="javascript:void(0)">Home</a></li> 
    -->
    </ul>

</div><!-- end sub menu -->


</div>

</div>


<script>
	<!--
	function show(){
	var Digital=new Date()
	var day=Digital.getDay()
	var month=Digital.getMinutes()
	var year=Digital.getMonth()
	var hours=Digital.getHours()
	var minutes=Digital.getMinutes()
	var seconds=Digital.getSeconds()
	
	if (hours==0)
	hours=12
	if (minutes<=9)
	minutes="0"+minutes
	if (seconds<=9)
	seconds="0"+seconds
    
	document.getElementById("Clock").innerHTML="<span id='date'>Today : <?=date('M, d  Y ');?> </span>"+hours+":"+minutes+":"
	+seconds+" "
	setTimeout("show()",1000)  
	}
	show()
	//-->
	</script>
    