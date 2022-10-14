@extends('layout.master-client')
@section('title', 'Profile')
@section('conten-title', 'Profile')
@section('content')
    <!-- breadcrumb-section -->
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
    <!-- end breadcrumb section -->
    <h2 style="text-align: center;margin-top: 30px">Thông tin chi tiết</h2>

    <div class="thongtin" style="display: inline-flex">
        <div style="width: 500px"></div>
        <div class="avatar" style="width: 200px">
            <img src="{{ asset($data->avatar) }}" width="180px" height="200px" alt="">
        </div>
        <div style="margin-left: 200px" class="detail">
            <div>
                <span style="color: black;font-size: 20px">
                    <span style="">Họ tên:</span> <span
                        style="color: #f28123;font-weight: bold">{{ $data->name }}</span> <br><br>
                    Email:<span style="color: #f28123;font-weight: bold"> {{ $data->email }}</span> <br><br>
                    Nickname: <span style="color: #f28123;font-weight: bold"> {{ $data->username }}</span>
                </span>
            </div>
        </div>
    </div> <br> <br>
    <div class="chucnang" style="margin-left: 600px;margin-bottom: 50px">
        <span>
            <a href="{{route('client.editProfile',Auth::id())}}">
                <button class="btn btn-success">Sửa đổi thông tin</button>
            </a>
            <span style="margin-left: 50px"><a href=""><button class="btn btn-warning">Đổi mật khẩu</button></a>
            <span style="margin-left: 50px"><a onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản')" href="{{route('client.report',Auth::id())}}"><button class="btn btn-danger">Khóa tài khoản</button></a></span>
            </span>
        </span>
    </div>
@endsection
