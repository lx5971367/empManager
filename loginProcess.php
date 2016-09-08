<?php
	//接收用户数据
	$id=$_POST['id'];
	$password=$_POST['password'];
	
	//简单验证，不到数据库
	if($id==1 && $password=="admin")
	{
	    header("Location:empManager.php");
	    //如果要跳转了，则最好带上exit();
	    exit();
	}
	else 
	{
	    header("Location:login.php?error=1");//携带一个信息回去
	}
?>