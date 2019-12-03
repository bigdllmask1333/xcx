<?php
namespace app\api\controller;
use QL\QueryList;

/*96微信*/
//数据源  http://xcx.96weixin.com
class Weixin96 {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/weixin96/getlist
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	//购物  http://xcx.96weixin.com/gouwu/index_1.html

	// 这是通过接口获取列表
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'http://xcx.96weixin.com/gouwu/index_1.html';

		$rules = [
			'minititle' => ['.content .wxapp_install>div:eq(1) ul li h5', 'text'], /*标题*/
			'discription' => ['.content .wxapp_install>div:eq(1) ul li p', 'text'], /*描述*/
			'qrcode' => ['.content .wxapp_install>div:eq(1) ul li .wxapp-open img', 'src'], /*图片*/
			'detail' => ['.content .wxapp_install>div:eq(1) ul li .wxapp-applogo', 'href'], /*详情页*/
			'img' => ['.content .wxapp_install>div:eq(1) ul li .wxapp-applogo img', 'src'], /*缩略图片*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) .wxapp-index-title h5', 'text'], /*分类*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) ul li dl dt', 'text'], /*分类*/
			'type' => ['.content .wxapp_install>div:eq(1) ul li dl dd:contains("分类"))', 'text'], /*分类*/
		];

		$rt = QueryList::get($url)->rules($rules)->query()->getData();

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	/*获取详情*/
	// http://xcx3.com/index.php/index/index/getDetail
	public function getDetail() {
		$url = 'http://xcx.96weixin.com/gouwu/4050.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.software_detail_title .software_detail_desc h1')->text();
		$qrcode = $ql->find('.software_detail_title .software_detail-code img')->src;
		$icon = $ql->find('.software_detail_title .software_detail_icon img')->src;
		$images = $ql->find('.soft_detail ul li img')->attrs('src')->all();
		$remark = $ql->find('.minapp_function div')->text();
		$tags = $ql->find('.software_detail_title .software_detail-desc .long-p:contains("搜索词："))')->text();
		// $typesurl = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->href;
		// $typesname = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->text();

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