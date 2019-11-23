<?php
namespace app\index\controller;
use QL\QueryList;

/*Mumayi.com*/
//数据源  http://www.mumayi.com/xiaochengxu/luyouchuxing/list_1_3.html
class Mumayi {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Mumayi/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/
	/*旅游出行*/
	//http://www.mumayi.com/xiaochengxu/luyouchuxing/list_1_3.html

	// 这是通过接口获取列表
	// http://xcx.com/index.php/index/Mumayi/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'http://www.mumayi.com/xiaochengxu/luyouchuxing/list_1_3.html';

		$rules = [
			// 'wuyong' => ['.index_tj_list  .list_detail .icon_txt_li', 'text'], /*无用*/
			'minititle' => ['.appBox3 ul li .img72_72', 'title'], /*标题*/
			'detail' => ['.appBox3 ul li .img72_72', 'href'], /*详情页*/
			'img' => ['.appBox3 ul li .img72_72 img', 'data-src'], /*缩略图片*/
			'discription' => ['.appBox3 ul li  a p', 'text'], /*无用*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) .wxapp-index-title h5', 'text'], /*分类*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) ul li dl dt', 'text'], /*分类*/
			// 'type' => ['.content .wxapp_install>div:eq(1) ul li dl dd:contains("分类"))', 'text'], /*分类*/
		];

		$rt = QueryList::get($url)->rules($rules)->query()->getData();

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	/*获取详情*/
	// http://xcx.com/index.php/index/Mumayi/getDetail
	public function getDetail() {
		$url = 'http://www.mumayi.com/xiaochengxu-21163.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.main960 .w670 .iapp_hd .iappname')->text();
		$icon = $ql->find('.main960 .w670 .iapp_hd .ibigicon  img')->src;
		$tags = $ql->find('.main960 .w670 .ibor2 ul li:contains("所属类别："))')->text();
		$qrcode = $ql->find('.main960 .w670 .ibor2 .erwmH img')->src;
		$images = $ql->find('.main960 .w670 .ibox img')->attrs('src')->all();
		$remark = $ql->find('.main960 .w670 .ibox .author p')->text();
		// $typesurl = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->href;
		// $typesname = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->text();
		array_shift($images);  /*去除第一个无效元素*/





		echo "<pre>";
		print_r($title);
		echo "<hr>";
		print_r($qrcode);
		echo "<hr>";
		print_r($icon);
		echo "<hr>";
		print_r($images);
		echo "<hr>";
		print_r($remark);
		echo "<hr>";
		print_r($tags);
		echo "</pre>";
	}
}