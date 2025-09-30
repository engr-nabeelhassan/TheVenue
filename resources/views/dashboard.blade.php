<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div class="flex">
            <!-- Sidebar -->
            <aside class="hidden md:flex md:w-64 lg:w-72 min-h-[calc(100vh-4rem)] bg-white/90 backdrop-blur border-r border-gray-100">
                <div class="w-full p-6 space-y-6">
                    <div>
                        <div class="text-2xl font-extrabold tracking-tight">
                            <span class="text-indigo-600">THE VENUE-</span><span class="text-gray-900">Banquet</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Manage halls, bookings, and events</p>
                    </div>
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-indigo-50 text-indigo-700 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10.707 1.793a1 1 0 0 0-1.414 0l-7.5 7.5A1 1 0 0 0 2 11h1v6a1 1 0 0 0 1 1h4v-4h4v4h4a1 1 0 0 0 1-1v-6h1a1 1 0 0 0 .707-1.707l-7.5-7.5Z"/></svg>
                            <span>Dashboard</span>
                        </a>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm0-11a3 3 0 0 0-3 3v1a3 3 0 1 0 6 0v-1a3 3 0 0 0-3-3Z" clip-rule="evenodd"/></svg>
                                <span>Customers</span>
                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="mt-1 ml-8 bg-white border border-gray-100 rounded-lg shadow-lg py-1 w-48 z-10 absolute left-0">
                                <a href="{{ route('customers.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Add New Customer</a>
                                <a href="{{ route('customers.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Customers List</a>
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M3 7.5A2.25 2.25 0 0 1 5.25 5.25h13.5A2.25 2.25 0 0 1 21 7.5v9.75A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V7.5Zm7.5 1.125a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h6a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-6Z"/></svg>
                                <span>Bookings</span>
                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="mt-1 ml-8 bg-white border border-gray-100 rounded-lg shadow-lg py-1 w-48 z-10 absolute left-0">
                                <a href="{{ route('bookings.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">New Booking</a>
                                <a href="{{ route('bookings.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Booking List</a>
                                <a href="{{ route('bookings.calendar') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Booking Calendar</a>
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                                <span>Payments</span>
                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="mt-1 ml-8 bg-white border border-gray-100 rounded-lg shadow-lg py-1 w-48 z-10 absolute left-0">
                                <a href="{{ route('payments.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Collect Payment</a>
                                <a href="{{ route('payments.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Payment List</a>
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                <span>Reports</span>
                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="mt-1 ml-8 bg-white border border-gray-100 rounded-lg shadow-lg py-1 w-64 z-10 absolute left-0">
                                <a href="{{ route('reports.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">All Reports</a>
                                <a href="{{ route('reports.customers-summary') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Customers Summary</a>
                                <a href="{{ route('reports.events-balance') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Events Balance Summary</a>
                                <a href="{{ route('reports.payment-summary') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Payment Summary</a>
                                <a href="{{ route('reports.venue-events') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Venue Events Summary</a>
                                <a href="{{ route('reports.customer-statements') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 rounded">Customer Statements</a>
                            </div>
                        </div>
                    </nav>

                    <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-100">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold shadow hover:from-indigo-500 hover:to-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M3 3.75A1.75 1.75 0 0 1 4.75 2h6.5A1.75 1.75 0 0 1 13 3.75v2a.75.75 0 0 1-1.5 0v-2a.25.25 0 0 0-.25-.25h-6.5a.25.25 0 0 0-.25.25v12.5c0 .138.112.25.25.25h6.5a.25.25 0 0 0 .25-.25v-2a.75.75 0 0 1 1.5 0v2A1.75 1.75 0 0 1 11.25 18h-6.5A1.75 1.75 0 0 1 3 16.25V3.75Zm12.03 4.47a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.75a.75.75 0 0 0 0 1.5h6.94l-1.72 1.72a.75.75 0 0 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3Z" clip-rule="evenodd"/></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>
            <!-- Main content -->
            <section class="flex-1 p-6 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-gray-900">Welcome, {{ auth()->user()->name }}</h1>
                            <p class="text-gray-500 mt-1">Here is an overview of your banquet operations.</p>
                        </div>
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('bookings.cancelled') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white shadow hover:bg-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelled Booking
                            </a>
                            <a href="{{ route('bookings.postponed') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-yellow-600 text-white shadow hover:bg-yellow-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Postponed Booking
                            </a>
                            <a href="{{ route('bookings.upcoming') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white shadow hover:bg-green-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Upcoming Events
                            </a>
                        </div>
                    </div>

                    <!-- Calendar Section -->
                    <div class="mt-8">
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            <!-- Calendar Header -->
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-semibold text-gray-900">Booking Calendar</h2>
                                    <div class="flex items-center space-x-2">
                                        <button onclick="previousMonth()" class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <span id="current-month" class="text-lg font-medium text-gray-900">{{ now()->format('F Y') }}</span>
                                        <button onclick="nextMonth()" class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Calendar Grid -->
                            <div class="p-6">
                                <div class="grid grid-cols-7 gap-1 mb-4">
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Sun</div>
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Mon</div>
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Tue</div>
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Wed</div>
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Thu</div>
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Fri</div>
                                    <div class="p-2 text-center font-semibold text-gray-600 bg-gray-50 rounded">Sat</div>
                                </div>

                                <div class="grid grid-cols-7 gap-1" id="calendar-grid">
                                    @php
                                        $firstDay = \Carbon\Carbon::create(now()->year, now()->month, 1);
                                        $lastDay = \Carbon\Carbon::create(now()->year, now()->month, 1)->endOfMonth();
                                        $startDate = $firstDay->copy()->startOfWeek();
                                        $endDate = $lastDay->copy()->endOfWeek();
                                        $currentDate = $startDate->copy();
                                    @endphp

                                    @while($currentDate <= $endDate)
                                        @php
                                            $dateString = $currentDate->format('Y-m-d');
                                            $isCurrentMonth = $currentDate->month == now()->month;
                                            $isToday = $currentDate->isToday();
                                            $dayBookings = $recentBookings->get($dateString, collect());
                                            $hasBookings = $dayBookings->count() > 0;
                                        @endphp

                                        <div class="relative min-h-[80px] p-2 border border-gray-200 rounded-lg
                                                    {{ $isToday ? 'ring-2 ring-indigo-500 bg-indigo-50' : '' }}
                                                    {{ $hasBookings ? 'bg-red-50 hover:bg-red-100' : ($isCurrentMonth ? 'bg-white hover:bg-gray-50' : 'bg-gray-50') }}
                                                    cursor-pointer transition-colors duration-200"
                                             data-date="{{ $dateString }}"
                                             data-bookings="{{ $dayBookings->toJson() }}"
                                             onclick="handleDateClick('{{ $dateString }}', {{ $dayBookings->toJson() }})">
                                            
                                            <div class="text-sm font-medium 
                                                        {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }}
                                                        {{ $isToday ? 'text-indigo-600 font-bold' : '' }}">
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
                            <div class="p-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex items-center justify-center space-x-6 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-green-100 border border-green-300 rounded"></div>
                                        <span class="text-gray-600">Available</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-red-100 border border-red-300 rounded"></div>
                                        <span class="text-gray-600">Booked</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-indigo-100 border border-indigo-300 rounded"></div>
                                        <span class="text-gray-600">Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500">Today's Bookings</div>
                                    <div class="mt-2 text-2xl font-bold text-indigo-600">{{ $todayBookings }}</div>
                                </div>
                                <div class="p-3 bg-indigo-100 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500">Upcoming Events</div>
                                    <div class="mt-2 text-2xl font-bold text-green-600">{{ $upcomingEvents }}</div>
                                </div>
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500">Available Halls</div>
                                    <div class="mt-2 text-2xl font-bold text-blue-600">{{ $availableHalls }}</div>
                                </div>
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500">Total Customers</div>
                                    <div class="mt-2 text-2xl font-bold text-purple-600">{{ $totalCustomers }}</div>
                                </div>
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        let currentYear = {{ now()->year }};
        let currentMonth = {{ now()->month }};

        function previousMonth() {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            updateCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            updateCalendar();
        }

        function updateCalendar() {
            // Update the month display
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            document.getElementById('current-month').textContent = 
                monthNames[currentMonth - 1] + ' ' + currentYear;

            // Reload the calendar grid
            fetch(`/bookings-calendar?year=${currentYear}&month=${currentMonth}`)
                .then(response => response.text())
                .then(html => {
                    // Extract just the calendar grid from the response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const calendarGrid = doc.querySelector('#calendar-grid');
                    if (calendarGrid) {
                        document.getElementById('calendar-grid').innerHTML = calendarGrid.innerHTML;
                    }
                })
                .catch(error => {
                    console.error('Error loading calendar:', error);
                });
        }

        // Add click handlers for calendar dates
        document.addEventListener('click', function(e) {
            if (e.target.closest('[data-date]')) {
                const dateElement = e.target.closest('[data-date]');
                const date = dateElement.getAttribute('data-date');
                handleDateClick(date);
            }
        });

        function handleDateClick(date, bookings) {
            if (bookings && bookings.length > 0) {
                let content = '<div class="space-y-4">';
                content += '<h3 class="text-lg font-semibold text-gray-900">Bookings for ' + new Date(date).toLocaleDateString() + '</h3>';
                
                bookings.forEach(booking => {
                    content += `
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
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
                
                // Create and show modal
                showBookingModal(content);
            } else {
                alert('No bookings for ' + new Date(date).toLocaleDateString() + '\n\nThis date is available for booking.');
            }
        }

        function showBookingModal(content) {
            // Create modal if it doesn't exist
            let modal = document.getElementById('bookingModal');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'bookingModal';
                modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50';
                modal.innerHTML = `
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-lg max-w-2xl w-full p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Booking Details</h3>
                                <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div id="bookingDetails"></div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
            }
            
            document.getElementById('bookingDetails').innerHTML = content;
            modal.classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
