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

    </div>


@endsection


@section('right_sidebar')
    <div class="">
        <div class="panel-item block">

            <div class="tab-pane" id="categories">
                <h3 class="post-title no-margin-top section-title">Micro Family</h3>
                <ul class="simple">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Artificial Intelligence</a>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Web Developer</a></li>
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