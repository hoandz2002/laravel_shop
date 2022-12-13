<?php

namespace App\Http\Controllers;

use App\Jobs\SendMaid;
use App\Models\Order;
use App\Models\Return_detail;
use App\Models\Shipping;
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
        $data = Order::select('orders.*')
            // ->where('orders.oderStatus', '<', 6)
            ->orderBy('orders.id', 'DESC')
            ->paginate(10);
        // dd($data);
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
        $haha = 'CODESHIP' . rand(100, 100000);
        $data = Order::find($order);
        if ($request->oderStatus == 1) {
            // insert shipping
            $shipping = new Shipping();
            $shipping->code_ship = $haha;
            $shipping->status = 2;
            $shipping->order_id = $order;
            // save shipping
            $shipping->save();
            $data->oderStatus = $request->oderStatus;
            session()->flash('sucssec', 'đơn hàng đã được cập nhật');
            $data->save();
            return redirect()->back();
        }
        if ($request->oderStatus == 2) {
            if ($data->code_ship == null) {
                session()->flash('error', 'Đơn hàng chưa được gửi đi!');
                return redirect()->back();
            }
        }
        $status_order = Shipping::where('shippings.code_ship', '=', $data->code_ship)
            ->select('shippings.*')
            ->get();
        // dd($status_order);
        foreach ($status_order as $value) {
            if ($request->oderStatus == 3 && $value->status != 1) {
                // dd(2);
                session()->flash('error', 'Khách hàng chưa nhận được đơn hàng!');
                return redirect()->back();
            } elseif ($request->oderStatus == 5 && $value->status == 1) {
                // dd(3);
                session()->flash('error', 'Khách hàng chưa thanh toán!');
                return redirect()->back();
            } elseif ($request->oderStatus == 5 && $value->status == 0) {
                // dd(4);
                session()->flash('error', 'Khách hàng chưa nhận được đơn hàng');
                return redirect()->back();
            } elseif ($data->oderStatus == 1) {
                // dd(5);   
                $data->oderStatus = $request->oderStatus;
                session()->flash('sucssec', 'đơn hàng đã được cập nhật');
                $data->save();
                SendMaid::dispatch($request->oderEmail)->delay(now()->addSeconds(2));
                return redirect()->back();
            } else {
                $data->oderStatus = $request->oderStatus;
                session()->flash('sucssec', 'đơn hàng đã được cập nhật');
                $data->save();
                return redirect()->back();
            }
        }
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
    public function add_code_ship(Request $request)
    {
        $data_code_ship = Shipping::where('code_ship', '=', $request->code_ship)->get();
        if (count($data_code_ship) < 1) {
            session()->flash('error', 'Mã vận đơn không tồn tại');
            return redirect()->back();
        } else {
            $order = Order::find($request->id_order);
            $order->code_ship = $request->code_ship;
            $order->save();
            session()->flash('sucssec', 'Đơn hàng đã được thêm mã vận đơn!');
            return redirect()->back();
        }
    }
}
