<?php
namespace app\index\controller;
use QL\QueryList;
class Index
{
    public function index()
    {
       //采集某页面所有的图片
       $data = QueryList::get('http://www.chengxu.la/')->find('img')->attrs('src');
       //打印结果
       print_r($data->all());
    }
}