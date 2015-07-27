<div class="grid_7">
<div class="left">
<!--<div id="left-h">
<ul>
<li>เพิ่มสินค้า</li>
<li>แก้ไขสินค้า</li>
<li>ลบสินค้า</li>

</ul>

</div> -->
<div id='cssmenu'>

<ul>
   <li class='active '><a href='<?= base_url();?>'><span>Home</span></a></li>
   <li><a href='<?php echo site_url('orders/add');?>'><span><?= $this->lang->line('orders_menu_add');?></span></a></li>
   <li><a href='<?php echo site_url('orders/edit');?>'><span>แสดงรายการสินค้า</span></a></li>
   <li><a href='<?php echo site_url('orders/del')?>'><span>กำหนดราคาสินค้า</span></a></li>
</ul>
</div>

</div>



</div>

<div class="grid_17">
<h2>Order View</h2>

</div>