@extends('layouts.full')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">404Error</li>
            </ol>
        </div>
    </header>

@endsection


@section('center')

    <div class="center-block error-404">
        <section class="text-center">
            <h1>Error 404</h1>
            <h2>Page not found</h2>
            <p class="lead lead-lg">The requested URL was not found on this server. That is all we know.</p>

            <a href="/" role="button" class="btn btn-ar btn-block btn-lg btn-primary">Back to Home</a>

        </section>
    </div>
@endsection