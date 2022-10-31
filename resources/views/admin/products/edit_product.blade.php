@extends('layout.master')
@section('title', 'Cap nhat san pham')
@section('content-title', 'Cap nhat san pham')
@section('content')

<form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST"
    enctype="multipart/form-data">
    {{ isset($product) ? method_field('PUT') : '' }}
        @csrf
        <div class="form-group">
            <label for="">Tên sản phẩm</label>
            <input type="text" name="nameProduct" value="{{ $product->nameProduct }}" id="" class="form-control">
            @if ($errors->has('nameProduct'))
                <p class="text-danger">{{ $errors->first('nameProduct') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="">Mô tả</label>
            <input class="form-control" type="text" name="description" value="{{ $product->description }}"
                id="">
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Avatar</label><br>
            <td><img src="{{ isset($product) ? asset($product->avatar) : '' }}" alt="" width="100"></td>
            <br> <br>
            <input class="form-control" type="file" name="avatar"
                value="{{ isset($product) ? $product->avatar : old('avatar') }}" id="">
            @if (session()->has('error'))
                <p class="text-danger">{{ session()->get('error') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Gía tiền hiển thị</label>
            <input class="form-control" type="text" name="price_in_active" value="{{ $product->price_in_active }}"
                id="">
        </div>
        {{-- <div class="col-md-6">
            <label class="form-label">Thư viện ảnh</label> <br>
            <input type="file" name="filenames[]" multiple class="form-control" placeholder="Chọn ảnh sản phẩm" />
        </div> --}}
        <div class="form-group">
            <label for="">Danh mục dản phẩm</label>
            <select class="w-100 p-2" name="category_id" id="">
                <option value="">chọn danh mục sản phẩm</option>
                @foreach ($cate as $item)
                    <option value="{{ $item->id }}" {{ $product->category_id === $item->id ? 'checked' : '' }}>
                        {{ $item->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <p class="text-danger">{{ $errors->first('category_id') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Sale (%)</label>
            <input class="form-control" type="text" name="sale" value="{{ $product->sale }}" id="">
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Khối lượng (kg)</label>
            <input class="form-control" type="text" name="mass" value="{{ $product->mass }}" id="">
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input type="radio" name="statusPrd" value="0" {{ $product->statusPrd === 0 ? 'checked' : '' }} /> Hiển
            thị
            <input type="radio" name="statusPrd" value="1" {{ $product->statusPrd === 1 ? 'checked' : '' }} /> Ẩn
        </div>
        <button class="btn btn-success">
            Update
        </button>
        <button class="btn btn-danger">nhập lại</button>
    </form>
    <br> <br>
@endsection
