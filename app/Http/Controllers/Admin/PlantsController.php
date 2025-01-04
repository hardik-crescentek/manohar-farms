<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plants = Plant::orderBy('id', 'desc')->get();
        $data['plants'] = $plants;

        return view('plants.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plants.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'quantity' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('plants', $request->image);
        }

        $createPlant = Plant::create([
            'image' => $fileName,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'nursery' => $request->nursery,
            'price' => $request->price,
            'location' => $request->location,
            'area' => $request->area,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if ($createPlant) {
            return redirect()->route('plants.index')->with(['success' => true, 'message' => 'Plant added successfully!']);
        } else {
            return redirect()->route('plants.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $plant = Plant::where('id', $id)->first();
        $data['plant'] = $plant;

        return view('plants.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'quantity' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $updatePlant = Plant::where('id', $id)->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'nursery' => $request->nursery,
            'price' => $request->price,
            'location' => $request->location,
            'area' => $request->area,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if ($request->hasFile('image')) {
            $plant = Plant::where('id', $id)->first();

            if (isset($plant->image) && $plant->image != null) {

                $fileName = fileUpload('plants', $request->image, $plant->image);
            } else {

                $fileName = fileUpload('plants', $request->image);
            }

            $plant->image = $fileName;
            $plant->save();
        }

        if ($updatePlant) {
            return redirect()->route('plants.index')->with(['success' => true, 'message' => 'Plant updated successfully!']);
        } else {
            return redirect()->route('plants.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deletePlant = Plant::where('id', $id)->delete();

        if ($deletePlant) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
