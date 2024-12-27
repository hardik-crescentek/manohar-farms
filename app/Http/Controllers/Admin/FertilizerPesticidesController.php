<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FertilizerPesticide;
use Illuminate\Http\Request;

class FertilizerPesticidesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fertilizerPesticides = FertilizerPesticide::orderBy('id', 'desc')->get();
        $data['fertilizerPesticides'] = $fertilizerPesticides;

        return view('fertilizer-pesticides.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fertilizer-pesticides.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        $createFP = FertilizerPesticide::create([
            'price' => $request->price,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($createFP) {
            return redirect()->route('fertilizer-pesticides.index')->with(['success' => true, 'message' => 'Fertilizer Pesticides added successfully!']);
        } else {
            return redirect()->route('fertilizer-pesticides.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fertilizerPesticides = FertilizerPesticide::where('id', $id)->first();
        $data['fertilizerPesticides'] = $fertilizerPesticides;

        return view('fertilizer-pesticides.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'quantity' => 'required',
            'price' => 'required'
        ]);

        $updateFP = FertilizerPesticide::where('id', $id)->update([
            'price' => $request->price,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($updateFP) {
            return redirect()->route('fertilizer-pesticides.index')->with(['success' => true, 'message' => 'Fertilizer Pesticides updated successfully!']);
        } else {
            return redirect()->route('fertilizer-pesticides.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteFP = FertilizerPesticide::where('id', $id)->delete();

        if($deleteFP) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function compostIndex() {
        
        return view('compost-fertilizer.list');
    }

    public function compostCreate() {

        return view('compost-fertilizer.add');
    }
}
