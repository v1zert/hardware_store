@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h2>Корзина</h2>

        @if($cart_items->isEmpty())
            <p>Ваша корзина пуста.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart_items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }} ₽</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <form method="POST" action="{{ url('/cart/decrease/' . $item->cart_id) }}">
                                    @csrf
                                    <button class="btn btn-secondary btn-sm">-</button>
                                </form>
                                <span class="mx-2">{{ $item->quantity }}</span>
                                <form method="POST" action="{{ url('/cart/increase/' . $item->cart_id) }}">
                                    @csrf
                                    <button class="btn btn-secondary btn-sm">+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ $item->price * $item->quantity }} ₽</td>
                        <td>
                            <form method="POST" action="{{ url('/cart/remove/' . $item->cart_id) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h4>Итого: {{ $total }} ₽</h4>
            <form method="POST" action="{{ route('checkout') }}">
                @csrf
                <button type="submit" class="btn btn-success">Оформить заказ</button>
            </form>

        @endif
    </div>
@endsection
