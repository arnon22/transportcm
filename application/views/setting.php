<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    
    
    <h2>Setting Menu</h2>
    </div><!--/span12-->
    </div>
    <div class="clear"></div>
    
    <div class="row-fluid">
    <div class="span2">
    
    <?php echo $this->load->view('common/left-menu');?>

    </div><!--/span2-->
    <div class="span10">
    <?php if(isset($out)){
        echo $out;
    };?>
    
    
    </div><!--/span10-->
    </div><!-- /row-fluid-->
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </div><!-- container-fluid -->
    
    
    
    <div class="container-fluid">
      
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>