@extends('layout.master')
@section('title', 'Quản lý người dùng')
@section('content-title', 'Quản lý người dùng')
@section('content')
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ isset($size) ? route('admin.sizes.update', $size->id) : route('admin.sizes.store') }}" method="POST"
        enctype="multipart/form-data">
        {{ isset($size) ? method_field('PUT') : '' }}
        @csrf
        <div class="form-group">
            <label for="">Tên kích cỡ</label>
            <input type="text" name="nameSize" id="" value="{{ isset($size) ? $size->nameSize : old('name') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input type="radio" name="statusSize" id="" value="0" style="margin-right: 10px"
                {{ isset($size) && $size->statusSize === 0 ? 'checked' : '' }}>Kích hoạt <br> 
                
            <input type="radio" name="statusSize" id="" value="1" style="margin-right: 10px"
                {{ isset($size) && $size->statusSize === 1 ? 'checked' : '' }}>Không kích hoạt
        </div>

        <button class="btn btn-success">
            {{ isset($size) ? 'Update' : 'Create' }}
        </button>
        <button class="btn btn-danger">nhập lại</button>

    </form>
@endsection
