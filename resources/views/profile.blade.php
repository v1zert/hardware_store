@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2>Профиль пользователя</h2>
        <div class="card p-4 mb-3">
            <p><strong>Имя:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Роль:</strong> {{ $user->role }}</p>
        </div>

        <div class="d-flex gap-2 mb-4">
            <!-- Кнопка выхода -->
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn btn-danger" type="submit">Выйти</button>
            </form>

            <!-- Ссылка на админку только для админа -->
            @if($user->role === 'admin')
                <a href="{{ url('/admin/users') }}" class="btn btn-warning">Админ-панель</a>
            @endif
        </div>

        <h3>Ваши заказы</h3>
        @php
            $orders = DB::table('orders')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp

        @if($orders->isEmpty())
            <p>У вас пока нет заказов.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>№ заказа</th>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Детали</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->total }} ₽</td>
                        <td>
                            @if($order->status === 'pending')
                                <span class="badge bg-secondary">В обработке</span>
                            @elseif($order->status === 'paid')
                                <span class="badge bg-primary">Оплачен</span>
                            @elseif($order->status === 'completed')
                                <span class="badge bg-success">Выполнен</span>
                            @elseif($order->status === 'canceled')
                                <span class="badge bg-danger">Отменен</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/checkout/' . $order->id) }}" class="btn btn-sm btn-info">Посмотреть</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
