<?php
    require_once 'EmpService.class.php';
	if(!empty($_GET['id']))
	{
	    if($_GET['flag']=="delete")//说明点击的是删除按键 
	    {
	        $id=$_GET['id'];
	        $empService=new EmpSerivce();
	        $b=$empService->deleteRow($id);
	        if($b==1)
	        {
	            header("Location:OK.php");
	        }
	        else
	        {
	            header("Location:error.php");
	        }
	    }
	}
?>