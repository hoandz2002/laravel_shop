<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $categoryProducts = Color::select('colors.*')
        ->Paginate(6);
        return view('admin.colors.list', ['list_cate' => $categoryProducts]);
    }
    public function store(Request $request)
    {
        $cate=new Color();

        $cate->fill($request->all());
        session()->flash('success','Bạn đã thê mới thành công !');
        $cate->save();
        return redirect()->route('admin.colors.list');
    }
    public function delete($id)
    {
        $data=Color::find($id);
        $data->delete();
        return redirect()->route('admin.colors.list');

    }
    public function edit(Color $color)
    {
        // dd($size);
        return view('admin.colors.edit',[
            'color'=> $color,
        ]);
    }
    public function update(Request $request,$color)
    {
        $catenew=Color::find($color);
        // dd($request->all());
        $catenew->name_Color = $request->name_Color;
        // $request->statusSize ? $catenew->statusSize = $request->statusSize : $catenew->statusSize = $catenew->statusSize;

        $catenew->save();
        return redirect()->route('admin.colors.list');

    }
}
