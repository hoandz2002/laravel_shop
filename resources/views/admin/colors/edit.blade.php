@extends('layout.master')
@section('title', 'Quản lý người dùng')
@section('content-title', 'Quản lý người dùng')
@section('content')
<form action="{{route('admin.colors.update',$color->id)}}" method="POST" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    @csrf
    <div class="form-group">
        <label for="">Tên màu sắc</label>
        <input type="text" name="name_Color" id="" value="{{$color->name_Color}}" class="form-control">
    </div>
    <button class="btn btn-success">
        {{ isset($size) ? 'Update' : 'Create' }}
    </button>
    <button class="btn btn-danger">nhập lại</button>

</form>
@endsection
