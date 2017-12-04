<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }

    public function permissionDenied()
    {
        //如果当前用户有访问后台的权限直接跳转
        if (config('admin.permission')){
            return redirect(url(config('administrator.uri')),302);
        }

        //否则使用视图
        return view('pages.permission_denied');
    }
}
