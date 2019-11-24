<?php
namespace app\index\controller;
use QL\QueryList;

/*Jisuapp*/
//数据源  http://shop.jisuapp.cn/tool/
class Jisuapp {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Jisuapp/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/
	/*工具*/
	//https://www.Jisuapp.com/xcx/17/

	// 这是通过接口获取列表
	// http://shop.jisuapp.cn/tool/
	// http://xcx.com/index.php/index/Jisuapp/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'http://shop.jisuapp.cn/tool/';

		$rules = [
			// 'wuyong' => ['.index_tj_list  .list_detail .icon_txt_li', 'text'], /*无用*/
			'minititle' => ['.g-main ul li .item-name', 'text'], /*标题*/
			'detail' => ['.g-main ul li  a', 'href'], /*详情页*/
			'img' => ['.g-main ul li a img', 'src'], /*缩略图片*/
			// 'tags' => ['.g-main ul li  span', 'text'], /*无用*/
			'discription' => ['.g-main ul li  .item-description', 'text'], /*无用*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) .wxapp-index-title h5', 'text'], /*分类*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) ul li dl dt', 'text'], /*分类*/
			// 'type' => ['.content .wxapp_install>div:eq(1) ul li dl dd:contains("分类"))', 'text'], /*分类*/
		];

		$rt = QueryList::get($url)->rules($rules)->query()->getData();

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	/*获取详情 */
	// http://xcx.com/index.php/index/Jisuapp/getDetail
	public function getDetail() {
		$url = 'http://shop.jisuapp.cn/program/605376.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.left-content .app-title')->text();
		$icon = $ql->find('.left-content .app-cover')->src;
		$tags = $ql->find('.left-content .app-title-wrap p:contains("标签："))')->text();
		$qrcode = $ql->find('.left-content  .app-qrcode  img')->src;
		$images = $ql->find('.left-content .detail-field-wrap .app-shot li img')->attrs('src')->all();
		$remark = $ql->find('.left-content  .app-desc p:eq(1)')->text();
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