@extends('layout.master')
@section('title', 'Quản lí feedback')
@section('content-title', 'Quản lý quản hồi khách hàng')
@section('content')

    <table class='table'>
        <thead>
            <tr>
                <th>Mã id</th>
                <th>Tên khách hàng</th>
                <th>Nội dung</th>
                <th>Mã đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name_user }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->content }}</td>
                    <td>{{ $item->order_Id }}</td>
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
    <div>
        {{ $contacts->links() }}
    </div>
@endsection
