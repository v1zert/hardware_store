@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')
        <h2>Редактирование пользователя</h2>


        <form method="POST" action="/admin/users/update/{{ $user->id }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Имя</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Роль</label>
                <select name="role" class="form-control">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="/admin/users" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
