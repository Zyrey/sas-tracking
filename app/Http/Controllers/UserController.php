<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\Request;
use App\Role;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user_email = $user->email;
        return view('user.show', compact('user_email'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function getUserData(Request $request){
        $user_data = User::where('email',$request['email'])
        ->join('clusters','clusters.id','users.cluster_id')
        ->select('users.id','users.first_name','users.last_name','users.middle_name','users.email','users.contact_number','clusters.cluster','users.cluster_id','users.role_id')
        ->get();
        return $user_data;
    }

    public function getRoles(){
        $roles = Role::get();
        return $roles;
    }

    public function saveEditedUser(Request $request){
        $user_data = User::find($request['id']);
        $user_data->first_name = $request['first_name'];
        $user_data->middle_name = $request['middle_name'];
        $user_data->last_name = $request['last_name'];
        $user_data->email = $request['email'];
        $user_data->contact_number = $request['contact_number'];
        $user_data->save();
        return "Success";
    }

    public function update(User $user, UpdateUser $request)
    {
        $user->update($request->all());

        return redirect(route('user.show', $user->email))
            ->with('message', 'Account updated successfully.');
    }

}
