<?php

namespace App\Http\Controllers;

use App\Jobs\SendMaid;
use App\Models\Order;
use App\Models\Return_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $return_detail = Return_detail::select('return_details.*')
            ->join('orders', 'return_details.order_id', '=', 'orders.id')
            ->get();
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
            ->where('orders.oderStatus', '<', 6)
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
        return view('admin.order.list', compact('data', 'ship', 'mass'));
    }
    public function updateStatusOrder(Request $request, $order)
    {
        // dd($request->all());
        $data = Order::find($order);
        // dd($data);
        $data->oderStatus = $request->oderStatus;
        session()->flash('sucssec', 'đơn hàng đã được cập nhật');
        $data->save();
        if ($data->oderStatus == 1) {
            SendMaid::dispatch($request->oderEmail)->delay(now()->addSeconds(2));
            return redirect()->route('admin.orders.list');
        }
        return redirect()->back();
    }
    public function showOrder()
    {
        // $data = Order::all()->where('user_id', '=', Auth::id())->where('orders.oderStatus', '<', 7);
        $data = Order::select('orders.*')
        ->where('user_id', '=', Auth::id())
        ->where('orders.oderStatus', '<', 7)
        ->get();
        return view('KH.order', [
            'order_list' => $data,
        ]);
    }
    public function orderReturn()
    {
        $data = Order::select('orders.*')
        ->where('user_id', '=', Auth::id())
        ->where('orders.oderStatus', '>', 6)
        ->get();
        // dd($data);
        return view('KH.order_return', [
            'order_list' => $data,
        ]);
    }
}
