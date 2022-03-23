<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    //类对象被创建之前该方法将会被调用
    public function __construct(){
        $this->middleware('auth', ['except' => ['show']]);

    }
    //个人页面的展示
    public function show(User $user){
        return view('users.show',compact('user'));
    }
    //编辑个人信息页面
    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }
    //编辑个人信息 提交
    public function update(UserRequest $request, ImageUploadHandler $uploader,User $user){
        $this->authorize('update', $user);
        $data = $request->all();
        if($request->acatar){
            $result = $uploader->save($request->acatar,'acatar',$user->id,416);
            if($result){
                $data['acatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }
}
