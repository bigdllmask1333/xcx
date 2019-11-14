<?php
namespace app\index\controller;
use QL\QueryList;
class Index
{
    public function index()
    {
       //采集某页面所有的图片
       $data = QueryList::get('http://www.chengxu.la/category-30.html')->find('.main div')->text();
       $data=explode(" 条记录 ", $data);

       // echo $data[0];

       $newarr1=explode(" 页", $data[1]);
       $newarr2=explode("/", $newarr1[0]);
       //打印结果
       print_r($data);
       echo "<hr>";
       print_r($newarr1);
       echo "<hr>";
       print_r($newarr2);
    }

    public function getdata(){
    	$url = 'http://www.chengxu.la/index.php?m=Index&a=catelist&id=31&p=1';

    	/*采集所有的条数跟页数以及对应的页码*/
    	$data = QueryList::get($url)->find('.main div')->text();
    	$data=explode(" 条记录 ", $data);
       	$newarr1=explode(" 页", $data[1]);
       	$newarr2=explode("/", $newarr1[0]);

       	$total=$data[0];
       	$page=$newarr2[1];


       	// if TODO  循环 做好即可


		// 定义采集规则
		$rules = [
		    // 采集文章标题
		    'minititle' => ['.main a','title'],
		    'href' => ['.main a','href'],
		    'img1' => ['.main a img','src'],
		    'title' => ['.main a em','text'],
		    'tags' => ['.main a span','text'],
		    // // 采集文章作者
		    // 'author' => ['#author_baidu>strong','text'],
		    // // 采集文章内容
		    // 'content' => ['.post_content','html']
		];
		$rt = QueryList::get($url)->rules($rules)->query()->getData()->map(function($item){
		    $item['img1'] = 'http://www.chengxu.la'.$item['img1'];
		    $item['href'] = 'http://www.chengxu.la/'.$item['href'];
		    return $item;
		});



		$btn['total']=$total;
		$btn['page']=$page;
		$btn['maindata']=$rt->all();
		echo "<pre>";
		print_r($btn);
		echo "</pre>";
    }

    public function getDetail(){

    }


    //截取指定两个字符之间的字符串
	public function cut($begin,$end,$str){
	    $b = mb_strpos($str,$begin) + mb_strlen($begin);
	    $e = mb_strpos($str,$end) - $b;
	    return mb_substr($str,$b,$e);
	}
}