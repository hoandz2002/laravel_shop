@extends('layout.master-client')
@section('title', 'Profile')
@section('conten-title', 'Profile')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Profile</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('client.updateProfile',$user->id)}}" method="POST"
        enctype="multipart/form-data">
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

        <div hidden class="form-group">
            <label for="">Phân quyền</label>
          <input type="text" name="role" value="0" id="">
        </div>
        <div hidden class="form-group">
            <label for="">Trạng thái</label>
          <input type="text" name="status" value="1"  id="">
        </div>

        <button class="btn btn-success">
            Update
        </button>
        <button class="btn btn-danger">nhập lại</button>
    </form>
@endsection
