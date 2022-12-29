<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Return_detail;
use App\Models\ReturnProduct;
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
    // dd($order);
    // dd($request->all());
    $updateStatus = ReturnProduct::find($order);
    // dd($updateStatus);
    if ($request->tu_choi == 1) {
      $updateStatus->oderStatus = 100;
      $updateStatus->save();
      // dd($request->tu_choi);
      session()->flash('error', 'Bạn đã từ chối yêu cầu đổi hàng!');
      return redirect()->back();
    }
    if ($request->tu_choi == 0) {
      // dd(2);
      $order_odd = Order::find($updateStatus->order_id);
      $voucher = Coupon::find($order_odd->id_voucher);
      // dd($voucher);
      $voucher->quantity = $voucher->quantity + 1;
      $voucher->save();
      $updateStatus->oderStatus = 7;
      $updateStatus->save();
      session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
      return redirect()->back();
    }
    if ($request->oderStatus) {
      if ($request->oderStatus == 8) {
        if ($updateStatus->code_ship === null) {
          session()->flash('error', 'Chưa có Mã vận đơn');
          return redirect()->back();
        }
      }
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
    $data = ReturnProduct::all();
    // dd($data);
    return view('admin.order.listReturnProduct', compact('data'));
  }
  public function add_code_ship(Request $request)
  {
    // dd($request->all());
    $data = ReturnProduct::find($request->id_order);
    $data->code_ship = $request->code_ship;
    $data->save();
    return redirect()->back();
  }
}
