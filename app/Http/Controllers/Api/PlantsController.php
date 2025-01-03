<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     try {
    //         $plants = Plant::orderBy('id', 'desc')->get();
    //         $totalPlants = Plant::count();

    //         $data['totalPlants'] = $totalPlants;
    //         $data['plants'] = $plants;

    //         return response()->json(['status' => 200, 'data' => $data], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
    //     }
    // }

    // Test index Fnc for an name based catagrize
    public function index()
    {
        try {
            // Fetch all plants and group them by name (case-insensitively)
            $plants = Plant::select('id', 'name') // Fetch only necessary columns
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy(function ($plant) {
                    return strtolower($plant->name); // Group by lowercase name
                });

            // Count the total plants
            $totalPlants = Plant::count();

             // Group by plant name and calculate the total quantity for each category
            $categoryPlants = $plants->groupBy('name')->map(function ($group) {
                return [
                    'name' => $group->first()->name,
                    'total_quantity' => $group->sum('quantity'),
                ];
            })->values();

            $data['totalPlants'] = $totalPlants;
            $data['plants'] = $plants;
            $data['category_plants'] = $categoryPlants;

            return response()->json(['status' => 200, 'data' => $data], 200);
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

            $fileName = '';
            if ($request->image != '') {
                // for vue
                // $fileName = fileUpload('plants', $request->image);
                $fileName = apiFileUpload('plants', $request->image);
            }

            $plant = Plant::create([
                'image' => $fileName,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'nursery' => $request->nursery,
                'price' => $request->price,
                'location' => $request->location,
                'area' => $request->area,
                'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
            ]);

            return response()->json(['status' => 200, 'message' => 'Plant added successfully!', 'data' => $plant], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
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

            $plant = Plant::find($id);

            if (!$plant) {
                throw new \Exception('Plant not found');
            }

            $plant->update([
                'name' => $request->name,
                'quantity' => $request->quantity,
                'nursery' => $request->nursery,
                'price' => $request->price,
                'location' => $request->location,
                'area' => $request->area,
                'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
            ]);

            if ($request->image != '') {
                $fileName = apiFileUpload('plants', $request->image, $plant->image ?? null);
                $plant->image = $fileName;
                $plant->save();
            }

            return response()->json(['status' => 200, 'message' => 'Plant updated successfully!', 'data' => $plant], 200);
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
            $plant = Plant::find($id);

            if (!$plant) {
                throw new \Exception('Plant not found');
            }

            $plant->delete();
            return response()->json(['status' => 200, 'message' => 'Plant deleted successfully', 'data' => []], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    // Test Fnc for an get an perticuler plant based on a
    public function getPlantsByCategory(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'name' => 'nullable', // Optional string for name
                'id' => 'nullable', // Optional integer for ID
            ]);

            // Fetch based on `id` or `name`
            $plantId = $request->input('id');
            $plantName = strtolower($request->input('name')); // Convert to lowercase for case-insensitive comparison

            $plants = collect(); // Initialize empty collection for plants

            if ($plantId) {
                // Fetch plant by ID
                $plants = Plant::where('id', $plantId)->get();
            } elseif ($plantName) {
                // Fetch plants by name (case-insensitively)
                $plants = Plant::whereRaw('LOWER(name) = ?', [$plantName])->get();
            }

            // If no results found
            if ($plants->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No plants found for the given criteria.', 'data' => []], 404);
            }

            // Prepare response data
            $data = [
                'criteria' => $plantId ? "ID: $plantId" : "Name: " . ucfirst($plantName),
                'plants' => $plants,
            ];

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
