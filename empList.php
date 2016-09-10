<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>雇员信息列表</title>
	</head>
</html>
<?php
    require_once 'EmpService.class.php';
	//显示所有用户信息，用表格方式

	//分页显示
	$pageSize=25;//每个页面显示4条记录，自定义
	$rowCount=0;//记录的总数，通过数据库取出数据
    $pageNow=1;//表示当前页，用户通过超链接选择,初始化显示第一页
	$empService=new EmpSerivce();
    $pageCount=$empService->getPageCount($pageSize);//表示共有多少页，通过算法计算出来	
    //设计点击某一页，显示为当前页时，接收回传的参数 。pageNow的值
    if(!empty($_GET['pageNow']))
    {
        $pageNow=$_GET['pageNow'];
    }
    /*
    if(!empty($_GET['pageChange']))//第二种分页方式用
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
    }*/
	echo "<table border=1>";
	echo "<tr><td>id</td><td>name</td><td>email</td><td>level</td><td>change</td><td>delete</td></tr>";
	$arr=$empService->getEmplistByPage($pageNow, $pageSize);
	for($i=0;$i<count($arr);$i++)//取出二维数组的值
	{
	    $row=$arr[$i];
	    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td>".
	    "<td>{$row['level']}</td><td><a href=#&id={$row['id']}>修改本行</a></td><td><a href=#&id={$row['id']}>删除本行</a></td></tr>";
	    
	}
	/*while ($row=$res->fetch_assoc())
	{
	    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td>".
	    "<td>{$row['level']}</td><td><a href=#&id={$row['id']}>修改本行</a></td><td><a href=#&id={$row['id']}>删除本行</a></td></tr>";
	}*/
	echo "</table>";
	//第一种分页方式，每一页都用相应的数字显示
	/*for($i=1;$i<=$pageCount;$i++)
	{
	    echo "<a href=empList.php?pageNow=".$i.">$i</a>&nbsp";//显示超链接的页数
	}*/
	//第二种分页方式，用首页、上一页、下一页、尾页显示
    /*echo "<a href=empList.php?pageNow=1>首页</a>&nbsp<a href=empList.php?pageChange=-1&pageNow=".$pageNow.">上一页</a>&nbsp".
        "<a href=empList.php?pageChange=1&pageNow=".$pageNow.">下一页</a>&nbsp".//因为初始化了pageNow的值为1，所以每次点击超链接跳回到该页面都会初始化pageNow
	    "<a href=empList.php?pageNow=".$pageCount.">尾页</a>&nbsp";//的值，所有在上一页、下一页的超链接中也带上pageNow的参数，即可表示点击这两个超链接之前的真正当前页是第几页
    */
    //第三种分页方式
    echo "<a href=empList.php?pageNow=1>首页</a>&nbsp";
    if($pageNow>1)
    {
        $pagePre=$pageNow-1;
        echo "<a href=empList.php?pageNow=".$pagePre.">上一页</a>&nbsp";
    }
    if($pageNow<$pageCount)
    {
        $pageNex=$pageNow+1;
        echo "<a href=empList.php?pageNow=".$pageNex.">下一页</a>&nbsp";
    }
    echo  "<a href=empList.php?pageNow=".$pageCount.">尾页</a>&nbsp";
    echo "当前{$pageNow}页/共有{$pageCount}页";
    echo "</br>";
    //实现批量翻页功能
    $pageRange=ceil($pageNow/5);//表示在第几个翻页范围，每个翻页范围显示5页
    $pageRangeNum=array();//每个翻页范围是一个等差数组
    $pageRangeNum[0]=5*$pageRange-4;//初始化每个翻页范围的起始页
    for($i=1;$i<=4;$i++)//按序添加每个翻页范围的等差数组
    {
        $pageRangeNum[$i]=$pageRangeNum[$i-1]+1;
    }
    $pageRangeNum['preRangeStart']=$pageRangeNum[0]-5;//上一页翻页范围的起始页
    if($pageRangeNum['preRangeStart']<1)
    {
        $pageRangeNum['preRangeStart']=1;
    }
    $pageRangeNum['nextRangeStart']=$pageRangeNum[0]+5;//下一页翻页范围的起始页
    if($pageRangeNum['nextRangeStart']>$pageCount)
    {
        $pageRangeNum['nextRangeStart']=$pageCount-4;
    }
    echo "<a href=empList.php?pageNow=".$pageRangeNum['preRangeStart']."><<</a>&nbsp";//连续向上翻5页
    if($pageNow != $pageCount && $pageCount>5)//当当前页不是最后一页时，就显示5个翻页范围的数组 
    {
        echo "<a href=?pageNow=".$pageRangeNum[0].">".$pageRangeNum[0]."</a>&nbsp";
        echo "<a href=?pageNow=".$pageRangeNum[1].">".$pageRangeNum[1]."</a>&nbsp";
        echo "<a href=?pageNow=".$pageRangeNum[2].">".$pageRangeNum[2]."</a>&nbsp";
        echo "<a href=?pageNow=".$pageRangeNum[3].">".$pageRangeNum[3]."</a>&nbsp";
        echo "<a href=?pageNow=".$pageRangeNum[4].">".$pageRangeNum[4]."</a>&nbsp";
    }
    elseif($pageCount>5) //当前页是最后一页时
    {
        for($i=0;$i<=4;$i++)
        {
            if($pageRangeNum[$i]<=$pageCount)
            {
                echo "<a href=?pageNow=".$pageRangeNum[$i].">".$pageRangeNum[$i]."</a>&nbsp";
            }
        }
    }
    echo "<a href=empList.php?pageNow=".$pageRangeNum['nextRangeStart'].">>></a>"; //连接向下翻5页 
    //指定跳转到某一页
?>
<form action="empList.php">
	<input type="text" name="pageNow">
	<input type="submit" value="跳转">
</form>
