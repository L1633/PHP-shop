<?php
class LoginController extends Controller{
    
    public function loginAction(){
        include CUR_VIEW_PATH."login.html";
    }

    public function signinAction(){
        //收集表单数据
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        //引入辅助函数
        $this->helper('input');
        //对用户名和密码进行转义
        $username = deepslashes($username);
        $password = deepslashes($password);
        //获取验证码
        $captcha = trim($_POST['captcha']);
        //先校验验证码
        // if($captcha !== strtolower($_SESSION['captcha']) ){
        //       $this->jump('index.php?p=admin&c=login&a=login','验证码不正确',0);
        // }
        //密码加密 进行验证
        $password = md5($password);
        //调用模型验证
        $admin = new AdminModel('admin');
        $user = $admin->checkUser($username,$password);
        // var_dump($user);
        if($user){
            //登录成功，保存登录标识符
            $_SESSION['admin'] = $user;
            $this->jump('index.php?p=admin&c=index&a=index','',0);
        }else{
            $this->jump('index.php?p=admin&c=login&a=login','用户名或密码错误');
        }
    }
    //退出
    public function logoutAction(){
        //删除登录标识符
        unset($_SESSION['admin']);
        //销毁session
        session_destroy();
        //跳转
        $this->jump('index.php?p=admin&c=login&a=login','',0);
    }

    //验证码
    public function captchaAction(){
        //引入验证码类
        $this->library('Captcha');
        //实例化
        $captcha = new Captcha();
        //生成验证码
        $captcha->generateCode();
        //将验证码保存到session中
        $_SESSION['captcha'] = $captcha->getCode();
    }

}
