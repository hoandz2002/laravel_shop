@extends('layout.master')
@section('title','Quản lí pản hồi')
@section('content-title','Quản lý quản hồi khách hàng')
@section('content')
<form action="{{ route('admin.combo2.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- <div class="form-group">
        <label for="">Sản phẩm tặng</label> <br>
        <select name="product_donate" id="">
            <option value="">không</option>
            @foreach ($product as $value)
                <option value="{{ $value->id }}">{{ $value->nameProduct }}</option>
            @endforeach
    </div> --}}
   
    <div class="form-group">
        <label for="">Sản phẩm 1</label><br>
        <select name="id_product1" id="">
            @foreach ($product as $value)
                <option value="{{ $value->id }}">{{ $value->nameProduct }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="">Sản phẩm 2</label> <br>
        <select name="id_product2" id="">
            @foreach ($product as $value)
                <option value="{{ $value->id }}">{{ $value->nameProduct }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="">Sản phẩm tặng</label> <br>
        <select name="" id="">
            <option value="">không</option>
            @foreach ($product as $value)
                <option value="{{ $value->id }}">{{ $value->nameProduct }}</option>
            @endforeach
        </select>
    </div>
        <div class="form-group">
            <label for="">Giá combo</label>
            <input style="width: 385px" type="text" name="price_combo2" id="" value="" class="form-control">
        </div>
  
    <button class="btn btn-success">
        {{ isset($size) ? 'Update' : 'Create' }}
    </button>
    <button class="btn btn-danger">nhập lại</button>
    
</form>
@endsection