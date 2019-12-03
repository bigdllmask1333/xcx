<?php
namespace app\api\controller;
use QL\QueryList;

/*84399小程序大全*/
//数据源  http://www.84399.com
class Ba4399 {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Ba4399/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	//出行与交通类小程序  http://www.84399.com/jiaotong/

	// 这是通过接口获取列表
	// http://xcx.com/index.php/index/Ba4399/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'http://www.84399.com/jiaotong/1.htm';

		$rules = [
			'minititle' => ['.main .mod-applet ul li span', 'text'], /*标题*/
			'detail' => ['.main .mod-applet ul li a', 'href'], /*详情页*/
			'img' => ['.main .mod-applet ul li a img', 'data-original'], /*缩略图片*/
			'qrcode' => ['.main .mod-applet ul li .code img', 'data-original'], /*图片*/
			// 'discription' => ['.main .mod-applet ul li a', 'href'], /*描述*/
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
	// http://xcx3.com/index.php/index/index/getDetail
	public function getDetail() {
		$url = 'http://www.84399.com/xiaochengxu/g7o0zl.htm';
		$ql = QueryList::get($url);

		$title = $ql->find('.main .intro .intro-box h1')->text();
		$icon = $ql->find('.main .intro .intro-box  img')->src;
		$tags = $ql->find('.main .intro  .info .info-list span:contains("标签"))')->text();
		$qrcode = $ql->find('.main .intro .qrcode')->src;
		$images = $ql->find('.main .gallery .screenshot ul li img')->attrs('src')->all();
		$remark = $ql->find('.main .description .bd')->text();
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