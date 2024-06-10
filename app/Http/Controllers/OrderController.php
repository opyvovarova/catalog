<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function index()
   {
       $orders = Order::with('products')->get();

       $total = 0;
       foreach ($orders as $order) {
           foreach ($order->products as $product) {
               $total += $product->pivot->quantity * $product->price;
           }
       }
       return view('orders.index', compact('orders', 'total'));
   }
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
        }
        return redirect()->back();
    }
}
