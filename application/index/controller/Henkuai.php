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

	//社交 http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1
	//资讯 http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=3
	//全部 http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index
	// http://xcx3.com/index.php/index/henkuai/getall
	public function getall() {

		$url = 'http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1';

		$ql = QueryList::get($url);

		$cdata = json_decode($this->juhecurl($url), true);
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
}