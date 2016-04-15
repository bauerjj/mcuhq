@extends('layouts.sidebar')

@section('title'){{$sort . $vendor}} microcontroller projects and tutorials | mcuhq @endsection

@section('meta')A community-driven analysis and discussion of microcontroller projects and ideas  @endsection

@section('header')
    <header class="main-header animated fadeInDown animation-delay-1">
        <div class="container home-phrase">
            A community-driven knowledge base of microcontroller projects and ideas. <a href="/register">Signup</a> now to start
            contributing!
        </div>
    </header>

    <div class="container">
        <div class="portfolio-topbar hidden-sm hidden-xs">
            <div class="row filter-row">
                <div class="col-md-6 vendors">
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
                        {{--<li><a href="{{Helper::modify_url(array('vendor'=> 'fujitsu'))}}"><span class="filter @if($inputs['vendor'] == 'fujitsu') active @else '' @endif" data-filter=".category-6">Fujitsu</span></a></li>--}}

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
                            <input type="text" name="q" class="form-control " placeholder="Search...">
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
    @foreach( $posts as $post )
            @include('posts')
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

@section('right_sidebar')
    {{--<a href="" type="button" class="btn btn-block btn-ar btn-primary">Reset Filters</a>--}}

    <div class="">
        <div class="panel-item block">
            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Top Tags</h3>
                <div class="tags-cloud">
                    @foreach($tagsNavBar as $tag)
                            <a href="/tags/{{$tag->slug}}" class="tag">{{$tag->slug .' x '.$tag->count.''}}</a>
                    @endforeach
                </div>
    </div>
    </div>
    </div>

   @endsection




