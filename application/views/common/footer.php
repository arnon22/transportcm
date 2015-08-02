<!-- footer -->
<div class="container-fluid">
<div class="clear"></div>
		<div class="row-fluid">
			<div class="span12">
			  <div class="row-fluid">
                <div style="margin: 10px;"></div>
			
					
				  
				</div><!--/span-->
			  </div><!--/row-->
			</div><!--/span-->
		  </div><!--/row-->
		  
  

    
		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<!--<script src="bootstrap/js/jquery.js"></script>-->
		<!--<script src="bootstrap/js/bootstrap.min.js"></script>-->
        <?php #echo js('bootstrap/js/bootstrap.min.js');?>
        <?php #echo js('bootstrap-alert.js')?>
       <?php #echo js('angular.min.js'); ?>
       <?php #echo js('app.js'); ?>
        <?php echo js('bootstrap-tab.js');?>
        <?php echo js('jquery.hotkeys.js');?>
        <?php echo js('jquery.datetimepicker.js');?>
        
        
      
		<script>
		
			$('#grid-demo-tabs a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
			})
			
			jQuery('#code').load('index.php?file=/editing/index.php');

			function iframeLoaded(iFrameID) 
			{
			  if(iFrameID) {
			        // here you can meke the height, I delete it first, then I make it again
			        iFrameID.height = "";
			        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 20 + "px";
			  }
			}
		</script>
        
        <script>
$(function(){
    //$('#TextBox1').MonthPicker({ StartYear: 2020, ShowIcon: false });
    //$("#TextBox1").mask("99-9999999");
    options = {
    pattern: 'mm/yyyy', // Default is 'mm/yyyy' and separator char is not mandatory
    selectedYear: <?php echo date('Y');?>,
    startYear: 2012,
   // finalYear: 2012,
    //monthNames: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
    monthNames:['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม']
};
    $('#monthYear').monthpicker(options);
});

</script>
      <footer>
        <p></p>
      </footer>

    </div><!--/.fluid-container-->
    
    


  </body>
</html>