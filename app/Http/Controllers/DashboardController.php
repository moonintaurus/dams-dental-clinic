<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->isStaff()) {
            return $this->adminDashboard();
        }

        return $this->patientDashboard();
    }

    private function adminDashboard()
    {
        $todayAppointments = Appointment::whereDate('appointment_date', today())
            ->with(['user', 'dentist', 'service'])
            ->get();

        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $totalPatients = User::where('role', 'patient')->count();
        $todayRevenue = Appointment::whereDate('appointment_date', today())
            ->where('status', 'completed')
            ->with('service')
            ->get()
            ->sum(fn($apt) => $apt->service->price);

        return view('admin.dashboard', compact(
            'todayAppointments', 
            'pendingAppointments', 
            'totalPatients', 
            'todayRevenue'
        ));
    }

    private function patientDashboard()
    {
        // Fetch upcoming appointments
        $upcomingAppointments = Appointment::where('user_id', Auth::id())
            ->where('appointment_date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->with(['dentist', 'service'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // NEW: Fetch medical records for the new dashboard section
        $medicalRecords = MedicalRecord::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.dashboard', compact('upcomingAppointments', 'medicalRecords'));
    }
}