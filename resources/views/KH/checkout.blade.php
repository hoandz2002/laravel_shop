@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')

    <!-- search area -->
    <form action="{{ route('client.shop') }}">
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
    <!-- end search area -->

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Check Out Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    {{-- <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div> --}}
    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div>
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    {{-- @if ($errors->any())
									{{dd($errors)}}
								@endif --}}
                                </div>

                                @foreach ($id_cart as $id)
                                    <span hidden>
                                        {{ $products = DB::table('carts')->select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')->join('products', 'carts.productId', '=', 'products.id')->where('userId', '=', Auth::user()->id)->where('carts.id', '=', $id)->get() }}
                                    </span>
                                    @foreach ($products as $item)
                                        <span hidden>
                                            {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }}
                                        </span>
                                        <p hidden>

                                            {{ $total += $item->quantity * $price_sale }}
                                            {{ $mass += $item->quantity * $item->mass }}
                                        </p>
                                    @endforeach
                                @endforeach
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Billing Address
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <form action="{{ route('client.storeOrder') }}" method="POST">
                                                @csrf

                                                <input hidden type="text" name="user_id" value="{{ Auth::id() }}"
                                                    id="">
                                                <input hidden type="text" name="oderStatus" value="0"
                                                    id="">
                                                <p><input type="text" value="" name="orderName" placeholder="Name">
                                                </p>
                                                <p><input type="email" value="" name="oderEmail"
                                                        placeholder="Email"></p>
                                                <p><input type="text" value="" name="address"
                                                        placeholder="Address"></p>
                                                <input type="text" hidden name="ship" value="{{ $ship }}"
                                                    id="">
                                                <p><input type="tel" name="phone" placeholder="Phone"></p>
                                                {{-- @foreach ($products as $item) --}}
                                                <input hidden type="text" name="total"
                                                    value="{{ $total + $ship - $price_coupon }}" id="">
                                                {{-- @endforeach --}}
                                                @foreach ($id_cart as $haha)
                                                    <input type="text" hidden name="id_cart[]" value="{{ $haha }}"
                                                        id="">
                                                @endforeach
                                                <p>
                                                    <textarea name="bill" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea>
                                                </p>
                                                <button class="btn btn-warning">Save</button> <br>
                                                <div>
                                                    @if ($errors->any())
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li style="color: red">{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Shipping Address
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shipping-address-form">
                                            <p style="font-size: 18px;font-weight: bold">Chọn loại vận chuyển</p>
                                            <div>
                                               @foreach ($ships as $value)
                                                   <input type="radio" name="ship_id" value="" id=""><span style="margin-left: 10px">{{$value->name_ship}}</span><br>
                                               @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Card Details
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <p>Your card details goes here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-details-wrap">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th>Chi tiết đon hàng</th>
                                    <th style="width: 100px">Giá tiền</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">

                                {{-- <tr>
                                    <td>Product</td>
                                    <td>Total</td>
                                </tr> --}}
                                <span hidden>
                                    {{ $total = 0 }}
                                </span>
                                @foreach ($id_cart as $id)
                                    <span hidden>
                                        {{ $products = DB::table('carts')->select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')->join('products', 'carts.productId', '=', 'products.id')->where('userId', '=', Auth::user()->id)->where('carts.id', '=', $id)->get() }}
                                    </span>
                                    @foreach ($products as $item)
                                        <span hidden>
                                            {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }}
                                        </span>
                                        <p hidden>

                                            {{ $total += $item->quantity * $price_sale }}
                                            {{ $mass += $item->quantity * $item->mass }}
                                        </p>
                                        <tr>
                                            <td>{{ $item->nameProduct }}</td>
                                            <td>
                                                @if ($item->sale > 0)
                                                    <span style="text-decoration: line-through">
                                                        {{ number_format($item->price) }}
                                                    </span>
                                                @endif
                                                {{ number_format($item->price - $item->price * ($item->sale / 100)) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                {{-- <span>
                                    {{
                                        $total += $total
                                    }}
                                </span> --}}

                            </tbody>
                            <tbody class="checkout-details">
                                {{-- <tr>
									<td>Subtotal</td>
									<td>$190</td>
								</tr> --}}
                                <tr>
                                    <td>Phí ship</td>
                                    <td>{{ number_format($ship) }}</td>
                                </tr>
                                <tr>
                                    <td>Tổng tiền</td>
                                    <td>{{ number_format($total = $total + $ship - $price_coupon) }}</td>
                                    {{-- <td>{{dd($price_coupon)}}</td> --}}
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        {{-- <a href="" class="boxed-btn">Place Order</a> --}}
                        <form action="{{ route('vnpay_payment') }}" method="POST">
                            @csrf
                            <button type="submit" name="redirect">
                                <img src="https://huewaco.net.vn/Images/icon/vnpay_qr.png" width="170px" height="40px"
                                    alt="">
                            </button>
                        </form>
                        <br>
                        <form action="{{ route('check_coupon') }}" method="POST">
                            @csrf
                            @foreach ($id_cart as $db)
                                <input type="text" hidden name="id[]" value="{{ $db }}" id="">
                            @endforeach
                            <input type="text" class="form-control" name="code" placeholder="add coupon"
                                id=""> <br>
                            <input type="submit" name="check_coupon" class="bnt btn-default check_coupon"
                                value="tính mã giảm giá" id="">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end check out section -->
@endsection
