<?php
namespace app\index\controller;
use QL\QueryList;

/*pchome小程序大全*/
//数据源  https://download.pchome.net/miniapp/list_1095_1.html
class Pchome {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Ba4399/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据  案例：处理了乱码的问题*/

	//旅游出行

	// 这是通过接口获取列表
	// http://xcx3.com/index.php/index/Pchome/getlist
	// https://download.pchome.net/miniapp/list_1095_1.html
	public function getlist() {
		header('Content-type: text/html; charset=UTF8'); // UTF8不行改成GBK试试，与你保存的格式匹配

		/*倒序循环10页
			TODO
		*/

		$url = 'https://download.pchome.net/miniapp/list_1095_1.html';

		$rules = [
			'minititle' => ['#J_App a .app-info .item-rt strong', 'text'], /*标题*/
			'detail' => ['#J_App  a', 'href'], /*详情页*/
			'discription' => ['#J_App  a .app-info .item-rt .brief', 'text'], /*简介*/
			'img' => ['#J_App  a .app-info .item-lt  img', 'src'], /*缩略图片*/
			'qrcode' => ['#J_App  a .app-qr img', 'src'], /*图片*/
			// 'discription' => ['.main .mod-applet ul li a', 'href'], /*描述*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) .wxapp-index-title h5', 'text'], /*分类*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) ul li dl dt', 'text'], /*分类*/
			// 'type' => ['.content .wxapp_install>div:eq(1) ul li dl dd:contains("分类"))', 'text'], /*分类*/
		];

		$rt = QueryList::get($url)->rules($rules)->encoding('UTF-8', 'GB2312')->removeHead()->query()->getData();
		// $js = $rt->all();
		// foreach ($js as $key => $value) {
		// 	$js[$key]['minititle'] = $js[$key]['minititle'];
		// }

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	/*获取详情*/
	// http://xcx3.com/index.php/index/Pchome/getDetail
	public function getDetail() {
		$url = 'https://download.pchome.net/miniapp/ly/detail-37081.html';
		$ql = QueryList::get($url)->encoding('UTF-8', 'GB2312')->removeHead();

		$title = $ql->find('.dl-con-left .dl-title-mobile span')->text();
		$qrcode = $ql->find('.dl-info-code-msoft img')->src;
		$icon = $ql->find('.dl-info-msoft .dl-info-pic-msoft  img')->src;
		$images = $ql->find('.dl-piclist-scroll  ul li img')->attrs('src')->all();
		$tags = $ql->find('.dl-info-con dl')->text();
		$remark = $ql->find('.dl-text-con')->text();

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