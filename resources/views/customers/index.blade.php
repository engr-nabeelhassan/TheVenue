<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-semibold">Customers List</h2>
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
                        </div>
                        <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">Add New Customer</a>
                    </div>

                    <form method="GET" action="{{ route('customers.index') }}" class="mb-4">
                        <div class="flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by customer name" class="flex-1 rounded-md border-gray-300 shadow-sm" />
                            <button type="submit" class="px-4 py-2 bg-gray-100 border rounded-md hover:bg-gray-200">Search</button>
                            <a href="{{ route('customers.index') }}" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                        </div>
                    </form>

                    @if (session('status'))
                        <div class="mb-4 p-3 rounded bg-green-50 text-green-700">{{ session('status') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNIC</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($customers as $customer)
                                    <tr>
                                        <td class="px-4 py-2">{{ $customer->id }}</td>
                                        <td class="px-4 py-2">{{ $customer->full_name }}</td>
                                        <td class="px-4 py-2">{{ $customer->cnic }}</td>
                                        <td class="px-4 py-2">{{ $customer->phone }}</td>
                                        <td class="px-4 py-2">{{ $customer->address }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $customer->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('customers.edit', $customer) }}" class="px-3 py-1 text-sm rounded bg-amber-500 text-white hover:bg-amber-400">Edit</a>
                                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Delete this customer?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-500">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $customers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


