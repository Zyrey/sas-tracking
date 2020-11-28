<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Role;
use App\User;

class AccountController extends Controller
{
    public function adminIndex()
    {
        $users = User::with('role')->where('is_admin', 1)->orderBy('last_name')->get();

        return view('user.admin.index', compact('users'));
    }


    public function coordinatorIndex()
    {
        $users = User::with('cluster')->where('is_admin', 0)->orderBy('last_name')->get();
        return view('user.coordinator.index', compact('users'));
    }


    public function adminCreate(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('user.admin.create', compact('user', 'roles'));
    }


    public function coordinatorCreate(User $user)
    {
        return view('user.coordinator.create', compact('user'));
    }


    public function store(StoreUser $request)
    {
        // Hash password
        $request['password'] = bcrypt($request->input('password'));
        $user = User::create($request->except('password_confirmation'));

        if ($user->is_admin) {
            return redirect(route('admins.index'))->with('message', "New admin account has been created!");
        } else {
            return redirect(route('coordinators.index'))->with('message', "New GPC account has been created!");
        }
    }


    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }


    public function edit(User $user)
    {
        if ($user->is_admin) {
            $roles = Role::orderBy('name')->get();
        }

        return view('user.edit', compact('user', 'roles'));
    }


    public function update(User $user, UpdateUser $request)
    {
        $user->update($request->all());

        return redirect(route('users.show', $user->email))->with('message', "Account updated successfully!");
    }


    public function activate(User $user)
    {
        $user->update([
            'status' => 1,
        ]);

        return back()->with('message', $user->fullname . " has been activated");
    }


    public function deactivate(User $user)
    {
        $user->update([
            'status' => 0
        ]);

        return back()->with('error', $user->fullname . " has been deactivated");
    }
}
