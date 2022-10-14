@extends('layout.master')
@section('title','Quản lí pản hồi')
@section('content-title','Quản lý quản hồi khách hàng')
@section('content')
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ isset($contacts) ? route('admin.contacts.update', $contacts->id) : route('admin.contacts.store') }}" method="POST"
        enctype="multipart/form-data">
        {{ isset($contacts) ? method_field('PUT') : '' }}
        @csrf
        <div class="form-group">
            <label for="">Họ tên</label>
            <input type="text" name="name" id="" value="{{ isset($contacts) ? $contacts->name : old('name') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" id="" value="{{ isset($contacts) ? $contacts->email : old('email') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" id="" value="{{ isset($contacts) ? $contacts->password : '' }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input type="radio" name="status" id="" value="1"
                {{ isset($user) && $user->status === 1 ? 'checked' : '' }}>Kích hoạt
            <input type="radio" name="status" id="" value="0"
                {{ isset($user) && $user->status === 0 ? 'checked' : '' }}>Không kích hoạt
        </div>

        <button class="btn btn-success">
            {{ isset($user) ? 'Update' : 'Create' }}
        </button>
        <button class="btn btn-danger">nhập lại</button>

    </form>
@endsection
