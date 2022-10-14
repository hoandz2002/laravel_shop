@extends('layout.master')
@section('title', 'Quản lí danh mục size')
@section('content-title', 'Quản lí danh mục kích thước ')
@section('content')
    <div>
        <a href="{{ route('admin.sizes.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên kích cỡ</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_cate as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nameSize }}</td>
                    <td>
                        <a onclick="return confirm('Bạn có muốn thay đổi trạng thái!')">
                            <form action="{{ route('admin.sizes.updateStatus', $item->id) }}" method="post">
                                @csrf

                                @if ($item->statusSize == 0)
                                    <i class="fab fa-circle alert-success"></i> Kích hoạt <button type="submit"
                                        style="background: transparent; border: transparent"><i
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
                        <a href="{{ route('admin.sizes.edit', $item->id) }}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                        <form action="{{ route('admin.sizes.delete', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Bạn có chắc chắn muốn xóa')" class='btn btn-danger'>Xoá</button>
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
