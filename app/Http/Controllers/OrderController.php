<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $mass = 0;
        $total = 0;
        $ship = 0;
        $data = Order::select(
            'id',   
            'orderDate',
            'user_id',
            'oderStatus',
            'phone',
            'address',
            'oderEmail',
            'orderName',
            'total',
        )
            // ->cursorPaginate(5);
            ->orderBy('orders.id', 'DESC')
            ->paginate(10);
            foreach ($data as $item) {
                $mass += $item->quantity * $item->mass;
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
            // dd($data);
        // dd($usersPaginate);
        return view('admin.order.list',compact('data','ship','mass'));
    }
    public function updateStatusOrder(Request $request, $order) {
        // dd($request->all());
        $data = Order::find($order);
        $data->oderStatus = $request->oderStatus;
        // dd($data->oderStatus);
        // dd($data->orderStatus);
        session()->flash('sucssec','đơn hàng đã được cập nhật');
        $data->save();
        return redirect()->route('admin.orders.list');
    }
    public function showOrder()
    {
        $data = Order::all()->where('user_id','=',Auth::id());
           
        return view('KH.order', [
            'order_list' => $data,
        ]);
    }
    
}
