<?php
    class Framework{
        //定义一个run方法
        public static function run(){
        //初始化
            static::init();
            static::autoload();
            static::dispath();

        }
        //初始化
        private static function init(){
            //定义常量路径
            define("DS",DIRECTORY_SEPARATOR);
            //根目录
            define("ROOT",getcwd().DS);
            //其他目录
            define("APP_PATH",ROOT."application".DS);
            define("FRAMEWORK_PATH",ROOT."framework".DS);
            define("PUBLIC_PATH",ROOT."public".DS);
            define("CONFIG_PATH",APP_PATH."config".DS);
            define("CONTROLLER_PATH",APP_PATH."controllers".DS);
            define("MODEL_PATH",APP_PATH."models".DS);
            define("VIEW_PATH",APP_PATH."views".DS);
            define("CORE_PATH",FRAMEWORK_PATH."core".DS);
            define("DB_PATH",FRAMEWORK_PATH."databases".DS);
            define("HELP_PATH",FRAMEWORK_PATH."helpers".DS);
            define("LIB_PATH",FRAMEWORK_PATH."libraries".DS);
            define("UPLOAD_PATH",PUBLIC_PATH."uploads".DS);
            //获取参数p 平台,c 控制器,a 动作
            define("PLATFORM",isset($_GET['p'])?$_GET['p']:"admin");
            define("CONTROLLER",isset($_GET['c'])?ucfirst($_GET['c']):"Index");
            define("ACTION",isset($_GET['a'])?$_GET['a']:"index");
            //设置当前控制器和视图目录
            define("CUR_CONTROLLER_PATH",CONTROLLER_PATH.PLATFORM.DS);
            define("CUR_VIEW_PATH",VIEW_PATH.PLATFORM.DS);
            //载入配置文件
            $GLOBALS['config'] = include CONFIG_PATH.'config.php';
            //载入核心类
            include CORE_PATH."Controller.class.php";
            include CORE_PATH."Model.class.php";
            include DB_PATH."Mysql.class.php";

            //开启session
            session_start();
            
        }
        
        //路由器分发，就是实例化对象并调用方法
        private static function dispath(){
            //获取控制器名称
            $controller_name = CONTROLLER."Controller";
            //获取动作名称
            $action_name = ACTION."Action";
            //实例化控制器对象
            $controller = new $controller_name();
             //调用方法
            $controller->$action_name(); 
        }

        //自动加载函数
        private static function load($classname){
            if(substr($classname,-10) == "Controller"){
                 //载入控制器
                include CUR_CONTROLLER_PATH."{$classname}.class.php";
            }elseif (substr($classname,-5) == "Model") {
                include MODEL_PATH."{$classname}.class.php";
            }else{

             }
        }

        //注册为自动加载函数
        private static function autoload(){
            $arr = array(__CLASS__,"load");
            spl_autoload_register($arr);
        }

    }