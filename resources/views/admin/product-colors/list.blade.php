@extends('layout.master')
@section('title', 'Quản lí danh thuộc tính măù sắc')
@section('content-title', 'Quản lí danh thuộc tính măù sắc')
@section('content')
    <div>
        {{-- <a href="">
            <button class='btn btn-success'>Thêm mới</button>
        </a> --}}
    </div>
    <!-- Button trigger modal -->
    <button style="margin-bottom: 10px" type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
        Cập nhật lại </button>

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
                    <form action="{{ route('admin.productColors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="product_id" hidden value="{{ $product }}" id="">
                        <div class="form-group">
                            <label for="">Tên màu sắc</label> <br>
                            @foreach ($color as $value)
                                <input type="checkbox" name="color_id[]" id=""
                                    @foreach ($list_cate as $item) {{ $value->id == $item->color_id ? 'checked' : '' }} @endforeach
                                    value="{{ $value->id }}"><span
                                    style="margin-left: 5px">{{ $value->name_Color }}</span> <br>
                            @endforeach
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
    <p>Mã sản phẩm:<span style="font-weight: bold">{{ $product }}</span></p>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Màu Sắc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_cate as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name_Color }}</td>

                    <td>
                        {{-- <a href="{{ route('admin.sizes.edit', $item->id) }}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a> --}}
                        <form action="{{ route('admin.sizes.delete', $item->id) }}" method="POST">
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
