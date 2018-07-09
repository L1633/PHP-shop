<?php
class AttributeController extends BaseController{

    public function indexAction(){
        //获取所有商品类型
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->gettypes();
        //获取该商品类型的id，然后获取该类型的属性列表
        $type_id = $_GET['type_id'];
        //默认是第一页
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        //设置每页显示数目
        $pagesize = 2;
        $offset = ($current-1)*$pagesize;
        //获取当前指定类型下的所有属性
        $attrModel = new AttributeModel('attribute');
        $attrs = $attrModel->getAttrs($type_id,$offset,$pagesize);
        //载入分页类
        $this->library('Page');
        //获取总记录数
        $where = "type_id = $type_id";
        $total = $attrModel->total($where);
        //创建page对象， 传递参数
        $page = new page($total,$pagesize,$current,'index.php',array('p'=>'admin','c'=>'attribute','a'=>'index','type_id'=>$type_id));
        $pageinfo = $page->showPage();

        include CUR_VIEW_PATH."attribute_list.html";
    }

    public function addAction(){
        //获取所有商品类型
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->gettypes();
        include CUR_VIEW_PATH."attribute_add.html";
    }

    public function insertAction(){
        //收集表单数据
         $data['attr_name'] = trim($_POST['attr_name']);
         $data['type_id'] = trim($_POST['type_id']);
         $data['attr_type'] = trim($_POST['attr_type']);
         $data['attr_input_type'] = trim($_POST['attr_input_type']);
         $data['attr_value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : '' ;
        //验证
        if($data['attr_name'] == ''){
            $this->jump('index.php?p=admin&c=attribute&a=add','商品属性名称不能为空');
        }
         //对输入的数据做转义和实体的处理
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        //调用模型添加到数据库并给出提示
        $AttrModel = new AttributeModel('attribute');
        if($AttrModel->insert($data)){
            $this->jump('index.php?p=admin&c=attribute&a=index','添加商品属性成功',2);
        }else{
            $this->jump('index.php?p=admin&c=attribute&a=add','添加商品属性失败');
        }
    }


    public function editAction(){
        include CUR_VIEW_PATH."attribute_edit.html";
    }

    public function updateAction(){

    }
    public function deleteAction(){

    }

    //获取指定类型的属性
    public function getAttrsAction(){
        $type_id = $_GET['type_id'];
        //获取当前指定类型下的所有属性
        $attrModel = new AttributeModel('attribute');
        $attrs = $attrModel->getAttrsForm($type_id);
        echo <<<STR
		<script type="text/javascript">
			window.parent.document.getElementById("tbody-goodsAttr").innerHTML 
			= "$attrs";
		</script>
STR;
    }
    
}