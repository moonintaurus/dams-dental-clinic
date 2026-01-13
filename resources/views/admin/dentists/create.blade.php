@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Add New Dentist</h2>

            <form action="{{ route('admin.dentists.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Full Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Specialization</label>
                        <input type="text" name="specialization" class="w-full border-gray-300 rounded-md" placeholder="e.g., Orthodontist" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Phone Number</label>
                    <input type="text" name="phone" class="w-full border-gray-300 rounded-md" required>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.dentists.index') }}" class="text-gray-600">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Save Dentist</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection