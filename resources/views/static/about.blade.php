@extends('layouts.full')

@section('header')
    <header class="main-header">
        <div class="container">

            <ol class="breadcrumb ">
                <li><a href="/">Home</a></li>
                <li class="active">About</li>
            </ol>
        </div>
    </header>

@endsection


@section('center')
    <div class="row">
        <div class="col-md-12">
            <div class="title-logo animated fadeInDown animation-delay-5">mcu<span>hq</span></div>
        </div>
        <div class="col-md-7">
            <h2 class="right-line">What is this?</h2>
            <p>A "Microcontroller <span class="highlighted">H</span>ead<span class="highlighted">q</span>uarters"</span> dedicated to heavily detailed discussion on microcontroller hardware and sofware.
            This content here focuses more on the microcontroller and its peripherals over the hack.
            </p>

           <p>It was born out of the frustration from using Instructables and hackaday where it was near impossible to replicate the project and learn how things really work under the hood. </p>
            <p>Originally I set out to create an online repository of my microcontroller studies, but soon realized that I can expand this so that anyone can add material.  </p>

            <p>For comments, suggestions, or errors, please contact me via <a href="http://github.com/mcuhq">github</a> or <a href="mailto:contact@mcuhq.com?Subject=Web%20Contact" target="_top">email</a>. I am still adding a bunch of new things to the site.</p>


            <p> - <a href="/user/1">Justin Bauer</a></p>
        </div>
        <div class="col-md-5">
            <h2 class="right-line">Completely Open Source</h2>
            <p>mcu<span>hq</span> strives for collaboration, which is why the source code for this entire website is openly avaliable to download and use!</p>
            <p>Built using <a href="https://laravel.com/">Laravel 5.2</a>, this "wiki-like" codebase can be easily migrated to other topics of interest. </p>
            <div class="github-widget" data-repo="mcuhq/mcuhq"></div>
        </div>
    </div> <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="right-line">What makes us different</h2>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="text-icon">
                <span class="icon-ar icon-ar-lg"><i class="fa fa-cloud"></i></span>
                <div class="text-icon-content">
                    <h3 class="no-margin">Easy to follow and reproduce</h3>
                    <p>Beginners should feel perfectly suitable in following along. Each article is written with beginners in mind. </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="text-icon">
                <span class="icon-ar icon-ar-lg"><i class="fa fa-desktop"></i></span>
                <div class="text-icon-content">
                    <h3 class="no-margin">Quickly find content</h3>
                    <p>The navigation and filtering terms are designed to highlight each microcontroller, its vendor, and its abilities</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="text-icon">
                <span class="icon-ar icon-ar-lg"><i class="fa fa-tablet"></i></span>
                <div class="text-icon-content">
                    <h3 class="no-margin">Add content with no pain</h3>
                    <p>Use the widely popular <a href="http://dillinger.io/">markdown</a> editor when adding or editing your mcu submission.</p>
                </div>
            </div>
        </div>

    </div> <!-- row -->

    @endsection

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/github-repo-widget/e23d85ab8f/jquery.githubRepoWidget.min.js"></script>

@endsection