<?php
    require_once 'EmpService.class.php';
    require_once 'Emp.class.php';
    if(!empty($_REQUEST['flag']))
    {
        if($_REQUEST['flag']=="delete")//说明点击的是删除按键 ，因为有GET也有POST方法，所有统一用REQUEST
        {
            $id=$_GET['id'];
            $empService=new EmpService();
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
    	if($_REQUEST['flag']=="insert")//说明点击的是插入,因为有GET也有POST方法，所有统一用REQUEST
    	{
    	    if(empty($_POST['username']) or empty($_POST['email']) or empty($_POST['level']))
    	    {
    	        echo "信息填写不全，请返回重新填写";
    	        echo "<a href='empInsert.php'>返回</a>";
    	    }
    	    else
    	    {
    	        $emp=new Emp();
    	        $emp->name=$_POST['username'];
    	        $emp->email=$_POST['email'];
    	        $emp->level=$_POST['level'];
    	        $empService=new EmpService();
    	        $b=$empService->insertRow($emp);
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
    }

?>