<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <h2><?php if(isset($h2_title)){ echo $h2_title;};?></h2>
   
    </div>

    </div>
    <div class="clear"></div>
      <div class="row-fluid">		
        <div class="span12">
        <div class="row-fluid">
        <div class="span3">
        <!--left menu-->
        <?php echo $this->load->view('common/left-menu-report');?>
        
        </div><!--/span2-->
        <div class="span9">
        <?php if(isset($output)&&$output=="orders_report"){
            echo $output;
        } ?>
        </div><!--/span10-->
        </div><!-- row-fluid-->
        </div><!--/span12-->
            

</div><!-- /div.row -->
</div><!--/container--> 

<script>
var opts = {

    'loadComplete': function () {
        var grid = $("#list2");
            sum = grid.jqGrid('getCol', 'total_amount',false,'sum');
        grid.jqGrid('footerData','set', {note: 'Total: ',total_amount: ''+sum});
    },

};
</script>
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>