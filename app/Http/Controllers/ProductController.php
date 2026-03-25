<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    public function viewProductImage(int $id)
    {

        $product = Product::with(
            'productVariant.attributes.attributeValue.attribute'
        )->findOrFail($id);



        // return $product;

        // return view('product-view', compact('product'));
        // $product = Product::findOrFail($id);

        // // Navbar ke liye categories
        $categories = Category::whereNull('parent_id')->get();


        return view('e-commerce.view-product', compact('product', 'categories'));
    }



    public function allProduct()
    {
        return view('admin.product.all-product');
    }


    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::with('attributeValue')->get();
        return view('admin.product.add-product', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'unit_price' => 'required|numeric',
            'category_id' => 'required',
            'quantity' => 'required|numeric',
            'product_image' => 'required',
        ]);

        DB::beginTransaction();

        try {

            // Upload Product Image
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('uploads/products'), $imageName);

            // Create Product
            $product = Product::create([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'small_description' => $request->small_description,
                'description' => $request->description,
                'product_image' => 'uploads/products/' . $imageName,
                'user_id' => Auth::id()
            ]);

            // VARIANTS
            if ($request->has('variants') && count($request->variants) > 0) {

                foreach ($request->variants as $index => $variantData) {

                    //Upload Variant Image
                    $variantImagePath = null;

                    if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $variantData['image'];
                        $fileName = time() . '_' . $index . '.' . $file->extension();
                        $file->move(public_path('uploads/variants'), $fileName);
                        $variantImagePath = 'uploads/variants/' . $fileName;
                    }

                    //Create Variant
                    $variant = new ProductVariant();
                    $variant->product_id = $product->id; // 🔥 FIX
                    $variant->variant = $variantData['variant'] ?? null;
                    $variant->sku = $variantData['sku'] ?? ('SKU-' . uniqid());
                    $variant->price = $variantData['price'] ?? $request->unit_price;
                    $variant->tax = $request->tax ?? 0;
                    $variant->discount = $request->discount ?? 0;
                    $variant->image = $variantImagePath;
                    $variant->save();

                    // Inventory
                    ProductInventory::create([
                        'variant_id' => $variant->id,
                        'quantity' => $variantData['qty'] ?? 0
                    ]);

                    // IMPORTANT FIX (correct attribute mapping)
                    if ($request->has('attribute_values') && isset($variantData['variant'])) {

                        $variantName = $variantData['variant']; // e.g. Blue - 4 GB
                        $parts = explode(' - ', $variantName);

                        foreach ($request->attribute_values as $attrId => $values) {

                            foreach ($values as $valId) {

                                $attrValue = AttributeValue::find($valId);

                                if ($attrValue && in_array($attrValue->value, $parts)) {

                                    VariantAttribute::create([
                                        'variant_id' => $variant->id,
                                        'attribute_id' => $attrId,
                                        'attribute_value_id' => $valId,
                                    ]);
                                }
                            }
                        }
                    }
                }
            } else {

                // ✅ SIMPLE PRODUCT
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->sku = 'SKU-' . uniqid();
                $variant->price = $request->unit_price;
                $variant->tax = $request->tax ?? 0;
                $variant->discount = $request->discount ?? 0;
                $variant->save();

                ProductInventory::create([
                    'variant_id' => $variant->id,
                    'quantity' => $request->quantity
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard.page')
                ->with('success', '🔥 Product Added Successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage()); // debug
        }
    }

    public function getAttributeValues(Request $request)
    {
        $attributes = Attribute::with('AttributeValue')
            ->whereIn('id', $request->attribute_ids)
            ->get();

        $data = [];

        foreach ($attributes as $attr) {
            $data[] = [
                'id' => $attr->id,
                'name' => $attr->name,
                'values' => $attr->AttributeValue->map(function ($val) {
                    return [
                        'id' => $val->id,
                        'value' => $val->value
                    ];
                })
            ];
        }

        return response()->json($data);
    }
}
