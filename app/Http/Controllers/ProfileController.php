<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $user = DB::table('users')
            ->where('id', session('user_id'))
            ->first();

        return view('profile', compact('user'));
    }
}
