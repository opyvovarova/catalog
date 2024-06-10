@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Заказ #{{ $order->id }}</h5>
                            <p class="card-text">Дата заказа: {{ $order->created_at }}</p>
                            <p class="card-text">Товары: {{ $order->products->pluck('name')->join(', ') }}</p>
                            <p class="card-text">Общая стоимость: {{ $order->products->sum(fn($product) => $product->pivot->quantity * $product->price) }}</p>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Итоговая стоимость всех заказов: {{ $total }}</h3>
            </div>

        </div>
    </div>

@endsection
