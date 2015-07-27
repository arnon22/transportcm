
<?php $this->load->view('common/header-bootstrap');?>
<!-- header -->


<!-- container -->
    <div class="container-fluid">
      <div class="row-fluid">
      <div class="span2">
      <?php echo $this->lang->line('orders_title');?>
      </div>
      
      <div class="span10">
    
    <ul class="nav nav-tabs">
    <li><a href="#order_list" data-toggle="tab"><?php echo $this->lang->line('order_list');?></a></li>
    <li><a href="#order_form_display" data-toggle="tab"><?php echo $this->lang->line('order_form_display');?></a></li>
    <!--<li><a href="#messages" data-toggle="tab">Messages</a></li>
    <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
    </ul>
    
    </div>
      </div>
      
     <div class="row-fluid"> 
   
      <div class="span2"></div>
      
      <div class="span10">
      
      <div class="tab-content">
      
        <div class="tab-pane active" id="order_list">
      
        <form class="form-search">
     <div class="input-append">
     <input type="text" class="search-query" placeholder="Keyword Invoive..." />
     <button type="submit" class="btn">Search</button>
     
     </div>
     
     </form>

        
     <div class="span4">
     
     
     
     
     </div>
     
      
      
      <table class="table table-hover">
      <caption></caption>
      <thead>
      <tr>
     <th><?php echo $this->lang->line('index');?></th>
      <th><?php echo $this->lang->line('order_number');?></th>
      <th><?php echo $this->lang->line('date_time');?></th>
      <th><?php echo $this->lang->line('number_dp');?></th>      
      <th><?php echo $this->lang->line('concrete_plant');?></th>      
      <th><?php echo $this->lang->line('agencies');?></th>
      <!--<th><?php echo $this->lang->line('distance');?></th>-->
      <!-- <th><?php echo $this->lang->line('distance_code');?></th>-->
      <!--<th><?php echo $this->lang->line('cubic_number');?></th> -->
      <th><?php echo $this->lang->line('car_number');?></th> 
      <th><?php echo $this->lang->line('driver_name');?></th>
      <!--<th><?php echo $this->lang->line('delivery_datetime');?></th>-->
      <th><?php echo $this->lang->line('save_by');?></th>
      <th></th>
      
      </tr>
      
      </thead>
      
      <tbody>
      
      <?php 
      if($results!=null){
                
        $i = $this->uri->segment(3)+1; 
        foreach($results as $order){ 
          
            
            ?>
        
      <tr data-href="<?php echo base_url();?>orders/edit/<?php echo $order->order_id; ?>" id="<?php echo $order->order_id?>" class="tr_order">
      <td><?php echo $i?></td>      
      <td><?php echo $order->order_number;?></td>
      <td><?php echo $order->created_datetime;?></td>
      <td><?php echo $order->dp_number;?></td>
      <td><?php echo iconv('utf-8','tis-620',$order->factory_code);?></td>
      <td><?php echo iconv('utf-8','tis-620',$order->customers_name);?></td>
      <!--<td><?php echo $order->real_distance;?></td>-->
      <!--<td><?php echo $order->distance_code;?></td> -->
      <!--<td><?php echo $order->cubic_code;?></td>-->
      <td><?php echo $order->car_number;?></td>
      <td><?php echo iconv('utf-8','tis-620',$order->driver_name);?></td>
      <!-- <td><?php echo $order->delivery_datetime;?></td>-->
      <td><?php echo $order->username;?></td>
      <td> <!--<a id="<?php echo $order->order_id;?>" href="#myModal" data-toggle="modal" title="ccc"><i class="icon-search"></i></a>   | -->
      <a href="<?php echo base_url();?>orders/order_edit/<?php echo $order->order_id;?>" title="<?php echo $this->lang->line('edit')?>"><i class="icon-edit"></i></a> | 
      <a href="javascript:void(0)" onclick="del_order('<?php

        echo $order->order_id;

?>',this)" title="<?php echo $this->lang->line('delete')?>"><i class="icon-remove"></i></a></td>
      </tr>
            
            
      <?php $i++; }
      }
      
      ?>
      

      </tbody>
      
      </table>
      
       <?php echo $pagination_links; ?>
      
      



