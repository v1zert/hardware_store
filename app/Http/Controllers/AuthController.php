<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // confirmed проверяет совпадение с password_confirmation
        ], [
            'name.required' => 'Поле имя обязательно',
            'email.required' => 'Поле email обязательно',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Пользователь с таким email уже существует',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Пароль должен быть минимум 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        // Создание пользователя
        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Редирект с сообщением об успешной регистрации
        return redirect('/login')->with('success', 'Регистрация прошла успешно. Войдите в аккаунт.');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role
            ]);

            return redirect()->route('profile');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль'
        ]);
    }

    public function logout()
    {
        session()->flush(); // очищаем всю сессию
        return redirect()->route('login');
    }

}
