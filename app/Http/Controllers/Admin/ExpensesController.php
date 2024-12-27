<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::orderBy('id', 'desc')->get();
        $data['expenses'] = $expenses;

        return view('expenses.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'amount' => 'required',
            'date' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('expenses', $request->image);
        }

        $createExpense = Expense::create([
            'name' => $request->name,
            'image' => $fileName,
            'amount' => $request->amount,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($createExpense) {
            return redirect()->route('expenses.index')->with(['success' => true, 'message' => 'Expense added successfully!']);
        } else {
            return redirect()->route('expenses.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::where('id', $id)->first();
        $data['expense'] = $expense;

        return view('expenses.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'amount' => 'required',
            'date' => 'required'
        ]);

        $updateExpense = Expense::where('id', $id)->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($request->hasFile('image')){
            $expense = Expense::where('id', $id)->first();

            if(isset($expense->image) && $expense->image != null) {
    
                $fileName = fileUpload('expenses', $request->image, $expense->image);
    
            } else {
    
                $fileName = fileUpload('expenses', $request->image);
            }

            $expense->image = $fileName;
            $expense->save();
        }

        if($updateExpense) {
            return redirect()->route('expenses.index')->with(['success' => true, 'message' => 'Expense updated successfully!']);
        } else {
            return redirect()->route('expenses.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteExpense = Expense::where('id', $id)->delete();

        if($deleteExpense) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
