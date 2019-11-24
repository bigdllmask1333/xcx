<?php
namespace app\index\controller;
use QL\QueryList;

/*Yqdown	.com*/
//数据源  https://www.yqdown.com/xcx/17/
class Yqdown {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Yqdown/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/
	/*工具*/
	//https://www.yqdown.com/xcx/17/

	// 这是通过接口获取列表
	// http://xcx.com/index.php/index/Yqdown/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'https://www.yqdown.com/xcx/17/';

		$rules = [
			// 'wuyong' => ['.index_tj_list  .list_detail .icon_txt_li', 'text'], /*无用*/
			'minititle' => ['.main ul li em', 'title'], /*标题*/
			'detail' => ['.main ul li  a', 'href'], /*详情页*/
			'img' => ['.main ul li a img', 'src'], /*缩略图片*/
			'tags' => ['.main ul li  span', 'text'], /*无用*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) .wxapp-index-title h5', 'text'], /*分类*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) ul li dl dt', 'text'], /*分类*/
			// 'type' => ['.content .wxapp_install>div:eq(1) ul li dl dd:contains("分类"))', 'text'], /*分类*/
		];

		$rt = QueryList::get($url)->rules($rules)->encoding('UTF-8', 'GB2312')->removeHead()->query()->getData();

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	/*获取详情*/
	// http://xcx.com/index.php/index/Yqdown/getDetail
	public function getDetail() {
		$url = 'https://www.yqdown.com/xcx/5828.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.body .main .intro h1')->text();
		$icon = $ql->find('.main .intro   .avatar')->src;
		$tags = $ql->find('.main div .info li span:contains("标签："))')->text();
		$qrcode = $ql->find('.main .intro  .qrcode')->src;
		$images = $ql->find('.main div .screenshot img')->attrs('src')->all();
		$remark = $ql->find('.description')->text();
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