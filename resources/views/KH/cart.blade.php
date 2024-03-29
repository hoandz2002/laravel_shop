@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')
    {{-- <style>
        /* The alert message box */
        .alert {
            width: 200px;
            float: right
            padding: 1000px;
            background-color: rgb(188, 239, 188);
            /* Red */
            color: black;
            /* margin-bottom: 15px; */
          
        }

        /* The close button */
        .closebtn {
            margin-left: 15px;
            color: black;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }
        /* When moving the mouse over the close button */
        .closebtn:hover {
            color: black;
        }
    </style> --}}
   
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
    {{-- test thong bao alert --}}
    <span id="hien_thi_thong_diep">
      
    </span>
    {{-- end test thong baos alert --}}
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
                                                @if ($item->type_sale == 1)
                                                    {{ $price_sale = $item->price - $item->price * ($item->sale / 100) - $item->sale_value }}
                                                    <p hidden>
                                                        {{ $total += $item->quantity * $price_sale }}
                                                        {{ $mass += $item->quantity * $item->mass }}
                                                    </p>
                                                @elseif ($item->type_sale == 2)
                                                    {{ $price_sale = $item->price - $item->price * ($item->sale / 100) - $item->price * ($item->sale_value / 100) }}
                                                    <p hidden>
                                                        {{ $total += $item->quantity * $price_sale }}
                                                        {{ $mass += $item->quantity * $item->mass }}
                                                    </p>
                                                @endif
                                            </span>
                                            {{-- <p hidden>
                                                {{ $total += $item->quantity * $price_sale }}
                                                {{ $mass += $item->quantity * $item->mass }}
                                            </p> --}}
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
                                                    @if ($item->sale > 0 || $item->sale_value)
                                                        <span
                                                            style="text-decoration: line-through">{{ number_format($item->price) }}
                                                            {{-- <input type="text" name="price" id="" value="{{$item->price}}"> --}}
                                                        </span>
                                                    @endif <br>
                                                    @if ($item->type_sale == 2)
                                                        {{ number_format($item->price - $item->price * ($item->sale / 100) - $item->price * ($item->sale_value / 100)) }}
                                                    @elseif ($item->type_sale == 1)
                                                        {{ number_format($item->price - $item->price * ($item->sale / 100) - $item->sale_value) }}
                                                    @else
                                                        {{ number_format($item->price - $item->price * ($item->sale / 100)) }}
                                                    @endif
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
                                                        id="so_luong" value="{{ $item->quantity }}" placeholder="0"
                                                        data-url="{{ route('client.updateCartsl', $item->id) }}"
                                                        min="1">
                                                </td>
                                                {{-- <td>
                                                    <button style="margin-bottom: 15px" type="submit"
                                                        class="btn btn-success"><i class="fas fa-check-circle"></i></button>
                                                </td> --}}

                        </form>
                        <td>
                            <button id="ok" type="button" style="margin-bottom: 15px" class="btn btn-success"><i
                                    class="fas fa-check-circle"></i></button>
                        </td>
                        </td>
                        <td class="product-total">
                            @if ($item->type_sale == 1)
                                <span
                                    hidden>{{ $price_sale = $item->price - $item->price * ($item->sale / 100) - $item->sale_value }}</span>
                                {{ number_format($item->quantity * $price_sale) }}<sup>đ</sup>
                        </td>
                        </td>
                    @elseif ($item->type_sale == 2)
                        <span hidden>
                            {{ $price_sale = $item->price - $item->price * ($item->sale / 100) - $item->price * ($item->sale_value / 100) }}
                        </span>
                        {{ number_format($item->quantity * $price_sale) }}<sup>đ</sup></td>
                    @else
                        {{ number_format($item->quantity * ($price_sale = $item->price - $item->price * ($item->sale / 100))) }}<sup>đ</sup>
                        @endif
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $('#ok').ready(function() {
            $(document).on('change', '#so_luong', function(event) {
                console.log(1)
                const url = $(this).data('url')
                const data = $(this).val();
                console.log(url, data);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: url,
                    data: {
                        so_luong_update: data,
                    },
                    success: function(res) {
                        console.log(res.thong_diep);
                        alert(res.thong_diep);
                    }
                })
            })
        })
    </script>
@endsection
