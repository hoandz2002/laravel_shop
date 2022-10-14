<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $categoryProducts = Size::select('id','nameSize','statusSize')
        ->Paginate(6);
        return view('admin.sizes.list', ['list_cate' => $categoryProducts]);
    }
    public function create()
    {
        return view('admin.sizes.create');
    }
    public function store(Request $request)
    {
        $cate=new Size();

        $cate->fill($request->all());

        $cate->save();
        return redirect()->route('admin.sizes.list');
    }
    public function edit(Size $size)
    {
        // dd($size);
        return view('admin.sizes.create',[
            'size'=> $size,
        ]);
    }
    public function update(Request $request,Size $size)
    {
        $catenew=Size::find($size->id);
        // dd($request->all());
        $catenew->nameSize = $request->nameSize;
        $request->statusSize ? $catenew->statusSize = $request->statusSize : $catenew->statusSize = $catenew->statusSize;

        $catenew->save();
        return redirect()->route('admin.sizes.list');

    }
    public function delete(Size $size)
    {
        $data=Size::find($size);
        $data->delete();
        return redirect()->route('admin.size.list');

    }
    public function updateStatus($cate)
    {
            $updateStatus = Size::find($cate);
            if($updateStatus->statusSize === 0){
                $updateStatus->statusSize = 1;
            }else {
                $updateStatus->statusSize = 0;
            }
            $updateStatus->save();
            session()->flash('success', 'Bạn đã cập nhật trạng thái thành công!');
            return redirect()->route('admin.sizes.list');
            // return redirect()->back();
    }
   
}
