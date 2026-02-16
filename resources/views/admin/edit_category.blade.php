@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')
        <h2>Редактировать категорию</h2>

        <form method="POST" action="/admin/categories/update/{{ $category->id }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="/admin/categories" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
