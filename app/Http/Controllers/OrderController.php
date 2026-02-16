<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Оформление заказа из корзины
    public function checkout()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');

        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('cart_items.user_id', $user_id)
            ->select('cart_items.*', 'products.price')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Ваша корзина пуста.');
        }

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $user_id,
            'total' => $total,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($cartItems as $item) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Очищаем корзину
        DB::table('cart_items')->where('user_id', $user_id)->delete();

        return redirect()->route('checkout.show', $orderId);
    }

    // Показ страницы заказа
    public function show($order_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');

        $order = DB::table('orders')->where('id', $order_id)->first();

        if (!$order || $order->user_id != $user_id) {
            abort(403);
        }

        $items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $order_id)
            ->select('products.name', 'order_items.quantity', 'order_items.price')
            ->get();

        return view('checkout', compact('order', 'items'));
    }

    // Оплата заказа
    public function pay($order_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');

        $order = DB::table('orders')->where('id', $order_id)->first();
        if (!$order || $order->user_id != $user_id) {
            abort(403);
        }

        DB::table('orders')->where('id', $order_id)->update([
            'status' => 'paid',
            'updated_at' => now()
        ]);

        return redirect()->route('profile')->with('success', 'Оплата прошла успешно!');
    }

    // Отмена заказа
    public function cancel($order_id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user_id = session('user_id');

        $order = DB::table('orders')->where('id', $order_id)->first();
        if (!$order || $order->user_id != $user_id) {
            abort(403);
        }

        if ($order->status === 'completed') {
            return redirect()->route('checkout.show', $order_id)
                ->with('error', 'Этот заказ уже выполнен и не может быть отменен.');
        }

        DB::table('orders')->where('id', $order_id)->update([
            'status' => 'canceled',
            'updated_at' => now()
        ]);

        return redirect()->route('profile')->with('success', 'Заказ отменен.');
    }
}
