<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::with(['booking', 'customer']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        // Clone filtered query for totals BEFORE pagination
        $filtered = clone $query;

        // Paginate for table view
        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Totals across the filtered dataset (not just current page)
        $totalDebit = (clone $filtered)->where('payment_method', 'Debit')->sum('add_amount');
        $totalCredit = (clone $filtered)->where('payment_method', 'Credit')->sum('add_amount');

        // Total Balance = sum of remaining_balance from the latest payment per unique customer
        $latestPaymentIds = (clone $filtered)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('customer_id')
            ->pluck('id');

        $totalBalance = Payment::whereIn('id', $latestPaymentIds)->sum('remaining_balance');

        return view('payments.index', compact('payments', 'totalDebit', 'totalCredit', 'totalBalance'));
    }

    public function create(): View
    {
        $customers = Customer::orderBy('full_name')->get();
        return view('payments.create', compact('customers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'receipt_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:Debit,Credit'],
            'payment_status' => ['required', 'in:Cash,Cheque,Online Transaction'],
            'previous_balance' => ['required', 'numeric', 'min:0'],
            'add_amount' => ['required', 'numeric', 'min:0'],
            'remaining_balance' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $payment = Payment::create($validated);

        return redirect()->route('payments.index')->with('status', 'Payment collected successfully.');
    }

    public function edit(Payment $payment): View
    {
        $customers = Customer::orderBy('full_name')->get();
        $payment->load(['booking', 'customer']);
        return view('payments.edit', compact('payment', 'customers'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'receipt_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:Debit,Credit'],
            'payment_status' => ['required', 'in:Cash,Cheque,Online Transaction'],
            'previous_balance' => ['required', 'numeric', 'min:0'],
            'add_amount' => ['required', 'numeric', 'min:0'],
            'remaining_balance' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('status', 'Payment updated successfully.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['booking', 'customer']);
        
        $pdf = Pdf::loadView('payments.receipt', compact('payment'))->setPaper('a4');
        return $pdf->download("payment-receipt-{$payment->id}.pdf");
    }

    public function details(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $customerId = $request->input('customer_id');

        $query = Payment::with(['booking', 'customer']);

        if ($fromDate && $toDate) {
            $query->whereBetween('receipt_date', [$fromDate, $toDate]);
        }

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $payments = $query->orderBy('receipt_date')->get();
        $customer = $customerId ? Customer::find($customerId) : null;

        $pdf = Pdf::loadView('payments.details', compact('payments', 'customer', 'fromDate', 'toDate'));
        return $pdf->download("payment-details-{$fromDate}-to-{$toDate}.pdf");
    }

    public function getCustomerBalance(Request $request)
    {
        $customerId = $request->input('customer_id');
        $customer = Customer::find($customerId);

        if (!$customer) {
            return response()->json(['balance' => 0]);
        }

        // Get total invoice amount for customer
        $totalInvoiceAmount = Booking::where('customer_id', $customerId)->sum('invoice_net_amount');
        
        // Get total payments made by customer
        $totalPayments = Payment::where('customer_id', $customerId)
            ->where('payment_method', 'Credit')
            ->sum('add_amount');

        $balance = $totalInvoiceAmount - $totalPayments;

        return response()->json([
            'balance' => $balance,
            'customer_name' => $customer->full_name,
            'contact' => $customer->phone
        ]);
    }

    public function getCustomerBookings(Request $request)
    {
        $customerId = $request->input('customer_id');
        $bookings = Booking::where('customer_id', $customerId)
            ->select('id', 'invoice_date', 'invoice_net_amount')
            ->orderBy('invoice_date', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking', 'customer']);
        return response()->json([
            'id' => $payment->id,
            'customer_name' => $payment->customer_name,
            'contact' => $payment->contact,
            'receipt_date' => $payment->receipt_date->format('Y-m-d'),
            'payment_method' => $payment->payment_method,
            'payment_status' => $payment->payment_status,
            'previous_balance' => $payment->previous_balance,
            'add_amount' => $payment->add_amount,
            'remaining_balance' => $payment->remaining_balance,
            'remarks' => $payment->remarks,
            'booking' => $payment->booking ? [
                'id' => $payment->booking->id,
                'invoice_date' => $payment->booking->invoice_date,
                'invoice_net_amount' => $payment->booking->invoice_net_amount
            ] : null,
            'created_at' => $payment->created_at->format('Y-m-d H:i:s')
        ]);
    }
}
