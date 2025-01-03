<?php

namespace App\Http\Controllers\Admin;

use App\Models\PlotFertilizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PlotFertilizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'land_part_id' => 'required|array',
            'fertilizer_name' => 'required|string',
            'quantity' => 'required|integer',
            'date' => 'required',
            'time' => 'required',
        ]);

        // Loop over each selected land part ID to create fertilizer entry

            $createFertilizerEntry = PlotFertilizer::create([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'fertilizer_name' => $request->fertilizer_name,
                'quantity' => $request->quantity,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person,
                'note' => $request->note,
            ]);


        // Return a response based on the success of the creation
        if ($createFertilizerEntry) {
            return redirect()->route('lands.maps', $request->land_id)
                ->with(['success' => true, 'message' => 'Fertilizer Entry added successfully!']);
        } else {
            return redirect()->route('lands.maps', $request->land_id)
                ->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(PlotFertilizer $plotFertilizer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlotFertilizer $plotFertilizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlotFertilizer $plotFertilizer)
    {
        // Validate the incoming request
        $request->validate([
            'land_part_id' => 'required|array',
            'fertilizer_name' => 'required|string',
            'quantity' => 'required|integer',
            'date' => 'required',
            'time' => 'required',
        ]);

        // Loop over each selected land part ID to update fertilizer entry

            $plotFertilizerUpdate = $plotFertilizer->update([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'fertilizer_name' => $request->fertilizer_name,
                'quantity' => $request->quantity,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person,
                'note' => $request->note,
            ]);


        // Return a response based on the success of the update
        if ($plotFertilizerUpdate) {
            return redirect()->route('lands.maps', $request->land_id)
                ->with(['success' => true, 'message' => 'Fertilizer Entry Updated successfully!']);
        } else {
            return redirect()->route('lands.maps', $request->land_id)
                ->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlotFertilizer $plotFertilizer)
    {
        $deleteplotFertilizer = $plotFertilizer->delete();

        if($deleteplotFertilizer) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
