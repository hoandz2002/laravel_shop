@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')
<div>
    @if (session()->has('sucssec'))
        <div class="alert alert-success"> 
            {{session()->get('sucssec')}}
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
            @foreach ($order_list  as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->orderName }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->oderEmail }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->total }}</td>
                    <td>
                       <form action="{{route('admin.orders.updateStatusOrder',$item->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <select style="height: 30px" name="oderStatus"  id="">
                            <option {{$item->oderStatus == 0 ?'selected' : ''}} value="0">Đang xử lý</option>
                            <option {{$item->oderStatus == 1?'selected' : ''}} value="1">Đang giao hàng</option>
                            <option {{$item->oderStatus == 2?'selected' : ''}} value="2">Đã giao hàng</option>
                            <option {{$item->oderStatus == 3?'selected' : ''}} value="3">Đã nhận hàng</option>
                        </select>
                        <button style="height: 30px" class="btn btn-dark "><i class="fa fa-redo"></i></button>
                       </form>
                    </td>
                  
                  <td>
                    <form action="{{route('admin.orders.detail',$item->id)}}">
                        <button class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                        </button>
                    </form>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div>
        {{ $order_list->links() }}
    </div> --}}
@endsection