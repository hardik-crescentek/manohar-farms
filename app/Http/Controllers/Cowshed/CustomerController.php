<?php

namespace App\Http\Controllers\Cowshed;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('cowshed.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('cowshed.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'milk' => 'required|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('cowshed.customers.index')->with(['success' => true, 'message' => 'Customer created successfully!']);
    }

    public function edit(Customer $customer)
    {
        return view('cowshed.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'milk' => 'required|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('cowshed.customers.index')->with(['success' => true, 'message' => 'Customer updated successfully!']);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('cowshed.customers.index')->with(['success' => true, 'message' => 'Customer deleted successfully!']);
    }
}
