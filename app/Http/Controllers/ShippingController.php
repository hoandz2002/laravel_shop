<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $data = Shipping::join('orders','orders.id','=','shippings.order_id')
        ->select('shippings.*','orders.id as order_id')->search()->paginate(6);
        return view('admin.shippings.index',compact('data'));
    }
}
