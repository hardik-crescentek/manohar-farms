<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DieselEntry;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DieselEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dieselEntries = DieselEntry::with('vehicle')->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $dieselEntries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'volume' => 'required',
                'vehicle_id' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createDieselEntry = DieselEntry::create([
                'vehicle_id' => $request->vehicle_id,
                'volume' => $request->volume,
                'payment_person' => $request->payment_person,
                'date' => date('Y-m-d', strtotime($request->date)),
                'amount' => $request->amount
            ]);

            if ($createDieselEntry) {
                return response()->json(['status' => 200, 'message' => 'Diesel entry added successfully!', 'data' => $createDieselEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $dieselEntry = DieselEntry::findOrFail($id);
            $vehicles = Vehicle::where('type', 1)->pluck('name', 'id')->toArray();
            return response()->json(['status' => 200, 'data' => ['dieselEntry' => $dieselEntry, 'vehicles' => $vehicles]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'volume' => 'required',
                'vehicle_id' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateDieselEntry = DieselEntry::where('id', $id)->update([
                'vehicle_id' => $request->vehicle_id,
                'volume' => $request->volume,
                'payment_person' => $request->payment_person,
                'date' => date('Y-m-d', strtotime($request->date)),
                'amount' => $request->amount
            ]);

            if ($updateDieselEntry) {
                return response()->json(['status' => 200, 'message' => 'Diesel entry updated successfully!', 'data' => $updateDieselEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteDieselEntry = DieselEntry::where('id', $id)->delete();

            if ($deleteDieselEntry) {
                return response()->json(['status' => 200, 'message' => 'Diesel entry deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting diesel entry');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
