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
                    <h4 class="first-letter">Vendors</h4>
                    <ul class="portfolio-topbar-cats">
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'all'))}}"><span class="filter @if($inputs['vendor'] == 'all' || $inputs['vendor'] == '') active @else '' @endif" data-filter="all">All</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'microchip'))}}"><span class="filter @if($inputs['vendor'] == 'microchip') active @else '' @endif" data-filter=".category-1">Microchip</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'atmel'))}}"><span class="filter @if($inputs['vendor'] == 'atmel') active @else '' @endif" data-filter=".category-2">Atmel</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'cypress'))}}"><span class="filter @if($inputs['vendor'] == 'cypress') active @else '' @endif" data-filter=".category-3">Cypress</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'ti'))}}"><span class="filter @if($inputs['vendor'] == 'ti') active @else '' @endif" data-filter=".category-4">TI</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'renesas'))}}"><span class="filter @if($inputs['vendor'] == 'renesas') active @else '' @endif" data-filter=".category-5">Renesas</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'stmicro'))}}"><span class="filter @if($inputs['vendor'] == 'stmicro') active @else '' @endif" data-filter=".category-6">STMicro</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'infineon'))}}"><span class="filter @if($inputs['vendor'] == 'infineon') active @else '' @endif" data-filter=".category-6">Infineon</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'nxp'))}}"><span class="filter @if($inputs['vendor'] == 'nxp') active @else '' @endif" data-filter=".category-6">NXP</span></a></li>
                        <li><a href="{{Helper::modify_url(array('vendor'=> 'fujitsu'))}}"><span class="filter @if($inputs['vendor'] == 'fujitsu') active @else '' @endif" data-filter=".category-6">Fujitsu</span></a></li>


                    </ul>
                    <span class="topbar-border">&nbsp;</span>
                </div>
                <div class="col-md-2 port-fix">
                    <h4 class="first-letter">Sort</h4>
                    <ul class="portfolio-topbar-cats">
                        <li><span class="filter active" data-filter=".category-1">New</span></li>
                        <li><span class="filter" data-filter=".category-1">Popular</span></li>
                        <li><span class="filter" data-filter=".category-1">Active</span></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h4 class="first-letter">Filter</h4>
                    <ul class="portfolio-topbar-desc">
                        <li><a href="javascript:void(0);" id="port-show" class="active">Vendor</a></li>
                        <li><a href="javascript:void(0);" id="port-hide">Category</a></li>
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
                            @if($post->main_image != '')
                                <img src="{{'/uploads/'.$post->main_image}}" class="img-post img-responsive main-image" alt="Image">
                                @else
                                <!-- https://pixabay.com/en/chip-micro-hardware-electronics-35646/ -->
                                <img src="/uploads/default-chip.png" class="img-post img-responsive main-image" alt="Image">

                            @endif
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
                            <i class="fa fa-bolt"></i>
                            <a href="{{url('vendors/'.$post->mcu->vendor->slug)}}">{{$post->mcu->vendor->name}}</a> //
                            <a href="{{url('vendors/'.$post->mcu->vendor->slug.'/?mcu='.$post->mcu->slug)}}">{{$post->mcu->name}}</a>
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

    @if(sizeof($posts) <1)
        <section class="text-center">
            <h1>No Posts found matching your criteria</h1>

            <a href="{{url('/new-post')}}" role="button" class="btn btn-ar btn-lg btn-primary">Contribute one now!</a>

        </section>


    @else
    <section class="text-center">
        {!! $posts->render() !!}
    </section>

    @endif
@endsection




