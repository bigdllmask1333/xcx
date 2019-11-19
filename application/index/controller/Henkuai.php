<?php
namespace app\index\controller;
use QL\QueryList;

/*很快*/
//数据源  http://daohang.henkuai.com/
class Henkuai {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx3.com/index.php/index/henkuai/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	/*通过分类获取列表*/
	//http://daohang.henkuai.com/program/1  直接拿数据
	public function getlistbytype() {
		$url = 'http://daohang.henkuai.com/program/1';
		$ql = QueryList::get($url);

		$rt = $ql->rules($rules)->query()->getData();
		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	// http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&page=2&flag=1&sort=new&apptype=1   分类接口地址（TODO 需要做分页处理，还需要对404进行处理）
	// http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1

	//社交 http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1
	//资讯 http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=3
	//全部 http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index
	// http://xcx3.com/index.php/index/henkuai/getall
	// 这是通过接口获取列表
	public function getlist() {

		/*倒序循环10页*/

		$url = 'http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1';
		// $url = 'http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1';

		$ql = QueryList::get($url);

		$cdata = json_decode($this->juhecurl($url), true);

		if (!$cdata['html']) {
			echo '暂无数据';
			return;
		}
		$ql = QueryList::html($cdata['html']);
		$images = $ql->find('a div img')->attrs('src')->all();

		$rules = [
			'detail' => ['a', 'href'], /*标题*/
			'img' => ['.ulimg img', 'src'], /*详情页链接*/
			'title' => ['.program-title', 'text'], /*小图标*/
		];

		$rt = $ql->rules($rules)->query()->getData();
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