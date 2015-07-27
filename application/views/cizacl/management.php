<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->cizacl->name?>-<?php echo $this->lang->line('version')?><?php echo $this->cizacl->version?></title>
<?php echo $this->cizacl->css() ?><?php echo $this->cizacl->scripts() ?>
<script type="text/javascript" src="<?php echo site_url('cizacl_js/cizacl')?>"></script>
</head>

<body>
<div id="header"></div>
<div id="container">
	<h1><?php echo $this->lang->line('cizacl_management')?></h1>
	<p>&nbsp;</p>
	<div class="cizacl_tabs">
		<ul>
			<li><a href="#tabs1"><?php echo $this->lang->line('roles')?></a></li>
			<li><a href="#tabs2"><?php echo $this->lang->line('resources')?></a></li>
			<li><a href="#tabs3"><?php echo $this->lang->line('rules')?></a></li>
		</ul>
		<div id="tabs1">
			<p align="right">
				<button type="button" class="cizacl_btn_add" onclick="add_role();"><?php echo $this->lang->line('add')?></button>
				&nbsp;
				<button type="button" class="cizacl_btn_edit" onclick="edit_role();"><?php echo $this->lang->line('edit')?></button>
				&nbsp;
				<button type="button" class="cizacl_btn_edit" onclick="del_role();"><?php echo $this->lang->line('del')?></button>
			</p>
			<p>&nbsp;</p>
			<table id="roles_table" class="jqgrid">
			</table>
			<div id="roles_navigator"></div>
		</div>
		<div id="tabs2">
			<p align="right">
				<button type="button" class="cizacl_btn_add" onclick="add_resource();"><?php echo $this->lang->line('add')?></button>
				&nbsp;
				<button type="button" class="cizacl_btn_edit" onclick="edit_resource();"><?php echo $this->lang->line('edit')?></button>
				&nbsp;
				<button type="button" class="cizacl_btn_edit" onclick="del_resource();"><?php echo $this->lang->line('del')?></button>
			</p>
			<p>&nbsp;</p>
			<table id="resources_table" class="jqgrid">
			</table>
			<div id="resources_navigator"></div>
		</div>
		<div id="tabs3">
			<p align="right">
				<button type="button" class="cizacl_btn_add" onclick="add_rule();"><?php echo $this->lang->line('add')?></button>
				&nbsp;
				<button type="button" class="cizacl_btn_edit" onclick="edit_rule();"><?php echo $this->lang->line('edit')?></button>
				&nbsp;
				<button type="button" class="cizacl_btn_edit" onclick="del_rule();"><?php echo $this->lang->line('del')?></button>
			</p>
			<p>&nbsp;</p>
			<table id="rules_table" class="jqgrid">
			</table>
			<div id="rules_navigator"></div>
		</div>
	</div>
</div>
</body>
</html>
