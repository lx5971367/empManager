<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	</head>
	<h1>添加用户</h1>
	<form action="empProcess.php" method="POST">
		<input type="hidden" name="flag" value="insert">
		<table>
    		<tr><td>用户名：</td><td><input type="text" name="name"></td></tr>
    		<tr><td>电子邮件：</td><td><input type="text" name="email"></td></tr>
    		<tr><td>等级：</td><td><input type="text" name="level"></td></tr>
    		<tr><td colspan=2><input type="submit" value="新增一个用户"></td></tr>
		</table>
	</form>
</html>