<!DOCTYPE html>
<html lang="en">
<head>
    @yield('head')


    @include('includes.head') {{-- importantt this comes last so that custom.css is not overriden--}}

</head>

<body>
<div id="wrap">
    <nav class="navbar navbar-default navbar-dark yamm navbar-static-top" role="navigation" id="header">
        @include('includes.navbar')
    </nav>






    @yield('header')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('message'))
                    <div class="flash alert-info">
                        <p class="panel-body">
                            {{ Session::get('message') }}
                        </p>
                    </div>
                @endif

                {{--Place these here since custom 404 page will always not have errors variable (this is a temp HACK)--}}
                @if(isset($errors))
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
                @endif
                @yield('center')
            </div>
        </div>
    </div>

</div>


<!-- footer-widgets -->
<footer id="footer" class="footer">
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
<script src="/bower_components/bootstrap-markdown-editor/dist/js/bootstrap-markdown-editor.js"></script>


@yield('script')
<script>
    jQuery(document).ready(function ($) {

        hljs.initHighlightingOnLoad();




    });
</script>

</body>

</html>
