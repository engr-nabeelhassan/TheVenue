<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Calendar
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('bookings.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to List
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
                <!-- Month Navigation -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                        </h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('bookings.calendar', ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1]) }}" 
                               class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                                ← Previous
                            </a>
                            <a href="{{ route('bookings.calendar', ['year' => now()->year, 'month' => now()->month]) }}" 
                               class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200">
                                Today
                            </a>
                            <a href="{{ route('bookings.calendar', ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1]) }}" 
                               class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                                Next →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-7 gap-1 mb-4">
                        <!-- Days of week headers -->
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Sun</div>
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Mon</div>
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Tue</div>
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Wed</div>
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Thu</div>
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Fri</div>
                        <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50">Sat</div>
                    </div>

                    <div class="grid grid-cols-7 gap-1" id="calendar-grid">
                        @php
                            $firstDay = \Carbon\Carbon::create($year, $month, 1);
                            $lastDay = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
                            $startDate = $firstDay->copy()->startOfWeek();
                            $endDate = $lastDay->copy()->endOfWeek();
                            $currentDate = $startDate->copy();
                        @endphp

                        @while($currentDate <= $endDate)
                            @php
                                $dateString = $currentDate->format('Y-m-d');
                                $dayBookings = $bookings->get($dateString, collect());
                                $isCurrentMonth = $currentDate->month == $month;
                                $isToday = $currentDate->isToday();
                                $hasBookings = $dayBookings->count() > 0;
                            @endphp

                            <div class="relative min-h-[100px] p-2 border border-gray-200 
                                        {{ $isCurrentMonth ? 'bg-white' : 'bg-gray-50' }}
                                        {{ $isToday ? 'ring-2 ring-indigo-500' : '' }}
                                        {{ $hasBookings ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-green-50' }}
                                        cursor-pointer transition-colors duration-200"
                                 data-date="{{ $dateString }}"
                                 data-bookings="{{ $dayBookings->toJson() }}"
                                 onclick="handleDateClick('{{ $dateString }}', {{ $dayBookings->toJson() }})">
                                
                                <div class="text-sm font-medium 
                                            {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }}
                                            {{ $isToday ? 'text-indigo-600' : '' }}">
                                    {{ $currentDate->format('j') }}
                                </div>

                                @if($hasBookings)
                                    <div class="mt-1 space-y-1">
                                        @foreach($dayBookings->take(2) as $booking)
                                            <div class="text-xs bg-red-200 text-red-800 px-1 py-0.5 rounded truncate"
                                                 title="{{ $booking->customer_name }} - {{ $booking->event_type }}">
                                                {{ $booking->customer_name }}
                                            </div>
                                        @endforeach
                                        @if($dayBookings->count() > 2)
                                            <div class="text-xs text-red-600">
                                                +{{ $dayBookings->count() - 2 }} more
                                            </div>
                                        @endif
                                    </div>
                                @elseif($isCurrentMonth)
                                    <div class="mt-1 text-xs text-green-600">
                                        Available
                                    </div>
                                @endif
                            </div>

                            @php
                                $currentDate->addDay();
                            @endphp
                        @endwhile
                    </div>
                </div>

                <!-- Legend -->
                <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-red-50 border border-red-200 rounded"></div>
                            <span class="text-sm text-gray-600">Booked Dates</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-green-50 border border-green-200 rounded"></div>
                            <span class="text-sm text-gray-600">Available Dates</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-indigo-50 border-2 border-indigo-500 rounded"></div>
                            <span class="text-sm text-gray-600">Today</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold" id="modalDate"></h3>
                    <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modalContent"></div>
            </div>
        </div>
    </div>

    <script>
        function handleDateClick(dateString, bookings) {
            const modal = document.getElementById('bookingModal');
            const modalDate = document.getElementById('modalDate');
            const modalContent = document.getElementById('modalContent');
            
            modalDate.textContent = new Date(dateString).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            if (bookings.length > 0) {
                let content = '<div class="space-y-4">';
                bookings.forEach(booking => {
                    content += `
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                             onclick="viewBooking(${booking.id})">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">${booking.customer_name}</h4>
                                    <p class="text-sm text-gray-600">${booking.event_type}</p>
                                    <p class="text-xs text-gray-500">
                                        ${new Date(booking.event_start_at).toLocaleTimeString()} - 
                                        ${new Date(booking.event_end_at).toLocaleTimeString()}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        ${booking.event_status === 'In Progress' ? 'bg-yellow-100 text-yellow-800' :
                                          booking.event_status === 'Completed' ? 'bg-green-100 text-green-800' :
                                          booking.event_status === 'Cancelled' ? 'bg-red-100 text-red-800' :
                                          'bg-blue-100 text-blue-800'}">
                                        ${booking.event_status}
                                    </span>
                                    <p class="text-sm text-gray-600 mt-1">PKR ${parseFloat(booking.invoice_net_amount).toLocaleString()}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                content += '</div>';
                modalContent.innerHTML = content;
            } else {
                modalContent.innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-green-600 text-6xl mb-4">✓</div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Date Available</h3>
                        <p class="text-gray-600">This date is available for booking.</p>
                        <a href="{{ route('bookings.create') }}?date=${dateString}" 
                           class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Create Booking
                        </a>
                    </div>
                `;
            }
            
            modal.classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        function viewBooking(bookingId) {
            window.location.href = `/bookings/${bookingId}`;
        }

        // Close modal when clicking outside
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });
    </script>
</x-app-layout>

