<?php
namespace app\api\controller;
use QL\QueryList;

/*shouji*/
//数据源  https://soft.shouji.com.cn/weixinapp/list_6_1.html
class Shouji {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Shouji/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/
	/*工具*/
	//https://soft.shouji.com.cn/weixinapp/list_6_1.html

	// 这是通过接口获取列表
	// http://xcx3.com/index.php/index/Shouji/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'https://soft.shouji.com.cn/weixinapp/list_6_1.html';

		$rules = [
			// 'wuyong' => ['.index_tj_list  .list_detail .icon_txt_li', 'text'], /*无用*/
			'minititle' => ['.index_tj_list .fl', 'title'], /*标题*/
			'detail' => ['.index_tj_list .fl', 'href'], /*详情页*/
			'img' => ['.index_tj_list .fl img', 'data-original'], /*缩略图片*/
			// 'discription' => ['.index_tj_list  .list_detail p', 'text'], /*无用*/
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
	// http://xcx3.com/index.php/index/Shouji/getDetail
	public function getDetail() {
		$url = 'https://soft.shouji.com.cn/weixin/app33611.html';
		$ql = QueryList::get($url);

		$title = $ql->find('#c_soft_down .s-head-l  h1')->text();
		$icon = $ql->find('#c_soft_down .s-head-l .s-head-ico  img')->src;
		$tags = $ql->find('#c_soft_down .s-head-l .s-head-des li:contains("类别："))')->text();
		$qrcode = $ql->find('#qrcode')->src;
		$images = $ql->find('#imgpreviewWrap .snapShotCont li img')->attrs('src')->all();
		$remark = $ql->find('#hidebox')->text();
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