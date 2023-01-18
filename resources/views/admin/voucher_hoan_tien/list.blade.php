@extends('layout.master')
@section('title', 'Quản lí Mã hoàn tiền')
@section('content-title', 'Quản lí mã hoàn tiền')
@section('content')
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Thêm mới
        </button>
    </div>
    <br>
    <div>
        @if (session()->has('thanhcong'))
            <div class="alert alert-success">
                {{ session()->get('thanhcong') }}
            </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thên mới voucher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.vouchers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Tiêu đề</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Nội dung</label>
                            <input type="text" name="content" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">số lượng</label>
                            <input type="text" name="quantity" id="" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Giá trị hoàn tiền</label>
                            <input type="text" name="refund" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Thời gian hết hạn</label>
                            <input type="date" name="end_date" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Giá trị để được giảm</label>
                            <input type="text" name="minimum_bill" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label> <br>
                            <input type="radio" name="status" id="" value="0"
                                style="margin-right: 10px">Kích hoạt <br>
                            <input type="radio" name="status" id="" value="1"
                                style="margin-right: 10px">Không kích hoạt
                        </div>

                        {{-- <button class="btn btn-success">Thêm</button>
                        <button class="btn btn-danger">nhập lại</button> --}}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                </form>
            </div>
        </div>
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
                <th>Giá trị hoàn</th>
                <th>Số lượng</th>
                <th>Điều kiện áp dụng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($voucher as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->refund) }} VND</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->minimum_bill) }} VND</td>
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

                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#exampleModal{{ $item->id }}">Sửa</button>
                        <form action="{{ route('admin.vouchers.delete', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Bạn có chắc chắn muốn xóa')"
                                class='btn btn-danger'>Xoá</button>
                        </form>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật voucher</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.vouchers.update', $item->id) }}"
                                        enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Tiêu đề</label>
                                            <input type="text" name="name" value="{{ $item->name }}"
                                                id="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nội dung</label>
                                            <input type="text" name="content" value="{{ $item->content }}"
                                                id="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">số lượng</label>
                                            <input type="text" name="quantity" value="{{ $item->quantity }}"
                                                id="" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Giá trị hoàn tiền</label>
                                            <input type="text" name="refund" value="{{ $item->refund }}"
                                                id="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Thời gian hết hạn</label>
                                            <input type="date" name="end_date" value="{{ $item->end_date }}"
                                                id="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Giá trị để được giảm</label>
                                            <input type="text" name="minimum_bill" value="{{ $item->minimum_bill }}"
                                                id="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Trạng thái</label> <br>
                                            <input type="radio" name="status" id=""
                                                {{ $item->status === 0 ? 'checked' : '' }} value="0"
                                                style="margin-right: 10px">Kích hoạt <br>
                                            <input type="radio" name="status"
                                                {{ $item->status === 1 ? 'checked' : '' }} id="" value="1"
                                                style="margin-right: 10px">Không kích hoạt
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-success">Cập nhật</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
