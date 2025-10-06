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

                    <!-- Search Box -->
                    <div class="mt-4">
                        <form method="GET" action="{{ route('reports.events-balance') }}" class="flex gap-2">
                            <input type="hidden" name="from_date" value="{{ $fromDate }}">
                            <input type="hidden" name="to_date" value="{{ $toDate }}">
                            <input type="hidden" name="sort" value="{{ request('sort', 'event_start_at') }}">
                            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by customer name or event type" 
                                   class="w-full md:w-96 rounded-md border-gray-300 shadow-sm py-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="{{ route('reports.events-balance', ['from_date' => $fromDate, 'to_date' => $toDate]) }}" 
                               class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </form>
                    </div>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.events-balance', array_merge(request()->query(), ['sort' => 'event_start_at', 'direction' => request('sort')==='event_start_at' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Event Date
                                        @if(request('sort')==='event_start_at')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.events-balance', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer
                                        @if(request('sort')==='customer_name')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.events-balance', array_merge(request()->query(), ['sort' => 'event_type', 'direction' => request('sort')==='event_type' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Event Type
                                        @if(request('sort')==='event_type')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.events-balance', array_merge(request()->query(), ['sort' => 'invoice_net_amount', 'direction' => request('sort')==='invoice_net_amount' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Invoice Amount
                                        @if(request('sort')==='invoice_net_amount')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $bookings->firstItem() + $index }}</td>
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

                <!-- Pagination & Per-page Controls -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="{{ route('reports.events-balance') }}" class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Show</span>
                        <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                            @foreach([10,25,50,100] as $n)
                                <option value="{{ $n }}" {{ (int)request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                        <span class="text-gray-600">entries</span>
                        <input type="hidden" name="from_date" value="{{ $fromDate }}" />
                        <input type="hidden" name="to_date" value="{{ $toDate }}" />
                        <input type="hidden" name="search" value="{{ request('search') }}" />
                        <input type="hidden" name="sort" value="{{ request('sort', 'event_start_at') }}" />
                        <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}" />
                    </form>

                    <div class="text-sm text-gray-600">
                        @if ($bookings->total() > 0)
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries
                        @else
                            Showing 0 entries
                        @endif
                    </div>

                    <div>{{ $bookings->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


