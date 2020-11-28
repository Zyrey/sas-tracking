<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstitution;
use App\Http\Requests\UpdateInstitution;
use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::orderBy('type')->orderBy('institution')->paginate(10);

        return view('institution.index', compact('institutions'));
    }


    public function create(Institution $institution)
    {
        return view('institution.create', compact('institution'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'institution' => 'required|string|min:2|max:225|unique:institutions,institution|regex:/^[A-Za-z\s.,-]+$/',
            'address' => 'required|string|min:3|max:225',
            'type' => 'required|integer|between:1,2',
        ]);

        $institution = Institution::create($request->all());

        return redirect(route('institutions.show', $institution->id))
            ->with('message', $institution->institution . ' has been created successfully.');
    }


    public function show(Institution $institution)
    {
        $institution->load('faculties');
        return view('institution.show', compact('institution'));
    }


    public function edit(Institution $institution)
    {
        return view('institution.edit', compact('institution'));
    }


    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'institution' => [
                'required', 'string', 'min:2', 'max:225', 'regex:/^[A-Za-z\s.,-]+$/',
                Rule::unique('institutions')->ignore($institution->id),
            ],
            'address' => 'required|string|min:3|max:225',
            'type' => 'required|integer|between:1,2',
        ]);

        $institution->update($request->all());

        return redirect(route('institutions.show', $institution->id))
            ->with('message', 'Institution has been updated successfully.');
    }

}
