<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Booking / Inventory Sale
        </h2>
    </x-slot>

    <div class="py-6" x-data="bookingForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('bookings.store') }}" @submit.prevent="onSubmit">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Invoice Date</label>
                            <input type="date" name="invoice_date" x-model="invoiceDate" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700">Customer Search</label>
                            <input 
                                type="text" 
                                x-model="customerSearch" 
                                @input.debounce.300ms="searchCustomers()" 
                                @focus="showCustomerDropdown = true"
                                class="mt-1 block w-full rounded-md border-gray-300" 
                                placeholder="Search by name or enter ID"
                                autocomplete="off">
                            <div x-show="showCustomerDropdown && customerResults.length > 0" 
                                 @click.away="showCustomerDropdown = false"
                                 class="absolute z-10 mt-1 left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                                <template x-for="customer in customerResults" :key="customer.id">
                                    <div @click="selectCustomer(customer)" 
                                         class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                        <div class="font-medium" x-text="customer.full_name"></div>
                                        <div class="text-xs text-gray-500" x-text="'ID: ' + customer.id + ' | ' + customer.phone"></div>
                                    </div>
                                </template>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Latest: {{ optional($latestCustomer)->id }} - {{ optional($latestCustomer)->full_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                            <input type="text" name="customer_name" x-model="customerName" class="mt-1 block w-full rounded-md border-gray-300" required readonly>
                            <p class="text-xs text-gray-500 mt-1" x-show="customerId">ID: <span x-text="customerId"></span></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Type</label>
                            <select name="event_type" x-model="eventType" class="mt-1 block w-full rounded-md border-gray-300" required>
                                <option value="Wedding">Wedding</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Corporate">Corporate</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Guests</label>
                            <input type="number" name="total_guests" x-model.number="totalGuests" min="0" class="mt-1 block w-full rounded-md border-gray-300" placeholder="e.g. 50, 100, 200" required>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Start</label>
                                <input type="datetime-local" x-model="eventStart" step="60" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event End</label>
                                <input type="datetime-local" x-model="eventEnd" step="60" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Status</label>
                            <select name="event_status" x-model="eventStatus" class="mt-1 block w-full rounded-md border-gray-300" required>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Postponed">Postponed</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="font-semibold mb-2">Inventory Items</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 py-2 border text-left">SR</th>
                                        <th class="px-2 py-2 border text-left">ITEM DESCRIPTION</th>
                                        <th class="px-2 py-2 border text-right">QUANTITY</th>
                                        <th class="px-2 py-2 border text-right">RATE</th>
                                        <th class="px-2 py-2 border text-left">DISC% or DISC-LUM</th>
                                        <th class="px-2 py-2 border text-right">NET AMOUNT</th>
                                        <th class="px-2 py-2 border"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, index) in items" :key="row.key">
                                        <tr>
                                            <td class="px-2 py-1 border text-sm" x-text="index + 1"></td>
                                            <td class="px-2 py-1 border">
                                                <input type="text" class="w-full border-gray-300 rounded-md" x-model="row.description" @input="onRowFieldChange()" placeholder="Description">
                                            </td>
                                            <td class="px-2 py-1 border text-right">
                                                <input type="number" step="0.01" class="w-full text-right border-gray-300 rounded-md" x-model.number="row.quantity" @input="recalcRow(row); onRowFieldChange()">
                                            </td>
                                            <td class="px-2 py-1 border text-right">
                                                <input type="number" step="0.01" class="w-full text-right border-gray-300 rounded-md" x-model.number="row.rate" @input="recalcRow(row); onRowFieldChange()">
                                            </td>
                                            <td class="px-2 py-1 border">
                                                <div class="flex gap-1">
                                                    <select class="border-gray-300 rounded-md" x-model="row.discountType" @change="recalcRow(row); onRowFieldChange()">
                                                        <option value="percent">DISC%</option>
                                                        <option value="lump">DISC-LUM</option>
                                                    </select>
                                                    <input type="number" step="0.01" class="w-full text-right border-gray-300 rounded-md" x-model.number="row.discountValue" @input="recalcRow(row); onRowFieldChange()" placeholder="Value">
                                                </div>
                                            </td>
                                            <td class="px-2 py-1 border text-right" x-text="formatCurrency(row.netAmount)"></td>
                                            <td class="px-2 py-1 border text-center">
                                                <button type="button" class="text-red-600" @click="removeRow(index)" x-show="items.length > 1">Remove</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="px-3 py-1 bg-gray-100 border rounded" @click="addRow()">Add Row</button>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Invoice Subtotal</span>
                                <span x-text="formatCurrency(itemsSubtotal)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Discount Total</span>
                                <span x-text="formatCurrency(itemsDiscountTotal)"></span>
                            </div>
                            <div class="flex justify-between font-semibold">
                                <span>INVOICE TOTAL</span>
                                <span x-text="formatCurrency(invoiceNetAmount)"></span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select x-model="paymentStatus" class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Online Transaction">Online Transaction</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="mr-2" x-model="paymentOptionAdvance" @change="onPaymentOptionChange"> Advance
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="mr-2" x-model="paymentOptionFull" @change="onPaymentOptionChange"> Full Payment
                                </label>
                            </div>
                            <div x-show="paymentOptionAdvance">
                                <label class="block text-sm font-medium text-gray-700">Advance Amount</label>
                                <input type="number" step="0.01" x-model.number="advanceAmount" @input="recalcPayments()" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Enter advance amount">
                            </div>
                            <div class="flex justify-between">
                                <span>Closing Amount</span>
                                <span x-text="formatCurrency(invoiceClosingAmount)"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">In words</label>
                                <input type="text" x-model="amountInWords" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Amount in words">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Remarks</label>
                        <textarea x-model="remarks" class="mt-1 block w-full rounded-md border-gray-300" rows="3" placeholder="Any remarks..."></textarea>
                    </div>

                    <input type="hidden" name="customer_id" x-model="customerId">
                    
                    <div class="mt-8 flex justify-end gap-2">
                        <button type="submit" @click="formAction='save'" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Booking</button>
                        <button type="submit" @click="formAction='save_and_print'" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save & Print Invoice</button>
                    </div>

                    <template x-for="hidden in hiddenFields" :key="hidden.name">
                        <input type="hidden" :name="hidden.name" :value="hidden.value">
                    </template>
                </form>
            </div>
        </div>
    </div>

    <script>
        function bookingForm() {
            return {
                invoiceDate: '{{ $today }}',
                customerId: {{ optional($latestCustomer)->id ?? 'null' }},
                customerName: '{{ addslashes(optional($latestCustomer)->full_name) }}',
                customerSearch: '{{ addslashes(optional($latestCustomer)->full_name) }}',
                customerResults: [],
                showCustomerDropdown: false,
                eventType: 'Wedding',
                eventStatus: 'In Progress',
                totalGuests: 0,
                eventStart: '{{ $selectedDate }}T10:00',
                eventEnd: '{{ $selectedDate }}T18:00',
                items: [{ key: 1, description: '', quantity: 0, rate: 0, discountType: 'percent', discountValue: 0, netAmount: 0 }],
                formAction: 'save',
                paymentStatus: 'Cash',
                paymentOptionAdvance: false,
                paymentOptionFull: false,
                advanceAmount: 0,
                amountInWords: '',
                remarks: '',

                get itemsSubtotal() {
                    return this.items.reduce((sum, r) => sum + (Number(r.quantity) * Number(r.rate) || 0), 0);
                },
                get itemsDiscountTotal() {
                    return this.items.reduce((sum, r) => {
                        const line = (Number(r.quantity) * Number(r.rate)) || 0;
                        if (r.discountType === 'percent') {
                            return sum + (line * (Number(r.discountValue) || 0) / 100);
                        }
                        return sum + (Number(r.discountValue) || 0);
                    }, 0);
                },
                get invoiceNetAmount() {
                    return Math.max(0, this.itemsSubtotal - this.itemsDiscountTotal);
                },
                get invoiceTotalPaid() {
                    if (this.paymentOptionFull) return this.invoiceNetAmount;
                    if (this.paymentOptionAdvance) return Math.min(this.advanceAmount || 0, this.invoiceNetAmount);
                    return 0;
                },
                get invoiceClosingAmount() {
                    const amount = Math.max(0, this.invoiceNetAmount - this.invoiceTotalPaid);
                    // Auto-update amount in words
                    this.amountInWords = this.numberToWords(amount);
                    return amount;
                },
                get hiddenFields() {
                    const fields = [
                        { name: 'action', value: this.formAction },
                        { name: 'invoice_date', value: this.invoiceDate },
                        { name: 'customer_name', value: this.customerName },
                        { name: 'event_type', value: this.eventType },
                        { name: 'event_status', value: this.eventStatus },
                        { name: 'total_guests', value: this.totalGuests },
                        { name: 'event_start_at', value: this.eventStart ? this.eventStart.replace('T', ' ') + ':00' : '' },
                        { name: 'event_end_at', value: this.eventEnd ? this.eventEnd.replace('T', ' ') + ':00' : '' },
                        { name: 'payment_status', value: this.paymentStatus },
                        { name: 'payment_option', value: this.paymentOptionFull ? 'full' : (this.paymentOptionAdvance ? 'advance' : '') },
                        { name: 'advance_amount', value: this.paymentOptionAdvance ? (this.advanceAmount || 0) : 0 },
                        { name: 'items_subtotal', value: this.itemsSubtotal.toFixed(2) },
                        { name: 'items_discount_amount', value: this.itemsDiscountTotal.toFixed(2) },
                        { name: 'invoice_net_amount', value: this.invoiceNetAmount.toFixed(2) },
                        { name: 'invoice_total_paid', value: this.invoiceTotalPaid.toFixed(2) },
                        { name: 'invoice_closing_amount', value: this.invoiceClosingAmount.toFixed(2) },
                        { name: 'amount_in_words', value: this.amountInWords },
                        { name: 'remarks', value: this.remarks },
                    ];

                    // Only include non-empty item rows
                    const nonEmptyItems = this.items.filter(r => (r.description && r.description.trim().length) || Number(r.quantity) > 0 || Number(r.rate) > 0 || Number(r.discountValue) > 0);
                    nonEmptyItems.forEach((r, idx) => {
                        fields.push({ name: `items[${idx}][sr_no]`, value: idx + 1 });
                        fields.push({ name: `items[${idx}][item_description]`, value: r.description });
                        fields.push({ name: `items[${idx}][quantity]`, value: r.quantity });
                        fields.push({ name: `items[${idx}][rate]`, value: r.rate });
                        fields.push({ name: `items[${idx}][discount_type]`, value: r.discountType });
                        fields.push({ name: `items[${idx}][discount_value]`, value: r.discountValue });
                        fields.push({ name: `items[${idx}][net_amount]`, value: r.netAmount });
                    });

                    return fields;
                },

                formatCurrency(v) {
                    return new Intl.NumberFormat('en-PK', { style: 'currency', currency: 'PKR' }).format(Number(v || 0));
                },

                numberToWords(num) {
                    if (num === 0) return 'Zero Rupees Only';
                    
                    const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                    const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
                    const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
                    
                    const convertLessThanThousand = (n) => {
                        if (n === 0) return '';
                        if (n < 10) return ones[n];
                        if (n < 20) return teens[n - 10];
                        if (n < 100) {
                            const ten = Math.floor(n / 10);
                            const one = n % 10;
                            return tens[ten] + (one > 0 ? ' ' + ones[one] : '');
                        }
                        const hundred = Math.floor(n / 100);
                        const rest = n % 100;
                        return ones[hundred] + ' Hundred' + (rest > 0 ? ' ' + convertLessThanThousand(rest) : '');
                    };
                    
                    let amount = Math.floor(num);
                    const paisa = Math.round((num - amount) * 100);
                    
                    if (amount === 0 && paisa > 0) {
                        return convertLessThanThousand(paisa) + ' Paisa Only';
                    }
                    
                    let result = '';
                    
                    // Crore (10,000,000)
                    if (amount >= 10000000) {
                        const crore = Math.floor(amount / 10000000);
                        result += convertLessThanThousand(crore) + ' Crore ';
                        amount = amount % 10000000;
                    }
                    
                    // Lakh (100,000)
                    if (amount >= 100000) {
                        const lakh = Math.floor(amount / 100000);
                        result += convertLessThanThousand(lakh) + ' Lakh ';
                        amount = amount % 100000;
                    }
                    
                    // Thousand (1,000)
                    if (amount >= 1000) {
                        const thousand = Math.floor(amount / 1000);
                        result += convertLessThanThousand(thousand) + ' Thousand ';
                        amount = amount % 1000;
                    }
                    
                    // Remaining (0-999)
                    if (amount > 0) {
                        result += convertLessThanThousand(amount) + ' ';
                    }
                    
                    result = result.trim() + ' Rupees';
                    
                    if (paisa > 0) {
                        result += ' and ' + convertLessThanThousand(paisa) + ' Paisa';
                    }
                    
                    return result + ' Only';
                },

                recalcRow(row) {
                    const line = (Number(row.quantity) * Number(row.rate)) || 0;
                    const discount = row.discountType === 'percent'
                        ? line * (Number(row.discountValue) || 0) / 100
                        : (Number(row.discountValue) || 0);
                    row.netAmount = Math.max(0, line - discount);
                    // Trigger amount in words update
                    this.$nextTick(() => { this.invoiceClosingAmount; });
                },

                addRow() {
                    this.items.push({ key: Date.now(), description: '', quantity: 0, rate: 0, discountType: 'percent', discountValue: 0, netAmount: 0 });
                },
                ensureTrailingEmptyRow() {
                    const hasEmptyRow = this.items.some(r => !(r.description?.trim()) && Number(r.quantity) === 0 && Number(r.rate) === 0 && Number(r.discountValue) === 0);
                    if (!hasEmptyRow) {
                        this.addRow();
                    }
                },
                onRowFieldChange() {
                    // If initial 5 rows are filled, keep adding one empty row at the end
                    this.ensureTrailingEmptyRow();
                },
                removeRow(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },

                onPaymentOptionChange() {
                    if (this.paymentOptionFull) {
                        this.paymentOptionAdvance = false;
                        this.advanceAmount = 0;
                    }
                    if (this.paymentOptionAdvance) {
                        this.paymentOptionFull = false;
                    }
                    // Trigger amount in words update
                    this.$nextTick(() => { this.invoiceClosingAmount; });
                },
                recalcPayments() {
                    // Trigger amount in words update
                    this.$nextTick(() => { this.invoiceClosingAmount; });
                },

                async searchCustomers() {
                    const query = this.customerSearch.trim();
                    if (!query || query.length < 2) {
                        this.customerResults = [];
                        return;
                    }
                    
                    try {
                        const res = await fetch(`{{ route('api.customer.search') }}?q=${encodeURIComponent(query)}`, { 
                            headers: { 'Accept': 'application/json' } 
                        });
                        const data = await res.json();
                        this.customerResults = data.customers || [];
                        this.showCustomerDropdown = true;
                    } catch (e) {
                        console.error('Search error:', e);
                        this.customerResults = [];
                    }
                },

                selectCustomer(customer) {
                    this.customerId = customer.id;
                    this.customerName = customer.full_name;
                    this.customerSearch = customer.full_name;
                    this.showCustomerDropdown = false;
                    this.customerResults = [];
                },

                async onSubmit(e) {
                    // Validate customer is selected
                    if (!this.customerId) {
                        alert('Please select a customer first');
                        return;
                    }
                    
                    // Validate at least one item
                    const nonEmptyItems = this.items.filter(r => (r.description && r.description.trim().length) || Number(r.quantity) > 0 || Number(r.rate) > 0);
                    if (nonEmptyItems.length === 0) {
                        alert('Please add at least one item');
                        return;
                    }
                    
                    e.target.submit();
                }
            }
        }
    </script>
</x-app-layout>


