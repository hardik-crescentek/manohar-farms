<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $bills = Bill::orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $bills], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $lands = Land::pluck('name', 'id')->toArray();
            return response()->json(['status' => 200, 'data' => ['lands' => $lands]], 200);
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
                'type' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $fileName = '';
            if ($request->image != '') {
                $fileName = apiFileUpload('bills', $request->image);
            }

            $createBill = Bill::create([
                'image' => $fileName,
                'type' => $request->type,
                'land_id' => $request->land_id,
                'payment_person' => $request->payment_person,
                'amount' => $request->amount,
                'period_start' => date('Y-m-d', strtotime($request->period_start)),
                'period_end' => date('Y-m-d', strtotime($request->period_end)),
                'due_date' => date('Y-m-d', strtotime($request->due_date)),
                'status' => $request->status ?? 0
            ]);

            if ($createBill) {
                return response()->json(['status' => 200, 'message' => 'Bill added successfully!', 'data' => $createBill], 200);
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
            $bill = Bill::findOrFail($id);
            $lands = Land::pluck('name', 'id')->toArray();
            return response()->json(['status' => 200, 'data' => ['bill' => $bill, 'lands' => $lands]], 200);
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
                'type' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateBill = Bill::find($id);

            if (!$updateBill) {
                throw new \Exception('Bill not found');
            }

            $updateBill->update([
                'type' => $request->type,
                'land_id' => $request->land_id,
                'payment_person' => $request->payment_person,
                'amount' => $request->amount,
                'period_start' => date('Y-m-d', strtotime($request->period_start)),
                'period_end' => date('Y-m-d', strtotime($request->period_end)),
                'due_date' => date('Y-m-d', strtotime($request->due_date)),
                'status' => $request->status
            ]);

            if ($request->image != '') {
                $fileName = apiFileUpload('bills', $request->image, $updateBill->image ?? null);
                $updateBill->image = $fileName;
                $updateBill->save();
            }

            if ($updateBill) {
                return response()->json(['status' => 200, 'message' => 'Bill updated successfully!', 'data' => $updateBill], 200);
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
            $deleteBill = Bill::where('id', $id)->delete();

            if ($deleteBill) {
                return response()->json(['status' => 200, 'message' => 'Bill deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting bill');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
