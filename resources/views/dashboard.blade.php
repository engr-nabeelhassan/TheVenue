<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div class="flex">
            <!-- Sidebar -->
            <aside class="hidden md:flex md:w-64 lg:w-72 min-h-[calc(100vh-4rem)] bg-white/90 backdrop-blur border-r border-gray-100">
                <div class="w-full p-6 space-y-6">
                    <div>
                        <div class="text-2xl font-extrabold tracking-tight">
                            <span class="text-indigo-600">TheVenue-</span><span class="text-gray-900">Banquet</span>
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
                        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M3 7.5A2.25 2.25 0 0 1 5.25 5.25h13.5A2.25 2.25 0 0 1 21 7.5v9.75A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V7.5Zm7.5 1.125a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h6a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-6Z"/></svg>
                            <span>Bookings</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v12m-9-6h12M3 6h.008v.008H3V6Zm0 6h.008v.008H3V12Zm0 6h.008v.008H3V18Z" />
                            </svg>
                            <span>Halls</span>
                        </a>
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
                            <a href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50">Add Booking</a>
                            <a href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white shadow hover:bg-indigo-500">New Event</a>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="text-sm text-gray-500">Today’s Bookings</div>
                            <div class="mt-2 text-2xl font-bold">0</div>
                        </div>
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="text-sm text-gray-500">Upcoming Events</div>
                            <div class="mt-2 text-2xl font-bold">0</div>
                        </div>
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="text-sm text-gray-500">Available Halls</div>
                            <div class="mt-2 text-2xl font-bold">0</div>
                        </div>
                        <div class="p-5 bg-white rounded-xl border border-gray-100 shadow-sm">
                            <div class="text-sm text-gray-500">Total Customers</div>
                            <div class="mt-2 text-2xl font-bold">0</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
