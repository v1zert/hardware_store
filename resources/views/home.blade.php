@extends('layouts.app')

@section('content')
    <div class="container my-4">

        {{-- Поиск и фильтр по категориям --}}
        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Поиск по названию..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-5">
                    <select name="category" class="form-select">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Показать</button>
                </div>
            </div>
        </form>

        {{-- Список товаров --}}
        <h3 class="mb-3">Товары</h3>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img
                            src="{{ asset('public/assets/img/' . $product->image) }}"
                            class="card-img-top"
                            alt="{{ $product->name }}"
                        >

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>

                            <p class="card-text">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <p class="fw-bold">{{ $product->price }} ₽</p>

                            <a href="{{ route('product.show', $product->id) }}"
                               class="btn btn-primary mt-auto">
                                Подробнее
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Товары не найдены.</p>
            @endforelse
        </div>

        {{-- Пагинация --}}
        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
@endsection
