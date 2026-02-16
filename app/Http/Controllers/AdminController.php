<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{


    // Список пользователей
    public function users()
    {
        $users = DB::table('users')->get();
        return view('admin.users', compact('users'));
    }

    // Форма редактирования
    public function editUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('admin.edit_user', compact('user'));
    }

    // Обновление пользователя
    public function updateUser(Request $request, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'updated_at' => now()
            ]);

        return redirect('/admin/users');
    }

    // Удаление пользователя
    public function deleteUser($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/admin/users');
    }

    // Форма создания
    public function createUser()
    {
        return view('admin.create_user');
    }

    // Сохранение
    public function storeUser(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/admin/users');
    }










    // Список категорий
    public function categories()
    {
        $categories = DB::table('categories')->get();
        return view('admin.categories', compact('categories'));
    }

// Форма создания категории
    public function createCategory()
    {
        return view('admin.create_category');
    }

// Сохранение новой категории
    public function storeCategory(Request $request)
    {
        DB::table('categories')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/admin/categories');
    }

// Форма редактирования категории
    public function editCategory($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return view('admin.edit_category', compact('category'));
    }

// Обновление категории
    public function updateCategory(Request $request, $id)
    {
        DB::table('categories')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'updated_at' => now()
            ]);

        return redirect('/admin/categories');
    }

// Удаление категории
    public function deleteCategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return redirect('/admin/categories');
    }









// Список продуктов
    public function products()
    {
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->get();

        return view('admin.products', compact('products'));
    }

    // Форма создания продукта
    public function createProduct()
    {
        $categories = DB::table('categories')->get();
        return view('admin.create_product', compact('categories'));
    }

    // Сохранение нового продукта
    public function storeProduct(Request $request)
    {
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $imageName);
        }

        DB::table('products')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageName,
            'category_id' => $request->category_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/admin/products');
    }

    // Форма редактирования продукта
    public function editProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $categories = DB::table('categories')->get();
        return view('admin.edit_product', compact('product', 'categories'));
    }

    // Обновление продукта
    public function updateProduct(Request $request, $id)
    {
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $product = DB::table('products')->where('id', $id)->first();
        $imageName = $product->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img'), $imageName);
        }

        DB::table('products')->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageName,
            'category_id' => $request->category_id,
            'updated_at' => now()
        ]);

        return redirect('/admin/products');
    }

    // Удаление продукта
    public function deleteProduct($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect('/admin/products');
    }








    // Список заказов
    public function orders()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('admin.orders', compact('orders'));
    }

// Просмотр деталей заказа
    public function viewOrder($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->where('orders.id', $id)
            ->first();

        $items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('order_items.*', 'products.name as product_name', 'products.price as product_price')
            ->where('order_items.order_id', $id)
            ->get();

        return view('admin.view_order', compact('order', 'items'));
    }

// Изменение статуса заказа
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,completed,canceled'
        ]);

        DB::table('orders')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return redirect()->back();
    }

// Удаление заказа
    public function deleteOrder($id)
    {
        DB::table('order_items')->where('order_id', $id)->delete();
        DB::table('orders')->where('id', $id)->delete();

        return redirect('/admin/orders');
    }

}
