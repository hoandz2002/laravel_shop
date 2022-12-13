<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Price_product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function updateCartsl(Request $request, $cart)
    {

        // $data = Cart::find($cart);
        // $price_product = Price_product::find($data->price_product_id);
        // // dd($price_product->quantity);
        // if ($request->quantity > $price_product->quantity) {
        //     session()->flash('error', 'Số lượng không có sẵn trong kho hàng');
        //     return redirect()->back();
        // }elseif($request->quantity == 0){
        //     session()->flash('error', 'Số lượng không được để trông!');
        //     return redirect()->back();
        // } 
        // else {
        //     $data->quantity = $request->quantity;
        //     $data->save();
        //     // \dd($cart);
        //     session()->flash('success', 'Cập nhật giỏ hàng thành công kkk!');
        //     return redirect()->back();
        // }
        // dd($request->all());
        // dd($cart);
        $data = Cart::find($cart);
        $price_product = Price_product::find($data->price_product_id);
        if ($request->so_luong_update > $price_product->quantity) {
            $message = 'Số lượng không có sẵn trong kho hàng';
        } elseif ($request->so_luong_update == 0) {
            $message = 'Số lượng không được để trông!';
        } else {
            $data->quantity = $request->so_luong_update;
            $data->save();
            // \dd($cart);
            $message = 'Cập nhật giỏ hàng thành công';
        }
        // dd($message);
        // dd($request->all());
        return response()->json(['success' => true, 'thong_diep' => $message]);
    }
}
