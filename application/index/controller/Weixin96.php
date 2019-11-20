<?php
namespace app\index\controller;
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

	/**
	 * 请求接口返回内容
	 * @param  string $url [请求的URL地址]
	 * @param  string $params [请求的参数]
	 * @param  int $ipost [是否采用POST形式]
	 * @return  string
	 */
	public function juhecurl($url, $params = false, $ispost = 0) {
		$httpInfo = array();
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if ($ispost) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt($ch, CURLOPT_URL, $url);
		} else {
			if ($params) {
				curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
			} else {
				curl_setopt($ch, CURLOPT_URL, $url);
			}
		}
		$response = curl_exec($ch);
		if ($response === FALSE) {
			//echo "cURL Error: " . curl_error($ch);
			return false;
		}
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$httpInfo = array_merge($httpInfo, curl_getinfo($ch));
		curl_close($ch);
		return $response;
	}

	/*获取详情*/
	// http://xcx.com/index.php/index/henkuai/getDetail
	public function getDetail() {
		$url = 'http://daohang.henkuai.com/detail/8125.html';
		$ql = QueryList::get($url);

		$title = $ql->find('.main .main-cont .main-cont-left .clearfix h1')->text();
		$tags = $ql->find('.main .main-cont .main-cont-left .clearfix a')->attrs('href')->all();
		$qrcode = $ql->find('.main .main-cont .ewmcode img')->src;
		$images = $ql->find('.main .main-cont .match-list img')->attrs('src')->all();
		$remark = $ql->find('.main>div:eq(2) .screenshot')->text();
		$typesurl = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->href;
		$typesname = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->text();

		echo "<pre>";
		print_r($title);
		echo "<hr>";
		print_r($tags);
		echo "<hr>";
		print_r($qrcode);
		echo "<hr>";
		print_r($images);
		echo "<hr>";
		print_r($remark);
		echo "<hr>";
		print_r($typesurl);
		echo "<hr>";
		print_r($typesname);
		echo "</pre>";
	}
}