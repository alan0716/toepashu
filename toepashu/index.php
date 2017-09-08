<?php 
require_once 'php.lib/constants.php';
require_once PHP_LIB_PATH.'default_setting.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administration of Web Service</title>
<link type='text/css' rel='stylesheet' href='css/basic_setting.css' />
<link type='text/css' rel='stylesheet' href='css/jquery_treeview.css' />

<script src="js.lib/jquery-1.8.3.js" type="text/javascript"></script>
<script src="js.lib/jquery_cookie.js" type="text/javascript"></script>
<script src="js.lib/jquery_treeview.js" type="text/javascript"></script>
<script src="js.lib/parameters.js" type="text/javascript"></script>
<script src="js.lib/functions.js" type="text/javascript"></script>
<script src="js.lib/tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="mainPageLayout" class="comRange">
	<div id="header" class="comRange">
		<div id="headerTitle"><b>Administration of Web Service</b></div>
		<div id="system_date"></div>
	</div>
	<div id="mainMenu"><?php require_once 'menu.php';?></div>
	<div id="mainContent">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#e1e4e9" style="font-size:12px;">
			<tr >
				<td height="30" width="90%" valign="middle" align="left" style="PADDING-LEFT: 8px;"><font style="COLOR: #555555">
					<img src="images/url_01.gif" />&nbsp;後端首頁</font> 
				</td>
			</tr>
		</table>
		
		<table border="0" cellspacing="0" cellpadding="0" width="95%" align="center" style="margin-top:20px;">
			<tr>
				<td>Welcome <?php echo $_SESSION['account'];?>!</td>
			</tr>
		</table>
	</div>	
</div>
<?php require_once 'footer.php';?>
<div class="clearboth"></div>
</body>
</html>