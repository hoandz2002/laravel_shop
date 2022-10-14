<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $categoryProducts = Material::select('materials.*')
            ->get();
        return view('admin.materials.list', compact('categoryProducts'));
    }
    public function create()
    {
        return view('admin.materials.create');
    }
    public function store(Request $request)
    {
        $cate = new Material();

        $cate->fill($request->all());

        $cate->save();
        return redirect()->route('admin.materials.list');
    }
    public function edit($material)
    {
        // dd($size);
        $materials = Material::where('materials.id_material','=',$material)
        ->select('materials.*')
        ->get();
        // dd($color);
        return view('admin.materials.edit', [
            'materials' => $materials,
        ]);

    }
    public function update(Request $request, Material $material)
    {
        $catenew = Material::find($material->id);
        // dd($request->all());
        $catenew->nameSize = $request->nameSize;
        $request->statusSize ? $catenew->statusSize = $request->statusSize : $catenew->statusSize = $catenew->statusSize;

        $catenew->save();
        return redirect()->route('admin.materials.list');
    }
    public function delete($id)
    {
        $data = Material::where('materials.id_material','=',$id);
        // dd($data);
        $data->delete();
        return redirect()->route('admin.materials.list');
    }
}
