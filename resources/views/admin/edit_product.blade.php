@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')
        <h2>Редактировать продукт</h2>

        <form method="POST" action="/admin/products/update/{{ $product->id }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Цена</label>
                <input type="text" name="price" class="form-control" value="{{ $product->price }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Изображение</label>
                <input type="file" name="image" class="form-control">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="" width="100" class="mt-2">
                @endif
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="/admin/products" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
