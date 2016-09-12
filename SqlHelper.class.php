<?php
	//这是一个工具类,完成对数据库的操作
	class SqlHelper
	{
	    private $mysqli;
	    private static $host="localhost";
	    private static $username="root";
	    private static $password="lx128SIMON";
	    private static $database="study";
	    
	    public function __construct()
	    {
	        $this->mysqli=new MySQLi(SqlHelper::$host,SqlHelper::$username,SqlHelper::$password,SqlHelper::$database);
	        if($this->mysqli->connect_error)
	        {
	            die("连接失败".$this->mysqli->connect_error);
	        }
	        $this->mysqli->query("set names utf8");
	    }
	    
	    public function executeDql($sql)
	    {
	        $res=$this->mysqli->query($sql) or die($this->mysqli->connect_error);
	        return $res;
	    }
	    
	    
	    public function executeDqlArray($sql)//把结果集存入数组当中，这样就可以及时的释放结果集了
	    {
	        $arr=array();
	        $res=$this->mysqli->query($sql) or die($this->mysqli->connect_error);
	        $i=0;
	        while ($row=$res->fetch_assoc())//把结果集的内容及时转移到数组中
	        {
	            $arr[$i++]=$row;
	        }
	        $res->free();//及时释放结果集
	        return $arr;
	        
	    }
	    
	    
	    //这是一个通用的，并体现了面向对象编程的思想 。
	    public function executeDqlFenYe($sql1,$sql2,&$fenYePage)//引用传递，利用这个函数，把FenYePage中的成员变量的值利用实例$fenYePage得到，
	    {
	        $arr=array();
	        $res=$this->mysqli->query($sql1) or die($this->mysqli->connect_error);
	        $i=0;
	        while ($row=$res->fetch_row())
	        {
	            $arr[$i++]=$row;
	        }
	        $res->free();
	        $fenYePage->resArray=$arr;
	        
	        $res2=$this->mysqli->query($sql2) or die($this->mysqli->connect_error);
	        if($row=$res2->fetch_row())
	        {
	            $fenYePage->rowCount=$row[0];
	            $fenYePage->pageCount=ceil($row[0]/$fenYePage->pageSize);
	        }
	        $res2->free();
       
	    }
	    
	    
	    
	    public function executeDml($sql)
	    {
	        $b=$this->mysqli->query($sql);
	        if(!$b)
	        {
	            die("操作失败".$this->mysqli->connect_error);
	        }
	        else 
	        {
	            if($this->mysqli->affected_rows>0)
	            {
	                echo "操作成功";
	            }
	            else 
	            {
	                echo "没有影响到行数";
	            }
	            
	        }
	    }
	    
	    public function closeConnect()
	    {
	        if(!empty($this->mysqli))
	        {
	            $this->mysqli->close();
	        }
	    }
	    
	    
	}
?>