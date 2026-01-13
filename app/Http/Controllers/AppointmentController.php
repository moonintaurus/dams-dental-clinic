<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\Service;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->isPatient()) {
            $appointments = Appointment::where('user_id', Auth::id())
                ->with(['dentist', 'service'])
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
        } else {
            $appointments = Appointment::with(['user', 'dentist', 'service'])
                ->orderBy('appointment_date', 'desc')
                ->paginate(20);
        }

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $dentists = Dentist::all();
        $services = Service::all();
        return view('appointments.create', compact('dentists', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dentist_id' => 'required|exists:dentists,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);

        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'appointment_created',
            'message' => 'Your appointment has been submitted and is pending approval.'
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully! Awaiting confirmation.');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        //
    }

    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,no-show'
        ]);

        $appointment->update($validated);

        Notification::create([
            'user_id' => $appointment->user_id,
            'type' => 'appointment_status',
            'message' => "Your appointment status has been updated to: {$validated['status']}"
        ]);

        return back()->with('success', 'Appointment status updated successfully.');
    }

    public function getAvailableSlots(Request $request)
    {
        $dentistId = $request->dentist_id;
        $date = $request->date;

        $bookedSlots = Appointment::where('dentist_id', $dentistId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->toArray();

        $allSlots = [
            '09:00', '10:00', '11:00', '13:00', 
            '14:00', '15:00', '16:00', '17:00'
        ];

        $availableSlots = array_diff($allSlots, $bookedSlots);

        return response()->json(array_values($availableSlots));
    }
}