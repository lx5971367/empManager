<?php
    require_once 'SqlHelper.class.php';
	//主要用来完成对admin表的各种操作
	class AdminService
	{
	    
	    private $sqlHelper;
	     
	    function __construct()
	    {
	        $this->sqlHelper=new SqlHelper();//用构造方法来实例化
	    }
	    //提供一个验证用户是否合法的方法
	    public function checkAdmin($id,$password)
	    {
	        $sql="select password,name from admin where id = $id";
	        $res=$this->sqlHelper->executeDql($sql);
	        if($row=$res->fetch_assoc())
	        {
	            if(md5($password)==($row['password']))
	            {
	                return $row['name'];
	            }
	        }
	        //关闭资源
	        $res->free();
	        return "";
	    }
	}
?>