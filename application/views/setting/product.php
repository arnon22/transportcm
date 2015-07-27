<?php
//Header
$this->load->view('common/header');
?>
<div class="container_24">
<?php
//left menu
$this->load->view('setting/menu-left');
?>
<!-- content -->

<div class="grid_18">
<h2>ฟอร์มบันทึกข้อมูลสินค้า</h2>
<div id="company-info">
<?php echo form_open("setting/add_product");?>
<table>
<tr>
<th></th>
<th></th>
<th></th>
</tr>
<tr>
<td><label>products code</label></td>
<td><input id="products_code" name="products_code" value="" /></td>
<td rowspan="4"><p><input type="button" id="add-product" name="add-product"  value="Add" class="button"/></p>
<p><input type="button" id="cancle-product" class="button" value="Cancle" /></p>

</td>
</tr>

<tr>
<td><label>products name</label></td>
<td><input id="products_name" name="products_name" value="" /></td>
</tr>

<tr>
<td><label>products note</label></td>
<td><textarea name="products_note" id="products_note" style="width: 227px; height: 47px;"></textarea></td>
</tr>

<tr>
<td><label>products status</label></td>
<td><select name="products_status">
<option value="0">ไม่ใช้งาน</option>
<option value="1" selected="">ใช้งาน</option>
</select></td>
</tr>
</table>
<?php echo form_close(); ?>

</div>
<!-- <p><input type="button" id="add_tbl" value="Add" /></p> -->





<div id="contents">
<h2>ตารางแสดงข้อมูลสินค้า</h2>
<table id="customer">
<thead>
<tr>
<th>Prduucts Code</th>
<th>Products Name</th>
<th>products note</th>
<th>products status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
if(count($rs>0)){ 
    foreach($rs as $rew){ ?>
        <tr>
        <td><?php echo iconv('UTF-8','TIS-620',$rew['products_code']);?></td>
        <td><?php echo iconv('UTF-8','TIS-620',$rew['products_name']);?></td>
        <td><?php echo iconv('UTF-8','TIS-620',$rew['products_note']);?></td>
        <td><?php if(iconv('UTF-8','TIS-620',$rew['products_status'])=='0'){echo "ไม่ใช้งาน";}else{ echo "ใช้งาน";};?></td>
        <td><a id="<?php echo $rew['products_id']?>" class="pro_edit" href="javascript:void(0)" onclick="">Edit</a>| <a href="javascript:void(0)" onclick="del('<?php echo $rew['products_id'];?>',this)">Delete</a></td>
        </tr>
        
        
    <?php }?> 

<?php } ?>



</tbody>

</table>



</div>





</div>

</div>

<?php
//Footer
$this->load->view('common/footer');
?>