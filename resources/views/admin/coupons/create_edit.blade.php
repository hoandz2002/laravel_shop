@extends('layout.master')
@section('title', 'Quản lí Voucher')
@section('content-title', 'Quản lý mã giảm giá')
@section('content')
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}"
        method="POST" enctype="multipart/form-data">
        {{ isset($coupon) ? method_field('PUT') : '' }}
        @csrf
        <div class="form-group">
            <label for="">Tiêu đề</label>
            <input type="text" name="name" id="" value="{{ isset($coupon) ? $coupon->name : old('name') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Nội dung</label>
            <input type="text" name="content" id=""
                value="{{ isset($coupon) ? $coupon->content : old('content') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">số lượng</label>
            <input type="text" name="quantity" id=""
                value="{{ isset($coupon) ? $coupon->quantity : old('quantity') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Mã code</label>
            <input type="text" name="code" id="" value="{{ isset($coupon) ? $coupon->code : old('code') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Giá giảm</label>
            <input type="text" name="sale" id="" value="{{ isset($coupon) ? $coupon->sale : old('sale') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Thời gian hết hạn</label>
            <input type="date" name="end_date" id=""
                value="{{ isset($coupon) ? $coupon->end_date : old('end_date') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Giá trị để được giảm</label>
            <input type="text" name="Minimum_bill" id=""
                value="{{ isset($coupon) ? $coupon->Minimum_bill : old('Minimum_bill') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input type="radio" name="status" id="" value="0" style="margin-right: 10px"
                {{ isset($coupon) && $coupon->status === 0 ? 'checked' : '' }}>Kích hoạt <br>

            <input type="radio" name="status" id="" value="1" style="margin-right: 10px"
                {{ isset($coupon) && $coupon->status === 1 ? 'checked' : '' }}>Không kích hoạt
        </div>

        <button class="btn btn-success">
            {{ isset($coupon) ? 'Update' : 'Create' }}
        </button>
        <button class="btn btn-danger">nhập lại</button>

    </form>
@endsection
