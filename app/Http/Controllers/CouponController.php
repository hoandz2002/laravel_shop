<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

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
        $coupon=new Coupon();

        $coupon->fill($request->all());

        $coupon->save();
        return redirect()->route('admin.coupons.list');
    }
    public function edit()
    {
        
    }
    public function update()
    {
        
    }
    public function delete()
    {
        
    }
   
}
