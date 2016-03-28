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
    <!--        <div class="pull-right">-->
    <!--            <a href="javascript:void(0);" class="sb-icon-navbar sb-toggle-right"><i class="fa fa-bars"></i></a>-->
    <!--        </div>-->
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
                   data-hover="dropdown">Topics and Tags</a>
                <ul class="dropdown-menu dropdown-menu-left animated-2x animated fadeIn">
                    <li>
                        <div class="yamm-content">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Topics</h4>
                                        <ul>
                                            <li><a href="/categories/general-purpose">
                                                    General Purpose <span class="badge">1</span></a></li>
                                            <li><a href="/categories/audio">
                                                    Audio <span class="badge">0</span></a></li>
                                            <li><a href="/categories/rtos">
                                                    RTOS <span class="badge">0</span></a></li>
                                            <li><a href="/categories/power-supplies">
                                                    Power Supplies <span class="badge">0</span></a></li>
                                            <li><a href="/categories/communication">
                                                    Communication <span class="badge">0</span></a></li>
                                            <li><a href="/categories/low-energy">
                                                    Low Energy <span class="badge">0</span></a></li>
                                            <li><a href="/categories/iot">
                                                    Internet of Things <span class="badge">0</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4>&nbsp;</h4>
                                        <ul>
                                            <li><a href="/categories/wireless">
                                                    Wireless <span class="badge">0</span></a></li>
                                            <li><a href="/categories/display">
                                                    Display <span class="badge">1</span></a></li>
                                            <li><a href="/categories/analog">
                                                    Analog <span class="badge">0</span></a></li>
                                            <li><a href="/categories/i-o">
                                                    I/O <span class="badge">1</span></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="clearfix  hidden-lg"></div>


                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-tag"></i>
                                            Top Tags</h4>
                                        <div class="tags-cloud">
                                            <a href="/tags/led" class="tag">led</a>
                                            <a href="/tags/io" class="tag">io</a>
                                            <a href="/tags/launchpad" class="tag">launchpad</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <div class="tags-cloud">
                                        </div>
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
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Microchip</h4>
                                        <div>
                                            <a href="#" class="tag">PIC10</a>
                                            <a href="#" class="tag">PIC12</a>
                                            <a href="#" class="tag">PIC16</a>
                                            <a href="#" class="tag">PIC18</a>
                                            <a href="#" class="tag">PIC24</a>
                                            <a href="#" class="tag">dsPIC</a>
                                            <a href="#" class="tag">PIC32</a>

                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Atmel</h4>
                                        <div>
                                            <a href="#" class="tag">Arduino</a>
                                            <a href="#" class="tag">ATtiny</a>
                                            <a href="#" class="tag">ATmega</a>
                                            <a href="#" class="tag">ATxmega</a>
                                            <a href="#" class="tag">AT91SAM</a>
                                            <a href="#" class="tag">AVR32</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Cypress</h4>
                                        <div>
                                            <a href="#" class="tag">PSoC1</a>
                                            <a href="#" class="tag">PSoC3</a>
                                            <a href="#" class="tag">PSoC5</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Texas Inst.</h4>
                                        <div>
                                            <a href="#" class="tag">MSP430</a>
                                            <a href="#" class="tag">MSP432</a>
                                            <a href="#" class="tag">TMS570</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Renasas</h4>
                                        <div>
                                            <a href="#" class="tag">RL78</a>
                                            <a href="#" class="tag">78K</a>
                                            <a href="#" class="tag">R8C</a>
                                            <a href="#" class="tag">RX</a>
                                            <a href="#" class="tag">RZ</a>
                                            <a href="#" class="tag">V850</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> STMicro</h4>
                                        <div>
                                            <a href="#" class="tag">ST7</a>
                                            <a href="#" class="tag">STM8</a>
                                            <a href="#" class="tag">ST10</a>
                                            <a href="#" class="tag">STM32</a>
                                        </div>

                                    </div>
                                </div>

                                <div class="clearfix  hidden-lg"></div>


                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> NXP</h4>
                                        <div>
                                            <a href="#" class="tag">LPC700</a>
                                            <a href="#" class="tag">LPC2100</a>
                                            <a href="#" class="tag">LPC1300</a>
                                            <a href="#" class="tag">LPC4000</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Fujitsu</h4>
                                        <div>
                                            <a href="#" class="tag">FR</a>
                                            <a href="#" class="tag">FM3</a>
                                            <a href="#" class="tag">FM4</a>
                                            <a href="#" class="tag">FCR4</a>
                                        </div>
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Silicon Labs</h4>
                                        <div>
                                            <a href="#" class="tag">C8051</a>
                                            <a href="#" class="tag">EFM32</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">
                                    <div class="megamenu-block">
                                        <h4 class="megamenu-block-title"><i class="fa fa-folder"></i> Infineon</h4>
                                        <div>
                                            <a href="#" class="tag">XC800</a>
                                            <a href="#" class="tag">XE166</a>
                                            <a href="#" class="tag">XC 2000</a>
                                            <a href="#" class="tag">C166</a>
                                            <a href="#" class="tag">XMC4000</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
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