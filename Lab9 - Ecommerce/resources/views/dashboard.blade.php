<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-500 rounded-2xl shadow-lg p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-green-100 mt-1">Here's an overview of your employee management system.</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('employees.index') }}" class="bg-white rounded-2xl shadow-sm border border-green-100 p-6 hover:shadow-md hover:border-green-300 transition-all duration-200 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 group-hover:bg-green-600 rounded-xl flex items-center justify-center transition-colors duration-200">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Manage</p>
                            <p class="font-semibold text-gray-800">All Employees</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('employees.create') }}" class="bg-white rounded-2xl shadow-sm border border-green-100 p-6 hover:shadow-md hover:border-green-300 transition-all duration-200 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 group-hover:bg-green-600 rounded-xl flex items-center justify-center transition-colors duration-200">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Add</p>
                            <p class="font-semibold text-gray-800">New Employee</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white rounded-2xl shadow-sm border border-green-100 p-6 hover:shadow-md hover:border-green-300 transition-all duration-200 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 group-hover:bg-green-600 rounded-xl flex items-center justify-center transition-colors duration-200">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Edit</p>
                            <p class="font-semibold text-gray-800">My Profile</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
