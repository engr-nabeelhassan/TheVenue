<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Details - Invoice #{{ $booking->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('bookings.invoice', $booking) }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Download PDF
                </a>
                <a href="{{ route('bookings.edit', $booking) }}" 
                   class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('bookings.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <!-- Invoice Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900">THE VENUE BANQUET</h1>
                        <p class="text-lg text-gray-600">Contact: 0335-999 9357 - 0304-888 1100 | 021-34635544 - 021-34635533</p>
                        <p class="text-lg text-gray-600">Address: Askari 4, Main Rashid Minhas Road Karachi</p>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Invoice Date:</span> {{ $booking->invoice_date->format('d/m/Y') }}</p>
                                <p><span class="font-medium">Invoice #:</span> {{ $booking->id }}</p>
                                <p><span class="font-medium">Event Type:</span> {{ $booking->event_type }}</p>
                                <p><span class="font-medium">Total Guests:</span> {{ $booking->total_guests }}</p>
                                <p><span class="font-medium">Event Status:</span> 
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($booking->event_status == 'In Progress') bg-yellow-100 text-yellow-800
                                        @elseif($booking->event_status == 'Completed') bg-green-100 text-green-800
                                        @elseif($booking->event_status == 'Cancelled') bg-red-100 text-red-800
                                        @elseif($booking->event_status == 'Postponed') bg-blue-100 text-blue-800
                                        @endif">
                                        {{ $booking->event_status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Details</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Event Start:</span> {{ $booking->event_start_at->format('d/m/Y H:i') }}</p>
                                <p><span class="font-medium">Event End:</span> {{ $booking->event_end_at->format('d/m/Y H:i') }}</p>
                                <p><span class="font-medium">Payment Status:</span> {{ $booking->payment_status }}</p>
                                <p><span class="font-medium">Payment Option:</span> {{ ucfirst($booking->payment_option ?? 'N/A') }}</p>
                                @if($booking->advance_amount > 0)
                                    <p><span class="font-medium">Advance Amount:</span> {{ number_format($booking->advance_amount, 2) }} PKR</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p><span class="font-medium">Customer Name:</span> {{ $booking->customer_name }}</p>
                            @if($booking->customer)
                                <p><span class="font-medium">Contact:</span> {{ $booking->customer->phone }}</p>
                                <p><span class="font-medium">Address:</span> {{ $booking->customer->address }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Items</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300 text-left">SR</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left">ITEM DESCRIPTION</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">QUANTITY</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">RATE</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left">DISCOUNT</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">NET AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->items as $item)
                                        <tr>
                                            <td class="px-4 py-2 border border-gray-300">{{ $item->sr_no }}</td>
                                            <td class="px-4 py-2 border border-gray-300">{{ $item->item_description }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-right">{{ number_format($item->quantity, 2) }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-right">{{ number_format($item->rate, 2) }}</td>
                                            <td class="px-4 py-2 border border-gray-300">
                                                {{ $item->discount_type == 'percent' ? $item->discount_value . '%' : number_format($item->discount_value, 2) }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-right">{{ number_format($item->net_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Invoice Totals -->
                    <div class="mt-6">
                        <div class="flex justify-end">
                            <div class="w-64">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Invoice Subtotal:</span>
                                        <span>{{ number_format($booking->items_subtotal, 2) }} PKR</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Discount Total:</span>
                                        <span>{{ number_format($booking->items_discount_amount, 2) }} PKR</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>INVOICE TOTAL:</span>
                                        <span>{{ number_format($booking->invoice_net_amount, 2) }} PKR</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Total Paid:</span>
                                        <span>{{ number_format($booking->invoice_total_paid, 2) }} PKR</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>Closing Amount:</span>
                                        <span>{{ number_format($booking->invoice_closing_amount, 2) }} PKR</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($booking->amount_in_words)
                        <div class="mt-4">
                            <p><span class="font-medium">Amount in Words:</span> {{ $booking->amount_in_words }}</p>
                        </div>
                    @endif

                    @if($booking->remarks)
                        <div class="mt-4">
                            <p><span class="font-medium">Remarks:</span> {{ $booking->remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
