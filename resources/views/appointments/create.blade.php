@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Appointments
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Book an Appointment</h1>

            <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                @csrf

                <!-- Service Selection -->
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Service <span class="text-red-500">*</span>
                    </label>
                    <select id="service_id" name="service_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose a service...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} - ₱{{ number_format($service->price, 2) }} ({{ $service->duration }} mins)
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dentist Selection -->
                <div>
                    <label for="dentist_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Dentist <span class="text-red-500">*</span>
                    </label>
                    <select id="dentist_id" name="dentist_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose a dentist...</option>
                        @foreach($dentists as $dentist)
                            <option value="{{ $dentist->id }}" {{ old('dentist_id') == $dentist->id ? 'selected' : '' }}>
                                {{ $dentist->name }} - {{ $dentist->specialization }}
                            </option>
                        @endforeach
                    </select>
                    @error('dentist_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Selection -->
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Appointment Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="appointment_date" name="appointment_date" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ old('appointment_date') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('appointment_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Selection -->
                <div>
                    <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Appointment Time <span class="text-red-500">*</span>
                    </label>
                    <select id="appointment_time" name="appointment_time" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            disabled>
                        <option value="">Select date and dentist first...</option>
                    </select>
                    @error('appointment_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Any special concerns or requirements...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex space-x-4">
                    <button type="submit"
                            class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Book Appointment
                    </button>
                    <a href="{{ route('appointments.index') }}"
                       class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Dynamic time slot availability checking
document.addEventListener('DOMContentLoaded', function() {
    const dentistSelect = document.getElementById('dentist_id');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');

    function updateAvailableSlots() {
        const dentistId = dentistSelect.value;
        const date = dateInput.value;

        if (!dentistId || !date) {
            timeSelect.disabled = true;
            timeSelect.innerHTML = '<option value="">Select date and dentist first...</option>';
            return;
        }

        // Show loading state
        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="">Loading available slots...</option>';

        // Fetch available slots
        fetch(`{{ route('api.available-slots') }}?dentist_id=${dentistId}&date=${date}`)
            .then(response => response.json())
            .then(slots => {
                timeSelect.innerHTML = '';
                
                if (slots.length === 0) {
                    timeSelect.innerHTML = '<option value="">No available slots for this date</option>';
                    return;
                }

                timeSelect.innerHTML = '<option value="">Choose a time...</option>';
                slots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot;
                    option.textContent = formatTime(slot);
                    timeSelect.appendChild(option);
                });
                
                timeSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching slots:', error);
                timeSelect.innerHTML = '<option value="">Error loading slots</option>';
            });
    }

    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const displayHour = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
        return `${displayHour}:${minutes} ${ampm}`;
    }

    dentistSelect.addEventListener('change', updateAvailableSlots);
    dateInput.addEventListener('change', updateAvailableSlots);
});
</script>
@endsection