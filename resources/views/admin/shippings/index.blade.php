@extends('layout.master')
@section('title', 'Thông tin vận chuyển')
@section('content-title', 'Thông tin vận chuyển')
@section('content')
    <div style="margin-bottom: 20px">
        <form action="">
            <input type="text" name="search" placeholder="nhập mã đơn hàng..." style="height: 37px" id="">
            <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã vận chuyển</th>
                <th>Mã đơn hàng</th>
                <th>trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->code_ship }}</td>
                    <td>DHM{{ $item->order_id }}</td>
                    <td>
                        <div>
                            @if ($item->status == 0)
                                <span style="font-weight: bold">Đang giao hàng</span>
                            @elseif ($item->status == 1)
                                <span style="font-weight: bold">Đã nhận hàng</span>
                            @elseif ($item->status == 2)
                                <span style="font-weight: bold">Đã thanh toán</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button {{ $item->status == 0 || 1 ? 'disabled' : '' }}
                                onclick="return confirm('Bạn có chắc chắn muốn xóa')" class='btn btn-danger'>Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $data->links() }}
    </div>
@endsection
