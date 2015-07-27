<!-- Header -->
<?php $this->load->view('common/header-bootstrap');?>

<div class="container-fluid">
<div class="row-fluid">
<div class="span2">
<?php

$this->load->view('left-menu/report_left_menu');
?>



</div>
<div class="span10">

<h2><?php echo $this->lang->line('report_order_summary');?></h2>

<div class="well">
<form class="form-horizontal" id="truck-order" method="POST" action="reports/report_orders_summary">

<div class="control-group">
 <label class="control-label" for="factory_site">Plant</label>
 <div class="controls">
  <select id="factory_id" name="factory_id" class="input-medium">
    <option value="0" selected=""><?php echo $this->lang->line('all_select');?></option>
      <?php if($factory){
    
    foreach($factory as $rows){
        
        echo "<option value =\"{$rows['factory_id']}\">".iconv('utf-8','tis-620',$rows['factory_code'])."</option>";
    }
    
  }?>
    
      <!--<option value="">Plant one</option>
      <option>Plant two</option> -->
    </select>
    
   </div>
</div>


<div class="control-group">
<div id="datetimepicker1" class="input-append date">
<label class="control-label" for="date_time_order">Start Date</label>
<div class="controls">
    <input data-format="dd/MM/yyyy hh:mm:ss" id="start_datetime" name="start_datetime" placeholder="<?php echo $this->lang->line('start_datetime');?>" class="input-medium" required="" type="text">
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
    </div>
  </div>
</div>
<div class="control-group">
 <div id="datetimepicker2" class="input-append date">

<label class="control-label" for="dalivery_date_time">End Date</label>
<div class="controls">
<input data-format="dd/MM/yyyy hh:mm:ss" id="end_datetime" name="end_datetime" placeholder="Date Time" class="input-medium" type="text"/>
<span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
    </div>
</div> 
  
  
</div>

  
  



<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label" for="create_order_btn"></label>
  <div class="controls">
    <a href="reports/report_orders_summary" class="btn" target="_blank">Create Report</a>
    <a href="javascript:void(0)" id="create_order_report_btn" class="btn">Create Report2</a>
    <button id="create_order_btn" name="create_order_btn" class="btn btn-success">Create Report</button>
    <button id="cancle_btn" name="cancle_btn" class="btn btn-danger">Cancle</button>
  </div>
</div>


    

</form>
</div>









</div>


</div>


<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
    
    $('#datetimepicker2').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>

<script>
$(function(){
    $('#create_order_report_btn').click(function(){        
        var factory = $('#factory_site').val();
        var start_date = $('#start_datetime').val();
        var end_date = $('#end_datetime').val();
        var car_number = $('#car_number').val();
        
        var data = "factory_id="+factory+"&start_date="+start_date+"&end_date="+end_date+"&car_number="+car_number;
        
        
        
        //alert("factory_id="+factory+"&start_date="+start_date+"&end_date="+end_date+"&car_number="+car_number);
    });
    
    
    
});


</script>













</div>

<!-- footer -->
<?php $this->load->view('common/footer-bootstap');?>