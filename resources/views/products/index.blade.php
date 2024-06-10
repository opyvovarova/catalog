@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mt-20">
                        <div class="card mb-4 p-3">
                            <div class="card-body">
                                <h5 class="cart-title">{{ $product->name }}</h5>
                                <p class="cart-text">{{ $product->price }}</p>
                            </div>
                            <form action="{{ route('cart.add', $product->id) }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control mr-2" value="1" min="1">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

        </div>
    </div>
@endsection
