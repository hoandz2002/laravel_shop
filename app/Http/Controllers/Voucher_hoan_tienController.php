<?php

namespace App\Http\Controllers;

use App\Models\Voucher_hoan_tien;
use Illuminate\Http\Request;

class Voucher_hoan_tienController extends Controller
{
    public function index()
    {
        $voucher = Voucher_hoan_tien::all();
        return view('admin.voucher_hoan_tien.list', compact('voucher'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $data = new Voucher_hoan_tien();
        $data->fill($request->all());
        $data->save();
        session()->flash('thanhcong', 'Bạn đã thêm mới thành công');
        return redirect()->route('admin.vouchers.list');
    }
    public function update(Request $request, $id)
    {
        // dd($id);
        $data = Voucher_hoan_tien::find($id);
        $data->fill($request->all());
        $data->save();
        return redirect()->route('admin.vouchers.list');
    }
    public function delete($id)
    {
        $data = Voucher_hoan_tien::find($id);
        // dd($data);
        $data->delete();
        session()->flash('thanhcong', 'Bạn đã xóa thành công');
        return redirect()->back();
    }
}
