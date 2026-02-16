@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h2>Подтверждение заказа #{{ $order->id }}</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }} ₽</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price * $item->quantity }} ₽</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h4>Итого: {{ $order->total }} ₽</h4>

        <div class="mt-3 d-flex gap-2">
            {{-- Кнопка оплатить, только если заказ pending --}}
            @if($order->status === 'pending')
                <form method="POST" action="{{ url('/pay/' . $order->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Оплатить заказ</button>
                </form>
            @elseif($order->status === 'paid')
                <span class="badge bg-primary p-2">Заказ оплачен</span>
            @elseif($order->status === 'completed')
                <span class="badge bg-success p-2">Заказ выполнен</span>
            @elseif($order->status === 'canceled')
                <span class="badge bg-danger p-2">Заказ отменен</span>
            @endif

            {{-- Кнопка отмены, только если заказ не выполнен и не отменен --}}
            @if(!in_array($order->status, ['completed', 'canceled']))
                <form method="POST" action="{{ url('/cancel/' . $order->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Отменить заказ</button>
                </form>
            @endif

            {{-- Кнопка назад --}}
            <a href="{{ route('profile') }}" class="btn btn-secondary">Назад</a>
        </div>
    </div>
@endsection
