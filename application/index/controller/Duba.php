<?php
namespace app\index\controller;
use QL\QueryList;

/*毒霸*/
//数据源  http://www.duba.com/wxapp/search.html?type=tag&keyword=工具
class Duba {

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	// http://xcx.com/index.php/index/Mumayi/index
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	/*TODO  循环遍历出所有数据*/
	/*工具*/
	//http://www.duba.com/wxapp/search.html?type=tag&keyword=工具

	// 这是通过接口获取列表
	// http://xcx.com/index.php/index/duba/getlist
	public function getlist() {

		/*倒序循环10页
			TODO
		*/

		$url = 'http://www.duba.com/wxapp/search.html?type=tag&keyword=工具';

		$rules = [
			// 'wuyong' => ['.index_tj_list  .list_detail .icon_txt_li', 'text'], /*无用*/
			'minititle' => ['.appBox3 ul li .img72_72', 'title'], /*标题*/
			'detail' => ['.appBox3 ul li .img72_72', 'href'], /*详情页*/
			'img' => ['.appBox3 ul li .img72_72 img', 'data-src'], /*缩略图片*/
			'discription' => ['.appBox3 ul li  a p', 'text'], /*无用*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) .wxapp-index-title h5', 'text'], /*分类*/
			// 'type1' => ['.content .wxapp_install>div:eq(1) ul li dl dt', 'text'], /*分类*/
			// 'type' => ['.content .wxapp_install>div:eq(1) ul li dl dd:contains("分类"))', 'text'], /*分类*/
		];

		$rt = QueryList::get($url)->rules($rules)->query()->getData();

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
	}

	// http://xcx.com/index.php/index/duba/getlist2
	public function getlist2() {




		/*倒序循环10页*/
		/*这里page_size 可以随便改*/
		$url = 'http://ent.duba.com/api/wxapp/config.json';
		// $url = 'http://daohang.henkuai.com/ajaxHandle.php?handle=getlist&from=index&id=1';

		// $cdata = json_decode($this->juhecurl($url), true);

		$cdata = file_get_contents($url); 



		// echo $json_string;exit;

		// 用参数true把JSON字符串强制转成PHP数组 
		// $cdata = json_decode($json_string, true);

		// if (!$cdata['data']) {
		// 	echo '暂无数据';
		// 	return;
		// }

		$datas=explode('var AppHotSearchMap', $cdata);

		// echo $datas[0];

		$datas2=explode('// 列表', $datas[0]);  /*去除列表字符串*/


		$datas3=explode('var AppTagMap =', $datas2[1]);



		echo "<pre>";

		// echo $datas2[1];

		// echo "<hr>";
		// echo $datas3[1];
		// echo "<hr>";

		$cs2=str_replace(';','',$datas3[1]);
		$cs3=str_replace(';','',$datas3[0]);
		$cs4=str_replace('var AppMap = ','',$cs3);


		

		print_r(json_decode($cs4,true));


		echo $cs2;
		echo $cs4;

		echo "<hr>";
		// echo gettype($cs2);
		echo "<hr>";
		print_r(json_decode($cs2,true));
		echo "<hr>";
		echo "</pre>";

	}

	/*获取详情*/
	// http://xcx.com/index.php/index/Mumayi/getDetail
	public function getDetail() {
		echo 'no data';
		// $url = 'http://www.mumayi.com/xiaochengxu-21163.html';
		// $ql = QueryList::get($url);

		// $title = $ql->find('.main960 .w670 .iapp_hd .iappname')->text();
		// $icon = $ql->find('.main960 .w670 .iapp_hd .ibigicon  img')->src;
		// $tags = $ql->find('.main960 .w670 .ibor2 ul li:contains("所属类别："))')->text();
		// $qrcode = $ql->find('.main960 .w670 .ibor2 .erwmH img')->src;
		// $images = $ql->find('.main960 .w670 .ibox img')->attrs('src')->all();
		// $remark = $ql->find('.main960 .w670 .ibox .author p')->text();
		// // $typesurl = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->href;
		// // $typesname = $ql->find('.main>div:eq(0) .main-cont-left>div:eq(1) ul>li:eq(0) a')->text();
		// array_shift($images);  /*去除第一个无效元素*/





		// echo "<pre>";
		// print_r($title);
		// echo "<hr>";
		// print_r($qrcode);
		// echo "<hr>";
		// print_r($icon);
		// echo "<hr>";
		// print_r($images);
		// echo "<hr>";
		// print_r($remark);
		// echo "<hr>";
		// print_r($tags);
		// echo "</pre>";
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