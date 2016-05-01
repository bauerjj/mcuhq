@extends('layouts.full')

@section('title')blog | mcuhq @endsection

@section('meta')Microcontroller plus random thoughs blog | mcuhq  @endsection

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">Blog</li>
            </ol>
        </div>
    </header>

    <div class="container">
        <div class="portfolio-topbar hidden-sm hidden-xs">
            <div class="row filter-row">
                <div class="col-md-6 vendors">
                    <h4 class="first-letter">Blog Topics</h4>
                    <ul class="portfolio-topbar-cats">
                        <li><a href="{{Helper::modify_url(array('category'=> 'all'))}}"><span class="filter @if($inputs['category'] == 'all' || $inputs['category'] == '') active @else '' @endif" data-filter="all">All</span></a></li>
                        <li><a href="{{Helper::modify_url(array('category'=> 'microcontrollers'))}}"><span class="filter @if($inputs['category'] == 'microcontrollers') active @else '' @endif" data-filter=".category-1">Microcontrollers</span></a></li>
                        <li><a href="{{Helper::modify_url(array('category'=> 'website'))}}"><span class="filter @if($inputs['category'] == 'website') active @else '' @endif" data-filter=".category-2">Website</span></a></li>
                        <li><a href="{{Helper::modify_url(array('category'=> 'electronics'))}}"><span class="filter @if($inputs['category'] == 'electronics') active @else '' @endif" data-filter=".category-3">Electronics</span></a></li>
                        <li><a href="{{Helper::modify_url(array('category'=> 'industry-news'))}}"><span class="filter @if($inputs['category'] == 'industry-news') active @else '' @endif" data-filter=".category-4">Industry News</span></a></li>
                        <li><a href="{{Helper::modify_url(array('category'=> 'tech'))}}"><span class="filter @if($inputs['category'] == 'tech') active @else '' @endif" data-filter=".category-5">Tech</span></a></li>
                        <li><a href="{{Helper::modify_url(array('category'=> 'random'))}}"><span class="filter @if($inputs['category'] == 'random') active @else '' @endif" data-filter=".category-5">Random</span></a></li>

                    </ul>
                    <span class="topbar-border">&nbsp;</span>
                </div>
                <div class="col-md-2 port-fix sort">
                    <h4 class="first-letter">Sort</h4>
                    <ul class="portfolio-topbar-cats">
                        <li><a href="{{Helper::modify_url(array('sort'=> 'new'))}}"><span class="filter  @if($inputs['sort'] == '' || $inputs['sort'] == 'new') active @else '' @endif" data-filter=".category-1">New</span></a></li>
                        <li><a href="{{Helper::modify_url(array('sort'=> 'views'))}}"><span class="filter  @if($inputs['sort'] == 'views') active @else '' @endif" data-filter=".category-1">Popular</span></a></li>
                        <li><a href="{{Helper::modify_url(array('sort'=> 'comments'))}}"><span class="filter  @if($inputs['sort'] == 'comments') active @else '' @endif" data-filter=".category-1">Active</span></a></li>
                    </ul>
                    <span class="topbar-border">&nbsp;</span>

                </div>

                <div class="col-md-4 search ">
                    {{--<h4 class="first-letter">Sort</h4>--}}

                    <form role="form" method="get" action='{{ url("/search") }}'>
                        <div class="input-group search-main">
                            <input type="text" name="q" class="form-control " placeholder="Search Blog Articles...">
                            <span class="input-group-btn">
                                <button class="btn btn-ar btn-primary" type="button">Go!</button>
                            </span>
                        </div><!-- /input-group -->
                    </form>
                    <span class="topbar-border">&nbsp;</span>

                </div>

            </div>
        </div>
    </div>
@endsection



@section('center')
    <div class="container">
        <div class="row masonry-container">
            @foreach($posts as $blog)

            <div class="col-md-3 col-sm-6 masonry-item blog-item">
                <div class="thumbnail">
                    <img src="{{'/uploads/'.$blog->main_image}}" class="img-responsive" alt="Image">
                    <div class="caption">
                        <h3>
                            <a href="{{ url('/blog/'.$blog->id .'/'.$blog->slug) }}">{{ $blog->title }}</a>
                        </h3><div class="clearfix"></div>
                        <p>                        {!! str_limit(strip_tags($blog->body_html), $limit = 150, $end = '....... <a href='.url("/blog/".$blog->id.'/'.$blog->slug).'>Read More</a>') !!}
                        </p>
                        <hr class="dotted">
                    <span class="autor-post">
                        by <a href="{{url('/user/'.$blog->author->id.'/'.urlencode($blog->author->name))}}">{{$blog->author->name}}</a>
                    </span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div> <!-- masonry-item  -->

            @endforeach

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<div class="video">--}}
                        {{--<iframe src="http://player.vimeo.com/video/50061391?title=0&amp;byline=0&amp;portrait=0"></iframe>--}}
                    {{--</div>--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/img14.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/img10.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, laudantium.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/img13.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/img09.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/7.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/img08.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}

            {{--<div class="col-md-3 col-sm-6 masonry-item blog-item">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="assets/img/demo/img22.jpg" class="img-responsive" alt="Image">--}}
                    {{--<div class="caption">--}}
                        {{--<h3>An amazing post title</h3>--}}
                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem voluptate aut recusandae numquam dicta placeat in facilis voluptas dolorem vitae aliquam, voluptatem illo quo, saepe beatae cumque provident similique porro.</p>--}}
                        {{--<p>Tenetur labore fuga corporis tempore inventore minima itaque, veniam aliquid aliquam odit placeat tempora. Natus officia sit minima tempora.</p>--}}
                        {{--<hr class="dotted">--}}
                    {{--<span class="autor-post">--}}
                        {{--<img src="assets/img/demo/avatar100.jpg" alt="">--}}
                        {{--by <a href="#">adrigm</a>--}}
                    {{--</span>--}}
                        {{--<a href="#" class="btn btn-ar btn-primary pull-right" role="button">Read more &raquo;</a>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div> <!-- masonry-item  -->--}}


        {{--</div> <!-- masonry-container  -->--}}

    </div> <!-- container  -->
        </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.1.0/masonry.pkgd.min.js"></script>
    <script>
        $('.masonry-container').masonry({
            // options
            itemSelector: '.masonry-item',
            columnWidth: '.masonry-item'
        });
    </script>
@endsection