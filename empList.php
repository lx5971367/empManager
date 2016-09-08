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
	//分页显示
	$pageSize=4;//每个页面显示4条记录，自定义
	$rowCount=0;//记录的总数，通过数据库取出数据
    $pageNow=1;//表示当前页，用户通过超链接选择,初始化显示第一页
	$pageCount=0;//表示共有多少页，通过算法计算出来	
	$sql="select count(id) from emp";//查询出共有多少个数据
	$resCount=$mysqli->query($sql);
	if($rowOne=$resCount->fetch_row())
	{
	    $rowCount=$rowOne[0];//得到rouCount的值
	}
	//计算共有多少页 
	$pageCount=ceil($rowCount/$pageSize);
    //设计点击某一页，显示为当前页时，接收回传的参数 。pageNow的值
    if(!empty($_GET['pageNow']))
    {
        $pageNow=$_GET['pageNow'];
    }
    if(!empty($_GET['pageChange']))
    {
        $pageNow=$pageNow+$_GET['pageChange'];
        if($pageNow<1)//连接按上一页，超过了限制值，则一直显示首页
        {
            $pageNow=1;
        }
        elseif ($pageNow>$pageCount)//连接按下一页，超过了限制值，则一直显示尾页
        {
            $pageNow=$pageCount;
        }
    }
	$res=$mysqli->query("select * from emp limit ".$pageSize*($pageNow-1).",{$pageSize}");
	echo "<table border=1>";
	echo "<tr><td>id</td><td>name</td><td>email</td><td>level</td><td>change</td><td>delete</td></tr>";
	while ($row=$res->fetch_assoc())
	{
	    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td>".
	    "<td>{$row['level']}</td><td><a href=#?id={$row['id']}>修改本行</a></td><td><a href=#&id={$row['id']}>删除本行</a></td></tr>";
	}
	echo "</table>";
	//第一种分页方式，每一页都用相应的数字显示
	/*for($i=1;$i<=$pageCount;$i++)
	{
	    echo "<a href=empList.php?pageNow=".$i.">$i</a>&nbsp";//显示超链接的页数
	}*/
	//第二种分页方式，用首页、上一页、下一页、尾页显示
    echo "<a href=empList.php?pageNow=1>首页</a>&nbsp<a href=empList.php?pageChange=-1&pageNow=".$pageNow.">上一页</a>&nbsp".
        "<a href=empList.php?pageChange=1&pageNow=".$pageNow.">下一页</a>&nbsp".//因为初始化了pageNow的值为1，所以每次点击超链接跳回到该页面都会初始化pageNow
	    "<a href=empList.php?pageNow=".$pageCount.">尾页</a>&nbsp";//的值，所有在上一页、下一页的超链接中也带上pageNow的参数，即可表示点击这两个超链接之前的真正当前页是第几页
	
	
	$resCount->free();
	$res->free();
	$mysqli->close();
	
?>