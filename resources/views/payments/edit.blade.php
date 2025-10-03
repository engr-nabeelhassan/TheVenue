<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Payment Receipt #{{ $payment->id }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="paymentEditForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <strong>Errors:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('payments.update', $payment) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Receipt Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Receipt Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Receipt Date</label>
                                <input type="date" name="receipt_date" x-model="receiptDate" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer</label>
                                <select name="customer_id" x-model="customerId" @change="fetchCustomerDetails()" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $payment->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="customerName">
                                <label class="block text-sm font-medium text-gray-700">Selected Customer</label>
                                <input type="text" x-model="customerName" 
                                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50" readonly>
                            </div>

                            <div x-show="contact">
                                <label class="block text-sm font-medium text-gray-700">Contact</label>
                                <input type="text" x-model="contact" 
                                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50" readonly>
                            </div>

                            <!-- Hidden fields for form submission -->
                            <input type="hidden" name="customer_name" x-model="customerName">
                            <input type="hidden" name="contact" x-model="contact">
                        </div>

                        <!-- Payment Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Payment Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method" x-model="paymentMethod" @change="calculateRemainingBalance()" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Method</option>
                                    <option value="Debit" {{ $payment->payment_method == 'Debit' ? 'selected' : '' }}>Debit</option>
                                    <option value="Credit" {{ $payment->payment_method == 'Credit' ? 'selected' : '' }}>Credit</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select name="payment_status" x-model="paymentStatus" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Status</option>
                                    <option value="Cash" {{ $payment->payment_status == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Cheque" {{ $payment->payment_status == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="Online Transaction" {{ $payment->payment_status == 'Online Transaction' ? 'selected' : '' }}>Online Transaction</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Previous Balance</label>
                                <input type="number" step="0.01" name="previous_balance" x-model="previousBalance" 
                                       class="mt-1 block w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Add Amount</label>
                                <input type="number" step="0.01" name="add_amount" x-model="addAmount" @input="calculateRemainingBalance()" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Remaining Balance</label>
                                <input type="number" step="0.01" name="remaining_balance" x-model="remainingBalance" 
                                       class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>
                    </div>

                    <!-- Customer Bookings -->
                    <div class="mt-6" x-show="customerBookings.length > 0">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Bookings</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300 text-left">Booking ID</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left">Invoice Date</th>
                                        <th class="px-4 py-2 border border-gray-300 text-right">Amount</th>
                                        <th class="px-4 py-2 border border-gray-300 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="booking in customerBookings" :key="booking.id">
                                        <tr :class="booking.id == selectedBookingId ? 'bg-blue-50' : ''">
                                            <td class="px-4 py-2 border border-gray-300" x-text="booking.id"></td>
                                            <td class="px-4 py-2 border border-gray-300" x-text="booking.invoice_date"></td>
                                            <td class="px-4 py-2 border border-gray-300 text-right" x-text="formatCurrency(booking.invoice_net_amount)"></td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                <button type="button" @click="selectBooking(booking)" 
                                                        :class="booking.id == selectedBookingId ? 'text-green-600' : 'text-indigo-600'"
                                                        class="hover:text-indigo-900">
                                                    <span x-text="booking.id == selectedBookingId ? 'Selected' : 'Select'"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Remarks</label>
                        <textarea name="remarks" x-model="remarks" 
                                  class="mt-1 block w-full rounded-md border-gray-300" rows="3" 
                                  placeholder="Any remarks about this payment..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('payments.index') }}" 
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update Payment
                        </button>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="booking_id" x-model="selectedBookingId">
                </form>
            </div>
        </div>
    </div>

    <script>
        function paymentEditForm() {
            return {
                receiptDate: '{{ $payment->receipt_date->format('Y-m-d') }}',
                customerId: '{{ $payment->customer_id }}',
                customerName: '{{ $payment->customer_name }}',
                contact: '{{ $payment->contact }}',
                paymentMethod: '{{ $payment->payment_method }}',
                paymentStatus: '{{ $payment->payment_status }}',
                previousBalance: {{ $payment->previous_balance }},
                addAmount: {{ $payment->add_amount }},
                remainingBalance: {{ $payment->remaining_balance }},
                remarks: '{{ $payment->remarks }}',
                customerBookings: [],
                selectedBookingId: '{{ $payment->booking_id }}',

                async init() {
                    // Fetch customer details on load
                    if (this.customerId) {
                        await this.fetchCustomerDetails();
                    }
                },

                async fetchCustomerDetails() {
                    if (!this.customerId) {
                        this.customerName = '';
                        this.contact = '';
                        this.previousBalance = 0;
                        this.customerBookings = [];
                        return;
                    }

                    try {
                        // Fetch customer bookings
                        const bookingsResponse = await fetch(`{{ route('api.customer-bookings') }}?customer_id=${this.customerId}`);
                        const bookingsData = await bookingsResponse.json();
                        this.customerBookings = bookingsData;
                    } catch (error) {
                        console.error('Error fetching customer details:', error);
                    }
                },

                calculateRemainingBalance() {
                    const prevBalance = parseFloat(this.previousBalance) || 0;
                    const amount = parseFloat(this.addAmount) || 0;
                    
                    if (this.paymentMethod === 'Debit') {
                        this.remainingBalance = prevBalance + amount;
                    } else if (this.paymentMethod === 'Credit') {
                        this.remainingBalance = prevBalance - amount;
                    } else {
                        this.remainingBalance = prevBalance;
                    }
                },

                selectBooking(booking) {
                    this.selectedBookingId = booking.id;
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('en-PK', { 
                        style: 'currency', 
                        currency: 'PKR' 
                    }).format(Number(amount || 0));
                }
            }
        }
    </script>
</x-app-layout>
