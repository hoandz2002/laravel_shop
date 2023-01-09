<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UserRequest;
use App\Jobs\SendMaid;
use App\Models\Cart;
use App\Models\CategoryProduct;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Information;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Price_product;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Purse;
use App\Models\Ship;
use App\Models\Shipping;
use App\Models\Size;
use App\Models\Transaction;
use App\Models\User;
use DateTime;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function test()
    {
        return view('test');
    }
    // 
    public function index()
    {
        $product = Product::select('products.*')
            //    ->join('price_products','products.id','=','price_products.product_Id')
            ->skip(0)->take(6)->get();

        // dd($product);
        return view('KH.index', [
            'product' => $product
        ]);
    }
    public function contact()
    {
        return view('KH.contact');
    }
    public function storeContact(ContactRequest $request)
    {
        $contact = new Contact();

        $contact->fill($request->all());
        $contact->save();
        session()->flash('success', 'bạn đã gửi thành công');
        return redirect()->route('client.contact');
    }
    public function shop()
    {
        $cate = CategoryProduct::all();
        $sizes = Size::all();
        $products = Product::Select('products.*')->where('statusPrd', '=', 0)->search()->Paginate(6);

        return view('KH.shop', compact('products', 'cate', 'sizes'));
    }

    public function about()
    {
        return view('KH.about');
    }
    public function new()
    {
        return view('KH.news');
    }
    public function cart(Request $request)
    {
        // dd($request->all());
        $mass = 0;
        $total = 0;
        $ship = 0;
        $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'products.mass', 'products.sale', 'sizes.nameSize', 'materials.name_Material', 'colors.name_Color', 'price_products.sale_value', 'price_products.type_sale')
            ->join('price_products', 'carts.price_product_id', '=', 'price_products.id')
            ->join('products', 'carts.productId', '=', 'products.id')
            ->join('sizes', 'price_products.size_Id', '=', 'sizes.id')
            ->join('colors', 'carts.color_id', '=', 'colors.id')
            ->join('materials', 'price_products.material_Id', '=', 'materials.id_material')
            ->where('userId', '=', Auth::user()->id)
            ->get();
        // dd($products);
        return view('KH.cart', compact('products', 'total', 'mass', 'ship'));
    }
    public function storeCart(Request $request)
    {
        // dd($request->all());
        if (!$request->material_id) {
            session()->flash('error', 'Chất liệu không được để trống');
            return redirect()->back();
        } elseif (!$request->size_id) {
            session()->flash('error', 'Size không được để trống');
            return redirect()->back();
        } elseif (!$request->color_id) {
            session()->flash('error', 'Màu sắc không được để trống');
            return redirect()->back();
        }
        // dd($request->all());
        $kk = Price_product::find($request->price_product_id);
        if (Auth::user()) {
            if ($request->quantity > $kk->quantity) {
                session()->flash('error', 'Không đủ số luọng trong kho');
                return redirect()->back();
            }
            // dd(1);

            $cartAllId = DB::table('carts')
                ->where('carts.userId', '=', Auth::user()->id)->get();
            // dd($cartAllId);
            foreach ($cartAllId as $data) {
                if ($request->productId == $data->productId) {
                    // dd(01);
                    if ($request->material_id == $data->material_id) {
                        // dd(12);
                        if ($request->size_id == $data->size_id && $request->color_id == $data->color_id) {
                            // dd(2);
                            $cartId = DB::table('carts')->where('carts.userId', '=', Auth::user()->id)
                                ->where('carts.productId', '=', $request->productId)
                                ->where('carts.size_id', '=', $request->size_id)
                                ->where('carts.color_id', '=', $request->color_id)
                                ->where('carts.material_id', '=', $request->material_id)
                                ->get();
                            // dd($cartId);
                            $number = $data->quantity + $request->quantity;
                            //dd($number);
                            $id = $cartId->pluck('id'); // Lấy ra mảng id
                            Cart::whereIn('id', $id)->update(['quantity' => $number]); // update các post có id trong mảng
                            session()->flash('success', 'Thêm vào giỏ hàng thành công!9999999999');
                            return redirect()->route('client.cart');
                        } else {
                            // dd(999);
                            $product = new Cart();
                            $product->fill($request->all());
                            if ($request->color_id == null) {
                                session()->flash('error', 'vui lòng chọn màu sắc!');
                                return redirect()->back();
                            }
                            $product->save();
                            session()->flash('success', 'Thêm giỏ hàng thành công lalla!');
                            return redirect()->route('client.cart');
                        }
                        // elseif ($request->size_id == $data->size_id && $request->color_id !== $data->color_id) {
                        //     dd(291002);
                        //     $product = new Cart();
                        //     // dd($product);
                        //     $product->fill($request->all());
                        //     if ($request->color_id == null) {
                        //         session()->flash('error', 'vui lòng chọn màu sắc!');
                        //         return redirect()->back();
                        //     }
                        //     $product->save();
                        //     session()->flash('success', 'Thêm giỏ hàng thành công poil,mnb!');
                        //     return redirect()->route('client.cart');
                        // } 
                        // elseif ($request->color_id !== $request->color_id && $request->size_id !== $data->size_id) {
                        //     dd(3);
                        //     $product = new Cart();
                        //     $product->fill($request->all());
                        //     if ($request->color_id == null) {
                        //         session()->flash('error', 'vui lòng chọn màu sắc!');
                        //         return redirect()->back();
                        //     }
                        //     $product->save();
                        //     session()->flash('success', 'Thêm giỏ hàng thành công oiuytrew!');
                        //     return redirect()->route('client.cart');
                        // } 
                        // elseif ($request->color_id == $data->color_id  && $request->size_id != $data->size_id) {
                        //     // dd(4);
                        //     $product = new Cart();
                        //     $product->fill($request->all());
                        //     if ($request->color_id == null) {
                        //         session()->flash('error', 'vui lòng chọn màu sắc!');
                        //         return redirect()->back();
                        //     }
                        //     $product->save();
                        //     session()->flash('success', 'Thêm giỏ hàng thành công hihihi!');
                        //     return redirect()->route('client.cart');
                        // }
                    } else {
                        // dd(5);
                        $product = new Cart();
                        $product->fill($request->all());
                        if ($request->color_id == null) {
                            session()->flash('error', 'vui lòng chọn màu sắc!');
                            return redirect()->back();
                        }
                        $product->save();
                        session()->flash('success', 'Thêm giỏ hàng thành công lalla!');
                        return redirect()->route('client.cart');
                    }
                } else {
                    // dd(6);
                    $product = new Cart();
                    $product->fill($request->all());
                    if ($request->color_id == null) {
                        session()->flash('error', 'vui lòng chọn màu sắc!');
                        return redirect()->back();
                    }
                    $product->save();
                    session()->flash('success', 'Thêm giỏ hàng thành công fgfdsdfg!');
                    return redirect()->route('client.cart');
                }
            }
            if (count($cartAllId) == 0) {
                // dd(987);
                $product = new Cart();
                $product->fill($request->all());
                if ($request->color_id == null) {
                    session()->flash('error', 'vui lòng chọn màu sắc!');
                    return redirect()->back();
                }
                $product->save();
                session()->flash('success', 'Thêm giỏ hàng thành công 55555555555!');
                return redirect()->route('client.cart');
            }
        } else {
            session()->flash('error_emty_user', 'Bạn cần đăng nhập tài khoản !');
            return redirect()->back();
        }
        dd('end');
    }
    public function deleteCart($products)
    {
        $data = Cart::find($products);
        $data->delete();
        return redirect()->back();
    }
    public function single($id)
    {
        $dataProduct = Product::find($id);
        $cate = CategoryProduct::all();
        $material = Material::all();
        $product_color = ProductColor::where('product_colors.product_id', '=', $id)
            ->join('colors', 'product_colors.color_id', '=', 'colors.id')
            ->select('product_colors.*', 'colors.*')->get();
        // dd($product_color);
        $price_material = Price_product::where('price_products.product_Id', '=', $id)
            ->where('price_products.material_Id', '=', 1)
            ->join('products', 'price_products.product_Id', '=', 'products.id')
            ->join('sizes', 'sizes.id', '=', 'price_products.size_Id')
            ->join('materials', 'materials.id_material', '=', 'price_products.material_Id')
            ->select('price_products.*', 'sizes.nameSize', 'sizes.statusSize', 'products.sale', 'materials.name_Material')
            ->get();
        // dd($price_material);
        $price_material2 = Price_product::where('price_products.product_Id', '=', $id)
            ->where('price_products.material_Id', '=', 2)
            ->join('products', 'price_products.product_Id', '=', 'products.id')
            ->join('sizes', 'sizes.id', '=', 'price_products.size_Id')
            ->join('materials', 'materials.id_material', '=', 'price_products.material_Id')
            ->select('price_products.*', 'sizes.nameSize', 'sizes.statusSize', 'sizes.id as size_id', 'products.sale', 'materials.name_Material')
            ->get();

        // dd($price_material2);
        $productCate = Product::where('category_id', '=', $dataProduct->category_id)->skip(0)->take(3)->get();
        $price_product = Price_product::where('product_Id', '=', $id)
            ->join('sizes', 'sizes.id', '=', 'price_products.size_Id')
            ->select('price_products.*', 'sizes.nameSize')
            ->get();
        $comment = Comment::select('comments.*', 'users.name', 'users.avatar')->join('users', 'users.id', '=', 'comments.user_id')
            ->join('products', 'products.id', '=', 'comments.product_id')
            ->where('comments.product_id', '=', $id)
            ->get();
        return view('KH.single-product', [
            'dataProduct' => $dataProduct,
            'cate' => $cate,
            'productCate' => $productCate,
            'comment' => $comment,
            'price_product' => $price_product,
            'price_material' => $price_material,
            'price_material2' => $price_material2,
            'material' => $material,
            'product_color' => $product_color,
        ]);
    }

    public function getSizeMate(Request $request)
    {
        $data = DB::table('price_products')
            ->join('sizes', 'price_products.size_Id', '=', 'sizes.id')
            ->where('product_Id', '=', $request->prd)->where('material_Id', '=', $request->mate)
            ->select('price_products.*', 'sizes.nameSize')
            ->get();
        $size = Size::all();
        $dataProduct = Product::find($request->prd);
        $check = 0;
        $show = '';
        $total = 0;

        foreach ($size as $el) {
            foreach ($data as $it) {
                if ($it->size_Id == $el->id) {
                    if ($it->type_sale == 2) {
                        $price_pr = $it->price;
                        $total = $it->price - $it->price * ($dataProduct->sale / 100) - $it->price * ($it->sale_value / 100);
                    } elseif ($it->type_sale == 1) {
                        $price_pr = $it->price;
                        $total = $it->price - $it->price * ($dataProduct->sale / 100) - $it->sale_value;
                    } else {
                        $price_pr = $it->price;
                        $total = $it->price - $it->price * ($dataProduct->sale / 100);
                    }
                    // dd($total);
                    $show .= "<div style='display: inline-flex'>
                                <button type='button' 
                                  class='btn btn-outline-danger clearCo color$it->id' onclick='clickRadio($it->id, $total,$price_pr)'>
                                      $it->nameSize
                                  <input style='cursor: pointer;width: 100%;opacity: 0;' type='radio'
                                      name='size_id' value='$it->size_Id'
                                      id='size$it->size_Id'>
                              </button>
                              </div>";
                    $check = 1;
                }
            }
            if ($check == 0) {
                $show .= " <button  type='button'
                class='btn border none' disable>
                    $el->nameSize
                <input disable style='cursor: pointer;width: 100%;opacity: 0;' type='radio'
                    name='size_id' value='$el->size_Id'
                    id='size$el->size_Id'>
            </button>";
            }
            $check = 0;
        }
        // dd($size);
        return response()->json(['show' => $show, 'size' => $size], 200);
    }
    public function storeComment(Request $request)
    {
        if ($request->content == null) {
            session()->flash('error_empty_comment', 'không được để trống bình luận');
            return redirect()->back();
        } else {
            $data = new Comment();
            $data->fill($request->all());
            $data->dateComment = date('Y-m-d');
            // dd($data->dateComment);
            // dd($request- >all());
            $data->save();
            return redirect()->back();
        }
    }
    public function deleteComment($product)
    {
        $data = Comment::find($product);
        // dd($data->id);
        $data->delete();
        return redirect()->back();
    }
    public function updateCart(Request $request, $id)
    {
        $data = Cart::find($id);
        dd($request->all());;
    }
    public function checkout(Request $request)
    {
        // dd($request->all());
        $coupon = Coupon::select('coupons.*')
            ->where('status', '=', 0)
            ->get();
        $ships = Ship::all();
        $kk = Information::all();
        // dd($data);
        $address = Information::where('information.status', '=', 0)->get();
        // $address_thaydoi = Information::where('information.status','=',2)->get();
        // dd($address_thaydoi);
        if ($request->id) {
            $price_coupon = 0;
            $id_cart = $request->id;
            $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')
                ->join('products', 'carts.productId', '=', 'products.id')
                ->where('userId', '=', Auth::user()->id)
                ->get();
            // dd($products);

            if (count($products) == 0) {
                session()->flash('error', 'Giỏi hàng hiện đang trống !');
                return redirect()->back();
            } else {
                $total = 0;
                $ship = 0;
                $mass = 0;
                // $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'products.price', 'products.mass')->join('products', 'carts.productId', '=', 'products.id')->where('userId', '=', Auth::user()->id)->get();
                $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')
                    // ->join('price_products', 'carts.productId', '=', 'price_products.product_Id')
                    ->join('products', 'carts.productId', '=', 'products.id')
                    ->where('userId', '=', Auth::user()->id)
                    ->get();

                // dd($products);
                foreach ($products as $data) {
                    $mass += $data->quantity * $data->mass;
                }
                if ($mass <= 10) {
                    $ship = 50000;
                } elseif ($mass <= 30) {
                    $ship = 150000;
                } elseif ($mass <= 60) {
                    $ship = 300000;
                } else {
                    $ship = 500000;
                }
                // dd($products);
                return view('KH.checkout', compact('kk', 'products', 'mass', 'total', 'ship', 'id_cart', 'price_coupon', 'ships', 'address', 'coupon'));
            }
        } else {
            session()->flash('empty_checkbok', 'Vui lòng chọn sản phẩm thanh toán !');
            return redirect()->back();
        }
    }
    public function ajax_ship(Request $request)
    {
        // dd($request->all());
        $voucher = Coupon::find($request->id_voucher);
        $giam_gia = $voucher->sale;
        // dd($giam_gia);
        return response()->json(['success' => true, 'giam_gia' => $giam_gia]);
    }
    public function check_coupon(Request $request)
    {
        // dd($request->all());
        $ships = Ship::all();
        $kk = Information::all();
        $address = Information::where('information.status', '=', 0)->get();
        $price_coupon = 0;
        $coupon = Coupon::select('coupons.*')->get();
        // dd($coupon);

        foreach ($coupon as $key => $item) {
            if ($request->code) {
                if ($item->code == $request->code) {
                    $id_cart = $request->id;
                    $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')
                        // ->join('price_products', 'carts.productId', '=', 'price_products.product_Id')
                        ->join('products', 'carts.productId', '=', 'products.id')
                        ->where('userId', '=', Auth::user()->id)
                        ->get();
                    if (count($products) == 0) {
                        session()->flash('error', 'Giỏi hàng hiện đang trống !');
                        return redirect()->back();
                    } else {
                        $total = 0;
                        $ship = 0;
                        $mass = 0;
                        // $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'products.price', 'products.mass')->join('products', 'carts.productId', '=', 'products.id')->where('userId', '=', Auth::user()->id)->get();
                        $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')
                            // ->join('price_products', 'carts.productId', '=', 'price_products.product_Id')
                            ->join('products', 'carts.productId', '=', 'products.id')
                            ->where('userId', '=', Auth::user()->id)
                            ->get();

                        // dd($products);
                        foreach ($products as $data) {
                            $mass += $data->quantity * $data->mass;
                        }
                        if ($mass <= 10) {
                            $ship = 50000;
                        } elseif ($mass <= 30) {
                            $ship = 150000;
                        } elseif ($mass <= 60) {
                            $ship = 300000;
                        } else {
                            $ship = 500000;
                        }
                        // dd($products);
                    }
                    $price_coupon = $item->sale;
                    // dd($price_coupon);
                    session()->flash('success', 'Đã thêm mã giảm giá thành công!');
                    return view('KH.checkout', compact('coupon', 'products', 'mass', 'total', 'ship', 'id_cart', 'price_coupon', 'kk', 'ships', 'address'));
                }
                // elseif ($request->code != $item->code) {
                //     dd('ma giam gia khong hop le');
                // }
            }
            if ($request->voucher) {
                if ($item->id == $request->voucher) {
                    $id_cart = $request->id;
                    $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')
                        // ->join('price_products', 'carts.productId', '=', 'price_products.product_Id')
                        ->join('products', 'carts.productId', '=', 'products.id')
                        ->where('userId', '=', Auth::user()->id)
                        ->get();
                    if (count($products) == 0) {
                        session()->flash('error', 'Giỏi hàng hiện đang trống !');
                        return redirect()->back();
                    } else {
                        $total = 0;
                        $ship = 0;
                        $mass = 0;
                        // $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'products.price', 'products.mass')->join('products', 'carts.productId', '=', 'products.id')->where('userId', '=', Auth::user()->id)->get();
                        $products = Cart::select('carts.*', 'products.nameProduct', 'products.avatar', 'price', 'products.mass', 'products.sale')
                            // ->join('price_products', 'carts.productId', '=', 'price_products.product_Id')
                            ->join('products', 'carts.productId', '=', 'products.id')
                            ->where('userId', '=', Auth::user()->id)
                            ->get();

                        // dd($products);
                        foreach ($products as $data) {
                            $mass += $data->quantity * $data->mass;
                        }
                        if ($mass <= 10) {
                            $ship = 50000;
                        } elseif ($mass <= 30) {
                            $ship = 150000;
                        } elseif ($mass <= 60) {
                            $ship = 300000;
                        } else {
                            $ship = 500000;
                        }
                        // dd($products);
                    }
                    $price_coupon = $item->sale;
                    // dd($price_coupon);
                    session()->flash('success', 'Đã thêm mã giảm giá thành công!');
                    return view('KH.checkout', compact('coupon', 'products', 'mass', 'total', 'ship', 'id_cart', 'price_coupon', 'kk', 'ships', 'address'));
                }
                //else {
                //     dd('khong duoc giam gia dau cu');
                // }
            }
        }
    }
    public function createOrder(Request $request)
    {
        // dd($request->all());
        $data = new Order();
        $data->orderDate = date('Y-m-d');
        $data->fill($request->all());
        $data->save();
        session()->flash('success', 'Bạn đã đặt hàng thành công');
        return redirect()->route('client.checkout');
    }
    public function storeOrder(OrderRequest $request)
    {
        // dd($request->all());
        if ($request->id_voucher) {
            $coupon = Coupon::find($request->id_voucher);
            if ($coupon->Minimum_bill > $request->total) {
                session()->flash('error', 'Voucher không hợp lệ. Vui lòng chọn lại');
                return redirect()->back();
            }
            if ($coupon->quantity < 1) {
                session()->flash('error', 'Voucher đã hết. Vui lòng chọn lại!');
                return redirect()->back();
            }
            $coupon->quantity = $coupon->quantity - 1;
            $coupon->save();
        }
        // dd('1');
        if ($request->ship_db === null) {
            // dd('kkk');
            $abc = 1;
            $bla = Ship::find($abc);
            $request->ship_db = $request->ship_mac_dinh;
        }
        // dd($request->vitien);
        if ($request->vitien == 0) {
            $pur = Purse::where('user_id', '=', Auth::user()->id)->first();
            $pur->surplus = $pur->surplus - ($request->total + $request->ship_db);
            // insert lich su chuyen tien
            $pur->save();
            $lich_su_hoan_tien = new Transaction();
            $lich_su_hoan_tien->date_time = Date(now());
            $lich_su_hoan_tien->content = "Thanh toán tiền hàng";
            $lich_su_hoan_tien->money = $request->total + $request->ship_db;
            $lich_su_hoan_tien->user_id = Auth::user()->id;
            $lich_su_hoan_tien->type = "Khách hàng thanh toán";
            $lich_su_hoan_tien->surplus = $pur->surplus;
            // save lich su haon tien
            $lich_su_hoan_tien->save();
        }
        // dd("end");
        // dd($request->ship_db);

        // $statement = DB::select("SHOW TABLE STATUS LIKE 'orders'");
        // $nextId = $statement[0]->Auto_increment;
        // \dd($nextId);        
        $order = new Order();
        $order->orderDate = date('Y-m-d');
        $order->oderStatus = 0;
        $order->total = $request->total + $request->ship_db;
        $order->coupon = $request->coupon;
        $order->orderShip = $request->ship_db;
        $order->user_id = Auth::user()->id;
        $order->orderName = $request->orderName;
        $order->oderEmail = $request->oderEmail;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->id_voucher = $request->id_voucher;
        // dd($request->total);
        $order->save();

        $carts = Cart::all()->where('userId', '=', Auth::user()->id);
        // 
        foreach ($request->id_cart as $value) {
            $cart_id = Cart::where('userId', '=', Auth::user()->id)
                ->where('carts.id', '=', $value)
                ->select('carts.*')
                ->get();
            foreach ($cart_id as $hihi) {
                $data = Price_product::find($hihi->price_product_id);
                $data->quantity = $data->quantity - $hihi->quantity;
                $data->save();
                // 
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $hihi->productId;
                $orderDetail->oddNamePrd = 'a';
                $orderDetail->oddPricePrd = $hihi->price;
                $orderDetail->oddQuantityPrd = $hihi->quantity;
                $orderDetail->price_product_id = $hihi->price_product_id;
                $orderDetail->save();
                $hihi->delete();
            }
        }
        session()->flash('success', 'Thanh toán hóa đơn thành công!');
        // SendMaid::dispatch($request->input('oderEmail'))->delay(now()->addSeconds(2));
        return redirect()->route('client.cart');
    }
    public function profile($user)
    {
        $data = User::find($user);
        return view('KH.profile', compact('data'));
        // dd('adu');
    }
    public function editProfile($id)
    {
        $user = User::find($id);
        return view('KH.editProfile', [
            'user' => $user,
        ]);
    }
    public function updateProfile(User $user, UserRequest $request)
    {
        $userEdit = User::find($user->id);
        // dd($request->all());
        $userEdit->name = $request->name;
        $userEdit->username = $request->username;
        $userEdit->password = $request->password;
        $userEdit->email = $request->email;

        $request->avatar ? $userEdit->avatar = $request->avatar : $userEdit->avatar = $userEdit->avatar;

        //
        if ($request->hasFile('avatar')) {
            $avatarName = $request->avatar->hashName();
            $avatarName = $request->username . '_' . $avatarName;
            $userEdit->avatar = $request->avatar->storeAs('images/users', $avatarName);
        } else {
            $userEdit->avatar = $userEdit->avatar;
        }
        $request->role ? $userEdit->role = $request->role : $userEdit->role = $userEdit->role;
        //
        $request->status ? $userEdit->status = $request->status : $userEdit->status = $userEdit->status;

        $userEdit->save();
        return redirect()->route('client.profile', Auth::id());
    }
    public function report($user)
    {
        $data = User::find($user);

        $data->status = 1;

        $data->save();
        return redirect()->route('logout');
    }
    public function addtocart(Request $request)
    {
        // dd($request->price);
        if (Auth::user()) {
            $product = new Cart();
            $product->fill($request->all());
            //
            $price = Price_product::where('product_Id', '=', $request->productId)->where('price', '=', $request->price)
                ->get();
            // dd($price);
            $cartAllId = DB::table('carts')
                ->join('products', 'carts.price', '=', 'products.price_in_active')
                ->join('price_products', 'carts.price', '=', 'price_products.price')
                ->where('carts.userId', '=', Auth::user()->id)->get();
            // dd($cartAllId);
            foreach ($cartAllId as $data) {
                if ($data->productId == $request->productId && $data->price_in_active != $request->price) {
                    $product = new Cart();
                    $product->fill($request->all());
                    $product->save();
                    session()->flash('success', 'Thêm giỏ hàng thành công !');
                    return redirect()->back();
                } elseif ($data->productId == $request->productId && $data->price_in_active == $request->price) {
                    $cartId = DB::table('carts')
                        ->where('carts.userId', '=', Auth::user()->id)
                        ->where('carts.productId', '=', $request->productId)
                        ->where('carts.price', '=', $request->price)
                        ->get();
                    $number = $data->quantity + $request->quantity;
                    // \dd($number);
                    $id = $cartId->pluck('id'); // Lấy ra mảng id
                    Cart::whereIn('id', $id)->update(['quantity' => $number]); // update các post có id trong mảng
                    session()->flash('success', 'Thêm vào giỏ hàng thành công !');
                    return redirect()->back();
                }
            }
            //
            $product->save();
            session()->flash('success', 'Thêm giỏ hàng thành công !');
            return redirect()->back();
        } else {
            session()->flash('error_emty_user', 'Bạn cần đăng nhập tài khoản !');
            return redirect()->back();
        }
    }

    // Cổng thanh toán 

    public function vnpay_payment()
    {
        $vnp_Url = "http://sandbox.vnpayment.vn/tryitnow/Home/CreateOrder";
        $vnp_Returnurl = "http://127.0.0.1:8000/checkout";
        $vnp_TmnCode = "70QY85KB"; //Mã website tại VNPAY 
        $vnp_HashSecret = "LNOGQXDDUFQHLZZQZRTJUEBLWPWWVWRL"; //Chuỗi bí mật

        $vnp_TxnRef = '1256'; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan don hang';
        $vnp_OrderType = 'Billpayment';
        $vnp_Amount = 20000 * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,


        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }
    public function execPostRequest($url, $data, $tien)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        $update = Purse::where('purses.user_id', '=', Auth::user()->id)->first();
        $update->surplus = $update->surplus + $tien;
        $update->save();
        return $result;
    }
    public function momo_payment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = $request->money;
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/purses/list";
        $ipnUrl = "http://127.0.0.1:8000/purses/list";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        // dd($signature);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data), $amount);
        // dd($result);
        $jsonResult = json_decode($result, true);  // decode json
        return redirect()->to($jsonResult['payUrl']);

        //Just a example, please check more in there
    }
}
