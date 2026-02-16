<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Все категории
        $categories = DB::table('categories')->get();

        // Базовый запрос
        $query = DB::table('products');

        // 🔍 Поиск по названию
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🗂 Фильтр по категории
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Товары
        $products = $query
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('home', compact('categories', 'products'));
    }
}
