@extends('layout.master')
@section('title', 'Quản lý combo bán hàng')
@section('content-title', 'Quản lý combo bán hàng')
@section('content')
    <div>
        <a href="{{ route('admin.combo2.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>Mã id</th>
                <th>Sản phẩm 1</th>
                <th>Sản phẩm 2</th>
                <th>Sản phẩm tặng</th>
                <th>Giá tiền combo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->id_product1 }}</td>
                    <td>{{ $item->id_product2 }}</td>
                    <td>
                        @if ($item->product_donate == null)
                        không
                        @else
                        {{$item->product_donate}}
                        @endif
                    </td>
                    <td>{{ $item->price_combo2 }}</td>

                    <td>
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa')">
                            <form action="{{ route('admin.contacts.delete', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="submit"
                                    class="btn btn-danger">Delete</button>
                            </form>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
