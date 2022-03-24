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








?>
