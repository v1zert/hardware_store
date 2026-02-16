@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')

        <div class="d-flex justify-content-between align-items-center">
            <h2>Категории</h2>
            <a href="/admin/categories/create" class="btn btn-primary">Добавить категорию</a>
        </div>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="/admin/categories/edit/{{ $category->id }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="/admin/categories/delete/{{ $category->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Удалить категорию?')">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
