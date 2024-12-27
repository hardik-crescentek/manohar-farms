<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlushHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlushHistoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'land_part_id' => 'required',
            'date' => 'required'
        ]);

        $createFlushHistory = FlushHistory::create([
            'user_id' => Auth::user()->id,
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'date' => date('Y-m-d', strtotime($request->date)),
            'person' => $request->person,
            'note' => $request->note
        ]);

        if($createFlushHistory) {
            return redirect()->route('lands.maps', $request->land_id)->with(['success' => true, 'message' => 'Flush Entry added successfully!']);
        } else {
            return redirect()->route('lands.maps', $request->land_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlushHistory $flushHistory)
    {
        $request->validate([
            'land_part_id' => 'required',
            'date' => 'required'
        ]);

        $flushHistoryUpdate = $flushHistory->update([
            'user_id' => Auth::user()->id,
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'date' => date('Y-m-d', strtotime($request->date)),
            'person' => $request->person,
            'note' => $request->note
        ]);

        if($flushHistoryUpdate) {
            return redirect()->route('lands.maps', $request->land_id)->with(['success' => true, 'message' => 'Flush Entry Updated successfully!']);
        } else {
            return redirect()->route('lands.maps', $request->land_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlushHistory $flushHistory)
    {
        $deleteFlushHistory = $flushHistory->delete();

        if($deleteFlushHistory) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
