@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')
        <h2>Заказ #{{ $order->id }}</h2>
        <p><strong>Пользователь:</strong> {{ $order->user_name }} ({{ $order->user_email }})</p>
        <p><strong>Сумма:</strong> {{ $order->total }}</p>
        <p><strong>Статус:</strong> {{ $order->status }}</p>

        <form method="POST" action="/admin/orders/update-status/{{ $order->id }}">
            @csrf
            <select name="status" class="form-control mb-2">
                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
                <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                <option value="canceled" {{ $order->status=='canceled'?'selected':'' }}>Canceled</option>
            </select>
            <button type="submit" class="btn btn-success mb-3">Обновить статус</button>
        </form>

        <h4>Товары в заказе:</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Продукт</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price * $item->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/admin/orders" class="btn btn-secondary">Назад</a>
    </div>
@endsection
