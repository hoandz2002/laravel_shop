@extends('layout.master')

@section('title', 'Quản lý người dùng')

@section('content-title', 'Quản lý người dùng')

@section('content')
    @if ($errors->any())
        {{-- <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
        </ul> --}}
    @endif
    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST"
        enctype="multipart/form-data">
        {{ isset($user) ? method_field('PUT') : '' }}
        @csrf
        <div class="form-group">
            <label for="">Tên</label>
            <input type="text" name="name" id="" value="{{ isset($user) ? $user->name : old('name') }}"
                class="form-control">
                @if ($errors->has('name'))
                <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" id="" value="{{ isset($user) ? $user->email : old('email') }}"
                class="form-control">
                @if ($errors->has('email'))
                <p class="text-danger">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div hidden class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" id="" value="{{ isset($user) ? $user->password : '' }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Tên hiển thị</label>
            <input type="text" name="username" id="" value="{{ isset($user) ? $user->username : '' }}"
                class="form-control">
                @if ($errors->has('username'))
                <p class="text-danger">{{ $errors->first('username') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Anhr đại diện</label>
            <input type="file" name="avatar" id="" value="{{ isset($user) ? $user->avatar : '' }}"
                class="form-control">
        </div>
       
        <div class="form-group">
            <label for="">Phân quyền</label>
            <input type="radio" name="role" id="" value="1"
                {{ isset($user) && $user->role === 1 ? 'checked' : '' }}>AD
            <input type="radio" name="role" id="" value="0"
                {{ isset($user) && $user->role === 0 ? 'checked' : '' }}>KH
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
