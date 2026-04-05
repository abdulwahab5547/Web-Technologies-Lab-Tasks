<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('employees.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name" class="block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" class="block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4 text-gray-700">
                <label>Position</label>
                <input type="text" name="position" class="block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label>Salary</label>
                <input type="number" name="salary" class="block w-full border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Employee</button>
        </form>
    </div>
</x-app-layout>