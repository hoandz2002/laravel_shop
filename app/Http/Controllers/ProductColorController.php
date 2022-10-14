<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public function index($product)
    {
        $color = Color::all();
        $categoryProducts = ProductColor::select('product_colors.*','colors.name_Color')
        ->where('product_colors.product_id','=',$product)
        ->join('colors','product_colors.color_id','=','colors.id')
        // ->get();
        ->Paginate(6);
        // dd($categoryProducts);
        return view('admin.product-colors.list', [
            'list_cate' => $categoryProducts,
            'product' => $product,
            'color' => $color

        ]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $oldProduct_color = ProductColor::where('product_colors.product_id','=',$request->product_id)
        ->get();
      
        foreach ($oldProduct_color as $value) {
            $value->delete();
        }
        for ($i = 0; $i < count($request->color_id); $i++) {
            $data = new ProductColor();
            $data->color_id = $request->color_id[$i];
            $data->product_id = $request->product_id;

            $data->save();
        }
        return redirect()->route('admin.productColors.list',$request->product_id);
    }
}
