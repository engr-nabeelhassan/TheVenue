<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Collect Payment
        </h2>
    </x-slot>

    <div class="py-6" x-data="paymentForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('payments.store') }}" @submit.prevent="onSubmit">
                    @csrf

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
                                        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="customerName">
                                <label class="block text-sm font-medium text-gray-700">Selected Customer</label>
                                <input type="text" name="customer_name" x-model="customerName" 
                                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contact</label>
                                <input type="text" name="contact" x-model="contact" 
                                       class="mt-1 block w-full rounded-md border-gray-300" readonly>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Payment Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method" x-model="paymentMethod" @change="calculateRemainingBalance()" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Method</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Credit">Credit</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select name="payment_status" x-model="paymentStatus" 
                                        class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Select Status</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Online Transaction">Online Transaction</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Previous Balance</label>
                                <input type="number" step="0.01" name="previous_balance" x-model="previousBalance" 
                                       class="mt-1 block w-full rounded-md border-gray-300" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Add Amount</label>
                                <input type="number" step="0.01" name="add_amount" x-model="addAmount" @input="calculateRemainingBalance()" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Remaining Balance</label>
                                <input type="number" step="0.01" name="remaining_balance" x-model="remainingBalance" 
                                       class="mt-1 block w-full rounded-md border-gray-300" readonly>
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
                                        <tr>
                                            <td class="px-4 py-2 border border-gray-300" x-text="booking.id"></td>
                                            <td class="px-4 py-2 border border-gray-300" x-text="booking.invoice_date"></td>
                                            <td class="px-4 py-2 border border-gray-300 text-right" x-text="formatCurrency(booking.invoice_net_amount)"></td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                <button type="button" @click="selectBooking(booking)" 
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                    Select
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
                        <button type="button" @click="printReceipt()" 
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Print Receipt
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Save Receipt
                        </button>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="booking_id" x-model="selectedBookingId">
                </form>
            </div>
        </div>
    </div>

    <script>
        function paymentForm() {
            return {
                receiptDate: '{{ now()->format('Y-m-d') }}',
                customerId: '',
                customerName: '',
                contact: '',
                paymentMethod: '',
                paymentStatus: '',
                previousBalance: 0,
                addAmount: 0,
                remainingBalance: 0,
                remarks: '',
                customerBookings: [],
                selectedBookingId: '',

                async fetchCustomerDetails() {
                    if (!this.customerId) {
                        this.customerName = '';
                        this.contact = '';
                        this.previousBalance = 0;
                        this.customerBookings = [];
                        return;
                    }

                    try {
                        // Fetch customer balance
                        const balanceResponse = await fetch(`{{ route('api.customer-balance') }}?customer_id=${this.customerId}`);
                        const balanceData = await balanceResponse.json();
                        
                        this.customerName = balanceData.customer_name || '';
                        this.contact = balanceData.contact || '';
                        this.previousBalance = balanceData.balance || 0;

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
                },

                printReceipt() {
                    // This would open a print dialog for the receipt
                    window.print();
                },

                async onSubmit(e) {
                    e.target.submit();
                }
            }
        }
    </script>
</x-app-layout>
