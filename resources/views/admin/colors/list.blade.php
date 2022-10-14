@extends('layout.master')
@section('title', 'Quản lí màu sắc sản phẩm')
@section('content-title', 'Quản lí màu sắc sản phẩm')
@section('content')
    {{-- <div>
        <a href="{{ route('admin.colors.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div> --}}
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
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
                    <form action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên màu sắc</label>
                            <input type="text" name="name_Color" id="" value="" class="form-control">
                        </div>
                        <button class="btn btn-success">
                            {{ isset($size) ? 'Update' : 'Create' }}
                        </button>
                        <button class="btn btn-danger">nhập lại</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="margin: 10px 0px 10px 0px">
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
                <th>Tên màu</th>
                <th>màu sắc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_cate as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name_Color }}</td>
                    <td>
                        <div style="width: 50px;height: 30px;background:{{ $item->name_Color }}"></div>
                    </td>
                    <td>
                        <a href="{{ route('admin.colors.edit', $item->id) }}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                        <form action="{{ route('admin.colors.delete', $item->id) }}" method="POST">
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
    <div>
        {{ $list_cate->links() }}
    </div>
@endsection
