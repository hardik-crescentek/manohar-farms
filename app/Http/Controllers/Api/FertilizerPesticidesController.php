<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerPesticide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FertilizerPesticidesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $fertilizerPesticides = FertilizerPesticide::orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $fertilizerPesticides], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
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
                'quantity' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createFP = FertilizerPesticide::create([
                'price' => $request->price,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'date' => date('Y-m-d', strtotime($request->date))
            ]);

            return response()->json(['status' => 200, 'message' => 'Fertilizer Pesticides added successfully!', 'data' => $createFP], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $fertilizerPesticides = FertilizerPesticide::find($id);

            if (!$fertilizerPesticides) {
                throw new \Exception('Fertilizer Pesticides not found');
            }

            return response()->json(['status' => 200, 'data' => $fertilizerPesticides], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage(), 'data' => []], 404);
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
                'quantity' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $fertilizerPesticides = FertilizerPesticide::find($id);

            if (!$fertilizerPesticides) {
                throw new \Exception('Fertilizer Pesticides not found');
            }

            $fertilizerPesticides->update([
                'price' => $request->price,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'date' => date('Y-m-d', strtotime($request->date))
            ]);

            return response()->json(['status' => 200, 'message' => 'Fertilizer Pesticides updated successfully!', 'data' => $fertilizerPesticides], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteFP = FertilizerPesticide::find($id);

            if (!$deleteFP) {
                throw new \Exception('Fertilizer Pesticides not found');
            }

            $deleteFP->delete();
            return response()->json(['status' => 200, 'message' => 'Fertilizer Pesticides deleted successfully', 'data' => []], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
