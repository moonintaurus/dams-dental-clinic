<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    /**
     * Display a listing of dentists with their appointment counts.
     */
    public function index()
    {
        // Fetches dentists and includes count of related appointments for the table view
        $dentists = Dentist::withCount('appointments')->paginate(10);
        return view('admin.dentists.index', compact('dentists'));
    }

    /**
     * Show the form for creating a new dentist.
     */
    public function create()
    {
        return view('admin.dentists.create');
    }

    /**
     * Store a newly created dentist in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'schedule' => 'nullable|array',
        ]);

        
        if ($request->has('schedule') && is_array($request->schedule)) {
            $formattedSchedule = [];
            foreach ($request->schedule as $day) {
                $formattedSchedule[strtolower($day)] = ["09:00-17:00"];
            }
            $validated['schedule'] = $formattedSchedule;
        } else {
            $validated['schedule'] = [];
        }

        Dentist::create($validated);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentist added successfully with selected schedule.');
    }

    /**
     * Display the specified dentist.
     */
    public function show(Dentist $dentist)
    {
        return view('admin.dentists.show', compact('dentist'));
    }

    /**
     * Show the form for editing the specified dentist.
     */
    public function edit(Dentist $dentist)
    {
        return view('admin.dentists.edit', compact('dentist'));
    }

    /**
     * Update the specified dentist in storage.
     */
    public function update(Request $request, Dentist $dentist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'schedule' => 'nullable|array',
        ]);

        // Convert checkbox values into the key-value structure: {"monday": ["09:00-17:00"]}
        if ($request->has('schedule') && is_array($request->schedule)) {
            $formattedSchedule = [];
            foreach ($request->schedule as $day) {
                $formattedSchedule[strtolower($day)] = ["09:00-17:00"];
            }
            $validated['schedule'] = $formattedSchedule;
        } else {
            $validated['schedule'] = [];
        }

        $dentist->update($validated);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentist profile and schedule updated successfully.');
    }

    /**
     * Remove the specified dentist from storage.
     */
    public function destroy(Dentist $dentist)
    {
        $dentist->delete();
        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentist deleted successfully.');
    }
}