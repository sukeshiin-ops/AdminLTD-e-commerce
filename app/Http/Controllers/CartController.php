<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    // public function increment($id)
    // {
    //     $user = Auth::user();

    //     $cart = Cart::where('user_id', $user->id)->where('product_id', $id)->firstOrFail();

    //     $cart->quantity += 1;
    //     $cart->save();

    //     $total = $cart->price * $cart->quantity;

    //     // Correct subtotal calculation
    //     $subtotal = Cart::where('user_id', $user->id)->get()->sum(function ($item) {
    //         return $item->price * $item->quantity;
    //     });

    //     return response()->json([
    //         'quantity' => $cart->quantity,
    //         'total' => $total,
    //         'subtotal' => $subtotal
    //     ]);
    // }


    public function increment($id)
    {
        $user = Auth::user();


        $cart = Cart::where('user_id', $user->id)
            ->where('variant_id', $id)
            ->firstOrFail();

        $cart->quantity += 1;
        $cart->save();

        $total = $cart->price * $cart->quantity;

        $subtotal = Cart::where('user_id', $user->id)
            ->get()
            ->sum(fn($item) => $item->price * $item->quantity);

        return response()->json([
            'quantity' => $cart->quantity,
            'total' => $total,
            'subtotal' => $subtotal
        ]);
    }

    public function decrement($id)
    {
        $user = Auth::user();

        // ❗ variant_id use kar
        $cart = Cart::where('user_id', $user->id)
            ->where('variant_id', $id)
            ->first();

        if (!$cart) {
            return response()->json([
                'quantity' => 0,
                'total' => 0,
                'subtotal' => 0
            ]);
        }

        $cart->quantity -= 1;

        if ($cart->quantity < 1) {
            $cart->delete();
            $quantity = 0;
            $total = 0;
        } else {
            $cart->save();
            $quantity = $cart->quantity;
            $total = $cart->price * $cart->quantity;
        }

        $subtotal = Cart::where('user_id', $user->id)
            ->get()
            ->sum(fn($item) => $item->price * $item->quantity);

        return response()->json([
            'quantity' => $quantity,
            'total' => $total,
            'subtotal' => $subtotal
        ]);
    }


    public function remove($variant_id)
    {
        $user = Auth::user();

        Cart::where('user_id', $user->id)
            ->where('variant_id', $variant_id)
            ->delete();

        return redirect()->route('view.cart.page');
    }
}
