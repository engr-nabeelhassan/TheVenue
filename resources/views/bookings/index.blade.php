<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-semibold">Booking List</h2>
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('bookings.calendar') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-500">Calendar View</a>
                            <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">New Booking</a>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('bookings.index') }}" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name, invoice date, or event type" class="rounded-md border-gray-300 shadow-sm" />
                            <select name="event_status" class="rounded-md border-gray-300 shadow-sm">
                                <option value="">All Status</option>
                                <option value="In Progress" {{ request('event_status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ request('event_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ request('event_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="Postponed" {{ request('event_status') == 'Postponed' ? 'selected' : '' }}>Postponed</option>
                            </select>
                            <input type="date" name="invoice_date_from" value="{{ request('invoice_date_from') }}" placeholder="From Date" class="rounded-md border-gray-300 shadow-sm" />
                            <input type="date" name="invoice_date_to" value="{{ request('invoice_date_to') }}" placeholder="To Date" class="rounded-md border-gray-300 shadow-sm" />
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="{{ route('bookings.index') }}" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </div>
                    </form>

                    @if (session('status'))
                        <div class="mb-4 p-3 rounded bg-green-50 text-green-700">{{ session('status') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('bookings.index', array_merge(request()->query(), ['sort' => 'invoice_date', 'direction' => request('sort')==='invoice_date' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Invoice Date
                                            @if(request('sort')==='invoice_date')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('bookings.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Customer Name
                                            @if(request('sort')==='customer_name')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('bookings.index', array_merge(request()->query(), ['sort' => 'event_type', 'direction' => request('sort')==='event_type' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event Type
                                            @if(request('sort')==='event_type')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('bookings.index', array_merge(request()->query(), ['sort' => 'event_start_at', 'direction' => request('sort')==='event_start_at' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event Start
                                            @if(request('sort')==='event_start_at')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('bookings.index', array_merge(request()->query(), ['sort' => 'event_end_at', 'direction' => request('sort')==='event_end_at' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event End
                                            @if(request('sort')==='event_end_at')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('bookings.index', array_merge(request()->query(), ['sort' => 'event_status', 'direction' => request('sort')==='event_status' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Event Status
                                            @if(request('sort')==='event_status')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-2">{{ $booking->invoice_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                        <td class="px-4 py-2">{{ $booking->event_type }}</td>
                                        <td class="px-4 py-2">{{ $booking->event_start_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2">{{ $booking->event_end_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($booking->event_status == 'In Progress') bg-yellow-100 text-yellow-800
                                                @elseif($booking->event_status == 'Completed') bg-green-100 text-green-800
                                                @elseif($booking->event_status == 'Cancelled') bg-red-100 text-red-800
                                                @elseif($booking->event_status == 'Postponed') bg-blue-100 text-blue-800
                                                @endif">
                                                {{ $booking->event_status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('bookings.show', $booking) }}" class="px-3 py-1 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-500">View</a>
                                                <a href="{{ route('bookings.edit', $booking) }}" class="px-3 py-1 text-sm rounded bg-amber-500 text-white hover:bg-amber-400">Edit</a>
                                                <form method="POST" action="{{ route('bookings.destroy', $booking) }}" onsubmit="return confirm('Delete this booking?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-500">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No bookings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <form method="GET" action="{{ route('bookings.index') }}" class="flex items-center gap-2 text-sm">
                            <span class="text-gray-600">Show</span>
                            <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                                @foreach([10,25,50,100] as $n)
                                    <option value="{{ $n }}" {{ (int)request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <span class="text-gray-600">entries</span>
                            <input type="hidden" name="search" value="{{ request('search') }}" />
                            <input type="hidden" name="event_status" value="{{ request('event_status') }}" />
                            <input type="hidden" name="invoice_date_from" value="{{ request('invoice_date_from') }}" />
                            <input type="hidden" name="invoice_date_to" value="{{ request('invoice_date_to') }}" />
                            <input type="hidden" name="sort" value="{{ request('sort', 'invoice_date') }}" />
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
    </div>
</x-app-layout>