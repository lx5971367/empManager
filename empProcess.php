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
    	    if(empty($_POST['name']) or empty($_POST['email']) or empty($_POST['level']))
    	    {
    	        echo "信息填写不全，请返回重新填写";
    	        echo "<a href='empInsert.php'>返回</a>";
    	    }
    	    else
    	    {
    	        $emp=new Emp();
    	        $emp->name=$_POST['name'];
    	        $emp->email=$_POST['email'];
    	        $emp->level=$_POST['level'];
    	        $empService=new EmpService();
    	        $b=$empService->insertRow($emp);//用面向对象的思想 ，传递一个对象实例，也就是一行
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
    	if($_REQUEST['flag']=='update')
    	{
    	    if(empty($_POST['name']) or empty($_POST['email']) or empty($_POST['level']))
    	    {
    	        echo "信息填写不全，请返回重新填写";
    	        echo "<a href='empUpdate.php?id=".$_POST['id']."'>返回</a>";
    	    }
    	    else
    	    {
    	        $emp=new Emp();
    	        $emp->id=$_POST['id'];
    	        $emp->name=$_POST['name'];
    	        $emp->email=$_POST['email'];
    	        $emp->level=$_POST['level'];
    	        $empService=new EmpService();
    	        $b=$empService->updateRow($emp);//用面向对象的思想 ，传递一个对象实例，也就是一行
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