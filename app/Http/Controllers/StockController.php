<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\StockHistory;
use App\Models\VariantAttribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function edit($id)
    {
        $product = ProductInventory::with('Product_table')->findOrFail($id);
        return view('e-commerce.seller.stock.edit', compact('product'));
    }



    public function update(Request $request, $id)
    {

        $request->validate([
            'new_stock' => 'required|integer|min:0',
        ]);


        $product = ProductInventory::findOrFail($id);

        $oldStock = $product->quantity;
        $addedStock = $request->new_stock;

        $product->quantity = $oldStock + $addedStock;
        $product->save();


        StockHistory::create([
            'inventory_id' => $product->id,
            'added_stock' => $addedStock,
            'old_stock'   => $oldStock,
            'new_total'   => $product->quantity,
        ]);


        return redirect()->route('view.seller.product')
            ->with('success', 'Stock updated successfully!');
    }


    public function create()
    {
        $products = Product::all();
        return view('e-commerce.seller.stock.create', compact('products'));
    }






    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|min:3',
            'category_id' => 'required|numeric',
            'short' => 'required|string|max:255',
            'desc' => 'required|string',
            'price' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'product_image' => 'required'
        ]);

        $imageName = null;

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/products'), $imageName);
        }



        Product::create([
            'product_name' => $request->product_name,
            'small_description' => $request->short,
            'category_id' => $request->category_id,
            'product_price' => $request->price,
            'description' => $request->desc,
            'product_image' => $imageName,
            'tax' => $request->tax,
            'discount' => 30,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('view.seller.product')
            ->with('success', 'Product Created Successfully');
    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();

        try {

            $product = Product::with('variants.inventory')->findOrFail($id);

            foreach ($product->variants as $variant) {


                if ($variant->inventory) {
                    $variant->inventory->delete();
                }

                VariantAttribute::where('variant_id', $variant->id)->delete();


                $variant->delete();
            }


            $product->delete();

            DB::commit();

            return redirect()->route('view.seller.product')
                ->with('success', 'Product Deleted Successfully!!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editPage($id)
    {
        $product = Product::where('id', $id)->first();

        return view('e-commerce.seller.stock.edit-product', compact('product'));
    }



    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'product_image' => 'required',
            'short' => 'nullable|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        $data = [
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'product_price' => $request->price,
            'tax' => $request->tax,
            'small_description' => $request->short,
            'description' => $request->desc,
        ];

        if ($request->hasFile('product_image')) {
            if (
                $product->product_image &&
                !filter_var($product->product_image, FILTER_VALIDATE_URL) &&
                File::exists(public_path($product->product_image))
            ) {
                Log::info('Deleting old image at: ' . public_path($product->product_image));
                File::delete(public_path($product->product_image));
            }

            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $data['product_image'] = 'uploads/products/' . $imageName;
        }

        Product::updateOrCreate(
            ['id' => $id],
            $data
        );

        return redirect()->route('view.seller.product')
            ->with('success', 'Product updated successfully!');
    }
}
