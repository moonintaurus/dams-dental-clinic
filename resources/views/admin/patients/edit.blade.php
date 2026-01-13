@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h2 class="text-2xl font-bold mb-6">Edit Patient: {{ $patient->name }}</h2>

            <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-bold">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $patient->name) }}" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block font-bold">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-bold">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block font-bold">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-bold">Address</label>
                    <textarea name="address" class="w-full border-gray-300 rounded-md">{{ old('address', $patient->address) }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.patients.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection