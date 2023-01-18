<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CouponController extends Controller
{
    public function index()
    {
        $coupon = Coupon::select('coupons.*')->get();
        return view('admin.coupons.list', ['list_coupon' => $coupon]);
    }
    public function create()
    {
        return view('admin.coupons.create_edit');
    }
    public function store(Request $request)
    {
        if ($request->Minimum_bill < $request->sale) {
            session()->flash('error', 'Giá trị được giảm không được lớn hơn giá trị đơn hàng!');
            return redirect()->back();
        }
        $coupon = new Coupon();

        $coupon->fill($request->all());

        $coupon->save();
        return redirect()->route('admin.coupons.list');
    }
    public function edit(Coupon $size)
    {
        // dd($size);
        $coupon = $size;
        return view('admin.coupons.create_edit', compact('coupon'));
    }
    public function update(Request $request, $size)
    {
        if ($request->Minimum_bill < $request->sale) {
            session()->flash('error', 'Giá trị được giảm không được lớn hơn giá trị đơn hàng!');
            return redirect()->back();
        }
        $data = Coupon::find($size);
        $data->name = $request->name;
        $data->content = $request->content;
        $data->end_date = $request->end_date;
        $data->sale = $request->sale;
        $data->code = $request->code;
        $data->quantity = $request->quantity;
        $data->Minimum_bill = $request->Minimum_bill;
        $data->status = $request->status;
        // save
        $data->save();
        return redirect()->route('admin.coupons.list');
    }
    public function delete($size)
    {
        $data = Coupon::find($size);
        $data->delete();
        session()->flash('success', 'Đã xóa thành công');
        return redirect()->back();
    }
    public function updateStatus($coupon)
    {
        $hihi = Coupon::find($coupon);
        // dd($data);
        if ($hihi->status == 0) {
            $data = Coupon::where('id', '=', $coupon)
                ->update(['status' => 1]);
        } elseif ($hihi->status == 1) {
            $data = Coupon::where('id', '=', $coupon)
                ->update(['status' => 0]);
        }
        $hihi->save();
        return redirect()->back();
    }
}
