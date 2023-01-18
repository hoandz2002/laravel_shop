<?php

namespace App\Http\Controllers;

use App\Models\Purse;
use App\Models\Transaction;
use App\Models\Voucher_hoan_tien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurseController extends Controller
{
    public function create()
    {
        return view('KH.purses.create');
    }
    // 
    public function store(Request $request)
    {
        # code...
    }
    // 
    public function edit()
    {
        # code...
    }
    // 
    public function update(Request $request)
    {
        # code...
    }
    // 
    public function index()
    {
        $purse = Purse::where('purses.user_id', '=', Auth::user()->id)->join('users', 'users.id', '=', 'purses.user_id')
            ->select('users.*', 'purses.surplus', 'purses.status')
            ->first();
        $data = Transaction::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->Paginate(10);
        // dd($purse);
        return view('KH.purses.list', compact('purse', 'data'));
    }
    public function ajax_voucher_hoan_tien(Request $request)
    {
        // dd($request->all());
        $voucher_hoan_tien = Voucher_hoan_tien::find($request->id_voucher);
        // dd($voucher_hoan_tien);
        $tien_hoan = $voucher_hoan_tien->refund;
        $id_voucher_hoan_tien = $request->id_voucher;
        return response()->json(['success' => true, 'tien_hoan' => $tien_hoan, 'id_voucher_hoan_tien' => $id_voucher_hoan_tien]);
    }
}
