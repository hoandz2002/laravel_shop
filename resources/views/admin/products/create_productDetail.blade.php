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
                        <option value="{{ $item->id }}">{{ $item->nameSize }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Chất liệu: </label>
                {{-- <input type="text" name="product_Id" id="" value="{{ $value->name_Material }}"
                    class="form-control"> --}}
                <select name="material_Id" id="">
                    @foreach ($material as $item)
                        <option value="{{ $item->id_material }}">{{ $item->name_Material }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Giá tiền: </label>
                <input type="text" name="price" id="" value="{{ $value->price }}" class="form-control">

            </div>
            <button class="btn btn-success">
                {{ isset($price_pro) ? 'Update' : 'Create' }}
            </button>
            <button class="btn btn-danger">nhập lại</button>

        </form>
    @endforeach

    <br> <br>
@endsection
