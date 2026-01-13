@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Appointments
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Appointment Details</h1>
                <span class="px-4 py-2 text-sm font-semibold rounded-full
                    @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                    @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Patient</h3>
                    <p class="text-lg text-gray-900">{{ $appointment->user->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Dentist</h3>
                    <p class="text-lg text-gray-900">{{ $appointment->dentist->name }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->dentist->specialization }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Date</h3>
                    <p class="text-lg text-gray-900">{{ $appointment->appointment_date->format('F j, Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Time</h3>
                    <p class="text-lg text-gray-900">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Service</h3>
                    <p class="text-lg text-gray-900">{{ $appointment->service->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Price</h3>
                    <p class="text-lg text-gray-900">₱{{ number_format($appointment->service->price, 2) }}</p>
                </div>
            </div>

            @if($appointment->notes)
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Notes</h3>
                <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $appointment->notes }}</p>
            </div>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">Update Status</h3>
                <form method="POST" action="{{ route('appointments.updateStatus', $appointment) }}" class="flex space-x-4">
                    @csrf
                    <select name="status" class="flex-1 px-4 py-2 border rounded-lg">
                        <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="no-show" {{ $appointment->status === 'no-show' ? 'selected' : '' }}>No-Show</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection