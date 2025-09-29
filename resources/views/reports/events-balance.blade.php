<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events Balance Summary
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back to Reports</a>
                <a href="{{ route('reports.events-balance.pdf', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Download PDF</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Filters -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('reports.events-balance') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">From Date</label>
                            <input type="date" name="from_date" value="{{ $fromDate }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">To Date</label>
                            <input type="date" name="to_date" value="{{ $toDate }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Generate</button>
                        </div>
                    </form>
                </div>

                <!-- Summary -->
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded">
                            <div class="text-sm text-blue-600">Total Revenue</div>
                            <div class="text-2xl font-bold text-blue-900">{{ number_format($totalRevenue, 2) }} PKR</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded">
                            <div class="text-sm text-green-600">Total Paid</div>
                            <div class="text-2xl font-bold text-green-900">{{ number_format($totalPaid, 2) }} PKR</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded">
                            <div class="text-sm text-red-600">Total Outstanding</div>
                            <div class="text-2xl font-bold text-red-900">{{ number_format($totalOutstanding, 2) }} PKR</div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sr#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid (Credit)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outstanding</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $index => $booking)
                                @php
                                    $paid = $booking->payments->where('payment_method', 'Credit')->sum('add_amount');
                                    $outstanding = ($booking->invoice_net_amount ?? 0) - $paid;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($booking->event_start_at)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->customer_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->event_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($booking->invoice_net_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($paid, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($outstanding, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


