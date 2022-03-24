<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }




	public function index(Request $resquest,Topic $topic)
	{
	    //解决n+1 问题
		$topics = $topic->withOrder($resquest->order)
                ->with('user','category')
                ->paginate(30);
        //$topics = Topic::paginate(30);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }
    //创建帖子
	public function create(Topic $topic)
	{
        $categories = Category::all();
        return view('topics.create_and_edit',compact('topic','categories'));
	}
	/**
	 * store() 方法的第二个参数，会创建一个空白的 $topic 实例；
     * $topic->fill($request->all()); fill 方法会将传参的键值数组填充到模型的属性中，
     * Auth::id() 获取到的是当前登录的 ID；
     * $topic->save() 保存到数据库中。
	 * @Auther 小菜鸟阿飞
	 * @Date 2022/3/24 14:09
	 */
	public function store(TopicRequest $request,Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}
