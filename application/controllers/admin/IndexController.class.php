<?php
    class Indexcontroller extends BaseController{
        //生成验证码
        public function codeAction(){
            $this->library('Captcha');
            $c = new Captcha();
            $c->generateCode();
        }

        public function indexAction(){
            include CUR_VIEW_PATH."index.html";
        }
        
        public function topAction(){
            include CUR_VIEW_PATH."top.html";
        }
        public function menuAction(){
            include CUR_VIEW_PATH."menu.html";
        }
        public function dragAction(){
            include CUR_VIEW_PATH."drag.html";
        }
        public function mainAction(){
            include CUR_VIEW_PATH."main.html";
        }
    }
    