@extends('layout.master')

@section('title', 'Đơn hàng hoàn trả')

@section('content-title', 'Đơn hàng hoàn trả')

@section('content')
    <div>
        @if (session()->has('sucssec'))
            <div class="alert alert-info">
                {{ session()->get('sucssec') }}
            </div>
        @endif
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>Mã id</th>
                <th>Người nhận</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th style="text-align: center">Hoàn trả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->orderName }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->oderEmail }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ number_format($item->total) }}</td>
                    <td>
                        <form action="{{ route('admin.orders.updateStatusOrder', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select style="height: 30px" name="oderStatus" id="">
                                <option {{ $item->oderStatus == 6 ? 'selected' : '' }} value="6">Đang xác nhận HT
                                </option>
                                <option {{ $item->oderStatus == 7 ? 'selected' : '' }} value="6">Chuẩn bị lấy hàng
                                </option>
                                <option {{ $item->oderStatus == 8 ? 'selected' : '' }} value="8">Đang lấy hàng
                                </option>
                                <option {{ $item->oderStatus == 9 ? 'selected' : '' }} value="9">Lấy hàng thành công
                                </option>
                                <option {{ $item->oderStatus == 10 ? 'selected' : '' }} value="10">Đã hoàn tiền
                                </option>

                            </select>
                            <input type="text" name="oderEmail" value="{{ $item->oderEmail }}" hidden id="">
                            <button style="height: 30px" class="btn btn-dark "><i class="fa fa-redo"></i></button>
                        </form>
                    </td>
                    <td>
                        @if ($item->oderStatus == 6)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Chi tiết
                            </button>
                            <form action="{{ route('client.returnProducts.listReturn', $item->id) }}" method="GET">
                                <button class="btn btn-danger">xác nhận</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.orders.detail', $item->id) }}">
                            <input type="text" hidden name="orderShip" value="{{ $item->orderShip }}" id="">
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
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <input type="text" value="{{ $item->id }}" name="" id="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
</div> @endsection
