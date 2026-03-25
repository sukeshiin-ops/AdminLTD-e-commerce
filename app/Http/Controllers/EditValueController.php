<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    // public function createe($id) {



    //    return view('admin.attribute.add-value');
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, $id)
    // {

    // dd($id);
    //     $data = $request->validate([
    //         'values' => 'required|array',
    //         'values.*' => 'required|string'
    //     ]);

    //     foreach($request->values as $newValue){
    //         AttributeValue::create([
    //             'value' => $data
    //         ]);
    //     }

    //      return redirect()->route('edit-value.show')->with('success', 'Deleted Successfully !!');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $allValue = Attribute::with('AttributeValue')->where('id', $id)->first();
        // return $allValue;
        return view('admin.attribute.edit-value', compact('allValue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $val = AttributeValue::where('id', $id)->first();

        return view('admin.attribute.update-value', compact('val'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'value' => 'required|string',
        ]);

        $val = AttributeValue::findOrFail($id);
        $val->update([
            'value' => $request->value,
        ]);

        return redirect()->route('edit-value.show', $val->attribute_id)
            ->with('success', 'Attribute value updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {

            $val = AttributeValue::findOr($id);
            $attId  = $val->attribute_id;

            AttributeValue::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('edit-value.show', $attId)->with('success', 'Deleted Successfully !!');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
