<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();

        return view('role.index', compact('roles'));
    }


    public function create(Role $role)
    {
        return view('role.create', compact('role'));
    }


    public function store(Request $request)
    {
        $role = Role::create($this->validatedRequests());
        return redirect(route('roles.show', $role->id))->with('message', 'Role Created Successfully');
    }


    public function show(Role $role)
    {
        return view('role.show', compact('role'));
    }


    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }


    public function update(Role $role)
    {
        $role->update($this->validatedRequests());
        return redirect(route('roles.show', $role->id))->with('message', 'Role Updated Successfully');
    }


    private function validatedRequests()
    {
        return
            request()->validate([
                'name' => 'required|string|min:3|max:255',
                'description' => 'nullable|min:3|max:1000',
            ]);
    }
}
