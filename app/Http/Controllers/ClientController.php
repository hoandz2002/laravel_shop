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
use App\Models\Ship;
use App\Models\Size;
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
        $products = Product::Select('products.*')->search()->Paginate(6);

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
        $kk = Price_product::find($request->price_product_id);
        // dd($request->all());
        if (Auth::user()) {
            if ($request->quantity > $kk->quantity) {
                session()->flash('error', 'Không đủ số luọng trong kho');
                return redirect()->back();
            }
            // dd(2);
            $product = new Cart();
            $product->price_product_id = $request->price_product_id;
            $product->fill($request->all());
            // $price = Price_product::where('product_Id', '=', $request->productId)->where('price', '=', $request->price)
            //     ->get();
            $cartAllId = DB::table('carts')
                ->where('carts.userId', '=', Auth::user()->id)->get();
            // dd($cartAllId);
            foreach ($cartAllId as $data) {
                if ($request->productId) {
                    if ($request->material_id) {
                        if ($request->size_id == $data->size_id && $request->color_id == $data->color_id) {
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
                        }
                        elseif ($request->size_id == $data->size_id && $request->color_id != $data->color_id) {
                            $product = new Cart();
                            // dd($product);
                            $product->fill($request->all());
                            if ($request->color_id == null) {
                                session()->flash('error', 'vui lòng chọn màu sắc!');
                                return redirect()->back();
                            }
                            $product->save();
                            session()->flash('success', 'Thêm giỏ hàng thành công poil,mnb!');
                            return redirect()->route('client.cart');
                        } elseif (!$request->color_id && !$data->size_id) {
                            // dd(2);
                            $product = new Cart();
                            $product->fill($request->all());
                            if ($request->color_id == null) {
                                session()->flash('error', 'vui lòng chọn màu sắc!');
                                return redirect()->back();
                            }
                            $product->save();
                            session()->flash('success', 'Thêm giỏ hàng thành công oiuytrew!');
                            return redirect()->route('client.cart');
                        } elseif ($request->color_id == $data->color_id && $request->size_id != $data->size_id) {
                            // dd(2);
                            $product = new Cart();
                            $product->fill($request->all());
                            if ($request->color_id == null) {
                                session()->flash('error', 'vui lòng chọn màu sắc!');
                                return redirect()->back();
                            }
                            $product->save();
                            session()->flash('success', 'Thêm giỏ hàng thành công hihihi!');
                            return redirect()->route('client.cart');
                        } 
                    } 
                    else {
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
            ->select('price_products.*', 'sizes.nameSize', 'sizes.statusSize', 'products.sale', 'materials.name_Material')
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
        $coupon = Coupon::select('coupons.*')->get();
        $ships = Ship::all();
        $kk = Information::all();
        // dd($data);
        $address = Information::where('information.status', '=', 0)->get();
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
        if ($request->ship == null) {
            $abc = 1;
            $bla = Ship::find($abc);
            $request->ship = $request->ship_db + ($request->ship_db * ($bla->price_ship / 100));
        }
        $pice_ship = $request->ship;
        // $statement = DB::select("SHOW TABLE STATUS LIKE 'orders'");
        // $nextId = $statement[0]->Auto_increment;
        // \dd($nextId);        
        $order = new Order();
        $order->orderDate = date('Y-m-d');
        $order->oderStatus = 0;
        $order->total = $request->total + $request->ship;
        // dd($order->total);
        $order->orderShip = $request->ship;
        $order->user_id = Auth::user()->id;
        $order->orderName = $request->orderName;
        $order->oderEmail = $request->oderEmail;
        $order->phone = $request->phone;
        $order->address = $request->address;
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
}
