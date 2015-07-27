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
        
        <form class="form-horizontal" method="POST" action="">
        <legend>รายงานค่าขนส่งรายเดือน</legend>
        <div class="control-group">
        <label class="control-label"><?php echo $this->lang->line('factory');?></label>
        
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
        <label class="control-label" for="month"> เดือน</label>
        <div class="controls">
        <select name="month">
        <?php if(isset($thaimonth)){
            
            foreach($thaimonth as $row){
                
                echo "<option value=\"{$row['code']}\">{$row['month']}</option>";
            }
            
        }?>
        
        
        </select>
        </div>
        </div>
        
        <div class="control-group">
        
        <label class="control-label">ปี</label>
        <div class="controls">
        <select name="selectYear">
        <?php if(isset($myYear)){
            
            foreach($myYear as $row){
                
                echo "<option value=\"{$row['orderYear']}\">{$row['orderYear']}</option>";
            }
            
        }?>
        
        </select>
        </div>
        </div>
        
        <div class="control-group">
        
        <div class="controls">
        <input class="btn btn-success" type="submit" name="submit" value="Submit" />
        </div>
        </div>
        
        </form><!--/form-->
        </div>
        
       
        </div><!--/span9-->
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