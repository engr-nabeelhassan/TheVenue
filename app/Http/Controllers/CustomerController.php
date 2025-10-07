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

        // Sorting params with whitelisting
        $sortableColumns = ['id', 'full_name', 'cnic', 'phone', 'address', 'created_at'];
        $sort = $request->input('sort', 'created_at');
        if (!in_array($sort, $sortableColumns, true)) {
            $sort = 'created_at';
        }
        $direction = strtolower((string) $request->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Per page selection with sensible bounds
        $perPage = (int) $request->input('per_page', 10);
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        $customers = Customer::query()
            ->when($searchQuery !== '', function ($query) use ($searchQuery) {
                $query->where('full_name', 'like', "%{$searchQuery}%");
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
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
        // Check if customer has any bookings
        if ($customer->bookings()->exists()) {
            return redirect()->route('customers.index')
                ->with('error', 'Cannot delete customer. This customer has existing bookings.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('status', 'Customer deleted successfully.');
    }
}


