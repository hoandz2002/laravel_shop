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
    <form action="{{ isset($cate) ? route('catepr.update', $cate->id) : route('catepr.store') }}" method="POST"
        enctype="multipart/form-data">
        {{ isset($cate) ? method_field('PUT') : '' }}
        @csrf
        <div class="form-group">
            <label for="">Tên danh mục</label>
            <input type="text" name="name" id="" value="{{ isset($cate) ? $cate->name : old('name') }}"
                class="form-control">
                <div>
                    @if (session()->has('erro'))
                        <div class="alert-default-danger">
                            * {{session()->get('erro')}}
                        </div>
                    @endif
                </div>
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input type="radio" name="statusCate" id="" value="0" style="margin-right: 10px"
                {{ isset($cate) && $cate->statusCate === 0 ? 'checked' : '' }}>Kích hoạt <br> 
                
            <input type="radio" name="statusCate" id="" value="1" style="margin-right: 10px"
                {{ isset($cate) && $cate->statusCate === 1 ? 'checked' : '' }}>Không kích hoạt
        </div>

        <button class="btn btn-success">
            {{ isset($cate) ? 'Update' : 'Create' }}
        </button>
        <button class="btn btn-danger">nhập lại</button>

    </form>
@endsection
