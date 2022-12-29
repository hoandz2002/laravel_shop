@extends('layout.master')

@section('title', 'Quản lí đơn hàng')

@section('content-title', 'Quản lí đơn hàng')

@section('content')
    <div>
        @if (session()->has('sucssec'))
            <div class="alert alert-info">
                {{ session()->get('sucssec') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Người nhận</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Mã vận chuyển</th>
                <th>Trạng thái</th>
                {{-- <th style="text-align: center">Hoàn trả</th> --}}
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>DHM{{ $item->id }}</td>
                    <td>{{ $item->orderName }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->oderEmail }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ number_format($item->total) }}</td>
                    <!-- Button trigger modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Trạng thái đơn hàng</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{-- <input type="text" value="{{$item->id}}" name="" id=""> --}}
                                    <p> <span style="font-weight: bold">Trạng thái đơn hàng:</span> <span
                                            style="color: red">{{ $item->code_ship }}</span></p>
                                    <p><span style="font-weight: bold">Trạng thái đơn hàng:</span>
                                        @if ($item->code_ship)
                                            <span style="color: red">Đã nhận hàng</span>
                                        @else
                                            <span style="color: red">Đã nhận hàng</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <td>
                        {{ $item->code_ship }}
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
                    </td>
                    <!-- Button trigger modal -->
                    <!-- Modal -->
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
                                    <form action="{{ route('admin.orders.add_code_ship') }}" method="POST">
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
                    <td>
                        <form action="{{ route('admin.orders.updateStatusOrder', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select {{ $item->oderStatus >= 5 ? 'disabled' : '' }} class="form-control-sm"
                                style="height: 30px" name="oderStatus" id="">
                                <option class="form-control" {{ $item->oderStatus == 0 ? 'selected' : '' }}
                                    {{ $item->oderStatus == 1 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 2 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 3 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 5 ? 'disabled' : '' }} value="0">Đang xử lý</option>
                                <option class="form-control" {{ $item->oderStatus == 1 ? 'selected' : '' }}
                                    {{ $item->oderStatus == 2 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 3 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 5 ? 'disabled' : '' }} value="1">Đang chuẩn bị hàng
                                </option>
                                <option class="form-control" {{ $item->oderStatus == 2 ? 'selected' : '' }}
                                    {{ $item->oderStatus == 0 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 3 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 5 ? 'disabled' : '' }} value="2">Đang giao hàng
                                </option>
                                <option class="form-control" {{ $item->oderStatus == 3 ? 'selected' : '' }}
                                    {{ $item->oderStatus == 0 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 1 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 5 ? 'disabled' : '' }} value="3">Đã nhận hàng</option>
                                <option class="form-control" {{ $item->oderStatus >= 5 ? 'selected' : '' }}
                                    {{ $item->oderStatus == 0 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 2 ? 'disabled' : '' }}
                                    {{ $item->oderStatus == 1 ? 'disabled' : '' }} value="5">Đã thanh toán
                                </option>
                                {{-- <option {{ $item->oderStatus == 6 ? 'selected' : '' }} value="6">Đang xác nhận HT
                                </option> --}}
                                <option class="form-control" {{ $item->oderStatus == 4 ? 'selected' : '' }} value="4">
                                    Đã hủy đơn</option>

                            </select>
                            <input type="text" name="oderEmail" value="{{ $item->oderEmail }}" hidden id="">
                            <button {{ $item->oderStatus >= 5 ? 'disabled' : '' }} style="height: 30px"
                                class="btn btn-outline-info "><i class="fa fa-check"></i></button>
                        </form>
                    </td>
                    {{-- <td>
                        @if ($item->oderStatus == 6)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Chi tiết
                            </button>
                            <form action="{{ route('client.returnProducts.listReturn', $item->id) }}" method="GET">
                                <button class="btn btn-danger">xác nhận</button>
                            </form>
                        @endif
                    </td> --}}
                    <td>
                        <form action="{{ route('admin.orders.detail', $item->id) }}">
                            <input type="text" hidden name="orderShip" value="{{ $item->orderShip }}"
                                id="">
                            <input type="text" hidden name="coupon" value="{{ $item->coupon }}" id="">
                            <input type="text" hidden name="oddPricePrd" value="{{ $item->total }}" id="">
                            <button class="btn btn-warning">
                                <i class="fas fa-eye"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $data->links() }}
    </div>
@endsection
