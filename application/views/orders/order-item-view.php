<!-- Modal -->


<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
<h3 id="myModalLabel">Order Deatil</h3>
</div>
<div class="modal-body">
<p>This Is ID: <?php echo $id;?></p>
<?php

if(isset($result)){
    
    foreach($result as $order){ ?>
    
    <table class="table table-striped">
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('order_date_time'))?>: </th>
    <td><?php echo $order->created_datetime;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('delivery_datetime'))?> : </th>
    <td><?php echo $order->delivery_datetime;?></td>
    </tr>
    
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('order_number'))?>  : </th>
    <td><?php echo $order->order_number;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('number_dp'))?>  : </th>
    <td><?php echo $order->dp_number;?></td>
    </tr>
    
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('concrete_plant'))?>  : </th>
    <td><?php echo $order->factory_name." (".$order->factory_code.")";?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('agencies'))?>  : </th>
    <td><?php echo $order->customers_name;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('phone_number'))?>  : </th>
    <td><?php echo $order->phone_number;?></td>
    </tr>
    
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('real_distance'))?>  : </th>
    <td><?php echo $order->real_distance;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('distance_code'))?> : </th>
    <td><?php echo $order->distance_code;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('cubic_code'))?>  : </th>
    <td><?php echo $order->cubic_code;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('car_number'))?> : </th>
    <td><?php echo $order->car_number;?></td>
    </tr>
    <tr>
    <th><?php echo iconv('tis-620','utf-8',$this->lang->line('driver_name'))?> : </th>
    <td><?php echo $order->driver_name;?></td>
    </tr>
    
    
    
   
    </tr>
    
    
    
    
    
    
    
    </table>
    
        
        
 <?php       
    }
    
}

?>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<!--<button class="btn btn-primary"><i class="icon-print"></i>Print</button>-->
<a target="_blank" href="<?php echo base_url();?>reports/order_deatil_pdf/<?php echo $id;?>" class="btn btn-success"><i class="icon-print"></i> Print</a>
</div>

