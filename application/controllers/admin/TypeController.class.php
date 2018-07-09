<?php  
class TypeController extends BaseController{

    public function indexAction(){
        //获取所有信息 并在页面上展示
        $TypeModel = new TypeModel('goods_type');
        // $types = $TypeModel-> gettypes();
        // include CUR_VIEW_PATH."goods_type_list.html";
        //默认是第一页
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        //设置每页显示数目
        $pagesize = 3;
        $offset = ($current-1)*$pagesize;
        $types = $TypeModel->getPageTypes($offset,$pagesize);
        //载入分页类
        $this->library('Page');
        //获取总记录数
        $where = '';
        $total = $TypeModel->total($where);
        //创建page对象， 传递参数
        $page = new page($total,$pagesize,$current,'index.php',array('p'=>'admin','c'=>'type','a'=>'index'));
        $pageinfo = $page->showPage();
        //载入模板页面
        include CUR_VIEW_PATH."goods_type_list.html";
    }

    public function addAction(){
        include CUR_VIEW_PATH."goods_type_add.html";
    }

    public function insertAction(){
        //收集表单数据
        $data['type_name'] = $_POST['type_name'];
        //做相应的验证和处理

        if($data['type_name'] == ''){
            $this->jump('index.php?p=admin&c=type&a=add','商品类型名称不能为空');
        }
        //对输入的数据做转义和实体的处理
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        //调用模型添加到数据库并给出提示
        $TypeModel = new TypeModel('goods_type');
        if($TypeModel->insert($data)){
            $this->jump('index.php?p=admin&c=type&a=index','添加商品类型成功',2);
        }else{
            $this->jump('index.php?p=admin&c=type&a=add','添加商品类型失败');
        }
    }

    public function editAction(){
        include CUR_VIEW_PATH."goods_type_edit.html";
    }

    public function updateAction(){

    }
    public function deleteAction(){

    }
    
}
