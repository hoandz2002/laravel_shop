<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function updateCartsl(Request $request,$cart)
    {
        // dd($request->all());
        $data = Cart::find($cart);
        $data->quantity = $request->quantity;
        $data->save();
        // \dd($cart);
        session()->flash('success', 'Cập nhật giỏ hàng thành công kkk!');
        return redirect()->back();
    }
}
