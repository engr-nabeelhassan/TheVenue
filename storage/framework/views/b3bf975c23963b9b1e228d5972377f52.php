<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Booking - Invoice #<?php echo e($booking->id); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6" x-data="bookingForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="<?php echo e(route('bookings.update', $booking)); ?>" @submit.prevent="onSubmit">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Invoice Date</label>
                            <input type="date" name="invoice_date" x-model="invoiceDate" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Customer ID</label>
                            <input type="number" x-model.number="customerId" @change="fetchCustomer()" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Enter Customer ID" required>
                            <p class="text-xs text-gray-500 mt-1">Latest: <?php echo e(optional($latestCustomer)->id); ?> - <?php echo e(optional($latestCustomer)->full_name); ?></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                            <input type="text" name="customer_name" x-model="customerName" class="mt-1 block w-full rounded-md border-gray-300" required>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Status</label>
                            <select name="event_status" x-model="eventStatus" class="mt-1 block w-full rounded-md border-gray-300" required>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Postponed">Postponed</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Start</label>
                                <input type="datetime-local" x-model="eventStart" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event End</label>
                                <input type="datetime-local" x-model="eventEnd" class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
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

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="<?php echo e(route('bookings.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update Booking</button>
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
                invoiceDate: '<?php echo e($booking->invoice_date->format('Y-m-d')); ?>',
                customerId: <?php echo e($booking->customer_id); ?>,
                customerName: '<?php echo e(addslashes($booking->customer_name)); ?>',
                eventType: '<?php echo e($booking->event_type); ?>',
                eventStatus: '<?php echo e($booking->event_status); ?>',
                totalGuests: <?php echo e($booking->total_guests); ?>,
                eventStart: '<?php echo e($booking->event_start_at->format('Y-m-d\TH:i')); ?>',
                eventEnd: '<?php echo e($booking->event_end_at->format('Y-m-d\TH:i')); ?>',
                items: [
                    <?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    {
                        key: <?php echo e($it->id); ?>,
                        description: <?php echo json_encode($it->item_description, 15, 512) ?>,
                        quantity: <?php echo e($it->quantity); ?>,
                        rate: <?php echo e($it->rate); ?>,
                        discountType: <?php echo json_encode($it->discount_type, 15, 512) ?>,
                        discountValue: <?php echo e($it->discount_value); ?>,
                        netAmount: <?php echo e($it->net_amount); ?>

                    }<?php if(!$loop->last): ?>,<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                paymentStatus: '<?php echo e($booking->payment_status); ?>',
                paymentOptionAdvance: <?php echo e($booking->payment_option === 'advance' ? 'true' : 'false'); ?>,
                paymentOptionFull: <?php echo e($booking->payment_option === 'full' ? 'true' : 'false'); ?>,
                advanceAmount: <?php echo e($booking->advance_amount); ?>,
                amountInWords: <?php echo json_encode($booking->amount_in_words ?? '', 15, 512) ?>,
                remarks: <?php echo json_encode($booking->remarks ?? '', 15, 512) ?>,

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
                    return Math.max(0, this.invoiceNetAmount - this.invoiceTotalPaid);
                },
                get hiddenFields() {
                    const fields = [
                        { name: 'invoice_date', value: this.invoiceDate },
                        { name: 'customer_id', value: this.customerId },
                        { name: 'customer_name', value: this.customerName },
                        { name: 'event_type', value: this.eventType },
                        { name: 'event_status', value: this.eventStatus },
                        { name: 'total_guests', value: this.totalGuests },
                        { name: 'event_start_at', value: this.eventStart ? new Date(this.eventStart).toISOString() : '' },
                        { name: 'event_end_at', value: this.eventEnd ? new Date(this.eventEnd).toISOString() : '' },
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

                    this.items.forEach((r, idx) => {
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

                recalcRow(row) {
                    const line = (Number(row.quantity) * Number(row.rate)) || 0;
                    const discount = row.discountType === 'percent'
                        ? line * (Number(row.discountValue) || 0) / 100
                        : (Number(row.discountValue) || 0);
                    row.netAmount = Math.max(0, line - discount);
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
                },
                recalcPayments() {},

                async fetchCustomer() {
                    if (!this.customerId) return;
                    try {
                        const res = await fetch(`<?php echo e(route('api.customer')); ?>?customer_id=${this.customerId}`, { headers: { 'Accept': 'application/json' } });
                        const data = await res.json();
                        if (data.found) {
                            this.customerName = data.customer.full_name;
                        }
                    } catch (e) {}
                },

                async onSubmit(e) {
                    e.target.submit();
                }
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Shahjahan\Desktop\the_venue\resources\views/bookings/edit.blade.php ENDPATH**/ ?>