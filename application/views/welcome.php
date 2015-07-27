<div class="container_24">

<div class="grid_24">
<!-- <div id="retrieved-data"></div> -->

<!-- form -Order-->
<div>
<div id="company-info">
<?php echo form_open("setting/add_product");?>
<table>
<tr>
<th colspan="5">บันทึกเปิดรายการ <span style="float: right;"><span>ขณะนี้เวลา <?php echo date('H:i:s');?></span></span></th>

</tr>
<tr>
<td><label>วันที่</label></td>
<td><input type="text" id="popupDatepicker" /><span style="display: none;">
<img src="<?php echo base_url()?>images/calendar-green.gif" id="calImg" />

</td>


<td>หมายเลข DP</td>
<td><input id="products_code" name="products_code" value="" /></td>
<td rowspan="3">
<span><a class="button_ok">บันทึก</a></span> 
</td>
</tr>

<tr>
<td><label><?php echo $this->lang->line('concrete_plant');?></label></td>
<td><select>
<?php 
if($factory>0){
    foreach ($factory as $rows){
        if($rows['factory_status']!=0){
        echo "<option value=\"{$rows['factory_id']}\">{$rows['factory_code']}</option>";
        }
    }
}

?>
<!-- <option value="0">แพ้นปลวกแดง</option>
<option value="1">แพ้นหนองใหญ่</option> -->
</select>


</td>
<td>ลูกค้า</td>
<td><select>

<?php
echo "<option selected=\"selected\" value=\"\">--เลือกลูกค้า--</option>";
if($customer>0){
    foreach ($customer as $rowcus){
        
        
        echo "<option value=\"{$rowcus['customers_id']}\">".iconv('UTF-8','TIS-620',$rowcus['customers_name'])."</option>";
        
    }
}
?>
<!-- <option value="0">Customer1</option>
<option value="1">Customer2</option> -->
</select></td>


</tr>


<tr>
<td><label>ระยะทาง</label></td>
<td>
<input id="real-distance" /><span>Km.</span><span> จำนวนคิว </span><select>
<?php 
if($cubiccode!=""){
    foreach($cubiccode as $cubic){
        echo "<option value=\"{$cubic['cubic_id']}\">{$cubic['cubic_value']}</option>";
    }
    
}

?>

</select> <span>คิว</span></td>

<td>หมายเลขรถ</td>
<td><select>
<option value="0">C-001</option>
<option value="1">C-001</option>
</select></td>

</tr>
<tr>

<td>
<label>ค่าขนส่ง</label>
</td>
<td>
<select id="distance">
<option>1</option>
<option>2</option>
</select>
</td>
<td>คนขับรถ</td>
<td>
<select>
<option value="0" selected="selected"> --เลือกคนขับ-- </option>
<?php 
if ($driver>0){
    foreach($driver as $rowdriver){
        echo "<option value=\"{$rowdriver['driver_id']}\">".iconv('UTF-8','TIS-620',$rowdriver['driver_name'])."</option>";
        
    }
}
?>
</select>
</td>
<td rowspan="3">
<span><a class="button_cancle">ยกเลิก</a></span>
</td>
</tr>

<tr>
<td></td>
<td></td>
<td><label>หมายเหต</label></td>
<td><textarea name="products_note" id="products_note" style="width: 227px; height: 47px;"></textarea></td>


</tr>

<tr>


</td>

</tr>
</table>
<?php echo form_close(); ?>

</div>

</div>

</div>

<div class="clear"></div>
<div class="grid_24">
<div class="grid_10"><h2>รายการเดินรถ</h2><span><a href="javascript:void(0)" id="showorder-hide"><img src="<?php echo base_url()?>imgs/directional_up.png" /></a></span></div>

<div class="clear"></div>
<div id="contents">

<table id="customer">
<thead>
<tr>
<th colspan="6">ราการเดินรถ</th>
<th colspan="6"></th>
</tr>
<tr>
<th>วันที่</th>
<th>หมายเลข DP</th>
<th>หน่วยงาน</th>
<th>ระยะจริง</th>
<th>รหัสค่าขนส่ง</th>
<th>จำนวนคิว</th>
<th>หมายเลขรถ</th>
<th>คนขับ</th>
<th>เวลา</th>
<th>หมายเหต์</th>

<th>Action</th>
</tr>
</thead>
<tbody>

        <tr>
        <td>20/04/2013</td>
        <td>DP00001</td>
        <td>ปลวกแดง</td>
        <td>9.00</td>
        <td>1</td>
        
        <td>0.25</td>
        <td>80-8715</td>
        <td>นายเอ</td>
        <td></td>
        <td></td>
        <td>Print | Edit | Del</td>
        </tr>
        
        
   



</tbody>

</table>



</div>
</div>
<div id="retrieved-data">s</div>

</div>
