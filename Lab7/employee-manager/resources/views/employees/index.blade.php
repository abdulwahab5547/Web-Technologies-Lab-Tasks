<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-bold">Employee List</h2>
                <a href="{{ route('employees.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Employee</a>
            </div>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                    <tr>
                        <td class="p-2 border">{{ $emp->name }}</td>
                        <td class="p-2 border">{{ $emp->email }}</td>
                        <td class="p-2 border flex gap-2">
                            <a href="{{ route('employees.edit', $emp) }}" class="text-blue-500 hover:text-blue-700">Edit</a>

                            <form action="{{ route('employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>