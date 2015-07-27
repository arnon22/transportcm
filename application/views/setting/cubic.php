<div class="container_24">
<?php

$this->load->view('setting/menu-left')

?>
<div class="grid_18">
<h2><?php

echo $this->lang->line('cubic_h2_title');

?></h2>
<div id="company-info">
<?php

echo form_open("cubiccode");

?>
<table>
<tr>
<th></th>
<th></th>
<th></th>
</tr>
<tr>
<td><label><?php

echo $this->lang->line('cubic_code');

?></label></td>
<td><input id="cubic_code" name="cubic_code" value="" /><span class="error"  id="err-cubicode">sfff</span></td>
<td rowspan="4"><p><a class="button_ok" id="add-cubic"><?php

echo $this->lang->line('save');

?></a></p>
<p><a class="button_cancle" id="cancle-cublc"><?php

echo $this->lang->line('cancle');

?></a></p>

</td>
</tr>

<tr>
<td><label><?php

echo $this->lang->line('cubic_number');

?></label></td>
<td><input id="cubic_value" name="cubic_value" value="" /></td>
</tr>

<tr>
<td><label><?php

echo $this->lang->line('cubic_note');

?></label></td>
<td><textarea name="cubic_note" id="cubic_note" style="width: 227px; height: 47px;"></textarea></td>
</tr>

<tr>
<td><label><?php

echo $this->lang->line('cubic_status');

?></label></td>
<td><select name="cubic_status" id="cubic_status">
<option value="0"><?php

echo $this->lang->line('item_no_use');

?></option>
<option value="1" selected=""><?php

echo $this->lang->line('item_use');

?></option>
</select></td>
</tr>
</table>
<?php

echo form_close();

?>

</div>
<!-- <p><input type="button" id="add_tbl" value="Add" /></p> -->




<h2><?php

echo $this->lang->line('cubic_table_title');

?></h2>
<div id="contents">
<div class="contents-show-list">

</div>


</div>

<div class="scrollableContainer">
  <div class="scrollingArea">
  	<table class="cruises scrollable">
  	  <thead>
  			<tr>
  	     
        <th class="name"><div><?php

echo $this->lang->line('cubic_code');

?></div></th>
        <th class="operator"><div><?php

echo $this->lang->line('cubic_number');

?></div></th>
        <th class="began"><div></div><?php

echo $this->lang->line('cubic_note');

?></div></th>
        <th class="tonnage"><div><?php

echo $this->lang->line('cubic_status');

?></div></th>
        <th class="status"><div>Action</th>
			</tr>
  		</thead>
  		<tbody>
        
        <?php

if (count($rs > 0))
{
    foreach ($rs as $rew)
    {

?>
        <tr>
        <td class="name"><div><?php

        echo ($rew['cubic_id']);

?></div></td>
        <td class="operator"><div><?php

        echo iconv('UTF-8', 'TIS-620', $rew['cubic_value']);

?></div></td>
        <td class="began"><div><?php

        echo iconv('UTF-8', 'TIS-620', $rew['cubic_note']);

?></div></td>
        <td class="tonnage"><div><?php

        if (iconv('UTF-8', 'TIS-620', $rew['cubic_status']) == '0')
        {
            echo $this->lang->line('item_no_use'