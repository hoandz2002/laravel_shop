<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\CategoryProduct;
use App\Models\Color;
use App\Models\GalleryImag;
use App\Models\GalleryImage;
use App\Models\Material;
use App\Models\Price;
use App\Models\Price_product;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::join('category_products', 'products.category_id', '=', 'category_products.id')
        //     ->join('sizes', 'products.size_id', '=', 'sizes.id')->where('statusCate', '=', 0)
        //     ->select('products.*', 'category_products.name', 'sizes.nameSize')
        //     ->search()
        //     ->Paginate(6);
        $products = Product::select('products.*', 'category_products.name')
            ->join('category_products', 'products.category_id', '=', 'category_products.id')
            ->orderBy('products.id', 'DESC')
            ->search()->paginate(6);
        $price = DB::table('price_products')->join('products', 'price_products.product_Id', '=', 'products.id')
            ->where('products.id', '=', 'product_Id')
            ->get();
        // dd($products);
        return view('admin.products.list', compact('products', 'price'));
    }
    public function create()
    {
        $cate = CategoryProduct::all()->where('statusCate', '=', 0);
        $sizes = Size::all()->where('statusSize', '=', 0);
        $material = Material::all();
        $color = Color::all();

        return view('admin.products.create', compact('cate', 'sizes', 'material', 'color'));
    }

    public function store(ProductRequest $request)
    {
        dd($request->all());
        $product = new Product();
        $product->fill($request->all());
        // 2. Kiểm tra file và lưu
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = '_' . $avatarName;
            $product->avatar = $avatar->storeAs('/images/products', $avatarName);
            // Storage::disk('local')->put('/images/products'. $avatarName, file_get_contents($request->avatar));
            // dd($product->avatar);
            // dd(Storage::url('images/products/'. $avatarName));
        } else {
            $product->avatar = 'http://127.0.0.1:8000/images/products/_szgm3jII0paoZo4U2L3uPG15MdBDHeNb44NZwizX.jpg';
            // session()->flash('error', 'Vui lòng thêm ảnh');
            // return redirect()->back();
        }
        $product->save();
        // 3. Lưu $product vào CSDL
        $files = [];
        if ($request->hasFile('filenames')) {
            foreach ($request->file('filenames') as $file) {

                $name = $file->getClientOriginalName();
                $file->move(public_path('images/GalleryProducts'), $name);
                $files[] = $name;
                $images = new GalleryImage();
                foreach ($files as $ok) {
                    $images->image_gallery = 'images/GalleryProducts/' . $ok;
                }

                $images->product_id = $product->id;
                $images->save();
            }
        }

        for ($i = 0; $i < count($request->size_Id); $i++) {
            $data = new Price_product();
            $data->size_Id = $request->size_Id[$i];
            $data->material_Id = $request->material_Id[$i];
            $data->price = $request->price[$i];
            $data->product_Id = $product->id;
            $data->save();
        }
        // 
        for ($i = 0; $i < count($request->color_id); $i++) {
            $data = new ProductColor();
            $data->color_id = $request->color_id[$i];
            $data->product_id = $product->id;
            $data->save();
        }

        session()->flash('success', 'Bạn đã thêm mới thành công!');
        return redirect()->route('products.list');
    }
    public function delete($product)
    {
        $data = Product::find($product);
        $trongloz = DB::table('price_products')->where('product_Id', '=', $product)->get();
        // dd($trongloz);
        $price = Price_product::all()->where('product_Id', '=', $product);
        foreach ($price as $db) {
            $db->delete();
        }
        $data->delete();
        return redirect()->route('products.list');
    }
    public function edit(Product $product)
    {
        $material = Material::all();
        $color = Color::all();

        $cate = CategoryProduct::all()->where('statusCate', '=', 0);
        $sizes = Size::all()->where('statusSize', '=', 0);
        $price_pro = DB::table('price_products')
            ->where('product_Id', '=', 12)
            ->select('price_products.*')
            ->get();
        // dd($price_pro);
        return view('admin.products.create', compact('product', 'cate', 'sizes', 'price_pro', 'color', 'material'));
    }
    public function update(ProductRequest $request, $product)
    {
        // dd($request->all());
        $data = Product::find($product);
        $data->price_in_active = $request->price_in_active;
        $data->fill($request->all());
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = $request->category_id . '_' . $avatarName;
            $data->avatar = $avatar->storeAs('images/products', $avatarName);
        } else {
            $data->avatar = $data->avatar;
        }
        $files = [];
        if ($request->hasFile('filenames')) {
            foreach ($request->file('filenames') as $file) {
                $images = new GalleryImage();
                $name = $file->getClientOriginalName();
                $file->move(public_path('images/GalleryProducts'), $name);
                $files[] = $name;
                foreach ($files as $ok) {
                    $images->image_gallery = 'images/GalleryProducts/' . $ok;
                }
                $images->product_id = $data->id;
                $images->save();
            }
        }
        $request->category_id ? $data->category_id = $request->category_id : $data->category_id = $data->category_id;
        $request->statusPrd ? $data->statusPrd = $request->statusPrd : $data->statusPrd = $data->statusPrd;

        $data->save();
        // update size 

        session()->flash('success', 'Bạn đã sửa thành công!');
        return redirect()->route('products.list');
    }
    public function listProductDetail($id)
    {
        $material = Material::all();
        // dd($material);
        $sizes = Size::all()->where('statusSize', '=', 0);
        // dd($id);
        $products = Price_product::select('price_products.*', 'products.nameProduct', 'products.avatar', 'sizes.nameSize', 'materials.name_Material')
            ->join('sizes', 'price_products.size_Id', '=', 'sizes.id')
            ->join('materials', 'price_products.material_Id', '=', 'materials.id_material')
            ->join('products', 'price_products.product_Id', '=', 'products.id')
            ->where('price_products.product_id', '=', $id)
            ->get();
        // dd($product);
        return view('admin.products.product_detail', compact('products','id','sizes','material'));
    }
    public function edit_productDetail($id)
    {
        $material = Material::all();
        // dd($material);
        $sizes = Size::all()->where('statusSize', '=', 0);
        // 
        $price_pro = DB::table('price_products')
            ->where('price_products.id', '=', $id)
            ->join('products', 'price_products.product_Id', '=', 'products.id')
            ->join('sizes', 'price_products.size_Id', '=', 'sizes.id')
            ->join('materials', 'price_products.material_Id', '=', 'materials.id_material')
            ->select('price_products.*', 'sizes.nameSize', 'materials.name_Material','products.nameProduct')
            ->get();
        // dd($price_pro);
        return view('admin.products.create_productDetail', compact('price_pro','material','sizes'));
    }
    public function update_productDetail ($id,Request $request)
    {
        // dd($request->all());
        $product = Price_product::find($id);
        $product->product_Id = $request->product_Id;
        $product->size_Id = $request->size_Id;
        $product->material_Id = $request->material_Id;
        $product->price = $request->price;

        $product->save();
        return redirect()->route('admin.datailProduct.list',$request->product_Id);
    }
    public function create_productDetail(Request $request)
    {
        $material = Material::all();
        // dd($material);
        $sizes = Size::all()->where('statusSize', '=', 0);
        // dd($request->all());
        return view('admin.products.create_detail',compact('sizes','material'));
    }
    public function store_productDetail(Request $request)
    {
        $product=new Price_product();
        $product ->fill($request->all());
        $product->save();
        return redirect()->back();
    }
    public function delete_productDetail($id)
    {
        $data=Price_product::find($id);
        $data->delete();
        return redirect()->back();

    }
}
