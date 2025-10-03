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
        // Get today's bookings
        $todayBookings = Booking::whereDate('event_start_at', today())->count();
        
        // Get upcoming events (next 7 days)
        $upcomingEvents = Booking::whereBetween('event_start_at', [today(), today()->addDays(7)])->count();
        
        // Get total customers
        $totalCustomers = Customer::count();
        
        // Get available halls (assuming 5 halls total for now)
        $totalHalls = 5;
        $bookedHalls = Booking::whereDate('event_start_at', today())->count();
        $availableHalls = max(0, $totalHalls - $bookedHalls);
        
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
            'availableHalls',
            'recentBookings',
            'year',
            'month'
        ));
    }
}
