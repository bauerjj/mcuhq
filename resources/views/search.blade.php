@extends('layouts.full')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">search</li>
            </ol>
        </div>
    </header>

@endsection

@section('center')
    <form role="form" method="get" action='{{ url("/search") }}'>
        <div class="input-group">
            <input type="text" class="form-control" name="q" value='{{$search}}' placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-ar btn-primary" type="submit">Go!</button>
                            </span>
        </div><!-- /input-group -->
    </form>
    <br/>

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