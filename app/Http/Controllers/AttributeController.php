<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    public function showAttribue()
    {

        $attribute = Attribute::get();

        return view('admin.attribute.all-attribute', compact('attribute'));
    }

    public function deleteAttribute($id)
    {


        DB::beginTransaction();
        try {
            Attribute::where('id', $id)->delete();
            DB::commit();

            return redirect()->route('show.all.attribute')->with('success', 'Attribute Deleted Successfully !!!');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->route('show.all.attribute')->with('error', $e->getMessage());
        }
    }


    public function edit()
    {
        return view('admin.attribute.add-attribute');
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validate([
                'name' => 'required|min:3',
                'values' => 'required|array',
                'values.*' => 'required|string'
            ]);


            $attribute =  Attribute::create([
                'name' => $request->name
            ]);


            foreach ($request->values as $attData) {
                $attribute->AttributeValue()->create([
                    'value' => $attData
                ]);
            }



            DB::commit();

            return redirect()->route('show.all.attribute')->with('success', 'Attribute Deleted Successfully !!!');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->route('show.all.attribute')->with('error', $e->getMessage());
        }
    }


    public function  updatePage($id)
    {

        $alldata = Attribute::where('id', $id)->first();
        return view('admin.attribute.edit-attrtibute', compact('alldata'));
    }





    public function updateAttribute(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validate([
                'name' => 'required|min:3',
                'value.*' => 'nullable|string',
            ]);


            Attribute::where('id', $id)->update([
                'name' => $request->name
            ]);


            if ($request->has('value')) {
                $attribute = Attribute::findOrFail($id);


                $attribute->AttributeValue()->delete();


                foreach ($request->value as $val) {
                    if (!empty($val)) {
                        $attribute->AttributeValue()->create(['value' => $val]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('show.all.attribute')->with('success', 'Attribute Updated Successfully !!!');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->route('show.all.attribute')->with('error', $e->getMessage());
        }
    }



    public function createValue($id)
    {

        $attribute = Attribute::with('AttributeValue')->where('id', $id)->get();
        return view('admin.attribute.add-value', compact('attribute'));
    }


    public function storeValue(Request $request, $id)
    {

        $data = $request->validate([
            'values' => 'required|array',
            'values.*' => 'required|string'
        ]);


        foreach ($request->values as $newValue) {
            AttributeValue::create([
                'attribute_id' => $id,
                'value' => $newValue
            ]);
        }

        return redirect()->route('show.all.attribute')->with('success', 'Deleted Successfully !!');
    }
}
