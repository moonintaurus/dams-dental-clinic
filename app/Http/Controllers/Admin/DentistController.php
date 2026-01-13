<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    public function index()
    {
        $dentists = Dentist::withCount('appointments')->paginate(10);
        return view('admin.dentists.index', compact('dentists'));
    }

    public function create()
    {
        return view('admin.dentists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        Dentist::create($validated);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentist added successfully.');
    }

    public function show(Dentist $dentist)
    {
        //
    }

    public function edit(Dentist $dentist)
    {
        return view('admin.dentists.edit', compact('dentist'));
    }

    public function update(Request $request, Dentist $dentist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $dentist->update($validated);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentist updated successfully.');
    }

    public function destroy(Dentist $dentist)
    {
        $dentist->delete();
        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentist deleted successfully.');
    }
}