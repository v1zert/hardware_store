@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.header')
        <h2>Заказы</h2>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Email</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Создан</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user_name }}</td>
                    <td>{{ $order->user_email }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <a href="/admin/orders/view/{{ $order->id }}" class="btn btn-sm btn-info">Просмотр</a>
                        <a href="/admin/orders/delete/{{ $order->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Удалить заказ?')">Удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
