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
        <div id="form-bg">
        <form class="form-horizontal" action="" method="POST">
        <legend>รายงานสต๊อกน้ำมัน</legend>
        
        <div class="control-group">
        <label class="control-label"><?php echo $this->lang->line('factory');?> </label>
        <div class="controls">
        <select name="factory">
        <option value="All"><?php echo $this->lang->line("All");?></option>
        <?php if(isset($factory)){
            
            foreach($factory as $row){
            echo "<option value=\"{$row['factory_id']}\">{$row['factory_name']}</option>";    
            }
            
        }?>
        
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">เดือน/ปี </label>
        <div class="controls"> 
        <input  class="input-medium" name="monthYear" id="monthYear" type="text" value="" />
       <!-- <input name="dateInput" type="text" id="dateInput" value="" />-->  
       <input name="oil_type" type="hidden" value="All" />
        </div>
        </div>
        
        <div class="control-group">
        <div class="controls">
        <input id="submit-form" type="submit" name="submit" value="สร้างรายงาน" class="btn btn-success" />
        </div>
        </div>
                
        </form><!--/form-->
        
        <div>
        <?php 
            if(isset($report_status)){
                echo $report_status;
            }
        ?>
        </div>
       
        </div>
        
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
$(function(){
    $('#submit-form').click(function(){
        var monthYear = $('#monthYear').val();
        if(monthYear==""){
            $('#monthYear').focus();
            return false;
        }
        
    });
});
</script>




		
<!-- //footer -->
<?php $this->load->view('common/footer');?>