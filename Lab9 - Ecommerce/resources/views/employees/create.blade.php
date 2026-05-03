<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Add New Employee
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden">
                <div class="bg-green-600 px-6 py-4">
                    <h3 class="text-white font-semibold">Employee Information</h3>
                    <p class="text-green-100 text-sm">Fill in the details below to add a new employee.</p>
                </div>

                <form action="{{ route('employees.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="pl-9 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                   placeholder="Jane Smith" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="pl-9 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                   placeholder="jane@company.com" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="text" name="position" value="{{ old('position') }}"
                                   class="pl-9 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                   placeholder="Software Engineer" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Salary (USD)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm font-medium">$</span>
                            </div>
                            <input type="number" name="salary" value="{{ old('salary') }}"
                                   class="pl-7 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                   placeholder="50000" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Employee
                        </button>
                        <a href="{{ route('employees.index') }}"
                           class="text-sm text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
