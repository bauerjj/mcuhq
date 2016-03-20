@extends('layouts.sidebar')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">{{$breadcrumb}}</li>
            </ol>
        </div>
    </header>

@endsection



@section('center')
    <div class="panel-default post-show">
        <div class="panel-title">
           <h2>{{$topic .': '. $title}}</h2>
            <p class="small">{{$description}} </p>
        </div>

        <hr/>

        @foreach( $posts as $post )
            @include('posts')
        @endforeach

        <section class="text-center">
            {!! $pagination->render() !!}
        </section>

    </div>


@endsection


@section('right_sidebar')
    <a href="{{$url}}" type="button" class="btn btn-block btn-ar btn-primary">Reset Filters</a>

    <div class="">
        <div class="panel-item block">
            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Micro Family</h3>
                <ul class="simple">
                    @if($inputs['mcu'] == 'all' || $inputs['mcu'] == '')
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a href={{Helper::modify_url(array('mcu'=>'all'))}}>All</a></li>
                    @foreach($mcus as $mcu => $count)
                            @if($inputs['mcu'] == urlencode(strtolower($mcu)))
                                <li class="active">
                                @else
                                    <li>
                                @endif
                        <a href="{{Helper::modify_url(array('mcu'=> urlencode(strtolower($mcu))))}}">{{$mcu}} ({{$count}})</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Compiler</h3>
                <ul class="simple">
                    @if($inputs['compiler'] == 'all' || $inputs['compiler'] == '')
                        <li class="active">
                            @else
                                <li>
                        @endif
                    <a href={{Helper::modify_url(array('compiler'=>'all'))}}>All</a></li>
                    @foreach($compilers as $compiler => $count)
                        @if($inputs['compiler'] == urlencode(strtolower($compiler)))
                            <li class="active">
                                @else
                                    <li>
                                        @endif
                            <a href="{{Helper::modify_url(array('compiler'=> urlencode(strtolower($compiler))))}}">{{$compiler}} ({{$count}})</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Languages</h3>
                <ul class="simple">
                    @if($inputs['language'] == 'all' ||$inputs['language'] == '' )
                        <li class="active">
                    @else
                        <li>
                            @endif
                            <a href={{Helper::modify_url(array('lan'=>'all'))}}>All</a></li>
                        @foreach($languages as $language => $count)
                            @if($inputs['language'] == urlencode(strtolower($language)))
                                <li class="active">
                            @else
                                <li>
                                    @endif
                                    <a href="{{Helper::modify_url(array('lan'=> urlencode(strtolower($language))))}}">{{$language}} ({{$count}})</a></li>
                                @endforeach
                </ul>
            </div>
            @if($topic != 'Category')
            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Categories</h3>
                <ul class="simple">
                    @if($inputs['category'] == 'all' ||$inputs['category'] == '' )
                        <li class="active">
                    @else
                        <li>
                            @endif
                            <a href={{Helper::modify_url(array('category'=>'all'))}}>All</a></li>
                        @foreach($categories as $category => $count)
                            @if($inputs['category'] == urlencode(strtolower($category)))
                                <li class="active">
                            @else
                                <li>
                                    @endif
                                    <a href="{{Helper::modify_url(array('category'=> urlencode(strtolower($category))))}}">{{$category}} ({{$count}})</a></li>
                                @endforeach
                </ul>
            </div>
            @endif


            @if($topic != 'Tag')

            <div class="tags-cloud">
                <h3 class="post-title no-margin-top section-title">Tags</h3>

                @foreach($tags as $tag => $count)
                    @if($inputs['tag'] == urlencode(strtolower($tag)))
                        <a href="{{Helper::modify_url(array('tag'=> urlencode(strtolower($tag))))}}" class="tag active">{{strtolower($tag)}} ({{$count}})</a>

                    @else
                    <a href="{{Helper::modify_url(array('tag'=> urlencode(strtolower($tag))))}}" class="tag">{{strtolower($tag)}} ({{$count}})</a>
                    @endif
                @endforeach
            </div>
                @endif


        </div>
    </div>

@endsection

