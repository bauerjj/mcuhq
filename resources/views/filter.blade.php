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
            </div>
        </div>


@endsection


@section('right_sidebar')
    <div class="">
        <button type="button" class="btn btn-block btn-ar btn-primary">Download Source</button>
        <div class="panel-item">
            <ul class="list-unstyled">
                <li><strong>Views:</strong> 3512</li>
                <li><strong>Comments:</strong> <a href="#comments">12</a></li>
            </ul>
            <hr>

            <h3 class="section-title">Related</h3>
            <ul class="list-unstyled related">
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Another fake title that is pretty long indeed oh owow </a></li>
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Test my link yo please </a></li>
                <li><a href="#">Test my link yo please </a></li>

            </ul>
        </div>
    </div>

@endsection