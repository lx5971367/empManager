<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>雇员信息列表</title>
	</head>
</html>
<?php
	//显示所有用户信息，用表格方式
	$mysqli=new MySQLi("localhost","root","lx128SIMON","study");
	if($mysqli->connect_error)
	{
	    die("连接失败".$mysqli->connect_error);
	}
	$mysqli->query("set names utf8");
	$res=$mysqli->query("select * from emp");
	echo "<table border=1>";
	echo "<tr><td>id</td><td>name</td><td>email</td><td>level</td></tr>";
	while ($row=$res->fetch_assoc())
	{
	    echo "<tr><td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['level']."</td></tr>";
	}
	echo "</table>";
	
?>