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
  public function updateStatus(Request $request, $order)
  {
    // dd($request->all());
    $updateStatus = Order::find($order);
    if ($request->tu_choi == 1) {
      $updateStatus->oderStatus = 100;
      $updateStatus->save();
      // dd($request->tu_choi);
      session()->flash('error', 'Bạn đã từ chối yêu cầu đổi hàng!');
      return redirect()->back();
    }
    if ($request->tu_choi == 0) {
      // dd(2);
      $updateStatus->oderStatus = 7;
      $updateStatus->save();
      session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
      return redirect()->back();
    }
    if ($request->oderStatus) {
      $updateStatus->oderStatus = $request->oderStatus;
      // dd(3);
      session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
      $updateStatus->save();
      return redirect()->back();
    }
    dd(4);
  }
  public function listReturnProduct()
  {
    $data = Order::select('orders.*')->where('orders.oderStatus', '>', 5)->get();
    // dd($data);
    return view('admin.order.listReturnProduct', compact('data'));
  }
}
