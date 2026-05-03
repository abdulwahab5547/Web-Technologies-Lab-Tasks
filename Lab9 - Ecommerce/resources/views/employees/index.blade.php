<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-green-800 leading-tight flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                {{ __('Employees') }}
            </h2>
            <a href="{{ route('employees.create') }}"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Employee
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden">

                @if(session('success'))
                    <div class="bg-green-50 border-b border-green-200 px-6 py-3 flex items-center gap-2 text-green-700 text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-green-600 text-white text-left">
                            <th class="px-6 py-4 font-semibold">#</th>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Email</th>
                            <th class="px-6 py-4 font-semibold">Position</th>
                            <th class="px-6 py-4 font-semibold">Salary</th>
                            <th class="px-6 py-4 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($employees as $index => $emp)
                        <tr class="hover:bg-green-50 transition-colors duration-100">
                            <td class="px-6 py-4 text-gray-400 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $emp->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $emp->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $emp->position ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 font-medium">
                                ${{ number_format($emp->salary ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('employees.edit', $emp) }}"
                                       class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 hover:bg-green-100 border border-green-200 px-3 py-1.5 rounded-lg transition duration-150">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Remove {{ $emp->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-1.5 rounded-lg transition duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-sm font-medium">No employees found</p>
                                    <a href="{{ route('employees.create') }}" class="text-green-600 text-sm font-semibold hover:underline">Add your first employee →</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($employees->count() > 0)
                <div class="px-6 py-3 bg-green-50 border-t border-green-100 text-sm text-gray-500">
                    Showing <span class="font-medium text-green-700">{{ $employees->count() }}</span> employee(s)
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
