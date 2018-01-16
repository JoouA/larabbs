<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\Socialite\SocialiteManager;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ],[
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码不正确',
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider()
    {
        $config = config('services');

        $socialite = new SocialiteManager($config);

        return $socialite->driver('github')->redirect();
    }

    /**
     *
     */
    public function handleProviderCallback()
    {
        $config = config('services');

        $socialite = new SocialiteManager($config);

        $user = $socialite->driver('github')->user();


        $user_info = [
            'name' => $user->getUsername(),
            'email'=> $user->getEmail(),
            'password' => bcrypt(str_random(6)),
            'avatar' => $user->getAvatar(),
        ];

        // 对user_info里面的邮箱进行判断，如果一样就直接登录
        $if_user_exit = User::query()->where('email',$user_info['email'])->first();

        if ($if_user_exit){
            Auth::login($if_user_exit);
        }else{
            try{
                $user = User::create($user_info);
                Auth::login($user);
                return redirect()->route('root');
            }catch (\Exception $e){
                return redirect()->route('login')->with('danger','登陆失败');
            }
        }
        return redirect()->route('root');
    }

    public function weiboProvider()
    {
        $config = config('services');

        $socialite = new SocialiteManager($config);
        return $socialite->driver('weibo')->redirect();
    }

    public function weiboProviderCallback()
    {
        $config = config('services');

        $socialite = new SocialiteManager($config);

        $user = $socialite->driver('weibo')->user();

        dd($user);
    }
}
