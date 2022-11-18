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
                                            địa chỉ nhận hàng
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
                                                    <a href="{{ route('client.informations.updateStatus', $value->id) }}"
                                                        style="text-decoration: none;">
                                                        <div style="border: 1px solid gray;width: 100%;height: 161px;">
                                                            <span style="margin-left: 20px"><b>Name:</b>
                                                                {{ $value->name_to }}</span> <br>
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
                                                    <div style="width: 500px;margin-left: 616px;margin-top: 100px"
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
                                                <span><b>Name:</b> {{ $value->name_to }}</span> <br>
                                                <span><b>Email:</b> {{ $value->email_to }}</span> <br>
                                                <span><b>address:</b> {{ $value->address_to }}</span> <br>
                                                <span><b>Phone:</b> {{ $value->phone }}</span> <br> <br>
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
                                                    <input hidden type="text" hidden name="ship_db"
                                                        value="{{ $ship }}" id="">
                                                    <p><input hidden type="tel" name="phone"
                                                            value="{{ $item->phone }}" placeholder="Phone"></p>
                                                    {{-- @foreach ($products as $item) --}}
                                                    <input hidden type="text" name="total"
                                                        value="{{ $total - $price_coupon }}" id="">
                                                    {{-- <input type="text" name="type_sale" value="{{$type_sale}}" id="">
                                                        <input type="text" name="sale_value" value="{{$sale_value}}" id=""> --}}
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
                                                        id="alo{{ $value->id }}" name="ship"
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
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal2">
                                                Thanh toán onile
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Ngân hàng liên
                                                                kết
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span><b>Số tài khoản:</b> 19036632929019 </span> <br>
                                                            <span><b>Tên tài khoản:</b> DAO CU HOAN </span> <br>
                                                            <span><b>Ngân hàng:</b> TECHCOMBANK</span> <br>
                                                            <span><b>Ghi chú:</b> {{ Auth::user()->name }} thanh toan tien
                                                                hang </span> <br>
                                                            <hr>
                                                            <span><b>Số tài khoản:</b> 0392397262 </span> <br>
                                                            <span><b>Tên tài khoản:</b> DAO CU HOAN </span> <br>
                                                            <span><b>Ngân hàng:</b> MOMO</span> <br>
                                                            <span><b>Ghi chú:</b> {{ Auth::user()->name }} thanh toan tien
                                                                hang </span> <br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            {{-- <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button> --}}
                                                            <button data-dismiss="modal" type="button"
                                                                class="btn btn-primary" onclick="hienthi0()">thanh toán
                                                                thành công</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end modals --}}
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal3">
                                                thanh toán sau khi nhận hàng
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-style: italic">Vui lòng cọc 15% tiền hàng để đảm
                                                                bảo tính xác thực trước khi nhận hàng mong quý khách chuyển
                                                                qua STK dưới đây: </p>
                                                            <br>
                                                            <span style="font-style: italic">Số tiền phải cọc:
                                                                {{ number_format(0.2 * ($total + $ship - $price_coupon)) }}</span>
                                                            <br>
                                                            <span><b>Số tài khoản:</b> 19036632929019 </span> <br>
                                                            <span><b>Tên tài khoản:</b> DAO CU HOAN </span> <br>
                                                            <span><b>Ngân hàng:</b> TECHCOMBANK</span> <br>
                                                            <span><b>Ghi chú:</b> khach hang {{ Auth::user()->name }}
                                                                chuyen tien coc hang </span> <br>
                                                            <hr>
                                                            <span><b>Số tài khoản:</b> 0392397262 </span> <br>
                                                            <span><b>Tên tài khoản:</b> DAO CU HOAN </span> <br>
                                                            <span><b>Ngân hàng:</b> MOMO</span> <br>
                                                            <span><b>Ghi chú:</b> khach hang {{ Auth::user()->name }}
                                                                chuyen tien coc hang </span> <br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            {{-- <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button> --}}
                                                            <button data-dismiss="modal" onclick="hienthi()"
                                                                type="button" class="btn btn-primary">thanh toán thành
                                                                công</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end modals coc --}}
                                        </div> <br>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button id="btn_order" class="bnt btn-default"
                                style="display: none;background: #F28123;color: white;width: 110px;height: 40px;border: 0px;border-radius: 10px">Đặt
                                hàng</button>
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
                                    <th>Chi tiết đon hàng</th>
                                    <th style="width: 100px">Giá tiền</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">

                                <tr>
                                    <td>Product</td>
                                    <td>Total</td>
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
                                                    @if ($item->quantity > 1)
                                                        x{{ $item->quantity }}
                                                    @endif
                                                @elseif ($item->type_sale == 1)
                                                    {{ number_format($item->price - $item->price * ($item->sale / 100) - $item->sale_value) }}<sup>đ</sup>
                                                    @if ($item->quantity > 1)
                                                        x{{ $item->quantity }}
                                                    @endif
                                                @else
                                                    {{ number_format($item->price - $item->price * ($item->sale / 100)) }}<sup>đ</sup>
                                                    @if ($item->quantity > 1)
                                                        x{{ $item->quantity }}
                                                    @endif
                                                @endif
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
                                    <td>
                                        <div id="haha">{{ $ship }}</div>
                                        @foreach ($ships as $value)
                                            <div style="display: none" id="hienthi{{ $value->id }}">
                                                {{ number_format($ship + ($value->price_ship / 100) * $ship) }}<sup>đ</sup>
                                            </div>
                                        @endforeach
                                        {{-- <div id="hienhi2">{{ number_format($ship) }}</div>
                                        <div id="hienthi3">{{ number_format($ship) }}</div> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tổng tiền</td>
                                    <td>
                                        <div id="kkk">
                                            {{ number_format($total + $ship - $price_coupon) }}
                                        </div>
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
                                                    </div> --}}
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
                                                                                style="margin-left: 200px;margin-top: 30px"
                                                                                type="radio" name="voucher"
                                                                                value="{{$value->id}}" id="">
                                                                        </div>
                                                                    </div> <br>
                                                                @endforeach
                                                                <button>hoan thanh</button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" data-dismiss="modal"
                                                                class="btn btn-primary">Hoàn thành</button>
                                                        </div>
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

        function ok1() {
            hienthi1ElementDiv.style.display = "block"
            hienthi2ElementDiv.style.display = "none"
            hienthi3ElementDiv.style.display = "none"
            hahaElementDiv.style.display = "none"
            // 
            tongtien1ElementDiv.style.display = "block"
            tongtien2ElementDiv.style.display = "none"
            tongtien3ElementDiv.style.display = "none"
            kkkElementDiv.style.display = "none"

        }

        function ok2() {
            hienthi1ElementDiv.style.display = "none"
            hienthi2ElementDiv.style.display = "block"
            hienthi3ElementDiv.style.display = "none"

            // 
            tongtien1ElementDiv.style.display = "none"
            tongtien2ElementDiv.style.display = "block"
            tongtien3ElementDiv.style.display = "none"
            kkkElementDiv.style.display = "none"

        }

        function ok3() {
            hienthi1ElementDiv.style.display = "none"
            hienthi2ElementDiv.style.display = "none"
            hienthi3ElementDiv.style.display = "block"
            kkkElementDiv.style.display = "none"
            // 
            tongtien1ElementDiv.style.display = "none"
            tongtien2ElementDiv.style.display = "none"
            tongtien3ElementDiv.style.display = "block"
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
