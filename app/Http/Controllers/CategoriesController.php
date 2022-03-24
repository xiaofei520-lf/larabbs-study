<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use  App\Models\Category;

class CategoriesController extends Controller
{

    public function show(Request $request,Topic $topic,Category $category){
        //读取分类 ID关联的话题，并按20条分页
        $topics = $topic->withOrder($request->order)
                        ->with('user', 'category')   // 预加载防止 N+1 问题
                        ->where('category_id',$category->id)
                        ->paginate(20);

        //传参变量话题和分类到模板中
        return view('topics.index',compact('topics','category'));
    }
}
