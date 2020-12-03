<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        $data['user'] = $user;

        return view('backend.profile.index', $data);
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate(
            [
                'new_password'         =>  'min:8|required_with:new_confirm_password|same:new_confirm_password',
                'new_confirm_password' =>  'min:8',
            ],
            [
                'new_password.min'               =>  'The new password must be at least 8 characters.',
                'new_confirm_password.min'       =>  'The new confirm password must be at least 8 characters.',             
                'new_password.same'              =>  'The new password and new confirm password must match.',
            ]
        );


        $user->update(['password' => $request->new_password]);

        return redirect()->back()->with('success', 'Password Updated Successfully!');
    }
}
