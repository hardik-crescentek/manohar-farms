<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\GheeSelling;

class GheeSellingController extends Controller
{
    public function index()
    {
        $gheeSellings = GheeSelling::with('customer')->get();
        return view('cowshed.ghee_sellings.index', compact('gheeSellings'));
    }

    public function create()
    {
        $customers = Customer::pluck('name', 'id')->toArray();
        $data['customers'] = $customers;

        return view('cowshed.ghee_sellings.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('ghee', $request->image);
        }

        $gheeSelling = new GheeSelling([
            'image' => $fileName,
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'note' => $request->note,
        ]);

        $gheeSelling->save();

        return redirect()->route('cowshed.ghee-sellings.index')->with(['success' => true, 'message' => 'Ghee selling record added successfully!']);
    }

    public function edit(GheeSelling $gheeSelling)
    {
        $customers = Customer::pluck('name', 'id')->toArray();
        $data['customers'] = $customers;

        $data['gheeSelling'] = $gheeSelling;

        return view('cowshed.ghee_sellings.edit', $data);
    }

    public function update(Request $request, GheeSelling $gheeSelling)
    {
        $request->validate([
            'price' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $gheeSelling->update([
            'image' => $request->image,
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'note' => $request->note,
        ]);

        if($request->hasFile('image')){
            $expense = GheeSelling::where('id', $id)->first();

            if(isset($expense->image) && $expense->image != null) {
    
                $fileName = fileUpload('ghee', $request->image, $expense->image);
    
            } else {
    
                $fileName = fileUpload('ghee', $request->image);
            }

            $expense->image = $fileName;
            $expense->save();
        }

        return redirect()->route('cowshed.ghee-sellings.index')->with(['success' => true, 'message' => 'Ghee selling record updated successfully!']);
    }

    public function destroy(GheeSelling $gheeSelling)
    {
        $gheeSelling->delete();

        return redirect()->route('cowshed.ghee-sellings.index')->with('success', 'Ghee selling record deleted successfully!');
    }
}
