<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::orderBy('id', 'desc')->get();
        $data['bills'] = $bills;

        return view('bills.list', $data);
    }

    public function getTable(Request $request) {

        $type = $request->type;

        $query = Bill::orderBy('id', 'desc');

        if(isset($type) && $type != 2) {
            $query->where('status', $type);
        }

        $bills = $query->get();
        $data['bills'] = $bills;
        return View::make('bills.Ajax.table', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('bills.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('bills', $request->image);
        }

        $createBill = Bill::create([
            'type' => $request->type,
            'image' => $fileName,
            'land_id' => $request->land_id,
            'payment_person' => $request->payment_person,
            'amount' => $request->amount,
            'period_start' => isset($request->period_start) && $request->period_start != null ? date('Y-m-d', strtotime($request->period_start)) : NULL,
            'period_end' => isset($request->period_end) && $request->period_end != null ? date('Y-m-d', strtotime($request->period_end)) : NULL,
            'due_date' => isset($request->due_date) && $request->due_date != null ? date('Y-m-d', strtotime($request->due_date)) : NULL,
            'status' => $request->status
        ]);

        if($createBill) {
            return redirect()->route('bills.index')->with(['success' => true, 'message' => 'Bill added successfully!']);
        } else {
            return redirect()->route('bills.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $bill = Bill::where('id', $id)->first();
        $data['bill'] = $bill;

        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('bills.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required'
        ]);

        $updateBill = Bill::where('id', $id)->update([
            'type' => $request->type,
            'land_id' => $request->land_id,
            'payment_person' => $request->payment_person,
            'amount' => $request->amount,
            'period_start' => isset($request->period_start) && $request->period_start != null ? date('Y-m-d', strtotime($request->period_start)) : NULL,
            'period_end' => isset($request->period_end) && $request->period_end != null ? date('Y-m-d', strtotime($request->period_end)) : NULL,
            'due_date' => isset($request->due_date) && $request->due_date != null ? date('Y-m-d', strtotime($request->due_date)) : NULL,
            'status' => $request->status
        ]);

        if($request->hasFile('image')){
            $bill = Bill::where('id', $id)->first();

            if(isset($bill->image) && $bill->image != null) {

                $fileName = fileUpload('bills', $request->image, $bill->image);

            } else {

                $fileName = fileUpload('bills', $request->image);
            }

            $bill->image = $fileName;
            $bill->save();
        }

        if($updateBill) {
            return redirect()->route('bills.index')->with(['success' => true, 'message' => 'Bill updated successfully!']);
        } else {
            return redirect()->route('bills.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteBill = Bill::where('id', $id)->delete();

        if($deleteBill) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
