@extends('layout.master')
@section('title','Quản lí pản hồi')
@section('content-title','Quản lý quản hồi khách hàng')
@section('content')

<table class='table'>
    <thead>
        <tr>
            <th>Mã id</th>
            <th>Tên khách hàng</th>
            <th>email</th>
            <th>Chủ đề</th>
            <th>Nội dung</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->content }}</td>

                <td>
                    <a onclick="return confirm('Bạn có muốn thay đổi trạng thái!')">
                        <form action="{{ route('admin.contacts.updateAction', $item->id) }}" method="post">
                            @csrf

                            @if ($item->action === 0)
                                <i class="fab fa-circle alert-danger"></i> không hiển thị <button type="submit"
                                    style="background: transparent; border: transparent"><i
                                        class="fa fa-redo"></i></button>
                            @else
                                <i class="fab fa-circle alert-success"></i> Hiển thị <button type="submit"
                                    style="background: transparent; border: transparent"><i
                                        class="fa fa-redo"></i></button>
                            @endif
                        </form>
                    </a>

                </td>
                <td>
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa')">
                            <form action="{{ route('admin.contacts.delete', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="submit" class="btn btn-danger">Delete</button>
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