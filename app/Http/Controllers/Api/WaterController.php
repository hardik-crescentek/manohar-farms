<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $waters = Water::with('land')->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $waters], 200);
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
                'land_id' => 'required',
                'source' => 'required',
                'volume' => 'required',
                'price' => 'required',
                'date' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createWater = Water::create([
                'land_id' => $request->land_id,
                'source' => $request->source,
                'volume' => $request->volume,
                'price' => $request->price,
                'date' => date('Y-m-d', strtotime($request->date))
            ]);

            if ($createWater) {
                return response()->json(['status' => 200, 'message' => 'Water added successfully!', 'data' => $createWater], 200);
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
            $water = Water::findOrFail($id);
            $lands = Land::pluck('name', 'id')->toArray();
            return response()->json(['status' => 200, 'data' => ['water' => $water, 'lands' => $lands]], 200);
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
                'land_id' => 'required',
                'source' => 'required',
                'volume' => 'required',
                'price' => 'required',
                'date' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateWater = Water::where('id', $id)->update([
                'land_id' => $request->land_id,
                'source' => $request->source,
                'volume' => $request->volume,
                'price' => $request->price,
                'date' => date('Y-m-d', strtotime($request->date))
            ]);

            if ($updateWater) {
                return response()->json(['status' => 200, 'message' => 'Water updated successfully!', 'data' => $updateWater], 200);
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
            $deleteWater = Water::where('id', $id)->delete();

            if ($deleteWater) {
                return response()->json(['status' => 200, 'message' => 'Water deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting water');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
