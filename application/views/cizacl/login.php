<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->cizacl->name?>-<?php echo $this->lang->line('version')?><?php echo $this->cizacl->version?></title>
<?php echo $this->login->getCss();?><?php echo $this->login->getScripts();?>
</head>
<body>
<div id="content">
	<h1><?php echo $this->lang->line('login')?></h1>
	<div id="jq_msg"></div>
	<div id="content-login">
		<form name="form1" id="form1" action="#">
			<table width="100%" border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td width="30%" align="right" valign="middle"><?php echo $this->lang->line('username')?></td>
					<td width="70%"><input type="text" name="username" id="username" size="30" /></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><?php echo $this->lang->line('password')?></td>
					<td><input type="password" name="password" id="password" size="30" /></td>
				</tr>
				<tr>
					<td align="right" valign="middle">&nbsp;</td>
					<td><button type="submit" class="cizacl_btn_check"><?php echo $this->lang->line('submit')?></button>
						&nbsp;
						<button type="reset" class="cizacl_btn_del"><?php echo $this->lang->line('cancel')?></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</body>
</html>