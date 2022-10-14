@extends('layout.master')
@section('title', 'Hóa đơn chi tiết')
@section('content')
    <div>
        <div class="alert alert-default-info">
            <h3 class="text-center">Hóa đơn chi tiết sản phẩm</h3>
        </div>
        <div class="col-lg-8 col-md-8 m-auto border border border-danger">
            {{-- <div class="d-flex">
            <div class="text-uppercase">
                <h2 class="font-weight-bolder">Sixteen <em style="color: #f33f3f; font-style: normal;">furniture</em></h2>
            </div>
        </div> --}}
            <div class="w-100">
                <h3 class="text-center">Hóa đơn mua hàng</h3>
                <div class="p-3 col-lg-10 m-auto">
                    <div class="d-flex">
                        <div class="col-lg-6"><b>Tên khách hàng: </b>{{ $data->orderName }}</div>
                        <div class="col-lg-6"><b>Số điện thoại: </b> {{ $data->phone }}</div>
                    </div>
                    <div class="d-flex">
                        <div class="col-lg-6"><b>Email: </b> {{ $data->oderEmail }}</div>
                        <div class="col-lg-6"><b>Địa chỉ: </b> {{ $data->address }}</div>
                    </div>
                </div>
            </div>
            <div class="">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã id</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            {{-- <th>Size</th> --}}
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->id_details }}</td>
                                <td>{{ $item->nameProduct }}</td>
                                <td><img src="{{ asset($item->avatar) }}" width="100px" alt=""></td>
                                <td>
                                    <span>
                                        @if ($item->sale)
                                            <p style="text-decoration: line-through">
                                                {{ number_format($item->oddPricePrd) }}<sup>đ</sup>
                                            </p>
                                            {{ number_format($item->oddPricePrd - ($item->oddPricePrd * $item->sale) / 100) }}<sup>đ</sup>
                                        @else
                                            {{ number_format($item->oddPricePrd) }}<sup>đ</sup>
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $item->oddQuantityPrd }}</td>
                                <td>
                                    <span>
                                        @if ($item->sale)
                                            {{ number_format(($item->oddPricePrd - ($item->oddPricePrd * $item->sale) / 100) * $item->oddQuantityPrd) }}<sup>đ</sup>
                                        @else
                                            {{ number_format($item->oddPricePrd * $item->oddQuantityPrd) }}<sup>đ</sup>
                                        @endif
                                    </span>
                                </td>
                                <p hidden>{{ $total += $item->oddPricePrd * $item->oddQuantityPrd }}</p>
                            </tr>
                        @endforeach
                        {{-- <tr>
                        <td colspan="4">Tổng tiền:</td>
                        <td colspan="1">{{ number_format($total) }}<sup>đ</sup></td>
                    </tr> --}}
                    </tbody>
                </table>
            </div>
            <div style="margin-left: 800px">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td style="text-align: center;font-weight: bold">Chi tiết đơn hàng</td>
                            <td style="text-align: center;font-weight: bold">Price</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ $orders = DB::table('order_details')
                        ->select('order_details.*', 'products.*')
                        ->join('products', 'order_details.product_id', '=', 'products.id')
                        ->where('order_id', '=', $order)->get() }} --}}
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->nameProduct }}</td>
                                <td><span>
                                        @if ($item->sale)
                                            {{ number_format(($item->oddPricePrd - ($item->oddPricePrd * $item->sale) / 100) * $item->oddQuantityPrd) }}<sup>đ</sup>
                                        @else
                                            {{ number_format($item->oddPricePrd * $item->oddQuantityPrd) }}<sup>đ</sup>
                                        @endif
                                    </span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Phí ship</td>
                            <td>
                                {{ number_format($ship) }}<sup>đ</sup>
                            </td>
                        </tr>
                        <tr>
                            <td>Mã giảm giá</td>
                            <td>{{ number_format($total_price - $price_sale - $ship) }} <sup>đ</sup></td>
                        </tr>
                        <tr>
                            <td><strong>Tổng tiền</strong></td>
                            <td><strong>{{ number_format($total_price) }}<sup>đ</sup></strong></td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <br>
        </div>
    @endsection
