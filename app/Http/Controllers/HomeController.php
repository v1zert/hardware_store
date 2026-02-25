<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $categories = DB::table('categories')->get();

        $query = DB::table('products');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('home', compact('categories', 'products'));
    }
}
