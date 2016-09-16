<?php
    require_once 'SqlHelper.class.php';
	class EmpService
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
	    
	    public function deleteRow($id)
	    {
	        $sqlHelper=new SqlHelper();
	        $sql="delete from emp where id = $id";
	        $b=$sqlHelper->executeDml($sql);
	        $sqlHelper->closeConnect();
	        return $b;
	    }
	    
	    public function insertRow($emp)
	    {
	        $sqlHelper=new SqlHelper();
	        $sql="insert into emp (name,email,level) values ('".$emp->name."','".$emp->email."',".$emp->level.")";//如果插入的是字符
	        //一定不要忘记了字符的格式，要不然会插入不成功
	        $b=$sqlHelper->executeDml($sql);
	        $sqlHelper->closeConnect();
	        return $b;
	    }
	    
	    
	    public function getEmpById($id)
	    {
	        $sqlHelper=new SqlHelper();
	        $sql="select * from emp where id = $id";
	        $arr=$sqlHelper->executeDqlArray($sql);
	        //把数据二次封装到实例中,用面向对象的思想，封装一个实例，再把实例返回
	        $emp=new Emp();
	        $emp->id=$arr[0]['id'];
	        $emp->name=$arr[0]['name'];
	        $emp->email=$arr[0]['email'];
	        $emp->level=$arr[0]['level'];
	        $sqlHelper->closeConnect();
	        return $emp;
	    }
	    
	    public function updateRow($emp)
	    {
	        $sqlHelper=new SqlHelper();
	        $sql="update emp set name='".$emp->name."',email='".$emp->email."',level='".$emp->level."' where id='".$emp->id."'";
	        $b=$sqlHelper->executeDml($sql);
	        $sqlHelper->closeConnect();
	        return $b;
	    }
	    
	    
	    
	    
	}
?>