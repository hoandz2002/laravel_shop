@extends('layout.master')

@section('title', 'Chi tiết sản phẩm')

@section('content-title', 'Chi tiết sản phẩm')

@section('content')
    {{-- test modal --}}
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
                    <form action="{{ route('admin.datailProduct.store_productDetail') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <p style="font-weight: bold;font-size: 18px">mã sản phẩm: {{ $value->product_Id }}</p> --}}
                        <p>Mã sản phẩm: <span style="font-weight: bold">{{ $id }}</span></p>
                        <div hidden class="form-group">
                            <label for="">Product</label>
                            <input type="text" name="product_Id" value="{{ $id }}" id=""
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">kích thước: </label>
                            <select name="size_Id" id="">
                                @foreach ($sizes as $item)
                                    <option value="{{ $item->id }}">{{ $item->nameSize }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Chất liệu: </label>
                            {{-- <input type="text" name="product_Id" id="" value="{{ $value->name_Material }}"
                            class="form-control"> --}}
                            <select name="material_Id" id="">
                                @foreach ($material as $item)
                                    <option value="{{ $item->id_material }}">{{ $item->name_Material }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Giá tiền: </label>
                            <input type="text" name="price" id="" value="" class="form-control">

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
    <div class="d-inline-flex">
        {{-- <form action="" class="form-group d-block">
            <input type="text" class="form-control mr-1 d-inline-block" name="search" placeholder="Tìm kiếm tên sản phẩm">
            <button type="submit" class="btn btn-primary w-50">Tìm kiếm</button>
        </form> --}}
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>kích cỡ</th>
                <th>Chất liệu</th>
                <th>Giá sản phẩm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->nameSize }}</td>
                    <td>{{ $product->name_Material }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <a href="{{ route('admin.datailProduct.edit_productDetail', $product->id) }}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                        <form action="{{ route('admin.datailProduct.delete_productDetail', $product->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class='btn btn-danger'
                                onclick="return confirm('Bạn có chắc chắn muốn xóa')">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
