@extends('layouts.full')

@section('header')
    <header class="main-header animated fadeInDown animation-delay-1">
        <div class="container">
            A community-driven knowledge base of microcontroller projects and ideas. <a href="#">Signup</a> now to start
            contributing!
        </div>
    </header>


    <div class="container">
        <div class="portfolio-topbar hidden-sm hidden-xs">
            <div class="row">
                <div class="col-md-8">
                    <h4>Vendors</h4>
                    <ul class="portfolio-topbar-cats">
                        <li><span class="filter active" data-filter="all">All</span></li>
                        <li><span class="filter" data-filter=".category-1">Microchip</span></li>
                        <li><span class="filter" data-filter=".category-2">Atmel</span></li>
                        <li><span class="filter" data-filter=".category-3">Cypress</span></li>
                        <li><span class="filter" data-filter=".category-4">TI</span></li>
                        <li><span class="filter" data-filter=".category-5">Renesas</span></li>
                        <li><span class="filter" data-filter=".category-6">STMicro</span></li>
                        <li><span class="filter" data-filter=".category-6">Infineon</span></li>
                        <li><span class="filter" data-filter=".category-6">NXP</span></li>
                        <li><span class="filter" data-filter=".category-6">Fujitsu</span></li>
                        <li><span class="filter" data-filter=".category-6">Others</span></li>


                    </ul>
                    <span class="topbar-border">&nbsp;</span>
                </div>
                <div class="col-md-2 port-fix">
                    <h4>Sort</h4>
                    <ul class="portfolio-topbar-cats">
                        <li><span class="filter active" data-filter=".category-1">New</span></li>
                        <li><span class="filter" data-filter=".category-1">Popular</span></li>
                        <li><span class="filter" data-filter=".category-1">Active</span></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h4>Filter</h4>
                    <ul class="portfolio-topbar-desc">
                        <li><a href="javascript:void(0);" id="port-show" class="active">Vendor</a></li>
                        <li><a href="javascript:void(0);" id="port-hide">Topic</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('center')
    @foreach( $posts as $post )
        <article class="post">
            <div class=""> {{--panel panel-default--}}
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <img src="/assets/img/demo/2.jpg" class="img-post img-responsive" alt="Image">
                        </div>
                        <div class="col-md-9 col-sm-9 post-content">
                            <h3 class="post-title">
                                <a href="{{ url('/'.$post->id .'/'.$post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            {!! str_limit(strip_tags($post->body_html), $limit = 250, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}

                        </div>
                    </div>
                </div>
                <div class="panel-footer post-info-b">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <i class="fa fa-clock-o"></i> {{ $post->created_at->format('M d, Y') }}
                            <i class="fa fa-user"> </i> <a
                                    href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a>
                            <i class="fa fa-folder-open"></i>
                            <?php $i = 0; ?>
                            @foreach($post->categories as $cat)
                                <?php if ($i != 0) echo ' ,' ?>
                                <a href="#">{{$cat->name}}</a>
                                <?php $i++; ?>
                            @endforeach
                            <div class="tags-cloud">
                                @foreach($post->tagged as $tag)
                                    <a href="/tags/{{$tag->tag_slug}}" class="tag">{{strtolower($tag->tag_name)}}</a>
                                @endforeach
                            </div>
                        </div>
                        {{--<div class="col-lg-2 col-md-2 col-sm-2">--}}
                        {{--<a href="#" class="pull-right">Read more &raquo;</a>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </article>
    @endforeach


    <section class="text-center">
        {!! $posts->render() !!}
    </section>
@endsection




