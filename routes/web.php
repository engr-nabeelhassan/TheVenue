<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    Route::get('/bookings-calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings-cancelled', [BookingController::class, 'cancelled'])->name('bookings.cancelled');
    Route::get('/bookings-postponed', [BookingController::class, 'postponed'])->name('bookings.postponed');
    Route::get('/bookings-upcoming', [BookingController::class, 'upcoming'])->name('bookings.upcoming');
    Route::get('/bookings-upcoming-pdf', [BookingController::class, 'upcomingPdf'])->name('bookings.upcoming.pdf');
    Route::get('/api/customer', [BookingController::class, 'customerById'])->name('api.customer');
    Route::get('/api/customer/search', [BookingController::class, 'searchCustomers'])->name('api.customer.search');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/details', [PaymentController::class, 'details'])->name('payments.details');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/api/customer-balance', [PaymentController::class, 'getCustomerBalance'])->name('api.customer-balance');
    Route::get('/api/customer-bookings', [PaymentController::class, 'getCustomerBookings'])->name('api.customer-bookings');
    
    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/customers-summary', [ReportsController::class, 'customersSummary'])->name('reports.customers-summary');
    Route::get('/reports/customers-summary-pdf', [ReportsController::class, 'customersSummaryPdf'])->name('reports.customers-summary.pdf');
    Route::get('/reports/events-balance', [ReportsController::class, 'eventsBalance'])->name('reports.events-balance');
    Route::get('/reports/events-balance-pdf', [ReportsController::class, 'eventsBalancePdf'])->name('reports.events-balance.pdf');
    Route::get('/reports/payment-summary', [ReportsController::class, 'paymentSummary'])->name('reports.payment-summary');
    Route::get('/reports/payment-summary-pdf', [ReportsController::class, 'paymentSummaryPdf'])->name('reports.payment-summary.pdf');
    Route::get('/reports/venue-events', [ReportsController::class, 'venueEvents'])->name('reports.venue-events');
    Route::get('/reports/venue-events-pdf', [ReportsController::class, 'venueEventsPdf'])->name('reports.venue-events.pdf');
    Route::get('/reports/customer-statements', [ReportsController::class, 'customerStatements'])->name('reports.customer-statements');
    Route::get('/reports/customer-statements-pdf', [ReportsController::class, 'customerStatementsPdf'])->name('reports.customer-statements.pdf');
    
    // Backup
    Route::post('/backup', [BackupController::class, 'backup'])->name('backup.database');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
