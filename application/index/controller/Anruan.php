<?php
namespace app\index\controller;
use QL\QueryList;

/*anruan*/
//数据源  https://www.anruan.com/xcxlist/101_1_1.html
class Anruan {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Ud91/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	//生活

	// 这是通过接口获取列表
	//https://www.anruan.com/xcxlist/101_1_1.html
	//http://xcx3.com/index.php/index/Anruan/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'https://www.anruan.com/xcxlist/101_1_1.html';

		$rules = [
			'minititle' => ['.sou_h5_net  ul li  .tes a', 'text'], /*标题*/
			'detail' => ['.sou_h5_net  ul li  .tes a', 'href'], /*详情页*/
			'img' => ['.sou_h5_net  ul li .img img', 'src'], /*缩略图片*/
			// 'qrcode' => ['.main .mod-applet ul li .code img', 'data-original'], /*图片*/
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
	// http://xcx3.com/index.php/index/Anruan/getDetail
	public function getDetail() {
		$url = 'https://www.anruan.com/xcx/2322.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.Top_info .info_L .bt h1')->text();
		$icon = $ql->find('.Top_info .info_L .info .img img')->src;
		$tags = $ql->find('.Top_info .info_L .info .info_cent ul li:contains("标签")')->text();
		$qrcode = $ql->find('.Top_info .info_L .info  .sao img')->src;
		$images = $ql->find('.content .Lef_2 .snapShotCont li img')->attrs('src')->all();
		$remark = $ql->find('.content .Lef1_cent p')->text();
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