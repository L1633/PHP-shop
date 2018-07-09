<?php
class BrandController extends BaseController{

    //商品首页
    public function indexAction(){
        $BrandModel = new BrandModel('brand');
        $brands = $BrandModel->getbrands();

        include CUR_VIEW_PATH."brand_list.html";
    }

    public function addAction(){
        
        include CUR_VIEW_PATH."brand_add.html";
    }

    public function insertAction(){
        //收集表单信息
        $data['brand_name'] = trim($_POST['brand_name']);
        $data['url'] = trim($_POST['url']);
        $data['brand_desc'] = trim($_POST['brand_desc']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = $_POST['is_show'];
        //创建模型处理数据
        $BrandModel = new BrandModel('brand');
         //做相应的验证和处理
        if($data['brand_name'] == ''){
            $this->jump('index.php?p=admin&c=brand&a=add','品牌名称不能为空');
        }
        if($BrandModel->insert($data)){
            $this->jump('index.php?p=admin&c=brand&a=index','添加品牌成功',2);
        }else{
            $this->jump('index.php?p=admin&c=brand&a=add','添加品牌失败');
        }

        
    }

    public function editAction(){

        include CUR_VIEW_PATH."brand_edit.html";
    }

    public function deleteAction(){
        //获取品牌id
        $brand_id = $_GET['brand_id'] + 0;
        //创建模型处理数据
        $BrandModel = new BrandModel('brand');
        
        if($BrandModel->delete($brand_id)){
            $this->jump('index.php?p=admin&c=brand&a=index','移除成功');
        }else{
            $this->jump('index.php?p=admin&c=brand&a=index','移除失败');
        }
    }
}