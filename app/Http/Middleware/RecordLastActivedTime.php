<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RecordLastActivedTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果用户登录的话
        if (Auth::check()){
            // 记录最后的登录时间
            Auth::user()->recordLastActivedAt();
        }

        return $next($request);
    }
}
