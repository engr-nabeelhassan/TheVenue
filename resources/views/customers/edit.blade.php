<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Edit Customer</h2>
                        <a href="{{ route('customers.index') }}" class="text-gray-600 hover:text-gray-800 underline">Back to Customers</a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded bg-red-50 text-red-700">
                            <ul class="list-disc pl-6">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $customer->id }}" disabled>
                        </div>

                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input id="full_name" name="full_name" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('full_name', $customer->full_name) }}" />
                        </div>

                        <div>
                            <label for="cnic" class="block text-sm font-medium text-gray-700">CNIC</label>
                            <input id="cnic" name="cnic" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('cnic', $customer->cnic) }}" />
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Contact</label>
                            <input id="phone" name="phone" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('phone', $customer->phone) }}" />
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $customer->address) }}</textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-500">
                                Update
                            </button>
                            <a href="{{ route('customers.index') }}" class="ml-3 text-gray-600 hover:text-gray-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


