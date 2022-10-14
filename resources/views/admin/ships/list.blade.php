@extends('layout.master')
@section('title', 'Quản lí danh mục size')
@section('content-title', 'Quản lí danh mục kích thước ')
@section('content')
    <div>
        {{-- <a href="{{ route('admin.mater.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a> --}}
    </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            Tạo mới </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm mới hãng vận chuyển</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.ships.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Hãng vận chuyển</label>
                                <input type="text" name="name_ship" id="" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">giá tiền</label>
                                <input type="text" name="price_ship" id="" value="" class="form-control">
                            </div>
                            <button class="btn btn-success">
                                Create
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
                <th>Hãng giao hàng</th>
                <th>giá tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name_ship }}</td>
                    <td>{{ $item->price_ship }}</td>

                    <td>
                        <a href="">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                        <form action="" method="POST">
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
    {{-- <div>
        {{ $list_cate->links() }}
    </div> --}}
@endsection
