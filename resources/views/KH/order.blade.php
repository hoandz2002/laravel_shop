@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')
    <!-- search area -->
    <form action="{{ route('client.shop') }}">
        <div class="search-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="close-btn"><i class="fas fa-window-close"></i></span>
                        <div class="search-bar">
                            <div class="search-bar-tablecell">
                                <h3>Search For:</h3>
                                <input type="text" name="search" placeholder="Keywords">
                                <button type="submit">Search <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end search area -->

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>List order</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @if (session()->has('danger'))
            <div class="alert alert-danger">
                {{ session()->get('danger') }}
            </div>
        @endif

    </div>
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

    </div>
    <div>
        @if (session()->has('error_empty'))
            <div class="alert alert-warning">
                {{ session()->get('error_empty') }}
            </div>
        @endif
    </div>
    <div>
        <table class='table'>
            <thead>
                <tr>
                    <th>M?? id</th>
                    <th>Ng?????i nh???n</th>
                    <th>S??? ??i???n tho???i</th>
                    <th>Email</th>
                    <th>?????a ch???</th>
                    <th>T???ng ti???n</th>
                    <th>Tr???ng th??i</th>
                    <th colspan="2" style="text-align: center">H??nh ?????ng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_list as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->orderName }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->oderEmail }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ number_format($item->total) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatusOrder', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select disabled style="height: 30px" name="oderStatus" id="">
                                    <option {{ $item->oderStatus == 0 ? 'selected' : '' }} value="0">??ang x??? l??
                                    </option>
                                    <option {{ $item->oderStatus == 1 ? 'selected' : '' }} value="1">??ang chu???n b???
                                        h??ng
                                    </option>
                                    <option {{ $item->oderStatus == 2 ? 'selected' : '' }} value="2">??ang giao h??ng
                                    </option>
                                    <option {{ $item->oderStatus == 3 ? 'selected' : '' }} value="3">???? nh???n h??ng
                                    </option>
                                    <option {{ $item->oderStatus == 4 ? 'selected' : '' }} value="4">H???y ????n h??ng
                                    </option>
                                    <option {{ $item->oderStatus >= 5 ? 'selected' : '' }} value="5">???? thanh to??n
                                </select>
                                {{-- <button style="height: 30px" class="btn btn-dark "><i class="fa fa-redo"></i></button> --}}
                            </form>
                        </td>

                        <td>
                            <form action="{{ route('client.detail', $item->id) }}">
                                <input type="text" hidden name="oddPricePrd" value="{{ $item->total }}" id="">
                                <input type="text" hidden name="orderShip" value="{{ $item->orderShip }}"
                                    id="">
                                <input type="text" hidden name="coupon" value="{{ $item->coupon }}" id="">
                                <button class="btn btn-warning">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                        </td>
                        {{-- <td>
                            <form action="https://www.facebook.com/profile.php?id=100070668864172">
                                <button class="btn btn-primary">Li??n h??? shop</button>
                            </form>
                         </td> --}}
                        <td>
                            <form method="POST" action="{{ route('client.updateStatusOrder', $item->id) }}">
                                @csrf
                                {{-- <button style="width:170px;" class="btn {{ $item->oderStatus == 4 ?'btn-success '  : 'btn-danger'}}"  >
                                    {{ $item->oderStatus == 4 ? '?????t l???i ????n h??ng' : 'H???y ????n h??ng'}}
                                </button> --}}

                                @if ($item->oderStatus == 0 || $item->oderStatus == 1)
                                    <button style="width: 170px" class="btn btn-danger">
                                        H???y ????n h??ng
                                    </button>
                                @elseif ($item->oderStatus == 2)
                                    <button style="width: 170px" class="btn btn-dark">
                                        ???? nh???n h??ng
                                    </button>
                                @elseif ($item->oderStatus == 3)
                                    <button style="width: 170px" class="btn btn-warning">
                                        ????nh gi??
                                    </button>
                                @elseif ($item->oderStatus >= 5)
                                    <?php
                                    $date1 = date(today());
                                    $date2 = $item->orderDate;
                                    $diff = abs(strtotime($date2) - strtotime($date1));
                                    $years = floor($diff / (365 * 60 * 60 * 24));
                                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                    ?>
                                    @if ($days > 3 || $years > 1 || $months > 1)
                                        <div>
                                            <button class="btn btn-outline-primary" type="button">Mua
                                                l???i</button>
                                            <button class="btn btn-outline-secondary" type="button">Li??n h??? shop</button>
                                        </div>
                                    @else
                                        <button style="width: 170px" class="btn btn-info">
                                            Ho??n tr???
                                        </button>
                                    @endif
                                @elseif ($item->oderStatus == 4)
                                    <button style="width: 170px" class="btn btn-success">
                                        ?????t l???i ????n h??ng
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div>
        {{ $order_list->links() }}
    </div> --}}
    </div>

@endsection
