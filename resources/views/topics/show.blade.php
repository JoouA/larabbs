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
                <span class="glyphicon glyphicon-commit" aria-hidden="true"></span>
                {{ $topic->reply_count }}
            </div>

            <div class="topic-body">
                {!! $topic->body !!}
            </div>
            @can('update',$topic)
            <div class="operate">
                <hr>
                <a href="{{ route('topics.edit',$topic->id) }}" class="btn btn-default btn-xs" role="button">
                    <i class="glyphicon glyphicon-edit"></i>编辑
                </a>
                <a href="#" class="btn btn-default btn-xs" role="button">
                    <i class="glyphicon glyphicon-trash"></i>删除
                </a>
            </div>
            @endcan
        </div>
    </div>
</div>
@stop
