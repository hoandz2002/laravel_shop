<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
      $range = Carbon::now()->subDays(30);
  
      $stats = DB::table('orders')
        ->where('orderDate', '>=', $range)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get([
          DB::raw('Date(orderDate) as date'),
          DB::raw('COUNT(*) as value')
        ]);
        // dd($range);
        //thống kê số lượng sản phẩm theo loại sản phẩm
      $cates = DB::table('products')
        ->join('category_products', 'products.category_id', '=', 'category_products.id')
        ->groupBy('category_products.name')
        ->get([
          'category_products.name',
          DB::raw('COUNT(category_id) as value')
        ]);
  
      // dd($cates);
      return view('admin.dashboard', compact('cates', 'stats'));
    }
}
