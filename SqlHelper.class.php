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
	    public function executeDqlFenYe($sql1,$sql2,$fenYePage)//引用传递，利用这个函数，把FenYePage中的成员变量的值利用实例$fenYePage得到，
	    {
	        $arr=array();
	        $res=$this->mysqli->query($sql1) or die($this->mysqli->connect_error);
	        $i=0;
	        while ($row=$res->fetch_assoc())
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
	        
	        
	        
	        //第三种分页方式，上一页，下一页的分页方式
	        $navigate="";
	        $navigate="<a href={$fenYePage->gotoUrl}?pageNow=1>首页</a>&nbsp";
	        if($fenYePage->pageNow>1)
	        {
	            $pagePre=$fenYePage->pageNow-1;
	            $navigate.="<a href={$fenYePage->gotoUrl}?pageNow=".$pagePre.">上一页</a>&nbsp";
	        }
	        if($fenYePage->pageNow<$fenYePage->pageCount)
	        {
	            $pageNex=$fenYePage->pageNow+1;
	            $navigate.="<a href={$fenYePage->gotoUrl}?pageNow=".$pageNex.">下一页</a>&nbsp";
	        }
	        $navigate.="<a href={$fenYePage->gotoUrl}?pageNow=".$fenYePage->pageCount.">尾页</a>&nbsp";
	        $navigate.="当前{$fenYePage->pageNow}页/共有{$fenYePage->pageCount}页";
	        $fenYePage->navigate=$navigate;
	        
	        
	        
	        
	        //改进版的实现批量翻页功能
	        $navigateBatch;
	        $pageRangeNum=10;//每次实现批量翻几页
	        $pageRange=ceil($fenYePage->pageNow/$pageRangeNum);//表示在第几个翻页范围
	        if($fenYePage->pageCount>$pageRangeNum)//总页数大于$pageRangeNum时，实现批量翻页才会有意义
	        {
	            $pageRangeNumStart=1+($pageRange-1)*$pageRangeNum;//每一个翻页范围的起始值是一个等差数组
	            $pageRangeNumStartTemp=$pageRangeNumStart;//把起始值储存起来 ，以便做循环使用
	            $pageRangePreNumStart=$pageRangeNumStart-$pageRangeNum;//上一页翻页范围的起始页
	            if($pageRangePreNumStart<1)
	            {
	                $pageRangePreNumStart=1;
	            }
	            $pageRangeNextNumStart=$pageRangeNumStart+$pageRangeNum;//下一页翻页范围的起始页
	            $navigateBatch="<a href={$fenYePage->gotoUrl}?pageNow=".$pageRangePreNumStart."><<</a>&nbsp";//连续向上翻页
	            if($fenYePage->pageNow < ($fenYePage->pageCount-($fenYePage->pageCount%$pageRangeNum)+1))//当当前页不是最后一个翻页范围或最后一个翻页范围的页数与$pageRangeNum相等时
	            {
	                if($pageRangeNextNumStart>$fenYePage->pageCount)//当在最后一个翻页范围时
	                {
	                    $pageRangeNextNumStart=$fenYePage->pageCount-$pageRangeNum+1;//向下翻页链接的值就直接设置为本页的开始值
	                }
	                for(;$pageRangeNumStart<$pageRangeNumStartTemp+$pageRangeNum;$pageRangeNumStart++)//按序添加每个翻页范围的等差数组
	                {
	                    $navigateBatch.="<a href={$fenYePage->gotoUrl}?pageNow=".$pageRangeNumStart.">".$pageRangeNumStart."</a>&nbsp";
	                }
	            }
	            elseif($fenYePage->pageNow >= ($fenYePage->pageCount-($fenYePage->pageCount%$pageRangeNum)+1)) //当当前页在最后一个翻页范围时,且最后一个翻页范围的页数小于$pageRangeNum，按实际需求显示几个分页链接
	            {
	                 
	                for(;$pageRangeNumStart<$pageRangeNumStartTemp+$pageRangeNum;$pageRangeNumStart++)
	                {
	                    if($pageRangeNumStart<=$fenYePage->pageCount)
	                    {
	                         $navigateBatch.="<a href={$fenYePage->gotoUrl}?pageNow=".$pageRangeNumStart.">".$pageRangeNumStart."</a>&nbsp";
	                    }
	                }
	                $pageRangeNextNumStart=$fenYePage->pageCount;//向下翻页链接的值就直接设置为本页的结束值
	            }
	             $navigateBatch.="<a href={$fenYePage->gotoUrl}?pageNow=".$pageRangeNextNumStart.">>></a>"; //连接向下翻页
	             $fenYePage->navigateBatch=$navigateBatch;
	        }
	    }
	    
	    
	    
	    public function executeDml($sql)
	    {
	        $b=$this->mysqli->query($sql);
	        if(!$b)
	        {
	            die("操作失败".$this->mysqli->connect_error);
	            return 0;
	        }
	        else 
	        {
	            if($this->mysqli->affected_rows>0)
	            {
	                return 1;
	                echo "操作成功";
	            }
	            else 
	            {
	                return 2;
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