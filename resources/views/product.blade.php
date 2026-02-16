@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="row">

            <div class="col-md-6">
                <img src="{{ asset('public/assets/img/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            </div>

            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <h4>{{ $product->price }} ₽</h4>

                @if(session()->has('user_id'))
                    <form method="POST" action="{{ url('/cart/add/' . $product->id) }}">
                        @csrf
                        <div class="d-flex align-items-center mb-3">
                            <button type="button" class="btn btn-secondary btn-sm" id="decrease">-</button>
                            <input type="text" name="quantity" id="quantity" value="1" class="form-control text-center mx-2" style="width: 60px;">
                            <button type="button" class="btn btn-secondary btn-sm" id="increase">+</button>
                        </div>
                        <button type="submit" class="btn btn-success">Добавить в корзину</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Войдите, чтобы добавить в корзину</a>
                @endif

            </div>
        </div>
    </div>

    <script>
        const decreaseBtn = document.getElementById('decrease');
        const increaseBtn = document.getElementById('increase');
        const quantityInput = document.getElementById('quantity');

        decreaseBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if(value > 1) quantityInput.value = value - 1;
        });

        increaseBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
        });
    </script>
@endsection
