<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>雇员信息列表</title>
	</head>
</html>
<?php
    require_once 'EmpService.class.php';
    require_once 'FenYePage.class.php';

    //创建一个FenYePage对象实例
    $fenYePage=new FenYePage();
    $fenYePage->pageNow=1;
    if(!empty($_GET['pageNow']))
    {
        $fenYePage->pageNow=$_GET['pageNow'];
    }
    $fenYePage->pageSize=6;
    $empService=new EmpSerivce();
    $empService->getFenYePage($fenYePage);//调用该函数后，$fenYePage里的所有成员变量的值都有了
    
    
	//显示所有用户信息，用表格方式

	echo "<table border=1>";
	echo "<tr><td>id</td><td>name</td><td>email</td><td>level</td><td>change</td><td>delete</td></tr>";
	for($i=0;$i<count($fenYePage->resArray);$i++)//取出二维数组的值
	{
	    $row=$fenYePage->resArray[$i];
	    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td>".
	    "<td>{$row['level']}</td><td><a href=#&id={$row['id']}>修改本行</a></td><td><a href=#&id={$row['id']}>删除本行</a></td></tr>";
	    
	}
	echo "</table>";

	//实现分页功能
	echo $fenYePage->navigate;
	
	//实现批量分页功能
	echo $fenYePage->navigateBatch;
?>
<form action="empList.php">
	<input type="text" name="pageNow">
	<input type="submit" value="跳转">
</form>
