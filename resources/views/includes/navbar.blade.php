<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-bars"></i>
        </button>
        <a id="ar-brand" class="navbar-brand" href="/"><span></span></a>
    </div>
    <!-- navbar-header -->

    <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="pull-right">
               <a href="javascript:void(0);" class="sb-icon-navbar sb-toggle-right"><i class="fa fa-bars"></i></a>
            </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            {{--<li>--}}
                {{--<a href="/">Home</a>--}}
            {{--</li>--}}
            <li class="dropdown search">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i></a>
                <div class="dropdown-menu  dropdown-search-box animated fadeInDown">
                    <form role="form" method="get" action='{{ url("/search") }}'>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-ar btn-primary" type="submit">Go!</button>
                            </span>
                        </div><!-- /input-group -->
                    </form>
                </div>
            </li> <!-- dropdown -->
            <li class="dropdown yamm-fw">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                   data-hover="dropdown">Tags and Categories</a>
                <ul class="dropdown-menu dropdown-menu-left animated-2x animated fadeIn">
                    <li>
                        <div class="yamm-content">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        {{--<h4 class="megamenu-block-title"><i class="fa fa-tag"></i>--}}
                                            {{--Top Tags</h4>--}}
                                        <div class="tags-cloud">
                                            <?php $count = 0; ?>
                                            @foreach($tagsNavBar as $tag)
                                                @if($count++ < 10)
                                                   <a href="/tags/{{$tag->slug}}" class="tag">{{$tag->slug}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <div class="tags-cloud">
                                            <?php $count = 0; ?>
                                            @foreach($tagsNavBar as $tag)
                                                @if($count++ < 10)

                                                @elseif($count > 10 && $count < 20)
                                                    <a href="/tags/{{$tag->slug}}" class="tag">{{$tag->slug}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix  hidden-lg"></div>


                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        {{--<h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Topics</h4>--}}
                                        <ul>
                                            <?php $count = 0; ?>
                                            @foreach($categoriesNavBar as $cat)
                                                @if($count++ < 5)
                                                    <li><a href="/categories/{{$cat->slug}}">
                                                            {{$cat->name}} <span class="badge">{{$cat->count}}</span></a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        {{--<h4>&nbsp;</h4>--}}
                                        <ul>
                                            <?php $count = 0; ?>
                                            @foreach($categoriesNavBar as $cat)
                                                @if($count++ < 5)

                                                @elseif($count++ > 5 && $count < 16)
                                                    <li><a href="/categories/{{$cat->slug}}">
                                                            {{$cat->name}} <span class="badge">{{$cat->count}}</span></a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="dropdown yamm-fw">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                   data-hover="dropdown">Microcontrollers</a>
                <ul class="dropdown-menu dropdown-menu-left animated-2x animated fadeIn">
                    <li>
                        <div class="yamm-content">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <div>
                                            <a href="{{url('vendors/microchip?mcu=pic10')}}" class="tag">PIC10</a>
                                            <a href="{{url('vendors/microchip?mcu=pic12')}}" class="tag">PIC12</a>
                                            <a href="{{url('vendors/microchip?mcu=pic16')}}" class="tag">PIC16</a>
                                            <a href="{{url('vendors/microchip?mcu=pic18')}}" class="tag">PIC18</a>
                                            <a href="{{url('vendors/microchip?mcu=pic24')}}" class="tag">PIC24</a>
                                            <a href="{{url('vendors/microchip?mcu=dspic')}}" class="tag">dsPIC</a>
                                            <a href="{{url('vendors/microchip?mcu=pic32')}}" class="tag">PIC32</a>

                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Atmel</h4>
                                        <div>
                                            <a href="{{url('vendors/atmel?mcu=aruduino')}}" class="tag">Arduino</a>
                                            <a href="{{url('vendors/atmel?mcu=attiny')}}" class="tag">ATtiny</a>
                                            <a href="{{url('vendors/atmel?mcu=atmega')}}" class="tag">ATmega</a>
                                            <a href="{{url('vendors/atmel?mcu=atxmega')}}" class="tag">ATxmega</a>
                                            <a href="{{url('vendors/atmel?mcu=at91asm')}}" class="tag">AT91SAM</a>
                                            <a href="{{url('vendors/atmel?mcu=avr32')}}" class="tag">AVR32</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Cypress</h4>
                                        <div>
                                            <a href="{{url('vendors/cypress?mcu=psoc3')}}" class="tag">PSoC3</a>
                                            <a href="{{url('vendors/cypress?mcu=psoc4')}}" class="tag">PSoC4</a>
                                            <a href="{{url('vendors/atmel?mcu=psoc5')}}" class="tag">PSoC5</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Texas Inst.</h4>
                                        <div>
                                            <a href="{{url('vendors/ti?mcu=msp430')}}" class="tag">MSP430</a>
                                            <a href="{{url('vendors/ti?mcu=msp432')}}" class="tag">MSP432</a>
                                            <a href="{{url('vendors/ti?mcu=tms570')}}" class="tag">TMS570</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Renasas</h4>
                                        <div>
                                            <a href="{{url('vendors/renasas?mcu=rl78')}}" class="tag">RL78</a>
                                            <a href="{{url('vendors/renasas?mcu=78k')}}" class="tag">78K</a>
                                            <a href="{{url('vendors/renasas?mcu=r8c')}}" class="tag">R8C</a>
                                            <a href="{{url('vendors/renasas?mcu=rx')}}" class="tag">RX</a>
                                            <a href="{{url('vendors/renasas?mcu=rz')}}" class="tag">RZ</a>
                                            <a href="{{url('vendors/renasas?mcu=v850')}}" class="tag">V850</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> STMicro</h4>
                                        <div>
                                            <a href="{{url('vendors/stmicro?mcu=st7')}}" class="tag">ST7</a>
                                            <a href="{{url('vendors/stmicro?mcu=stm8')}}" class="tag">STM8</a>
                                            <a href="{{url('vendors/stmicro?mcu=st10')}}" class="tag">ST10</a>
                                            <a href="{{url('vendors/stmicro?mcu=stm32')}}" class="tag">STM32</a>
                                        </div>

                                    </div>
                                </div>

                                <div class="clearfix  hidden-lg"></div>


                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> NXP</h4>
                                        <div>
                                            <a href="{{url('vendors/nxp?mcu=lpc700')}}" class="tag">LPC700</a>
                                            <a href="{{url('vendors/nxp?mcu=lpc2100')}}" class="tag">LPC2100</a>
                                            <a href="{{url('vendors/nxp?mcu=lpc1300')}}" class="tag">LPC1300</a>
                                            <a href="{{url('vendors/nxp?mcu=lpc4000')}}" class="tag">LPC4000</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Fujitsu</h4>
                                        <div>
                                            <a href="{{url('vendors/fujitsu?mcu=fr')}}" class="tag">FR</a>
                                            <a href="{{url('vendors/fujitsu?mcu=fm3')}}" class="tag">FM3</a>
                                            <a href="{{url('vendors/fujitsu?mcu=fm4')}}" class="tag">FM4</a>
                                            <a href="{{url('vendors/fujitsu?mcu=fcr4')}}" class="tag">FCR4</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Silicon Labs</h4>
                                        <div>
                                            <a href="{{url('vendors/fujitsu?mcu=c8051')}}" class="tag">C8051</a>
                                            <a href="{{url('vendors/fujitsu?mcu=efm32')}}" class="tag">EFM32</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Infineon</h4>
                                        <div>
                                            <a href="{{url('vendors/infineon?mcu=xc800')}}" class="tag">XC800</a>
                                            <a href="{{url('vendors/infineon?mcu=xe166')}}" class="tag">XE166</a>
                                            <a href="{{url('vendors/infineon?mcu=xc2000')}}" class="tag">XC 2000</a>
                                            <a href="{{url('vendors/infineon?mcu=c166')}}" class="tag">C166</a>
                                            <a href="{{url('vendors/infineon?mcu=xmc4000')}}" class="tag">XMC4000</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            @if(Route::getCurrentRoute() != null) <!-- 404 has not route controller -->
            @if(strpos(Route::getCurrentRoute()->getActionName(),'BlogController'))
                <li class="addBlue">
                    <a href="/blog">Blog</a>
                 </li>
            @else
                <li>
                    <a href="/blog">Blog</a>
                </li>

            @endif
            @endif

            <li>
                <a href="/about">About</a>

            </li>
            <li class="dropdown">
                    @if (Auth::guest())
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                           data-hover="dropdown">Login</a>
                    <ul class="dropdown-menu dropdown-menu-left animated-2x animated fadeIn">
                        <li>
                            <a href="{{ url('/login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ url('/register') }}">Register</a>
                        </li>
                    </ul>
                    @else
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu dropdown-menu-left animated-2x animated fadeIn">
                                @if (Auth::user()->can_post())
                                    <li>
                                        <a href="{{ url('/new-post') }}">Add new post</a>
                                    </li>
                                    @if(Auth::user()->is_admin())
                                        <li>
                                            <a href="{{ url('/new-blog') }}">Add new blog</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ url('/user/'.Auth::id().'/posts') }}">My Posts</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('/user/'.Auth::id()) }}">My Profile</a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}">Logout</a>
                                </li>
                            </ul>
                    @endif
            </li>
        </ul>
    </div>
    <!-- navbar-collapse -->
</div>