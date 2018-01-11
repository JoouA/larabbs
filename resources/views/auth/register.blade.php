@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">用户注册</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">姓名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">邮箱</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">确认密码</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="mobile" class="col-md-4 control-label">手机号码</label>
                            <div class="col-md-6">
                                <input type="text" id="mobile" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
                                @if($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">验证码</label>

                            <div class="col-md-3">
                                <input id="captcha" type="text" class="form-control" name="captcha" required>
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                 <img id="captcha" class="thumbnail captcha" src="{{ captcha_src() }}" style=" height: 45px" alt="captcha" onclick="this.src='/captcha/flat?'+Math.random()">
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('verifyCode') ? 'has-error'  : '' }}">
                            <label for="verifyCode" class="col-md-4 control-label">手机验证码</label>
                            <div class="col-md-3">
                                <input type="text" id="verifyCode" name="verifyCode" class="form-control" placeholder="请输入短信验证码">
                                @if($errors->has('verifyCode'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('verifyCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="button" id="sendVerifySmsButton" class="btn btn-primary ">获取激活码</button>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    注册
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/laravel-sms.js') }}"></script>
    <script type="text/javascript">
        $('#sendVerifySmsButton').sms({
            //laravel csrf token
            //该token仅为laravel框架的csrf验证,不是access_token!
            token       : "{{csrf_token()}}",

            //请求时间间隔
            interval    : 60,

            //语音验证码
            voice       : false,

            //请求参数
            requestData : {
                //手机号
                mobile: function () {
                    return $('input[name=mobile]').val();
                },
                // 验证码
                captcha : function () {
                    return $('input[name=captcha]').val();
                },
                //手机号的检测规则
                mobile_rule: 'mobile_required',
//                captcha_rule: 'check_captcha',
            },

            //消息展示方式(默认为alert)
            notify      : function (msg, type) {
                alert(msg);
            },
        });
    </script>
@endsection
