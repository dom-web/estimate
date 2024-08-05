<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Estimate;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all()->map(function ($customer) {
            $estimatesCount = Estimate::where('customer_id', $customer->id)->count();
            $orderedEstimatesCount = Estimate::where('customer_id', $customer->id)->where('ordered', true)->count();

            return [
                'customer' => $customer,
                'estimates_count' => $estimatesCount,
                'ordered_estimates_count' => $orderedEstimatesCount,
                'order_rate' => $estimatesCount > 0 ? ($orderedEstimatesCount / $estimatesCount) * 100 : 0
            ];
        });

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'kana' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'tel' => 'required',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'kana' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'tel' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
