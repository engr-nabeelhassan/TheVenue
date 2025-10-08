<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Get today's bookings (bookings created today)
        $todayBookings = Booking::whereDate('created_at', today())->count();
        
        // Get upcoming events (matching the button logic - excluding cancelled and postponed)
        $upcomingEvents = Booking::where('event_start_at', '>=', now())
            ->where('event_status', '!=', 'Cancelled')
            ->where('event_status', '!=', 'Postponed')
            ->count();
        
        // Get total customers
        $totalCustomers = Customer::count();
        
        // Get today's events (all bookings for today)
        $todayEvents = Booking::whereDate('event_start_at', today())
            ->where('event_status', '!=', 'Cancelled')
            ->count();
        
        // Get today's event details for slider
        $todayEventsList = Booking::with('customer')
            ->whereDate('event_start_at', today())
            ->where('event_status', '!=', 'Cancelled')
            ->orderBy('event_start_at', 'asc')
            ->get();
        
        // Get year and month from request or use current
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Get bookings for calendar with selected month/year
        $recentBookings = Booking::with('customer')
            ->whereMonth('event_start_at', $month)
            ->whereYear('event_start_at', $year)
            ->get()
            ->groupBy(function ($booking) {
                return $booking->event_start_at->format('Y-m-d');
            });

        return view('dashboard', compact(
            'todayBookings',
            'upcomingEvents', 
            'totalCustomers',
            'todayEvents',
            'todayEventsList',
            'recentBookings',
            'year',
            'month'
        ));
    }
}
