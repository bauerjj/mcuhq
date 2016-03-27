<article class="post">
    <div class=""> {{--panel panel-default--}}
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    @if($post->main_image != '')
                        <img src="{{'/uploads/'.$post->main_image}}" class="img-post img-responsive main-image" alt="Image">
                        @else
                                <!-- https://pixabay.com/en/chip-micro-hardware-electronics-35646/ -->
                        <img src="/uploads/default-chip.png" class="img-post img-responsive main-image" alt="Image">

                    @endif
                </div>
                <div class="col-md-9 col-sm-9 post-content">
                    <h3 class="post-title">
                        <a href="{{ url('/'.$post->id .'/'.$post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    {!! str_limit(strip_tags($post->body_html), $limit = 250, $end = '....... <a href='.url("/".$post->id.'/'.$post->slug).'>Read More</a>') !!}

                </div>
            </div>
        </div>
        <div class="panel-footer post-info-b">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <i class="fa fa-clock-o"></i> {{ $post->created_at->format('M d, Y') }}
                    <i class="fa fa-user"> </i> <a
                            href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a>
                    <i class="fa fa-comments"></i><a href="{{url('/'.$post->id.'/'.$post->slug.'#comments')}}">{{$post->comments_count}}</a>
                    <i class="fa fa-eye"></i> {{$post->view_counter}}
                    <i class="fa fa-folder-open"></i>
                    <?php $i = 0; ?>
                    @foreach($post->categories as $cat)
                        <?php if ($i != 0) echo ' ,' ?>
                        <a href="{{url('/categories/'.$cat->slug)}}">{{$cat->name}}</a>
                        <?php $i++; ?>
                    @endforeach
                    <i class="fa fa-bolt"></i>
                    <a href="{{url('/vendors/'.$post->mcu->vendor->slug)}}">{{$post->mcu->vendor->name}}</a> //
                    <a href="{{url('/vendors/'.$post->mcu->vendor->slug.'/?mcu='.$post->mcu->slug)}}">{{$post->mcu->name}}</a>
                    <div class="tags-cloud">
                        @foreach($post->tagged as $tag)
                            <a href="/tags/{{$tag->tag_slug}}" class="tag">{{strtolower($tag->tag_name)}}</a>
                        @endforeach
                    </div>
                </div>
                {{--<div class="col-lg-2 col-md-2 col-sm-2">--}}
                {{--<a href="#" class="pull-right">Read more &raquo;</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</article>