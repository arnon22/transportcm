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
<div id="contents">
<h2><?php echo $this->lang->line('distance_title');?></h2>
<table id="customer">
<thead>
<tr>
<th>รหัสระยะทาง</th>
<th>ระยะทางเริ่มต้น</th>
<th>ระยะทางสิ้นสุด</th>
<th>สถานะ</th>
<th><?php echo $this->lang->line('distance_name');?></th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
if(isset($distance)){
    foreach($distance as $row_distance){
        if($row_distance['distance_status'] == 0){
            $status = "ไม่ใช้งาน";
        }else{
            $status ="ใช้งาน";
        } ?>
        
        <tr>
        <td><?php echo iconv('UTF-8','TIS-620',$row_distance['distance_code']);?></td>
        <td><?php echo $row_distance['range_min'];?></td>
        <td><?php echo $row_distance['range_max'];?></td>
        <td><?php echo iconv('UTF-8','TIS-620', $row_distance['distance_name']);?></td>
        <td><?php echo $status;?></td>
        <td><a href="javascript:void(0)" id="<?php echo $row_distance['distance_id'];?>" class="edit_distance"><?php echo $this->lang->line('edit');?></a> | <a href="javascript:void(0)" onclick="deldistance('<?php echo $row_distance['distance_id'];?>',this)"><?php echo $this->lang->line('delete');?></a></td>
        
        </tr>
        
        
<?php        
    }
}
?>




</tbody>

</table> <!-- end table customer -->



</div><!-- end id contents-->
<!-- -->
<h2>ฟอร์มบันทึกข้อมูลสินค้า</h2>
<div id="company-info">
<?php echo form_open("setting");?>
<table>
<tr>
<th></th>
<th></th>
<th></th>
</tr>
<tr>
<td><label>รหัสระยะทาง</label></td>
<td><input id="distance_code" name="distance_code" value="" /></td>
<td rowspan="5"><p><a href="javascript:void(0)" id="add_distance" class="button_ok">บันทึก</a></p>
<p><a href="javascript:void(0)" id="cancle_distance" class="button_cancle">ยกเลิก</a></p>

</td>
</tr>

<tr>
<td><label>ระยะทางเริ่มต้น</label></td>
<td><input id="distance_start" name="distance_start" value="" class="distance_number" /><span>กม.</span></td>
</tr>

<tr>
<td><label>ระยะทางสิ้นสุด</label></td>
<td><input id="distance_end" name="distance_end" value="" class="distance_number" /><span>กม.</span></td>
</tr>
<tr><td><label>รายละเอียด</label></td><td><input id="distance_name" name="distance_name" value="" /></td></tr>



<tr>
<td><label>สถานะ</label></td>
<td><select id="distance_status" name="distance_status">
<option value="0">ไม่ใช้งาน</option>
<option value="1" selected="">ใช้งาน</option>
</select></td>
</tr>
</table>
<?php echo form_close(); ?>

</div>
<!-- <p><input type="button" id="add_tbl" value="Add" /></p> -->











</div>

</div>
<?php
//Footer
$this->load->view('common/footer');
?>