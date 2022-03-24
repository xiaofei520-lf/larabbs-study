<?php
use Illuminate\Support\Facades\Route;
function route_class()
{
    //把当前路由名称的。换成-
    return str_replace('.','-', Route::currentRouteName());
}
function category_nav_active($category_id){
    return active_class(if_route('categories.show') && if_route_param('category',$category_id));
}
function make_excerpt($value,$length = 200)
{
    //preg_replace ( mixed $pattern , mixed $replacement , mixed $subject) 搜索 subject 中匹配 pattern 的部分， 以 replacement 进行替换。
    //strip_tags() 函数剥去字符串中的 HTML、XML 以及 PHP 的标签。
    //trim()  去除两侧空格 第二个参数  是去除对应的元素
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ',strip_tags($value)));
    return str()->limit($excerpt, $length);
}








?>
