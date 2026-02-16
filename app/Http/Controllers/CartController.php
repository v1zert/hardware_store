<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        // Проверка авторизации
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');

        // Получаем товары с alias для cart_id
        $cart_items = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('cart_items.user_id', $user_id)
            ->select(
                'cart_items.id as cart_id',
                'cart_items.quantity',
                'products.id as product_id',
                'products.name',
                'products.price',
                'products.image'
            )
            ->get();

        $total = $cart_items->sum(fn($item) => $item->price * $item->quantity);

        return view('cart', compact('cart_items', 'total'));
    }

    public function add(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');

        $exists = DB::table('cart_items')
            ->where('user_id', $user_id)
            ->where('product_id', $id)
            ->first();

        if ($exists) {
            DB::table('cart_items')->where('id', $exists->id)->increment('quantity');
        } else {
            DB::table('cart_items')->insert([
                'user_id' => $user_id,
                'product_id' => $id,
                'quantity' => 1,
                'created_at' => now()
            ]);
        }

        return redirect()->route('cart');
    }

    public function remove($id)
    {
        DB::table('cart_items')->where('id', $id)->delete();
        return redirect()->route('cart');
    }

    public function increase($id)
    {
        DB::table('cart_items')->where('id', $id)->increment('quantity');
        return redirect()->route('cart');
    }

    public function decrease($id)
    {
        $item = DB::table('cart_items')->where('id', $id)->first();

        if ($item && $item->quantity > 1) {
            DB::table('cart_items')->where('id', $id)->decrement('quantity');
        } else {
            DB::table('cart_items')->where('id', $id)->delete();
        }

        return redirect()->route('cart');
    }
}
