<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diesel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DieselManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $diesels = Diesel::orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $diesels], 200);
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
                'volume' => 'required|max:120',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $total = $request->volume * $request->price;

            $createDiesel = Diesel::create([
                'volume' => $request->volume,
                'price' => $request->price,
                'total_price' => $total,
                'payment_person' => $request->payment_person,
                'date' => date('Y-m-d', strtotime($request->date))
            ]);

            if ($createDiesel) {
                return response()->json(['status' => 200, 'message' => 'Diesel added successfully!', 'data' => $createDiesel], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $diesel = Diesel::findOrFail($id);
            return response()->json(['status' => 200, 'data' => $diesel], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $diesel = Diesel::findOrFail($id);
            return response()->json(['status' => 200, 'data' => $diesel], 200);
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
                'volume' => 'required|max:120',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $total = $request->volume * $request->price;

            $updateDiesel = Diesel::where('id', $id)->update([
                'volume' => $request->volume,
                'price' => $request->price,
                'total_price' => $total,
                'payment_person' => $request->payment_person,
                'date' => date('Y-m-d', strtotime($request->date))
            ]);

            if ($updateDiesel) {
                return response()->json(['status' => 200, 'message' => 'Diesel updated successfully!', 'data' => $updateDiesel], 200);
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
            $deleteDiesel = Diesel::where('id', $id)->delete();

            if ($deleteDiesel) {
                return response()->json(['status' => 200, 'message' => 'Diesel deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting diesel');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
