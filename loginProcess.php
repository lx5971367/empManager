<?php
	//接收用户数据
	$id=$_POST['id'];
	$password=$_POST['password'];
	
	//简单验证，不到数据库
	/*if($id==1 && $password=="admin")
	{
	    header("Location:empManager.php");
	    //如果要跳转了，则最好带上exit();
	    exit();
	}
	else 
	{
	    header("Location:login.php?error=1");//携带一个信息回去
	}*/
	
	//用数据库的方法进行验证
	$mysqli=new MySQLi("localhost","root","lx128SIMON","study");
	if($mysqli->connect_error)
	{
	    die("连接失败".$mysqli->connect_error);   
	}
	$mysqli->query("set names utf8");
	$res=$mysqli->query("select password,name from admin where id = $id");
	if($row=$res->fetch_assoc())
	{
	    if($row['password'] == $password)
	    {
	        header("Location:empManager.php?name=".$row['name']."");//取出用户的名字
	        exit();
	    }
	}
	header("Location:login.php?error=1");
	exit();
?>