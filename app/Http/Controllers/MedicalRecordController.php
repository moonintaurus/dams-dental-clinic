<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{

   

    /**
     * Display a listing of the medical records for the logged-in patient.
     */
    public function index()
    {
        // Load the dentist and service details via the appointment relationship
        $medicalRecords = MedicalRecord::where('user_id', Auth::id())
            ->with(['appointment.dentist', 'appointment.service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('medical-records.index', compact('medicalRecords'));
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
        ]);

        MedicalRecord::create($validated);

        return back()->with('success', 'Medical record has been successfully added to the patient\'s history.');
    }

    /**
     * Update an existing medical record.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);

        return back()->with('success', 'Medical record updated successfully.');
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return back()->with('success', 'Medical record deleted successfully.');
    }
}