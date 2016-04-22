<div class="sb-slidebar sb-right">
    <form role="form" method="get" action='{{ url("/search") }}'>
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Search...">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
        </span>
        </div><!-- /input-group -->
    </form>

    <h2 class="slidebar-header no-margin-bottom">Recent Posts</h2>
    <ul class="slidebar-menu">
        @foreach($recentPostsSidebar as $post)
            <li><a href="{{url($post->id.'/'.$post->slug)}}">{{$post->title}}</a></li>
        @endforeach
        {{--<li><a href="index.html">Home</a></li>--}}
        {{--<li><a href="portfolio_topbar.html">Portfolio</a></li>--}}
        {{--<li><a href="page_about3.html">About us</a></li>--}}
        {{--<li><a href="blog.html">Blog</a></li>--}}
        {{--<li><a href="page_contact.html">Contact</a></li>--}}
    </ul>

    <h2 class="slidebar-header">Obligatory</h2>
    <div class="slidebar-social-icons">
        <a href="https://twitter.com/mcuhq" class="twitter"><i class="fa my-fa-twitter fa-3x"> </i></a>
        <a href="https://github.com/mcuhq/mcuhq" class="github"><i class="fa fa fa-github fa-3x"> </i></a>
        <a href="https://www.linkedin.com/in/justin-bauer-a7a9ba116" class="linkedin"><i class="fa my-fa-linkedin-square fa-3x"> </i></a>
    </div>
</div> <!-- sb-slidebar sb-right -->