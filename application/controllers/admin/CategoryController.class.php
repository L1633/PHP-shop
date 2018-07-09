<?php
class CategoryController extends BaseController{
    //商品分类index页面 获取所有商品list
    public function indexAction(){
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getCats();//结果是二维数组
        include CUR_VIEW_PATH."cat_list.html";
    }

    //显示添加商品分类表单 中的上级分类
    public function addAction(){
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getCats();//结果是二维数组
        include CUR_VIEW_PATH."cat_add.html";
    }

    public function insertAction(){
        //收集表单post信息
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        
        $data['cat_desc'] = trim($_POST['cat_desc']);
        //对于描述内容进行转义
        $data['cat_desc'] = htmlspecialchars($data['cat_desc']);
        
        $data['parent_id'] = $_POST['parent_id'];
        $data['is_show'] = $_POST['is_show'];
        //做相应的验证和处理
        if($data['cat_name'] == ''){
            $this->jump('index.php?p=admin&c=category&a=add','分类名称不能为空');
        }
        //调用模型添加到数据库并给出提示
        $categoryModel = new CategoryModel('category');
        if($categoryModel->insert($data)){
            $this->jump('index.php?p=admin&c=category&a=index','添加分类成功',2);
        }else{
            $this->jump('index.php?p=admin&c=category&a=add','添加分类失败');
        }
    }
    //编辑方法，展示编辑的原本视图和内容
    public function editAction(){
        //获取传递过来的cat_id
        //+0 是为了得到的是一个数字类型
        $cat_id = $_GET['cat_id'] + 0;
        //获取该类的原本的信息内容，展现在页面上
        $categoryModel = new CategoryModel('category');
        //获取当前修改项的信息
        $cat = $categoryModel->selectByPk($cat_id);
        //获取所有分类的信息
        $cats = $categoryModel->getCats();//结果是二维数组

        include CUR_VIEW_PATH."cat_edit.html";
    }
    //编辑过后修改数据库中的内容
    public function updateAction(){
        //1.收集表单数据
		$data['cat_name'] = trim($_POST['cat_name']);
		$data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        
        $data['cat_desc'] = trim($_POST['cat_desc']);
        //对于描述内容进行转义
        $data['cat_desc'] = htmlspecialchars($data['cat_desc']);

		$data['parent_id'] = $_POST['parent_id'];
        $data['is_show'] = $_POST['is_show'];
        //重要的 cat_id 不能少
        $data['cat_id'] = $_POST['cat_id']; 
        //2.验证及处理
		if ($data['cat_name'] == '') {
			$this->jump('index.php?p=admin&c=category&a=add','分类名称不能为空');
		}
        $categoryModel = new CategoryModel('category');
        //获取该类的所有后代id
        $ids = $categoryModel->getSubIds($data['cat_id']);
        //判断当前选择的是不是该类的后代类
        //后代类不能作为自己的上类分级
        if(in_array($data['parent_id'],$ids)){
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}",
				'不能将当前分类的后代或者自己作为其上级分类');
        }
        $cats = $categoryModel->update($data); 
        if($categoryModel->update($data)){
            $this->jump('index.php?p=admin&c=category&a=index','编辑成功');
        }else{
            $this->jump('index.php?p=admin&c=category&a=index','编辑失败');
        }
    }

    public function deleteAction(){
        //获取商品 cat_id;
        $cat_id = $_GET['cat_id'] + 0;
        $categoryModel = new CategoryModel('category');
        //获取该类所有的后代id
        $ids = $categoryModel->getSubIds($cat_id);
        //判断数组内除了自己是否还有其他子类
        if(count($ids)>1){
            $this->jump('index.php?p=admin&c=category&a=index','当前分类有后代分类，不能删除，请先删除后代分类');
		}
        $cats = $categoryModel->delete($cat_id);
        if($categoryModel->delete($cat_id)){
            $this->jump('index.php?p=admin&c=category&a=index','移除成功');
        }else{
            $this->jump('index.php?p=admin&c=category&a=index','移除失败');
        }
    }
    
}