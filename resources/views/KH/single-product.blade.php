@extends('layout.master-client')
@section('title', 'san pham')
@section('conten-title', 'san pham')
@section('content')
    <link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
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
                        <p>See more Details</p>
                        <h1>Single Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error_emty_user'))
            <div class="alert alert-warning">
                {{ session()->get('error_emty_user') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{ asset($dataProduct->avatar) }}" width="100%" alt="">
                    </div>
                    <br><br>
                    <div>
                        <p style="" id="myContent" class="text-capitalize nameContent my-1">
                            {{ $dataProduct->description }}
                        </p>
                        <div style="" class="m-auto text-center">
                            <a onclick="myFunctionHide()" id="buttonHide"
                                style="color: blue; cursor: pointer; display: none;">Ấn</a>
                            <a onclick="myFunctionShow()" id="buttonShow" style="color: blue; cursor: pointer;">Hiển
                                thị</a>
                        </div>
                    </div> <br> <br>
                </div>

                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $dataProduct->nameProduct }}
                            @if ($dataProduct->sale > 0)
                                <span
                                    style="color: white;font-weight: bold;background: red;width: 200px;text-align: center;border-radius:0px 10px 0px 10px">
                                    -{{ $dataProduct->sale }}%
                                </span>
                            @endif
                        </h3>
                        <span hidden>
                            {{ $sale = ($dataProduct->price * $dataProduct->sale) / 100 }}
                        </span>
                        <p>
                            @foreach ($price_material as $data)
                                <div id="ww{{ $data->size_Id }}" style="height: 30px;display: none">
                                    <p style="text-decoration: line-through">{{ number_format($data->price) }}<sup>đ</sup>
                                    </p>
                                    <p style="color: red;font-size: 25px;font-weight: bold;margin-top: -30px">
                                        {{ number_format($data->price - $data->price * ($data->sale / 100)) }}<sup>đ</sup>
                                    </p>
                                    <input type="text" hidden value="{{ $data->price }}" name=""
                                        id="db_price{{ $data->size_Id }}">
                                </div>
                            @endforeach
                        </p>
                        <p>
                            @foreach ($price_material2 as $data)
                                <div id="bb{{ $data->size_Id }}" style="height: 30px;display: none">
                                    <p style="text-decoration: line-through">{{ number_format($data->price) }}<sup>đ</sup>
                                    </p>
                                    <p style="color: red;font-size: 25px;font-weight: bold;margin-top: -30px">
                                        {{ number_format($data->price - $data->price * ($data->sale / 100)) }}<sup>đ</sup>
                                    </p>
                                    <input type="text" hidden value="{{ $data->price }}" name=""
                                        id="mn_price{{ $data->size_Id }}">
                                </div>
                            @endforeach
                        </p>
                        <span hidden>
                            {{ $sale = ($dataProduct->price * $dataProduct->sale) / 100 }}
                        </span>

                        <div>
                            <br>
                            {{-- <p style="" id="myContent" class="text-capitalize nameContent my-1">
                                {{ $dataProduct->description }}
                            </p>
                            <div style="" class="m-auto text-center">
                                <a onclick="myFunctionHide()" id="buttonHide"
                                    style="color: blue; cursor: pointer; display: none;">Ấn</a>
                                <a onclick="myFunctionShow()" id="buttonShow" style="color: blue; cursor: pointer;">Hiển
                                    thị</a>
                            </div> --}}


                            <div class="single-product-form">
                                <form action="{{ route('client.storeCart') }}" method="POST">
                                    @csrf
                                    <input type="text" name="price" hidden id="total_price">
                                    <span style="font-size: 18px;font-weight: bold">Chất liệu:</span><br> <br>
                                    <div style="display: inline-flex;margin-bottom: 10px">
                                        @foreach ($material as $bla)
                                            <div style="width: 200;height: 30px;">
                                                <input name="material_id" id="hihi{{ $bla->id_material }}" type="radio"
                                                    value="{{ $bla->id_material }}" style="width: 20px;height:20px"
                                                    id=""> <span style="font-weight: bold">Chất liệu
                                                    {{ $bla->name_Material }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="hienthi_size" style="display: none">
                                        <p>Kích thước:</p>
                                        @foreach ($price_material as $data)
                                            <input style="cursor: pointer;width: 30px" type="radio" name="size_id"
                                                value="{{ $data->size_Id }}" id="{{ $data->size_Id }}"><span
                                                style="margin-left: 10px;font-weight: bold">{{ $data->nameSize }}
                                            </span><br>
                                            {{-- <div id="LL{{ $data->size }}" style="display: none">
                                                    <input type="text" name="price" id=""
                                                        value="{{ $data->price }}">
                                                </div> --}}
                                        @endforeach
                                    </div>
                                    <div id="hienthi_size2" style="display: none">
                                        <p>Kích thước:</p>
                                        @foreach ($price_material2 as $data)
                                            <input style="cursor: pointer;width: 30px" type="radio" name="size_id"
                                                value="{{ $data->size_Id }}" id="size{{ $data->size_Id }}"><span
                                                style="margin-left: 10px;font-weight: bold">{{ $data->nameSize }}
                                            </span><br>
                                        @endforeach
                                    </div>
                                    <br>
                                    <div style="display: inline-flex;">
                                        @foreach ($product_color as $key => $item)
                                            <div
                                                style="background: {{ $item->name_Color }};width: 30px;height: 30px;margin-left:10px;border-radius: 100%">
                                                <input onclick="changeColor({{ $key }})"
                                                    style="opacity: 0;width: 100%;cursor: pointer;"
                                                    id="icon{{ $item->id }}" name="color_id" type="radio"
                                                    value="{{ $item->color_id }}"
                                                    style="width: 20px;height:20px; cursor: pointer;" id="">
                                                <div style="margin-left: 9px" class="iconCheck iconCheck{{ $key}}"
                                                    style="display: none;z-index: inherit;">
                                                    <i style="color: white" class="fas fa-check"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <script>
                                        let iconElemetRadio = document.getElementById("icon1")
                                        let showiconElementDiv = document.getElementById("showicon1")
                                        let icon2ElemetRadio = document.getElementById("icon2")
                                        let showicon2ElementDiv = document.getElementById("showicon2")
                                        const changeColor = function(key) {
                                            document.querySelectorAll('.iconCheck').forEach((e, key) => {
                                                e.style.display = "none"
                                            })
                                            document.querySelectorAll('.iconCheck')[key].style.display = "block"
                                        }
                                    </script>
                                    <br>
                                    <br>
                                    <input hidden type="text" value="{{ $dataProduct->id }}" name="productId"
                                        id="">
                                    <input hidden type="text" value="{{ Auth::user() ? Auth::user()->id : '' }}"
                                        name="userId" id="">
                                    {{-- <input hidden type="text" value="{{ $dataProduct->price }}" name="price"
                                    id=""> --}}
                                    <input type="number" name="quantity" min="1" max="5" value="1"
                                        placeholder="0">
                                    <br>
                                    <button class="btn btn-warning p-2" style="border-radius: 20px;font-weight: bold">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                    <br> <br>
                                </form>
                                <p><strong>Categories: </strong>
                                    @foreach ($cate as $data)
                                        @if ($data->id == $dataProduct->category_id)
                                            {{ $data->name }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <h4>Share:</h4>
                            <ul class="product-share">
                                <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href=""><i class="fab fa-twitter"></i></a></li>
                                <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                                <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end single product -->

        <div style="margin-left: 400px;margin-bottom: 20px; " class="comment">
            <h5 style="font-weight: bold;color: green">Viết đánh giá của bạn </h5>
            <br><br>
            @if (Auth::user())
                <form action="{{ route('client.storeComment') }}" method="POST">
                    @csrf
                    <div style="background: blanchedalmond;position: relative;" class="stars">
                        {{-- <form action=""> --}}
                        <div style="position: absolute;top: -50px;left: 50px;">

                            <input class="star star-5" id="star-5" value="5" type="radio" name="rating" />
                            <label class="star star-5" for="star-5"></label>
                            <input class="star star-4" id="star-4" value="4" type="radio" name="rating" />
                            <label class="star star-4" for="star-4"></label>
                            <input class="star star-3" id="star-3" value="3" type="radio" name="rating" />
                            <label class="star star-3" for="star-3"></label>
                            <input class="star star-2" id="star-2" value="2" type="radio" name="rating" />
                            <label class="star star-2" for="star-2"></label>
                            <input class="star star-1" id="star-1" value="1" type="radio" name="rating" />
                            <label class="star star-1" for="star-1"></label>
                        </div>
                        {{-- </form> --}}
                    </div> <br>
                    <input hidden type="text" name="user_id" value="{{ Auth::id() }}" id="">
                    <input hidden type="text" name="product_id" value="{{ $dataProduct->id }}" id="">
                    <img style="border-radius: 5px" src="{{ asset(Auth::user()->avatar) }}" width="50px"
                        alt="">
                    <input type="text"
                        style="width: 500px;height: 50px;border-radius: 5px;border: solid 1px gray;font-size: 20px"
                        name="content" value="" placeholder="Viết bình luận" id="">

                    <button class="btn btn-success" style="height: 50px">Submit</button>
                    <span>
                        @if (session()->has('error_empty_comment'))
                            <p style="color: red;margin-left: 50px">{{ session()->get('error_empty_comment') }}</p>
                        @endif
                    </span>
                </form>
            @else
                <p style="color: gray">Vui lòng đăng nhập để sử dụng tính năng này</p>
            @endif
            @foreach ($comment as $data)
                <div style="margin-top: 40px;width: 100%;display: flex;float: left">

                    <div style="width: 50px">
                        <img src="{{ asset($data->avatar) }}" width="50px" alt=""> <br>
                    </div>
                    <div style="margin-left:20px;">
                        <span style="font-weight:bold">{{ $data->name }}</span> &emsp;
                        @if ($data->rating == 1)
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                        @elseif ($data->rating == 2)
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                        @elseif ($data->rating == 3)
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                        @elseif ($data->rating == 4)
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                        @elseif ($data->rating == 5)
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                            <i style="color: #FD4;font-size: 10px" class="fas fa-star"></i>
                        @elseif ($data->rating == 0)
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                            <i style="color: gray;font-size: 10px;" class="fas fa-star"></i>
                        @endif
                        <br>
                        <span>{{ $data->content }}</span> <br>
                        <span style="font-size: 13px"><a href="#">thích</a></span>
                        <span style="font-size: 13px;margin-left: 5px"><a href="#">phản hồi</a></span>
                        @if ($data->user_id == Auth::id())
                            <span style="font-size: 13px;margin-left: 5px;display: inline-flex">
                                <form action="{{ route('client.deleteComment', $data->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('ban co chac muon xoa binh luan,')"
                                        style="background: transparent;border: 0;color: red">xóa</button>
                                </form>
                            </span>
                        @endif

                        <span style="font-size: 13px;color: gray;margin-left: 5px">{{ $data->dateComment }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- more products -->
        <div class="more-products mb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="section-title">
                            <hr>
                            <h3><span class="orange-text">Related</span> Products</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet
                                beatae optio.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($productCate as $data)
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{ route('client.single', $data->id) }}"><img
                                            src="{{ asset($data->avatar) }}" alt=""></a>
                                </div>
                                <h3>{{ $data->nameProduct }}</h3>
                                <p style="color: red" class="product-price"><span style="color: gray">Each product</span>
                                    {{ number_format($data->price_in_active) }}<sup>đ</sup> </p>
                                <form action="{{ route('client.addtocart') }}" method="POST">
                                    @csrf
                                    <input hidden type="text" name="nameProduct" value="{{ $data->nameProduct }}"
                                        id="">
                                    <input hidden type="text" name="price" value="{{ $data->price_in_active }}"
                                        id="">
                                    <input hidden type="text" value="{{ $data->id }}" name="productId"
                                        id="">
                                    <input hidden type="text" value="{{ Auth::user() ? Auth::user()->id : '' }}"
                                        name="userId" id="">
                                    <input type="number" hidden name="quantity" min="1" value="1"
                                        placeholder="0"> <br>

                                    {{-- <a href="{{ route('client.addtocart')}}" class="cart-btn"><i
                                        class="fas fa-shopping-cart"></i> Add to Cart</a> --}}

                                    <button style="background: transparent;border: 0">
                                        <a class="cart-btn">
                                            <i class="fas fa-shopping-cart"></i>Add to Cart
                                        </a>
                                    </button>
                                </form>
                                {{-- <a href="{{ route('client.single', $data->id) }}" class="cart-btn"><i
                                        class="fas fa-shopping-cart"></i> Add to Cart</a> --}}

                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
        <!-- end more products -->
        <input type="text" disabled name="" id="">

        <script>
            let id1ElemetRadio = document.getElementById("1")
            let id2ElemetRadio = document.getElementById("2")
            let id3ElemetRadio = document.getElementById("3")
            // 
            let size1ElemetRadio = document.getElementById("size1")
            let size2ElemetRadio = document.getElementById("size2")
            let size3ElemetRadio = document.getElementById("size3")
            // 
            let material1ElemetRadio = document.getElementById("hihi1")
            let material2ElemetRadio = document.getElementById("hihi2")
            // 
            let id1ElementDiv = document.getElementById("ww1")
            let id2ElementDiv = document.getElementById("ww2")
            let id3ElementDiv = document.getElementById("ww3")
            // 
            let id4ElementDiv = document.getElementById("bb1")
            let id5ElementDiv = document.getElementById("bb2")
            let id6ElementDiv = document.getElementById("bb3")
            // 
            // let haha1ElementDiv = document.getElementById("haha1")
            // let haha2ElementDiv = document.getElementById("haha2")
            let hienthi_sizeElementDiv = document.getElementById("hienthi_size")
            let hienthi_size2ElementDiv = document.getElementById("hienthi_size2")
            // 
            let total = document.getElementById("total_price")
            let db_price = document.getElementById("db_price")
            let mn_price = document.getElementById("mn_price")
            id1ElemetRadio.onchange = function() {
                if (this.checked) {
                    id1ElementDiv.style.display = "block"
                    console.log(db_price1.value);
                    total.value = db_price1.value;
                    id2ElementDiv.style.display = "none"
                    id3ElementDiv.style.display = "none"
                    // 
                    id4ElementDiv.style.display = "none"
                    id5ElementDiv.style.display = "none"
                    id6ElementDiv.style.display = "none"
                }
            }
            id2ElemetRadio.onchange = function() {
                if (this.checked) {
                    id2ElementDiv.style.display = "block"
                    console.log(db_price2.value);
                    total.value = db_price2.value;
                    id1ElementDiv.style.display = "none"
                    id3ElementDiv.style.display = "none"
                    // 
                    id5ElementDiv.style.display = "none"
                    id4ElementDiv.style.display = "none"
                    id6ElementDiv.style.display = "none"
                }
            }
            id3ElemetRadio.onchange = function() {
                if (this.checked) {
                    id3ElementDiv.style.display = "block"
                    total.value = db_price3.value;
                    id2ElementDiv.style.display = "none"
                    id1ElementDiv.style.display = "none"
                    // 
                    id6ElementDiv.style.display = "none"
                    id5ElementDiv.style.display = "none"
                    id4ElementDiv.style.display = "none"
                }

            }
            // size khac
            size1ElemetRadio.onchange = function() {
                if (this.checked) {
                    id4ElementDiv.style.display = "block"
                    console.log(mn_price1.value);
                    total.value = mn_price1.value;
                    id5ElementDiv.style.display = "none"
                    id6ElementDiv.style.display = "none"
                    // 
                    id1ElementDiv.style.display = "none"
                    id2ElementDiv.style.display = "none"
                    id3ElementDiv.style.display = "none"
                }
            }
            size2ElemetRadio.onchange = function() {
                if (this.checked) {
                    id5ElementDiv.style.display = "block"
                    console.log(mn_price1.value);
                    total.value = mn_price2.value;
                    id4ElementDiv.style.display = "none"
                    id6ElementDiv.style.display = "none"
                    // 
                    id2ElementDiv.style.display = "none"
                    id1ElementDiv.style.display = "none"
                    id3ElementDiv.style.display = "none"
                }
            }
            size3ElemetRadio.onchange = function() {
                if (this.checked) {
                    id6ElementDiv.style.display = "block"
                    console.log(mn_price1.value);
                    total.value = mn_price3.value;
                    id5ElementDiv.style.display = "none"
                    id4ElementDiv.style.display = "none"
                    // 
                    id3ElementDiv.style.display = "none"
                    id2ElementDiv.style.display = "none"
                    id1ElementDiv.style.display = "none"
                }
            }
            // chat kieu
            material1ElemetRadio.onchange = function() {
                if (this.checked) {
                    hienthi_sizeElementDiv.style.display = "block"
                    hienthi_size2ElementDiv.style.display = "none"

                }
            }
            material2ElemetRadio.onchange = function() {
                if (this.checked) {
                    hienthi_size2ElementDiv.style.display = "block"
                    hienthi_sizeElementDiv.style.display = "none"
                }
            }
        </script>

    @endsection
    <script type="text/javascript">
        // function changeImage(a) {
        //     console.log(document.getElementById("imgClick").src = "a");
        //     document.getElementById("imgClick").src = a;
        // }

        // function cong() {
        //     var val = document.getElementById("quantity").value;
        //     document.getElementById("quantity").value = parseInt(val) + 1;
        // }

        // function tru() {
        //     var val = document.getElementById("quantity").value;
        //     if (parseInt(val) > 1) {
        //         document.getElementById("quantity").value = parseInt(val) - 1;
        //     }
        // }

        function myFunctionShow() {
            var element = document.getElementById("myContent");
            element.classList.remove("nameContent");
            document.getElementById('buttonShow').style.display = 'none';
            document.getElementById('buttonHide').style.display = 'block';
        }

        function myFunctionHide() {
            var element = document.getElementById("myContent");
            element.classList.add("nameContent");
            document.getElementById('buttonShow').style.display = 'block';
            document.getElementById('buttonHide').style.display = 'none';
        }
    </script>
    <style>
        .hoverne:hover {
            color: #f33f3f;
        }

        .nameContent {
            display: block;
            display: -webkit-box;
            max-width: 100%;
            height: 44px;
            margin: 0 auto;
            font-size: 14px;
            /* line-height:  1; */
            -webkit-line-clamp: 7;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 12px;
            padding: 0px 4px;
        }

        div.stars {
            width: 270px;
            display: inline-block;
        }

        input.star {
            display: none;
        }

        label.star {
            float: right;
            padding: 3px;
            font-size: 23px;
            color: #444;
            transition: all .2s;
        }

        input.star:checked~label.star:before {
            content: '\f005';
            color: #FD4;
            transition: all .25s;
        }

        input.star-5:checked~label.star:before {
            color: #FE7;
            text-shadow: 0 0 20px #952;
        }

        input.star-1:checked~label.star:before {
            color: #F62;
        }

        label.star:hover {
            transform: rotate(-15deg) scale(1.3);
        }

        label.star:before {
            content: '\f006';
            font-family: FontAwesome;
        }

        /*  */
        /*  */
        /*  */
    </style>
