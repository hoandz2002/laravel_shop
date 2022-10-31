<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Return_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
  public function index($order, Request $request)
  {
    // dd($order);
    $mass = 0;
    $ship = 0;
    $total = 0;
    $price_sale = 0;
    // dd($request->all());

    $total_price = $request->oddPricePrd;
    // dd($total_price);
    $orders = OrderDetail::select('order_details.*', 'products.*')
      ->join('products', 'order_details.product_id', '=', 'products.id')
      ->where('order_id', '=', $order)
      // ->join('price_products','order_details.product_id','=','price_products.product_Id')
      // ->where('order_details.product_id','=','price_products.product_Id')
      ->get();
    // dd($orders);
    foreach ($orders as $item) {
      $price_sale += ($item->oddPricePrd - ($item->oddPricePrd * $item->sale) / 100) * $item->oddQuantityPrd;
      // $total += $item->oddQuantityPrd * $item->oddPricePrd;
      $mass += $item->mass * $item->oddQuantityPrd;
    }
    // dd($price_sale);
    // dd($total);
    // dd($mass);
    if ($mass <= 10) {
      $ship = 50000;
    } elseif ($mass <= 30) {
      $ship = 150000;
    } elseif ($mass <= 60) {
      $ship = 300000;
    } else {
      $ship = 500000;
    }
    // dd($ship);
    $data = Order::find($order);
    // dd($data);
    return view('admin.order.detail', compact('orders', 'data', 'total', 'mass', 'order', 'ship', 'total_price', 'price_sale'));
  }
  public function detail($order, Request $request)
  {
    // dd($order);
    // dd($request->all());
    $mass = 0;
    $ship = $request->orderShip;
    $total = 0;
    $price_sale = 0;
    // dd($request->all());

    $total_price = $request->oddPricePrd;
    // dd($total_price);
    $orders = OrderDetail::select('order_details.*', 'products.*')
      ->join('products', 'order_details.product_id', '=', 'products.id')
      ->where('order_id', '=', $order)
      // ->join('price_products','order_details.product_id','=','price_products.product_Id')
      // ->where('order_details.product_id','=','price_products.product_Id')
      ->get();
    // dd($orders);
    foreach ($orders as $item) {
      $price_sale += ($item->oddPricePrd - ($item->oddPricePrd * $item->sale) / 100) * $item->oddQuantityPrd;
      // $total += $item->oddQuantityPrd * $item->oddPricePrd;
      $mass += $item->mass * $item->oddQuantityPrd;
    }
    $data = Order::find($order);
    // dd($data);
    return view('KH.detail', compact('orders', 'data', 'total', 'mass', 'order', 'ship', 'total_price', 'price_sale'));
  }
  public function updateStatusOrder($order)
  {
    // dd($order);
    $updateStatus = Order::find($order);
    if ($updateStatus->oderStatus == 0) {
      $updateStatus->oderStatus = 4;
    } elseif ($updateStatus->oderStatus == 1) {
      $updateStatus->oderStatus = 4;
    } elseif ($updateStatus->oderStatus == 2) {
      $updateStatus->oderStatus = 3;
    } elseif ($updateStatus->oderStatus == 3) {
      $id_Order = $order;
      // session()->flash('danger', 'Bạn không thể hủy đơn');
      return redirect()->route('client.create', $id_Order);
    } elseif ($updateStatus->oderStatus == 5) {
      $id_Order = $order;
      $updateStatus->oderStatus = 6;
      $updateStatus->save();
      return redirect()->route('client.returnProducts.create', $id_Order);
    } 

    $updateStatus->save();
    session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
    return redirect()->route('client.showOrder');
  }
  
}