</div><!-- end #home -->


<div class="tab-pane" id="profile">

</div><!--end #order_form_display -->
<div class="tab-pane" id="order_form_display">

<div class="well">
<form class="form-horizontal" id="truck-order" method="POST" action="orders/add_new_order">

<div class="control-group">
<div id="datetimepicker1" class="input-append date">
<label class="control-label" for="date_time_order">Date/Time</label>
<div class="controls">
    <input data-format="dd/MM/yyyy hh:mm:ss" id="date_time_order" name="date_time_order" placeholder="date-time" class="input-medium" required="" type="text">
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
    </div>
  </div>
 <div id="datetimepicker2" class="input-append date">

<label class="control-label" for="dalivery_date_time">Delivery Time</label>
<div class="controls">
<input data-format="dd/MM/yyyy hh:mm:ss" id="dalivery_date_time" name="dalivery_date_time" placeholder="Date Time" class="input-medium" type="text"/>
<span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
    </div>
</div> 
  
  
</div>

<div class="control-group">

 <label class="control-label" for="db_number">DP Number</label>
 <div class="controls">
 <input id="db_number" name="db_number" placeholder="DP Number" class="input-medium" required="" type="text">
 </div>
</div>

<div class="control-group">
 <label class="control-label" for="factory_site">Plant</label>
 <div class="controls">
  <select id="factory_site" name="factory_site" class="input-medium">
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
  
    
 <label class="control-label" for="Customer">Customer</label>
  <div class="controls">
    <select id="Customer" name="Customer" class="input-xlarge">
      <?php
      if($customer){
        
        foreach($customer as $rows){
            
            echo "<option value=\"{$rows['customers_id']}\">".iconv('utf-8','tis-620',$rows['customers_name'])."</option>";
        }
      }
      
      ?>
      
      
      
    </select>
    <button id="New_Customer" name="New_Customer" class="btn btn-inverse">New Customer</button>
 </div>
 </div>
 
  <div class="control-group">
  
  <label class="control-label" for="real_distance">Real Distance</label>
  <div class="controls">
  <input id="real_distance" name="real_distance" placeholder="Real Distance" class="input-small" required="" type="text"/><span> Km.</span>
 </div>
  </div>
  
  <div class="control-group">
  <label class="control-label" for="Distance_code">Distance Code</label>
  
  <div class="controls">
  <select id="Distance_code" name="Distance_code" class="input-small">
      <?php
      if($distance){
        
        foreach($distance as $rows){
            
            echo "<option value=\"{$rows['distance_id']}\">".iconv('utf-8','tis-620',$rows['distance_code'])."</option>";
        }
      }
      
      ?>
    </select>
    
     </div>
  </div>
  
  <div class="control-group">
  <label class="control-label" for="Cubic">Cubic</label>
  <div class="controls">
  <select id="Cubic" name="Cubic" class="input-small">
         <?php
      if($cubic){
        
        foreach($cubic as $rows){
            
            echo "<option value=\"{$rows['cubic_id']}\">".iconv('utf-8','tis-620',$rows['cubic_value'])."</option>";
        }
      }
      
      ?>
      
      <option value=""></option>
    </select>
    
    </div>
  </div>
  
    
