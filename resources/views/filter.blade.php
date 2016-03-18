@extends('layouts.sidebar')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">Microchip</li>
            </ol>
        </div>
    </header>

@endsection



@section('center')
    <div class="panel-default post-show">
        <div class="panel-title">
           <h2>Vendors: {{$vendor->name}}</h2>
            <p class="small">{{$vendor->description}} </p>
        </div>

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
                                <i class="fa fa-comments"></i><a href="{{url('/'.$post->id.'/'.$post->slug.'#comments')}}">{{$post->comments_count}}</a>
                                <i class="fa fa-eye"></i> {{$post->view_counter}}
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

        <section class="text-center">
            {!! $pagination->render() !!}
        </section>

    </div>


@endsection


@section('right_sidebar')
    <button type="button" class="btn btn-block btn-ar btn-primary">Reset Filters</button>

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


            <div class="tags-cloud">
                <h3 class="post-title no-margin-top section-title">Tags</h3>

                @foreach($tags as $tag => $count)
                    <a href="/tags/{{$tag}}" class="tag">{{strtolower($tag)}} {{$count}}</a>
                @endforeach
            </div>


        </div>
    </div>

@endsection

