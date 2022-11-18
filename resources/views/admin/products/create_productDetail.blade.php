@extends('layout.master')
@section('title', 'Cập nhật thuộc tính sản phẩm')
@section('content-title', 'Cập nhật thuộc tính sản phẩm')
@section('content')
    @foreach ($price_pro as $value)
        <form action="{{ route('admin.datailProduct.update_productDetail', $value->id) }}" method="POST"
            enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
            <p style="font-weight: bold;font-size: 18px">mã sản phẩm: {{ $value->product_Id }}</p>
            <div hidden class="form-group">
                <label for="">Product</label>
                <input type="text" name="product_Id" id="" value="{{ $value->product_Id }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="">kích thước: </label>
                {{-- <input type="text" name="product_Id" id="" value="{{ $value->nameSize }}" class="form-control"> --}}
                <select name="size_Id" id="">
                    @foreach ($sizes as $item)
                        <option {{ $value->size_Id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->nameSize }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Chất liệu: </label>
                {{-- <input type="text" name="product_Id" id="" value="{{ $value->name_Material }}"
                    class="form-control"> --}}
                <select name="material_Id" id="">
                    @foreach ($material as $item)
                        <option {{ $value->material_Id == $item->id_material ? 'selected' : '' }} value="{{ $item->id_material }}">{{ $item->name_Material }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Giá tiền: </label>
                <input type="text" name="price" id="" value="{{ $value->price }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Loại giảm giá</label>
                {{-- <input type="text" name="type_sale" id="" value="{{ $value->type_sale }}" class="form-control"> --}}
                <br>
                <select name="type_sale" id="">
                    <option {{ $value->type_sale == 1 ? 'selected' : '' }} value="1">Trừ tiền</option>
                    <option {{ $value->type_sale == 2 ? 'selected' : '' }} value="2">Trừ % giá trị</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Giá giảm </label>
                <input type="text" name="sale_value" id="" value="{{ $value->sale_value }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Số lượng sản phẩm</label>
                <input type="text" name="quantity" id="" value="{{ $value->quantity }}" class="form-control">
            </div>
            <button class="btn btn-success">
                {{ isset($price_pro) ? 'Update' : 'Create' }}
            </button>
            <button class="btn btn-danger">nhập lại</button>

        </form>
    @endforeach

    <br> <br>
@endsection
