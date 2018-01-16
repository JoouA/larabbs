<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--CSRF-TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>404</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div>
    <div class="container">
        <div class="col-md-6 col-md-offset-4">
            <h1 class="header">
                Larabbs- 404
            </h1>
            <div class="content">
                <p>
                    <strong>你似乎来到了错误的地方..</strong>
                </p>
                <p>来源链接是否正确？用户、话题或问题是否存在？</p>
                <hr>
                <p>
                    <a href="/">返回首页</a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
