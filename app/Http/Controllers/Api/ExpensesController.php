<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $expenses = Expense::orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $expenses], 200);
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
                'amount' => 'required',
                'date' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $fileName = '';
            if ($request->image != '') {
                $fileName = apiFileUpload('expenses', $request->image);
            }

            $createExpense = Expense::create([
                'image' => $fileName,
                'name' => $request->name,
                'amount' => $request->amount,
                'date' => date('Y-m-d', strtotime($request->date)),
                'payment_person' => $request->payment_person
            ]);

            if ($createExpense) {
                return response()->json(['status' => 200, 'message' => 'Expense added successfully!', 'data' => $createExpense], 200);
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
            $expense = Expense::findOrFail($id);
            return response()->json(['status' => 200, 'data' => $expense], 200);
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
            $expense = Expense::findOrFail($id);
            return response()->json(['status' => 200, 'data' => $expense], 200);
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
                'amount' => 'required',
                'date' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateExpense = Expense::find($id);

            if (!$updateExpense) {
                throw new \Exception('Expense not found');
            }

            $updateExpense->update([
                'name' => $request->name,
                'amount' => $request->amount,
                'date' => date('Y-m-d', strtotime($request->date)),
                'payment_person' => $request->payment_person
            ]);

            if ($request->image != '') {
                $fileName = apiFileUpload('expenses', $request->image, $updateExpense->image ?? null);
                $updateExpense->image = $fileName;
                $updateExpense->save();
            }

            if ($updateExpense) {
                return response()->json(['status' => 200, 'message' => 'Expense updated successfully!', 'data' => $updateExpense], 200);
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
            $deleteExpense = Expense::where('id', $id)->delete();

            if ($deleteExpense) {
                return response()->json(['status' => 200, 'message' => 'Expense deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting expense');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
