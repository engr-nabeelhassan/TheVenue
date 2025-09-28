<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking List
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('bookings.calendar') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Calendar View
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
                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('bookings.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300" 
                                       placeholder="Search by customer name, invoice date, or event type">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Status</label>
                                <select name="event_status" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Status</option>
                                    <option value="In Progress" {{ request('event_status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ request('event_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ request('event_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="Postponed" {{ request('event_status') == 'Postponed' ? 'selected' : '' }}>Postponed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="invoice_date_from" value="{{ request('invoice_date_from') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="invoice_date_to" value="{{ request('invoice_date_to') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                Filter
                            </button>
                            <a href="{{ route('bookings.index') }}" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Bookings Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Start</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event End</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->invoice_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->event_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->event_start_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->event_end_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($booking->event_status == 'In Progress') bg-yellow-100 text-yellow-800
                                            @elseif($booking->event_status == 'Completed') bg-green-100 text-green-800
                                            @elseif($booking->event_status == 'Cancelled') bg-red-100 text-red-800
                                            @elseif($booking->event_status == 'Postponed') bg-blue-100 text-blue-800
                                            @endif">
                                            {{ $booking->event_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('bookings.show', $booking) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('bookings.edit', $booking) }}" 
                                               class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form method="POST" action="{{ route('bookings.destroy', $booking) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No bookings found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>