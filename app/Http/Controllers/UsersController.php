<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth',['except' => ['show']]);
    }

    public function show(User $user)
    {
        $topics = $user->topics()->recent()->paginate(5);
        $replies = $user->replies()->with('topic')->recent()->paginate(5);
        return view('users.show',compact('user','topics','replies'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader ,User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if ($request->file('avatar')){
            $result = $uploader->save($request->file('avatar'),'avatars',$user->id,362);

            if ($request){
               $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功');
    }
}
