<?php
namespace app\index\controller;
use QL\QueryList;
use think\Db;

//数据源  http://www.chengxu.la/
class Index {

	/*抓取来源  小程序，小游戏*/
	// http://www.chengxu.la/
	// http://daohang.henkuai.com/
	// http://xcx.96weixin.com/
	// http://www.84399.com/
	// https://download.pchome.net/miniapp/list_1097_1.html
	// https://www.91ud.com/app/
	// http://123.sogou.com/wxapp/
	// https://www.anruan.com/xcx/
	// http://www.we123.com/xcx/
	// https://soft.shouji.com.cn/weixinapp/
	// http://www.mumayi.com/xiaochengxu/

	// http://www.duba.com/wxapp/search.html?type=tag&keyword=工具
	// http://www.xmtzxm.com/xcx/
	// https://www.yqdown.com/xcx/
	// http://xiao.lieyunwang.com/
	// http://shop.jisuapp.cn/genre/hot/
	// https://www.hishop.com.cn/xiaocx/daquan.html
	// https://minapp.com/miniapp/

	//基础数据抓取  SEO优化  表单提交审核  资讯

	/*测试数据*/
	public function index() {
		//采集某页面所有的图片
		return 'just test';
	}

	// http://xcx2.com/index.php/index/index/getall
	// 一次性抓取所有数据
	public function getall() {
		set_time_limit(0);
		for ($i = 1; $i < 32; $i++) {
			$this->getdata($i);
		}
	}

	// http://xcx2.com/index.php/index/index/getdata

	/*这个接口只做页面数据处理，抓取以及数据库存储*/

	// 1-7
	// 21-31
	// http://xcx2.com/index.php/index/index/getdata/id/31
	public function getdata($type = '') {

		if (!$type) {
			$type = request()->param() ? request()->param() : 30;
			$type = $type['id'];
		}

		$baseurl = 'http://www.chengxu.la/index.php?m=Index&a=catelist&id=' . $type . '&p=';
		$url = 'http://www.chengxu.la/index.php?m=Index&a=catelist&id=' . $type . '&p=1';
		/*采集所有的条数跟页数以及对应的页码*/
		$data = QueryList::get($url)->find('.main div')->text();
		$data2 = QueryList::get($url)->find('head title')->text();

		$newarr3 = explode(" - 程序啦 ", $data2);
		$title = $newarr3[0];

		/*空白页拦截*/
		if (strpos($title, '程序啦') !== false) {
			echo '当前页面没有数据';
			return;
		}

		$data = explode(" 条记录 ", $data);
		$newarr1 = explode(" 页", $data[1]);
		$newarr2 = explode("/", $newarr1[0]);

		$total = $data[0]; /*单项总条数*/
		$page = $newarr2[1]; /*单项的总页数*/

		$rules = [
			'minititle' => ['.main a', 'title'], /*标题*/
			'href' => ['.main a', 'href'], /*详情页链接*/
			'mini_image' => ['.main a img', 'src'], /*小图标*/
			'title' => ['.main a em', 'text'], /*大标题*/
			'tags' => ['.main a span', 'text'], /*标签*/
		];

		// $btnarr = array();  用于测试打印数据用

		/*分页抓取*/
		if ($page >= 1) {
			for ($i = 1; $i <= $page; $i++) {

				$url = $baseurl . $i;
				// $rt = QueryList::get($url)->rules($rules)->query()->getData()->map(function ($item) {
				// 	$item['mini_image'] = 'http://www.chengxu.la' . (isset($item['mini_image']) ? $item['mini_image'] : '');
				// 	$item['href'] = 'http://www.chengxu.la/' . $item['href'];
				// 	return $item;
				// });

				$rt = QueryList::get($url)->rules($rules)->query()->getData();

				/*对整理后的数据进行处理  优化后一次循环搞定*/
				foreach ($rt->all() as $key => $value) {
					$value['mini_image'] = 'http://www.chengxu.la' . (isset($value['mini_image']) ? $value['mini_image'] : '');
					$value['href'] = 'http://www.chengxu.la/' . $value['href'];
					$value['typetitle'] = $title;
					$value['typeid'] = $type;
					$this->intdata($value); /*数据新增插入*/
					// array_push($btnarr, $value);    //测试数据 用于打印数据
				}

				echo '完成类型' . $title . '第' . $i . '页数据展示<br>';
			}
		}

		// 定义采集规则
		// $btn['total'] = $total;
		// $btn['page'] = $page;
		// $btn['maindata'] = $btnarr;
		// echo "<pre>";
		// print_r($btn);
		// echo "</pre>";
	}

	/*更新数据，插入数据*/
	public function intdata($data) {
		$ck = Db::name('applist')->where(array('href' => $data['href']))->find();
		if (!$ck) {
			if ($data['minititle']) {
				$data['createtime'] = time();
				Db::name('applist')->insert($data);
			}

		}
	}

	/*这个接口做数据详情页的抓取跟存储*/
	// http://xcx3.com/index.php/index/index/getDetail
	// 基础逻辑写完，一个循环全部搞定
	public function getDetail() {

		$url = 'http://www.chengxu.la/app-1966.html';

		// $ql->find('#one>.two')->html();
		// $ql = QueryList::get($url)->find('.main')->html();

		$ql = QueryList::get($url);
		// $titles = $ql->find('h3>a')->texts(); //获取搜索结果标题列表
		// $links = $ql->find('h3>a')->attrs('href'); //获取搜索结果链接列表

		$title = $ql->find('.main>div:eq(1) h3')->text();
		$tags = $ql->find('.main>div:eq(1) ul>li:eq(1)>span:eq(1) strong')->text();
		$images = $ql->find('.main>div:eq(2) .screenshot  img')->attrs('data-original')->all();
		$qrcode = $ql->find('.qrcode')->src;
		$remark = $ql->find('.description>p:eq(0)')->text();

		echo "<pre>";
		print_r($title);
		echo "<hr>";
		print_r($tags);
		echo "<hr>";
		print_r($images);
		echo "<hr>";
		print_r($qrcode);
		echo "<hr>";
		print_r($remark);
		echo "</pre>";
	}

	//截取指定两个字符之间的字符串
	// public function cut($begin, $end, $str) {
	// 	$b = mb_strpos($str, $begin) + mb_strlen($begin);
	// 	$e = mb_strpos($str, $end) - $b;
	// 	return mb_substr($str, $b, $e);
	// }
}