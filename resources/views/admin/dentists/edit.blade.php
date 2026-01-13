@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Dentist: {{ $dentist->name }}</h2>

            <form action="{{ route('admin.dentists.update', $dentist) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $dentist->name) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Specialization</label>
                        <input type="text" name="specialization" value="{{ old('specialization', $dentist->specialization) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $dentist->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Available Working Days</label>
                     <div class="grid grid-cols-2 md:grid-cols-4 gap-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
        @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            // Extract the keys (days) from your existing JSON-style array
            $activeDays = is_array($dentist->schedule) ? array_keys($dentist->schedule) : [];
        @endphp

        @foreach($days as $day)
            <label class="flex items-center p-2 hover:bg-white rounded transition cursor-pointer">
                <input type="checkbox" 
                       name="schedule[]" 
                       value="{{ strtolower($day) }}" 
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 shadow-sm"
                       {{ in_array(strtolower($day), $activeDays) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-700">{{ $day }}</span>
            </label>
        @endforeach
    </div>
    <p class="text-xs text-gray-500 mt-2 italic">Select all days Dr. {{ explode(' ', $dentist->name)[1] ?? 'Maria' }} is available for appointments.</p>
</div>
                </div>

                <div class="flex items-center justify-end space-x-3 mt-6">
                    <a href="{{ route('admin.dentists.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition">
                        Update Dentist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection