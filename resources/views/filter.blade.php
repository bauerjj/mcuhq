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
           <h2>Vendors: Microchip</h2>
            <p class="small">Microchip is best known for its 8-bit processors such as the PIC16 and PIC18 series. </p>
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
            {!! $pagination->render() !!}
        </section>

    </div>


@endsection


@section('right_sidebar')
    <div class="">
        <div class="panel-item block">

            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Micro Family</h3>
                <ul class="simple">
                    <li class="active"><a href={{"?".$_SERVER['QUERY_STRING']."&compiler=all"}}>All</a></li>
                    @foreach($compilers as $compiler => $count)
                        <li><a href="?compiler={{urlencode(strtolower($compiler))}}">{{$compiler}} ({{$count}})</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Compilers</h3>
                <ul class="simple">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Artificial Intelligence</a>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Web Developer</a></li>
                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Languages</h3>
                <ul class="simple">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Artificial Intelligence</a>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Web Developer</a></li>
                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Category</h3>
                <ul class="simple">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Artificial Intelligence</a>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Web Developer</a></li>
                </ul>
            </div>
            <div class="tags-cloud">
                {{--@foreach($post->tags as $tag)--}}

                    {{--<a href="/tags/{{$tag->slug}}" class="tag">{{strtolower($tag->name)}}</a>--}}
                {{--@endforeach--}}
            </div>


        </div>
    </div>

@endsection

