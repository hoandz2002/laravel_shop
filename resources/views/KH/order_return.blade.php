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
                        <h1
                            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            Đơn hàng hoàn trả</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @if (session()->has('danger'))
            <div class="alert alert-danger">
                {{ session()->get('danger') }}
            </div>
        @endif
    </div>
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div>
        <table class='table'>
            <thead>
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Mã vận đơn</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th colspan="2" style="text-align: center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <span hidden>{{ $dem = 0 }}</span>
                @foreach ($order_list as $item)
                    <tr>
                        <td>HDHT{{ $dem = $dem + 1 }}</td>
                        <td>{{ $item->orderName }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->oderEmail }}</td>
                        <td>{{ $item->address }}</td>
                        <td>
                            {{ $item->code_ship }}
                            @if ($item->oderStatus == 6)
                                <i style="color: gray">Chờ Admin xác nhận</i>
                            @else
                                @if ($item->code_ship)
                                    <button style="background: transparent;border: 0" type="button" data-toggle="modal"
                                        data-target="#exampleModal{{ $item->id }}">
                                        <i style="color: red" class="fas fa-search"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal1{{ $item->id }}">
                                        Add code ship
                                    </button>
                                @endif
                            @endif

                        </td>
                        <div class="modal fade" id="exampleModal1{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('client.returnProducts.add_code_ship') }}" method="POST">
                                            @csrf
                                            <div>
                                                <input type="text" hidden name="id_order" value="{{ $item->id }}">
                                                <label for="">Nhập mã vận đơn</label>
                                                <input type="text" class="form-control" name="code_ship"
                                                    placeholder="nhập code ship" id="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <td>{{ number_format($item->total) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatusOrder', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select disabled style="height: 30px" name="oderStatus" id="">
                                    <option {{ $item->oderStatus == 6 ? 'selected' : '' }} value="7">Đang xác nhận HT
                                    </option>
                                    <option {{ $item->oderStatus == 7 ? 'selected' : '' }} value="7">Chuẩn bị lấy hàng
                                    </option>
                                    <option {{ $item->oderStatus == 8 ? 'selected' : '' }} value="8">Đang lấy hàng
                                    </option>
                                    <option {{ $item->oderStatus == 9 ? 'selected' : '' }} value="9">Lấy hàng thành
                                        công
                                    </option>
                                    <option {{ $item->oderStatus == 10 ? 'selected' : '' }} value="10">Đã hoàn tiền
                                    </option>
                                    <option {{ $item->oderStatus == 100 ? 'selected' : '' }} value="100">Không được xác
                                        nhận
                                    </option>
                                </select>
                                {{-- <button style="height: 30px" class="btn btn-dark "><i class="fa fa-redo"></i></button> --}}
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('client.detail', $item->order_id) }}">
                                <input type="text" hidden name="oddPricePrd" value="{{ $item->total }}" id="">
                                <input type="text" hidden name="orderShip" value="{{ $item->orderShip }}"
                                    id="">
                                <input type="text" name="return" value="ok" hidden id="">
                                <input type="text" hidden name="coupon" value="{{ $item->coupon }}" id="">
                                <button style="margin-left: 150px" class="btn btn-warning">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                        </td>
                        {{-- <td>
                            <form action="https://www.facebook.com/profile.php?id=100070668864172">
                                <button class="btn btn-primary">Liên hệ shop</button>
                            </form>
                        </td> --}}
                        <td>
                            <form method="POST" action="{{ route('client.updateStatusOrder', $item->id) }}">
                                @csrf
                                {{-- <button style="width:170px;" class="btn {{ $item->oderStatus == 4 ?'btn-success '  : 'btn-danger'}}"  >
                                    {{ $item->oderStatus == 4 ? 'Đặt lại đơn hàng' : 'Hủy đơn hàng'}}
                                </button> --}}
                                @if ($item->oderStatus == 0 || $item->oderStatus == 1)
                                    <button style="width: 170px" class="btn btn-danger">
                                        Hủy đơn hàng
                                    </button>
                                @elseif ($item->oderStatus == 2)
                                    <button style="width: 170px" class="btn btn-dark">
                                        Đã nhận hàng
                                    </button>
                                @elseif ($item->oderStatus == 3)
                                    <button style="width: 170px" class="btn btn-warning">
                                        Đánh giá
                                    </button>
                                @elseif ($item->oderStatus == 5)
                                    <button style="width: 170px" class="btn btn-info">
                                        Hoàn trả
                                    </button>
                                @elseif ($item->oderStatus == 4 ||
                                    $item->oderStatus == 6 ||
                                    $item->oderStatus == 7 ||
                                    $item->oderStatus == 8 ||
                                    $item->oderStatus == 9 ||
                                    $item->oderStatus == 10)
                                    <button type="button" style="width: 170px" class="btn btn-success">
                                        Đặt lại đơn hàng
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div>
        {{ $order_list->links() }}
    </div> --}}
    </div>
@endsection
