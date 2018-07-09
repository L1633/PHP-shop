<?php
    //核心控制器  基础控制器
    class Controller{
        //跳转方法
        public function jump($url,$message,$wait=2){
            if($time == 0){
                header("Location:$url");
            }else{
                include CUR_VIEW_PATH."message.html";
            }
            die();//一定要退出  
        }
        //引入工具类
        public function library($lib){
            include LIB_PATH."{$lib}.class.php";
        }
        //引入辅助函数方法
        public function helper($help){
            include HELP_PATH."{$help}.php";
        }
    }
