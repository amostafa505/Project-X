<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolsController extends Controller
{
    // List schools
    public function index()
    {
        $schools = School::orderBy('name')->paginate(15);
        return view('schools.index', compact('schools'));
    }

    // Show create form
    public function create()
    {
        return view('schools.create');
    }

    // Store
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:255',
            'phone'  => 'nullable|string|max:255',
            'address'=> 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        School::create($data + ['status' => $data['status'] ?? 'active']);

        return redirect()->route('schools.index')->with('success', 'School created.');
    }

    // Edit form
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    // Update
    public function update(Request $request, School $school)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:255',
            'phone'  => 'nullable|string|max:255',
            'address'=> 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $school->update($data);

        return redirect()->route('schools.index')->with('success', 'School updated.');
    }

    // Delete
    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('schools.index')->with('success', 'School deleted.');
    }
}
