@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')

        <div class="d-flex justify-content-between align-items-center">
            <h2>Продукты</h2>
            <a href="/admin/products/create" class="btn btn-primary">Добавить продукт</a>
        </div>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Категория</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" width="50">
                        @endif
                    </td>
                    <td>
                        <a href="/admin/products/edit/{{ $product->id }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="/admin/products/delete/{{ $product->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Удалить продукт?')">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
