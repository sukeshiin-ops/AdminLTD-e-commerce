<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{

    public function purchasedUsers()
    {
        $sellerId = Auth::id();

        $orders = OrderDetail::with([
            'variant.product',   // product via variant
            'order.user_rel'     // user info
        ])
            ->whereHas('variant.product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->latest()
            ->get();

        return view('e-commerce.seller.seller-product', compact('orders'));
    }


    public function orderPage()
    {
        $sellerId = Auth::id();

        $product = Product::first();

        $orders = Order::with([
            'user_rel',
            'orderDetails_rel.variant.product',
            'orderDetails_rel.variant.variantAttributes.attribute',
            'orderDetails_rel.variant.variantAttributes.attributeValue'
        ])
            ->whereHas('orderDetails_rel.variant.product', function ($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->get();

        return view('e-commerce.seller.order-page', compact('orders', 'product'));
    }


    public function invoicePage($id)
    {
        $order = Order::with([
            'orderDetails_rel.variant.product',
            'user_rel'
        ])->findOrFail($id);

        return view('e-commerce.seller.invoice', compact('order'));
    }
}
