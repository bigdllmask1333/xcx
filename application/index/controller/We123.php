<?php
namespace app\index\controller;
use QL\QueryList;

/*we123*/
//数据源  http://www.we123.com/xcx/
class We123 {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx3.com/index.php/index/henkuai/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	/*工具*/
	// http://www.we123.com/xcx/json/3.json     json文件本地化做的处理
	// 这是通过接口获取列表
	// http://xcx3.com/index.php/index/We123/getlist
	public function getlist() {

		/*倒序循环10页*/
		/*这里page_size 可以随便改*/
		$url = 'http://www.we123.com/xcx/json/3.json';
		// $url = 'http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1';

		$cdata = json_decode($this->juhecurl($url), true);

		if (!$cdata) {
			echo '暂无数据';
			return;
		}

		echo "<pre>";
		print_r($cdata);
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
	// http://xcx3.com/index.php/index/We123/getDetail
	public function getDetail() {
		$url = 'http://www.we123.com/xcx/11726/';
		$ql = QueryList::get($url);

		$title = $ql->find('.articlebox .xcxtop_left .xcxtop_logo h1')->text();
		$icon = $ql->find('.articlebox .xcxtop_left .xcxtop_logo img')->src;
		$tags = $ql->find('.articlebox .xcxtop_left .xcxtop_logo .xcxtop_fl a')->text();
		$qrcode = $ql->find('.articlebox .xcxtop_right img')->src;
		$images = $ql->find('.articlebox .imgbox ul li img')->attrs('src')->all();
		$remark = $ql->find('.articlebox .xcxinfo')->text();
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