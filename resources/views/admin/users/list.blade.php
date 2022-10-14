@extends('layout.master')

@section('title', 'Quản lý người dùng')

@section('content-title', 'Quản lý người dùng')

@section('content')
    {{-- <div>
        <a href="{{ route('users.create') }}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div> --}}
    <table class='table'>
        <thead>
            <tr>
                <th>Mã id</th>
                <th>Tên</th>
                <th>Ảnh</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Quyền</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user_list as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td><img src="{{ $user->avatar }}" width="60px" alt=""></td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a onclick="return confirm('Bạn có muốn thay đổi trạng thái!')">
                            <form action="{{ route('users.updateStatus', $user->id) }}" method="post">
                                @csrf

                                @if ($user->status === 1)
                                    <i class="fab fa-circle alert-danger"></i> không kích hoạt <button type="submit"
                                        style="background: transparent; border: transparent"><i
                                            class="fa fa-redo"></i></button>
                                @else
                                    <i class="fab fa-circle alert-success"></i> Kích hoạt <button type="submit"
                                        style="background: transparent; border: transparent"><i
                                            class="fa fa-redo"></i></button>
                                @endif
                            </form>
                        </a>

                    </td>
                    <td>{{ $user->role === 0 ? 'Khách hàng' : 'Admin' }}</td>
                    <td>
                        @if ($user->role === 1)
                        @else
                        <a href="{{route('users.edit', $user->id)}}">
                            <button class='btn btn-warning'>Sửa</button>
                        </a>
                            {{-- <a onclick="return confirm('Bạn có chắc chắn muốn xóa')">
                                <form action="{{ route('users.delete', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </a> --}}
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $user_list->links() }}
    </div>
@endsection
