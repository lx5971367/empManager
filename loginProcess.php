<?php
    require_once 'AdminService.class.php';
	//接收用户数据
	$id=$_POST['id'];
	$password=$_POST['password'];
	if(empty($id) or empty($password))
	{
	    header("Location:login.php?error=2");
	    exit();
	}
    
	//实例化一个AdminService的方法 
	$adminService=new AdminService();
	$name=$adminService->checkAdmin($id, $password);
	if($name!="")
	{
	    header("Location:empManager.php?name=$name");//取出用户的名字
	    exit();
	}
	else 
	{
	    header("Location:login.php?error=1");
	    exit();
	}
?>