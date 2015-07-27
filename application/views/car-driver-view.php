<!-- Car Driver -->
<div class="container_16">
<div class="grid_5 prefix_4">
<h2>Car Driver Form</h2>

</div>
<div class="clear"></div>

</div>

<div class="container_16">
<div class="grid_16">
<h2><?php echo $this->lang->line('car_driver_form_title')?></h2>


</div>
<div class="clear"></div>

<div class="grid_16">
<div id="company-info">

<div>
<form id="customer-form">
<div id="customer-info">
<table>
<thead>
<tr>
<th colspan="5"><?php echo $this->lang->line('car_driver_form_title');?></th>

</tr>
</thead>

<tbody>

<tr>
<td><?php echo $this->lang->line('citizen-number');?></td>
<td>
<div id="citizen">
	<input type="text" name="number1" id="num-group1" maxlength="1" size="1" /> -
	<input type="text" name="number2" id="num-group2" maxlength="4" size="4" /> -
	<input type="text" name="number3" id="num-group3" maxlength="5" size="5" /> -
    <input type="text" name="number4" id="num-group4" maxlength="1" size="1" />  
    <input type="text" name="number5" id="num-group5" maxlength="1" size="1" /> - 
    <input type="text" name="number6" id="num-group6" maxlength="1" size="1" />
    </div>
 </td>
 <td><label><?php echo $this->lang->line('date')?><span class="red">*</span></label></td>
<td><input type="text" id="popupDatepicker" /><span style="display: none;">
<img src="<?php echo base_url()?>images/calendar-green.gif" id="calImg" />
</td>
<td rowspan="3">
<span><a href="javascript:void(0)" id="save-customer" class="button_ok"><?php echo $this->lang->line('save');?></a></span> 
</td>
</tr>


<tr>
<td><?php echo $this->lang->line('name-lastname');?><span class="red">*</span></td>
<td><input id="driver_name" name="driver_name" value="<?php echo set_value('driver_name');?>" /></td>
<!--concrete plant -->
<td><label><?php echo $this->lang->line('concrete_plant');?><span class="red">*</span></label></td>
<td><select id="factory">
<option value="0"> - <?php echo $this->lang->line('select_concrete_plant');?> - </option>
<?php 
if($factory>0){
    foreach ($factory as $rows){
        if($rows['factory_status']!=0){
        echo "<option value=\"{$rows['factory_id']}\">{$rows['factory_code']}</option>";
        }
    }
}

?>

</select>


</td>


</tr>


<tr>
<td><label><?php echo $this->lang->line('address1');?><span class="red">*</span></label></td>
<td><input id="address1" name="address1" value="<?php echo set_value('address1');?>" /></td>
<td><label><?php echo $this->lang->line('address2');?></label></td>
<td><input id="address2" name="address2" value="<?php echo set_value('address2');?>" /></td>
</tr>
<tr>
<td><?php echo $this->lang->line('aumpher1');?><span class="red">*</span></td>

<td><!-- <input id="aumpher1" name="aumpher1" value="<?php echo set_value('aumpher1');?>" /> --> <select id="aumpher1"></select></td>
<td><?php echo $this->lang->line('aumpher1');?></td>
<td><select id="aumpher2"></select><!-- <input id="aumpher2" name="aumpher2" value="<?php echo set_value('aumpher2'); ?>" /> --></td>
<td rowspan="5">
<span><a class="button_cancle"><?php echo $this->lang->line('cancle');?></a></span>
</td>
</tr>

<tr>
<td><label><?php echo $this->lang->line('province')?></label><span class="red">*</span></td>
<td><!-- <input id="province1" name="province1" value="<?php echo set_value('province1') ?>" /> -->
<select id="province1" name="provice1" class="province">
<option value="0" selected="selected">==เลือกจังหวัด==</option>

<?php
if($province>0){
    foreach($province as $rs_pro){
        
        echo "<option value=\"{$rs_pro['PROVINCE_ID']}\">".iconv('UTF-8','TIS-620',$rs_pro['PROVINCE_NAME'])."</option>";
        
    }
    
}

?>

</select>
<!--<span id="PostID">f</span>
<select id="District"></select> -->

</td>
<td><label><?php echo $this->lang->line('province');?></label></td>
<td>
<select id="province2" name="provice2" class="province">
<option value="0" selected="selected">==เลือกจังหวัด==</option>

<?php
if($province>0){
    foreach($province as $rs_pro){
        
        echo "<option value=\"{$rs_pro['PROVINCE_ID']}\">".iconv('UTF-8','TIS-620',$rs_pro['PROVINCE_NAME'])."</option>";
        
    }
    
}

?>

</select>



</td>
</tr>

<tr>
<td><label><?php echo $this->lang->line('postcode');?></label><span class="red">*</span></td>
<td><input id="postcode1" name="postcode1" value="<?php echo set_value('postcode1');?>" maxlength="5" size="5" /></td>
<td><label><?php echo $this->lang->line('postcode');?></label></td>
<td><input id="postcode2" name="postcode2" value="<?php echo set_value('postcode2');?>" maxlength="5" size="5" /></td>
</tr>

<tr>

<td><label><?php echo $this->lang->line('phone_number');?></label><span class="red">*</span></td>
<td><input type="text" name="area_code" id="area_code" maxlength="3" size="3" /> -
	<input type="text" name="number1" id="number1" maxlength="6" size="6" />
</td>
<td><label><?php echo $this->lang->line('contact_person');?></label><span class="red">*</span></td>
<td><input id="contact_person" name="contact_person" value="<?php echo set_value('contact_person');?>" /></td>
</tr>
<tr>
<td><label><?php echo $this->lang->line('remark');?></label></td>
<td><textarea id="remark" style="width: 229px; height: 48px;"></textarea></td>
<td><label><?php echo $this->lang->line('moble_number');?></label></td>
<td><input type="text" name="mobile1" id="mobile1" maxlength="3" size="3" /> -
	<input type="text" name="mobile2" id="mobile2" maxlength="7" size="7" />
</td>

</tr>

</tbody>


</table>


</div>

</div>


</div>


</div>

</div>
