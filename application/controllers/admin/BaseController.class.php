<?php
class BaseController extends Controller{
    //构造方法
    public function __construct(){
        $this->checkLogin();
    }
    //判断是否登录
    public function checkLogin(){
        if(!isset($_SESSION['admin'])){
            $this->jump('index.php?p=admin&c=login&a=login','请登录');
        }
    }
}