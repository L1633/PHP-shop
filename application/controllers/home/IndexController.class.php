<?php
class IndexController extends Controller{
    //显示首页
    public function indexAction(){
        //显示所有商品分类
        $category = new CategoryModel('category');
        $cats = $category->forntCats();
        //获取推荐商品
        $goodsModel = new GoodsModel('goods');
        $bestGoods = $goodsModel->getBestGoods();
        include CUR_VIEW_PATH."index.html";
    }





}