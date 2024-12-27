<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FilterHistory;
use App\Models\BoreWells;

class FilterHistoryController extends Controller
{
    public function index($id) {

        $boreWells = BoreWells::where('id', $id)->first();
        $data['boreWells'] = $boreWells;
        
        $filterHistory = FilterHistory::where('bore_wells_id', $id)->get();
        $data['filterHistory'] = $filterHistory;

        return view('filter-history.list', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $boreWells = BoreWells::where('id', $id)->first();
        $data['boreWell'] = $boreWells;

        return view('filter-history.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $boreWellsId = $request->bore_wells_id;
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'last_cleaning_date' => 'required'
        ]);

        $boreWells = FilterHistory::create([
            'name' => $request->name,
            'company' => $request->company,
            'location' => $request->location,
            'last_cleaning_date' => date('Y-m-d', strtotime($request->last_cleaning_date)),
            'bore_wells_id' => $boreWellsId ?? 0,
            'filter_notification' => $request->filter_notification,
        ]);


        if($boreWells) {
            return redirect()->route('filter-history.index', $boreWellsId)->with(['success' => true, 'message' => 'Filter History added successfully!']);
        } else {
            return redirect()->route('filter-history.index', $boreWellsId)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $boreWells = BoreWells::where('id', $id)->first();
        $data['boreWell'] = $boreWells;
        $filterHistory = FilterHistory::findOrFail($id);
        $data['filterHistory'] = $filterHistory;
        return view('filter-history.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $boreWellsId = $request->bore_wells_id;
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'last_cleaning_date' => 'required'
        ]);

        $updateWater = FilterHistory::where('id', $id)->update([
            'name' => $request->name,
            'company' => $request->company,
            'location' => $request->location,
            'last_cleaning_date' => date('Y-m-d', strtotime($request->last_cleaning_date)),
            'bore_wells_id' => $boreWellsId ?? 0,
            'filter_notification' => $request->filter_notification,
        ]);

        if($updateWater) {
            return redirect()->route('filter-history.index', $boreWellsId)->with(['success' => true, 'message' => 'Filter History updated successfully!']);
        } else {
            return redirect()->route('filter-history.index', $boreWellsId)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteFilterHistory = FilterHistory::where('id', $id)->delete();

        if($deleteFilterHistory) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
