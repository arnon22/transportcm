<?php
//View for Setting Company

$this->load->view('common/header');
?>

<div class="container_24">

<?php
$this->load->view('setting/menu-left');

?>
<div class="grid_18">
<div class="suffix_1">ssaaa</div>
<div class="prefix_8"><h2><?php echo $this->lang->line('company_title_form');?></h2></div>

<div id="company-info">
<?php echo form_open('setting/company');?>
<?php 
if(count($results)==0){
    echo "No Data";
}else{
    foreach($results as $data_files){?>
        


<table>
<tr>
<td><label for="company-name"><?php echo $this->lang->line('company_name');?></label> </td>
<td><input id="company_name" name="company-name" value="<?php echo iconv('UTF-8','TIS-620',trim($data_files['company_name']));?>" /></td>
<input id="company_id" type="hidden" value="<?echo $data_files['company_id'];?>" />
</tr>

<tr>
<td><label for="adds1"><?php echo $this->lang->line('company_adds1');?></label> </td>
<td><input id="address1" class="address" name="addrs1" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_address1']);?>" /> </td>
</tr>

<tr>
<td><label for="adds2"><?php echo $this->lang->line('company_adds2');?></label> </td>
<td><input id="address2" class="address" name="addrs2" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_address2']);?>" /> </td>
</tr>

<tr>
<td><label for="city"><?php echo $this->lang->line('city');?></label> </td>
<td><input id="city" name="city" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_city']);?>" /> </td>
</tr>

<tr>
<td><label for="province"><?php echo $this->lang->line('province');?></label> </td>
<td><input id="province" name="province" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_province']);?>" /> </td>
</tr>

<tr>
<td><label for="postcode"><?php echo $this->lang->line('postcode');?></label> </td>
<td><input id="postcode" name="postcode" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_postcode']);?>" /> </td>
</tr>

<tr>
<td><label for="tel"><?php echo $this->lang->line('tel');?></label> </td>
<td><input id="tel" name="tel" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_tel']);?>" /> </td>
</tr>

<tr>
<td><label for="fax"><?php echo $this->lang->line('fax');?></label> </td>
<td><input id="fax" name="fax" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_fax']);?>" /> </td>
</tr>

<tr>
<td><label for="tax-id"><?php echo $this->lang->line('tax_id');?></label> </td>
<td><input id="tax_id" name="tax-id" value="<?php echo iconv('UTF-8','TIS-620',$data_files['company_tax_id']);?>" /> </td>
<input id="modified_date" type="hidden" value="<?php echo date('Y-m-d');?>"/>
</tr>

<tr>
<td></td>
<td>
<!-- <input id="update-company" type="button" title="Update" class="btn" value="update" name="submit" />--> 
<a id="update-company" href="javascript:void(0)" class="btn"><?php echo $