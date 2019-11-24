<?php
namespace app\index\controller;

/*小程序*/
//数据源  https://minapp.com
class Minapp {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*小推荐*/
	// http://xcx3.com/index.php/index/Minapp/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/

	/*工具*/
	// https://minapp.com/api/v5/trochili/miniapp/?tag=&offset=21&limit=21
	// 这是通过接口获取列表
	// http://xcx.com/index.php/index/Minapp/getlist
	public function getlist() {

		/*倒序循环10页*/
		/*这里page_size 可以随便改*/
		// $url = 'https://minapp.com/api/v5/trochili/miniapp/';
		$url = 'https://minapp.com/api/v5/trochili/miniapp/?tag=&offset=21&limit=21';



		// echo   $this->juhecurl($url);

		$cdata = json_decode($this->curlData($url), true);

		// $cdata = file_get_contents($url);

		// if (!$cdata['data']) {
		// 	echo '暂无数据';
		// 	return;
		// }

		echo "<pre>";
		print_r($cdata);
		echo "</pre>";

	}

	// /**
	//  * 请求接口返回内容
	//  * @param  string $url [请求的URL地址]
	//  * @param  string $params [请求的参数]
	//  * @param  int $ipost [是否采用POST形式]
	//  * @return  string
	//  */
	// public function juhecurl($url, $params = false, $ispost = 0) {
	// 	$httpInfo = array();
	// 	$ch = curl_init();

	// 	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	// 	// curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
	// 	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	// 	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	// 	if ($ispost) {
	// 		curl_setopt($ch, CURLOPT_POST, true);
	// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	// 		curl_setopt($ch, CURLOPT_URL, $url);
	// 	} else {
	// 		if ($params) {
	// 			curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
	// 		} else {
	// 			curl_setopt($ch, CURLOPT_URL, $url);
	// 		}
	// 	}
	// 	$response = curl_exec($ch);
	// 	if ($response === FALSE) {
	// 		//echo "cURL Error: " . curl_error($ch);
	// 		return false;
	// 	}
	// 	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 	$httpInfo = array_merge($httpInfo, curl_getinfo($ch));
	// 	curl_close($ch);
	// 	return $response;
	// }

	/**
	 * @param $url
	 * @param $data
	 * @param string $method
	 * @param string $type
	 * @return bool|string
	 */
	public function curlData($url,$type='json')
	{
	    //初始化
	    $ch = curl_init();
	    $headers = [
	        'form-data' => ['Content-Type: multipart/form-data'],
	        'json'      => ['Content-Type: application/json'],
	    ];
	    
	    // 请求头，可以传数组
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers[$type]);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         // 执行后不直接打印出来
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
	    $output = curl_exec($ch); //执行并获取HTML文档内容
	    curl_close($ch); //释放curl句柄
	    return $output;
	}

	/*上面的接口一步到位，不需要详情*/
	// http://xcx3.com/index.php/index/sougou/getDetail
	// public function getDetail() {

	// 	$url1 = 'http://123.sogou.com/wxapp/apps/getAppDetailById?id=3068';
	// 	$url2 = 'http://123.sogou.com/wxapp/apps/getAppImageById?id=3068';
	// 	// $url = 'http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1';

	// 	$cdata1 = json_decode($this->juhecurl($url1), true);
	// 	$cdata2 = json_decode($this->juhecurl($url2), true);

	// 	echo "<pre>";
	// 	print_r($cdata1['data']);
	// 	print_r($cdata2['data']);
	// 	echo "</pre>";

	// }
}