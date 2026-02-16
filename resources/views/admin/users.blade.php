@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        @include('admin.header')

        <div class="d-flex justify-content-between align-items-center">
            <h2>Пользователи</h2>
            <a href="/admin/users/create" class="btn btn-primary ">Добавить пользователя</a>
        </div>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="/admin/users/edit/{{ $user->id }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="/admin/users/delete/{{ $user->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Удалить пользователя?')">Удалить</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
