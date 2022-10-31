@extends('layout.master')

@section('title', 'Thông tin hoàn trả')

@section('content-title', 'Thông tin hoàn trả')

@section('content')
    @foreach ($data as $value)
        <div>
            <p><span style="font-weight: bold">Mã đơn hàng: </span><span>{{ $value->order_id }}</span></p>
            <p><span style="font-weight: bold">Họ tên khách hàng: </span> {{ $value->user_name }}</p>
            <p><span style="font-weight: bold">email: </span> {{ $value->email }}</p>
            <p><span style="font-weight: bold">Lí do hoàn đơn: </span> {{ $value->reason }}</p>
            <p><span style="font-weight: bold">Ảnh phản hồi:</span> </p>
            <p><span style="font-weight: bold">Lời nhắn: </span> {{ $value->message }}</p>
            <form action="{{ route('client.returnProducts.updateStatus', $value->order_id) }}" method="POST">
                @csrf
                <button class="btn btn-success">Xác nhận hoàn trả</button>
            </form>
            {{-- <button class="btn btn-danger">Từ chối hoàn trả</button> --}}
        </div>
    @endforeach
@endsection
