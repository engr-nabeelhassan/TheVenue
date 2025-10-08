<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers Summary Report
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to Reports
                </a>
                <a href="{{ route('reports.customers-summary.pdf', request()->query()) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Date Range Filter -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('reports.customers-summary') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="{{ $fromDate }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="{{ $toDate }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Search Box -->
                    <div class="mt-4">
                        <form method="GET" action="{{ route('reports.customers-summary') }}" class="flex gap-2">
                            <input type="hidden" name="from_date" value="{{ $fromDate }}">
                            <input type="hidden" name="to_date" value="{{ $toDate }}">
                            <input type="hidden" name="sort" value="{{ request('sort', 'full_name') }}">
                            <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by customer name, phone, or CNIC" 
                                   class="w-full md:w-96 rounded-md border-gray-300 shadow-sm py-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="{{ route('reports.customers-summary', ['from_date' => $fromDate, 'to_date' => $toDate]) }}" 
                               class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </form>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm text-blue-600">Total Customers</div>
                            <div class="text-2xl font-bold text-blue-900">{{ $totalCustomers }}</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm text-green-600">Active Customers</div>
                            <div class="text-2xl font-bold text-green-900">{{ $activeCustomers }}</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-sm text-purple-600">Inactive Customers</div>
                            <div class="text-2xl font-bold text-purple-900">{{ $totalCustomers - $activeCustomers }}</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="text-sm text-orange-600">Total Current Balance</div>
                            <div class="text-2xl font-bold text-orange-900">
                                {{ number_format($totalCurrentBalance, 2) }} PKR
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customers Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sr#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.customers-summary', array_merge(request()->query(), ['sort' => 'full_name', 'direction' => request('sort')==='full_name' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer Name
                                        @if(request('sort')==='full_name')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.customers-summary', array_merge(request()->query(), ['sort' => 'status', 'direction' => request('sort')==='status' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Status
                                        @if(request('sort')==='status')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.customers-summary', array_merge(request()->query(), ['sort' => 'total_bookings', 'direction' => request('sort')==='total_bookings' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Total Bookings
                                        @if(request('sort')==='total_bookings')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('reports.customers-summary', array_merge(request()->query(), ['sort' => 'current_balance', 'direction' => request('sort')==='current_balance' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Current Balance
                                        @if(request('sort')==='current_balance')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customers as $index => $customer)
                                @php
                                    $totalBookings = $customer->bookings->count();
                                    $totalAmount = $customer->bookings->sum('invoice_net_amount');
                                    $totalAdvanceAmount = $customer->bookings->sum('advance_amount');
                                    $totalDebits = $customer->payments->where('payment_method', 'Debit')->sum('add_amount');
                                    $totalCredits = $customer->payments->where('payment_method', 'Credit')->sum('add_amount');
                                    $currentBalance = $totalAmount + $totalDebits - ($totalAdvanceAmount + $totalCredits);
                                    $isActive = $totalBookings > 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customers->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full {{ $isActive ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                                    <span class="text-sm font-medium {{ $isActive ? 'text-green-600' : 'text-gray-600' }}">
                                                        {{ substr($customer->full_name, 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $customer->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $customer->cnic ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customer->phone ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $isActive ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $totalBookings }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $currentBalance > 0 ? 'bg-red-100 text-red-800' : ($currentBalance < 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ number_format($currentBalance, 2) }} PKR
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900">No customers found</p>
                                            <p class="text-sm text-gray-500">No customers found for the selected date range</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Per-page Controls -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="{{ route('reports.customers-summary') }}" class="flex items-center gap-2 text-sm">
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
                        <input type="hidden" name="sort" value="{{ request('sort', 'full_name') }}" />
                        <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}" />
                    </form>

                    <div class="text-sm text-gray-600">
                        @if ($customers->total() > 0)
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                        @else
                            Showing 0 entries
                        @endif
                    </div>

                    <div>{{ $customers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
