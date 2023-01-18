<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Price_product;
use App\Models\Return_detail;
use App\Models\ReturnProduct;
use App\Models\Voucher_hoan_tien;
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
  public function updateStatusOrder(Request $request, $order)
  {
    // dd($request->all());
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
      // $id_Order = $order;
      // return redirect()->route('client.create', $id_Order);
      $id_Order = $order;
      $odd_order = Order::find($order);
      // 
      $return_id = ReturnProduct::where('order_id', '=', $order)->where('oderStatus', '<=', 10)->get();
      // dd($return_id);
      if ($return_id->count() > 0) {
        session()->flash('error_empty', 'Bạn đã gửi yêu cầu hoàn trả và đang đợi hệ thống xác nhận!');
        return redirect()->back();
      }
      // 
      $order_return = new ReturnProduct();
      $order_return->order_id = $order;
      $order_return->orderDate = date(now());
      $order_return->user_id = $odd_order->user_id;
      $order_return->oderStatus = $odd_order->oderStatus + 3;
      $order_return->phone = $odd_order->phone;
      $order_return->address = $odd_order->address;
      $order_return->oderEmail = $odd_order->oderEmail;
      $order_return->orderName = $odd_order->orderName;
      $order_return->orderShip = $odd_order->orderShip;
      $order_return->total = $odd_order->total;
      $order_return->coupon = $odd_order->coupon;
      $order_return->id_voucher_hoan_tien = $request->id_voucher_hoan_tien;

      $order_return->save();

      return redirect()->route('client.returnProducts.create', $id_Order);
    } elseif ($updateStatus->oderStatus = 5) {
      $id_Order = $order;
      $odd_order = Order::find($order);
      // 
      $return_id = ReturnProduct::where('order_id', '=', $order)->where('oderStatus', '<=', 10)->get();
      // dd($return_id);
      if ($return_id->count() > 0) {
        session()->flash('error_empty', 'Bạn đã gửi yêu cầu hoàn trả và đang đợi hệ thống xác nhận!');
        return redirect()->back();
      }
      // dd(1);
      $tongtien = 0;
      if ($request->id_voucher_hoan_tien != null) {
        $voucher_hoan_tien = Voucher_hoan_tien::find($request->id_voucher_hoan_tien);
        $tongtien = $odd_order->total - $voucher_hoan_tien->refund;
        // dd($tongtien);
      } else {
        $tongtien = $odd_order->total;
        // dd($tongtien);
      }
      // 
      $order_return = new ReturnProduct();
      $order_return->order_id = $order;
      $order_return->orderDate = date(now());
      $order_return->user_id = $odd_order->user_id;
      $order_return->oderStatus = $odd_order->oderStatus + 1;
      $order_return->phone = $odd_order->phone;
      $order_return->address = $odd_order->address;
      $order_return->oderEmail = $odd_order->oderEmail;
      $order_return->orderName = $odd_order->orderName;
      $order_return->orderShip = $odd_order->orderShip;
      $order_return->total = $tongtien;
      $order_return->id_voucher_hoan_tien = $request->id_voucher_hoan_tien;
      $order_return->save();

      return redirect()->route('client.returnProducts.create', $id_Order);
    }

    $updateStatus->save();
    session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
    return redirect()->route('client.showOrder');
  }
}
