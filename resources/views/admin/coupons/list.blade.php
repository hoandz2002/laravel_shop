@extends('layout.master')
@section('title', 'Quản lí Mã giảm giá')
@section('content-title', 'Quản lí mã giảm giá')
@section('content')
    <div>
        <a href="{{ route('admin.coupons.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div>
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Mã code</th>
                <th>Giá giảm</th>
                <th>Số lượng</th>
                <th>Điều kiện áp dụng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_coupon as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ number_format($item->sale) }} VND</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->Minimum_bill) }} VND</td>
                    <td>
                        <a onclick="return confirm('Bạn có muốn thay đổi trạng thái!')">
                            <form action="{{ route('admin.coupons.updateStatus', $item->id) }}" method="post">
                                @csrf

                                @if ($item->status == 0)
                                    <i class="fab fa-circle alert-success"></i> Kích hoạt
                                    <button type="submit" style="background: transparent; border: transparent"><i
                                            class="fa fa-redo"></i></button>
                                @else
                                    <i class="fab fa-circle alert-danger"></i>Không kích hoạt <button type="submit"
                                        style="background: transparent; border: transparent"><i
                                            class="fa fa-redo"></i></button>
                                @endif
                            </form>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $item->id) }}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                        <form action="{{ route('admin.coupons.delete', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Bạn có chắc chắn muốn xóa')"
                                class='btn btn-danger'>Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
