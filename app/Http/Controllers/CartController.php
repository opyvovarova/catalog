<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(AddToCartRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price'=> $product->price,
                'quantity'=>$request->quantity
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('cart.show')->with('success', 'Товар успешно добавлен в корзину.');
    }

    public function show()
    {
        $cart = session()->get('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function checkout(CheckoutRequest $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Создаем новый заказ с указанной общей стоимостью
        $order = Order::create(['total' => $total]);

        // Добавляем каждый продукт из корзины в заказ
        foreach ($cart as $id => $details) {
            $order->products()->attach($id, ['quantity' => $details['quantity']]);
        }

        // Очищаем корзину после оформления заказа
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Order placed successually.');
    }
}
