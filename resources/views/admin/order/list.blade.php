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
                                <option {{ $item->oderStatus == 0 ? 'selected' : '' }} value="0">Đang xử lý</option>
                                <option {{ $item->oderStatus == 1 ? 'selected' : '' }} value="1">Đang chuẩn bị hàng
                                </option>
                                <option {{ $item->oderStatus == 2 ? 'selected' : '' }} value="2">Đang giao hàng</option>
                                <option {{ $item->oderStatus == 3 ? 'selected' : '' }} value="3">Đã nhận hàng</option>
                                <option {{ $item->oderStatus == 5 ? 'selected' : '' }} value="5">Đã thanh toán</option>
                                <option {{ $item->oderStatus == 4 ? 'selected' : '' }} value="4">Đã hủy đơn</option>
                            </select>
                            <input type="text" name="oderEmail" value="{{$item->oderEmail}}" hidden  id="">
                            <button style="height: 30px" class="btn btn-dark "><i class="fa fa-redo"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="{{ route('admin.orders.detail', $item->id) }}">
                            <input type="text" hidden name="orderShip" value="{{$item->orderShip}}" id="">
                            <input type="text" hidden name="oddPricePrd" value="{{$item->total}}" id="">
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
