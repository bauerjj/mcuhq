<!DOCTYPE html>
<html lang="en">
<head>

    @yield('head')


    @include('includes.head')

</head>

<body>
<div id="wrap">
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
            <div class="col-md-3">
                <aside class="sidebar">
                    @yield('right_sidebar')
                </aside>

            </div>
        </div>
    </div>

</div>


<!-- footer-widgets -->
<footer id="footer-v6" class="footer">
    @include('includes.footer')
</footer>

<div id="back-top">
    <a href="#header"><i class="fa fa-chevron-up"></i></a>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
<script src="/assets/js/vendors.js"></script>
<script src="/assets/js/DropdownHover.js"></script>
<script src="/assets/js/app.js"></script>
<script src="/assets/js/holder.js"></script>

@yield('script')
<script>
    jQuery(document).ready(function ($) {

        hljs.initHighlightingOnLoad();




    });

</script>

</body>

</html>
