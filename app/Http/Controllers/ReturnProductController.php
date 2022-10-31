<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Return_detail;
use Illuminate\Http\Request;

class ReturnProductController extends Controller
{
  public function create($id_Order)
  {
    $id_donhang = $id_Order;
    // dd($id_donhang);
    return view('KH.form_hoan_tra', compact('id_donhang'));
  }
  public function storeReturn(Request $request)
  {
    // dd($request->all());
    $data = new Return_detail();
    $data->fill($request->all());
    // dd($request->all());
    // dd($data);
    $data->save();
    session()->flash('success', 'bạn đã gửi yêu cầu thành công');
    return redirect()->back();
  }
  public function listReturn($id)
  {
    $data = Return_detail::select('return_details.*')->where('return_details.order_id', '=', $id)->get();
    // dd($data);
    return view('admin.order.listReturn', compact('data'));
  }
  public function updateStatus($order)
  {
    // dd(1);
    // dd($order);
    $updateStatus = Order::find($order);
    if ($updateStatus->oderStatus == 6) {
      $id_Order = $order;
      $updateStatus->oderStatus = 7;
      $updateStatus->save();
      return redirect()->route('client.returnProducts.listReturnProduct');
    }
    $updateStatus->save();
    session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
    return redirect()->route('client.returnProducts.listReturnProduct');
  }
  public function listReturnProduct()
  {
    $data = Order::select('orders.*')->where('orders.oderStatus','>',5)->get();
    // dd($data);
    return view('admin.order.listReturnProduct',compact('data'));
  }
}
