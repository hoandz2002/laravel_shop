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
                        <h1>Cart</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- cart -->
    <div>
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
        @if (session()->has('empty_checkbok'))
            <div class="alert alert-warning">
                {{ session()->get('empty_checkbok') }}
            </div>
        @endif
    </div>
    <div class="cart-section mt-150 mb-150">

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <form action="{{ route('client.checkout') }}" method="GET">
                            <table class="cart-table">
                                <thead class="cart-table-head">
                                    <tr class="table-head-row">
                                        <th>All<input type="checkbox" value="" name="" id=""></th>
                                        {{-- <th>id</th> --}}
                                        <th class="product-image">Product Image</th>
                                        <th class="product-name">Name</th>
                                        <th class="product-price">Đặc điểm</th>
                                        <th class="product-price">Price</th>
                                        <th colspan="3" class="product-quantity">Quantity</th>
                                        <th class="product-total">Total</th>
                                        <th class="product-remove">Action</th>

                                        {{-- <th class="product-action">Action</th> --}}

                                    </tr>
                                </thead>
                                @if (count($products) > 0)
                                    <tbody>

                                        @foreach ($products as $item)
                                            <span hidden>
                                                {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }}
                                            </span>
                                            <p hidden>
                                                {{ $total += $item->quantity * $price_sale }}
                                                {{ $mass += $item->quantity * $item->mass }}
                                            </p>

                                            <tr class="table-body-row">
                                                <td>
                                                    <input type="checkbox" name="id[]" value="{{ $item->id }}"
                                                        id="">
                                                </td>
                                                {{-- <td class="product-remove"><a href="{{route('client.deleteCart',$item->id)}}"><i class="far fa-window-close"></i></a></td> --}}
                                                <td class="product-image"><img src="{{ asset($item->avatar) }}"
                                                        alt="">
                                                </td>
                                                <td class="product-name"><a
                                                        href="{{ route('client.single', $item->productId) }}">{{ $item->nameProduct }}</a>
                                                </td>
                                                <td>{{ $item->nameSize }}, {{ $item->name_Color }},
                                                    {{ $item->name_Material }}</td>
                                                {{-- <input type="text" name="nameProduct" value="{{$item->nameProduct}}"  id=""> --}}
                                                <td class="product-price" style="width: 100px">
                                                    @if ($item->sale > 0)
                                                        <span
                                                            style="text-decoration: line-through">{{ number_format($item->price) }}
                                                            {{-- <input type="text" name="price" id="" value="{{$item->price}}"> --}}
                                                        </span>
                                                    @endif <br>
                                                    {{ number_format($item->price - $item->price * ($item->sale / 100)) }}
                                                </td>
                                                <td hidden>
                                                    <form action="">
                                                        <button>test</button>
                                                    </form>
                                                </td>
                                                <td class="product-quantity">
                                                    <form action="{{ route('client.updateCartsl', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                <td>
                                                    <input style="height: 35px" type="number" name="quantity"
                                                        value="{{ $item->quantity }}" placeholder="0" min="1">
                                                </td>

                                                <td>
                                                    <button style="margin-bottom: 15px" type="submit"
                                                        class="btn btn-success"><i class="fas fa-check-circle"></i></button>
                                                </td>
                        </form>
                        </td>
                        <td class="product-total">
                            {{ number_format($item->quantity * $price_sale) }}<sup>đ</sup></td>
                        {{-- <td class="product-total">{{ $item->mass}}</td> --}}
                        <td class="product-remove">
                            <form action="{{ route('client.deleteCart', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                {{-- <td class="product-remove"><a href="{{route('client.deleteCart',$item->id)}}"><i class="far fa-window-close"></i></a></td> --}}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    @else
                        <span>
                            <span style="color: gray;height: 300px;width: 400px;position: absolute;top: -50px">Giỏ
                                hàng
                                bạn đang trống!</span>
                        </span>

                        </tbody>
                        @endif
                        </table>
                        <br>
                        <div>
                            <button style="background: transparent;border: 0;">
                                <a class="boxed-btn black">
                                    Checkout
                                </a>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Total</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Subtotal: </strong></td>
                                    <td>{{ number_format($total) }}</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Shipping: </strong></td>
                                    <td>
                                        @if ($mass <= 10)
                                            {{ $ship = 50000 }}
                                        @elseif ($mass <= 30)
                                            {{ $ship = 150000 }}
                                        @elseif ($mass <= 60)
                                            {{ $ship = 300000 }}
                                        @else
                                            {{ $ship = 500000 }}
                                        @endif

                                    </td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Total: </strong></td>
                                    <td>{{ number_format($total = $total + $ship) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-buttons">
                            <a href="{{ route('client.shop') }}" class="boxed-btn">Shop</a>
                            {{-- <a href="{{ route('client.checkout') }}" class="boxed-btn black">Check Out</a> --}}
                        </div>
                    </div>
                    <div class="coupon-section">
                        <h3>Order detail</h3>
                        <div class="coupon-form-wrap">
                            <form action="{{ route('client.showOrder') }}">
                                {{-- <p><input type="text" placeholder="Coupon"></p> --}}
                                {{-- <p><input type="button" value="Views"></p> --}}
                                <button class="btn btn-danger">View</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->
@endsection
