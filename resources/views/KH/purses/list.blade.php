@extends('layout.master-client')
@section('title', 'Quản lý đia chỉ nhận hàng')
@section('content-title', 'Quản lý đia chỉ nhận hàng')
@section('content')
    <style>
        #text {
            margin-left: 300px;
            font-size: 18px;
        }
    </style>
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1
                            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            VÍ TIỀN</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h2 style="font-family: monospace;text-align: center">Ví số dư</h2>
    <div style="display: flex;float: left;margin-left: 280px">
        <div style="margin-left: 50px">
            <span style="font-weight: bold;font-size: 18px">Khách hàng: </span><span
                style="font-size: 18px">{{ $purse->name }}</span>
        </div>
        <div id="text">
            <span style="font-weight: bold;font-size: 18px">
                Số dư:
            </span>
            @if ($purse->surplus == 0)
                <span style="color: red"><span>{{ $purse->surplus }}</span> VNĐ</span>
            @elseif ($purse->surplus > 0)
                <span style="color: green"><span>{{ number_format($purse->surplus) }}</span> VNĐ</span>
            @endif
        </div>
        <div id="text" style="">
            <span style="font-weight: bold;font-size: 18px">
                Trạng thái:
            </span>
            @if ($purse->status === 0)
                <span style="color: rgb(11, 205, 34)">
                    Đang hoạt động
                </span>
            @else
                <span style="color: red">
                    Không hoạt động
                </span>
            @endif
        </div>
    </div>
    <br> <br>
    <div>
        <div style="float: right;margin-right: 400px">
            <a href="#" class="btn btn-secondary" style="margin-right: 20px">Rút tiền</a>
            <a href="{{ route('client.purses.create') }}" class="btn btn-info">Nạp tiền</a>
        </div>
    </div>
    <br><br><br>
    <hr style="width: 1000px;"><br>
    <h2 style="font-family: monospace;text-align: center;">Lịch sử giao dịch</h2>
    <div class="lich_su_giao_dich">
        <table class='table'>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày giờ</th>
                    <th>Nội dung</th>
                    <th>Số tiền</th>
                    <th>Loại giao dịch</th>
                    <th>Số dư</th>
                </tr>
            </thead>
            <tbody>
                <span hidden>{{ $dem = 0 }}</span>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $dem = $dem + 1 }}</td>
                        <td>{{ $item->date_time }}</td>
                        <td>{{ $item->content }}</td>
                        <td>{{ number_format($item->money) }} VND</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ number_format($item->surplus) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $data->links() }}
        </div>
    </div>
    <br><br>
@endsection
