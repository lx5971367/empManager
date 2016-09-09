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
	    
	}
?>