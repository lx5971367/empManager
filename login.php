<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	</head>
	<h1>管理员登录系统</h1>
	<form action="loginProcess.php" method="post">
		<table>
			<tr><td>用户ID</td><td><input type="text" name="id"></td></tr>
			<tr><td>密&nbsp码</td><td><input type="password" name="password"></td></tr>
			<tr><td><input type="submit" value="提交"></td><td><input type="reset" value="重新输入"></td></tr>
		</table>
	</form>
	<?php
	   if(!empty($_GET['error']))//用empty函数判断是否GET到携带回来的参数
	   {
	       $error=$_GET['error'];//接收到location携带的参数
	       if ($error==1)
	       {
	           echo "<font color='red' size='3'>用户名或密码错误</font>";
	       }
	       elseif ($error==2)
	       {
	           echo "<font color='red' size='3'>用户名或密码未填写</font>";
	       }

	   }
	?>
</html>