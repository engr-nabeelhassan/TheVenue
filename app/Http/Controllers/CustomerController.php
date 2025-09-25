<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $searchQuery = trim((string) $request->input('q'));

        $customers = Customer::query()
            ->when($searchQuery !== '', function ($query) use ($searchQuery) {
                $query->where('full_name', 'like', "%{$searchQuery}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'cnic' => ['required', 'string', 'max:50', 'unique:customers,cnic'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('status', 'Customer created successfully.');
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'cnic' => ['required', 'string', 'max:50', 'unique:customers,cnic,' . $customer->id],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('status', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('status', 'Customer deleted successfully.');
    }
}


