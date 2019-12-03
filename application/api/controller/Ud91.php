<?php
namespace app\api\controller;
use QL\QueryList;

/*91ud.com*/
//数据源  https://www.91ud.com/app/
class Ud91 {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Ud91/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	//新闻资讯

	// 这是通过接口获取列表
	//https://www.91ud.com/zixun/list_xcx_1.html
	//http://xcx3.com/index.php/index/Ud91/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'https://www.91ud.com/zixun/list_xcx_1.html';

		$rules = [
			'duoyu' => ['.liswrap  ul li  .Os_110Icon', 'src'], /*多余*/
			'minititle' => ['.liswrap  ul li .name', 'text'], /*标题*/
			'detail' => ['.liswrap  ul li .img', 'href'], /*详情页*/
			'img' => ['.liswrap  ul li .img img', 'src'], /*缩略图片*/
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
	// http://xcx3.com/index.php/index/Ud91/getDetail
	public function getDetail() {
		$url = 'https://www.91ud.com/app/42265.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.main .name h1')->text();
		$icon = $ql->find('.main .avatar img')->src;
		$tags = $ql->find('.main .tags a')->text();
		$qrcode = $ql->find('.main .qrcode img')->src;
		$images = $ql->find('.main .screenshot-list li img')->attrs('src')->all();
		$remark = $ql->find('.main .description p:eq(0)')->text();
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