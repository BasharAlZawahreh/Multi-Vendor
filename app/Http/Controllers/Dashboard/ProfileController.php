<?php

namespace App\Http\Controllers;

use App\Models\Profile;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('dashboard.profiles.edit', [
            'user' => auth()->user()
        ]);
    }


    public function update()
    {
        request()->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthday' => 'nullable|date|before:today',
            'gender' => 'in:male,female|nullable',
            'country' => 'required|string|size:2'
        ]);

        auth()->user()->profile()->fill(request()->all())->save();

        return redirect()->back()->with('success','Profile Updated Successfully!')


        /*
        $profile =  auth()->user()->profile;
        if ($profile->first_name) {
            $profile->update(request()->all());
        }
        else{
            auth()->user()->profile()->create(request()->all());

            // request()->merge([
            //     'user_id'=>auth()->user()->id()
            // ]);

            // Profile::create(request()->all());
        }
        */
    }
}
