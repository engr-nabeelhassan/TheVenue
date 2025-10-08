<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function customersSummary(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));
        $search = $request->get('search');
        $sort = $request->get('sort', 'full_name');
        $direction = $request->get('direction', 'asc');
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Get all customers with bookings and payments
        $query = Customer::with([
            'bookings' => function($q) use ($fromDate, $toDate) {
                $q->whereBetween('created_at', [$fromDate, $toDate]);
            },
            'payments' => function($q) use ($fromDate, $toDate) {
                $q->whereBetween('created_at', [$fromDate, $toDate]);
            }
        ]);

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('cnic', 'like', "%{$search}%");
            });
        }

        // Get all for totals calculation
        $allCustomers = (clone $query)->get();
        $totalCustomers = $allCustomers->count();
        $activeCustomers = $allCustomers->filter(function($customer) {
            return $customer->bookings->count() > 0;
        })->count();
        
        // Calculate total current balance
        $totalCurrentBalance = $allCustomers->sum(function($customer) {
            $totalClosingAmount = $customer->bookings->sum('invoice_closing_amount');
            $totalPayments = $customer->payments->sum('add_amount');
            return $totalClosingAmount - $totalPayments;
        });

        // Apply sorting
        $sortable = ['full_name', 'phone', 'total_bookings', 'total_amount', 'current_balance', 'status'];
        if (!in_array($sort, $sortable)) {
            $sort = 'full_name';
        }

        if (in_array($sort, ['full_name', 'phone'])) {
            $query->orderBy($sort, $direction);
        }

        $customers = $query->paginate($perPage)->appends($request->query());

        // Sort by calculated fields if needed
        if (in_array($sort, ['total_bookings', 'total_amount', 'current_balance', 'status'])) {
            $customers->setCollection($customers->getCollection()->sortBy(function($customer) use ($sort) {
                if ($sort === 'total_bookings') {
                    return $customer->bookings->count();
                } elseif ($sort === 'total_amount') {
                    return $customer->bookings->sum('invoice_net_amount');
                } elseif ($sort === 'current_balance') {
                    $totalClosingAmount = $customer->bookings->sum('invoice_closing_amount');
                    $totalPayments = $customer->payments->sum('add_amount');
                    return $totalClosingAmount - $totalPayments;
                } elseif ($sort === 'status') {
                    return $customer->bookings->count() > 0 ? 1 : 0;
                }
            }, SORT_REGULAR, $direction === 'desc'));
        }

        return view('reports.customers-summary', compact('customers', 'fromDate', 'toDate', 'totalCustomers', 'activeCustomers', 'totalCurrentBalance'));
    }

    public function customersSummaryPdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $customers = Customer::with([
            'bookings' => function($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            },
            'payments' => function($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }
        ])->get();

        $totalCustomers = $customers->count();
        $activeCustomers = $customers->filter(function($customer) {
            return $customer->bookings->count() > 0;
        })->count();
        
        // Calculate total current balance
        $totalCurrentBalance = $customers->sum(function($customer) {
            $totalClosingAmount = $customer->bookings->sum('invoice_closing_amount');
            $totalPayments = $customer->payments->sum('add_amount');
            return $totalClosingAmount - $totalPayments;
        });

        $pdf = Pdf::loadView('reports.customers-summary-pdf', compact('customers', 'fromDate', 'toDate', 'totalCustomers', 'activeCustomers', 'totalCurrentBalance'));
        return $pdf->download('customers-summary-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function eventsBalance(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));
        $search = $request->get('search');
        $sort = $request->get('sort', 'event_start_at');
        $direction = $request->get('direction', 'desc');
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = Booking::with(['customer', 'payments'])
            ->whereBetween('event_start_at', [$fromDate, $toDate]);

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        // Get all for totals calculation
        $allBookings = (clone $query)->get();
        $totalRevenue = $allBookings->sum('invoice_net_amount');
        $totalPaid = $allBookings->sum('advance_amount');
        $totalClosingAmount = $allBookings->sum('invoice_closing_amount');
        $totalSubtotal = $allBookings->sum('items_subtotal');
        $totalDiscount = $allBookings->sum('items_discount_amount');

        // Apply sorting
        $sortable = ['created_at', 'event_start_at', 'customer_name', 'items_subtotal', 'items_discount_amount', 'invoice_net_amount'];
        if (!in_array($sort, $sortable)) {
            $sort = 'event_start_at';
        }

        $query->orderBy($sort, $direction);

        $bookings = $query->paginate($perPage)->appends($request->query());

        return view('reports.events-balance', compact('bookings', 'fromDate', 'toDate', 'totalRevenue', 'totalPaid', 'totalClosingAmount', 'totalSubtotal', 'totalDiscount'));
    }

    public function eventsBalancePdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::with(['customer', 'payments'])
            ->whereBetween('event_start_at', [$fromDate, $toDate])
            ->get();

        $totalRevenue = $bookings->sum('invoice_net_amount');
        $totalPaid = $bookings->sum('advance_amount');
        $totalClosingAmount = $bookings->sum('invoice_closing_amount');
        $totalSubtotal = $bookings->sum('items_subtotal');
        $totalDiscount = $bookings->sum('items_discount_amount');

        $pdf = Pdf::loadView('reports.events-balance-pdf', compact('bookings', 'fromDate', 'toDate', 'totalRevenue', 'totalPaid', 'totalClosingAmount', 'totalSubtotal', 'totalDiscount'));
        return $pdf->download('events-balance-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function paymentSummary(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));
        $search = $request->get('search');
        $sort = $request->get('sort', 'receipt_date');
        $direction = $request->get('direction', 'desc');
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = Payment::with(['customer', 'booking'])
            ->whereBetween('receipt_date', [$fromDate, $toDate]);

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhere('payment_status', 'like', "%{$search}%");
            });
        }

        // Get all for totals calculation
        $allPayments = (clone $query)->get();
        $totalDebit = $allPayments->where('payment_method', 'Debit')->sum('add_amount');
        $totalCredit = $allPayments->where('payment_method', 'Credit')->sum('add_amount');
        $netBalance = $totalDebit - $totalCredit;

        // Apply sorting
        $sortable = ['receipt_date', 'customer_name', 'payment_method', 'payment_status', 'previous_balance', 'add_amount', 'remaining_balance'];
        if (!in_array($sort, $sortable)) {
            $sort = 'receipt_date';
        }

        $query->orderBy($sort, $direction);

        $payments = $query->paginate($perPage)->appends($request->query());

        return view('reports.payment-summary', compact('payments', 'fromDate', 'toDate', 'totalDebit', 'totalCredit', 'netBalance'));
    }

    public function paymentSummaryPdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $payments = Payment::with(['customer', 'booking'])
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->get();

        $totalDebit = $payments->where('payment_method', 'Debit')->sum('add_amount');
        $totalCredit = $payments->where('payment_method', 'Credit')->sum('add_amount');
        $netBalance = $totalDebit - $totalCredit;

        $pdf = Pdf::loadView('reports.payment-summary-pdf', compact('payments', 'fromDate', 'toDate', 'totalDebit', 'totalCredit', 'netBalance'));
        return $pdf->download('payment-summary-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function venueEvents(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $events = Booking::with(['customer'])
            ->whereBetween('event_start_at', [$fromDate, $toDate])
            ->get()
            ->groupBy('event_type');

        $totalEvents = $events->flatten()->count();
        $totalRevenue = $events->flatten()->sum('invoice_net_amount');

        return view('reports.venue-events', compact('events', 'fromDate', 'toDate', 'totalEvents', 'totalRevenue'));
    }

    public function venueEventsPdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $events = Booking::with(['customer'])
            ->whereBetween('event_start_at', [$fromDate, $toDate])
            ->get()
            ->groupBy('event_type');

        $totalEvents = $events->flatten()->count();
        $totalRevenue = $events->flatten()->sum('invoice_net_amount');

        $pdf = Pdf::loadView('reports.venue-events-pdf', compact('events', 'fromDate', 'toDate', 'totalEvents', 'totalRevenue'));
        return $pdf->download('venue-events-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function customerStatements(Request $request): View
    {
        $customerId = $request->get('customer_id');
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $customers = Customer::all();
        $selectedCustomer = null;
        $bookings = collect();
        $payments = collect();

        if ($customerId) {
            $selectedCustomer = Customer::find($customerId);
            $bookings = Booking::where('customer_id', $customerId)
                ->whereBetween('event_start_at', [$fromDate, $toDate])
                ->get();
            $payments = Payment::where('customer_id', $customerId)
                ->whereBetween('receipt_date', [$fromDate, $toDate])
                ->get();
        }

        return view('reports.customer-statements', compact('customers', 'selectedCustomer', 'bookings', 'payments', 'fromDate', 'toDate', 'customerId'));
    }

    public function customerStatementsPdf(Request $request)
    {
        $customerId = $request->get('customer_id');
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $selectedCustomer = Customer::find($customerId);
        $bookings = Booking::where('customer_id', $customerId)
            ->whereBetween('event_start_at', [$fromDate, $toDate])
            ->get();
        $payments = Payment::where('customer_id', $customerId)
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->get();

        $pdf = Pdf::loadView('reports.customer-statements-pdf', compact('selectedCustomer', 'bookings', 'payments', 'fromDate', 'toDate'));
        return $pdf->download('customer-statement-' . ($selectedCustomer->full_name ?? 'unknown') . '-' . $fromDate . '-to-' . $toDate . '.pdf');
    }
}
