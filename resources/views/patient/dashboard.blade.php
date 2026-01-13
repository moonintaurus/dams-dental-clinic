@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Dashboard</h1>
            <a href="{{ route('appointments.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Book New Appointment
            </a>
        </div>

        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-lg p-8 mb-8 text-white">
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-blue-100">Manage your appointments and view your dental history</p>
        </div>

        {{-- Upcoming Appointments Section --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Upcoming Appointments</h2>
            </div>
            <div class="p-6">
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                        <div class="border-l-4 
                            @if($appointment->status === 'confirmed') border-green-500
                            @elseif($appointment->status === 'pending') border-yellow-500
                            @else border-gray-300
                            @endif
                            bg-gray-50 p-4 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="font-bold text-lg text-gray-900">
                                            {{ $appointment->appointment_date->format('F j, Y') }}
                                        </span>
                                        <span class="text-gray-600">
                                            {{ date('g:i A', strtotime($appointment->appointment_time)) }}
                                        </span>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 mb-1">
                                        <span class="font-semibold">Service:</span> {{ $appointment->service->name }}
                                    </p>
                                    <p class="text-gray-700 mb-1">
                                        <span class="font-semibold">Dentist:</span> {{ $appointment->dentist->name }}
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 mb-4">You don't have any upcoming appointments</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- NEW: Recent Medical Records Quick View --}}
        <div class="bg-white rounded-lg shadow mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Recent Treatment History</h2>
                <a href="{{ route('medical-records.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All Records</a>
            </div>
            <div class="p-0">
                @if(isset($medicalRecords) && $medicalRecords->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Treatment</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($medicalRecords->take(3) as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $record->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    {{ $record->diagnosis }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $record->treatment }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">No medical records available yet.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Links Grid --}}
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('appointments.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-lg"><svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                    <div>
                        <h3 class="font-bold text-gray-900">History</h3>
                        <p class="text-sm text-gray-600">View appointment history</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 p-3 rounded-lg"><svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    <div>
                        <h3 class="font-bold text-gray-900">Profile</h3>
                        <p class="text-sm text-gray-600">Update personal information</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('medical-records.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-purple-100 p-3 rounded-lg"><svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    <div>
                        <h3 class="font-bold text-gray-900">Full Records</h3>
                        <p class="text-sm text-gray-600">View detailed history</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection