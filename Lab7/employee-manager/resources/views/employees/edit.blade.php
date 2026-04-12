<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
            <h2 class="text-xl font-bold">Edit Employee: {{ $employee->name }}</h2>
        </div>
        
        <form action="{{ route('employees.update', $employee) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PATCH') <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $employee->name }}" class="block w-full border-gray-300 rounded shadow-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $employee->email }}" class="block w-full border-gray-300 rounded shadow-sm" required>
            </div>

            <div class="mb-4 text-gray-700">
                <label class="block text-sm font-medium text-gray-700">Position</label>
                <input type="text" name="position" value="{{ $employee->position }}" class="block w-full border-gray-300 rounded shadow-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Salary</label>
                <input type="number" name="salary" value="{{ $employee->salary }}" class="block w-full border-gray-300 rounded shadow-sm" required>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Employee</button>
                <a href="{{ route('employees.index') }}" class="text-gray-600 underline">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>