@extends('layout.master')
@section('title', 'Quản lí danh mục sản phẩm')
@section('content-title', 'Quản lí danh mục')
@section('content')
    <div>
        <a href="{{ route('catepr.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div>
    <div>
        @if (session()->has('success'))
            <div class="alert-success">
                {{session()->get('success')}}
            </div>
        @endif
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục </th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_cate as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a onclick="return confirm('Bạn có muốn thay đổi trạng thái!')">
                            <form action="{{ route('catepr.updateStatus', $item->id) }}" method="post">
                                @csrf

                                @if ($item->statusCate == 0)
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
                        <a href="{{route('catepr.edit', $item->id)}}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                        <form action="{{ route('catepr.delete', $item->id) }}" method="POST">
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
