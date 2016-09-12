<?php
    require_once 'SqlHelper.class.php';
	class EmpSerivce
	{
	    /*private $sqlHelper;//如果用构造函数的方法来实例化，则不能在每个成员函数中去关闭连接，因为在一个函数中关闭了连接，等于把实例化也关闭掉了。
	    
	    function __construct()
	    {
	        $this->sqlHelper=new SqlHelper();//用构造方法来实例化
	    }*/
	    //获取共有多少页
	    public function getPageCount($pageSize)//要在成员函数中关闭链接，则必须在每个成员函数中去实例化
	    {
	        $sqlHelper=new SqlHelper();
	        $sql="select count(id) from emp";
	        $res=$sqlHelper->executeDql($sql);
	        if($row=$res->fetch_row())
	        {
	            $pageCount=ceil($row[0]/$pageSize);
	        }
	        $res->free();//释放资源
	        $sqlHelper->closeConnect();//关闭连接
	        return $pageCount;     
	    }
	    
	    public function getEmplistByPage($pageNow,$pageSize)
	    {
	        $sqlHelper=new SqlHelper();
	        $sql="select * from emp limit ".($pageNow-1)*$pageSize.",$pageSize";
	        $arr=$sqlHelper->executeDqlArray($sql);
	        $sqlHelper->closeConnect();
	        return $arr;
	    }
	    
	    public function getFenYePage($fenYePage)
	    {
	        $sqlHelper=new SqlHelper();
	        $sql1="select * from emp limit ".($fenYePage->pageNow-1)*$fenYePage->pageSize.",$fenYePage->pageSize";
	        $sql2="select count(id) from emp";
	        $sqlHelper->executeDqlFenYe($sql1, $sql2, $fenYePage);
	        $sqlHelper->closeConnect();
	    }
	    
	    
	    
	    
	}
?>