<div class="control-group">
<div class="controls">
  <input type="button" class="btn btn-warning" value="Cal Price" id="select_v" />
  <script>
  $('#select_v').click(function(){
    
    var cubic_id = $('#Cubic').val();
    var distance_id = $('#Distance_code').val();
    var factory_id = $('#factory_site').val();
    
    var data = "cubic_id="+cubic_id+"&distance_id="+distance_id+"&factory_id="+factory_id;
    
    //alert (data);
    
    $.ajax({
                type: "POST",
                url: "auto_pricelist/check_price",
                data: data,
                //dataType: "JSON",
                cache: false,
                success: function(){
                    
                }
                
    });
    
  });
  
  </script>
  </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="price"></label>
     <div class="input-prepend">
      <span class="add-on">Price</span>
      <input id="price" name="price" class="input-medium" placeholder="" type="text">
  </div>
  </div>
  
  
  <div class="control-group">
  
  <label class="control-label" for="Car_number">Car Number</label>
  <div class="controls">
    <select id="Car_number" name="Car_number" class="input-medium">
        <?php
      if($car){
        
        foreach($car as $rows){
            
            echo "<option value=\"{$rows['car_id']}\">".iconv('utf-8','tis-620',$rows['car_number'])."</option>";
        }
      }
      
      ?>
    
    </select>
    
   </div>
   </div>
   <div class="control-group">
   
  <label class="control-label" for="Driver">Driver</label>
  <div class="controls">
    <select id="driver" name="driver" class="input-medium">
        <?php
      if($driver){
        
        foreach($driver as $rows){
            
            echo "<option value=\"{$rows['driver_id']}\">".iconv('utf-8','tis-620',$rows['driver_name'])."</option>";
        }
      }
      
      ?>
    
    </select>
 </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="remark">Remark</label>
  <div class="controls">                     
    <textarea id="remark" name="remark">default text</textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label" for="create_order_btn"></label>
  <div class="controls">
    <button id="create_order_btn" name="create_order_btn" class="btn btn-success">Create Order</button>
    <button id="cancle_btn" name="cancle_btn" class="btn btn-danger">Cancle</button>
  </div>
</div>

<div>
		<?php echo $output; ?>
    </div>
    

</form>
</div>

</div>
<div class="tab-pane" id="settings">4.</div>
</div>
      
      
    
      
      
      </div><!-- end span12--> 
      
      </div><!-- end row-->
      
      
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
<h3 id="myModalLabel">Modal header</h3>
</div>
<div class="modal-body">
<p>Body</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary">Save changes</button>
</div>
</div>

<!-- this is the placeholder for the modal box -->
<div id="modal-editUser" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<!-- content will go here -->
</div>

      

    </div> <!-- /container -->
    
    <!-- this is the code that makes it all happen -->

<script type="text/javascript">
	jQuery( function($) { 
		// find all tr's with a data-href attribute
		$('tbody tr[data-href]').click( function() {
			// copy the data-href value to the modal for later use
			$('#modal-editUser').attr('data-href',$(this).attr('data-href'));
			// show the modal window
			$('#modal-editUser').modal({show: true , backdrop : true , keyboard: true});
		}).find('a').hover( function() { 
			// unbind it in case I put some a tags in the table row eventually
			$(this).parents('tr').unbind('click'); 
		}, function() { 
			$(this).parents('tr').click( function() { 
				// rebind it
				$('#modal-editUser').attr('data-href',$(this).attr('data-href'));
				$('#modal-editUser').modal({show: true , backdrop : true , keyboard: true});
			}); 
		});
		
		// when the modal show event fires, load the url that was copied to the data-href attribute
		$('#modal-editUser').bind('show', function() {
			$(this).load($(this).attr('data-href'));
		});
	});
    
    
    // del distance
function del_order(id,obj){
    var conf = confirm("Do you want to Delete?");
    
    if(conf){
        
        $.ajax({
            url:"orders/del_order/"+id,
            type:"POST",
            success:function(res){
                if(res=="ok"){
                  $(obj).parent().parent().remove();  
                }
            },
            error:function(eer){
                console.log("Error:" +err);
            }
        });
        
       // $(obj).parent().parent().remove();
        
        
    }else{
        return false;
    }
    
}
</script>
    
    
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
        
        
            
            $('#real_distance').keyup(function(){
            
            var real_distance = $(this).val();
            
            if(real_distance!=""){
            
            var data_real = "real_distance="+real_distance;
            
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url()?>auto_pricelist/check_real_distance",
                data: data_real,
               dataType: "JSON",
               cache: false,
                success:function(res){
                    
                    $(res).each(function(key,val){
                       // alert("Source="+real_distance+"result"+val['distance_id']);
                       
                       $('#Distance_code').addClass('option='+val['distance_id']+'');
                       
                    });
                    
                }
                
                
            });
            
            
            
                
            }
            
            
            
        }).delay(3000).keyup();
            
      
    
        
        
        
    });
    
    


</script>



<!-- footer-->
<?php $this->load->view('common/footer-bootstap');?>    

