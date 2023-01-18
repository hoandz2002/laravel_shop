<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Purse;
use App\Models\Return_detail;
use App\Models\ReturnProduct;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher_hoan_tien;
use DateTime;
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
      $hoantien = Purse::where('user_id', '=', $updateStatus->user_id)->first();
      if ($updateStatus->id_voucher_hoan_tien != null) {
        $voucher_hoan_tien = Voucher_hoan_tien::find($updateStatus->id_voucher_hoan_tien);
        // dd($voucher_hoan_tien);
        $hoantien->surplus = $hoantien->surplus + $voucher_hoan_tien->refund;
        $hoantien->save();
        // in sert lich su nap rut tien 

        $lich_su_hoan_tien = new Transaction();
        $lich_su_hoan_tien->date_time = Date(now());
        $lich_su_hoan_tien->content = "Hoàn tiền sử dụng voucher";
        $lich_su_hoan_tien->money = $voucher_hoan_tien->refund;
        $lich_su_hoan_tien->user_id = $order_odd->user_id;
        $lich_su_hoan_tien->type = "Hoàn tiền voucher";
        $lich_su_hoan_tien->surplus = $hoantien->surplus;
        // save lich su haon tien
        $lich_su_hoan_tien->save();
      }
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
      if ($request->oderStatus == 10) {
        $hoantien = Purse::where('user_id', '=', $updateStatus->user_id)->first();
        // dd($hoantien);
        $hoantien->surplus = $hoantien->surplus + $updateStatus->total;
        $hoantien->save();
        // save
        $updateStatus->oderStatus = $request->oderStatus;
        // them vao lich su hoan tien 
        $vi_tien = Purse::where('user_id', '=', $updateStatus->user_id)->first();
        // 
        $lich_su_hoan_tien = new Transaction();
        $lich_su_hoan_tien->date_time = Date(now());
        $lich_su_hoan_tien->content = "Hoàn tiền hàng";
        $lich_su_hoan_tien->money = $updateStatus->total;
        $lich_su_hoan_tien->user_id = $updateStatus->user_id;
        $lich_su_hoan_tien->type = "Admin chuyển tiền";
        $lich_su_hoan_tien->surplus = $hoantien->surplus;
        // save lich su haon tien
        $lich_su_hoan_tien->save();
        session()->flash('success', 'Đã hoàn tiền cho khách hàng!');
        $updateStatus->save();
        return redirect()->back();
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
