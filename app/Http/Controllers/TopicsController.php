<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    //编辑器 图片上传
    public function uploadImage(Request $request,ImageUploadHandler $uploader){
        //初始化数据，默认是失败的
        $data = [
          'success' => false,
          'msg' => '上传失败!',
          'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给$file
        if($file = $request->upload_file){
            //保存图片到本地
            $result = $uploader->save($file,'topics',Auth::id(),1024);
            //图片保存成功的话
            if($result){
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
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

    public function show(Request $request,Topic $topic)
    {
        // URL 矫正
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
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
		return redirect()->to($topic->link())->with('success', '帖子创建成功');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '修改成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '成功删除！');
	}
}
