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

        $customers = Customer::with(['bookings' => function($query) use ($fromDate, $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }])->get();

        $totalCustomers = $customers->count();
        $activeCustomers = $customers->where('bookings', '!=', null)->count();

        return view('reports.customers-summary', compact('customers', 'fromDate', 'toDate', 'totalCustomers', 'activeCustomers'));
    }

    public function customersSummaryPdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $customers = Customer::with(['bookings' => function($query) use ($fromDate, $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }])->get();

        $totalCustomers = $customers->count();
        $activeCustomers = $customers->where('bookings', '!=', null)->count();

        $pdf = Pdf::loadView('reports.customers-summary-pdf', compact('customers', 'fromDate', 'toDate', 'totalCustomers', 'activeCustomers'));
        return $pdf->download('customers-summary-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function eventsBalance(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::with(['customer', 'payments'])
            ->whereBetween('event_start_at', [$fromDate, $toDate])
            ->get();

        $totalRevenue = $bookings->sum('invoice_net_amount');
        $totalPaid = $bookings->sum(function($booking) {
            return $booking->payments->where('payment_method', 'Credit')->sum('add_amount');
        });
        $totalOutstanding = $totalRevenue - $totalPaid;

        return view('reports.events-balance', compact('bookings', 'fromDate', 'toDate', 'totalRevenue', 'totalPaid', 'totalOutstanding'));
    }

    public function eventsBalancePdf(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::with(['customer', 'payments'])
            ->whereBetween('event_start_at', [$fromDate, $toDate])
            ->get();

        $totalRevenue = $bookings->sum('invoice_net_amount');
        $totalPaid = $bookings->sum(function($booking) {
            return $booking->payments->where('payment_method', 'Credit')->sum('add_amount');
        });
        $totalOutstanding = $totalRevenue - $totalPaid;

        $pdf = Pdf::loadView('reports.events-balance-pdf', compact('bookings', 'fromDate', 'toDate', 'totalRevenue', 'totalPaid', 'totalOutstanding'));
        return $pdf->download('events-balance-' . $fromDate . '-to-' . $toDate . '.pdf');
    }

    public function paymentSummary(Request $request): View
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->get('to_date', now()->endOfMonth()->format('Y-m-d'));

        $payments = Payment::with(['customer', 'booking'])
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->get();

        $totalDebit = $payments->where('payment_method', 'Debit')->sum('add_amount');
        $totalCredit = $payments->where('payment_method', 'Credit')->sum('add_amount');
        $netBalance = $totalDebit - $totalCredit;

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
