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
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:patient'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function show(User $patient)
    {
        // Fetches all related data for the 'View' profile page
        $appointments = $patient->appointments()
            ->with(['dentist', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        $medicalRecords = $patient->medicalRecords()->latest()->get();
        
        return view('admin.patients.show', compact('patient', 'appointments', 'medicalRecords'));
    }

    public function edit(User $patient)
    {
        // FIX: Fetching appointments specifically for the edit view to prevent Undefined Variable error
        $appointments = $patient->appointments()
            ->with(['dentist', 'service'])
            ->get();

        return view('admin.patients.edit', compact('patient', 'appointments'));
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

        // This requires 'address', 'phone', and 'date_of_birth' to be in the $fillable array of User.php
        $patient->update($validated);

        // Redirecting to show page to verify changes
        return redirect()->route('admin.patients.show', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(User $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}