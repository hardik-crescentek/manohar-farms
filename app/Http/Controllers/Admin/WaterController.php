<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Water;
use Illuminate\Http\Request;

class WaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $waters = Water::with('land')->orderBy('id', 'desc')->get();
        $data['waters'] = $waters;

        return view('water.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('water.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'land_id' => 'required',
            'source' => 'required',
            'volume' => 'required',
            'price' => 'required',
            'date' => 'required'
        ]);

        $createWater = Water::create([
            'land_id' => $request->land_id,
            'source' => $request->source,
            'volume' => $request->volume,
            'price' => $request->price,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($createWater) {
            return redirect()->route('water.index')->with(['success' => true, 'message' => 'Water added successfully!']);
        } else {
            return redirect()->route('water.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $water = Water::where('id', $id)->first();
        $data['water'] = $water;

        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('water.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'land_id' => 'required',
            'source' => 'required',
            'volume' => 'required',
            'price' => 'required',
            'date' => 'required'
        ]);

        $updateWater = Water::where('id', $id)->update([
            'land_id' => $request->land_id,
            'source' => $request->source,
            'volume' => $request->volume,
            'price' => $request->price,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($updateWater) {
            return redirect()->route('water.index')->with(['success' => true, 'message' => 'Water updated successfully!']);
        } else {
            return redirect()->route('water.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteWater = Water::where('id', $id)->delete();

        if($deleteWater) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
