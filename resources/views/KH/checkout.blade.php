@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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
    </div>
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
                                        {{ $products = DB::table('carts')->select(
                                                'carts.*',
                                                'products.nameProduct',
                                                'products.avatar',
                                                'products.mass',
                                                'products.sale',
                                                'price_products.sale_value',
                                                'price_products.type_sale',
                                            )->join('products', 'carts.productId', '=', 'products.id')->join('price_products', 'carts.price_product_id', '=', 'price_productS.id')->where('userId', '=', Auth::user()->id)->where('carts.id', '=', $id)->get() }}
                                    </span>
                                    @foreach ($products as $item)
                                        <span hidden>
                                            {{-- {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }} --}}
                                            @if ($item->type_sale == 1)
                                                {{ $price_sale = $item->price - $item->price * ($item->sale / 100) - $item->sale_value }}
                                                <p hidden>
                                                    {{ $type_sale = 1 }}
                                                    {{ $sale_value = $item->sale_value }}
                                                    {{ $total += $item->quantity * $price_sale }}
                                                    {{ $mass += $item->quantity * $item->mass }}
                                                </p>
                                            @elseif ($item->type_sale == 2)
                                                {{ $price_sale = $item->price - $item->price * ($item->sale / 100) - $item->price * ($item->sale_value / 100) }}
                                                <p hidden>
                                                    {{ $type_sale = 1 }}
                                                    {{ $sale_value = $item->sale_value }}
                                                    {{ $total += $item->quantity * $price_sale }}
                                                    {{ $mass += $item->quantity * $item->mass }}
                                                </p>
                                            @else
                                                {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }}
                                                {{ $total += $item->quantity * $price_sale }}
                                                {{ $mass += $item->quantity * $item->mass }}
                                            @endif
                                        </span>
                                        {{-- <p hidden>

                                            {{ $total += $item->quantity * $price_sale }}
                                            {{ $mass += $item->quantity * $item->mass }}
                                        </p> --}}
                                    @endforeach
                                @endforeach
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Địa chỉ nhận hàng
                                        </button>
                                    </h5>
                                </div>
                                <!-- Modal -->
                                <div style="margin-top: 100px" class="modal fade" id="exampleModal" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="width: 100%">
                                                @foreach ($kk as $value)
                                                    {{-- href="{{ route('client.informations.updateStatus', $value->id) }}" --}}
                                                    <a data-dismiss="modal" class="changeAddress"
                                                        data-id="{{ $value->id }}" style="text-decoration: none;">
                                                        <div style="border: 1px solid gray;width: 100%;height: 161px;">
                                                            <span style="margin-left: 20px"><b>Name:</b>
                                                                {{ $value->name_to }} @if ($value->status === 0)
                                                                    <span
                                                                        style="width: 80px;height: 25px;border: solid 1px red; color: red;float: right;text-align: center;font-weight: bold">Mặc
                                                                        định</span>
                                                                @endif
                                                            </span> <br>
                                                            <span style="margin-left: 20px"><b>Email:</b>
                                                                {{ $value->email_to }}</span> <br>
                                                            <span style="margin-left: 20px"><b>address:</b>
                                                                {{ $value->address_to }}</span> <br>
                                                            <span style="margin-left: 20px"><b>Phone:</b>
                                                                {{ $value->phone }}</span> <br> <br>

                                                        </div> <br>
                                                        <a style="float: right;position: relative;top: -59px">
                                                            <button type="button" class="btn btn-outline-info"
                                                                data-toggle="modal"
                                                                data-target="#exampleModal1{{ $value->id }}">
                                                                Sửa
                                                            </button> </a>
                                                    </a>
                                                    {{-- start modals edit address --}}
                                                    <!-- Button trigger modal -->
                                                    <!-- Modal -->
                                                    <div style="width: 500px;margin-left: 702px;margin-top: 100px"
                                                        class="modal fade" id="exampleModal1{{ $value->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật
                                                                        địa chỉ</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('client.informations.update', $value->id) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        {{ method_field('PUT') }}
                                                                        @csrf
                                                                        <input hidden type="text"
                                                                            value="{{ $value->id }}" name="id"
                                                                            id="">
                                                                        <div class="form-group">
                                                                            <label for="">Tên người nhận</label>
                                                                            <input type="text" name="name_to"
                                                                                id=""
                                                                                value="{{ $value->name_to }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Email</label>
                                                                            <input type="text" name="email_to"
                                                                                id=""
                                                                                value="{{ $value->email_to }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Địa chỉ nhận</label>
                                                                            <input type="text" name="address_to"
                                                                                id=""
                                                                                value="{{ $value->address_to }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Số điện thoại</label>
                                                                            <input type="text" name="phone"
                                                                                id=""
                                                                                value="{{ $value->phone }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div hidden class="form-group">
                                                                            <input type="text" name="status"
                                                                                id=""
                                                                                value="{{ $value->status }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <button class="btn btn-success">
                                                                            Cập nhật
                                                                        </button>
                                                                        <button class="btn btn-danger">nhập lại</button>
                                                                        <br>
                                                                        <br><br> <br> <br><br><br><br><br><br><br>.

                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- end modals edit address --}}
                                                @endforeach
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
                                                    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
                                                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                                                <script>
                                                    $(".changeAddress").click(function() {
                                                        $.ajax({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                            type: "POST",
                                                            url: "/informations/changeAddress/" + $(this).data("id"),
                                                            // data: "data",
                                                            dataType: "JSON",
                                                            success: function(response) {
                                                                $("input[name=oderStatus]").val(response.status)
                                                                $("input[name=orderName]").val(response.name_to)
                                                                $("input[name=oderEmail]").val(response.email_to)
                                                                $("input[name=address]").val(response.address_to)
                                                                $("input[name=phone]").val(response.phone)
                                                                $("#ten").text(response.name_to)
                                                                $("#email").text(response.email_to)
                                                                $("#dia_chi").text(response.address_to)
                                                                $("#sdt").text(response.phone)
                                                            }
                                                        });
                                                    })
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- end model --}}

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <i class="fas fa-search-location" style="color: orangered"> <span>Địa chỉ nhận
                                                hàng</span></i>
                                        @foreach ($address as $value)
                                            <div style="margin-left: 10px">
                                                <span><b>Name:</b> <span class=""
                                                        id="ten">{{ $value->name_to }}@if ($value->status === 0)
                                                            <span
                                                                style="float: right;text-align: center;color: red;border: red 1px solid;width: 80px;">Mặc
                                                                Định</span>
                                                        @endif
                                                    </span> </span> <br>
                                                <span><b>Email:</b> <span class="" id="email">
                                                        {{ $value->email_to }}</span></span> <br>
                                                <span><b>address:</b> <span class=""
                                                        id="dia_chi">{{ $value->address_to }}</span> </span> <br>
                                                <span><b>Phone:</b> <span class="" id="sdt">
                                                        {{ $value->phone }}</span></span> <br> <br>
                                                <!-- Button trigger modal -->
                                                <button style="color: black" type="button"
                                                    class="btn btn-outline-warning" data-toggle="modal"
                                                    data-target="#exampleModal">
                                                    Thay đổi
                                                </button>

                                            </div>
                                        @endforeach
                                        <div class="billing-address-form">
                                            <form action="{{ route('client.storeOrder') }}" method="POST">
                                                @csrf
                                                @foreach ($address as $item)
                                                    <input type="text" value="{{ $ship }}" hidden
                                                        name="ship_mac_dinh" id="">
                                                    <input hidden type="text" name="user_id"
                                                        value="{{ Auth::id() }}" id="">
                                                    <input hidden type="text" name="oderStatus" value="0"
                                                        id="">
                                                    <p><input hidden type="text" value="{{ $item->name_to }}"
                                                            name="orderName" placeholder="Name">
                                                    </p>
                                                    <p><input hidden type="email" value="{{ $item->email_to }}"
                                                            name="oderEmail" placeholder="Email"></p>
                                                    <p><input hidden type="text" value="{{ $item->address_to }}"
                                                            name="address" placeholder="Address"></p>
                                                    <input hidden type="text" name="ship_db" value=""
                                                        id="ship_db">
                                                    <input hidden type="text" name="coupon" id="gia_code_voucher"
                                                        value="0">
                                                    <p><input hidden type="tel" name="phone"
                                                            value="{{ $item->phone }}" placeholder="Phone"></p>
                                                    {{-- @foreach ($products as $item) --}}
                                                    <input hidden type="text" name="total"
                                                        value="{{ $total - $price_coupon }}" id="total">
                                                @endforeach
                                                {{-- @endforeach --}}
                                                @foreach ($id_cart as $haha)
                                                    <input type="text" hidden name="id_cart[]"
                                                        value="{{ $haha }}" id="">
                                                @endforeach
                                                <p>
                                                    <textarea name="bill" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea>
                                                </p>
                                                {{-- <button class="btn btn-warning">Save</button> <br> --}}
                                                <div>
                                                    @if ($errors->any())
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li style="color: red">{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            phương thức vận chuyển
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
                                                    <input type="radio" onclick="ok{{ $value->id }}()"
                                                        id="alo{{ $value->id }}"
                                                        value="{{ $ship + ($value->price_ship / 100) * $ship }}"
                                                        id=""><span
                                                        style="margin-left: 10px">{{ $value->name_ship }}
                                                        ({{ number_format($ship + ($value->price_ship / 100) * $ship) }}<sup>đ</sup>)
                                                    </span><br>
                                                @endforeach
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal5">
                                            Chọn voucher
                                        </button>
                                    </h5>
                                    <!-- Modal(dong 606) -->

                                </div>
                                <div id="" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shipping-address-form">
                                            <div>

                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- lu luon --}}
                            {{-- </form> --}}
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Phương thức thanh toán
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            {{-- <p>Your card details goes here.</p> --}}
                                            <!-- Button trigger modal -->
                                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal2">
                                                Thanh toán chuyển khoản
                                            </button> --}}
                                            {{-- <input type="radio" name="vi_tien" value="0" id=""> --}}
                                            <input type="radio" name="vitien" value="0" class="btn-check" id="btn-check-2"
                                                checked autocomplete="off">
                                            <label class="btn btn-outline-secondary" for="btn-check-2">Thanh toán qua ví
                                                tiền</label>
                                                {{-- phương thức thanh toaNS 2 --}}
                                            <input type="radio" name="vitien" value="1" class="btn-check" id="btn-check-3"
                                                checked autocomplete="off">
                                            <label class="btn btn-outline-secondary" for="btn-check-3">thanh toán sau khi
                                                nhận hàng</label>
                                        </div> <br>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <input hidden type="text" name="id_voucher" id="id_giam_gia" value="">
                            <button id="btn_order" class="bnt btn-default"
                                style="background: #F28123;color: white;width: 110px;height: 40px;border: 0px;border-radius: 10px">Đặt
                                hàng
                            </button>
                        </div>
                    </div>
                </div>
                </form>
                {{-- end form gui request sang ben order --}}
                <div class="col-lg-4">
                    <div class="order-details-wrap">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th>Chi tiết đơn hàng</th>
                                    <th style="width: 100px">Giá tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">

                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Giá tiền</td>
                                    <td>Tổng tiền</td>
                                </tr>
                                <span hidden>
                                    {{ $total = 0 }}
                                </span>
                                @foreach ($id_cart as $id)
                                    <span hidden>
                                        {{ $products = DB::table('carts')->select(
                                                'carts.*',
                                                'products.nameProduct',
                                                'products.avatar',
                                                'products.mass',
                                                'products.sale',
                                                'price_products.sale_value',
                                                'price_products.type_sale',
                                            )->join('products', 'carts.productId', '=', 'products.id')->join('price_products', 'carts.price_product_id', '=', 'price_productS.id')->where('userId', '=', Auth::user()->id)->where('carts.id', '=', $id)->get() }}
                                    </span>
                                    @foreach ($products as $item)
                                        <span hidden>
                                            {{-- {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }} --}}
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
                                            @else
                                                {{ $price_sale = $item->price - $item->price * ($item->sale / 100) }}
                                                {{ $total += $item->quantity * $price_sale }}
                                                {{ $mass += $item->quantity * $item->mass }}
                                            @endif
                                        </span>
                                        {{-- <p hidden>

                                            {{ $total += $item->quantity * $price_sale }}
                                            {{ $mass += $item->quantity * $item->mass }}
                                        </p> --}}
                                        <tr>
                                            <td>{{ $item->nameProduct }}</td>
                                            <td>
                                                @if ($item->sale > 0 || $item->sale_value)
                                                    <span style="text-decoration: line-through">
                                                        {{ number_format($item->price) }}
                                                    </span>
                                                @endif
                                                {{-- {{ number_format($item->price - $item->price * ($item->sale / 100)) }} --}}
                                                @if ($item->type_sale == 2)
                                                    {{ number_format($item->price - $item->price * ($item->sale / 100) - $item->price * ($item->sale_value / 100)) }}<sup>đ</sup>
                                                    @if ($item->quantity > 0)
                                                        <b>x{{ $item->quantity }}</b>
                                                    @endif
                                                @elseif ($item->type_sale == 1)
                                                    {{ number_format($item->price - $item->price * ($item->sale / 100) - $item->sale_value) }}<sup>đ</sup>
                                                    @if ($item->quantity > 0)
                                                        <b>x{{ $item->quantity }}</b>
                                                    @endif
                                                @else
                                                    {{ number_format($item->price - $item->price * ($item->sale / 100)) }}<sup>đ</sup>
                                                    @if ($item->quantity > 0)
                                                        <b>x{{ $item->quantity }}</b>
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- tong tien tưng sp * sl --}}
                                            <td>
                                                {{-- {{ number_format($item->price - $item->price * ($item->sale / 100)) }} --}}
                                                @if ($item->type_sale == 2)
                                                    {{ number_format(($item->price - $item->price * ($item->sale / 100) - $item->price * ($item->sale_value / 100)) * $item->quantity) }}<sup>đ</sup>
                                                @elseif ($item->type_sale == 1)
                                                    {{ number_format(($item->price - $item->price * ($item->sale / 100) - $item->sale_value) * $item->quantity) }}<sup>đ</sup>
                                                @else
                                                    {{ number_format(($item->price - $item->price * ($item->sale / 100)) * $item->quantity) }}<sup>đ</sup>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tbody class="checkout-details">
                                {{-- <tr>
									<td>Subtotal</td>
									<td>$190</td>
								</tr> --}}
                                <tr>
                                    <td>Phí ship</td>
                                    <td colspan="2">
                                        <div style="text-align: right" id="haha">{{ number_format($ship) }}
                                            <sup>đ</sup>
                                        </div>
                                        @foreach ($ships as $value)
                                            <div style="display: none;" id="hienthi{{ $value->id }}">
                                                {{ number_format($ship + ($value->price_ship / 100) * $ship) }}<sup>đ</sup>
                                            </div>
                                            <input hidden type="text" name=""
                                                id="tien_ship{{ $value->id }}"
                                                value="{{ $ship + ($value->price_ship / 100) * $ship }}">
                                        @endforeach
                                        <input hidden type="text" id="value_ship" value="" name=""
                                            id="">
                                    </td>
                                </tr>
                                <tr id="hien_thi_gia_voucher">

                                </tr>
                                <tr>
                                    <td>Tổng tiền</td>
                                    <td colspan="2">
                                        <div style="text-align: right" id="kkk">
                                            {{ number_format($total + $ship - $price_coupon) }}
                                        </div>
                                        <input hidden type="text" name="" id="money"
                                            value="{{ $total + $ship }}">
                                        <div>
                                            @foreach ($ships as $value)
                                                <div style="display: none" id="tongtien{{ $value->id }}">
                                                    {{ number_format($total + ($ship + ($value->price_ship / 100) * $ship) - $price_coupon) }}<sup>đ</sup>
                                                </div>
                                            @endforeach
                                            {{-- modals --}}
                                            <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Voucher giảm
                                                                giá </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('check_coupon') }}" method="POST">
                                                                @csrf
                                                                @foreach ($id_cart as $db)
                                                                    <input type="text" hidden name="id[]"
                                                                        value="{{ $db }}" id="">
                                                                @endforeach
                                                                <div
                                                                    style="display: flex;background: #f8f8f8;height: 50px">
                                                                    <input type="text" class="form-control"
                                                                        name="code" placeholder="add coupon"
                                                                        id="">
                                                                    {{-- <input width="100px" height="30px" type="submit" name="check_coupon" class=""
                                                    value="Áp dụng" id=""> --}}
                                                                    {{-- <div style="">
                                                        <input class="" class="form-control"  type="submit" name="check_coupon" value="Áp dụng" id="">
                                                    </div> --}}@aware(['propName'])
                                                                    <div style="width: 20%"><button
                                                                            class="btn btn-outline-danger"
                                                                            name="check_coupon" type="submit">Áp
                                                                            dụng</button></div>
                                                                </div>
                                                            </form>
                                                            <br>
                                                            <form action="{{ route('check_coupon') }}" method="POST">
                                                                @csrf
                                                                @foreach ($id_cart as $db)
                                                                    <input type="text" hidden name="id[]"
                                                                        value="{{ $db }}" id="">
                                                                @endforeach
                                                                @foreach ($coupon as $value)
                                                                    <div
                                                                        style="width: 100%;min-height: 50px;display: flex">
                                                                        <div>
                                                                            <img src="https://cf.shopee.vn/file/05a0d5c56d00e1c21b53f0a08356efc1"
                                                                                width="70px" height="70px" w
                                                                                alt="">
                                                                        </div>
                                                                        <div style="margin-left: 15px">
                                                                            Giảm {{ number_format($value->sale) }} <br>
                                                                            Đơn tối thiểu
                                                                            {{ number_format($value->Minimum_bill) }}
                                                                        </div>
                                                                        <div>
                                                                            <input
                                                                                {{ $total < $value->Minimum_bill ? 'disabled' : '' }}
                                                                                {{ $value->quantity < 1 ? 'disabled' : '' }}
                                                                                style="margin-left: 200px;margin-top: 30px"
                                                                                type="radio" name="voucher"
                                                                                value="{{ $value->id }}"
                                                                                data-url="{{ route('client.ajax_ship') }}"
                                                                                id="radio_voucher">
                                                                        </div>
                                                                    </div> <br>
                                                                @endforeach
                                                                <div class="modal-footer">
                                                                    <button data-dismiss="modal"
                                                                        class="btn btn-success">Hoàn thành</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        {{-- <div class="modal-footer">
                                                            <button type="button" data-dismiss="modal"
                                                                class="btn btn-primary">Đóng</button>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>{{dd($price_coupon)}}</td> --}}
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        {{-- <a href="" class="boxed-btn">Place Order</a> --}}
                        {{-- <form action="{{ route('vnpay_payment') }}" method="POST">
                            @csrf
                            <button type="submit" name="redirect">
                                <img src="https://huewaco.net.vn/Images/icon/vnpay_qr.png" width="170px" height="40px"
                                    alt="">
                            </button>
                        </form> --}}
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end check out section -->
    <script>
        $(document).ready(function() {
            $(document).on('change', '#radio_voucher', function(event) {
                console.log('anh hoan dep zai');
                const url = $(this).data('url')
                const data = $(this).val()
                const value_ship = $('#value_ship').val()
                const tongtien = $('#money').val()
                // const gia_code_voucher = $('#gia_code_voucher').val()
                console.log(url, data, tongtien, value_ship);
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        id_voucher: data
                    },
                    success: function(response) {
                        //    kk =  new Intl.NumberFormat('vn-VN', { maximumSignificantDigits: 3 }).format(response.giam_gia)
                        console.log(response);
                        let value_voucher = response.giam_gia.toLocaleString();
                        gia_voucher = `-${value_voucher} <sup>đ</sup>`
                        thanh_tien = tongtien - response.giam_gia - (-value_ship) - 500000
                        let text = thanh_tien.toLocaleString();
                        console.log(thanh_tien, 'hhaha');
                        hienthi_thanhtien = `${text} <sup>đ</sup>`
                        hienthi_voucher = `<td>Giảm giá</td>
                                    <td colspan="2">
                                        <div style="text-align: right" >${gia_voucher}
                                        </div>
                                    </td>`
                        $('#hien_thi_gia_voucher').html(hienthi_voucher)
                        $('#kkk').html(hienthi_thanhtien)
                        $('#gia_code_voucher').val(response.giam_gia)
                        const total = tongtien - response.giam_gia - 500000
                        console.log(total);
                        $('#total').val(total)
                        $('#id_giam_gia').val(data)

                    }
                });
            });
        });
    </script>
    <script>
        let btn_orderElementDiv = document.getElementById("btn_order")
        // 
        let hienthi1ElementDiv = document.getElementById("hienthi1")
        let hienthi2ElementDiv = document.getElementById("hienthi2")
        let hienthi3ElementDiv = document.getElementById("hienthi3")
        let hahaElementDiv = document.getElementById("haha")
        // 
        let tongtien1ElementDiv = document.getElementById("tongtien1")
        let tongtien2ElementDiv = document.getElementById("tongtien2")
        let tongtien3ElementDiv = document.getElementById("tongtien3")
        let kkkElementDiv = document.getElementById("kkk")
        // 
        let value_ship = document.getElementById("value_ship")
        let tienship1 = document.getElementById("tien_ship1")
        let tienship2 = document.getElementById("tien_ship2")
        let tienship3 = document.getElementById("tien_ship3")


        function ok1() {
            hienthi1ElementDiv.style.display = "block"
            hienthi1ElementDiv.style.float = "right"
            hienthi2ElementDiv.style.display = "none"
            hienthi3ElementDiv.style.display = "none"
            hahaElementDiv.style.display = "none"
            // 
            value_ship.value = tienship1.value
            ship_db.value = value_ship.value
            // 
            tongtien1ElementDiv.style.display = "block"
            tongtien1ElementDiv.style.float = "right"
            tongtien2ElementDiv.style.display = "none"
            tongtien3ElementDiv.style.display = "none"
            kkkElementDiv.style.display = "none"

        }

        function ok2() {
            hienthi1ElementDiv.style.display = "none"
            hienthi2ElementDiv.style.display = "block"
            hienthi2ElementDiv.style.float = "right"
            hienthi3ElementDiv.style.display = "none"
            hahaElementDiv.style.display = "none"
            // 
            value_ship.value = tienship2.value
            ship_db.value = value_ship.value

            // 
            tongtien1ElementDiv.style.display = "none"
            tongtien2ElementDiv.style.display = "block"
            tongtien2ElementDiv.style.float = "right"
            tongtien3ElementDiv.style.display = "none"
            kkkElementDiv.style.display = "none"

        }

        function ok3() {
            hienthi1ElementDiv.style.display = "none"
            hienthi2ElementDiv.style.display = "none"
            hienthi3ElementDiv.style.display = "block"
            hienthi3ElementDiv.style.float = "right"
            kkkElementDiv.style.display = "none"
            // 
            value_ship.value = tienship3.value
            ship_db.value = value_ship.value

            // 
            tongtien1ElementDiv.style.display = "none"
            tongtien2ElementDiv.style.display = "none"
            tongtien3ElementDiv.style.display = "block"
            tongtien3ElementDiv.style.float = "right"
            hahaElementDiv.style.display = "none"

        }

        function hienthi() {
            btn_orderElementDiv.style.display = "block"
        }

        function hienthi0() {
            btn_orderElementDiv.style.display = "block"
        }
    </script>

@endsection
