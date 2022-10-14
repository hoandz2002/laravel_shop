<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function index()
    {
        $data = Ship::all();

        return view('admin.ships.list',compact('data'));
    }
    public function store(Request $request)
    {
        $data = new Ship();
        $data->fill($request->all());
        $data->save();
        return redirect()->back();
    }
}
