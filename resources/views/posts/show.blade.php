@extends('layouts.sidebar')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li><a href="#">Microchip</a></li>
                <li class="active">{{ $post->title }}</li>
            </ol>
        </div>
    </header>

@endsection


@section('center')

    <div class="panel-default post-show">
        <div class="panel-title">
            <h2>
                @if($post)
                    {{ $post->title }}
                    @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
                        <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a>
                        </button>
                    @endif
                @else
                    Page does not exist
                @endif

            </h2>
            <p>{{ $post->created_at->format('M d,Y') }} By <a
                        href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>
        </div>
        <div class="panel-body">
            @if($post)
                <div>
                    {!! $post->body_html !!}
                </div>
                <div>
                    <h2>Leave a comment</h2>
                </div>
                @if(Auth::guest())
                    <p>Login to Comment</p>
                @else
                    <div class="panel-body">
                        <form method="post" action="/comment/add">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="on_post" value="{{ $post->id }}">
                            <input type="hidden" name="slug" value="{{ $post->slug }}">

                            <div class="form-group">
                                <textarea required="required" placeholder="Enter comment here" name="body"
                                          class="form-control"></textarea>
                            </div>
                            <input type="submit" name='post_comment' class="btn btn-success" value="Post"/>
                        </form>
                    </div>
                @endif
                <div id="comments">
                    @if($comments)
                        <ul style="list-style: none; padding: 0">
                            @foreach($comments as $comment)
                                <li class="panel-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <h3>{{ $comment->author->name }}</h3>

                                            <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                        </div>
                                        <div class="list-group-item">
                                            <p>{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @else
                404 error
            @endif

        </div>
    </div>
@endsection

@section('right_sidebar')
    <div class="">
        <button type="button" class="btn btn-block btn-ar btn-primary">Download Source</button>
        <div class="panel-item">
                <ul class="list-unstyled">
                    <li><strong>Author:</strong> <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></li>
                    <li><strong>Created:</strong> {{ $post->created_at->format('M d,Y') }}</li>
                    <li><strong>Updated:</strong> {{ $post->updated_at->format('M d,Y') }}</li>
                    <li><strong>Views:</strong> 3512</li>
                    <li><strong>Comments:</strong> <a href="#comments">12</a></li>
                </ul>
            <hr>
            <ul class="list-unstyled">
                <li><strong>Micro:</strong> <a href="#">PIC16</a></li>
                <li><strong>Vendor:</strong> <a href="#">Microchip</a></li>
                <li><strong>Arch:</strong> 8-bit</li>
                <li><strong>Language(s):</strong> C</li>
                <li><strong>Compiler:</strong> 25</li>
                <li><strong>Dev Tools:</strong> C</li>
                <li><strong>Categories:</strong>
                    @foreach($categories as $cat)

                    <a href="#">{{$cat->name}}</a>
                    @endforeach

                </li>

            </ul>
            <div class="tags-cloud">
                @foreach($post->tags as $tag)

                    <a href="/tags/{{$tag->slug}}" class="tag">{{strtolower($tag->name)}}</a>
                @endforeach
            </div>

            <h3 class="section-title">Related</h3>
            <ul class="list-unstyled related">
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Another fake title that is pretty long indeed oh owow </a></li>
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Test my link yo please </a></li>

            </ul>

        </div>
    </div>


    {{--<div class="block">--}}
        {{--<div class="tab-content ">--}}
            {{--<div class="panel panel-primary categories ">--}}
                {{--<h3 class="post-title no-margin-top"><i class="fa fa-folder-open"></i> Categories--}}
                {{--</h3>--}}
                {{--<ul class="simple">--}}
                    {{--<li><a href="#">Microchip PIC</a></li>--}}
                    {{--<li><a href="#">Atmel AVR</a></li>--}}
                    {{--<li><a href="#">TI MSP430</a></li>--}}
                    {{--<li><a href="#">Cypress PSoC</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="tab-content ">--}}

        {{--<div class="panel panel-primary categories ">--}}
            {{--<h3 class="post-title no-margin-top"><i class="fa fa-tags"></i> Tags</h3>--}}

            {{--<div class="tags-cloud">--}}
                {{--<a href="#" class="tag">Web</a>--}}
                {{--<a href="#" class="tag">Artificial Intelligence</a>--}}
                {{--<a href="#" class="tag">Programing</a>--}}
                {{--<a href="#" class="tag">Design</a>--}}
                {{--<a href="#" class="tag">3D</a>--}}
                {{--<a href="#" class="tag">Games</a>--}}
                {{--<a href="#" class="tag">Resources</a>--}}
                {{--<a href="#" class="tag">2D</a>--}}
                {{--<a href="#" class="tag">C++</a>--}}
                {{--<a href="#" class="tag">Jquery</a>--}}
                {{--<a href="#" class="tag">Javascript</a>--}}
                {{--<a href="#" class="tag">Library</a>--}}
                {{--<a href="#" class="tag">Windows</a>--}}
                {{--<a href="#" class="tag">Linux</a>--}}
                {{--<a href="#" class="tag">Cloud</a>--}}
                {{--<a href="#" class="tag">Game developer</a>--}}
                {{--<a href="#" class="tag">Server</a>--}}
                {{--<a href="#" class="tag">Google</a>--}}
                {{--<a href="#" class="tag">Bootstrap</a>--}}
                {{--<a href="#" class="tag">Less</a>--}}
                {{--<a href="#" class="tag">Sass</a>--}}
                {{--<a href="#" class="tag">Engine</a>--}}
                {{--<a href="#" class="tag">Node.js</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    {{--<div class="panel panel-primary">--}}
        {{--<div class="panel-heading"><i class="fa fa-comments"></i> Recent Comments</div>--}}
        {{--<div class="panel-body">--}}
            {{--<ul class="comments-sidebar">--}}

            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="panel panel-primary">--}}
        {{--<div class="panel-heading"><i class="fa fa-align-left"></i> Widget Text</div>--}}
        {{--<div class="panel-body">--}}
            {{--<p></p>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection