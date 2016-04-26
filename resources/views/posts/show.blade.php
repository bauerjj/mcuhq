@extends('layouts.sidebar')

@section('title'){{$post->title}} | mcuhq @endsection
@section('meta'){{$post->description}} @endsection

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li><a href="/vendors/{{$vendor->slug}}">{{$vendor->name}}</a></li>
                <li class="active">{{ $post->title }}</li>
            </ol>
        </div>
    </header>
@endsection

@section('head')
     {{--For the comments plugin--}}
    <link rel="stylesheet" href="/vendor/comments/css/prism-okaidia.css">
    <link rel="stylesheet" href="/vendor/comments/css/comments.css">

@endsection


@section('center')

    <div class="panel-default post-show">
        <div class="panel-title">
            <h2>
                @if($post)
                    {{{ $post->title }}}
                    @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
                        <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->id .'/'.$post->slug)}}">Edit Post</a>
                        </button>
                    @endif
                @else
                    Page does not exist
                @endif

            </h2>
            <p>{{ $post->created_at->format('M d,Y') }} By <a
                        href="{{ url('/user/'.$post->author_id)}}">{{{ $post->author->name }}}</a></p>
        </div>
        <div class="panel-body">
            @if($post)
                <div>
                    {!! $post->body_html !!}
                </div>


                <div class="">
                    <h2>Comments</h2>
                    <div id="demoo" class="">
                        {{--@if(!Auth::guest() && Auth::user()->is_admin())--}}
                        {{--<div class="pull-left">--}}
                            {{--<a href="{{ route('comments.admin.index') }}" class="btn btn-default btn-sm">Admin Dashboard</a>--}}
                        {{--</div>--}}
                        {{--@endif--}}
                            {{--If comments arn't showing up: do php artisan config:cache and composer dump-autoload--}}
                        {{--comments/src/Jobs/FetchComments.php commment out the following:--}}
                        {{--//            if ($this->author->guest()) {--}}
                        {{--//                $query->authorEmail($email, 'or');--}}
                        {{--//            } elseif ($email) {--}}
                        {{--//                $query->userId($this->author->id(), 'or');--}}
                        {{--//            }--}}
                        {{--Also comment out the URL portion of the form in 'post-form.blade.php'--}}

                        <div class="clearfix"></div>

                        @include('help')

                                <!-- Display comments. -->
                        @include('comments::display', ['pageId' => $post->id, 'id' => 'comments'])
                    </div>
                </div>
            @else
                404 error
            @endif

        </div>
    </div>
@endsection

@section('right_sidebar')
    <div class="">
        @if($post->main_image != '')
            <img src="{{'/uploads/'.$post->main_image}}" class="main-image-preview" alt="Image">
        @endif
        @if($post->source_file == '')
            <a href="#" type="button" class="btn btn-block btn-ar btn-primary disabled">No Source Download</a>
        @else
            <a href="{{url('/uploads/'.$post->source_file)}}" type="button" class="btn btn-block btn-ar btn-primary">Download Source</a>
        @endif
            <div class="panel-item">
                <ul class="list-unstyled">
                    <li><strong>Author:</strong> <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></li>
                    <li><strong>Created:</strong> {{ $post->created_at->format('M d,Y') }}</li>
                    <li><strong>Updated:</strong> {{ $post->updated_at->format('M d,Y') }}</li>
                    @if(($post->more_info_link) != "")
                        @if(strpos($post->more_info_link, 'github'))
                            <li><strong>Follow: </strong><a href="{{$post->more_info_link}}">github</a></li>
                        @else
                            <li><strong>Follow: </strong><a href="{{$post->more_info_link}}">source</a></li>
                        @endif
                    @endif
                    <li><strong>Views:</strong> {{$post->view_counter}}</li>
                    <li><strong>Comments:</strong> <a href="#comments">{{$post->comments->count()}}</a></li>
                </ul>
            <hr>
            <ul class="list-unstyled">
                <li><strong>Micro:</strong> <a href="{{url('vendors/'.$vendor->slug.'/?mcu='.$mcu->slug)}}">{{$mcu->name}}</a></li>
                <li><strong>Vendor:</strong> <a href="{{url('vendors/'.$vendor->slug)}}">{{$vendor->name}}</a></li>
                <li><strong>Arch:</strong> {{{$arch->name}}}</li>
                @if(isset($languages))
                <li><strong>Language(s): </strong>
                    @foreach($languages as $language)

                        <a href="{{url('vendors/'.$vendor->slug.'/?language='.$language->slug)}}">{{{$language->name}}}</a>
                    @endforeach
                </li>
                @endif
                @if(isset($compiler))
                <li><strong>Compiler:</strong>
                        <a href="{{url('vendors/'.$vendor->slug.'/?compiler='.$compiler->slug)}}">{{{$compiler->name}}}</a>
                </li>
                @endif
                <li><strong>Categories:</strong>
                    @foreach($categories as $cat)

                    <a href="{{url('categories/'.$cat->slug)}}">{{{ $cat->name }}}</a>
                    @endforeach

                </li>

            </ul>
            <div class="tags-cloud">
                @foreach($post->tags as $tag)
                    <a href="{{url('tags/'.$tag->slug)}}" class="tag">{{{strtolower($tag->name)}}}</a>
                @endforeach
            </div>

            <h3 class="section-title">Related</h3>
            <ul class="list-unstyled related">
                @foreach($related as $post)
                    <li><a href="{{url($post->id.'/'.$post->slug)}}">{{{$post->title}}}</a></li>
                @endforeach
            </ul>

        </div>
    </div>
@endsection

@section('script')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js"></script>--}}



    <script>
        // So to make any large images fit inside viewing area
        $( ".main-content img" ).addClass( "img-responsive img-thumbnail center-block" );
        $("table").addClass("table-bordered table table-striped");

        $('.main-content').find('img').each(function() {
            // Don't do anything to the main image picture though!
            if(!$(this).hasClass('main-image-preview'))
                //for each img add the width plus a specific value, in this case 20
                $( this ).wrap("<div class='row'><div class='testt'>" +  " <a class='inline' href='" + $(this).attr("src") + "' " + " data-toggle='lightbox'></div></div<");

        });


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.js"></script>

    <script>

        // delegate calls to data-toggle="lightbox"
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
                onShown: function() {
                    if (window.console) {
                        return console.log('onShown event fired');
                    }
                },
                onContentLoaded: function() {
                    if (window.console) {
                        return console.log('onContentLoaded event fired');
                    }
                },
                onNavigate: function(direction, itemIndex) {
                    if (window.console) {
                        return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                    }
                }
            });
        });
    </script>

    {{--For the comments plugin--}}
    <script src="http://cdn.jsdelivr.net/vue/1.0.16/vue.min.js"></script>
    <script src="/vendor/comments/js/utils.js"></script>
    <script src="/vendor/comments/js/comments.min.js"></script>
    {{--///////////////////////////////////////////////////////--}}


@endsection