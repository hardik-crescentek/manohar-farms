<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Plant;
use App\Models\WaterEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $lands = Land::with('plant')->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $lands], 200);
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
                'name' => 'required|max:120',
                'plant_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'address' => 'required',
                'plants' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $fileName = apiFileUpload('lands', $request->image);

            $createLand = Land::create([
                'image' => $fileName,
                'name' => $request->name,
                'plant_id' => $request->plant_id,
                'address' => $request->address,
                'plants' => $request->plants
            ]);

            if ($createLand) {
                return response()->json(['status' => 200, 'message' => 'Land added successfully!', 'data' => $createLand], 200);
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
            $land = Land::findOrFail($id);
            $plants = Plant::pluck('name', 'id')->toArray();
            return response()->json(['status' => 200, 'data' => ['land' => $land, 'plants' => $plants]], 200);
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
                'name' => 'required|max:120',
                'plant_id' => 'required',
                'address' => 'required',
                'plants' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateLand = Land::where('id', $id)->update([
                'name' => $request->name,
                'plant_id' => $request->plant_id,
                'address' => $request->address,
                'plants' => $request->plants
            ]);

            if ($request->image != '') {
                $land = Land::where('id', $id)->first();

                if (isset($land->image) && $land->image != null) {
                    $fileName = fileUpload('lands', $request->image, $land->image);
                } else {
                    $fileName = fileUpload('lands', $request->image);
                }

                $land->image = $fileName;
                $land->save();
            }

            if ($updateLand) {
                return response()->json(['status' => 200, 'message' => 'Land updated successfully!', 'data' => $updateLand], 200);
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
            $deleteLand = Land::where('id', $id)->delete();

            if ($deleteLand) {
                return response()->json(['status' => 200, 'message' => 'Land deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting land');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function saveWater(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'land_id' => 'required',
                'land_part_id' => 'required',
                'date' => 'required',
                'time' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createWaterEntry = WaterEntry::create([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person,
                'volume' => $request->volume,
                'notes' => $request->notes
            ]);

            if ($createWaterEntry) {
                return response()->json(['status' => 200, 'message' => 'Water Entry added successfully!', 'data' => $createWaterEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getWaterLandPartWise(Request $request, $id) {

        try {
            $waterEntries = WaterEntry::whereJsonContains('land_part_id', $id)->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $waterEntries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateWaterLandPartWise(Request $request, $id)
    {
        try {
            // Validate the input data
            $validator = Validator::make($request->all(), [
                'land_id' => 'required',
                'land_part_id' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Find the water entry
            $waterEntry = WaterEntry::find($id);

            if (!$waterEntry) {
                throw new \Exception('Water entry not found.');
            }

            // Update the water entry
            $waterEntry->update([
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person,
                'volume' => $request->volume,
                'notes' => $request->notes,
            ]);

            return response()->json(['status' => 200, 'message' => 'Water Entry updated successfully!', 'data' => $waterEntry], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function destroyWaterLandPartWise(string $id)
    {
        try {
            $deleteWaterEntry = WaterEntry::where('id', $id)->delete();

            if ($deleteWaterEntry) {
                return response()->json(['status' => 200, 'message' => 'Water entry deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting water entry');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
