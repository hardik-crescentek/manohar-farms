<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\BoreWells;
use App\Models\FilterHistory;
use Illuminate\Http\Request;

class BoreWellsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boreWells = BoreWells::with('land')->orderBy('id', 'desc')->get();
        $data['boreWells'] = $boreWells;
        return view('bore-wells.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('bore-wells.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'land_id' => 'required',
            'status' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('bore_wells', $request->image);
        }

        $boreWells = BoreWells::create([
            'type' => $request->type,
            'land_id' => $request->land_id,
            'image' => $fileName,
            'name' => $request->name,
            'depth' => $request->depth,
            'status' => $request->status,
            'filter' => $request->filter,
        ]);


        if($boreWells) {
            return redirect()->route('bore-wells.index')->with(['success' => true, 'message' => 'Bore & Wells Details added successfully!']);
        } else {
            return redirect()->route('bore-wells.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $types = ['bore' => 'bore', 'wells' => 'wells'];
        $data['types'] = $types;

        $status = ['active' => 'active', 'inactive' => 'InActive'];
        $data['status'] = $status;

        $boreWell = BoreWells::where('id', $id)->first();
        $data['boreWell'] = $boreWell;

        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        // Return view with data
        return view('bore-wells.edit',$data);
    }

    public function update(Request $request, BoreWells $boreWell)
    {
        $request->validate([
            'type' => 'required',
            'land_id' => 'required',
            'status' => 'required'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $fileName = fileUpload('bore_wells', $request->file('image'), $boreWell->image);
        } else {
            $fileName = $boreWell->image;
        }

        $updateBoreWells = $boreWell->update([
            'type' => $request->type,
            'land_id' => $request->land_id,
            'name' => $request->name,
            'depth' => $request->depth,
            'image' => $fileName,
            'status' => $request->status,
        ]);

        if($updateBoreWells) {
            return redirect()->route('bore-wells.index')->with(['success' => true, 'message' => 'Bore & Wells Dateails updated successfully!']);
        } else {
            return redirect()->route('bore-wells.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteBoreWells = BoreWells::where('id', $id)->delete();

        if($deleteBoreWells) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
