<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //获取用户的所有通知
        //notifications 这个方法在trait HasDatabaseNotifications 里面带有
        $notifications = Auth::user()->notifications()->orderBy('created_at','desc')->paginate(20);
        //标记已读
        Auth::user()->markAsRead();
        return view('notifications.index',compact('notifications'));
    }
}
