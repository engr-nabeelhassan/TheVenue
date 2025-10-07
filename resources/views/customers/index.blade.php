<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Customers List
                </h2>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 underline">Back to Dashboard</a>
            </div>
            <a href="{{ route('customers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add New Customer</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">

                    <!-- Customer List Filters -->
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer List Filters</h3>
                        <form method="GET" action="{{ route('customers.index') }}" class="space-y-4">
                            <div class="flex gap-2">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by customer name" class="flex-1 rounded-md border-gray-300 shadow-sm" />
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Search</button>
                                <a href="{{ route('customers.index') }}" class="px-4 py-2 border rounded-md hover:bg-gray-50">Reset</a>
                            </div>
                        </form>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort')==='id' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            ID
                                            @if(request('sort')==='id')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => 'full_name', 'direction' => request('sort')==='full_name' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Full Name
                                            @if(request('sort')==='full_name')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => 'cnic', 'direction' => request('sort')==='cnic' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            CNIC
                                            @if(request('sort')==='cnic')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('sort')==='phone' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Phone
                                            @if(request('sort')==='phone')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => 'address', 'direction' => request('sort')==='address' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Address
                                            @if(request('sort')==='address')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('customers.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort')==='created_at' && request('direction')==='asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                            Created
                                            @if(request('sort')==='created_at')
                                                <span class="text-gray-400">{{ request('direction')==='asc' ? '▲' : '▼' }}</span>
                                            @else
                                                <span class="text-gray-300">↕</span>
                                            @endif
                                        </a>
                                    </th>
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
                                        <td class="px-4 py-2">{{ $customer->address ?: '-' }}</td>
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

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <form method="GET" action="{{ route('customers.index') }}" class="flex items-center gap-2 text-sm">
                            <span class="text-gray-600">Show</span>
                            <select name="per_page" class="rounded-md border-gray-300" onchange="this.form.submit()">
                                @foreach([10,25,50,100] as $n)
                                    <option value="{{ $n }}" {{ (int)request('per_page', 10) === $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <span class="text-gray-600">entries</span>
                            <input type="hidden" name="q" value="{{ request('q') }}" />
                            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}" />
                            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}" />
                        </form>

                        <div class="text-sm text-gray-600">
                            @if ($customers->total() > 0)
                                Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                            @else
                                Showing 0 entries
                            @endif
                        </div>

                        <div>{{ $customers->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


