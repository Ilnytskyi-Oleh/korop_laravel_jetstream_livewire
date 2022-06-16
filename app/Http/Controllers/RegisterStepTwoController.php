<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterStepTwoController extends Controller
{
    public function create()
    {
        return view('auth.register-step2');
    }

    public function store(Request $request)
    {
        auth()->user()->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
        ]);

        if($request->hasFile('photo')) {
            auth()->user()->updateProfilePhoto($request->photo);
        }

        return redirect()->route('dashboard');
    }
}
