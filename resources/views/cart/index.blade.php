@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($cart as $id => $details)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $details['name'] }}</h5>
                            <p class="card-text">{{ $details['price'] }}</p>
                            <p class="card-text">Количество: {{ $details['quantity'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Общая стоимость: {{ $total }}</h3>
                <form action="{{ route('cart.checkout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success">Оформить заказ</button>
                </form>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-primary">Назад</a>

        </div>

    </div>
@endsection
