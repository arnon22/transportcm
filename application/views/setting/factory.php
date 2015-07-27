<?php
//header

$this->load->view('common/header');
?>
<div class="container_24">
<?php
//left menu
$this->load->view('setting/menu-left');

//content factory
?>
<div class="grid_18">

<div class="prefix_8"><h2><?php echo $this->lang->line('factory_title');?></h2></div>
<div id="company-info">
<?php echo form_open('setting/add_data');?>
<table>
<tr>
<td><label for="factory_code"><?php echo $this->lang->line('factory_code');?></label></td>
<td><input value="<?php echo set_value('factory_code');?>" id="factory_code" name="factory_code" /><span class="error" id="fcode_error"><?php echo $this->lang->line('fcode_error');?></span></td>

<input type="hidden" name="factory_create" value="<?php echo date("Y-m-d H:i:s");?>" />
<input type="hidden" name="factory_modified" value="<?php echo date("Y-m-d H:i:s");?>" />
<input type="hidden" name="factory_id" value="" />
</tr>

<tr>
<td><label for="factory_name"><?php echo $this->lang->line('factory_name');?></label></td>
<td><input name="factory_name" id="factory_name" value="<?php echo iconv('UTF-8','TIS-620',set_value('factory_name'));?>" /> <span class="error" id="fname_error">NO ent</span></td>
</tr>

<tr>
<td><label for="factory_note"><?php echo $this->lang->line('factory_note');?></label></td>
<td><textarea id="factory_note" name="factory_note" style="width: 223px; height: 87px; "></textarea></td>
</tr>

<tr>
<td><label for="factory_status"><?php echo $this->lang->line('factory_status'); ?></label></td>
<td><select name="factory_status">
    <option value="0">ไมใช้งาน</option>
    <option value="1" selected="">ใช้งาน</option>
</select></td>
</tr>

<tr>
<td></td>
<td>
<!-- <input id="btsubmit" name="btsubmit" class="button" type="submit" title="Update" value="update" /> --> 
<input id="btsubmit" name="btsubmit" class="button" type="button" title="Insert" value="Insert" /> 
<input id="btupdate" name="btupdate" class="button" type="button" title="Update" value="update" />
</td>
</tr>

</table>

<?php echo form_close('');?>


</div>

<!-- Factory List -->
<div id="contents">
<table id="factory">
<thead>
<tr>
<th><?php echo $this->lang->line('factory_code');?></th>
<th><?php echo $this->lang->line('factory_name');?></th>
<th><?php echo $this->lang->line('factory_note');?></th>
<th><?php echo $this->lang->line('factory_status');?></th>
<th></th>

</tr>
</thead>
<tbody>
<?php foreach($results as $data_files){?>

<tr>
<!-- <input id="factory_id" name="factory_id" value="<?php echo $data_files['factory_id'];?>" type="hidden"/> -->
<td id="res_faccode"><?php echo iconv('UTF-8','TIS-620',$data_files['factory_code']);?></td>
<td id="res_facname"><?php echo iconv('UTF-8','TIS-620',$data_files['factory_name']);?></td>
<td><?php echo iconv('UTF-8','TIS-620',$data_files['factory_note']);?></td>
<td><?php if(iconv('UTF-8','TIS-620',$data_files['factory_status'])=='0'){echo "ไม่ใช้งาน";}else{ echo "ใช้งาน";}?></td>
<td><a href="javascript:void(0)" id="<?php echo $data_files['factory_id'];?>" class="f_edit">Edit</a> | <a href="javascript:void(0)" onclick="delfactory('<?php echo $data_files['factory_id'];?>',this)">Delete</a></td>
</tr>
<?php }?>

</tbody>
</table>

</div>


</div>

</div>


<?php

//end content



//footer
$this->load->view('common/footer');




?>