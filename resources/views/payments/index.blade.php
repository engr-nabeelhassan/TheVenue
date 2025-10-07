<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payment List
            </h2>
            <a href="{{ route('payments.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Collect Payment
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">

                <!-- Payment Details Form -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Details Report</h3>
                    <form method="GET" action="{{ route('payments.details') }}" id="reportForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer (Optional)</label>
                                <select name="customer_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Customers</option>
                                    @foreach(\App\Models\Customer::orderBy('full_name')->get() as $customer)
                                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- Shared action row: Search (left) and Generate PDF (right) -->
                    <div class="mt-6 flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                        <form method="GET" action="{{ route('payments.index') }}" class="flex gap-2 w-full md:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name or contact" class="w-full md:w-96 rounded-md border-gray-300 shadow-sm py-2" />
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="{{ route('payments.index') }}" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </form>

                        <button type="submit" form="reportForm" class="self-end md:self-auto bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Generate PDF Report
                        </button>
                    </div>
                </div>

                <!-- Payments Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('payments.index', array_merge(request()->query(), ['sort' => 'receipt_date', 'direction' => request('sort')==='receipt_date' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Receipt Date
                                        @if(request('sort')==='receipt_date')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('payments.index', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => request('sort')==='customer_name' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Customer Name
                                        @if(request('sort')==='customer_name')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('payments.index', array_merge(request()->query(), ['sort' => 'debit', 'direction' => request('sort')==='debit' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Debit
                                        @if(request('sort')==='debit')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('payments.index', array_merge(request()->query(), ['sort' => 'credit', 'direction' => request('sort')==='credit' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Credit
                                        @if(request('sort')==='credit')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('payments.index', array_merge(request()->query(), ['sort' => 'balance', 'direction' => request('sort')==='balance' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                        Balance
                                        @if(request('sort')==='balance')
                                            <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                        @else
                                            <span class="text-gray-300">↕</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($payments as $index => $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ optional($payment->receipt_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->contact }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->payment_method === 'Debit' ? number_format($payment->add_amount, 2) : '0.00' }} PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $payment->payment_method === 'Credit' ? number_format($payment->add_amount, 2) : '0.00' }} PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($payment->remaining_balance, 2) }} PKR
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <button onclick="showPaymentDetails({{ $payment->id }})" class="px-3 py-1 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-500">Details</button>
                                            <a href="{{ route('payments.edit', $payment) }}" class="px-3 py-1 text-sm rounded bg-amber-500 text-white hover:bg-amber-400">Edit</a>
                                            <a href="{{ route('payments.receipt.print', $payment) }}" target="_blank" class="px-3 py-1 text-sm rounded bg-green-600 text-white hover:bg-green-500">Print</a>
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-500">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No payments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr class="font-bold">
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">TOTAL</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($totalDebit, 2) }} PKR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($totalCredit, 2) }} PKR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($totalBalance, 2) }} PKR</td>
                                <td colspan="1"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination & Per-page Controls (match Booking List style) -->
                <div class="px-6 py-4 border-t border-gray-200 mt-4 flex items-center justify-between gap-4">
                    <form method="GET" action="{{ route('payments.index') }}" class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Show</span>
                        <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                            @foreach([10,25,50,100] as $n)
                                <option value="{{ $n }}" {{ (int)request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                        <span class="text-gray-600">entries</span>
                        <input type="hidden" name="search" value="{{ request('search') }}" />
                        <input type="hidden" name="sort" value="{{ request('sort', 'receipt_date') }}" />
                        <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}" />
                    </form>

                    <div class="text-sm text-gray-600">
                        @if ($payments->total() > 0)
                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries
                        @else
                            Showing 0 entries
                        @endif
                    </div>

                    <div>{{ $payments->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Payment Details</h3>
                    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="paymentDetails"></div>
            </div>
        </div>
    </div>

    <script>
        function showPaymentDetails(paymentId) {
            // Show loading state
            document.getElementById('paymentDetails').innerHTML = '<div class="text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div><p class="mt-2">Loading...</p></div>';
            document.getElementById('paymentModal').classList.remove('hidden');
            
            // Fetch payment details via AJAX
            fetch(`/payments/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('paymentDetails').innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                    <p class="text-sm text-gray-900">${data.customer_name}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Contact</label>
                                    <p class="text-sm text-gray-900">${data.contact}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Receipt Date</label>
                                    <p class="text-sm text-gray-900">${data.receipt_date}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <p class="text-sm text-gray-900">${data.payment_method}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                    <p class="text-sm text-gray-900">${data.payment_status}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Add Amount</label>
                                    <p class="text-sm text-gray-900">${data.add_amount} PKR</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Previous Balance</label>
                                    <p class="text-sm text-gray-900">${data.previous_balance} PKR</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Remaining Balance</label>
                                    <p class="text-sm text-gray-900">${data.remaining_balance} PKR</p>
                                </div>
                            </div>
                            ${data.remarks ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Remarks</label>
                                <p class="text-sm text-gray-900">${data.remarks}</p>
                            </div>
                            ` : ''}
                            ${data.booking ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Related Booking</label>
                                <p class="text-sm text-gray-900">Booking #${data.booking.id} - ${data.booking.invoice_date} (${data.booking.invoice_net_amount} PKR)</p>
                            </div>
                            ` : ''}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created At</label>
                                <p class="text-sm text-gray-900">${data.created_at}</p>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    document.getElementById('paymentDetails').innerHTML = '<p class="text-red-600">Error loading payment details.</p>';
                    console.error('Error:', error);
                });
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>
</x-app-layout>