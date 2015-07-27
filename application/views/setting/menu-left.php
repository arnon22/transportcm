<div class="grid_6">
<div class="left">
<div id='cssmenu'>
<h2>Menu</h2>
<ul>
   <!-- <li class='active '><a href='<?php echo base_url();?>'><span>Home</span></a></li> -->
   <li><?php echo anchor('',$this->lang->line('home'),'class=active');?></li>
   <li><?php echo anchor('setting/company',$this->lang->line('company_setting'));?></li>
   <li><?php echo anchor('setting/factory',$this->lang->line('factory_setting'));?></li>
   <li><?php echo anchor('setting/product',$this->lang->line('product_setting'));?></li>
   <li><?php echo anchor('setting/distance',$this->lang->line('distance_setting'));?></li>
   <li><?php echo anchor('cubiccode',$this->lang->line('queue_setting'));?></li>
   <li><?php echo anchor('setting/driver',$this->lang->line('driver_setting'));?></li>
   <li><?php echo anchor('setting/car',$this->lang->line('carinfo_setting'));?></li>
   <li><?php echo anchor('setting/report',$this->lang->line('reports_menu'));?></li>   
   
</ul>
</div>

</div>
<!-- End grid_6 -->
</div>