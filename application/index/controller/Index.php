<?php
namespace app\index\controller;
use QL\QueryList;
class Index
{
    public function index()
    {
       //采集某页面所有的图片
       $data = QueryList::get('http://www.chengxu.la/category-31.html')->find('img')->attrs('src');
       //打印结果
       print_r($data->all());
    }

    public function getdata(){
    	$url = 'http://www.chengxu.la/category-31.html';
		// 定义采集规则
		$rules = [
		    // 采集文章标题
		    'title' => ['.item a','title'],
		    'href' => ['.item a','href'],
		    'img1' => ['.item a img','src'],
		    'img2' => ['.item a img','data-original'],
		    'text' => ['.item a em','text'],
		    'maintitle' => ['.item a span','text'],
		    // // 采集文章作者
		    // 'author' => ['#author_baidu>strong','text'],
		    // // 采集文章内容
		    // 'content' => ['.post_content','html']
		];
		$rt = QueryList::get($url)->rules($rules)->query()->getData();

		echo "<pre>";
		print_r($rt->all());
		echo "</pre>";
    }
}