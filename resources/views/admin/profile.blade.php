@extends('layouts.full')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">{{ $user->name }}</li>
            </ol>
        </div>
    </header>

@endsection


@section('center')

    <div>
        <h3 class="first-letter padding-left-15">{{ $user->name }}</h3>
        <ul class="list-group">
            <li class="list-group-item">
                Joined on {{$user->created_at->format('M d,Y \a\t h:i a') }}
            </li>
            <li class="list-group-item panel-body">
                <table class="table-padding">
                    <style>
                        .table-padding td{
                            padding: 3px 8px;
                        }
                    </style>
                    <tr>
                        <td>Total Posts</td>
                        <td> {{$posts_count}}</td>
                        @if($author && $posts_count)
                            <td><a href="{{ url('/my-all-posts')}}">Show All</a></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Published Posts</td>
                        <td>{{$posts_active_count}}</td>
                        @if($posts_active_count)
                            <td><a href="{{ url('/user/'.$user->id.'/posts')}}">Show All</a></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Posts in Draft </td>
                        <td>{{$posts_draft_count}}</td>
                        @if($author && $posts_draft_count)
                            <td><a href="{{ url('my-drafts')}}">Show All</a></td>
                        @endif
                    </tr>
                </table>
            </li>
            <li class="list-group-item">
                Total Comments {{$comments_count}}
            </li>
        </ul>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="first-letter">Latest Posts</h3></div>
        <div class="list-group panel-body">
            @if(!empty($latest_posts[0]))
                @foreach($latest_posts as $latest_post)
                    <div class="list-group-item">

                    <p>
                        <strong><a href="{{ url('/'.$latest_post->id .'/'.$latest_post->slug) }}">{{ $latest_post->title }}</a></strong>
                        <span class="well-sm">On {{ $latest_post->created_at->format('M d,Y \a\t h:i a') }}</span>
                    </p>
                        </div>
                @endforeach
            @else
                <p>You have not written any post till now.</p>
            @endif
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="first-letter">Latest Comments</h3></div>
        <div class="list-group">
            @if(!empty($latest_comments[0]))
                @foreach($latest_comments as $latest_comment)
                    <div class="list-group-item">
                        <p>{{ $latest_comment->body }}</p>
                        <p>On {{ $latest_comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                        <p>On post <a href="{{ url('/'.$latest_comment->post->slug) }}">{{ $latest_comment->post->title }}</a></p>
                    </div>
                @endforeach
            @else
                <div class="list-group-item">
                    <p>You have not commented till now. Your latest 5 comments will be displayed here</p>
                </div>
            @endif
        </div>
    </div>
@endsection