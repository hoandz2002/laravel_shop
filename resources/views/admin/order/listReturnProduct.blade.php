@extends('layout.master')

@section('title', 'Đơn hàng hoàn trả')

@section('content-title', 'Đơn hàng hoàn trả')

@section('content')
    <div>
        @if (session()->has('success'))
            <div class="alert alert-info">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>Mã id</th>
                <th>Người nhận</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hoàn trả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <span hidden>{{ $dem = 0 }}</span>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $dem = $dem + 1 }}</td>
                    <td>{{ $item->orderName }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->oderEmail }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ number_format($item->total) }}</td>
                    <td>
                        <form action="{{ route('client.returnProducts.updateStatus', $item->id) }}" method="POST">
                            @csrf
                            <select {{ $item->oderStatus == 100 ? 'disabled' : '' }}
                                {{ $item->oderStatus == 10 ? 'disabled' : '' }}
                                {{ $item->oderStatus == 6 ? 'disabled' : '' }} style="height: 30px" name="oderStatus"
                                id="">
                                <option {{ $item->oderStatus == 6 ? 'selected' : '' }}
                                    @if ($item->oderStatus == 7 || $item->oderStatus == 8 || $item->oderStatus == 9) disabled @endif value="6">
                                    Đang xác nhận HT
                                </option>
                                <option {{ $item->oderStatus == 7 ? 'selected' : '' }}
                                    @if ($item->oderStatus == 8 || $item->oderStatus == 9) disabled @endif value="7">Chuẩn bị lấy hàng
                                </option>
                                <option {{ $item->oderStatus == 8 ? 'selected' : '' }}
                                    @if ($item->oderStatus == 9) disabled @endif value="8">Đang lấy hàng
                                </option>
                                <option {{ $item->oderStatus == 9 ? 'selected' : '' }}
                                    @if ($item->oderStatus == 7) disabled @endif value="9">Lấy hàng thành công
                                </option>
                                <option {{ $item->oderStatus == 10 ? 'selected' : '' }}
                                    @if ($item->oderStatus == 7 || $item->oderStatus == 8) disabled @endif value="10">Đã hoàn tiền
                                </option>
                                <option {{ $item->oderStatus == 100 ? 'selected' : '' }} value="10">Khách hàng hủy đơn
                                </option>
                            </select>
                            <input type="text" name="oderEmail" value="{{ $item->oderEmail }}" hidden id="">
                            <input type="text" value="3" name="tu_choi" hidden id="">
                            <button {{ $item->oderStatus == 100 ? 'disabled' : '' }}
                                {{ $item->oderStatus == 10 ? 'disabled' : '' }}
                                {{ $item->oderStatus == 6 ? 'disabled' : '' }} style="height: 30px"
                                class="btn btn-dark "><i class="fa fa-redo"></i></button>
                        </form>
                    </td>
                    <td>
                        @if ($item->oderStatus == 6)
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal{{ $item->id }}">
                                Chi tiết
                            </button>
                            {{-- <form action="{{ route('client.returnProducts.listReturn', $item->id) }}" method="GET">
                                <button class="btn btn-danger">xác nhận</button>
                            </form> --}}
                        @else
                            Đã xác nhận
                        @endif
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <span hidden>
                                        <?php
                                        $detail_return = DB::table('return_details')
                                            ->where('order_id', '=', $item->id)
                                            ->get();
                                        ?>
                                    </span>
                                    @foreach ($detail_return as $value)
                                        <div>
                                            <p><span style="font-weight: bold">Mã đơn hàng:
                                                </span><span>{{ $value->order_id }}</span></p>
                                            <p><span style="font-weight: bold">Họ tên khách hàng: </span>
                                                {{ $value->user_name }}</p>
                                            <p><span style="font-weight: bold">email: </span> {{ $value->email }}</p>
                                            <p><span style="font-weight: bold">Lí do hoàn đơn: </span>
                                                {{ $value->reason }}</p>
                                            <p><span style="font-weight: bold">Ảnh phản hồi:</span> </p>
                                            <p><span style="font-weight: bold">Lời nhắn: </span> {{ $value->message }}
                                            </p>
                                            <div class="modal-footer">
                                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                                <form action="{{ route('client.returnProducts.updateStatus', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input hidden type="text" name="tu_choi" value="0"
                                                        id=""> <button type="submit" class="btn btn-success">Xác
                                                        nhận</button>
                                                </form>
                                                <form action="{{ route('client.returnProducts.updateStatus', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input hidden type="text" name="tu_choi" value="1"
                                                        id="">
                                                    <button type="submit" class="btn btn-danger">Từ chối</button>
                                                </form>
                                            </div>
                                            {{-- <button class="btn btn-danger">Từ chối hoàn trả</button> --}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <td>
                        <form action="{{ route('admin.orders.detail', $item->id) }}">
                            <input type="text" hidden name="orderShip" value="{{ $item->orderShip }}" id="">
                            <input type="text" hidden name="oddPricePrd" value="{{ $item->total }}" id="">
                            <button class="btn btn-warning">
                                <i class="fas fa-eye"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Button trigger modal -->
@endsection
