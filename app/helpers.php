<?php
use Illuminate\Support\Facades\Route;
function route_class()
{
    //把当前路由名称的。换成-
    return str_replace('.','-', Route::currentRouteName());
}








?>
