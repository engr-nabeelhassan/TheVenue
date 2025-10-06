<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Customer Statements</h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back to Reports</a>
                @if($selectedCustomer)
                    <a href="{{ route('reports.customer-statements.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Download PDF</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Filters -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('reports.customer-statements') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Select Customer</label>
                                <select name="customer_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="{{ $fromDate }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="{{ $toDate }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Generate Statement</button>
                        </div>
                    </form>
                </div>

                @if($selectedCustomer)
                    <!-- Customer Info -->
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Customer Information</h3>
                                <div class="space-y-1 text-sm">
                                    <p><span class="font-medium">Name:</span> {{ $selectedCustomer->full_name }}</p>
                                    <p><span class="font-medium">Phone:</span> {{ $selectedCustomer->phone }}</p>
                                    <p><span class="font-medium">CNIC:</span> {{ $selectedCustomer->cnic ?? 'N/A' }}</p>
                                    <p><span class="font-medium">Address:</span> {{ $selectedCustomer->address ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Statement Period</h3>
                                <div class="space-y-1 text-sm">
                                    <p><span class="font-medium">From:</span> {{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }}</p>
                                    <p><span class="font-medium">To:</span> {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        // Calculate opening balance (all transactions before fromDate)
                        $openingBookings = \App\Models\Booking::where('customer_id', $customerId)
                            ->where('event_start_at', '<', $fromDate)
                            ->sum('invoice_net_amount');
                        
                        $openingPayments = \App\Models\Payment::where('customer_id', $customerId)
                            ->where('receipt_date', '<', $fromDate)
                            ->where('payment_method', 'Credit')
                            ->sum('add_amount');
                        
                        $openingBalance = $openingBookings - $openingPayments;
                        
                        // Calculate totals for current period
                        $totalBookings = $bookings->sum('invoice_net_amount');
                        $totalPayments = $payments->where('payment_method', 'Credit')->sum('add_amount');
                        $totalDebits = $payments->where('payment_method', 'Debit')->sum('add_amount');
                        
                        // Closing balance
                        $closingBalance = $openingBalance + $totalBookings - $totalPayments + $totalDebits;
                        
                        // Combine and sort all transactions
                        $transactions = collect();
                        
                        foreach($bookings as $booking) {
                            $transactions->push([
                                'date' => $booking->event_start_at,
                                'type' => 'Booking',
                                'description' => $booking->event_type . ' Event',
                                'debit' => $booking->invoice_net_amount,
                                'credit' => 0,
                                'reference' => 'Invoice #' . $booking->id
                            ]);
                        }
                        
                        foreach($payments as $payment) {
                            $transactions->push([
                                'date' => $payment->receipt_date,
                                'type' => 'Payment',
                                'description' => $payment->payment_status . ' Payment',
                                'debit' => $payment->payment_method === 'Debit' ? $payment->add_amount : 0,
                                'credit' => $payment->payment_method === 'Credit' ? $payment->add_amount : 0,
                                'reference' => 'Receipt #' . $payment->id
                            ]);
                        }
                        
                        $transactions = $transactions->sortBy('date');
                    @endphp

                    <!-- Summary Cards -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded">
                                <div class="text-sm text-blue-600">Opening Balance</div>
                                <div class="text-2xl font-bold text-blue-900">{{ number_format($openingBalance, 2) }} PKR</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded">
                                <div class="text-sm text-green-600">Total Invoiced</div>
                                <div class="text-2xl font-bold text-green-900">{{ number_format($totalBookings, 2) }} PKR</div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded">
                                <div class="text-sm text-purple-600">Total Paid</div>
                                <div class="text-2xl font-bold text-purple-900">{{ number_format($totalPayments, 2) }} PKR</div>
                            </div>
                            <div class="bg-red-50 p-4 rounded">
                                <div class="text-sm text-red-600">Closing Balance</div>
                                <div class="text-2xl font-bold text-red-900">{{ number_format($closingBalance, 2) }} PKR</div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debit</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Credit</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Opening Balance Row -->
                                <tr class="bg-blue-50 font-semibold">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Opening</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Opening Balance</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">—</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">—</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">—</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($openingBalance, 2) }}</td>
                                </tr>

                                @php $runningBalance = $openingBalance; @endphp
                                @foreach($transactions as $transaction)
                                    @php
                                        $runningBalance += $transaction['debit'] - $transaction['credit'];
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction['type'] === 'Booking' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $transaction['type'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction['description'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction['reference'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ $transaction['debit'] > 0 ? number_format($transaction['debit'], 2) : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ $transaction['credit'] > 0 ? number_format($transaction['credit'], 2) : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                            {{ number_format($runningBalance, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Closing Balance Row -->
                                <tr class="bg-red-50 font-bold">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Closing</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Closing Balance</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">—</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($totalBookings + $totalDebits, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($totalPayments, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($closingBalance, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Customer Selected</h3>
                        <p class="mt-1 text-sm text-gray-500">Please select a customer and date range to generate statement.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
