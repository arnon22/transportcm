<!-- Header -->
<?php $this->load->view('common/header-bootstrap');?>

<!-- containt -->
<div class="container">
<div class="row">
<div class="span5">dd</div>
<div class="span7">
<input />
</div>
<div class="span4">
<h2>Auto Pricelist</h2>
<form method="POST" action="upload_price/do_upload" >
<span class="btn btn-file">Upload<input type="file" /></span>
<input type="button" value="Upload Now" class="btn btn-large btn-success" />

</form>


<?php echo form_open_multipart('upload_price/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" class="btn btn-success" value="upload" />

</form>


<div class="progress">
<div class="bar" style="width: 60%;"></div>
</div>


</div><!-- span4-->

<div class="span8">
<table>
<tr>
<th>1</th>
<th>2</th>
</tr>

<tr>
<td>d</td>
<td>w</td>
</tr>

</table>



</div><!-- end span8-->


</div>

</div>



<!-- footer -->
<?php $this->load->view('common/footer-bootstap');?>