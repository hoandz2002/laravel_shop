<?php

namespace App\Http\Controllers;

use App\Models\Combo2;
use App\Models\Product;
use Illuminate\Http\Request;

class Combo2Controller extends Controller
{
    public function index()
    {
        $data = Combo2::all();
        $product = Product::all();
        return view('admin.combo2.list',compact('data','product'));
    }
    public function create()
    {
        $product = Product::all();
        return view('admin.combo2.create',compact('product'));

    }
    public function store(Request $request)
    {
        // dd($request->all());
        $data = new Combo2();
        $data->fill($request->all());
        $data->save();
        return redirect()->route('admin.combo2.list');
    }
    public function delete($id)
    {
    }
}
