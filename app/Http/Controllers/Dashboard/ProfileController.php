<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;


class ProfileController extends Controller
{
    public function edit()
    {
        return view('dashboard.profiles.edit', [
            'profile'=>auth()->user()->profile,
            'countries'=> Countries::getNames(),
            'locales'=>Languages::getNames(),
        ]);
    }

    public function update()
    {
        request()->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'in:male,female|nullable',
            'country' => 'required|string|size:2'
        ]);

        auth()->user()->profile->fill(request()->all())->save();

        return redirect()->back()->with('success','Profile Updated Successfully!');
    }
}
