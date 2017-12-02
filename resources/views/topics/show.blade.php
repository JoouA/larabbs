@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
            <div class="panel-body">
                作者：{{ $topic->user->name }}
            </div>
            <hr>
            <div class="media">
                <div align="center">
                    <a href="{{ route('users.show',$topic->user->id ) }}">
                        <img  class="thumbnail img-responsive" src="{{ $topic->user->avatar }}" alt="avatar" width="300px" height="300px">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <h1 class="text-center">
                {{ $topic->title }}
            </h1>

            <div class="article-meta text-center">
                {{ $topic->created_at->diffForHumans() }}
                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                {{--{{ $topic->replies->count()  }}--}}
                {{ $topic->reply_count }}
            </div>

            <div class="topic-body">
                {!! $topic->body !!}
            </div>
            @can('update',$topic)
                <div class="operate">
                    <hr>
                    <a href="{{ route('topics.edit',$topic->id) }}" class="btn btn-default btn-xs pull-left" role="button" style="margin-top:-10px">
                        <i class="glyphicon glyphicon-edit"></i>编辑
                    </a>
                    <form action="{{ route('topics.destroy',$topic->id) }}" method="post">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px;margin-top:-10px">
                            <i class="glyphicon glyphicon-trash"></i>删除
                        </button>
                    </form>
                </div>
            @endcan
        </div>
        {{--用户回复列表--}}
        <div class="panel panel-default topic-reply">
            <div class="panel panel-body">
                @includeWhen(Auth::check(),'topics._reply_box',['topic' => $topic])
                @include('topics._reply_list',['replies' => $replies ])
                {{--@include('topics._reply_list',['replies' => $topic->replies()->recent()->with('user')->get()])--}}
            </div>
        </div>
    </div>
</div>
@stop
