<?php
class GoodsController extends BaseController{

    public function indexAction(){

        include CUR_VIEW_PATH."goods_list.html";
    }

    public function addAction(){
        //获取所有商品分类
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getCats();
        //获取所有品牌
        $brandModel = new BrandModel('brand');
        $brands = $brandModel->getBrands();
        //获取所有商品类型
        $TypeModel = new TypeModel('goods_type');
        $types = $TypeModel->gettypes();
        
        include CUR_VIEW_PATH."goods_add.html";
    }

    public function insertAction(){
       //1.收集表单数据
		$data['goods_name'] = trim($_POST['goods_name']);
		$data['goods_sn'] = trim($_POST['goods_sn']);
		$data['cat_id'] = $_POST['cat_id'];
		$data['brand_id'] = $_POST['brand_id'];
		$data['type_id'] = $_POST['type_id'];
		$data['shop_price'] = trim($_POST['shop_price']);
		$data['market_price'] = trim($_POST['market_price']);
		$data['promote_start_time'] = strtotime($_POST['promote_start_time']);
		$data['promote_end_time'] = strtotime($_POST['promote_end_time']);
		$data['goods_desc'] = trim($_POST['goods_desc']);
		$data['goods_number'] = trim($_POST['goods_number']);
		$data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
		$data['is_new'] = isset($_POST['is_new']) ? $_POST['is_new'] : 0;
		$data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
		$data['is_onsale'] = isset($_POST['is_onsale']) ? $_POST['is_onsale'] : 0;
        $data['add_time'] = time();
        //处理图片上传，引入图片上传类
        if($_FILES['goods_img']['tmp_name'] != ''){
            $this->library('Upload');
            $upload = new Upload();
            if ($filename = $upload->up($_FILES['goods_img'])) {
				//成功
				$data['goods_img'] = $filename;
			} else {
				//失败
				$this->jump('index.php?p=admin&c=goods&a=add',$upload->error());
            }
        }
        //2.验证和处理
		if ($data['goods_name'] == '') {
			$this->jump('index.php?p=admin&c=goods&a=add','名称不能为空');
		}
        //3.调用模型完成商品主数据的添加，在添加成功的同时，需要添加属性数据
		$goodsModel = new GoodsModel('goods');
		if ($goods_id = $goodsModel->insert($data)) {
			//成功,需要添加属性数据
			if (isset($_POST['attr_id_list'])) {
				$ids = $_POST['attr_id_list'];
				$values = $_POST['attr_value_list'];
				$prices = $_POST['attr_price_list'];
				//将数据插入到goods_attr表中,循环插入
				$model = new Model('goods_attr');
				foreach ($ids as $k => $v) {
					$list['goods_id'] = $goods_id;
					$list['attr_id'] = $v;
					$list['attr_value'] =  $values[$k];
					$list['attr_price'] =  $prices[$k];
					//调用模型完成插入,借用model直接插入
					$model->insert($list);
				}
			}
			$this->jump('index.php?p=admin&c=goods&a=index','添加成功');
		} else {
			//失败
			$this->jump('index.php?p=admin&c=goods&a=add','添加失败');
		}
    }

    public function editAction(){
        include CUR_VIEW_PATH."goods_edit.html";
    }
    public function updateAction(){

    }
    public function deleteAction(){

    }
}
