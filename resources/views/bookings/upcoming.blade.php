<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Upcoming Events
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('bookings.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to All Bookings
                </a>
                <a href="{{ route('bookings.upcoming.pdf', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Print PDF
                </a>
                <a href="{{ route('bookings.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    New Booking
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Filters Section -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('bookings.upcoming') }}" class="space-y-4">
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
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    Generate
                                </button>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div class="flex gap-2">
                            <input type="hidden" name="from_date" value="{{ $fromDate }}">
                            <input type="hidden" name="to_date" value="{{ $toDate }}">
                            <input type="hidden" name="sort" value="{{ request('sort', 'event_start_at') }}">
                            <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by customer name, event type, or contact" 
                                   class="w-full md:w-96 rounded-md border-gray-300 shadow-sm py-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="{{ route('bookings.upcoming', ['from_date' => $fromDate, 'to_date' => $toDate]) }}" 
                               class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Bookings Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sr#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('bookings.upcoming', array_merge(request()->query(), ['sort' => 'event_start_at', 'direction' => request('sort')==='event_start_at' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Event Date & Time
                                        @if(request('sort')==='event_start_at')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('bookings.upcoming', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer Name
                                        @if(request('sort')==='customer_name')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Guests</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('bookings.upcoming', array_merge(request()->query(), ['sort' => 'event_type', 'direction' => request('sort')==='event_type' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" 
                                       class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Event Type
                                        @if(request('sort')==='event_type')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $index => $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $bookings->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex flex-col">
                                            <div class="font-medium">{{ $booking->event_start_at ? $booking->event_start_at->format('M d, Y') : 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $booking->event_start_at ? $booking->event_start_at->format('H:i') : 'N/A' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-600">
                                                        {{ substr($booking->customer_name, 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $booking->customer_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->customer->phone ?? $booking->contact ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $booking->total_guests ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ $booking->event_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('bookings.show', $booking) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('bookings.edit', $booking) }}" 
                                               class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <a href="{{ route('bookings.invoice', $booking) }}" 
                                               class="text-green-600 hover:text-green-900">Invoice</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900">No upcoming events found</p>
                                            <p class="text-sm text-gray-500">All your upcoming bookings will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Per-page Controls -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="{{ route('bookings.upcoming') }}" class="flex items-center gap-2 text-sm">
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
                        <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}" />
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
