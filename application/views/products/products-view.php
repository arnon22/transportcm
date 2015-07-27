<div class="container_24">

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
   <li><a href='<?= site_url('products/add');?>'><span>เพิ่มรายการสินค้า</span></a></li>
   <li><a href='<?= site_url('products/edit');?>'><span>แสดงรายการสินค้า</span></a></li>
   <li><a href='#'><span>กำหนดราคาสินค้า</span></a></li>
   <li><a href="#"><span><?php echo $this->lang->line('seting_menu');?></span></a></li>
</ul>
</div>

</div>



</div>

<div class="grid_17">
<h2><?php echo $this->lang->line('products_title'); ?></h2>
<p><?php echo $this->lang->line('products_list_title');?></p>

</div>

</div>