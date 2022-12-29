<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Price_product;
use App\Models\Return_detail;
use App\Models\ReturnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
  public function index($order, Request $request)
  {
    // dd($order);
    // dd($request->all());
    $return = 0;
    if ($request->return) {
      $return = 1;
    }
    $mass = 0;
    $ship = $request->orderShip;
    $total = 0;
    $price_sale = 0;
    // dd($request->all());
    $coupon = $request->coupon;
    // dd($coupon);
    $total_price = $request->oddPricePrd;
    // dd($total_price);
    $orders = OrderDetail::select('order_details.*', 'products.*', 'price_products.*')
      ->join('products', 'order_details.product_id', '=', 'products.id')
      ->where('order_id', '=', $order)
      ->join('price_products', 'order_details.price_product_id', '=', 'price_products.id')
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
    return view('admin.order.detail', compact('orders', 'return', 'data', 'total', 'mass', 'order', 'ship', 'total_price', 'price_sale', 'coupon'));
  }
  public function detail($order, Request $request)
  {
    // dd($order);
    // dd($request->all());
    $return = 0;
    if ($request->return) {
      $return = 1;
    }
    $mass = 0;
    $ship = $request->orderShip;
    $total = 0;
    $price_sale = 0;
    // dd($request->all());
    $coupon = $request->coupon;
    // dd($coupon);
    $total_price = $request->oddPricePrd;
    // dd($total_price);
    $orders = OrderDetail::select('order_details.*', 'products.*', 'price_products.*')
      ->join('products', 'order_details.product_id', '=', 'products.id')
      ->where('order_id', '=', $order)
      ->join('price_products', 'order_details.price_product_id', '=', 'price_products.id')
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
    return view('KH.detail', compact('orders', 'return', 'data', 'total', 'mass', 'order', 'ship', 'total_price', 'price_sale', 'coupon'));
  }
  public function updateStatusOrder($order)
  {
    $data = OrderDetail::where('order_id', '=', $order)->get();
    // dd($data);
    // dd($order);
    $updateStatus = Order::find($order);
    if ($updateStatus->oderStatus == 0) {
      foreach ($data as $value) {
        $price_product = Price_product::find($value->price_product_id);
        $price_product->quantity = $value->oddQuantityPrd + $price_product->quantity;
        $price_product->save();
      }
      $updateStatus->oderStatus = 4;
    } elseif ($updateStatus->oderStatus == 1) {
      foreach ($data as $value) {
        $price_product = Price_product::find($value->price_product_id);
        $price_product->quantity = $value->oddQuantityPrd + $price_product->quantity;
        $price_product->save();
      }
      $updateStatus->oderStatus = 4;
    } elseif ($updateStatus->oderStatus == 2) {
      $updateStatus->oderStatus = 3;
    } elseif ($updateStatus->oderStatus == 3) {
      $id_Order = $order;
      // session()->flash('danger', 'Bạn không thể hủy đơn');
      return redirect()->route('client.create', $id_Order);
    } elseif ($updateStatus->oderStatus = 5) {
      $id_Order = $order;
      $data = Order::find($order);
      // dd($data);
      $now = date(now());
      $thoi_gian = $data->orderDate;
      // test
      $order_return = new ReturnProduct();
      $order_return->order_id = $order;
      $order_return->orderDate = date(now());
      $order_return->user_id = $data->user_id;
      $order_return->oderStatus = $data->oderStatus + 1;
      $order_return->phone = $data->phone;
      $order_return->address = $data->address;
      $order_return->oderEmail = $data->oderEmail;
      $order_return->orderName = $data->orderName;
      $order_return->orderShip = $data->orderShip;
      $order_return->total = $data->total;
      $order_return->save();

      return redirect()->route('client.returnProducts.create', $id_Order);
    }

    $updateStatus->save();
    session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
    return redirect()->route('client.showOrder');
  }
}
