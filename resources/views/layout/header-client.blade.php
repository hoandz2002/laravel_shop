<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <div class="site-logo">
                        <a href="{{ route('client.index') }}">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="">
                        </a>
                    </div>
                    <!-- logo -->
                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class="current-list-item"><a href="{{ route('client.index') }}">Home</a>
                            </li>
                            <li><a style="font-size: 15px" href="{{ route('client.about') }}">About</a></li>
                            {{-- <li><a href="#">Pages</a> --}}
                            </li>
                            <li><a style="font-size: 15px" href="{{ route('client.new') }}">News</a>
                            </li>
                            <li><a style="font-size: 15px" href="{{ route('client.contact') }}">Contact</a></li>
                            <li><a style="font-size: 15px" href="{{ route('client.shop') }}">Shop</a>
                            </li>
                            <li>
                                <div class="header-icons">
                                    @if (Auth::user())
                                        <?php
                                        $carts = DB::table('carts')
                                            ->where('carts.userId', '=', Auth::user()->id)
                                            ->get();
                                        ?>
                                        @if (count($carts) > 0)
                                            <span class="position-absolute text-center font-weight-bold"
                                                style=" position: relative;background: white; border: 1px solid grey; top: 7px; right: 166px; width: 24px; height: 20px; border-radius: 50%;">
                                                <span style="color: red;position: absolute;top: -2px;right: 7px;">
                                                    <?php
                                                    echo count($carts);
                                                    ?>
                                                </span>
                                        @endif
                                        </span>
                                    @endif
                                    @if (Auth::user())
                                        <a class="shopping-cart" href="{{ route('client.cart') }}"><i
                                                class="fas fa-shopping-cart"></i></a>
                                    @endif
                                    <a class="mobile-hide search-bar-icon" href="#"><i
                                            class="fas fa-search"></i></a>
                                    <span>
                                        <a class="mobile-hide search-bar-icon" href="{{ route('logout') }}"><i
                                                class="fas fa-user"></i>
                                            {{ Auth::user() ? Auth::user()->name : '' }}</a>
                                        @if (Auth::user())
                                            <ul class="sub-menu">
                                                <li>
                                                    @if (Auth::user())
                                                        <a href="{{ route('client.profile', Auth::user()->id) }}">Thông
                                                            tin cá nhân</a>
                                                    @endif
                                                    {{-- <a href="{{route('client.profile',Auth::user()->id)}}">Thông tin cá nhân</a> --}}
                                                </li>
                                                {{-- <li><a href="checkout.html">Check Out</a></li> --}}
                                                <li><a href="{{ route('client.purses.list') }}">Ví tiền</a></li>
                                                <li><a href="{{ route('client.informations.list') }}">Địa chỉ</a></li>
                                                <li><a href="{{ route('client.showOrder') }}">Hóa Đơn</a></li>
                                                <li><a href="{{ route('client.orderReturn') }}">Đơn hoàn trả</a></li>
                                                <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                                            </ul>
                                        @endif
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                    <div class="mobile-menu">
                    </div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
