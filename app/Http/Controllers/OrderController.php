<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // public function OrderCheckout()
    // {

    //     $user = Auth::user();

    //     $cart = Cart::where('user_id', $user->id)->get();

    //     //add finall amount in order table so i have do to

    //     $total_price = 0;

    //     foreach ($cart as $items) {
    //         $total_price += $items->price * $items->quantity;
    //     }



    //     if ($cart->count() == 0) {
    //         return redirect()->route('e-commerce-page');
    //     }

    //     $order =   Order::create([
    //         'user_id' => $user->id,
    //         'order_address' => '97383 Bailee Way Apt. 513 New Elwyn, RI 95338',
    //         'final_discount' => 20,
    //         'final_amount' => $total_price,
    //         'final_tax' => 50,
    //         'status' => 'pending'
    //     ]);


    //     foreach ($cart as $items) {
    //         OrderDetail::create([
    //             'order_id' => $order->id,
    //             'product_id' => $items->product_id,
    //             'order_quantity' => $items->quantity,
    //             'price_per_unit' => $items->price,
    //             'discount' => 5,
    //             'tax' => 20,
    //         ]);
    //     }

    //     Cart::where('user_id', $user->id)->delete();

    //     return redirect()->route('user.order.page')->with('success', 'Order Placed Successfully!!');
    // }


    public function OrderCheckout()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->get();

        if ($cart->count() == 0) {
            return redirect()->route('e-commerce-page');
        }

        $total_price = 0;

        foreach ($cart as $items) {
            $total_price += $items->price * $items->quantity;
        }

        $order = Order::create([
            'user_id' => $user->id,
            'order_address' => 'Demo Address',
            'final_discount' => 20,
            'final_amount' => $total_price,
            'final_tax' => 50,
            'status' => 'pending'
        ]);

        foreach ($cart as $items) {
            OrderDetail::create([
                'order_id' => $order->id,
                'variant_id' => $items->variant_id, // ✅ FIXED
                'order_quantity' => $items->quantity,
                'price_per_unit' => $items->price,
                'discount' => 5,
                'tax' => 20,
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('user.order.page')
            ->with('success', 'Order Placed Successfully!!');
    }


    public function userOrders()
    {
        $orders = Order::with(['orderDetails_rel.product', 'user_rel'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('e-commerce.user.user-order', compact('orders'));
    }
}
