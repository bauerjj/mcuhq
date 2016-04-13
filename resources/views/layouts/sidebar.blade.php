<!DOCTYPE html>
<html lang="en">
<head>

    @yield('head')


    @include('includes.head')

</head>

<body>
<div id="sb-site" class="wrap">
    <nav class="navbar navbar-default navbar-dark yamm navbar-static-top" role="navigation" id="header">
        @include('includes.navbar')
    </nav>

    @yield('header')
    <div class="container margin-top-10">
        <div class="row main-content">
            <div class="col-md-9">
                @if (Session::has('message'))
                    <div class="flash alert-info">
                        <p class="panel-body">
                            {{ Session::get('message') }}
                        </p>
                    </div>
                @endif
                @if ($errors->any())
                    <div class='flash alert-danger'>
                        <ul class="panel-body">
                            @foreach ( $errors->all() as $error )
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('center')
            </div>
            <div class="col-md-3 ">
                <aside class="sidebar">
                    @yield('right_sidebar')
                </aside>

            </div>
        </div>
    </div>

</div>


<!-- footer-widgets -->
<footer id="footer">
    @include('includes.footer')
</footer>

@include('includes.slidebar')

<div id="back-top">
    <a href="#header"><i class="fa fa-chevron-up"></i></a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slidebars/0.10.2/slidebars.min.js"></script>

{!! Minify::javascript("/assets/js/DropdownHover.js") !!}


@yield('script')
<script>
    jQuery(document).ready(function ($) {

        hljs.initHighlightingOnLoad();

        $.slidebars({
            // siteClose: true, // true or false
            //disableOver: 480 // integer or false
            // hideControlClasses: true, // true or false
            // scrollLock: false // true or false
        });


    });

</script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-75403236-1', 'auto');
    ga('send', 'pageview');

</script>

</body>

</html>
