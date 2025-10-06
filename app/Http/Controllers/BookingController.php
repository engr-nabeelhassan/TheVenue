<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::with('customer');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('invoice_date', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        // Filter by event status
        if ($request->filled('event_status')) {
            $query->where('event_status', $request->event_status);
        }

        // Filter by invoice date
        if ($request->filled('invoice_date_from')) {
            $query->where('invoice_date', '>=', $request->invoice_date_from);
        }
        if ($request->filled('invoice_date_to')) {
            $query->where('invoice_date', '<=', $request->invoice_date_to);
        }

        // Sorting
        $sortField = $request->get('sort', 'invoice_date');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort field
        $allowedSortFields = ['invoice_date', 'customer_name', 'event_type', 'event_start_at', 'event_end_at', 'event_status'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'invoice_date';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = (int) $request->get('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $bookings = $query->paginate($perPage)->appends($request->query());

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request): View
    {
        $latestCustomer = Customer::latest()->first();
        $today = now()->toDateString();
        $selectedDate = $request->get('date', $today);

        return view('bookings.create', [
            'latestCustomer' => $latestCustomer,
            'today' => $today,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'invoice_date' => ['required', 'date'],
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'in:Wedding,Birthday,Corporate,Other'],
            'event_status' => ['required', 'in:In Progress,Completed,Cancelled,Postponed'],
            'total_guests' => ['required', 'integer', 'min:0'],
            'event_start_at' => ['required', 'date'],
            'event_end_at' => ['required', 'date', 'after_or_equal:event_start_at'],
            'payment_status' => ['required', 'in:Cash,Cheque,Online Transaction'],
            'payment_option' => ['nullable', 'in:advance,full'],
            'advance_amount' => ['nullable', 'numeric', 'min:0'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.sr_no' => ['required', 'integer', 'min:1'],
            'items.*.item_description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:0'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
            'items.*.discount_type' => ['required', 'in:percent,lump'],
            'items.*.discount_value' => ['required', 'numeric', 'min:0'],
            'items.*.net_amount' => ['required', 'numeric', 'min:0'],

            'items_subtotal' => ['required', 'numeric', 'min:0'],
            'items_discount_amount' => ['required', 'numeric', 'min:0'],
            'invoice_net_amount' => ['required', 'numeric', 'min:0'],
            'invoice_total_paid' => ['required', 'numeric', 'min:0'],
            'invoice_closing_amount' => ['required', 'numeric', 'min:0'],
            'amount_in_words' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        $booking = null;

        DB::transaction(function () use ($validated, &$booking) {
            $booking = Booking::create([
                'invoice_date' => $validated['invoice_date'],
                'customer_id' => $validated['customer_id'],
                'customer_name' => $validated['customer_name'],
                'event_type' => $validated['event_type'],
                'event_status' => $validated['event_status'],
                'total_guests' => $validated['total_guests'],
                'event_start_at' => $validated['event_start_at'],
                'event_end_at' => $validated['event_end_at'],
                'payment_status' => $validated['payment_status'],
                'payment_option' => $validated['payment_option'] ?? null,
                'advance_amount' => $validated['advance_amount'] ?? 0,
                'items_subtotal' => $validated['items_subtotal'],
                'items_discount_amount' => $validated['items_discount_amount'],
                'invoice_net_amount' => $validated['invoice_net_amount'],
                'invoice_total_paid' => $validated['invoice_total_paid'],
                'invoice_closing_amount' => $validated['invoice_closing_amount'],
                'amount_in_words' => $validated['amount_in_words'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $booking->items()->create([
                    'sr_no' => $item['sr_no'],
                    'item_description' => $item['item_description'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'discount_type' => $item['discount_type'],
                    'discount_value' => $item['discount_value'],
                    'net_amount' => $item['net_amount'],
                ]);
            }
        });

        if ($request->input('action') === 'save_and_print' && $booking) {
            return redirect()->route('bookings.invoice', $booking);
        }

        return redirect()->route('bookings.index')->with('status', 'Booking saved successfully.');
    }

    public function show(Booking $booking): View
    {
        $booking->load(['customer', 'items']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): View
    {
        $booking->load(['customer', 'items']);
        $latestCustomer = Customer::latest()->first();
        $today = now()->toDateString();
        
        return view('bookings.edit', compact('booking', 'latestCustomer', 'today'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'invoice_date' => ['required', 'date'],
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'in:Wedding,Birthday,Corporate,Other'],
            'total_guests' => ['required', 'integer', 'min:0'],
            'event_start_at' => ['required', 'date'],
            'event_end_at' => ['required', 'date', 'after_or_equal:event_start_at'],
            'event_status' => ['required', 'in:In Progress,Completed,Cancelled,Postponed'],
            'payment_status' => ['required', 'in:Cash,Cheque,Online Transaction'],
            'payment_option' => ['nullable', 'in:advance,full'],
            'advance_amount' => ['nullable', 'numeric', 'min:0'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.sr_no' => ['required', 'integer', 'min:1'],
            'items.*.item_description' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:0'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
            'items.*.discount_type' => ['required', 'in:percent,lump'],
            'items.*.discount_value' => ['required', 'numeric', 'min:0'],
            'items.*.net_amount' => ['required', 'numeric', 'min:0'],

            'items_subtotal' => ['required', 'numeric', 'min:0'],
            'items_discount_amount' => ['required', 'numeric', 'min:0'],
            'invoice_net_amount' => ['required', 'numeric', 'min:0'],
            'invoice_total_paid' => ['required', 'numeric', 'min:0'],
            'invoice_closing_amount' => ['required', 'numeric', 'min:0'],
            'amount_in_words' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated, $booking) {
            $booking->update([
                'invoice_date' => $validated['invoice_date'],
                'customer_id' => $validated['customer_id'],
                'customer_name' => $validated['customer_name'],
                'event_type' => $validated['event_type'],
                'total_guests' => $validated['total_guests'],
                'event_start_at' => $validated['event_start_at'],
                'event_end_at' => $validated['event_end_at'],
                'event_status' => $validated['event_status'],
                'payment_status' => $validated['payment_status'],
                'payment_option' => $validated['payment_option'] ?? null,
                'advance_amount' => $validated['advance_amount'] ?? 0,
                'items_subtotal' => $validated['items_subtotal'],
                'items_discount_amount' => $validated['items_discount_amount'],
                'invoice_net_amount' => $validated['invoice_net_amount'],
                'invoice_total_paid' => $validated['invoice_total_paid'],
                'invoice_closing_amount' => $validated['invoice_closing_amount'],
                'amount_in_words' => $validated['amount_in_words'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Delete existing items and create new ones
            $booking->items()->delete();
            foreach ($validated['items'] as $item) {
                $booking->items()->create([
                    'sr_no' => $item['sr_no'],
                    'item_description' => $item['item_description'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'discount_type' => $item['discount_type'],
                    'discount_value' => $item['discount_value'],
                    'net_amount' => $item['net_amount'],
                ]);
            }
        });

        return redirect()->route('bookings.index')->with('status', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('status', 'Booking deleted successfully.');
    }

    public function invoice(Booking $booking)
    {
        $booking->load(['customer', 'items']);
        
        // Render Blade to HTML explicitly to ensure all directives are compiled
        $html = view('bookings.invoice', compact('booking'))->render();
        $pdf = Pdf::loadHTML($html)->setPaper('a4');
        return $pdf->download("invoice-{$booking->id}.pdf");
    }

    public function calendar(Request $request): View
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Get bookings for the selected month
        $bookings = Booking::whereYear('event_start_at', $year)
            ->whereMonth('event_start_at', $month)
            ->with('customer')
            ->get()
            ->groupBy(function ($booking) {
                return $booking->event_start_at->format('Y-m-d');
            });

        return view('bookings.calendar', compact('bookings', 'year', 'month'));
    }

    public function customerById(Request $request): array
    {
        $customerId = $request->query('customer_id');
        $customer = Customer::find($customerId);

        if (!$customer) {
            return ['found' => false];
        }

        return [
            'found' => true,
            'customer' => [
                'id' => $customer->id,
                'full_name' => $customer->full_name,
                'cnic' => $customer->cnic,
                'phone' => $customer->phone,
                'address' => $customer->address,
            ],
        ];
    }

    public function searchCustomers(Request $request): array
    {
        $query = $request->query('q', '');
        
        if (strlen($query) < 2) {
            return ['customers' => []];
        }

        $customers = Customer::where('full_name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('cnic', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'full_name', 'phone', 'cnic', 'address']);

        return [
            'customers' => $customers->map(function($customer) {
                return [
                    'id' => $customer->id,
                    'full_name' => $customer->full_name,
                    'phone' => $customer->phone,
                    'cnic' => $customer->cnic,
                    'address' => $customer->address,
                ];
            })
        ];
    }

    public function cancelled(Request $request): View
    {
        $query = Booking::with('customer')
            ->where('event_status', 'Cancelled');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('invoice_date', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('bookings.cancelled', compact('bookings'));
    }

    public function postponed(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->subMonths(3)->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));
        $search = $request->get('search');
        $sort = $request->get('sort', 'event_start_at');
        $direction = $request->get('direction', 'desc');
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = Booking::with('customer')
            ->where('event_status', 'Postponed')
            ->whereBetween('event_start_at', [$fromDate, $toDate]);

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortable = ['customer_name', 'event_type', 'event_start_at'];
        if (!in_array($sort, $sortable)) {
            $sort = 'event_start_at';
        }

        $query->orderBy($sort, $direction);

        $bookings = $query->paginate($perPage)->appends($request->query());

        return view('bookings.postponed', compact('bookings', 'fromDate', 'toDate'));
    }

    public function postponedPdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->subMonths(3)->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->format('Y-m-d'));
        $search = $request->get('search');

        $query = Booking::with('customer')
            ->where('event_status', 'Postponed')
            ->whereBetween('event_start_at', [$fromDate, $toDate]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('event_start_at', 'desc')->get();

        $pdf = Pdf::loadView('bookings.postponed-pdf', compact('bookings', 'fromDate', 'toDate'));
        return $pdf->download('postponed-bookings-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function upcoming(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->addMonths(3)->format('Y-m-d'));
        $search = $request->get('search');
        $sort = $request->get('sort', 'event_start_at');
        $direction = $request->get('direction', 'asc');
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = Booking::with('customer')
            ->where('event_status', '!=', 'Cancelled')
            ->where('event_status', '!=', 'Postponed')
            ->whereBetween('event_start_at', [$fromDate, $toDate]);

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortable = ['event_start_at', 'customer_name', 'event_type'];
        if (!in_array($sort, $sortable)) {
            $sort = 'event_start_at';
        }

        $query->orderBy($sort, $direction);

        $bookings = $query->paginate($perPage)->appends($request->query());

        return view('bookings.upcoming', compact('bookings', 'fromDate', 'toDate'));
    }

    public function upcomingPdf(Request $request)
    {
        $query = Booking::with('customer')
            ->where('event_status', '!=', 'Cancelled')
            ->where('event_status', '!=', 'Postponed')
            ->where('event_start_at', '>=', now());

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('event_start_at', 'asc')->get();

        $pdf = Pdf::loadView('bookings.upcoming-pdf', compact('bookings'));
        return $pdf->download('upcoming-events-' . now()->format('Y-m-d') . '.pdf');
    }
}


