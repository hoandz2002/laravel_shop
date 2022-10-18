@extends('layout.master-client')
@section('title', 'Quản lý đia chỉ nhận hàng')
@section('content-title', 'Quản lý đia chỉ nhận hàng')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>INFORMATION</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <button style="margin-bottom: 10px" type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
        Tạo mới </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('client.informations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên người nhận</label>
                            <input type="text" name="name_to" id="" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email_to" id="" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Địa chỉ nhận</label>
                            <input type="text" name="address_to" id="" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" id="" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label> <br>
                            <input type="radio" name="status" id="" value="0" class=""><span
                                style="margin-left: 10px">hoạt động</span> <br>
                            <input type="radio" name="status" id="" value="1" class=""><span
                                style="margin-left: 10px">không hoạt động</span>
                        </div>
                        <button class="btn btn-success">
                            {{ isset($size) ? 'Update' : 'Create' }}
                        </button>
                        <button class="btn btn-danger">nhập lại</button>

                    </form>
                </div>
                {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
            </div>
        </div>
    </div>

    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên gnười nhận</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name_to }}</td>
                    <td>{{ $item->email_to }}</td>
                    <td>{{ $item->address_to }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if ($item->status == 0)
                            Đang sử dụng
                        @else
                            Không sử dụng
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.materials.edit', $item->id) }}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a> <br>
                        <form action="{{ route('admin.materials.delete', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Bạn có chắc chắn muốn xóa')"
                                class='btn btn-danger'>Xoá</button>
                        </form> <br>
                        @if ($item->status == 1)
                            <a href="{{ route('client.informations.updateStatus', $item->id) }}">
                                <button onclick="return confirm('Bạn muốn sử dụng địa chỉ này ?')" class="btn btn-info">
                                    sử dụng
                                </button> </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
