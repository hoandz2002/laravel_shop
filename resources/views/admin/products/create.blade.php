@extends('layout.master')
@section('title', 'Thêm mới sản phẩm')
@section('content-title', 'Thê mới sản phẩm')
@section('content')

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST"
        enctype="multipart/form-data">
        {{ isset($product) ? method_field('PUT') : '' }}
        @csrf
        <div cclass="form-group">
            <label for="">Tên sản phẩm</label>
            <input type="text" name="nameProduct" value="{{ isset($product) ? $product->nameProduct : old('nameProduct') }}"
                id="" class="form-control">
            @if ($errors->has('nameProduct'))
                <p class="text-danger">{{ $errors->first('nameProduct') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="">Mô tả</label>
            <input class="form-control" type="text" name="description"
                value="{{ isset($product) ? $product->description : old('description') }}" id="">
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Avatar</label><br>
            <td><img src="{{ isset($product) ? asset($product->avatar) : '' }}" alt="" width="100"></td>
            <br> <br>
            <input class="form-control" type="file" name="avatar"
                value="{{ isset($product) ? $product->avatar : old('avatar') }}" id="">
            @if (session()->has('error'))
                <p class="text-danger">{{ session()->get('error') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Gía tiền hiển thị</label>
            <input class="form-control" type="text" name="price_in_active"
                value="{{ isset($product) ? $product->price_in_active : old('price_in_active') }}" id="">
        </div>
        <div class="col-md-6">
            <label class="form-label">Thư viện ảnh</label> <br>
            <input type="file" name="filenames[]" multiple class="form-control" placeholder="Chọn ảnh sản phẩm" />
        </div>
        <div class="form-group">
            <label for="">Danh mục dản phẩm</label>
            <select class="w-100 p-2" name="category_id" id="">
                <option value="">chọn danh mục sản phẩm</option>
                @foreach ($cate as $item)
                    <option value="{{ $item->id }}"
                        {{ isset($data) && $data->category_id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <p class="text-danger">{{ $errors->first('category_id') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Sale (%)</label>
            <input class="form-control" type="text" name="sale"
                value="{{ isset($product) ? $product->sale : old('sale') }}" id="">
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Khối lượng (kg)</label>
            <input class="form-control" type="text" name="mass"
                value="{{ isset($product) ? $product->mass : old('mass') }}" id="">
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input type="radio" name="statusPrd" value="0" {{-- {{ $data->statusPrd === 0 ? 'checked' : '' }} --}} /> Hiển thị
            <input type="radio" name="statusPrd" value="1" {{-- {{ $data->statusPrd === 1 ? 'checked' : '' }} --}} /> Ẩn
        </div>
       <div>
        @foreach ($color as $value )
            <input type="checkbox" name="color_id[]" value="{{$value->id}}" id="">{{$value->name_Color}}
        @endforeach
        </div>
      <div>
        <table>
            <tr>
                <td> <div>
                    <label for="">Chất liệu: </label>
                    <select name="material_Id[]" id="">
                        @foreach ($material as $value )
                            <option value="{{$value->id_material}}">{{$value->name_Material}}</option>
                        @endforeach
                    </select>
                    <label for="">Chọn size: </label>
                    <select name="size_Id[]" id="">
                        @foreach ($sizes as $value )
                            <option value="{{$value->id}}">{{$value->nameSize}}</option>
                        @endforeach
                    </select> 
                    <label for=""> nhập giá tiền:</label>
                    <input type="text" name="price[]" placeholder="nhap dia tien" id="">
                </div> </td>
                <td>
                    <button type="button" onclick="them(this)">thêm</button>
            </tr>
        </table>
        <h3 hidden id="empty">Bạn chưa chọn mặt hàng nào</h3>
        <div id="not-empty" style="display:none;">
    
            <table id="giohang"></table>
            <h3 hidden> $<span id="tong">0</span></h3>
            <script>
                function them(button) {
                    var row = button.parentElement.parentElement.cloneNode(true); //button.parentElement.parentElement thêm vào bảng dưới(bản chính) + cloneNode(true) cho phép thêm bản sao của các nút đã nhấn thêm 
                    var nutXoa = row.getElementsByTagName("button")[0]; //gọi đến tagname button đã đc thêm
                    nutXoa.innerText = "Xóa"; //thêm chữ xóa vào button
                    nutXoa.setAttribute('onclick', 'xoa(this)'); // lấy giá trị ở lệnh onclick thêm vào hàm xoa(this) vào (lúc đầu là thêm,)
                    document.getElementById("giohang").appendChild(row); // truy xuất tới id giohang  và gán giá trị
                    tinhtong()
                }
        
                function xoa(button) {
                    var row = button.parentElement.parentElement;
                    document.getElementById("giohang").removeChild(row);
        
                    tinhtong(); //tinh tong
                }
        
                function tinhtong() {
                    var gio = document.getElementById("giohang");
                    var tr = gio.getElementsByTagName("tr");
                    var tong = 0;
                    for (var i = 0; i < tr.length; i++) {
                        var td = tr[i].getElementsByTagName("td");
                        var tien = td[1].innerText.substr(1);
                        tong += 1 * tien;
                    }
                    document.getElementById("tong").innerText = tong;
                    if (tong == 0) {
                        document.getElementById("empty").style.display = "";
                        document.getElementById("not-empty").style.display = "none";
                    }
                    else {
                        document.getElementById("empty").style.display = "none";
                        document.getElementById("not-empty").style.display = "";
                        if (tong > 6000) {
                            document.getElementById("tong").style.backgroundColor = "yellow";
                        }
                        else {
                            document.getElementById("tong").style.backgroundColor = "white";
                        }
                    }
                }
        
        
            </script>
            </div>
        <button class="btn btn-success">
            {{ isset($product) ? 'Update' : 'Create' }}
        </button>
        <button class="btn btn-danger">nhập lại</button>
    </form>
    <br> <br>
@endsection
