@extends('layout.master')
@section('title', 'Quản lý chất liệu')
@section('content-title', 'Quản lý chất liệu')
@section('content')
<form action="" method="POST" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    @csrf
    <div class="form-group">
        <label for="">Tên chất liệu</label>
        <input type="text" name="name_Material" id="" value="{{$materials->name_Material}}" class="form-control">
    </div>
    <button class="btn btn-success">
       Update
    </button>
    <button class="btn btn-danger">nhập lại</button>

</form>
@endsection
