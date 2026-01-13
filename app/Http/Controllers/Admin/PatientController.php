<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')
            ->withCount('appointments')
            ->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $patient)
    {
        $appointments = $patient->appointments()
            ->with(['dentist', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        $medicalRecords = $patient->medicalRecords()->latest()->get();
        
        return view('admin.patients.show', compact('patient', 'appointments', 'medicalRecords'));
    }

    public function edit(User $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, User $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date'
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.show', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(User $patient)
    {
        //
    }
}