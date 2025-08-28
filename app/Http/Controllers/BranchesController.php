<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\School;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::with('school')->orderBy('name');

        if ($request->filled('school_id')) {
            $query->where('school_id', $request->integer('school_id'));
        }

        $branches = $query->paginate(15)->appends($request->query());
        $schools  = School::orderBy('name')->get();

        return view('branches.index', compact('branches', 'schools'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();
        return view('branches.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name'      => 'required|string|max:255',
            'code'      => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'timezone'  => 'nullable|string|max:255',
        ]);

        Branch::create($data);

        return redirect()->route('branches.index')->with('success', 'Branch created.');
    }

    public function edit(Branch $branch)
    {
        $schools = School::orderBy('name')->get();
        return view('branches.edit', compact('branch', 'schools'));
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name'      => 'required|string|max:255',
            'code'      => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:255',
            'address'   => 'nullable|string|max:255',
            'timezone'  => 'nullable|string|max:255',
        ]);

        $branch->update($data);

        return redirect()->route('branches.index')->with('success', 'Branch updated.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted.');
    }
}
