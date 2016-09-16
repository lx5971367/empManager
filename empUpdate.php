<?php
    require_once 'Emp.class.php';
    require_once 'EmpService.class.php';
	$id=$_GET['id'];
	$empService=new EmpService();
	$emp=$empService->getEmpById($id);	
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	</head>
	<h1>添加用户</h1>
	<form action="empProcess.php" method="POST">
		<input type="hidden" name="flag" value="update">
		<table>
			<tr><td>用户ID：</td><td><input type="text" name="id" readonly="readonly" value="<?php echo $emp->id; ?>"></td></tr>
    		<tr><td>用户名：</td><td><input type="text" name="name" value="<?php echo $emp->name; ?>"></td></tr>
    		<tr><td>电子邮件：</td><td><input type="text" name="email" value="<?php echo $emp->email; ?>"></td></tr>
    		<tr><td>等级：</td><td><input type="text" name="level" value="<?php echo $emp->level; ?>"></td></tr>
    		<tr><td colspan=2><input type="submit" value="修改用户"></td></tr>
		</table>
	</form>
</html>