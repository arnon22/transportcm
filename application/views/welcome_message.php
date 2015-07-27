<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Anon" />
    <link rel="stylesheet" href="css/login.css"  />
    <script src="js/jquery-1.8.2.js"></script>
    <script src="js/login.js"></script>
    
	<title>Transportation Management System</title>
</head>

<body>
<div id="login-head"></div>
<div id="login-center"></div>
<div id="login-footer">
<div id="footer-l"></div>
<div id="footer-r">
<form name="frmLogin" id="login" >
<p>
<input  id="username" type="text" name="username" title="username" autofocus="true"/>
</p>
<p>
<input id="password" type="password" name="password" title="password"/>
</p>
<p>
<input id="login"  type="submit" value="LOGIN" onclick="checkfeildLogin()" />
</p>
</form>

</div> 
</div>


</body>
</html>