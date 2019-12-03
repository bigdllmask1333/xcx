<?php
namespace app\api\controller;
use QL\QueryList;

/*Xmtzxm.com*/
//数据源  http://www.xmtzxm.com/yundong/
class Xmtzxm {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Mumayi/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/
	/*运动*/
	//http://www.xmtzxm.com/yundong/

	// 这是通过接口获取列表
	// http://xcx.com/index.php/index/Xmtzxm/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'http://www.xmtzxm.com/yundong/';

		$rules = [
			// 'wuyong' => ['.index_tj_list  .list_detail .icon_txt_li', 'text'], /*无用*/
			'minititle' => ['.cate-list li .avatar', 'title'], /*标题*/
			'detail' => ['.cate-list li .avatar', 'href'], /*详情页*/
			'img' => ['.cate-list li .avatar img', 'data-src'], /*缩略图片*/
			'tags' => ['.cate-list li  .tags', 'text'], /*无用*/
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
	// http://xcx.com/index.php/index/Xmtzxm/getDetail
	public function getDetail() {
		$url = 'http://www.xmtzxm.com/xcx/21785.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.main .intro .name h1')->text();
		$icon = $ql->find('.main .intro   img')->src;
		$tags = $ql->find('.main div .info li:contains("分类："))')->text();
		$qrcode = $ql->find('.main .qrcode img')->src;
		$images = $ql->find('.main div .screenshot img')->attrs('src')->all();
		$remark = $ql->find('.main div .ziti:eq(0)')->text();
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