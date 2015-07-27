<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TruckManagment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    	
    <?php echo css('bootstrap/css/bootstrap.min.css')?>
    <?php echo css('jqgrid/js/themes/redmond/jquery-ui.custom.css','screen');?>	
      <?php echo css('jqgrid/js/jqgrid/css/ui.jqgrid.css','screen');?>
       <?php echo css('jqgrid/js/jqgrid/css/ui.bootstrap.jqgrid.css','screen');?>


    <?php echo js("jquery.min.js");?>
    <?php echo js("jqgrid/js/jqgrid/js/i18n/grid.locale-en.js");?>
    <?php echo js("jqgrid/js/jqgrid/js/jquery.jqGrid.min.js");?>
    <?php echo js("jqgrid/js/themes/jquery-ui.custom.min.js");?>
	

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

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
          <a class="brand" href="#">Truck Management</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              <a href="#" class="navbar-link">www.phpgrid.org</a>
            </p>
            <ul class="nav">
             
              <li class="active"><a href="<?php echo site_url()?>bootstrap">Home</a></li>
              <li><a href="<?php echo site_url()?>income">Income</a></li>
              <li><a target="_blank" href="http://www.phpgrid.org/docs">Docs</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <p>Main nenu</p>
    </div>
    <hr />
    </div>
    <div class="clear"></div>
      <div class="row-fluid">
       <!-- <div class="span2">
			<div class="accordion" id="accordion_menu">
					
			</div>
		  
		  
        </div><!--/span-->
		
        <div class="span12">
          <div class="row-fluid">
            <div class="span3">			
				<?php echo $out;?>
                
                <?php if(isset($out_master)){
                    echo $out_master;
                    
                }?>
                <br />
                
                

            </div><!--/span-->
            <div class="span9">
            <div class="row-fluid">
            <div class="span12">
            <?php if(isset($out_detail)){
                    echo $out_detail;
                    
                }?>
            
            </div>
            </div>
            
            </div>
          </div><!--/row-->
        </div><!--/span-->
		<div class="clear"></div>
		<div class="row-fluid">
			<div class="span12">
			  <div class="row-fluid">
				<div class="alert alert-info">
					
				  
				</div><!--/span-->
			  </div><!--/row-->
			</div><!--/span-->
		  </div><!--/row-->
		  
      </div><!--/row-->

      <hr>
		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="bootstrap/js/jquery.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
        <?php echo js('bootstrap/js/bootstrap.min.js');?>
	<!--	<script>
    var opts = {
        // e.g. to show footer summary
        'loadComplete': function () {
               var grid = $("#list2");

               // sum of displayed result
            sum = grid.jqGrid('getCol', 'total_amount', false, 'sum'); // 'sum, 'avg', 'count' (use count-1 as it count footer row).

            // sum of running total records
            sum_running = grid.jqGrid('getCol', 'running_total')[0];

            // sum of total records
            sum_table = grid.jqGrid('getCol', 'table_total')[0];

            // record count
            c = grid.jqGrid('getCol', 'id', false, 'sum');

            grid.jqGrid('footerData','set', {id: 'Total: ' + sum, income_date: 'Sub Total: '+sum_running, total: 'Grand Total: '+sum_table});
        },
        // e.g. to update footer summary on selection
        'onSelectRow': function () {

               var grid = $("#list2");

               var t = 0;
            var selr = grid.jqGrid('getGridParam','selarrrow'); // array of id's of the selected rows when multiselect options is true. Empty array if not selection 
            for (var x=0;x<selr.length;x++)
            {
                t += parseInt(grid.jqGrid('getCell', selr[x], 'total_amount'));
            }
            grid.jqGrid('footerData','set', {income_date: 'Total: '+t});
        }

    };
    </script>-->
      <footer>
        <p></p>
      </footer>

    </div><!--/.fluid-container-->


  </body>
</html>
