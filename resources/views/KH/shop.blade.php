@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')

    <!-- search area -->
    <form action="">
        <div class="search-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="close-btn"><i class="fas fa-window-close"></i></span>
                        <div class="search-bar">
                            <div class="search-bar-tablecell">
                                <h3>Search For:</h3>
                                <input type="text" name="search" placeholder="Keywords">
                                <button type="submit">Search <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end search arewa -->

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Shop</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    <span>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error_emty_user'))
            <div class="alert alert-warning">
                {{ session()->get('error_emty_user') }}
            </div>
        @endif
    </span>
    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach ($cate as $data)
                                <li data-filter=".prd{{ $data->id }}">
                                    {{ $data->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row product-lists">
                @foreach ($products as $item)
                    <div class="col-lg-4 col-md-6 text-center prd{{ $item->category_id }}">
                        <div class="single-product-item">
                            <div class="product-image" style="position: relative">
                                @if ($item->sale > 0)
                                    <span class="giamgia"
                                        style="position: absolute;top: 40px; background: white;width: 60px;border-top-right-radius: 10px;border-bottom-right-radius: 10px">
                                        <span style="color: red;font-weight: bold">
                                            {{ $item->sale }}%
                                        </span>
                                    </span>
                                @endif
                                <a href="{{ route('client.single', $item->id) }}"><img src="{{ asset($item->avatar) }}"
                                        alt=""></a>
                            </div>
                            <h3>{{ $item->nameProduct }}</h3>
                            <span style="color: gray">each product</span>

                            <p class="product-price">
                            <p style="color: red" class="product-price">
                                {{ number_format($item->price_in_active) }} <sup>đ</sup> </p>

                            </p>
                            <span hidden>
                                {{ $sale = ($item->price * $item->sale) / 100 }}
                            </span>
                            {{-- <p style="color: red;" class="product-price">
                                {{ number_format($item->price - $sale) }}<sup>đ</sup>
                            </p> --}}
                            <form action="{{ route('client.addtocart') }}" method="POST">
                                @csrf
                                <input hidden type="text" name="nameProduct" value="{{ $item->nameProduct }}"
                                    id="">
                                <input hidden type="text" name="price" value="{{ $item->price_in_active }}" id="">
                                <input hidden type="text" value="{{ $item->id }}" name="productId" id="">
                                <input hidden type="text" value="{{ Auth::user() ? Auth::user()->id : '' }}"
                                    name="userId" id="">
                                <input type="text" name="sale" value="{{ $item->sale }}" hidden id="">
                                <input type="number" hidden name="quantity" min="1" value="1" placeholder="0">
                                <br>

                                {{-- <a href="{{ route('client.addtocart')}}" class="cart-btn"><i
                                class="fas fa-shopping-cart"></i> Add to Cart</a> --}}

                                <button style="background: transparent;border: 0">
                                    <a class="cart-btn">
                                        <i class="fas fa-shopping-cart"></i>Add to Cart
                                    </a>
                                </button>
                            </form>
                            {{-- <a href="{{ route('client.single',$item->id)}}" class="cart-btn"><i
                                class="fas fa-shopping-cart"></i> Chi tiết sản phẩm</a> --}}
                        </div>

                    </div>
                @endforeach
            </div>



            {{-- <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="pagination-wrap">
                        <ul>
                            <li><a href="#">Prev</a></li>
                            <li><a href="#">1</a></li>
                            <li><a class="active" href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div> --}}
            <div style="margin: 0 auto;">{{ $products->links() }}</div>

        </div>
    </div>
    <!-- end products -->
    {{-- <!-- jquery -->
 <script src="{{asset(' assets/js/jquery-1.11.3.min.js')}}"></script>
 <!-- bootstrap -->
 <script src="{{asset(' assets/bootstrap/js/bootstrap.min.js')}}"></script>
 <!-- count down -->
 <script src="{{asset(' assets/js/jquery.countdown.js')}}"></script>
 <!-- isotope -->
 <script src="{{asset(' assets/js/jquery.isotope-3.0.6.min.js')}}"></script>
 <!-- waypoints -->
 <script src="{{asset(' assets/js/waypoints.js')}}"></script>
 <!-- owl carousel -->
 <script src="{{asset(' assets/js/owl.carousel.min.js')}}"></script>
 <!-- magnific popup -->
 <script src="{{asset(' assets/js/jquery.magnific-popup.min.js')}}"></script>
 <!-- mean menu -->
 <script src="{{asset(' assets/js/jquery.meanmenu.min.js')}}"></script>
 <!-- sticker js -->
 <script src="{{asset(' assets/js/sticker.js')}}"></script>
 <!-- main js -->
 <script src="{{asset(' assets/js/main.js')}}"></script> --}}

@endsection

<!-- footer -->
