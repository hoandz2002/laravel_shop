<?php

namespace App\Http\Controllers;

use App\Models\Purse;
use App\Models\Transaction;
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
}
